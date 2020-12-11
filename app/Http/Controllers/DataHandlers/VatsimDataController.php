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
        $url = "https://data.vatsim.net/v3/vatsim-data.json";

        if (app(CacheController::class)->checkCache('onlineatc', false)) {
            $clients = app(CacheController::class)->getCache('onlineatc', false);
        } else {
            $onlineATC = 0;
            try {
                $response = (new Client)->get($url, [
                    'header' => [
                        'Accept' => 'application/json',
                    ]
                ]);
                $response = json_decode((string) $response->getBody(), true);
                $clients = [];
                foreach ($response['controllers'] as $c) {
                    if (substr($c['callsign'], 0, 2) == "LF" && substr($c['callsign'], -5) !== "_ATIS" && config('vaccfr.atc_ranks')[$c['rating']] !== "OBS") {
                        $add = [
                            'callsign' => $c['callsign'],
                            'name' => $c['name'],
                            'livesince' => date_format(date_create($c['time_logon']), 'H:i'),
                            'rating' => config('vaccfr.atc_ranks')[$c['rating']],
                        ];
                        array_push($clients, $add);
                        $onlineATC++;
                    }
                }

            } catch(Throwable $e) {
                $clients = [];
            }
            
            app(CacheController::class)->putCache('onlineatc', $clients, 150, false);
            app(CacheController::class)->putCache('onlineatccount', $onlineATC, 150, false);
        }
        return $clients;
    }

    public function getOnlinePilots()
    {
        $url = "https://data.vatsim.net/v3/vatsim-data.json";

        if (app(CacheController::class)->checkCache('onlinepilotsall', false)) {
            $clients = app(CacheController::class)->getCache('onlinepilotsall', false);
        } else {
            try {
                $response = (new Client)->get($url, [
                    'header' => [
                        'Accept' => 'application/json',
                    ]
                ]);
                $response = json_decode((string) $response->getBody(), true);
                $clients = [];
                foreach ($response['pilots'] as $c) {
                    $add = [
                        'callsign' => $c['callsign'],
                        'name' => $c['name'],
                        'lat' => $c['latitude'],
                        'lon' => $c['longitude'],
                        'ssr' => $c['transponder'],
                    ];
                    array_push($clients, $add);
                }

            } catch(Throwable $e) {
                $clients = [];
            }
            
            app(CacheController::class)->putCache('onlinepilotsall', $clients, 150, false);
        }
        return $clients;
    }

    public function getOnlineATCCount()
    {
        if (app(CacheController::class)->checkCache('onlineatccount', false)) {
            $count = app(CacheController::class)->getCache('onlineatccount', false);
        } else {
            $t = $this->getOnlineATC();
            $count = app(CacheController::class)->getCache('onlineatccount', false);
        }
        return $count;
    }

    public function livemapDataGenerator()
    {
        $url = "https://data.vatsim.net/v3/vatsim-data.json";

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
                $lfff = false;
                $lfrr = false;
                $lfee = false;
                $lfbb = false;
                $lfmm = false;
                $twrs = [];
                $appr = [];
                $planesFR = [];
                $planesOver = [];
                $planeCount = 0;
                $atcCount = 0;
                foreach ($response['pilots'] as $p) {
                    if (substr($p['planned_depairport'], 0, 2) == "LF" || substr($p['planned_destairport'], 0, 2) == "LF") {
                        $planeCount++;
                        $add = [
                            'callsign' => $p['callsign'],
                            'hdg' => $p['heading'],
                            'lat' => $p['latitude'],
                            'lon' => $p['longitude'],
                            'dep' => $p['departure'],
                            'arr' => $p['arrival'],
                            'alt' => $p['altitude'],
                            'gspd' => $p['groundspeed'],
                        ];
                        array_push($planesFR, $add);
                    } else {
                        $vertices_x = array(-7.50, 9, 10.1, -7.50);
                        $vertices_y = array(51, 51, 40.1, 40.6);
                        $point_polygon = count($vertices_x);
                        $longitude_x = $p['longitude'];
                        $latitude_y = $p['latitude'];

                        if ($this->is_in_polygon($point_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)) {
                            $planeCount++;
                            $add = [
                                'callsign' => $p['callsign'],
                                'hdg' => $p['heading'],
                                'lat' => $p['latitude'],
                                'lon' => $p['longitude'],
                                'dep' => $p['departure'],
                                'arr' => $p['arrival'],
                                'alt' => $p['altitude'],
                                'gspd' => $p['groundspeed'],
                            ];
                            array_push($planesOver, $add);
                        }
                    }
                }
                foreach ($response['controllers'] as $p) {
                    if (substr($p['callsign'], 0, 2) == "LF" && config('vaccfr.atc_ranks')[$p['rating']] !== "OBS") {
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
                        if (substr($p['callsign'], -4) == "_CTR") {
                            if (substr($p['callsign'], 0, 4) === "LFFF") {
                                $lfff = true;
                            }
                            if (substr($p['callsign'], 0, 4) === "LFRR") {
                                $lfrr = true;
                            }
                            if (substr($p['callsign'], 0, 4) === "LFEE") {
                                $lfee = true;
                            }
                            if (substr($p['callsign'], 0, 4) === "LFBB") {
                                $lfbb = true;
                            }
                            if (substr($p['callsign'], 0, 4) === "LFMM") {
                                $lfmm = true;
                            }
                        }
                    }
                }
        
                $data = [
                    'planesFR' => $planesFR,
                    'planesOver' => $planesOver,
                    'appr' => $appr,
                    'twr' => $twrs,
                    'lfff' => $lfff,
                    'lfrr' => $lfrr,
                    'lfee' => $lfee,
                    'lfbb' => $lfbb,
                    'lfmm' => $lfmm,
                    'planeCount' => $planeCount,
                    'atcCount' => $atcCount,
                ];

            } catch(Throwable $e) {
                $data = [
                    'planesFR' => null,
                    'planesOver' => null,
                    'appr' => null,
                    'twr' => null,
                    'lfff' => false,
                    'lfrr' => false,
                    'lfee' => false,
                    'lfbb' => false,
                    'lfmm' => false,
                    'planeCount' => 0,
                    'atcCount' => 0,
                ];
            }

            app(CacheController::class)->putCache('livemap', $data, 150, false);
        }

        return $data;
    }

    public function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y)
    {
        $i = $j = $c = 0;
        for ($i = 0, $j = $points_polygon-1 ; $i < $points_polygon; $j = $i++) {
            if ( (($vertices_y[$i] > $latitude_y != ($vertices_y[$j] > $latitude_y)) &&
            ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i]) ) ) 
                $c = !$c;
        }
        return $c;
    }
}
