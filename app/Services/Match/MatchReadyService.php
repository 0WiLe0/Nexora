<?php

namespace App\Services\Match;

use App\Models\MatchPlayer;

class MatchReadyService
{
    public function __construct(
        private MatchBotNotifier $botNotifier
    ) {}

    public function handleReady(int $matchId, int $userId)
    {
        $player = MatchPlayer::where('match_id', $matchId)
            ->where('user_id', $userId)
            ->first();

        if (!$player) {
            return response()->json([
                'error' => 'Player not in this match'
            ], 404);
        }

        if (!$player->is_ready) {
            $player->update([
                'is_ready' => true,
                'ready_at' => now(),
            ]);
        }

        $total = MatchPlayer::where('match_id', $matchId)->count();
        $ready = MatchPlayer::where('match_id', $matchId)
            ->where('is_ready', true)
            ->count();

        if ($ready < $total) {
            return response()->json([
                'status' => 'ready',
                'ready' => $ready,
                'total' => $total,
            ]);
        }


        $ready_expires_at = now()->addSeconds(30);

        if(now() > $ready_expires_at) {
            return response()->json([
               'status' => 'expired',
            ]);
        }


        // ВСЕ ГОТОВЫ
        $this->botNotifier->notifyMatchReady($matchId);

        return response()->json([
            'status' => 'all_ready',
        ]);
    }
}

