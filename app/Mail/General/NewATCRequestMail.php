<?php

namespace App\Mail\General;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewATCRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($eventData)
    {
        $this->eventData = $eventData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('Mail/General/NewATCRequestEmail', [
            'eventData' => $this->eventData,
        ])
        ->subject('VATFrance - Nouvelle requête ATC');
    }
}
