<?php

namespace App\Mail\General;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewFeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $sender, $data)
    {
        $this->user = $user;
        $this->sender = $sender;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('Mail/General/NewFeedbackEmail', [
            'user' => $this->user,
            'sender' => $this->sender,
            'data' => $this->data,
        ])
        ->subject('French vACC - Nouveau Feedback ATC pour '.$this->user->fname.' '.$this->user->lname);
    }
}
