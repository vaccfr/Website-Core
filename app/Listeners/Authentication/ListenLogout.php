<?php

namespace App\Listeners\Authentication;

use App\Events\Authentication\EventLogout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ListenLogout
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
     * @param  EventLogout  $event
     * @return void
     */
    public function handle(EventLogout $event)
    {
        activity('logout')
        ->performedOn($event->user)
        ->causedBy($event->user->id)
        ->log('User '.$event->user->id.' logged out.');
    }
}
