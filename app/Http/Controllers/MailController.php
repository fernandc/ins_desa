<?php

namespace App\Http\Controllers;

use App\Mail\MailStructure;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function send_mail(){

        Mail::to("fernando.dc.dex@gmail.com,luciano.grandi.m@gmail.com")->queue(new MailStructure());
        return "Done";
    }

    

    
}
