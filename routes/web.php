<?php

use App\Http\Controllers\Auth\SteamAuthController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\LobbyController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\PartyRoleController;
use App\Http\Controllers\PlayController;
use App\Http\Controllers\ProfileController;
use App\Services\Bot\BotSelector;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

// страница входа
Route::get('/login', fn () => view('login'))
    ->middleware('guest')
    ->name('login');

// редирект на Steam
Route::get('/auth/steam', [SteamAuthController::class, 'redirect'])
    ->middleware('guest')
    ->name('steam.login');

// callback от Steam
Route::get('/auth/steam/callback', [SteamAuthController::class, 'callback'])
    ->middleware('guest')
    ->name('steam.callback');

/*
|--------------------------------------------------------------------------
| Profile (protected)
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/profile');

Route::get('/profile', [ProfileController::class, 'index'])
    ->middleware('auth')
    ->name('profile.index');

/*
|--------------------------------------------------------------------------
| Friends (protected)
|--------------------------------------------------------------------------
*/

Route::get('/friends', [FriendController::class, 'index'])
    ->middleware('auth')
    ->name('friends.index');

Route::post('/friends/{user}', [FriendController::class, 'store'])
    ->middleware('auth')
    ->name('friends.store');

Route::get('/profile/{id}', [ProfileController::class, 'show'])
    ->middleware('auth')
    ->name('profile.show');

Route::post('/friends/{friendship}/accept', [FriendController::class, 'accept'])
    ->middleware('auth')
    ->name('friends.accept');

Route::post('/friends/{friendship}/decline', [FriendController::class, 'decline'])
    ->middleware('auth')
    ->name('friends.decline');


Route::delete('/friends/{friendship}', [FriendController::class, 'destroy'])
    ->middleware('auth')
    ->name('friends.destroy');

Route::middleware('auth')->get('/api/friends', [FriendController::class, 'api']);

/*
|--------------------------------------------------------------------------
| play (protected)
|--------------------------------------------------------------------------
*/

Route::get('/play', [PlayController::class, 'index'])
    ->middleware('auth')
    ->name('play.index');

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})
    ->middleware('auth')
    ->name('logout');


Route::get('/lobby', [LobbyController::class, 'index'])
    ->middleware('auth')
    ->name('lobby.index');

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


