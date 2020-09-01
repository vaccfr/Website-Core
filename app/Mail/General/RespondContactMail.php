<?php

namespace App\Mail\General;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RespondContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $question, $response)
    {
        $this->user = $user;
        $this->question = $question;
        $this->response = $response;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('Mail/General/RespondContactEmail', [
            'question' => $this->question,
            'response' => $this->response,
            'user' => $this->user,
        ])
        ->subject('VATFrance - Response');
    }
}
