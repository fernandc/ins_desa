<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class MailStructure extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = "";

    public $msg = "";

    //public $replyTo = [];

    public $archivos = [];

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
        $this->archivos = $archivos;
        $this->color = $color;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->view('Plantilla_Mail.mail')->with("body",$this->msg)->with("head",$this->subject)->with("color",$this->color);
        foreach ($this->archivos as $path_to) {
            $path = Storage::path($path_to["path"]);
            $email->attach($path);
        }
        return $email;
    }
}
