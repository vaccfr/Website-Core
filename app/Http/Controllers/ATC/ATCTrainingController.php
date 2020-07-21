<?php

namespace App\Http\Controllers\ATC;

use App\Http\Controllers\Controller;
use App\Models\ATC\Airport;
use App\Models\ATC\ATCStudent;
use App\Models\ATC\MentoringRequest;
use Godruoyi\Snowflake\Snowflake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ATCTrainingController extends Controller
{
    public function index()
    {
        $activeStudent = ATCStudent::where('vatsim_id', auth()->user()->vatsim_id)->first();
        $existingRequest = MentoringRequest::where('student_id', auth()->user()->id)->first();
        if (!is_null($activeStudent)) {
            if ($activeStudent->active == true) {
                return view('app.atc.training');
            } else {
                return view('app.atc.training_req', [
                    'show' => "APPLIED",
                ]);
            }
        } else {
            $platforms = Airport::orderBy('icao', 'ASC')->get();
            return view('app.atc.training_req', [
                'platforms' => $platforms,
                'excl' => config('vatfrance.excluded_mentoring_airports'),
                'show' => "NORMAL",
            ]);
        }
        
        if (auth()->user()->subdiv_id !== "FRA") {
            return view('app.atc.training_req', [
                'show' => "NOREGION",
            ]);
        }

        return view('app.atc.training_req', [
            'show' => "ERROR",
        ]);
    }

    public function mentoringRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reqposition' => ['required'],
            'reqmotivation' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('app.atc.training', app()->getLocale());
        } elseif (in_array($request->get('reqposition'), config('vatfrance.excluded_mentoring_airports'))) {
            return redirect()->route('app.atc.training', app()->getLocale());
        }

        MentoringRequest::create([
            'id' => (new Snowflake)->id(),
            'student_id' => auth()->user()->id,
            'icao' => $request->get('reqposition'),
            'motivation' => $request->get('reqmotivation'),
        ]);

        ATCStudent::create([
            'id' => auth()->user()->id,
            'vatsim_id' => auth()->user()->vatsim_id,
        ]);

        return redirect()->route('app.atc.training', app()->getLocale())->with('pop-success', trans('app/alerts.success_application'));
    }
}
