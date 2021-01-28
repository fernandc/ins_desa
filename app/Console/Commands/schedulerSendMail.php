<?php

namespace App\Console\Commands;

use App\Mail\MailStructure;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;

class schedulerSendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedulerSendMail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Proceso de envío de correo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //Log::debug('Executado :'.date("Y/m/d H:i:s"));
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'mails_sended'
        );
        $response1 = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
        $mails = json_decode($response1->body(), true);
        foreach ($mails as $mail) {
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'mails_sended_to',
                'data' => ['id_mail' => $mail["id_mail"]]
            );
            $response2 = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $recipents = json_decode($response2->body(), true);
            foreach ($recipents as $to ) {
                if ($to["send_status"]=="CARGANDO"){
                    $dbdate = strtotime($to["fecha_para"]);
                    $datecomp = date('Y-m-d H:i:s',$dbdate);
                    $dbdate2 = strtotime($to["fecha_emision"]);
                    $datesend = date('Y-m-d H:i:s',$dbdate2);
                    $attach=null;
                    $mensaje = "";
                    if($to["team"]=="ALUMNO"){
                        $mensaje = str_replace("@apoderado",$to["name"],$mail["mensaje"]);
                        $mensaje = str_replace("@Apoderado",$to["name"],$mail["mensaje"]);
                        $mensaje = str_replace("@alumno",$to["student"],$mail["mensaje"]);
                        $mensaje = str_replace("@Alumno",$to["student"],$mail["mensaje"]);
                        $mensaje = str_replace("@curso",$to["grade"],$mail["mensaje"]);
                        $mensaje = str_replace("@Curso",$to["grade"],$mail["mensaje"]);
                        $mensaje = str_replace("@hoy",$datesend,$mail["mensaje"]);
                        $mensaje = str_replace("@Hoy",$datesend,$mail["mensaje"]);
                    }else{
                        $mensaje = $mail["mensaje"];
                    }
                    $color = "";
                    $tipo = $mail["tipo_mail"];
                    if($tipo == 1){
                        $color = "#007bff";
                    }elseif($tipo == 2){
                        $color = "#17a2b8";
                    }elseif($tipo == 3){
                        $color = "#28a745";
                    }elseif($tipo == 4){
                        $color = "#dc3545";
                    }
                    $flag = false;
                    if ($to["fecha_para" == null]) {
                        $flag = true;
                        Mail::to($to["email"])->queue(new MailStructure($mail["titulo"],$mail["mensaje"],$mail["email_staff"],$attach,$color));
                    }elseif(date("Y-m-d H:i:s") >= $datecomp){
                        $flag = true;
                        Mail::to($to["email"])->queue(new MailStructure($mail["titulo"],$mensaje,$mail["email_staff"],$attach,$color));
                    }
                    if($flag){
                        $arr = array(
                            'institution' => getenv("APP_NAME"),
                            'public_key' => getenv("APP_PUBLIC_KEY"),
                            'method' => 'update_sended',
                            'data' => ['id' => $to["id"]]
                        );
                        Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
                    }
                }
            }
        }
    }
}
