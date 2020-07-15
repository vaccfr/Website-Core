<?php

namespace App\Http\Controllers\Landingpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return view('landingpage.index');
    }

    public function policies()
    {
        return view('landingpage.statutes_policies');
    }
}
