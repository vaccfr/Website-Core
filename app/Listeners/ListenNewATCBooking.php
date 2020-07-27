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
                            ->description('VatFrance ATC Booking on '.$event->data['position'].' - '.$event->data['date'].' @ '.$event->data['time']);
            
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

        Mail::to($event->user->email)->send(new NewBookingMail($event->user, $event->data, $calendarLinks));
    }
}
