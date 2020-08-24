<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function dashboard()
    {
        return view('app.staff.news_dashboard');
    }
}
