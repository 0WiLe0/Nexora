<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchPlayer extends Model
{
    protected $fillable = [
        'game_match_id',
        'user_id',
        'is_ready',
    ];

    public function match()
    {
        return $this->belongsTo(GameMatch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);

    }

    public function gameMatch()
    {
        return $this->belongsTo(GameMatch::class, 'game_match_id');
    }

}

