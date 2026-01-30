<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Services\OpenDotaService;

class SteamAuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function redirect()
    {
        $params = [
            'openid.ns'         => 'http://specs.openid.net/auth/2.0',
            'openid.mode'       => 'checkid_setup',
            'openid.return_to'  => config('services.steam.redirect'),
            'openid.realm'     => config('app.url'),
            'openid.identity'  => 'http://specs.openid.net/auth/2.0/identifier_select',
            'openid.claimed_id'=> 'http://specs.openid.net/auth/2.0/identifier_select',
        ];

        return redirect('https://steamcommunity.com/openid/login?' . http_build_query($params));
    }

    public function callback(Request $request, OpenDotaService $openDota)
    {
        // 1️⃣ Проверяем режим OpenID
        if ($request->get('openid_mode') !== 'id_res') {
            abort(403, 'Invalid OpenID mode');
        }

        // 2️⃣ Проверяем подпись у Steam
        $params = [];
        foreach ($request->query() as $key => $value) {
            if (str_starts_with($key, 'openid_')) {
                $params[str_replace('_', '.', $key)] = $value;
            }
        }
        $params['openid.mode'] = 'check_authentication';

        $verify = Http::asForm()->post(
            'https://steamcommunity.com/openid/login',
            $params
        );

        if (!str_contains($verify->body(), 'is_valid:true')) {
            abort(403, 'Steam authentication failed');
        }

        // 3️⃣ Достаём SteamID
        preg_match(
            '#https://steamcommunity.com/openid/id/(\d+)#',
            $request->get('openid_claimed_id'),
            $matches
        );

        $steamId = $matches[1] ?? null;

        if (!$steamId) {
            abort(403, 'SteamID not found');
        }

        // 4️⃣ Запрашиваем профиль Steam
        $resp = Http::get(
            'https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v2/',
            [
                'key' => config('services.steam.key'),
                'steamids' => $steamId,
            ]
        );

        $player = data_get($resp->json(), 'response.players.0');

        $steamNickname   = $player['personaname'] ?? ('SteamUser_' . substr($steamId, -4));
        $steamAvatar     = $player['avatarfull'] ?? '';
        $steamProfileUrl = $player['profileurl'] ?? ('https://steamcommunity.com/profiles/' . $steamId);

        $mmr = $openDota->getComputedMMR($steamId);

        $user = User::updateOrCreate(
            ['steam_id' => $steamId],
            [
                'nickname'      => $steamNickname,
                'avatar'        => $steamAvatar,
                'profile_url'   => $steamProfileUrl,
                'valve_mmr'     => $mmr, // <- добавь поле
            ]
        );

        Auth::login($user);
        request()->session()->regenerate();


        return redirect()->route('profile.index');
    }



}
