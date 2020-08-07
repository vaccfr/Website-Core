<?php

namespace App\Listeners\Authentication;

use App\Events\Authentication\EventLogin;
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
        // dd($event, $event->user, $event->user->id);
        activity('login')
        ->performedOn($event->user)
        ->causedBy($event->user->id)
        ->log('User '.$event->user->id.' authenticated.');

        $event->user->last_login = Carbon::now();
        $event->user->login_ip = $event->ip;
        $event->user->save();
    }
}
