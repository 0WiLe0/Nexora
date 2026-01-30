<?php

namespace App\Http\Controllers;

use App\Models\PartyMember;
use Illuminate\Http\Request;

class PartyRoleController extends Controller
{
    public function update(Request $request, Party $party)
    {
        $request->validate([
            'roles' => 'array|max:2',
            'roles.*' => 'in:carry,mid,offlane,support,hard_support',
        ]);

        $member = PartyMember::where('party_id', $party->id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $member->roles = $request->roles;
        $member->save();

        return response()->json([
            'success' => true,
            'roles' => $member->roles,
        ]);
    }
}
