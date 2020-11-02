<?php

namespace App\Http\Controllers\CoFrance;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DataHandlers\VatsimDataController;
use Illuminate\Http\Request;

class SSRApiController extends Controller
{
    public function query(Request $request)
    {
        $CurrentlyOnlinePilots = app(VatsimDataController::class)->getOnlinePilots(); // cache of 150 seconds

        $result = "meow";
        return response($result, 200)->header('Content-Type', 'text/plain');
    }
}
