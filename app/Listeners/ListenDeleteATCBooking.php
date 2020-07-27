<?php

namespace App\Listeners;

use App\Events\EventDeleteATCBooking;
use App\Mail\DeleteBookingMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ListenDeleteATCBooking
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
     * @param  EventDeleteATCBooking  $event
     * @return void
     */
    public function handle(EventDeleteATCBooking $event)
    {
        $useremail = $event->user->email;
        if (!is_null($event->user->custom_email)) {
            $useremail = $event->user->custom_email;
        }

        Mail::to($useremail)->send(new DeleteBookingMail($event->user, $event->data));
    }
}
