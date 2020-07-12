<?php

namespace App\Http\Middleware;

use App\Models\Users\UserSetting;
use Closure;

class SetLocale
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
        $locale = $request->segment(1);
        if (in_array($locale, config('app.available_locales'))) {
            app()->setLocale($locale);
            if (auth()->check()) {
                $lang = UserSetting::where('vatsim_id', auth()->user()->vatsim_id)->first();
                $lang->update(['lang' => $locale]);
            }
            return $next($request);
        } else {
            return redirect()->back()->with(app()->getLocale());
        }
    }
}
