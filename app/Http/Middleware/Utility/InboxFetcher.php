<?php

namespace App\Http\Middleware\Utility;

use App\Http\Controllers\DataHandlers\CacheController;
use App\Models\General\InternalMessage;
use Closure;

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
        if (app(CacheController::class)->checkCache('inbox_count', true)) {
            $inbox_count = app(CacheController::class)->getCache('inbox_count', true);
            session()->put('inbox_count', $inbox_count);
        } else {
            $inbox = InternalMessage::orderBy('created_at', 'DESC')
            ->where('recipient_id', auth()->user()->id)
            ->with('recipient')
            ->with('sender')
            ->where('archived', false)
            ->where('trashed', false)
            ->get();
            $inbox_count = count($inbox->where('read', false));
            app(CacheController::class)->putCache('inbox_count', $inbox_count, 300, true);
            session()->put('inbox_count', $inbox_count);
        }
        return $next($request);
    }
}
