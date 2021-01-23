<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailStructure extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "";

    public $msg = "";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail)
    {
        $this->subject = $mail["sub"];
        $this->msg = $mail["msg"];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('Plantilla_Mail.mail');
    }
}
