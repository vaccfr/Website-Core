<?php

namespace App\Http\Controllers\ATC;

use App\Http\Controllers\Controller;
use App\Models\ATC\ATCRosterMember;
use App\Models\ATC\ATCStudent;
use App\Models\ATC\Mentor;
use App\Models\ATC\SoloApproval;
use Illuminate\Http\Request;

class ATCPagesController extends Controller
{
    public function atcRoster()
    {
        $rosterMembers = ATCRosterMember::orderBy('vatsim_id', 'ASC')
        ->with('user')
        ->get();

        $mentors = Mentor::orderBy('vatsim_id', 'ASC')
        ->with('user')
        ->get();

        $soloApproved = SoloApproval::orderBy('end_date', 'ASC')
        ->with('user')
        ->with('mentor.user')
        ->with('station')
        ->get();
        return view('app.atc.rosters', [
            'atc_roster' => $rosterMembers,
            'mentors' => $mentors,
            'soloApproved' => $soloApproved,
        ]);
    }

    public function loas()
    {
        return view('app.atc.loas');
    }
}
