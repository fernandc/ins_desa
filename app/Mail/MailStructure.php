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

    //public $responderA = "";

    public $archivos = [];

    public $color = "";

    public $params = "";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($titulo,$mensaje,$responder,$archivos,$color,$params)
    {
        $this->subject = $titulo;
        $this->msg = $mensaje;
        //$this->$responderA = $responder;
        $this->archivos = $archivos;
        $this->color = $color;
        $this->params = $params;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->view('Plantilla_Mail.mail')->with("body",$this->msg)->with("head",$this->subject)->with("color",$this->color)->with("params",$this->params);
        if (isset($this->archivos)) {
            foreach ($this->archivos as $path_to) {
                $path = Storage::path($path_to["path"]);
                $email->attach($path);
            }
        }
        return $this;
    }
}
