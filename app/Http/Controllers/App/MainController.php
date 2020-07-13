<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

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
        } catch(ClientException $e) {
            dd($e);
        }
        $response = json_decode((string) $response->getBody(), true);
        $sessions = $response['results'];
        // dd($sessions);
        return view('app.index', [
            'sessions' => $sessions,
        ]);
    }
}
