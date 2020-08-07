<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Data\SystemLog;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
        ->with('user')
        ->get();

        $membersToday = User::orderBy('last_login', 'DESC')
        ->whereDate('last_login', Carbon::today())
        ->get();

        return view('app.admin.webadmin', [
            'exceptions' => $exceptionLogs,
            'exceptionsToday' => count($exceptionsToday),
            'usersToday' => count($membersToday),
        ]);
    }
}
