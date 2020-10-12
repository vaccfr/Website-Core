<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DataHandlers\Utilities;
use App\Http\Controllers\DataHandlers\VatsimDataController;
use App\Models\ATC\Booking;
use App\Models\General\Event;
use App\Models\General\News;
use App\Models\Users\User;
use App\Models\Users\UserEmailPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use DateTime;

class MainController extends Controller
{
    public function index()
    {
        $bookingsToday = Booking::whereDate('start_date', Carbon::now()->format('Y-m-d'))
        ->with('user')
        ->orderBy('start_date', 'ASC')
        ->get();

        $eventList = Event::orderBy('start_date', 'ASC')
        ->whereDate('start_date', '>=', Carbon::now()->format('Y-m-d'))
        // ->whereDate('start_date', '<=', Carbon::now()->addDays(7)->format('Y-m-d'))
        ->get();

        $newslist = News::orderBy('created_at', 'DESC')
        ->with('author')
        ->with('author.staff')
        ->get();

        return view('app.user.index', [
            'events' => $eventList,
            'bookings' => $bookingsToday,
            'news' => $newslist,
        ]);
    }

    public function usersettings()
    {
        $user = Auth::user();
        if ($user->login_alert == true) {
            $user->login_alert = false;
            $user->save();
        }
        $useremail = Auth::user()->email;
        if (!is_null(Auth::user()->custom_email)) {
            $useremail = Auth::user()->custom_email." (custom)";
        }
        if (Auth::user()->subdiv_id == "FRA") {
            $utypes = config('vaccfr.usertypes');
        } else {
            $utypes = config('vaccfr.visiting_usertypes');
        }

        $userDiscord = Auth::user()->discord;
        return view('app.user.usersettings', [
            'usertypes' => $utypes,
            'useremail' => $useremail,
            'userDiscord' => $userDiscord,
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
        if (!is_null($request->get('sidenav'))) {
            $currentUser->settings->sidenav_collapsed = true;
            $currentUser->settings->save();
        } else {
            $currentUser->settings->sidenav_collapsed = false;
            $currentUser->settings->save();
        }
        switch (Auth::user()->subdiv_id) {
            case 'FRA':
                if (in_array($request->get('editusertype'), config('vaccfr.usertypes'))) {
                    $currentUser->account_type = $request->get('editusertype');
                    $currentUser->save();
                }
                break;
            
            default:
                if (in_array($request->get('editusertype'), config('vaccfr.visiting_usertypes'))) {
                    $currentUser->account_type = $request->get('editusertype');
                    $currentUser->save();
                }
                break;
        }

        return redirect()->route('app.user.settings', app()->getLocale())->with('toast-success', trans('app/alerts.settings_edited'));
    }

    public function userEmailPrefEdit(Request $request)
    {
        $switch = [
            "on" => true,
            null => false,
        ];
        $currentUser = UserEmailPreference::where('id', auth()->user()->id)->first();
        if (!is_null($currentUser)) {
            $currentUser->event_emails = $switch[$request->get('eventemail')];
            $currentUser->atc_booking_emails = $switch[$request->get('atcbookingemail')];
            $currentUser->atc_mentoring_emails = $switch[$request->get('atcmentoring')];
            $currentUser->website_update_emails = $switch[$request->get('websiteupdates')];
            $currentUser->news_emails = $switch[$request->get('newsemail')];
            $currentUser->internal_messaging_emails = $switch[$request->get('inmsgemail')];
            $currentUser->save();
            return redirect()->route('app.user.settings', app()->getLocale())->with('toast-success', trans('app/alerts.settings_edited'));
        } else {
            return redirect()->back()->with('toast-error', trans('app/alerts.error_occured'));
        }
    }

    public function statsPage()
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
            $mostControlled = $mostControlled[0];
        } else {
            $mostControlled = "N/A";
        }

        return view('app.user.stats', [
            'sessions' => $sessions,
            'atcTimes' => $times['atc'],
            'pilotTimes' => $times['pilot'],
            'mostControlled' => $mostControlled,
            'flights' => $allFlights,
        ]);
    }

    public function staffOrg()
    {
        return view('app.general.org');
    }
}
