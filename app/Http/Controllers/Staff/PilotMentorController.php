<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Mail\Mentoring\RequestRejectMail;
use App\Models\ATC\Airport;
use App\Models\Pilot\PilotMentor;
use App\Models\Pilot\PilotMentoringRequest;
use App\Models\Pilot\PilotStudent;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PilotMentorController extends Controller
{
    public function allview()
    {
        $applications = PilotMentoringRequest::orderBy('created_at', 'DESC')
        ->with('user')
        ->with('mentor')
        ->with(['mentor.user' => function($query) {
            $query->select('id', 'vatsim_id', 'fname', 'lname');
        }])
        ->get();

        $myMentor = PilotMentor::where('id', auth()->user()->id)->first();
        $ranks = [];

        foreach (array_keys(config('vatfrance.pilot_ranks')) as $r) {
            if (!in_array($myMentor->allowed_rank, $ranks)) {
                array_push($ranks, config('vatfrance.pilot_ranks')[$r]);
            }
        }

        $activeStudents = PilotStudent::where('active', true)->get();

        return view('app.staff.pilot_mentor_all', [
            'apps' => $applications,
            'me' => $myMentor,
            'choosable_ranks' => $ranks,
            'appsCount' => count($applications),
            'activeCount' => count($activeStudents),
        ]);
    }

    public function takeTraining(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'requestid' => ['required'],
        ]);
        if ($validator->fails()) {
            return redirect()->route('app.staff.pilot.all', app()->getLocale());
        }

        $reqid = $request->get('requestid');

        $request = PilotMentoringRequest::where('id', $reqid)->firstOrFail();
        $request->taken = true;
        $request->mentor_id = auth()->user()->id;
        $request->save();

        $student = PilotStudent::where('id', $request->student_id)->firstOrFail();
        $student->mentor_id = auth()->user()->id;
        $student->active = true;
        $student->status = "In Training";
        $student->save();

        $mentor = PilotMentor::where('id', auth()->user()->id)->first();
        $mentor->student_count++;
        $mentor->save();

        return redirect()->route('app.staff.pilot.all', app()->getLocale())->with('toast-info', trans('app/alerts.training_accepted'));
    }

    public function rejectTraining(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'requestid' => ['required'],
            'msgbody' => ['required'],
        ]);
        if ($validator->fails()) {
            return redirect()->route('app.staff.pilot.all', app()->getLocale());
        }

        $reqid = $request->get('requestid');

        $request = PilotMentoringRequest::where('id', $reqid)->firstOrFail();
        $userid = $request->student_id;
        $request->delete();

        $student = PilotStudent::where('id', $request->student_id)->firstOrFail();
        $student->delete();

        // $user = User::where('id', $userid)->first();
        // if (!is_null($user)) {
        //     Mail::to(config('vatfrance.ATC_staff_email'))->send(new RequestRejectMail(
        //         $user, [
        //             'student' => $user->fname.' '.$user->lname.' - '.$user->vatsim_id,
        //             'rejector' => auth()->user()->fname.' '.auth()->user()->lname,
        //             'body' => request('msgbody'),
        //         ]
        //     ));

        //     $useremail = $user->email;
        //     if (!is_null($user->custom_email)) {
        //         $useremail = $user->custom_email;
        //     }
        //     Mail::to($useremail)->send(new RequestRejectMail(
        //         $user, [
        //             'student' => $user->fname.' '.$user->lname.' - '.$user->vatsim_id,
        //             'rejector' => auth()->user()->fname.' '.auth()->user()->lname,
        //             'body' => request('msgbody'),
        //         ]
        //     ));
        // }

        return redirect()->route('app.staff.pilot.all', app()->getLocale())->with('toast-info', trans('app/alerts.training_rejected'));
    }

    public function myStudents()
    {
        $studySessions = config('vatfrance.student_progress_'.app()->getLocale());
        $progSteps = 100/(int)count($studySessions);

        $students = PilotStudent::where('mentor_id', auth()->user()->id)
        ->with('user')
        ->with('sessions')
        ->with('mentoringRequest')
        ->get();

        $positions = Airport::orderBy('city', 'ASC')
        ->with(['positions' => function($q) {
            $q->whereIn('solo_rank', app(Utilities::class)->getAuthedRanks(auth()->user()->atc_rating_short));
        }])
        ->get();

        $airports = Airport::orderBy('city', 'ASC')->get();

        // dd($airports[0]);
        
        return view('app.staff.pilot_mentor_mine', [
            'steps' => $studySessions,
            'progSteps' => $progSteps,
            'students' => $students,
            'positions' => $positions,
            'soloLengths' => [],
            'studentCount' => count($students),
            'airports' => $airports
        ]);
    }
}
