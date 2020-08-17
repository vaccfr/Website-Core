<?php

namespace App\Http\Controllers\DataHandlers;

use App\Http\Controllers\Controller;
use App\Models\ATC\Booking;
use App\Models\Users\DiscordData;
use App\Models\Users\User;
use App\Models\Users\UserEmailPreference;
use App\Models\Users\UserSetting;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class GDPRController extends Controller
{
    public function download()
    {
        $userData = User::where('id', auth()->user()->id)->first();
        $userSettings = UserSetting::where('id', auth()->user()->id)->first();
        $userEmail = UserEmailPreference::where('id', auth()->user()->id)->first();
        $userDiscord = DiscordData::where('user_id', auth()->user()->id)->first();
        $atcBookings = Booking::where('user_id', auth()->user()->id)->get();

        $pdf = PDF::loadView('gdpr_gb', compact(
            'userData',
            'userSettings',
            'userEmail',
            'userDiscord',
            'atcBookings',
            ))->setPaper('a4', 'landscape');
        $dateToday = Carbon::today()->format('Y-m-d');
        return $pdf->stream($dateToday.'_GDPR_DATA_'.auth()->user()->vatsim_id.'.pdf');
    }
}
