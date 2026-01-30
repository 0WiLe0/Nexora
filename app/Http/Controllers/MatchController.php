<?php

namespace App\Http\Controllers;

use App\Models\GameMatch;
use App\Models\MatchPlayer;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function store()
    {
        $user = auth()->user();

        $hasActiveMatch = MatchPlayer::query()
            ->where('user_id', $user->id)
            ->whereHas('gameMatch', function ($q) {
                $q->whereIn('status', ['waiting', 'ready', 'started']);
            })
            ->exists();


        if ($hasActiveMatch) {
            return response()->json([
                'error' => 'User already in active match',
            ], 409);
        }

        $match = GameMatch::where('status', 'waiting')
            ->where('max_players', 2)
            ->first();

        if (!$match) {
            $match = GameMatch::create([
                'status' => 'waiting',
                'max_players' => 2,
            ]);
        }

        return response()->json([
            'id' => $match->id,
            'status' => $match->status,
        ]);
    }


    public function join(int $match)
    {
        $match = GameMatch::findOrFail($match);

        $user = auth()->user();

        $hasActiveMatch = MatchPlayer::query()
            ->where('user_id', $user->id)
            ->whereHas('gameMatch', function ($q) {
                $q->whereIn('status', ['waiting', 'ready', 'started']);
            })
            ->exists();


        if ($hasActiveMatch) {
            return response()->json([
                'error' => 'User already in active match',
            ], 409);
        }

        if ($match->status !== 'waiting') {
            return response()->json([
                'error' => 'Match is not accepting players',
            ], 400);
        }

        $alreadyJoined = MatchPlayer::where('game_match_id', $match->id)
            ->where('user_id', $user->id)
            ->exists();

        if ($alreadyJoined) {
            return response()->json([
                'error' => 'User already joined this match',
            ], 409);
        }

        $playersCount = MatchPlayer::where('game_match_id', $match->id)->count();

        if ($playersCount >= $match->max_players) {
            return response()->json([
                'error' => 'Match is full',
            ], 400);
        }

        MatchPlayer::create([
            'game_match_id' => $match->id,
            'user_id' => $user->id,
            'is_ready' => false,
        ]);

        $playersCount++;

        if ($playersCount === $match->max_players) {
            $match->update([
                'status' => 'ready',
                'ready_expires_at' => now()->addSeconds(30),
            ]);
        }

        return response()->json([
            'status' => 'joined',
            'players_count' => $playersCount,
            'max_players' => $match->max_players,
            'match_status' => $match->status,
        ]);
    }


    public function ready(int $match)
    {
        $match = GameMatch::findOrFail($match);

        if ($match->status !== 'ready') {
            return response()->json(['error' => 'Match is not ready']);
        }

        if ($match->ready_expires_at < now()) {
            $match->update(['status' => 'expired']);

            return response()->json(['error' => 'Match is expired']);
        }

        $user = auth()->user();

        $currentMatchPlayer = MatchPlayer::where('game_match_id', $match->id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($currentMatchPlayer->is_ready) {
            return response()->json(['error' => 'Already ready']);
        }

        $currentMatchPlayer->update([
            'is_ready' => true,
            'status' => 'ready',
            'ready_at' => now(),
        ]);

        $readyCount = MatchPlayer::where('game_match_id', $match->id)
            ->where('is_ready', true)
            ->count();

        $totalCount = MatchPlayer::where('game_match_id', $match->id)
            ->count();

        if ($readyCount < $totalCount) {
            return response()->json([
                'status' => 'ready',
                'ready' => $readyCount,
                'total' => $totalCount,
            ]);
        }

        if ($readyCount === $totalCount){

            $match->update(['status' => 'started']);

            MatchPlayer::where('game_match_id', $match->id)
                ->update([
                    'status' => 'started',
                    'started_at' => now(),
                ]);

            return response()->json([
                'status' => 'started',
                'players' => MatchPlayer::where('game_match_id', $match->id)->get(),
            ]);
        }

        return response()->json(['error' => 'Что-то сломалось)']);
    }


    public function show(int $match)
    {
        $match = GameMatch::findOrFail($match);

        if (
            $match->status === 'ready' &&
            $match->ready_expires_at?->isPast()
        ) {
            $match->update(['status' => 'expired']);
        }


        $players = MatchPlayer::where('game_match_id', $match->id)->get();

        return response()->json([
            'id' => $match->id,
            'status' => $match->status,
            'max_players' => $match->max_players,
            'players_count' => $players->count(),
            'ready_count' => $players->where('is_ready', true)->count(),
            'ready_expires_at' => $match->ready_expires_at,
            'players' => $players->map(fn ($p) => [
                'id' => $p->user->id,
                'nickname' => $p->user->nickname,
                'avatar' => $p->user->avatar,
                'is_ready' => $p->is_ready,
            ]),
        ]);
    }


    public function start(int $match)
    {
        $match = GameMatch::findOrFail($match);

        if ($match->status !== 'ready') {
            return response()->json(['error' => 'Match is not ready to start']);
        }

        $playersCount = MatchPlayer::where('game_match_id', $match->id)->count();

        if ($playersCount !== $match->max_players){
            return response()->json(['error' => 'Not all players are ready']);
        }

        $readyCount = MatchPlayer::where('game_match_id', $match->id)
            ->where('is_ready', true)
            ->count();

        if ($readyCount !== $playersCount) {
            return response()->json(['error' => 'Not all players are ready']);
        }

        $match->update(['status' => 'started']);

        MatchPlayer::where('game_match_id', $match->id)
            ->update([
                'status' => 'started',
                'started_at' => now(),
            ]);

        return response()->json([
            "status"=> "started",
            "match_id"=> $match->id,
            "players"=> $readyCount
        ]);

    }

    public function finish(int $match){

        $match = GameMatch::findOrFail($match);

        if ($match->status !== 'started')
        {
            return response()->json(['error' => 'Match is not started']);
        }

        $match->update([
            'status' => 'finished',
            'finished_at' => now(),
        ]);

        $players = MatchPlayer::where('game_match_id', $match->id)
            ->get();

        foreach ($players as $player){

            if ($match->winner_team !== null)
            {
                $resultMatch =  $player->team === $match->winner_team ? true : false;
            } else {
                $resultMatch = null;
            }

            $player->update([
                'is_winner' => $resultMatch,
            ]);
        }


        $match->refresh();

        return response()->json([
            'status' => 'finished',
            'finished_at' => $match->finished_at,
            'winner_team' => $match->winner_team,
        ]);
    }

    public function cancel(int $match){

        $match = GameMatch::findOrFail($match);

        if ($match->status == 'started'){
            return response()->json(['error' => 'Match is also started']);
        }

        MatchPlayer::where('game_match_id', $match->id)
            ->where('user_id', auth()->id())
            ->delete();

        $playersCount = MatchPlayer::where('game_match_id', $match->id)->count();


        if ($playersCount === 0){
            $match->update(['status' => 'canceled']);
        } else {
            $match->update(['status' => 'waiting']);
        }

        return response()->json([
            'status' => $match->status,
        ]);
    }

    public function my()
    {
        $user = auth()->user();

        $matchPlayer = MatchPlayer::where('user_id', $user->id)
            ->whereHas('gameMatch', function ($q) {
                $q->whereNotIn('status', ['finished', 'canceled']);
            })
            ->first();

        if (!$matchPlayer) {
            return response()->json([
                'match' => null
            ]);
        }

        $match = $matchPlayer->gameMatch;

        return response()->json([
            'match' => [
                'id'     => $match->id,
                'status' => $match->status,
            ],
        ]);
    }

}
