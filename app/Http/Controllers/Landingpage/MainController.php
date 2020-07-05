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

    public function atctraining()
    {
        return view('landingpage.index');
    }

    public function atcrequest()
    {
        return view('landingpage.index');
    }

    public function pilottraining()
    {
        return view('landingpage.index');
    }
}
