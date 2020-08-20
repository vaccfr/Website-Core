<?php

namespace App\Http\Middleware\Users;

use App\Models\Users\DiscordData;
use Closure;
use Illuminate\Support\Facades\Auth;

class BannedUser
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
        $userDiscord = DiscordData::where('user_id', auth()->user()->id)->first();
        if (is_null($userDiscord)) {
            return redirect()->back();
        }
        if ($userDiscord->banned == true) {
            return redirect()->back()->with('toast-error', 'You are banned from VATFrance Discord Server');
        }
        return $next($request);
    }
}
