<?php

namespace App\Listeners;

use App\Events\EventLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;

class ListenLogin
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
     * @param  EventLogin  $event
     * @return void
     */
    public function handle(EventLogin $event)
    {
        $event->user->last_login = Carbon::now();
        $event->user->login_ip = $event->ip;
        $event->user->save();
    }
}
