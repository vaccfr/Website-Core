<?php

namespace App\Http\Middleware\Users;

use App\Models\Users\BannedUser as UsersBannedUser;
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
        $userBan = UsersBannedUser::where('user_id', auth()->user()->id)->first();
        if (!is_null($userBan)) {
            Auth::logout();
            return redirect()->route('landingpage.home', app()->getLocale())->with('toast-error', 'Your account has been restricted.');
        }
        $userDiscord = DiscordData::where('user_id', auth()->user()->id)->first();
        if (!is_null($userDiscord)) {
            if ($userDiscord->banned == true) {
                return redirect()->back()->with('toast-error', 'You are banned from the French vACC Discord Server');
            }
        }
        return $next($request);
    }
}
