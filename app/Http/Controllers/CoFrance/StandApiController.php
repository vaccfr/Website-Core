<?php

namespace App\Http\Controllers\CoFrance;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DataHandlers\VatsimDataController;
use App\Models\CoFrance\StandApiData;
use Illuminate\Http\Request;
use Yosymfony\Toml\TomlBuilder;

class StandApiController extends Controller
{
    protected $wtc_conversion = [
        "L" => 1,
        "M" => 2,
        "H" => 3,
        "J" => 4,
    ];

    protected $wtc_equivalences = [
        1 => "Light",
        2 => "Medium",
        3 => "Heavy",
        4 => "Super / Jumbo",
    ];

    protected $schengen = [
        "LP", "LE", "LF", "LS", "LI",
        "LG", "LM", "EB", "EI", "EH",
        "ED", "EP", "LZ", "LO", "LH",
        "LJ", "LK", "EY", "EV", "EE",
        "EF", "EN", "ES", "EL", "BI",
    ];

    protected $stand_users = [
        "A" => "airliners/commuter aircraft",
        "B" => "business/corporate aircraft",
        "C" => "cargo aircraft",
        "H" => "helicopters",
        "I" => "military helicopters",
        "M" => "military aircraft",
        "P" => "private aircraft",
        "T" => "military tanker/transport aircraft",
    ];

    public function editorDashboard(Request $request)
    {
        $curr_icao = null;
        $icaos = [];
        $standsDataFiltered = [];

        foreach (StandApiData::get() as $idx => $v) {
            if (!in_array($v['icao'], $icaos)) {
                array_push($icaos, $v['icao']);
            }
        }

        if (!is_null(request('icao')) && in_array(strtoupper(request('icao')), $icaos)) {
            foreach (StandApiData::where('icao', strtoupper(request('icao')))->get() as $d) {
                array_push($standsDataFiltered, $d);
            }
            $curr_icao = strtoupper(request('icao'));
        }

        return view('app.atc.cofrance.standApiEditor', [
            "currentIcao" => $curr_icao,
            "icaos" => $icaos,
            "data" => $standsDataFiltered,
            "wtc_equivalences" => $this->wtc_equivalences,
            "stand_users" => $this->stand_users,
        ]);
    }

    public function standEditor(Request $request)
    {
        $stand = StandApiData::where('id', request('standid'))->first();
        if (is_null($stand)) {
            return redirect()->back()->with('toast-error', 'Error occured with request');
        }
        
        $stand_user_values = [];
        foreach ($this->stand_users as $idx => $val) {
            if (request('su_'.array_keys($this->stand_users, $val)[0]) == "on") {
                array_push($stand_user_values, array_keys($this->stand_users, $val)[0]);
            }
        }

        $stand->stand = request('standnumber');
        $stand->usage = implode(',', $stand_user_values);
        $stand->lat = request('coordinates-lat');
        $stand->lon = request('coordinates-lon');
        $stand->companies = request('companies');
        $stand->wtc = request('wtcvalue');
        $stand->save();

        return redirect()->route('app.atc.cofrance.stands', [
            'locale' => app()->getLocale(),
            'icao' => $stand->icao,
        ])->with('toast-success', 'Stand "'.$stand->stand.'" edited with success!');
    }

    public function createStand(Request $request)
    {
        $stand = StandApiData::where('icao', request('airporticao'))->where('stand', request('standnumber'))->first();
        if (!is_null($stand)) {
            return redirect()->back()->with('toast-error', 'Error occured: a similar stand already exists');
        }

        $stand_user_values = [];
        foreach ($this->stand_users as $idx => $val) {
            if (request('su_'.array_keys($this->stand_users, $val)[0]) == "on") {
                array_push($stand_user_values, array_keys($this->stand_users, $val)[0]);
            }
        }

        $stand = new StandApiData();
        $stand->icao = request('airporticao');
        $stand->stand = request('standnumber');
        $stand->usage = implode(',', $stand_user_values);
        $stand->lat = request('coordinates-lat');
        $stand->lon = request('coordinates-lon');
        $stand->companies = request('companies');
        $stand->wtc = request('wtcvalue');
        $stand->save();

        return redirect()->route('app.atc.cofrance.stands', [
            'locale' => app()->getLocale(),
            'icao' => $stand->icao,
        ])->with('toast-success', 'Stand "'.$stand->stand.'" created with success!');
    }

