<?php

namespace App\Http\Controllers\ATC;

use App\Http\Controllers\Controller;
use App\Models\ATC\ATCRosterMember;
use App\Models\ATC\ATCStudent;
use Illuminate\Http\Request;

class ATCPagesController extends Controller
{
    public function atcRoster()
    {
        $rosterMembers = ATCRosterMember::orderBy('vatsim_id', 'ASC')
        ->with('user')
        ->get();
        return view('app.atc.rosters', [
            'atc_roster' => $rosterMembers,
        ]);
    }

    public function loas()
    {
        return view('app.atc.loas');
    }
}
