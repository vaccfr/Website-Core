<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\ATC\ATCStudent;
use App\Models\ATC\Mentor;
use App\Models\ATC\MentoringRequest;
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
        ->with(['sessions' => function($q) {
            return $q->where('date', Carbon::now()->addMonth());
        }])
        ->with('mentoringRequest')
        ->get();

        // dd($students[0]['sessions']);
        
        return view('app.staff.atc_mentor_mine', [
            'steps' => $studySessions,
            'progSteps' => $progSteps,
            'students' => $students,
        ]);
    }

    public function bookSession(Request $request)
    {
        return redirect()->route('app.staff.atc.mine', app()->getLocale())->with('toast-success', 'Mentoring session booked!');
    }
}
