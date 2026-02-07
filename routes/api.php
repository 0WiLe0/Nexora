<?php

use App\Http\Controllers\MatchController;
use App\Http\Controllers\PartyRoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchReadyController;

Route::middleware('auth')->prefix('party')->group(function () {

    Route::get('/my', [PartyController::class, 'my']);

    Route::post('/', [PartyController::class, 'create']);
    Route::post('{party}/invite/{friend}', [PartyController::class, 'invite']);
    Route::get('/invites', [PartyController::class, 'invites']);
    Route::post('{party}/accept', [PartyController::class, 'accept']);
    Route::post('{party}/invite-seen', [PartyController::class, 'markInviteSeen']);
    Route::post('{party}/roles', [PartyController::class, 'updateRoles']);
    Route::post('{party}/leave', [PartyController::class, 'leave']);
    Route::get('{party}', [PartyController::class, 'show'])
        ->whereNumber('party');

});




Route::middleware('auth')->group(function () {

    Route::post('/matches', [MatchController::class, 'store']);

    Route::get('/matches/my', [MatchController::class, 'my']);

    Route::get('/matches/{match}', [MatchController::class, 'show'])
        ->whereNumber('match');

    Route::post('/matches/{match}/join', [MatchController::class, 'join']);
    Route::post('/matches/{match}/ready', [MatchController::class, 'ready']);
    Route::post('/matches/{match}/start', [MatchController::class, 'start']);
    Route::post('/matches/{match}/finish', [MatchController::class, 'finish']);
    Route::post('/matches/{match}/cancel', [MatchController::class, 'cancel']);
});

