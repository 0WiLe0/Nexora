<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenDotaService
{
    public function getComputedMMR(int $steamId)
    {
        $account_id = $steamId - 76561197960265728 ;

        $resp = Http::get("https://api.opendota.com/api/players/{$account_id}")->json();


        if (!is_array($resp) || isset($resp['error'])) {
            return null; // или 0
        }

        return round($resp['computed_mmr']);
    }
}
