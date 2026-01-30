<?php

use App\Http\Controllers\MatchController;
use App\Http\Controllers\PartyRoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchReadyController;

Route::post('/matches', [MatchController::class, 'store']);
Route::post('/matches/{match}/join', [MatchController::class, 'join']);
Route::post('/matches/{match}/ready', [MatchController::class, 'ready']);
Route::post('/matches/{match}/start', [MatchController::class, 'start']);
Route::post('/matches/{match}/finish', [MatchReadyController::class, 'finish']);
Route::get('/matches/{match}', [MatchController::class, 'show']);



Route::middleware('auth:sanctum')->post(
    '/party/{party}/roles',
    [PartyRoleController::class, 'update']
);

