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

        Schema::create('game_matches', function (Blueprint $table) {
            $table->id();

            /*
             |-----------------------------------------
             | Статус матча
             |-----------------------------------------
             | created   — матч создан
             | waiting   — игроки подключаются
             | ready     — все нажали ready
             | expired   — не все нажали ready вовремя
             | started   — матч начался
             | finished  — матч завершён корректно
             | canceled  — матч отменён (до старта)
             */
            $table->string('status')->default('created');

            // Ограничения
            $table->unsignedInteger('max_players')->default(10);

            // Ready-фаза
            $table->unsignedInteger('ready_timeout')->default(30);
            $table->timestamp('ready_expires_at')->nullable();

            // Завершение матча (шаг 9)
            $table->timestamp('finished_at')->nullable();

            // Победившая команда (1 / 2 или null)
            $table->tinyInteger('winner_team')->nullable();

            // Payload под будущее (бот, аналитика, статистика)
            $table->json('result_payload')->nullable();

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_matches');
    }
};
