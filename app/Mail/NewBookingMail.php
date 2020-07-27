<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $data;
    protected $calendarLinks;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $data, $calendarLinks)
    {
        $this->user = $user;
        $this->data = $data;
        $this->calendarLinks = $calendarLinks;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('Mail/NewBookingEmail', [
            'user' => $this->user,
            'data' => $this->data,
            'calendarLinks' => $this->calendarLinks,
        ]);
    }
}
