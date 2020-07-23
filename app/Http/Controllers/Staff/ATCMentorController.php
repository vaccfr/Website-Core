<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DataHandlers\Utilities;
use App\Models\ATC\Airport;
use App\Models\ATC\ATCStudent;
use App\Models\ATC\Mentor;
use App\Models\ATC\MentoringRequest;
use App\Models\ATC\TrainingSession;
use Godruoyi\Snowflake\Snowflake;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ATCMentorController extends Controller
{
    public function allview()
    {
        $applications = MentoringRequest::orderBy('created_at', 'DESC')
        ->with('user')
        ->with('mentor')
        ->with(['mentor.user' => function($query) {
            $query->select('id', 'vatsim_id', 'fname', 'lname');
        }])
        ->get();

        $myMentor = Mentor::where('id', auth()->user()->id)->first();
        $ranks = [];

        foreach (array_keys(config('vatfrance.atc_ranks')) as $r) {
            if (!in_array($myMentor->allowed_rank, $ranks)) {
                array_push($ranks, config('vatfrance.atc_ranks')[$r]);
            }
        }

        $activeStudents = ATCStudent::where('active', true)->get();

        return view('app.staff.atc_mentor_all', [
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
            return redirect()->route('app.staff.atc.all', app()->getLocale());
        }

        $reqid = $request->get('requestid');

        $request = MentoringRequest::where('id', $reqid)->firstOrFail();
        $request->taken = true;
        $request->mentor_id = auth()->user()->id;
        $request->save();

        $student = ATCStudent::where('id', $request->student_id)->firstOrFail();
        $student->mentor_id = auth()->user()->id;
        $student->active = true;
        $student->status = "taken";
        $student->save();

        return redirect()->route('app.staff.atc.all', app()->getLocale())->with('toast-info', trans('app/alerts.training_accepted'));
    }

    public function myStudents()
    {
        $studySessions = config('vatfrance.student_progress_'.app()->getLocale());
        $progSteps = 100/(int)count($studySessions);

        $students = ATCStudent::where('mentor_id', auth()->user()->id)
        ->with('user')
        ->with('sessions')
        ->with('mentoringRequest')
        ->get();

        $positions = Airport::orderBy('icao', 'ASC')
        ->with(['positions' => function($q) {
            $q->whereIn('solo_rank', app(Utilities::class)->getAuthedRanks(auth()->user()->atc_rating_short));
        }])
        ->get();

        // dd($students[0]['user']);
        
        return view('app.staff.atc_mentor_mine', [
            'steps' => $studySessions,
            'progSteps' => $progSteps,
            'students' => $students,
            'positions' => $positions,
        ]);
    }

    public function bookSession(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userid' => ['required'],
            'reqposition' => ['required'],
            'sessiondate' => ['required', 'date_format:d.m.Y'],
            'starttime' => ['required', 'before:endtime', 'date_format:H:i'],
            'endtime' => ['required', 'after:starttime', 'date_format:H:i'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', 'Session could not be requested. Please fill all required fields');
        }

        // dd(htmlspecialchars($request->get('sessiondate')));

        TrainingSession::create([
            'id' => (new Snowflake)->id(),
            'student_id' => $request->get('userid'),
            'mentor_id' => auth()->user()->id,
            'position' => htmlspecialchars($request->get('reqposition')),
            'date' => htmlspecialchars($request->get('sessiondate')),
            'time' => htmlspecialchars($request->get('starttime')) . ' - ' . htmlspecialchars($request->get('endtime')),
            'start_time' => htmlspecialchars($request->get('starttime')),
            'end_time' => htmlspecialchars($request->get('endtime')),
            'requested_by' => 'Mentor ('.auth()->user()->fname.' '.auth()->user()->lname.')',
            'accepted_by_student' => false,
            'accepted_by_mentor' => true,
            'status' => 'Awaiting student approval',
            'mentor_comment' => htmlspecialchars($request->get('reqcomment')),
        ]);

        return redirect()->route('app.staff.atc.mine', app()->getLocale())->with('toast-success', 'Mentoring session requested!');
    }

    public function acceptSession(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sessionid' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', 'Error occured');
        }

        $session = TrainingSession::where('id', $request->get('sessionid'))->firstOrFail();
        $session->status = "Confirmed";
        $session->accepted_by_mentor = true;
        $session->save();

        return redirect()->route('app.staff.atc.mine', app()->getLocale())->with('toast-success', 'Session accepted');
    }

    public function cancelSession(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sessionid' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', 'Error occured');
        }

        $session = TrainingSession::where('id', $request->get('sessionid'))->firstOrFail();
        $session->delete();

        return redirect()->route('app.staff.atc.mine', app()->getLocale())->with('toast-success', 'Session cancelled');
    }
}
