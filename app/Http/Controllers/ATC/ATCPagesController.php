<?php

namespace App\Http\Controllers\ATC;

use App\Http\Controllers\Controller;
use App\Models\ATC\ATCStudent;
use Illuminate\Http\Request;

class ATCPagesController extends Controller
{
    public function loas()
    {
        return view('app.atc.loas');
    }
}
