<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MatchPlayer;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class MatchReadyController extends Controller
{
    public function ready(Request $request)
    {
        $request->validate([
            'match_id' => 'required|integer',
        ]);

        // ВРЕМЕННО: без auth
        $user = User::query()->first();
        if (!$user) {
            return response()->json(['error' => 'No users found'], 500);
        }

        $player = MatchPlayer::where('match_id', $request->match_id)
            ->where('user_id', $user->id)
            ->first();

        if (!$player) {
            return response()->json([
                'error' => 'Player not in this match'
            ], 404);
        }

        // Если уже ready — не меняем состояние
        if (!$player->is_ready) {
            $player->update([
                'is_ready' => true,
                'ready_at' => now(),
            ]);
        }

        /** 🧠 ШАГ 6.3 — проверяем всех игроков */

        $totalPlayers = MatchPlayer::where('match_id', $request->match_id)->count();
        $readyPlayers = MatchPlayer::where('match_id', $request->match_id)
            ->where('is_ready', true)
            ->count();

        // Если ещё не все готовы — просто отвечаем
        if ($readyPlayers < $totalPlayers) {
            return response()->json([
                'status' => 'ready',
                'ready' => $readyPlayers,
                'total' => $totalPlayers,
            ]);
        }

        /** 🚀 ВСЕ ГОТОВЫ — УВЕДОМЛЯЕМ БОТА */

        $players = MatchPlayer::where('match_id', $request->match_id)->get();
        $botUrl = sprintf(
            'http://%s:%s/player-ready',
            env('BOT_HOST'),
            env('BOT_PORT')
        );



        foreach ($players as $p) {
            Http::post($botUrl, [
                'steam_id' => $p->steam_id,
            ]);
        }


        return response()->json([
            'status' => 'all_ready',
            'message' => 'All players ready, bot notified',
        ]);
    }
}
