<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\ATC\ATCStudent;
use App\Models\ATC\Mentor;
use App\Models\ATC\MentoringRequest;
use Illuminate\Http\Request;
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
        // $studySessions = config('vatfrance.student_progress_'.app()->getLocale());
        $studySessions = config('vatfrance.student_progress_gb');
        $stepsEach = 100/(int)count($studySessions);
        $currentProgress = 3;
        $stepsCurrent = $currentProgress * $stepsEach;
        
        return view('app.staff.atc_mentor_mine', [
            'steps' => $studySessions,
            'progSteps' => $stepsEach,
            'progCurrent' => $stepsCurrent,
        ]);
    }
}
