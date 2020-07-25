<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrgpageController extends Controller
{
    public function staffOrg()
    {
        return view('app.general.org');
    }
}
