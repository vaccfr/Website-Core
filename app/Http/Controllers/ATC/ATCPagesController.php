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

    public function tools(Request $request)
    {
        $apptype = "APPROACHTYPE";
        $apptype_form = null;
        if ($request->has('apptype')) {
            $apptype = request('apptype');
            $apptype_form = request('apptype');
        }

        $sid = "SID";
        $sid_form = null;
        if ($request->has('sid')) {
            $sid = request('sid');
            $sid_form = request('sid');
        }

        $birds = "";
        $birds_form = false;
        if ($request->has('birds') && request('birds') == "1") {
            $birds = "&birds=1";
            $birds_form = true;
        }
        $baseURL = config('app.url')."/api/atis/\$atiscode/\$deprwy(\$atisairport)/\$arrrwy(\$atisairport)/".$apptype."/".$sid."/?m=\$metar(\$atisairport)".$birds;

        return view('app.atc.tools', [
            'url' => $baseURL,
            'apptype' => $apptype_form,
            'sid' => $sid_form,
            'birds' => $birds_form,
        ]);
    }

    public function toolsGenAtis(Request $request)
    {
        $birds = "0";
        if ($request->get('birds') == "on") {
            $birds = "1";
        }
        return redirect()->route('app.atc.tools', [
            'locale' => app()->getLocale(),
            'apptype' => $request->get('apptype'),
            'sid' => $request->get('sid'),
            'birds' => $birds,
        ]);
    }
}
