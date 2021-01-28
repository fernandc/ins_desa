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

    public $replyTo = array();

    public $attachments = array();

    public $color = "";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($titulo,$mensaje,$responder,$archivos,$color)
    {
        $this->subject = $titulo;
        $this->msg = $mensaje;
        $this->replyTo = $responder;
        $this->attachments = $archivos;
        $this->color = $color;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('Plantilla_Mail.mail')->with("body",$msg)->with("head",$subject)->with("color",$color);
    }
}
