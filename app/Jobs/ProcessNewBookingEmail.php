<?php

namespace App\Jobs;

use App\Mail\NewBookingMail;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessNewBookingEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $from = DateTime::createFromFormat('d.m.Y H:i', $this->data['date']." ".$this->data['start_time']);
            $to = DateTime::createFromFormat('d.m.Y H:i', $this->data['date']." ".$this->data['end_time']);
            $link = \Spatie\CalendarLinks\Link::create($this->data['position'].' - VatFrance ATC', $from, $to)
                            ->description('VatFrance ATC Booking on '.$this->data['position'].' - '.$this->data['date'].' @ '.$this->data['time']);
            
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

        Mail::to($this->user->email)->send(new NewBookingMail($this->user, $this->data, $calendarLinks));
    }
}
