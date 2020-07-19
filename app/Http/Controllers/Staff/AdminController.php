<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Admin\Staff;
use App\Models\ATC\AtcRosterMember;
use App\Models\ATC\Booking;
use App\Models\ATC\Mentor;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        $members = User::get();
        $memberCount = count($members);
        $atcCount = count(AtcRosterMember::get());
        $bookingCount = count(Booking::where('date', Carbon::now()->format('d.m.Y'))->with('user')->get());
        return view('app.staff.admin', [
            'members' => $members,
            'memberCount' => $memberCount,
            'atcCount' => $atcCount,
            'bookingsCount' => $bookingCount,
            'locale' => app()->getLocale(),
        ]);
    }

    public function editUser(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'userid' => 'required',
        ]);

        if ($validated->fails()) {
            return redirect()->back();
        }

        $user = User::where('id', $request->get('userid'))->firstOrFail();

        if ($user->subdiv_id == "FRA") {
            $utypes = config('vatfrance.usertypes');
        } else {
            $utypes = config('vatfrance.visiting_usertypes');
        }

        $ranks = [];
        foreach (array_keys(config('vatfrance.atc_ranks')) as $r) {
            if ((int)$user->atc_rating >= (int)$r) {
                array_push($ranks, config('vatfrance.atc_ranks')[$r]);
            }
        }
        $currentMentorRank = Mentor::where('id', $user->id)->first();
        if (!is_null($currentMentorRank)) {
            $currentMentorRank = $currentMentorRank->allowed_rank;
        }

        return view('app.staff.admin-edit', [
            'user' => $user,
            'usertypes' => $utypes,
            'mentoring_ranks' => $ranks,
            'curr_mentor_rank' => $currentMentorRank,
        ]);
    }

    public function editUserFormDetails(Request $request)
    {
        $currentUser = User::where('id', $request->get('userid'))->firstOrFail();

        switch ($currentUser->is_approved_atc) {
            case true:
                if (is_null($request->get('approveatc'))) {
                    $currentUser->is_approved_atc = false;
                    $currentUser->save();
                }
                break;
            
            case false:
                if (!is_null($request->get('approveatc'))) {
                    $currentUser->is_approved_atc = true;
                    $currentUser->save();
                }
                break;
            
            default:
                break;
        }

        switch ($currentUser->subdiv_id) {
            case 'FRA':
                if (in_array($request->get('editusertype'), config('vatfrance.usertypes'))) {
                    $currentUser->account_type = $request->get('editusertype');
                    $currentUser->save();
                }
                break;
            
            default:
                if (in_array($request->get('editusertype'), config('vatfrance.visiting_usertypes'))) {
                    $currentUser->account_type = $request->get('editusertype');
                    $currentUser->save();
                }
                break;
        }

        return redirect()->route('app.staff.admin.edit', app()->getLocale());
    }

    public function editUserFormStaff(Request $request)
    {
        $currentUser = User::where('id', $request->get('userid'))->firstOrFail();

        // Edit Staff Status
        switch ($currentUser->is_staff) {
            case false:
                if (!is_null($request->get('staffswitch'))) {
                    Staff::updateOrCreate(['vatsim_id' => $currentUser->vatsim_id], [
                        'id' => $currentUser->id,
                        'staff_level' => 0,
                    ]);
                    $currentUser->is_staff = true;
                    $currentUser->save();
                }
                break;
            
            case true:
                if (is_null($request->get('staffswitch'))) {
                    $todel = Staff::where('vatsim_id', $currentUser->vatsim_id)->firstOrFail();
                    $todel->delete();
                    $currentUser->is_staff = false;
                    $currentUser->save();
                }
                break;
            
            default:
                break;
        }

        switch ($currentUser->isAtcMentor()) {
            case false:
                if (!is_null($request->get('atcmentorswitch'))) {
                    Mentor::updateOrCreate(['vatsim_id' => $currentUser->vatsim_id], [
                        'id' => $currentUser->id,
                        'allowed_rank' => $request->get('allowedrank'),
                    ]);
                    $currentUser->save();
                }
                break;
            
            case true:
                if (is_null($request->get('atcmentorswitch'))) {
                    $todel = Mentor::where('vatsim_id', $currentUser->vatsim_id)->firstOrFail();
                    $todel->delete();
                    $currentUser->save();
                }
                break;
            
            default:
                break;
        }


        $newUser = User::where('id', $request->get('userid'))->firstOrFail();
        return redirect()->route('app.staff.admin.edit', app()->getLocale());
    }
}
