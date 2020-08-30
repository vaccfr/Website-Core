<?php

namespace App\Http\Controllers\ATC;

use App\Events\EventDeleteATCBooking;
use App\Events\EventNewATCBooking;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DataHandlers\Utilities;
use App\Models\ATC\Airport;
use App\Models\ATC\ATCStation;
use App\Models\ATC\Booking;
use App\Models\ATC\MentoringRequest;
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
        for ($i=1; $i < 15; $i++) { 
            $day = Carbon::now()->addDays($i)->format('D. d/m');
            array_push($allDates, $day);
        }

        $bookingToday = Booking::whereDate('start_date', Carbon::now()->format('Y-m-d'))
        ->with('user')
        ->get();
        array_push($allBookings, $bookingToday);
        for ($i=1; $i < 15; $i++) { 
            $booking = Booking::whereDate('start_date', Carbon::now()
            ->addDays($i)
            ->format('Y-m-d'))
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
        $positions = Airport::orderBy('city', 'ASC')
        ->with(['positions' => function($q) {
            $q->whereIn('rank', app(Utilities::class)->getAuthedRanks(auth()->user()->atc_rating_short));
        }])
        ->with(['positions' => function($q) {
            $q->whereIn('solo_rank', app(Utilities::class)->getAuthedRanks(auth()->user()->atc_rating_short));
        }])
        ->get();

        $bookingToday = Booking::whereDate('start_date', Carbon::now()->format('Y-m-d'))
        ->with('user')
        ->get();

        $myBookings = Booking::where('vatsim_id', auth()->user()->vatsim_id)
        ->where('start_date', '>=', Carbon::now()->format('Y-m-d H:i:s'))
        ->get();

        $mentoring = MentoringRequest::where('student_id', auth()->user()->id)->with('mentorUser')->first();
        if (!is_null($mentoring)) {
            $isMentored = true;
            $mentorName = $mentoring->mentorUser->fname.' '.$mentoring->mentorUser->lname;
        } else {
            $isMentored = false;
            $mentorName = null;
        }

        return view('app.atc.mybookings', [
            'positions' => $positions,
            'myBookings' => $myBookings,
            'isMentored' => $isMentored,
            'mentorName' => $mentorName,
            'bookingToday' => $bookingToday,
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
        if ($request->has('ismentoring')) {
            if (request('ismentoring') == "on") {
                $hasMentoring = true;
                $hasMentoringVB = 1;
            }
        } else {
            $hasMentoring = false;
            $hasMentoringVB = 0;
        }
        $bookingOnDay = Booking::whereDate('start_date', date_create_from_format('d.m.Y H:i', request('bookingdate').' '.request('starttime'))->format('Y-m-d'))->get();
        $deny = false;
        $startHour = date_create_from_format('H:i', request('starttime'))->format('H');
        $startMin = date_create_from_format('H:i', request('starttime'))->format('i');
        $endHour = date_create_from_format('H:i', request('endtime'))->format('H');
        $endMin = date_create_from_format('H:i', request('endtime'))->format('i');
        foreach ($bookingOnDay as $i => $b) {
            if ($b['position'] == request('positionselect')) {
                $bStartHour = date_create_from_format('Y-m-d H:i:s', $b['start_date'])->format('H');
                $bStartMin = date_create_from_format('Y-m-d H:i:s', $b['start_date'])->format('i');
                $bEndMin = date_create_from_format('Y-m-d H:i:s', $b['end_date'])->format('i');
                $bEndHour = date_create_from_format('Y-m-d H:i:s', $b['end_date'])->format('H');

                if ($startHour >= $bStartHour && $startHour <= $bEndHour) {
                    if ($startMin >= $bStartMin && $startMin <= $bEndMin) {
                        $deny = true;
                    }
                }
                if ($endHour <= $bEndHour && $endHour >= $bStartHour) {
                    if ($endMin >= $bEndMin && $endMin <= $bStartMin) {
                        $deny = true;
                    }
                }
            }
        }
        if ($deny == true) {
            return redirect()->back()->with('pop-error', 'Cette position est déjà prise à cette date.');
        }

        $startTimestamp = date_create_from_format('d.m.Y H:i', request('bookingdate').' '.request('starttime'))->format('Y-m-d H:i:s');
        $endTimestamp = date_create_from_format('d.m.Y H:i', request('bookingdate').' '.request('endtime'))->format('Y-m-d H:i:s');

        Booking::create([
            'unique_id' => htmlspecialchars(Str::random(32)),
            'id' => (new Snowflake)->id(),
            'user_id' => auth()->user()->id,
            'vatsim_id' => auth()->user()->vatsim_id,
            'position' => htmlspecialchars($request->get('positionselect')),
            'start_date' => $startTimestamp,
            'end_date' => $endTimestamp,
            'training' => $hasMentoring,
        ]);

        $booking = Booking::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->first();
        return redirect('http://vatbook.euroutepro.com/atc/insert.asp?Local_URL='.$redirectURI
                        .'&Local_ID='.$booking->id
                        .'&b_day='.date_create_from_format('Y-m-d H:i:s', $booking->start_date)->format('d')
                        .'&b_month='.date_create_from_format('Y-m-d H:i:s', $booking->start_date)->format('m')
                        .'&b_year='.date_create_from_format('Y-m-d H:i:s', $booking->start_date)->format('Y')
                        .'&Controller='.auth()->user()->fname.' '.auth()->user()->lname
                        .'&Position='.$booking->position
                        .'&sTime='.date_create_from_format('Y-m-d H:i:s', $booking->start_date)->format('Hi')
                        .'&eTime='.date_create_from_format('Y-m-d H:i:s', $booking->end_date)->format('Hi')
                        .'&T='.$hasMentoringVB
                        .'&E=0&voice=1'
                    );
    }

    public function validateBooking(Request $request)
    {
        $booking = Booking::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first();
        $booking->vatbook_id = $request->EU_ID;
        $booking->save();

        if ((new Utilities)->checkEmailPreference(auth()->user()->id, 'atc_booking') == true) {
            event(new EventNewATCBooking(Auth::user(), [
                'position' => $booking->position,
                'date' => date_create_from_format('Y-m-d H:i:s', $booking->start_date)->format('d.m.Y'),
                'time' => date_create_from_format('Y-m-d H:i:s', $booking->start_date)->format('H:i').' '.date_create_from_format('Y-m-d H:i:s', $booking->end_date)->format('H:i'),
                'start_time' => date_create_from_format('Y-m-d H:i:s', $booking->start_date)->format('H:i'),
                'end_time' => date_create_from_format('Y-m-d H:i:s', $booking->end_date)->format('H:i'),
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

        return redirect('http://vatbook.euroutepro.com/atc/delete.asp?Local_URL='.$redirectURI
            .'&EU_ID='.$booking->vatbook_id
            .'&Local_ID=' . $booking->id
        );
    }

    public function validateDelete(Request $request)
    {
        $booking = Booking::where('vatsim_id', auth()->user()->vatsim_id)->where('id', $request->Local_ID)->first();
        if (!is_null($booking)) {
            $dataToSend = [
                'position' => $booking->position,
                'date' => date_create_from_format('Y-m-d H:i:s', $booking->start_date)->format('d.m.Y'),
                'time' => date_create_from_format('Y-m-d H:i:s', $booking->start_date)->format('H:i').' '.date_create_from_format('Y-m-d H:i:s', $booking->end_date)->format('H:i'),
                'start_time' => date_create_from_format('Y-m-d H:i:s', $booking->start_date)->format('H:i'),
                'end_time' => date_create_from_format('Y-m-d H:i:s', $booking->end_date)->format('H:i'),
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
