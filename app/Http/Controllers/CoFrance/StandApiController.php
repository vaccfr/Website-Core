<?php

namespace App\Http\Controllers\CoFrance;

use App\Http\Controllers\Controller;
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

    protected $schengen = [
        "LP", "LE", "LF", "LS", "LI",
        "LG", "LM", "EB", "EI", "EH",
        "ED", "EP", "LZ", "LO", "LH",
        "LJ", "LK", "EY", "EV", "EE",
        "EF", "EN", "ES", "EL", "BI",
    ];

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
        $result .= 'icaos = '.implode(',', $icaos);

        return response($result, 200)->header('Content-Type', 'text/plain');
    }

    public function query(Request $request)
    {
        $icaos = [];
        $allStands = StandApiData::get();
        foreach ($allStands as $i => $v) {
            if (!in_array($v['icao'], $icaos)) {
                array_push($icaos, $v['icao']);
            }
        }
        if (!in_array($request->arr, $icaos)) {
            return "ICAO not served";
        }
        $is_schengen = false;
        if (in_array(substr(request('dep'), 0, 2), $this->schengen)) {
            $is_schengen = true;
        }
        if (!array_key_exists(request('wtc'), $this->wtc_conversion)) {
            return "WTC not found";
        }
        $prefilter_stands = StandApiData::where('icao', request('arr'))
                            // ->where('schengen', $is_schengen)
                            ->where('wtc', '<=', $this->wtc_conversion[request('wtc')])
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
        return $filtered_stands;
        return $request;
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