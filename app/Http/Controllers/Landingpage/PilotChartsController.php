<?php

namespace App\Http\Controllers\Landingpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PilotChartsController extends Controller
{
    public function index()
    {
        // return redirect()->back()->with('toast-info', trans('app/alerts.page_unavailable'));
        return view('landingpage.pilot.pilotbrief');
    }
}
