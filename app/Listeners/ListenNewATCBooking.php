<?php

namespace App\Listeners;

use App\Events\EventNewATCBooking;
use App\Mail\NewBookingMail;
use DateTime;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ListenNewATCBooking
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
     * @param  EventNewATCBooking  $event
     * @return void
     */
    public function handle(EventNewATCBooking $event)
    {
        try {
            $from = DateTime::createFromFormat('d.m.Y H:i', $event->data['date']." ".$event->data['start_time']);
            $to = DateTime::createFromFormat('d.m.Y H:i', $event->data['date']." ".$event->data['end_time']);
            $link = \Spatie\CalendarLinks\Link::create($event->data['position'].' - VatFrance ATC', $from, $to)
                            ->description('VATFrance Booking ATC sur '.$event->data['position'].' - '.$event->data['date'].' @ '.$event->data['time'])
                            ->address($event->data['position'].' - VATSIM');
            
            $calendarLinks = [
                'ics' => $link->ics(),
                'google' => $link->google(),
            ];
        } catch (\Throwable $th) {
            $calendarLinks = [
                'ics' => null,
                'google' => null,
            ];
        }

        $useremail = $event->user->email;
        if (!is_null($event->user->custom_email)) {
            $useremail = $event->user->custom_email;
        }

        Mail::to($useremail)->send(new NewBookingMail($event->user, $event->data, $calendarLinks));
    }
}
