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
        if (app(CacheController::class)->checkCache('atc_sessions', true)) {
            $sessions = app(CacheController::class)->getCache('atc_sessions', true);
        } else {
            try {
                $response = (new Client())->get("https://api.vatsim.net/api/ratings/".$cid."/atcsessions", [
                    'headers' => [
                        'Accepts' => 'application/json',
                    ]
                ]);
                $response = json_decode((string) $response->getBody(), true);
                $sessions = $this->atcSessionsSort($response['results']);
                app(CacheController::class)->putCache('atc_sessions', $sessions, $this->expiryTime, true);
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

    protected function atcSessionsSort($data)
    {
        $sessions = array();
        foreach ($data as $session) {
            $sesh = [
                'epoch_start' => date("U", strtotime($session['start'])),
                'start_time' => app(Utilities::class)->iso2datetime($session['start']),
                'end_time' => app(Utilities::class)->iso2datetime($session['end']),
                'callsign' => $session['callsign'],
                'duration' => app(Utilities::class)->decMinConverter((float)$session['minutes_on_callsign'], false),
            ];
            array_push($sessions, $sesh);
        }
        $columns = array_column($sessions, 'epoch_start');
        array_multisort($columns, SORT_DESC, $sessions);
        return $sessions;
    }

    public function getUserHours()
    {
        $cid = auth()->user()->vatsim_id;
        if (app(CacheController::class)->checkCache('hours', true)) {
            $return = app(CacheController::class)->getCache('hours', true);
        } else {
            try {
                $response = (new Client)->get('https://api.vatsim.net/api/ratings/'.$cid.'/rating_times', [
                    'header' => [
                        'Accept' => 'application/json',
                    ]
                ]);
                $response = json_decode((string) $response->getBody(), true);
                $ATCTime = app(Utilities::class)->timeConverter((float)$response['atc'], false);
                $PilotTime = app(Utilities::class)->timeConverter((float)$response['pilot'], false);
                $return = [
                    'atc' => $ATCTime,
                    'pilot' => $PilotTime,
                ];
                app(CacheController::class)->putCache('hours', $return, $this->expiryTime, true);
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
