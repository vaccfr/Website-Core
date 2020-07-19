<?php

namespace App\Http\Controllers\ATC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ATCPagesController extends Controller
{
    public function loas()
    {
        return view('app.atc.loas');
    }
}
