<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DataHandlers\Utilities;
use App\Models\ATC\Airport;
use App\Models\ATC\ATCStudent;
use App\Models\ATC\Mentor;
use App\Models\ATC\MentoringRequest;
use App\Models\ATC\SoloApproval;
use App\Models\ATC\TrainingSession;
use Godruoyi\Snowflake\Snowflake;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class ATCMentorController extends Controller
{
    public $soloLengths = [15, 30, 45, 60];
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
        $student->status = "In Training";
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
        ->with('soloApprovals')
        ->get();

        $positions = Airport::orderBy('city', 'ASC')
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
            'soloLengths' => $this->soloLengths,
            'studentCount' => count($students),
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
            return redirect()->back()->with('pop-error', trans('app/alerts.session_req_error'));
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

        return redirect()->route('app.staff.atc.mine', app()->getLocale())->with('toast-success', trans('app/alerts.sessions_req_succ'));
    }

    public function acceptSession(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sessionid' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', trans('app/alerts.error_occured'));
        }

        $session = TrainingSession::where('id', $request->get('sessionid'))->firstOrFail();
        $session->status = "Confirmed";
        $session->accepted_by_mentor = true;
        $session->save();

        return redirect()->route('app.staff.atc.mine', app()->getLocale())->with('toast-success', trans('app/alerts.session_accepted'));
    }

    public function cancelSession(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sessionid' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', trans('app/alerts.error_occured'));
        }

        $session = TrainingSession::where('id', $request->get('sessionid'))->firstOrFail();
        $session->delete();

        return redirect()->route('app.staff.atc.mine', app()->getLocale())->with('toast-success', trans('app/alerts.session_cancelled'));
    }

    public function completeSession(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sessionid' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', trans('app/alerts.error_occured'));
        }

        $session = TrainingSession::where('id', $request->get('sessionid'))->firstOrFail();
        $session->completed = true;
        $session->status = "Completed, awaiting report";
        $session->save();

        return redirect()->route('app.staff.atc.mine', app()->getLocale())->with('toast-success', trans('app/alerts.session_completed'));
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

        $session = TrainingSession::where('id', $request->get('sessionid'))->firstOrFail();
        $session->mentor_report = $request->get('report_box')." - [Mentor: ".auth()->user()->fname." ".auth()->user()->lname." - ".$dateNow." UTC]";
        $session->status = "Completed";
        $session->save();

        return redirect()->route('app.staff.atc.mine', app()->getLocale())->with('toast-success', trans('app/alerts.report_added'));
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

        $atcstudent = ATCStudent::where('id', $request->get('userid'))->firstOrFail();
        $atcstudent->progress = (int)$request->get('stuprogress');
        $atcstudent->save();

        return redirect()->route('app.staff.atc.mine', app()->getLocale())->with('toast-success', trans('app/alerts.progr_edited'));
    }

    public function makeSolo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userid' => ['required'],
            'selectpos' => ['required'],
            'startdate' => ['required'],
            'length' => ['required'],
        ]);

        if ($validator->fails() or !in_array($request->get('length'), $this->soloLengths)) {
            return redirect()->back()->with('pop-error', trans('app/alerts.error_occured'));
        }

        $soloSession = SoloApproval::where('student_id', $request->get('userid'))
                        ->where('position', $request->get('selectpos'))
                        ->get();
        // dd(count($soloSession));
        if (!count($soloSession) == 0) {
            return redirect()->back()->with('pop-error', trans('app/alerts.solo_exist_err'));
        }
        SoloApproval::create([
            'id' => (new Snowflake)->id(),
            'student_id' => $request->get('userid'),
            'mentor_id' => auth()->user()->id,
            'position' => $request->get('selectpos'),
            'start_date' => $request->get('startdate'),
            'end_date' => Carbon::parse($request->get('startdate'))->addDays($request->get('length'))->format('d.m.Y'),
        ]);

        return redirect()->route('app.staff.atc.mine', app()->getLocale())->with('pop-success', trans('app/alerts.solo_added', ['POSITION' => $request->get('selectpos')]));
    }

    public function delSolo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'soloid' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', trans('app/alerts.error_occured'));
        }

        $soloSession = SoloApproval::where('id', $request->get('soloid'))->delete();

        return redirect()->route('app.staff.atc.mine', app()->getLocale())->with('pop-success', trans('app/alerts.solo_deleted'));
    }

    public function terminate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userid' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('pop-error', trans('app/alerts.error_occured'));
        }

        $mentoring = MentoringRequest::where('student_id', $request->get('userid'))->firstOrFail();
        $atcstudent = ATCStudent::where('id', $request->get('userid'))->firstOrFail();

        $atcstudent->mentor_id = null;
        $atcstudent->active = false;
        $atcstudent->status = "Waiting for Mentor";
        $atcstudent->save();

        $mentoring->taken = false;
        $mentoring->mentor_id = null;
        $mentoring->save();

        return redirect()->route('app.staff.atc.mine', app()->getLocale())->with('pop-success', trans('app/alerts.mentoring_terminated'));
    }
}
