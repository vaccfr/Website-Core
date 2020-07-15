<?php

namespace App\Http\Controllers\ATC;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DataHandlers\Utilities;
use App\Models\ATC\ATCStation;
use App\Models\ATC\Booking;
use Exception;
use Godruoyi\Snowflake\Snowflake;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function MyBookingsPage()
    {
        $allowedRanks = app(Utilities::class)->getAuthedRanks(auth()->user()->atc_rating_short);
        $stations = ATCStation::orderBy('code', 'ASC')
        ->whereIn('rank', $allowedRanks)
        ->get();
        
        return view('app.atc.mybookings', [
            'stations' => $stations,
            ]);
    }
    public function book(Request $request)
    {
        $redirectURI = env('APP_URL').'/'.app()->getLocale().'atc/validateBooking';
        $validatedData = $request->validate([
            'date' => 'required|date_format:d.m.Y',
            'start_time' => 'required|before:end_time|date_format:H:i',
            'end_time' => 'required|after:start_time|date_format:H:i',
        ]);

        Booking::create([
            'unique_id' => htmlspecialchars(str_random(32)),
            'id' => (new Snowflake)->id(),
            'user_id' => auth()->user()->id,
            'vatsim_id' => auth()->user()->vatsim_id,
            'position' => htmlspecialchars($request->get('position')),
            'date' => htmlspecialchars($request->get('date')),
            'time' => htmlspecialchars($request->get('start_time')) . ' - ' . htmlspecialchars($request->get('end_time')),
            'start_time' => htmlspecialchars($request->get('start_time')),
            'end_time' => htmlspecialchars($request->get('end_time')),
            'training' => false,
        ]);
        $booking = Booking::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->first();
        return redirect('http://vatbook.euroutepro.com/atc/insert.asp?Local_URL='.$redirectURI.'&Local_ID=' . $booking->id . '&b_day=' . substr($booking->date, 0, 2) . '&b_month=' . substr($booking->date, 3, 2) . '&b_year=' . substr($booking->date, 6, 10) . '&Controller=' . auth()->user()->fname . '%20' . auth()->user()->lname . '&Position=' . $booking->position .  '&sTime='  . substr($booking->start_time, 0, 2) . substr($booking->start_time, 3) . '&eTime=' . substr($booking->end_time, 0, 2) . substr($booking->end_time, 3) . '&T=' . $booking->training . '&E=0&voice=1');
    }
}
