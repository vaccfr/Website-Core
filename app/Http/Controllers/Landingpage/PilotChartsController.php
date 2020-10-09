<?php

namespace App\Http\Controllers\Landingpage;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PilotChartsController extends Controller
{
    public function index(Request $request)
    {
        if (is_null($request->ICAO)) {
            return view('landingpage.pilot.pilotbrief', [
                'hasCharts' => false,
                'embed' => '',
            ]);
        }

        // $url = "https://chartfox.org/api/interface/charts/".$request->icao."?token=".env('CHARTFOX_API');
        $url = "https://chartfox.org/api/interface/charts/LFPG?token=317CB5565DD1CC52B787F4113F6C3";

        $response = (new Client)->get($url);
        $response = html_entity_decode($response->getBody());
        // dd($response);

        return view('landingpage.pilot.pilotbrief', [
            'hasCharts' => true,
            'embed' => $response,
        ]);

        // return redirect()->back()->with('toast-info', trans('app/alerts.page_unavailable'));
    }

    public function fetch(Request $request)
    {
        if (is_null($request->icao)) {
            return redirect()->back()->with('toast-error', 'No ICAO provided');
        }
        return redirect()->route('landingpage.pilot.charts', [
            'locale' => app()->getLocale(),
            'ICAO' => $request->icao
        ]);
    }
}
