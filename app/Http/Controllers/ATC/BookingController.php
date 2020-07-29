<?php

namespace App\Http\Controllers\ATC;

use App\Events\EventDeleteATCBooking;
use App\Events\EventNewATCBooking;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DataHandlers\Utilities;
use App\Models\ATC\Airport;
use App\Models\ATC\ATCStation;
use App\Models\ATC\Booking;
use Exception;
use Godruoyi\Snowflake\Snowflake;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function allBookings()
    {
        $allDates = [];
        $allBookings = [];

        $day = Carbon::now()->format('D. d/m');
        array_push($allDates, $day);
        for ($i=1; $i < 8; $i++) { 
            $day = Carbon::now()->addDays($i)->format('D. d/m');
            array_push($allDates, $day);
        }

        $bookingToday = Booking::where('date', Carbon::now()->format('d.m.Y'))
        ->with('user')
        ->get();
        array_push($allBookings, $bookingToday);
        for ($i=1; $i < 8; $i++) { 
            $booking = Booking::where('date', Carbon::now()
            ->addDays($i)
            ->format('d.m.Y'))
            ->with('user')
            ->get();
            array_push($allBookings, $booking);
        }
        return view('app.atc.allbookings', [
            'bookingDate' => $allDates,
            'bookings' => $allBookings,
        ]);
    }
    public function MyBookingsPage()
    {
        // $allowedRanks = app(Utilities::class)->getAuthedRanks(auth()->user()->atc_rating_short);
        // $stations = ATCStation::orderBy('code', 'ASC')
        // ->whereIn('rank', $allowedRanks)
        // ->with('parent')
        // ->get();

        $positions = Airport::orderBy('city', 'ASC')
        ->with(['positions' => function($q) {
            $q->whereIn('rank', app(Utilities::class)->getAuthedRanks(auth()->user()->atc_rating_short));
        }])
        ->get();

        $bookings = Booking::where('vatsim_id', auth()->user()->vatsim_id)->get();
        return view('app.atc.mybookings', [
            'positions' => $positions,
            // 'stations' => $stations,
            'bookings' => $bookings,
            ]);
    }

    public function book(Request $request)
    {
        $redirectURI = route('do.atc.booking.validate', app()->getLocale());

        $validatedData = Validator::make($request->all(), [
            'positionselect' => 'required',
            'bookingdate' => 'required|date_format:d.m.Y',
            'starttime' => 'required|before:endtime|date_format:H:i',
            'endtime' => 'required|after:starttime|date_format:H:i',
        ]);

        if ($validatedData->fails()) {
            return redirect()->back()->with('pop-error', trans('app/alerts.booking_error_fields'));
        }

        Booking::create([
            'unique_id' => htmlspecialchars(Str::random(32)),
            'id' => (new Snowflake)->id(),
            'user_id' => auth()->user()->id,
            'vatsim_id' => auth()->user()->vatsim_id,
            'position' => htmlspecialchars($request->get('positionselect')),
            'date' => htmlspecialchars($request->get('bookingdate')),
            'time' => htmlspecialchars($request->get('starttime')) . ' - ' . htmlspecialchars($request->get('endtime')),
            'start_time' => htmlspecialchars($request->get('starttime')),
            'end_time' => htmlspecialchars($request->get('endtime')),
            'training' => false,
        ]);
        $booking = Booking::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->first();
        return redirect('http://vatbook.euroutepro.com/atc/insert.asp?Local_URL='.$redirectURI.'&Local_ID=' . $booking->id . '&b_day=' . substr($booking->date, 0, 2) . '&b_month=' . substr($booking->date, 3, 2) . '&b_year=' . substr($booking->date, 6, 10) . '&Controller=' . auth()->user()->fname . '%20' . auth()->user()->lname . '&Position=' . $booking->position .  '&sTime='  . substr($booking->start_time, 0, 2) . substr($booking->start_time, 3) . '&eTime=' . substr($booking->end_time, 0, 2) . substr($booking->end_time, 3) . '&T=' . $booking->training . '&E=0&voice=1');
    }

    public function validateBooking(Request $request)
    {
        $booking = Booking::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
        $booking->vatbook_id = $request->EU_ID;
        $booking->save();

        if ((new Utilities)->checkEmailPreference(auth()->user()->id, 'atc_booking') == true) {
            event(new EventNewATCBooking(Auth::user(), [
                'position' => $booking->position,
                'date' => $booking->date,
                'time' => $booking->time,
                'start_time' => $booking->start_time,
                'end_time' => $booking->end_time,
            ]));
        }

        return redirect()->route('app.atc.mybookings', app()->getLocale())->with('toast-success', trans('app/alerts.success_book', ['POSITION' => $booking->position]));
    }

    public function deleteBooking($locale, $bid)
    {
        $redirectURI = route('do.atc.bookingdel.validate', app()->getLocale());
        $booking = Booking::where('unique_id', $bid)->first();
        if (!$booking->vatsim_id == auth()->user()->vatsim_id) {
            return redirect()->back();
        }

        return redirect('http://vatbook.euroutepro.com/atc/delete.asp?Local_URL='.$redirectURI.'&EU_ID=' . $booking->vatbook_id . '&Local_ID=' . $booking->id);
    }

    public function validateDelete(Request $request)
    {
        $booking = Booking::where('vatsim_id', auth()->user()->vatsim_id)->where('id', $request->Local_ID)->first();
        if (!is_null($booking)) {
            $dataToSend = [
                'position' => $booking->position,
                'date' => $booking->date,
                'time' => $booking->time,
                'start_time' => $booking->start_time,
                'end_time' => $booking->end_time,
            ];
            $booking->delete();
            try {
                if ((new Utilities)->checkEmailPreference(auth()->user()->id, 'atc_booking') == true) {
                    event(new EventDeleteATCBooking(Auth::user(), $dataToSend));
                }
            } catch (\Throwable $th) {
                dd($th);
            }
        }

        return redirect()->route('app.atc.mybookings', app()->getLocale())->with('toast-success', trans('app/alerts.success_del'));
    }
}
