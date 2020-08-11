<?php

namespace App\Http\Controllers\DataHandlers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Throwable;

class VatsimDataController extends Controller
{
    public $expiryTime = 300; // Time in seconds for data to expire in cache

    public function getATCSessions()
    {
        $cid = auth()->user()->vatsim_id;
        if (app(CacheController::class)->checkCache('atc_sessions', true)) {
            $sessions = app(CacheController::class)->getCache('atc_sessions', true);
            $sessions = $this->atcSessionsSort($sessions['results']);
        } else {
            try {
                $response = (new Client())->get("https://api.vatsim.net/api/ratings/".$cid."/atcsessions", [
                    'headers' => [
                        'Accepts' => 'application/json',
                    ]
                ]);
                $response = json_decode((string) $response->getBody(), true);
                $sessions = $this->atcSessionsSort($response['results']);
                app(CacheController::class)->putCache('atc_sessions', $response, $this->expiryTime, true);
            } catch(Throwable $e) {
                $response = [
                    "results" => [

                    ],
                ];
                $sessions = [];
                app(CacheController::class)->putCache('atc_sessions', $response, $this->expiryTime, true);
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
            } catch(Throwable $e) {
                $return = [
                    'atc' => 'Api Error',
                    'pilot' => 'Api Error',
                ];
                app(CacheController::class)->putCache('hours', $return, $this->expiryTime, true);
            }
        }
        return $return;
    }

    public function getFlights()
    {
        $cid = auth()->user()->vatsim_id;
        if (app(CacheController::class)->checkCache('flights', true)) {
            $flights = app(CacheController::class)->getCache('flights', true);
        } else {
            try {
                $response = (new Client)->get('https://api.vatsim.net/api/ratings/'.$cid.'/connections', [
                    'header' => [
                        'Accept' => 'application/json',
                    ]
                ]);
                $response = json_decode((string) $response->getBody(), true);
                $flights = [];
                foreach ($response['results'] as $f) {
                    if ($f['type'] == 1) {
                        $new = [
                            'vatsim_id' => $f['vatsim_id'],
                            'callsign' => $f['callsign'],
                            'start' => $f['start'],
                            'end' => $f['end'],
                        ];
                        array_push($flights, $new);
                    }
                }

                app(CacheController::class)->putCache('flights', $flights, $this->expiryTime, true);
            } catch(Throwable $e) {
                $flights = [];
                app(CacheController::class)->putCache('flights', $flights, $this->expiryTime, true);
            }
        }
        return $flights;
    }
    
    public function getOnlineATC()
    {
        $url = "http://cluster.data.vatsim.net/vatsim-data.json";

        if (app(CacheController::class)->checkCache('onlineatc', false)) {
            $clients = app(CacheController::class)->getCache('onlineatc', false);
        } else {
            try {
                $response = (new Client)->get($url, [
                    'header' => [
                        'Accept' => 'application/json',
                    ]
                ]);
                $response = json_decode((string) $response->getBody(), true);
                $clients = [];
                foreach ($response['clients'] as $c) {
                    if ($c['clienttype'] == "ATC" && substr($c['callsign'], 0, 2) == "LF" && substr($c['callsign'], -5) !== "_ATIS" && config('vatfrance.atc_ranks')[$c['rating']] !== "OBS") {
                        $add = [
                            'callsign' => $c['callsign'],
                            'name' => $c['realname'],
                            'livesince' => date_format(date_create($c['time_logon']), 'H:i'),
                            'rating' => config('vatfrance.atc_ranks')[$c['rating']],
                        ];
                        array_push($clients, $add);
                    }
                }

            } catch(Throwable $e) {
                $clients = [];
            }
            
            app(CacheController::class)->putCache('onlineatc', $clients, 150, false);
        }
        return $clients;
    }

    public function livemapDataGenerator()
    {
        $url = "http://cluster.data.vatsim.net/vatsim-data.json";

        if (app(CacheController::class)->checkCache('livemap', false)) {
            $data = app(CacheController::class)->getCache('livemap', false);
        } else {
            try {
                $response = (new Client)->get($url, [
                    'header' => [
                        'Accept' => 'application/json',
                    ]
                ]);
                $response = json_decode((string) $response->getBody(), true);
                $twrs = [];
                $appr = [];
                $planes = [];
                $planeCount = 0;
                $atcCount = 0;
                foreach ($response['clients'] as $p) {
                    if ($p['clienttype'] == "PILOT") {
                        if (substr($p['planned_depairport'], 0, 2) == "LF" || substr($p['planned_destairport'], 0, 2) == "LF") {
                            $planeCount++;
                            $add = [
                                'callsign' => $p['callsign'],
                                'hdg' => $p['heading'],
                                'lat' => $p['latitude'],
                                'lon' => $p['longitude'],
                                'dep' => $p['planned_depairport'],
                                'arr' => $p['planned_destairport'],
                                'alt' => $p['altitude'],
                                'gspd' => $p['groundspeed'],
                            ];
                            array_push($planes, $add);
                        }
                    } elseif ($p['clienttype'] == "ATC") {
                        if ($p['clienttype'] == "ATC" && substr($p['callsign'], 0, 2) == "LF" && config('vatfrance.atc_ranks')[$p['rating']] !== "OBS") {
                            if (substr($p['callsign'], -4) == "_APP") {
                                $atcCount++;
                                $add = [
                                    'callsign' => $p['callsign'],
                                    'lat' => $p['latitude'],
                                    'lon' => $p['longitude'],
                                    'freq' => $p['frequency'],
                                ];
                                array_push($appr, $add);
                            }

                            if (substr($p['callsign'], -4) == "_TWR") {
                                $atcCount++;
                                $add = [
                                    'callsign' => $p['callsign'],
                                    'lat' => $p['latitude'],
                                    'lon' => $p['longitude'],
                                    'freq' => $p['frequency'],
                                ];
                                array_push($twrs, $add);
                            }
                        }
                    }
                }
        
                $data = [
                    'planes' => $planes,
                    'appr' => $appr,
                    'twr' => $twrs,
                    'planeCount' => $planeCount,
                    'atcCount' => $atcCount,
                ];

            } catch(Throwable $e) {
                $data = [
                    'planes' => null,
                    'appr' => null,
                    'twr' => null,
                    'planeCount' => 0,
                    'atcCount' => 0,
                ];
            }

            app(CacheController::class)->putCache('livemap', $data, 150, false);
        }

        return $data;
    }
}
