<?php

namespace App\Http\Middleware\Users;

use App\Models\Admin\Staff;
use Illuminate\Support\Facades\Auth;

use Closure;

class ExecStaff
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
        if (!Auth::check()) {
            return redirect()->back();
        }
        $user = Staff::where('vatsim_id', auth()->user()->vatsim_id)->first();
        if (is_null($user)) {
            return redirect()->back();
        }
        if ($user->executive == false) {
            return redirect()->back();
        }
        return $next($request);
    }
}
