<?php

namespace App\Http\Controllers\ATC;

use App\Http\Controllers\Controller;
use App\Models\ATC\Airport;
use App\Models\ATC\ATCStation;
use ErrorException;
use Exception;
use Illuminate\Http\Request;

class AirportsController extends Controller
{
    public function retrieveFromJson()
    {
        $airportsFile = file_get_contents(asset('assets/airports.json'));
        $airports = json_decode($airportsFile, true);
        foreach ($airports as $a) {
            try {
                Airport::create([
                    'icao' => $a['icao'],
                    'fir' => null,
                    'city' => $a['city'],
                    'airport' => $a['airport'],
                    'atis_frequency' => $a['atis'],
                ]);
                $current = Airport::where('icao', $a['icao'])->first();
                if (count($a['positions']) > 0) {
                    foreach ($a['positions'] as $p) {
                        try {
                            ATCStation::create([
                                'airport_id' => $current->id,
                                'code' => $p['code'],
                                'type' => $p['type'],
                                'frequency' => $p['frequency'],
                                'rank' => $p['rank'],
                                'solo_rank' => $p['solo_rank'],
                            ]);
                        } catch(ErrorException $e) {
                            dd($e);
                        }
                    }
                }
            } catch(ErrorException $e) {
                dd($e);
            }
        }
        return redirect()->back();
    }
}
