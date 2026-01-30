<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\Party;
use App\Models\PartyMember;
use Illuminate\Http\Request;

class PartyController extends Controller
{

    public const MAX_MEMBERS = 5;

    public function create()
    {
        $user = auth()->user();

        $partyCheck = PartyMember::where('user_id', $user->id)
            ->whereIn('status', ['invited', 'accepted'])
            ->first();

        if ($partyCheck !== null) {
            return response()->json(['error' => 'User already in party']);
        }

        $party = Party::create([
            'leader_id' => $user->id,
            'status' => 'open',
        ]);

        PartyMember::create([
            'party_id' => $party->id,
            'user_id' => $user->id,
            'role' => 'leader',
            'status' => 'accepted',
            'invite_seen' => true,
        ]);


        return response()->json(['party_id' => $party->id]);
    }

    public function invite($partyId, $friendId)
    {
        $user = auth()->user()->id;

        $partyFind = Party::where('id', $partyId)
            ->first();

        if ($partyFind == null) {
            return response()->json(['error' => 'Party not found']);
        }

        if ($partyFind->leader_id !== $user) {
            return response()->json(['error' => 'Only leader can invite']);
        }

        if ($partyFind->status !== 'open') {
            return response()->json(['error' => 'Only leader can invite']);
        }

        if (!Friendship::areFriends($user, $friendId)) {
            return response()->json(['error' => 'User is not your friend']);
        }

        $partyUserCount = PartyMember::where('party_id', $partyId)
            ->whereIn('status', ['invited', 'accepted'])
            ->count();

        if ($partyUserCount >= self::MAX_MEMBERS){
            return response()->json(['error' => 'Party is full']);
        }

        $partyCheck = PartyMember::where('party_id', $partyId)
            ->where('user_id', $friendId)
            ->whereIn('status', ['invited', 'accepted'])
            ->first();

        if ($partyCheck !== null) {
            return response()->json(['error' => 'User already in party']);
        }

        PartyMember::create([
            'party_id' => $partyId,
            'user_id' => $friendId,
            'role' => 'member',
            'status' => 'invited',
            'invite_seen' => false,
        ]);

        return response()->json(['status' => 'invited']);
    }

    public function invites()
    {
        $userId = auth()->id();

        $invites = PartyMember::with(['party', 'party.members.user'])
            ->where('user_id', $userId)
            ->where('status', 'invited')
            ->where('invite_seen', false)
            ->get();

        return response()->json(
            $invites->map(function ($invite) use ($userId) {
                $party = $invite->party;

                return [
                    'party_id'  => $party->id,
                    'leader_id' => $party->leader_id,
                    'status'    => $party->status,
                    'max'       => PartyController::MAX_MEMBERS,
                    'members'   => $party->members
                        ->whereIn('status', ['invited', 'accepted'])
                        ->map(function ($m) use ($userId) {
                            return [
                                'id'        => $m->user_id,
                                'nickname'  => $m->user->nickname,
                                'avatar'    => $m->user->avatar,
                                'status'    => $m->status,
                                'is_me'     => $m->user_id === $userId,
                                'is_friend' => $m->user_id === $userId
                                    || Friendship::areFriends($userId, $m->user_id),
                            ];
                        })->values(),
                ];
            })->values()
        );
    }



    public function accept($partyId)
    {
        $user = auth()->user()->id;

        $partyFind = Party::where('id', $partyId)
            ->first();

        if ($partyFind == null) {
            return response()->json(['error' => 'Party not found']);
        }

        $invite = PartyMember::where('party_id', $partyId)
            ->where('user_id', $user)
            ->where('status','invited')
            ->first();

        if ($invite == null) {
            return response()->json(['error' => 'No invite']);
        }


        $partyCheck = PartyMember::where('user_id', $user)
            ->where('party_id' ,'!=', $partyId)
            ->whereIn('status', ['invited', 'accepted'])
            ->first();

        if ($partyCheck !== null) {
            return response()->json(['error' => 'User already in party']);
        }

        $count = PartyMember::where('party_id', $partyId)
            ->where('status','accepted')
            ->count();

        if ($count >= self::MAX_MEMBERS) {
            return response()->json(['error' => 'Party is full']);
        }

        $invite->update([
            'status' => 'accepted',
            'invite_seen' => true,
        ]);

        return response()->json(['status' => 'accepted']);
    }

