<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('match_players', function (Blueprint $table) {
            $table->id();

            $table->foreignId('game_match_id')
                ->constrained('game_matches')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
             |-----------------------------------------
             | Статус игрока в матче
             |-----------------------------------------
             | joined    — зашёл в матч
             | ready     — нажал ready
             | started   — матч начался
             | finished  — матч завершён
             | left      — вышел / дропнул
             */
            $table->string('status')->default('joined');

            // Ready-фаза
            $table->boolean('is_ready')->default(false);

            // Команда игрока (1 / 2)
            $table->tinyInteger('team')->nullable();

            // Результат игрока
            $table->boolean('is_winner')->nullable();

            // Тайминги
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamp('left_at')->nullable();

            $table->timestamps();

            // Один игрок — один раз в матче
            $table->unique(['game_match_id', 'user_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_players');
    }
};
