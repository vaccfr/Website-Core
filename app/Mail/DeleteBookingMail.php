<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeleteBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('Mail/DeleteBookingEmail', [
            'user' => $this->user,
            'data' => $this->data,
        ])
        ->subject('ATC Bookings - Suppression de Booking');
    }
}
