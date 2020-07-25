<?php

namespace App\Http\Controllers\Landingpage;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DataHandlers\VatsimDataController;
use App\Models\ATC\ATCRequest;
use App\Models\ATC\Booking;
use Godruoyi\Snowflake\Snowflake;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    public function index()
    {
        $bookingsToday = Booking::where('date', Carbon::now()->format('d.m.Y'))
        ->with('user')
        ->get();
        $bookingsTomorrow = Booking::where('date', Carbon::now()
        ->addDays(1)
        ->format('d.m.Y'))
        ->with('user')
        ->get();
        $bookingsAfterTomorrow = Booking::where('date', Carbon::now()
        ->addDays(2)
        ->format('d.m.Y'))
        ->with('user')
        ->get();
        $dayToday = Carbon::now()->format('D. d/m');
        $dayTomorrow = Carbon::now()->addDays(1)->format('D. d/m');
        $dayAfterTomorrow = Carbon::now()->addDays(2)->format('D. d/m');
        $onlineATC = app(VatsimDataController::class)->getOnlineATC();
        return view('landingpage.index', [
            'book0' => $bookingsToday,
            'book1' => $bookingsTomorrow,
            'book2' => $bookingsAfterTomorrow,
            'day0' => $dayToday,
            'day1' => $dayTomorrow,
            'day2' => $dayAfterTomorrow,
            'atconline' => $onlineATC,
        ]);
    }

    public function events()
    {
        // return view('landingpage.events');
        return redirect()->back()->with('toast-info', 'This page is not yet available');
    }

    public function contact()
    {
        return view('landingpage.contact');
    }

    public function reqatc()
    {
        return view('landingpage.reqatc');
    }

    public function reqatcForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'cid' => ['required', 'integer'],
            'email' => ['required', 'email'],
            'event_name' => ['required'],
            'event_date' => ['required'],
            'sponsors' => ['required'],
            'website' => ['required'],
            'dep' => ['required'],
            'arr' => ['required'],
            'positions' => ['required'],
            'pilots' => ['required'],
            'route' => ['required'],
            'message' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', 'An error occured. Make sure you filled all the fields properly.');
        }

        ATCRequest::create([
            'id' => (new Snowflake)->id(),
            'name' => $request->get('name'),
            'vatsim_id' => $request->get('cid'),
            'email' => $request->get('email'),
            'event_name' => $request->get('event_name'),
            'event_date' => $request->get('event_date'),
            'event_sponsors' => $request->get('sponsors'),
            'event_website' => $request->get('website'),
            'dep_airport_and_time' => $request->get('dep'),
            'arr_airport_and_time' => $request->get('arr'),
            'requested_positions' => $request->get('positions'),
            'expected_pilots' => $request->get('pilots'),
            'route' => $request->get('route'),
            'message' => $request->get('message'),
        ]);

        return redirect()->route('landingpage.home.reqatc', app()->getLocale())->with('pop-success', 'Your request was submitted successfully and a receipt was sent to your email. We will get back to you as soon as we can.');
    }

    public function policies()
    {
        return view('landingpage.statutes_policies');
    }
}
