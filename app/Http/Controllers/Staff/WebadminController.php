<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Data\SystemLog;
use App\Models\Users\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class WebadminController extends Controller
{
    public function dashboard()
    {
        $exceptionLogs = SystemLog::orderBy('created_at', 'DESC')
        ->where('type', 2)
        ->with('user')
        ->get();

        $exceptionsToday = SystemLog::orderBy('created_at', 'DESC')
        ->where('type', 2)
        ->whereDate('created_at', Carbon::today())
        ->where('message', '!=', 'Unauthenticated.')
        ->with('user')
        ->get();

        $thisMorning = (new DateTime(Carbon::today()))->format('U');
        $totalToday = DB::table('sessions')
	    ->where('last_activity', '>', $thisMorning)
	    ->where('user_agent', '!=', 'python-requests/2.22.0')
        ->get();

        $visitorsToday = DB::table('sessions')
        ->where('last_activity', '>', $thisMorning)
        ->where('user_id', null, null)
	    ->where('user_agent', '!=', 'python-requests/2.22.0')
        ->get();

        $membersToday = DB::table('sessions')
        ->where('last_activity', '>', $thisMorning)
        ->where('user_id', '!=', null)
	    ->get();

        return view('app.admin.webadmin', [
            'exceptions' => $exceptionLogs,
            'exceptionsToday' => count($exceptionsToday),
            'totalToday' => count($totalToday),
            'visitorsToday' => count($visitorsToday),
            'membersToday' => count($membersToday),
        ]);
    }
}
