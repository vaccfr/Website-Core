<?php

namespace App\Listeners;

use App\Events\EventExceptionLog;
use App\Models\Data\SystemLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class ListenExceptionLog
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EventExceptionLog  $event
     * @return void
     */
    public function handle(EventExceptionLog $event)
    {
        if (!$event->exception->getMessage() == "Unauthenticated.") {
            if (Auth::guest()) {
                SystemLog::exception(2, 1, $event->exception->getMessage(), \Request::url(), $event->exception->getLine(), $event->exception->getFile());
            } else {
                SystemLog::exception(2, Auth::user()->id, $event->exception->getMessage(), \Request::url(), $event->exception->getLine(), $event->exception->getFile());
            }
        }
    }
}