    public function deleteStand(Request $request)
    {
        $stand = StandApiData::where('id', request('stand'))->first();
        if (is_null($stand)) {
            return redirect()->back()->with('toast-error', 'Error occured: stand not found');
        }
        $stand->delete();
        return redirect()->route('app.atc.cofrance.stands', [
            'locale' => app()->getLocale(),
            'icao' => $stand->icao,
        ])->with('toast-success', 'Stand "'.$stand->stand.'" deleted with success!');
    }

    public function active(Request $request)
    {
        $icaos = [];
        $allStands = StandApiData::get();
        foreach ($allStands as $i => $v) {
            if (!in_array($v['icao'], $icaos)) {
                array_push($icaos, $v['icao']);
            }
        }
        $tb = new TomlBuilder();
        $result = $tb
        ->addTable('request')
        ->addValue('code', 200)
        ->addValue('type', 'success')
        ->getTomlString();

        $result .= "\n";
        $result .= "[data]\n";
        $result .= 'icaos = ["'.implode('", "', $icaos).'"]';
        // $result .= 'icaos = '.implode(',', $icaos);

        return response($result, 200)->header('Content-Type', 'text/plain');
    }

    public function query(Request $request)
    {
        $tb = new TomlBuilder();
        
        $icaos = [];
        $allStands = StandApiData::get();
        foreach ($allStands as $i => $v) {
            if (!in_array($v['icao'], $icaos)) {
                array_push($icaos, $v['icao']);
            }
        }
        if (!in_array($request->arr, $icaos)) {
            $result = $tb
            ->addTable('request')
            ->addValue('code', 404)
            ->addValue('type', 'error')
            ->getTomlString();

            $result .= "\n";
            $result .= "[data]\n";
            $result .= 'error = ICAO not served';
            return response($result, 404)->header('Content-Type', 'text/plain');
        }
        $is_schengen = false;
        if (in_array(substr(request('dep'), 0, 2), $this->schengen)) {
            $is_schengen = true;
        }
        if (!array_key_exists(request('wtc'), $this->wtc_conversion)) {
            $result = $tb
            ->addTable('request')
            ->addValue('code', 404)
            ->addValue('type', 'error')
            ->getTomlString();

            $result .= "\n";
            $result .= "[data]\n";
            $result .= 'error = WTC not found';
            return response($result, 404)->header('Content-Type', 'text/plain');
        }
        $prefilter_stands = StandApiData::where('icao', request('arr'))
                            // ->where('schengen', $is_schengen)
                            ->where('wtc', '>=', $this->wtc_conversion[request('wtc')])
                            ->get();
        $filtered_stands = [];
        foreach ($prefilter_stands as $idx => $v) {
            $companies = explode(',', $v->companies);
            if (in_array(substr(request('callsign'), 0, 3), $companies)) {
                $filtered_data = [
                    "number" => $v->stand,
                    "lat" => $v->lat,
                    "lon" => $v->lon,
                ];
                array_push($filtered_stands, $filtered_data);
            }
        }
        if (count($filtered_stands) == 0) {
            $sendError = true;
            if (request('arr') == "LFPG") {
                $lfpgBinStands = $this->getLFPGBinStands();
                if ($lfpgBinStands['is'] == true) {
                    $sendError = false;
                    $filtered_stands = $lfpgBinStands['data'];
                }
            }
            if ($sendError == true) {
                $result = $tb
                ->addTable('request')
                ->addValue('code', 404)
                ->addValue('type', 'error')
                ->getTomlString();

                $result .= "\n";
                $result .= "[data]\n";
                $result .= 'error = No stands found';
                return response($result, 404)->header('Content-Type', 'text/plain');
            }
        }
        $onlinePilots = app(VatsimDataController::class)->getOnlinePilots();
        $final_stands = [];
        foreach ($filtered_stands as $idxs => $vs) {
            foreach ($onlinePilots as $idxp => $vp) {
                if (!$this->getCoordDistance($vs['lat'], $vs['lon'], $vp['lat'], $vp['lon']) < 0.02) {
                    array_push($final_stands, $vs);
                }
            }
        }
        if (count($final_stands) == 0) {
            $result = $tb
            ->addTable('request')
            ->addValue('code', 404)
            ->addValue('type', 'error')
            ->getTomlString();

            $result .= "\n";
            $result .= "[data]\n";
            $result .= 'error = No stands found';
            return response($result, 404)->header('Content-Type', 'text/plain');
        }
        $chosen = $final_stands[rand(0,count($final_stands))];
        $result = $tb
        ->addTable('request')
        ->addValue('code', 200)
        ->addValue('type', 'success')
        ->getTomlString();

        $result .= "\n";
        $result .= "[data]\n";
        $result .= 'stand = '.$chosen['number'];
        $result .= "\n".'lat = '.$chosen['lat'];
        $result .= "\n".'lon = '.$chosen['lon'];
        return response($result, 200)->header('Content-Type', 'text/plain');
    }

