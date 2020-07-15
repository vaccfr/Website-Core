<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DataHandlers\VatsimDataController;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
        $sessions = app(VatsimDataController::class)->getATCSessions();
        $times = app(VatsimDataController::class)->getUserHours();

        return view('app.index', [
            'sessions' => $sessions,
            'atcTimes' => $times['atc'],
            'pilotTimes' => $times['pilot'],
        ]);
    }

    // ATC
    public function mybookings()
    {
        $sessions = app(VatsimDataController::class)->getATCSessions();
        $times = app(VatsimDataController::class)->getUserHours();

        return view('app.atc.mybookings', [
            'sessions' => $sessions,
            'atcTimes' => $times['atc'],
            'pilotTimes' => $times['pilot'],
        ]);
    }
}
