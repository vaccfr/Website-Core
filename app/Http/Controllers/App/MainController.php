<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
        $cid = auth()->user()->vatsim_id;
        try {
            $response = (new Client)->get("https://api.vatsim.net/api/ratings/".$cid."/atcsessions", [
                'headers' => [
                    'Accepts' => 'application/json',
                ]
            ]);
            $response = json_decode((string) $response->getBody(), true);
            $sessions = $response['results'];
        } catch(ClientException $e) {
            $sessions = [];
        }

        $times = Auth::user()->totalTimes();

        // $sessions = [
        //     0 => [
        //         'callsign' => 'Placeholder',
        //         'minutes_on_callsign' => 'Placeholder',
        //     ]
        // ];
        return view('app.index', [
            'sessions' => $sessions,
            'atcTimes' => $times['atc'],
            'pilotTimes' => $times['pilot'],
        ]);
    }
}
