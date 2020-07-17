<?php

namespace App\Http\Middleware\Users;
use Illuminate\Support\Facades\Auth;

use Closure;

class Staff
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
        if (Auth::check() && Auth::user()->is_staff == true) {
            return $next($request);
        } else {
            return redirect()->back();
        }
    }
}
