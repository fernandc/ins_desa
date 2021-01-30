<?php

namespace App\Console\Commands;

use App\Mail\MailStructure;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;

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
            'method' => 'mails_sended_load'
        );
        $response1 = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
        $mails = json_decode($response1->body(), true);
        if(isset($mails)){
            foreach ($mails as $mail) {
                //ATTACHES
                $attach=null;
                $arr = array(
                    'institution' => getenv("APP_NAME"),
                    'public_key' => getenv("APP_PUBLIC_KEY"),
                    'method' => 'mails_sended_attach',
                    'data' => ['id_mail' => $mail["id_mail"]]
                );
                $responseA = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
                $recipentsA = json_decode($responseA->body(), true);
                if(isset($recipentsA)){
                    $attach=$recipentsA;
                }
                //MAIL_TO
                $arr = array(
                    'institution' => getenv("APP_NAME"),
                    'public_key' => getenv("APP_PUBLIC_KEY"),
                    'method' => 'mails_sended_to',
                    'data' => ['id_mail' => $mail["id_mail"]]
                );
                $response2 = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
                $recipents = json_decode($response2->body(), true);
                if(isset($recipents)){
                    $totales = 0;
                    $enviados = 0;
                    foreach ($recipents as $to) {
                        $totales++;
                        if ($to["send_status"]=="ENVIADO") {
                            $enviados++;
                        }
                        if ($to["send_status"]=="CARGANDO"){
                            $dbdate2 = strtotime($mail["fecha_emision"]);
                            $datesend = date('Y-m-d',$dbdate2);
                            $mensaje = "";
                            if($to["team"]=="ALUMNO"){
                                $mensaje = str_replace("@apoderado",$to["name"],$mail["mensaje"]);
                                $mensaje = str_replace("@Apoderado",$to["name"],$mensaje);
                                $mensaje = str_replace("@alumno",$to["student"],$mensaje);
                                $mensaje = str_replace("@Alumno",$to["student"],$mensaje);
                                $mensaje = str_replace("@curso",$to["grade"],$mensaje);
                                $mensaje = str_replace("@Curso",$to["grade"],$mensaje);
                                $mensaje = str_replace("@hoy",$datesend,$mensaje);
                                $mensaje = str_replace("@Hoy",$datesend,$mensaje);
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
                            //hash
                            $hashed = Hash::make($to["id"].$to["email"]);
                            $params = "https://".getenv("APP_URL")."logo_ins/?h=$hashed&key=".$to["id"];
                            //flag
                            $flag = false;
                            date_default_timezone_set("America/Santiago");
                            if ($mail["envio"] == "SEND") {
                                Mail::to($to["email"])->queue(new MailStructure($mail["titulo"],$mensaje,[$mail["email_staff"],$mail["nombre_staff"]],$attach,$color,$params));
                                $flag = true;
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
                    if ($totales==$enviados) {
                        $arr = array(
                            'institution' => getenv("APP_NAME"),
                            'public_key' => getenv("APP_PUBLIC_KEY"),
                            'method' => 'update_all_sended',
                            'data' => ['id_mail' => $mail["id_mail"]]
                        );
                    }
                }
            }
        }
    }
}
