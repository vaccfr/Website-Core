<?php

namespace App\Http\Middleware\Utility;

use App\Http\Controllers\DataHandlers\CacheController;
use App\Models\General\InternalMessage;
use Closure;
use Illuminate\Support\Facades\Auth;

class InboxFetcher
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
        session()->forget('inbox_count');
        if (Auth::check()) {
            $inbox = InternalMessage::orderBy('created_at', 'DESC')
            ->where('recipient_id', auth()->user()->id)
            ->where('read', false)
            ->where('recipient_archived', false)
            ->where('recipient_trashed', false)
            ->get();
            $inbox_count = count($inbox->where('read', false));
            session()->put('inbox_count', $inbox_count);
        } else {
            session()->put('inbox_count', 0);
        }
        return $next($request);
    }
}
