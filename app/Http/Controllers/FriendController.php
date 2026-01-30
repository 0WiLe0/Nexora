<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\String\b;

class FriendController extends Controller
{
    public function index(Request $request)
    {

        $me = auth()->id();

        $friendships = Friendship::where(function ($query) use ($me) {
            $query->where('requester_id', $me)
                ->orWhere('addressee_id', $me);
        })->get();

        $friendshipsMap = [];

        foreach ($friendships as $friendship) {
            $otherUserId = $friendship->requester_id === $me
                ? $friendship->addressee_id
                : $friendship->requester_id;

            $friendshipsMap[$otherUserId] = $friendship;
        }

        $usersAll = User::where('id', '!=', $me)->get();


        $friends = Friendship::where('status', 'accepted')
            ->where(function ($q) use ($me) {
                $q->where('requester_id', $me)
                    ->orWhere('addressee_id', $me);
            })->get();

        $incomingRequests = Friendship::with('requesterUser')
            ->where('status', 'pending')
            ->where('addressee_id', $me)
            ->get();


        $outgoingRequests = Friendship::where('status', 'pending')
            ->where('requester_id', $me )
            ->get();

        return view('friends.index', compact(
            'friends',
            'incomingRequests',
            'outgoingRequests',
            'usersAll',
            'friendshipsMap',
        ));
    }

    public function store(Request $request, $userID){


        $me = auth()->user()->id;

        if ( $me === $userID ){
           return back();
        }

        $myFriends = Friendship::where(function ($q) use ($me, $userID) {
            $q->where('requester_id', $me)
                ->where('addressee_id', $userID);
        })->orWhere(function ($q) use ($me, $userID) {
            $q->where('requester_id', $userID)
                ->where('addressee_id', $me);
        })->first();

        if ($myFriends !== null){
            return back();
        } else{
            Friendship::create([
                'requester_id' => $me,
                'addressee_id' => $userID,
                'status' => 'pending'
            ]);
        }

        return redirect()->route('friends.index');
    }



    public function accept($friendshipId){

        $friendship = Friendship::findOrFail($friendshipId);
        $me = auth()->user()->id;

        if (
            $friendship->status === 'pending'
            &&
            $friendship->addressee_id === $me
        ){
            $friendship->update([
                'status' => 'accepted'
            ]);

        } else {
            return back();
        }

        return redirect()->route('friends.index');
    }

    public function decline($friendshipId){

        $friendship = Friendship::findOrFail($friendshipId);
        $me = auth()->user()->id;

        if(
            $friendship->status !== 'pending'
            ||
            $friendship->addressee_id !== $me
        ){
            return back();
        } else {
            $friendship->delete();
        }

        return redirect()->route('friends.index');
    }

    public function destroy($friendshipId){

        $friendship = Friendship::findOrFail($friendshipId);
        $me = auth()->user()->id;

        if (
            $friendship->requester_id !== $me
            &&
            $friendship->addressee_id !== $me
        ){
            return back();
        } else {
            $friendship->delete();
        }

        return redirect()->route('friends.index');
    }

    public function api()
    {
        $me = auth()->id();

        $friends = Friendship::where('status', 'accepted')
            ->where(function ($q) use ($me) {
                $q->where('requester_id', $me)
                    ->orWhere('addressee_id', $me);
            })
            ->with(['requesterUser', 'addresseeUser'])
            ->get()
            ->map(function ($friendship) use ($me) {

                $friend = $friendship->requester_id === $me
                    ? $friendship->addresseeUser
                    : $friendship->requesterUser;

                return [
                    'id' => $friend->id,
                    'nickname' => $friend->nickname,
                    'avatar' => $friend->avatar,
                ];
            });

        return response()->json($friends);
    }


}
