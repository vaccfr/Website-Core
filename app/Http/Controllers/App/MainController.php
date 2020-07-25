<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DataHandlers\Utilities;
use App\Http\Controllers\DataHandlers\VatsimDataController;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index()
    {
        $flights = app(VatsimDataController::class)->getFlights();
        $sessions = app(VatsimDataController::class)->getATCSessions();
        $times = app(VatsimDataController::class)->getUserHours();

        $allFlights = [];
        foreach ($flights as $c) {
            $fl = [
                'epoch_start' => date("U", strtotime($c['start'])),
                'start_time' => app(Utilities::class)->iso2datetime($c['start']),
                'end_time' => app(Utilities::class)->iso2datetime($c['end']),
                'callsign' => $c['callsign'],
                'duration' => "N/A",
            ];
            array_push($allFlights, $fl);
        }
        $columns = array_column($allFlights, 'epoch_start');
        array_multisort($columns, SORT_DESC, $allFlights);

        $allATCCallsigns = [];
        if (count($sessions) !== 0) {
            foreach ($sessions as $s) {
                array_push($allATCCallsigns, $s['callsign']);
            }
            $values = array_count_values($allATCCallsigns);
            arsort($values);
            $mostControlled = array_slice(array_keys($values), 0, 5, true);
        } else {
            $mostControlled = "N/A";
        }

        return view('app.index', [
            'sessions' => $sessions,
            'atcTimes' => $times['atc'],
            'pilotTimes' => $times['pilot'],
            'mostControlled' => $mostControlled[0],
            'flights' => $allFlights,
        ]);
    }

    public function usersettings()
    {
        $useremail = Auth::user()->email;
        if (!is_null(Auth::user()->custom_email)) {
            $useremail = Auth::user()->custom_email." (custom)";
        }
        if (Auth::user()->subdiv_id == "FRA") {
            $utypes = config('vatfrance.usertypes');
        } else {
            $utypes = config('vatfrance.visiting_usertypes');
        }
        return view('app.usersettings', [
            'usertypes' => $utypes,
            'useremail' => $useremail,
        ]);
    }

    public function usersettingsedit(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'customemail' => ['email'],
        // ]);

        // if ($validator->fails()) {
        //     return redirect()->route('app.user.settings', app()->getLocale());
        // }

        $currentUser = User::where('id', $request->get('userid'))->firstOrFail();
        if (!is_null($request->get('customemail'))) {
            $currentUser->custom_email = $request->get('customemail');
            $currentUser->save();
        } else {
            $currentUser->custom_email = null;
            $currentUser->save();
        }
        if (!is_null($request->get('hidedetails'))) {
            $currentUser->hide_details = true;
            $currentUser->save();
        } else {
            $currentUser->hide_details = false;
            $currentUser->save();
        }
        switch (Auth::user()->subdiv_id) {
            case 'FRA':
                if (in_array($request->get('editusertype'), config('vatfrance.usertypes'))) {
                    $currentUser->account_type = $request->get('editusertype');
                    $currentUser->save();
                }
                break;
            
            default:
                if (in_array($request->get('editusertype'), config('vatfrance.visiting_usertypes'))) {
                    $currentUser->account_type = $request->get('editusertype');
                    $currentUser->save();
                }
                break;
        }

        return redirect()->route('app.user.settings', app()->getLocale())->with('toast-success', trans('app/alerts.settings_edited'));
    }
}
