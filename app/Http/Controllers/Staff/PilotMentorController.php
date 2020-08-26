<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DataHandlers\Utilities;
use App\Mail\Mentoring\RequestRejectMail;
use App\Models\ATC\Airport;
use App\Models\Pilot\PilotMentor;
use App\Models\Pilot\PilotMentoringRequest;
use App\Models\Pilot\PilotStudent;
use App\Models\Pilot\PilotTrainingSession;
use App\Models\Users\User;
use Godruoyi\Snowflake\Snowflake;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $studySessions = config('vatfrance.pilot_progress_'.app()->getLocale());
        $progSteps = 100/(int)count($studySessions);

        $students = PilotStudent::where('mentor_id', auth()->user()->id)
        ->with('user')
        ->with('sessions')
        ->with('mentoringRequest')
        ->get();
        
        return view('app.staff.pilot_mentor_mine', [
            'steps' => $studySessions,
            'progSteps' => $progSteps,
            'students' => $students,
            'studentCount' => count($students),
        ]);
    }

    public function bookSession(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userid' => ['required'],
            'reqdetails' => ['required'],
            'sessiondate' => ['required', 'date_format:d.m.Y'],
            'starttime' => ['required', 'before:endtime', 'date_format:H:i'],
            'endtime' => ['required', 'after:starttime', 'date_format:H:i'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', trans('app/alerts.session_req_error'));
        }

        $newTrSess = PilotTrainingSession::create([
            'id' => (new Snowflake)->id(),
            'student_id' => $request->get('userid'),
            'mentor_id' => auth()->user()->id,
            'description' => $request->get('reqdetails'),
            'date' => $request->get('sessiondate'),
            'time' => $request->get('starttime') . ' - ' . $request->get('endtime'),
            'start_time' => $request->get('starttime'),
            'end_time' => $request->get('endtime'),
            'requested_by' => 'Mentor ('.auth()->user()->fname.' '.auth()->user()->lname.')',
            'accepted_by_student' => false,
            'accepted_by_mentor' => true,
            'status' => 'Awaiting student approval',
            'mentor_comment' => $request->get('reqcomment'),
        ]);

        // $student = User::where('id', $request->get('userid'))->first();
        // if (!is_null($student)) {
        //     if ((new Utilities)->checkEmailPreference($student->id, 'atc_mentoring') == true) {
        //         event(new EventNewAtcSession($student, [
        //             'mentor_fname' => $student->fname,
        //             'position' => $newTrSess['position'],
        //             'date' => $newTrSess['date'],
        //             'time' => $newTrSess['time'],
        //         ]));
        //     }
        // }

        return redirect()->route('app.staff.pilot.mine', app()->getLocale())->with('toast-success', trans('app/alerts.sessions_req_succ'));
    }

    public function acceptSession(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sessionid' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', trans('app/alerts.error_occured'));
        }

        $session = PilotTrainingSession::where('id', $request->get('sessionid'))->firstOrFail();
        $session->status = "Confirmed";
        $session->accepted_by_mentor = true;
        $session->save();

        return redirect()->route('app.staff.pilot.mine', app()->getLocale())->with('toast-success', trans('app/alerts.session_accepted'));
    }

    public function cancelSession(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sessionid' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', trans('app/alerts.error_occured'));
        }

        $session = PilotTrainingSession::where('id', $request->get('sessionid'))->firstOrFail();
        $session->delete();

        return redirect()->route('app.staff.pilot.mine', app()->getLocale())->with('toast-success', trans('app/alerts.session_cancelled'));
    }

    public function completeSession(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sessionid' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', trans('app/alerts.error_occured'));
        }

        $session = PilotTrainingSession::where('id', $request->get('sessionid'))->firstOrFail();
        $session->completed = true;
        $session->status = "Completed, awaiting report";
        $session->save();

        return redirect()->route('app.staff.pilot.mine', app()->getLocale())->with('toast-success', trans('app/alerts.session_completed'));
    }

    public function writeSessionReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sessionid' => ['required'],
            'report_box' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', trans('app/alerts.incorr_args'));
        }

        $dateNow = Carbon::now()->format('d.m.Y - H:i');

        $session = PilotTrainingSession::where('id', $request->get('sessionid'))->firstOrFail();
        $session->mentor_report = $request->get('report_box')." - [Mentor: ".auth()->user()->fname." ".auth()->user()->lname." - ".$dateNow." UTC]";
        $session->status = "Completed";
        $session->save();

        return redirect()->route('app.staff.pilot.mine', app()->getLocale())->with('toast-success', trans('app/alerts.report_added'));
    }

    public function editProgress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userid' => ['required'],
            'stuprogress' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', trans('app/alerts.error_occured'));
        }

        $pilotstudent = PilotStudent::where('id', $request->get('userid'))->firstOrFail();
        $pilotstudent->progress = (int)$request->get('stuprogress');
        $pilotstudent->save();

        return redirect()->route('app.staff.pilot.mine', app()->getLocale())->with('toast-success', trans('app/alerts.progr_edited'));
    }

    public function modifyTraining(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'studentid' => ['required'],
            'trainingtype' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', trans('app/alerts.error_occured'));
        }

        $student = PilotMentoringRequest::where('student_id', request('studentid'))->first();
        if (is_null($student)) {
            return redirect()->back()->with('pop-error', trans('app/alerts.error_occured'));
        }

        $student->training_type = request('trainingtype');
        $student->save();

        return redirect()->route('app.staff.pilot.mine', app()->getLocale())->with('pop-success', trans('app/alerts.solo_deleted'));
    }

    public function terminate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userid' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', trans('app/alerts.error_occured'));
        }

        $mentoring = PilotMentoringRequest::where('student_id', $request->get('userid'))->firstOrFail();
        $pilotstudent = PilotStudent::where('id', $request->get('userid'))->firstOrFail();

        $pilotstudent->mentor_id = null;
        $pilotstudent->active = false;
        $pilotstudent->status = "Waiting for Mentor";
        $pilotstudent->save();

        $mentoring->taken = false;
        $mentoring->mentor_id = null;
        $mentoring->save();

        $mentor = PilotMentor::where('id', auth()->user()->id)->first();
        $mentor->student_count--;
        $mentor->save();

        return redirect()->route('app.staff.pilot.mine', app()->getLocale())->with('pop-success', trans('app/alerts.mentoring_terminated'));
    }
}
