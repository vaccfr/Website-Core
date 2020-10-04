<?php

namespace App\Listeners\Mentoring;

use App\Events\Mentoring\EventNewAtcSession;
use App\Mail\Mentoring\NewAtcSessionMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ListenNewAtcSession
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
     * @param  EventNewAtcSession  $event
     * @return void
     */
    public function handle(EventNewAtcSession $event)
    {
        $useremail = $event->user->email;
        if (!is_null($event->user->custom_email)) {
            $useremail = $event->user->custom_email;
        }

        // EMAIL_STUFF_TO_REPAIR
        // Mail::to($useremail)->send(new NewAtcSessionMail($event->user, $event->data));
    }
}
