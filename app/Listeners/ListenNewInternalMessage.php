<?php

namespace App\Listeners;

use App\Events\EventNewInternalMessage;
use App\Mail\InternalMessageMail;
use App\Models\Users\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ListenNewInternalMessage
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
     * @param  EventNewInternalMessage  $event
     * @return void
     */
    public function handle(EventNewInternalMessage $event)
    {
        $recipientUser = User::where('id', $event->recipient->id)->first();
        if (!is_null($recipientUser)) {
            $useremail = $recipientUser->email;
            if (!is_null($recipientUser->custom_email)) {
                $useremail = $recipientUser->custom_email;
            }

            // EMAIL_STUFF_TO_REPAIR
            Mail::to($useremail)->send(new InternalMessageMail($recipientUser, $event->data));
        }
    }
}
