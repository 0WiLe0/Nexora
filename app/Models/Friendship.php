<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Friendship extends Model
{
    protected $fillable = [
        'requester_id',
        'addressee_id',
        'status',
    ];

    public function requesterUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function addresseeUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'addressee_id');
    }


    public static function areFriends(int $userId, int $friendId): bool
    {
        return self::where('status', 'accepted')
            ->where(function ($q) use ($userId, $friendId) {
                $q->where(function ($q) use ($userId, $friendId) {
                    $q->where('requester_id', $userId)
                        ->where('addressee_id', $friendId);
                })
                    ->orWhere(function ($q) use ($userId, $friendId) {
                        $q->where('requester_id', $friendId)
                            ->where('addressee_id', $userId);
                    });
            })
            ->exists();
    }
}
