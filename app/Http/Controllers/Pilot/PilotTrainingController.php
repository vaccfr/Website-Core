<?php

namespace App\Http\Controllers\Pilot;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DataHandlers\Utilities;
use App\Mail\Mentoring\NewRequestMail;
use App\Models\ATC\Airport;
use App\Models\Pilot\PilotMentoringRequest;
use App\Models\Pilot\PilotStudent;
use App\Models\Pilot\PilotTrainingSession;
use App\Models\Users\User;
use Godruoyi\Snowflake\Snowflake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PilotTrainingController extends Controller
{
    public function index()
    {
        $activeStudent = PilotStudent::where('vatsim_id', auth()->user()->vatsim_id)->first();
        $existingRequest = PilotMentoringRequest::where('student_id', auth()->user()->id)->first();
        if (!is_null($activeStudent)) {
            if ($activeStudent->active == true) {
                $studySessions = config('vatfrance.student_progress_'.app()->getLocale());
                $progSteps = 100/(int)count($studySessions);

                $sessions = PilotTrainingSession::where('student_id', $activeStudent->id)
                ->with('mentorUser')
                ->get();

                $positions = Airport::orderBy('city', 'ASC')
                ->with(['positions' => function($q) {
                    $q->whereIn('solo_rank', app(Utilities::class)->getAuthedRanks(auth()->user()->atc_rating_short));
                }])
                ->get();

                if (!is_null($existingRequest)) {
                    $trainingPlatform = $existingRequest->training_type;
                } else {
                    $trainingPlatform = "N/A";
                }

                $mentorObj = User::where('id', $activeStudent->mentor_id)->first();

                return view('app.pilots.training', [
                    'steps' => $studySessions,
                    'progSteps' => $progSteps,
                    'student' => $activeStudent,
                    'sessions' => $sessions,
                    'positions' => $positions,
                    'mentorObj' => $mentorObj,
                    'sessionsCount' => count($sessions),
                    'trainingPlatform' => $trainingPlatform,
                ]);
            } else {
                $mRequest = PilotMentoringRequest::where('student_id', auth()->user()->id)->first();
                return view('app.pilots.training_req', [
                    'show' => "APPLIED",
                    'mRequest' => $mRequest,
                ]);
            }
        } else {
            if (auth()->user()->subdiv_id !== "FRA") {
                return view('app.pilots.training_req', [
                    'show' => "NOREGION",
                ]);
            }
            return view('app.pilots.training_req', [
                'show' => "NORMAL",
            ]);
        }

        return view('app.pilots.training_req', [
            'show' => "ERROR",
        ]);
    }

    public function mentoringRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reqtrainingtype' => ['required'],
            'reqmotivation' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('app.pilot.training', app()->getLocale());
        }

        $consent = true;
        if (is_null($request->get('reqallowmail'))) {
            $consent = false;
        }

        PilotMentoringRequest::create([
            'id' => (new Snowflake)->id(),
            'student_id' => auth()->user()->id,
            'training_type' => $request->get('reqtrainingtype'),
            'motivation' => $request->get('reqmotivation'),
            'mail_consent' => $consent,
        ]);

        PilotStudent::create([
            'id' => auth()->user()->id,
            'vatsim_id' => auth()->user()->vatsim_id,
        ]);

        // Mail::to(config('vatfrance.ATC_staff_email'))->send(new NewRequestMail([
        //     'sender' => auth()->user()->fullname()." - ".auth()->user()->vatsim_id,
        //     'body' => $request->get('reqmotivation'),
        // ]));

        return redirect()->route('app.pilot.training', app()->getLocale())->with('pop-success', trans('app/alerts.success_application'));
    }
}
