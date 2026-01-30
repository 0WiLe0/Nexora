<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use App\Models\MatchPlayer;
use Illuminate\Http\Request;

class LobbyController extends Controller
{
    public function index()
    {
        return view('lobby.index');
    }

}
