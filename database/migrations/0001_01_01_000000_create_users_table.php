<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Steam
            $table->string('steam_id')->unique();      // 7656119...
            $table->string('nickname');                // Steam nickname
            $table->string('avatar');                  // avatar URL
            $table->string('profile_url');             // Steam profile link
            $table->integer('valve_mmr')->nullable();
            $table->integer('nexora_rating')->nullable()->default(0);

            // System
            $table->timestamps();
            $table->rememberToken()->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
