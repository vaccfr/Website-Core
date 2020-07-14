<?php

namespace App\Http\Controllers\DataHandlers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class VatsimDataController extends Controller
{
    public $expiryTime = 300; // Time in seconds for data to expire in cache

    public function getATCSessions()
    {
        $cid = auth()->user()->vatsim_id;
        if (app(CacheController::class)->checkCache('atc_sessions')) {
            $sessions = app(CacheController::class)->getCache('atc_sessions');
        } else {
            try {
                $response = (new Client())->get("https://api.vatsim.net/api/ratings/".$cid."/atcsessions", [
                    'headers' => [
                        'Accepts' => 'application/json',
                    ]
                ]);
                $response = json_decode((string) $response->getBody(), true);
                $sessions = $response['results'];
                app(CacheController::class)->putCache('atc_sessions', $sessions, $this->expiryTime);
            } catch(ClientException $e) {
                $sessions = [];
            }
        }

        // $sessions = [
        //     0 => [
        //         'callsign' => 'Placeholder',
        //         'minutes_on_callsign' => 'Placeholder',
        //     ]
        // ];
        
        return $sessions;
    }

    public function getUserHours()
    {
        $cid = auth()->user()->vatsim_id;
        if (app(CacheController::class)->checkCache('hours')) {
            $return = app(CacheController::class)->getCache('hours');
        } else {
            try {
                $response = (new Client)->get('https://api.vatsim.net/api/ratings/'.$cid.'/rating_times', [
                    'header' => [
                        'Accept' => 'application/json',
                    ]
                ]);
                $response = json_decode((string) $response->getBody(), true);
                $return = [
                    'atc' => $response['atc'],
                    'pilot' => $response['pilot'],
                ];
                app(CacheController::class)->putCache('hours', $return, $this->expiryTime);
            } catch(ClientException $e) {
                $return = [
                    'atc' => 'Api Error',
                    'pilot' => 'Api Error',
                ];
            }
        }
        return $return;
    }
}
