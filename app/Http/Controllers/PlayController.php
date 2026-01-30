<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('play.index', compact('user'));
    }
}

