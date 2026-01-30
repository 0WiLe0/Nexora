<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameMatch extends Model
{
    protected $fillable = [
        'status',
        'max_players',
        'ready_timeout',
        'ready_expires_at',
    ];


    protected $casts = [
        'ready_expires_at' => 'datetime',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];


    public function players()
    {
        return $this->hasMany(MatchPlayer::class, 'game_match_id');
    }

}