    private function getLFPGBinStands()
    {
        $prefilter_stands = StandApiData::where('icao', 'LFPG')
                            ->where('stand', 'like', 'Q%')
                            ->get();
        $filtered_stands = [];
        foreach ($prefilter_stands as $idx => $v) {
            $filtered_data = [
                "number" => $v->stand,
                "lat" => $v->lat,
                "lon" => $v->lon,
            ];
            array_push($filtered_stands, $filtered_data);
        }
        if (count($filtered_stands) == 0) {
            return [
                'is' => false,
                'data' => [],
            ];
        }
        return [
            'is' => true,
            'data' => $filtered_stands,
        ];
    }

    private function getCoordDistance($lat1, $lon1, $lat2, $lon2)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        }
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        // return ($miles * 0.8684); // Nautical miles
        return ($miles * 1.609344); // Kilometers 
    }

    public function retrieveFromJson($locale, $icao)
    {
        try {
            $standfile = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/assets/standapi/'.$icao.'.json');
        } catch (\Throwable $th) {
            return redirect()->route('landingpage.home', 'en')->with('toast-error', 'Error occured importing stands from '.$icao);
        }
        $stands = json_decode($standfile, true);
        foreach ($stands as $idx => $stand) {
            if (count($stand['companies']) == 0) {
                $companies = null;
            } else {
                $companies = implode(',', $stand['companies']);
            }
            if (count($stand['usage']) == 0) {
                $usage = "A";
            } else {
                $usage = implode(',', $stand['usage']);
            }
            if (count($stand['wtc']) == 0) {
                $wtc = 2;
            } else {
                if (in_array("J", $stand['wtc'])) {
                    $wtc = 4;
                } elseif (in_array("H", $stand['wtc'])) {
                    $wtc = 3;
                } elseif (in_array("M", $stand['wtc'])) {
                    $wtc = 2;
                } elseif (in_array("L", $stand['wtc'])) {
                    $wtc = 1;
                }
            }
            try {
                StandApiData::create([
                    'icao' => strtoupper($icao),
                    'stand' => $stand['number'],
                    'wtc' => $wtc,
                    'schengen' => $stand['schengen'],
                    'lat' => $stand['lat'],
                    'lon' => $stand['lon'],
                    'companies' => $companies,
                    'usage' => $usage,
                ]);
            } catch (\Throwable $th) {
                dd($stand, $wtc);
            }
        }
    }
}