    public function leave($partyId)
    {
        $userId = auth()->id();

        $party = Party::find($partyId);
        if (!$party) {
            return response()->json(['error' => 'Party not found']);
        }

        $membership = PartyMember::where('party_id', $partyId)
            ->where('user_id', $userId)
            ->whereIn('status', ['invited', 'accepted'])
            ->first();

        if (!$membership) {
            return response()->json(['error' => 'Not in party']);
        }


        if ($party->leader_id === $userId) {
            $party->update(['status' => 'closed']);

            PartyMember::where('party_id', $partyId)
                ->whereIn('status', ['invited', 'accepted'])
                ->update(['status' => 'left']);

            return response()->json(['status' => 'closed']);
        }


        $membership->update(['status' => 'left']);

        // считаем, сколько accepted осталось
        $acceptedCount = PartyMember::where('party_id', $partyId)
            ->where('status', 'accepted')
            ->count();

        // если остался только лидер или никого
        if ($acceptedCount < 2) {
            $party->update(['status' => 'closed']);

            PartyMember::where('party_id', $partyId)
                ->where('status', 'accepted')
                ->update(['status' => 'left']);

            return response()->json(['status' => 'closed']);
        }

        return response()->json(['status' => 'left']);
    }



    public function show($partyId)
    {
        $user = auth()->id();

        $partyFind = Party::where('id', $partyId)
            ->first();

        if ($partyFind == null) {
            return response()->json(['error' => 'Party not found']);
        }

        $members = PartyMember::with('user')
            ->where('party_id', $partyId)
            ->whereIn('status', ['invited', 'accepted'])
            ->get();

        $resultMembers = [];

        foreach ($members as $member) {
            $isMe = $member->user_id === $user;

            $resultMembers[] = [
                'id' => $member->user_id,
                'nickname' => $member->user->nickname,
                'avatar' => $member->user->avatar,
                'role' => $member->role,
                'roles' => $member->roles ?? [],
                'status' => $member->status,
                'is_friend' => Friendship::areFriends($user, $member->user_id),
                'is_me' => $isMe,
            ];


        }

        return response()->json([
            'party_id' => $partyId,
            'leader_id' => $partyFind->leader_id,
            'status' => $partyFind->status,
            'members' => $resultMembers,
            'max' => self::MAX_MEMBERS,
        ]);
    }

    public function my()
    {
        $userId = auth()->id();

        $member = PartyMember::where('user_id', $userId)
            ->whereIn('status', ['invited', 'accepted'])
            ->first();


        if (!$member) {
            return response()->json([
                'party' => null
            ]);
        }

        $party = Party::find($member->party_id);

        if (!$party) {
            return response()->json([
                'party' => null
            ]);
        }

        $members = PartyMember::with('user')
            ->where('party_id', $party->id)
            ->whereIn('status', ['invited', 'accepted'])
            ->get();

        $resultMembers = [];

        foreach ($members as $m) {
            $isMe = $m->user_id === $userId;
            $isFriend = $isMe || Friendship::areFriends($userId, $m->user_id);

            $resultMembers[] = [
                'id'        => $m->user_id,
                'nickname'  => $m->user->nickname,
                'avatar'    => $m->user->avatar,
                'role'      => $m->role,
                'roles' => $m->roles ?? [],
                'status'    => $m->status,
                'is_me'     => $isMe,
                'is_friend' => $isFriend,
            ];
        }

        return response()->json([
            'party_id'    => $party->id,
            'status'      => $party->status,
            'leader_id'   => $party->leader_id,
            'my_status'   => $member->status,
            'invite_seen' => $member->invite_seen,
            'members'     => $resultMembers,
            'max'         => PartyController::MAX_MEMBERS,
        ]);

    }

    public function markInviteSeen($partyId)
    {
        $userId = auth()->id();

        $member = PartyMember::where('party_id', $partyId)
            ->where('user_id', $userId)
            ->where('status', 'invited')
            ->first();

        if (!$member) {
            return response()->json(['error' => 'No invite'], 404);
        }

        $member->update(['invite_seen' => true]);

        return response()->json(['status' => 'ok']);
    }

    public function updateRoles(Request $request, $partyId)
    {
        $userId = auth()->id();

        $request->validate([
            'roles' => 'array|max:2',
            'roles.*' => 'in:carry,mid,offlane,support,hard_support',
        ]);

        $party = Party::find($partyId);
        if (!$party) {
            return response()->json(['error' => 'Party not found'], 404);
        }

        $member = PartyMember::where('party_id', $partyId)
            ->where('user_id', $userId)
            ->whereIn('status', ['invited', 'accepted'])
            ->first();

        if (!$member) {
            return response()->json(['error' => 'Not in party'], 403);
        }

        $member->update([
            'roles' => $request->roles,
        ]);

        return response()->json([
            'status' => 'ok',
            'roles' => $member->roles,
        ]);
    }


}

