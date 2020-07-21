<?php

namespace App\Http\Controllers\DataHandlers;

use App\Http\Controllers\Controller;
use App\Models\Vatsim\UserAtcSession;
use App\Models\Vatsim\UserConnections;
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
            $sessions = UserAtcSession::where('vatsim_id', $cid)->get();
            $sessions = $this->atcSessionsSort($sessions);
        } else {
            try {
                $response = (new Client())->get("https://api.vatsim.net/api/ratings/".$cid."/atcsessions", [
                    'headers' => [
                        'Accepts' => 'application/json',
                    ]
                ]);
                $response = json_decode((string) $response->getBody(), true);
                foreach ($response['results'] as $s) {
                    UserAtcSession::updateOrCreate(['id' => $s['connection_id']], [
                        'start' => $s['start'],
                        'end' => $s['end'],
                        'server' => $s['server'],
                        'vatsim_id' => $s['vatsim_id'],
                        'type' => $s['type'],
                        'rating' => $s['rating'],
                        'callsign' => $s['callsign'],
                        'times_held_callsign' => $s['times_held_callsign'],
                        'minutes_on_callsign' => $s['minutes_on_callsign'],
                        'total_minutes_on_callsign' => $s['total_minutes_on_callsign'],
                        'aircrafttracked' => $s['aircrafttracked'],
                        'aircraftseen' => $s['aircraftseen'],
                        'flightsamended' => $s['flightsamended'],
                        'handoffsinitiated' => $s['handoffsinitiated'],
                        'handoffsreceived' => $s['handoffsreceived'],
                        'handoffsrefused' => $s['handoffsrefused'],
                        'squawksassigned' => $s['squawksassigned'],
                        'cruisealtsmodified' => $s['cruisealtsmodified'],
                        'tempaltsmodified' => $s['tempaltsmodified'],
                        'scratchpadmods' => $s['scratchpadmods'],
                    ]);
                }

                $sessions = UserAtcSession::where('vatsim_id', $cid)->get();
                $sessions = $this->atcSessionsSort($sessions);
                app(CacheController::class)->putCache('atc_sessions', 'true', $this->expiryTime, true);
            } catch(ClientException $e) {
                $sessions = [];
            }
        }
        
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

    public function getConnections()
    {
        $types = [
            0 => "Pilot/OBS",
            1 => "FSS",
            2 => "DEL",
            3 => "GND",
            4 => "TWR",
            5 => "APP/DEP",
            6 => "CTR",
        ];
        $excludes = [0];

        $cid = auth()->user()->vatsim_id;
        if (app(CacheController::class)->checkCache('connections', true)) {
            $connections = UserAtcSession::where('vatsim_id', $cid)->get();
        } else {
            try {
                $response = (new Client)->get('https://api.vatsim.net/api/ratings/'.$cid.'/connections', [
                    'header' => [
                        'Accept' => 'application/json',
                    ]
                ]);
                $response = json_decode((string) $response->getBody(), true);
                foreach ($response['results'] as $c) {
                    UserConnections::updateOrCreate(['id' => $c['id']], [
                        'vatsim_id' => $c['vatsim_id'],
                        'type' => $c['type'],
                        'rating' => $c['rating'],
                        'callsign' => $c['callsign'],
                        'start' => $c['start'],
                        'end' => $c['end'],
                        'server' => $c['server'],
                    ]);
                }

                $connections = UserConnections::where('vatsim_id', $cid)->get();
                app(CacheController::class)->putCache('connections', 'true', $this->expiryTime, true);
            } catch(ClientException $e) {
                $connections = [];
            }
        }
        return $connections;
    }
}
