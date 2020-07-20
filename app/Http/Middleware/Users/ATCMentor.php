<?php

namespace App\Http\Middleware\Users;
use Illuminate\Support\Facades\Auth;

use Closure;

class ATCMentor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isAtcMentor() == true) {
            return $next($request);
        } else {
            return redirect()->back();
        }
    }
}
