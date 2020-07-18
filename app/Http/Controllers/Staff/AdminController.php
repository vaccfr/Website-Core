<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Admin\Staff;
use App\Models\ATC\AtcRosterMember;
use App\Models\ATC\Booking;
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

        return view('app.staff.admin-edit', [
            'user' => $user,
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

        $newUser = User::where('id', $request->get('userid'))->firstOrFail();
        return view('app.staff.admin-edit', [
            'user' => $newUser,
        ]);
    }

    public function editUserFormStaff(Request $request)
    {
        $currentUser = User::where('id', $request->get('userid'))->firstOrFail();

        // Edit Staff Status
        switch ($currentUser->is_staff) {
            case false:
                if (!is_null($request->get('staffswitch'))) {
                    $newStaff = Staff::create([
                        'id' => $currentUser->id,
                        'vatsim_id' => $currentUser->vatsim_id,
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


        $newUser = User::where('id', $request->get('userid'))->firstOrFail();
        return view('app.staff.admin-edit', [
            'user' => $newUser,
        ]);
    }
}
