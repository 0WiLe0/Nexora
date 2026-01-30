<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartyMember extends Model
{
    protected $fillable = [
        'party_id',
        'user_id',
        'role',
        'status',
        'roles',
    ];

    protected $casts = [
        'roles' => 'array',
    ];


    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

