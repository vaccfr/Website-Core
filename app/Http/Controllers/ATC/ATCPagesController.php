<?php

namespace App\Http\Controllers\ATC;

use App\Http\Controllers\Controller;
use App\Models\ATC\Airport;
use App\Models\ATC\ATCRosterMember;
use App\Models\ATC\Mentor;
use App\Models\ATC\SoloApproval;
use App\Models\Users\User;
use Illuminate\Http\Request;

class ATCPagesController extends Controller
{
    public function atcRoster()
    {
        $rosterMembers = ATCRosterMember::orderBy('vatsim_id', 'ASC')
        ->where('visiting', false)
        ->with('user')
        ->get();

        $visitingAtc = ATCRosterMember::orderBy('vatsim_id', 'ASC')
        ->where('visiting', true)
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
            'visiting_roster' => $visitingAtc,
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

        $info = "";
        $info_form = null;
        if ($request->has('info') && request('info') != "0") {
            $info = "&info=".request('info');
            $info_form = request('info');
        }

        $ctwy = "";
        $ctwy_form = null;
        if ($request->has('ctwy') && request('ctwy') != "0") {
            $ctwy = "&ctwy=".request('ctwy');
            $ctwy_form = request('ctwy');
        }

        $crwy = "";
        $crwy_form = null;
        if ($request->has('crwy') && request('crwy') != "0") {
            $crwy = "&crwy=".request('crwy');
            $crwy_form = request('crwy');
        }
        $baseURL = config('app.url')."/api/atis/\$atiscode/\$deprwy(\$atisairport)/\$arrrwy(\$atisairport)/".$apptype."/".$sid."/?m=\$metar(\$atisairport)".$birds."".$info."".$ctwy."".$crwy;

        $airports = Airport::with('positions')->get();

        return view('app.atc.tools', [
            'url' => $baseURL,
            'apptype' => $apptype_form,
            'sid' => $sid_form,
            'birds' => $birds_form,
            'airport' => $airports,
            'info' => $info_form,
            'crwy' => $crwy_form,
            'ctwy' => $ctwy_form,
        ]);
    }

    public function toolsGenAtis(Request $request)
    {
        $birds = "0";
        if ($request->get('birds') == "on") {
            $birds = "1";
        }
        $info = "0";
        if (!is_null($request->get('info'))) {
            $info = request('info');
        }
        $crwy = "0";
        if (!is_null($request->get('crwy'))) {
            $crwy = request('crwy');
        }
        $ctwy = "0";
        if (!is_null($request->get('ctwy'))) {
            $ctwy = request('ctwy');
        }
        return redirect()->route('app.atc.tools', [
            'locale' => app()->getLocale(),
            'apptype' => $request->get('apptype'),
            'sid' => $request->get('sid'),
            'birds' => $birds,
            'info' => $info,
            'crwy' => $crwy,
            'ctwy' => $ctwy,
        ]);
    }
}
