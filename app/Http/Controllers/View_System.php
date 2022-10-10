<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use PDF;

class View_System extends Controller {
    public function main(request $request) {
        if (!Session::has('account')){
            return redirect('/logout');
        }
        $privileges = $this->user_privileges(Session::get('account')['dni']);
        session::put(['privileges' => $privileges]);
        $path = $request->path();
        $gets = $request->input();
        $message = null;
        if(session::has('message')){
            $message = session::get('message');
            //dd($message);
        }
        if($this->valSession()){
            $this->periods();
            switch ($path) {
                case "home":
                    $scheduler_by_user = $this->list_class_scheduler_by_user();
                    return view('home')->with("scheduler_by_user",$scheduler_by_user);
                    break;
                case "adm_periods":
                    if($this->isAdmin()){
                        $periodo = $this->periods();
                        return view('adm_periods')->with("periods",$periodo)->with("message",$message);
                    }else{
                        return redirect('');
                    }
                case "adm_users":
                    if($this->isAdmin()){
                        $staff = $this->get_personal();
                        return view('adm_users')->with("staff",$staff);
                    }else{
                        return redirect('');
                    }
                case "adm_courses":
                    if($this->isAdmin()){
                        $grades = $this->grades();
                        return view('adm_courses')->with("grades",$grades)->with("message",$message);
                    }else{
                        return redirect('');
                    }
                case "adm_students":
                    if($this->isAdmin()){
                        $curso = 0;
                        if(isset($gets['curso'])){
                            $curso = $gets['curso'];
                        }
                        $students = $this->students($curso);
						$grades = $this->grades();
                        return view('adm_students')->with("students",$students)->with("grades",$grades)->with("message",$message);
                    }else{
                        return redirect('');
                    }
                case "adm_students_norms":
                    if($this->isAdmin()){
                        $curso = 0;
                        if(isset($gets['curso'])){
                            $curso = $gets['curso'];
                        }
                        $students = $this->students($curso);
						$grades = $this->grades();
                        return view('adm_students_norms')->with("students",$students)->with("grades",$grades)->with("message",$message);
                    }else{
                        return redirect('');
                    }
                case "adm_teachers":
                    if($this->isAdmin()){
                        $staff = $this->staff();
                        $grades = $this->grades();
                        //cclass = $this->contarCursosYAsignaturas($staff);
                        //dd($cclass);
                        return view('adm_teachers')->with("staff",$staff)->with("grades",$grades)->with("message",$message);//->with("cclass",$cclass);
                    }else{
                        return redirect('');
                    }
                case "adm_horario":
                    if($this->isAdmin()){
                        $teachers = $this->staff();
						$grades = $this->grades();
                        return view('adm_schedule')->with("grades",$grades)->with("teachers",$teachers);
                    }else{
                        return redirect('');
                    }
                case "adm_subject":
                    if($this->isAdmin()){
                        $subject = $this->subject_list();
                        $subject_current = $this->subject_current_list();                        
                        return view('adm_subject')->with("subject_list",$subject)->with("subject_current_list",$subject_current)->with("message",$message);
                    }else{
                        return redirect('');
                    }
                case "mail_groups":
                    $list_groups = $this->list_groups();
                    $list_students_groups = $this->list_students_groups();
                    return view('mails/groups')->with("list_groups",$list_groups)->with("list_students_groups",$list_students_groups)->with("message",$message);                    
                case "mail_sent_and_tracing_mails":
                    $filter="";
                    if(isset($_GET["filter"])){
                        $flag = false;
                        if($this->isAdmin()){
                            $flag = true;
                        }else{
                            foreach ($privileges as $priv) {
                                if ($priv["id_privilege"] == 11) {
                                    $flag = true;
                                }
                            }
                        }
                        if($flag){
                            $filter = $_GET["filter"];
                        }
                    }
                    $info = $this->info_sent_mails($filter);
                    //dd($info);
                    //$destinatarios = $this->destinatarios_sent_mails($gets);->with("destinatarios",$destinatarios)
                    return view('mails/sent_and_tracing_mails')->with("info_mails",$info);                    
                case "mail_send_mail":
                    $has_priv = false;
                    foreach ($privileges as $priv) {
                        if ($priv["id_privilege"] == 3) {
                            $has_priv = true;
                        }
                    }
                    if($this->isAdmin() || $has_priv){
                        $list_to = $this->list_to();
                        $excCourses = array();
                        if(!$this->isAdmin()){
                            $period = $this->periods()["active_period"];
                            $class = $this->list_checked(Session::get('account')['dni'],$period);
                            //dd($class);
                            foreach($class as $row){
                                array_push($excCourses,$row["id_curso_periodo"]);
                            }
                        }
                        $excCourses= array_unique($excCourses);
                        //dd($excCourses+$list_to);
                        return view('mails/send_mail')->with("lista_para",$list_to)->with("cursos",$excCourses);
                    }else{
                        return back();
                    }
                case "info_assistance_old":
                    $has_priv = false;
                    foreach ($privileges as $priv) {
                        if ($priv["id_privilege"] == 8) {
                            $has_priv = true;
                        }
                    }
                    if($this->isAdmin() || $has_priv){
                        $period = $this->periods()["active_period"];
                        $class = $this->list_checked("all",$period);
                        $curso = 0;
                        $alumnos = [];
                        $enabled_days = [];
                        $assistance_data = [];
                        $horarios = [];
                        if(isset($_GET['curso'])){
                            $curso = $_GET['curso'];
                            $alumnos = $this->matriculas($curso);
                            $year = Session::get('period');
                            $enabled_days = $this->list_class_enabled_days(null,$curso,$year);
                        }
                        return view('info_asistencia')->with("clases",$class)->with("alumnos",$alumnos)->with("dias_activos",$enabled_days)->with("horarios",$horarios);
                    }else{
                        return back();
                    }
                case "info_assistance":
                    $has_priv = false;
                    foreach ($privileges as $priv) {
                        if ($priv["id_privilege"] == 8) {
                            $has_priv = true;
                        }
                    }
                    if($this->isAdmin() || $has_priv){
                        $period = $this->periods()["active_period"];
                        $class = $this->list_checked("all",$period);
                        $curso = 0;
                        $alumnos = [];
                        $enabled_days = [];
                        $assistance_data = [];
                        $horarios = [];
                        if(isset($_GET['curso'])){
                            $curso = $_GET['curso'];
                            $alumnos = $this->matriculas($curso);
                            $year = Session::get('period');
                            $enabled_days = $this->list_class_enabled_days(null,$curso,$year);
                            $arr = array(
                                'institution' => getenv("APP_NAME"),
                                'public_key' => getenv("APP_PUBLIC_KEY"),
                                'method' => 'assistance_student_lite',
                                'data' => [ 'year' => $year, 'id_grade' => $curso ]
                            );
                            $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
                            $data = json_decode($response->body(), true);
                            foreach ($data as $row) {
                                $exploded = explode("_",$row["a"]);
                                $item["id"] = $exploded[0];
                                $item["id_staff"] = $exploded[1];
                                $item["id_student"] = $exploded[2];
                                $item["id_class"] = $exploded[3];
                                $item["id_curso_periodo"] = $exploded[4];
                                $item["id_curso"] = $exploded[5];
                                $item["id_bloq"] = $exploded[6];
                                $item["type_a"] = $exploded[7];
                                $item["assistance"] = $exploded[8];
                                $item["justify"] = $exploded[9];
                                $item["date_in"] = $exploded[10];
                                array_push($assistance_data,$item);
                            }
                        }
                        return view('info_asistencia2')->with("clases",$class)->with("alumnos",$alumnos)->with("dias_activos",$enabled_days)->with("horarios",$horarios)->with("assistance",$assistance_data);
                    }else{
                        return back();
                    }
                case "plan_de_funcionamiento":
                    return view('info_plan_de_funcionamiento');
                case "noticias":            
                    if($this->isAdmin()){
                        $noticias = $this->listar_noticias();
                        return view('adm_news')->with("news",$noticias)->with("message",$message);
                    }else{
                        return redirect('');
                    }
                case "inscriptions":
                    $has_priv = false;
                    foreach ($privileges as $priv) {
                        if ($priv["id_privilege"] == 1) {
                            $has_priv = true;
                        }
                    }
                    $curso = null;
                    if($this->isAdmin() || $has_priv){
                        $has_priv = true;
                        $curso = 0;
                        if(isset($gets['curso'])){
                            $curso = $gets['curso'];
                        }
                    }else{
                        $arr = $this->myCourses();
                        if (count($arr)==1) {
                            $curso = $arr[0]["id_grade"];
                        }else{
                            $curso = null;
                        }
                    }
                    if ($curso === null) {
                        return back();
                    }
                    $students = $this->inscriptions($curso);
                    return view('inscriptions')->with("students",$students)->with("message",$message)->with("has_priv",$has_priv);
                case "students":
                        $has_priv = false;
                        $gen_cert = false;
                        foreach ($privileges as $priv) {
                            if ($priv["id_privilege"] == 1) {
                                $has_priv = true;
                            }
                            if ($priv["id_privilege"] == 15) {
                                $gen_cert = true;
                            }
                        }
                        $curso = null;
                        if($this->isAdmin() || $has_priv){
                            $has_priv = true;
                            $curso = 0;
                            if(isset($gets['curso'])){
                                $curso = $gets['curso'];
                            }
                        }else{
                            $arr = $this->myCourses();
                            if (count($arr)==1) {
                                $curso = $arr[0]["id_grade"];
                            }else{
                                $curso = null;
                            }
                        }
                        if ($curso === null) {
                            return back();
                        }
                        $students = $this->matriculas($curso);
                        $contador = 0;
                        foreach($students as $row){
                            $students[$contador]["hash"] = Crypt::encryptString($row["id_zmail"]."-".$row["id_stu"]."-".$row["para_periodo"]);
                            $contador++;
                        }
                        return view('info_students')->with("students",$students)->with("message",$message)->with("has_priv",$has_priv)->with("gen_cert",$gen_cert);
                case "proxys":
                    $has_priv = false;
                    foreach ($privileges as $priv) {
                        if ($priv["id_privilege"] == 2) {
                            $has_priv = true;
                        }
                    }
                    $curso = null;
                    if($this->isAdmin() || $has_priv){
                        $has_priv = true;
                        $curso = 0;
                        if(isset($gets['curso'])){
                            $curso = $gets['curso'];
                        }
                    }else{
                        $arr = $this->myCourses();
                        if (count($arr)==1) {
                            $curso = $arr[0]["id_grade"];
                        }else{
                            $curso = null;
                        }
                    }
                    if ($curso === null) {
                        return back();
                    }
                    $students = $this->matriculas($curso);
                    return view('proxys')->with("students",$students)->with("message",$message)->with("has_priv",$has_priv);
                case "info_request_1":
                    $has_priv = false;
                    foreach ($privileges as $priv) {
                        if ($priv["id_privilege"] == 4) {
                            $has_priv = true;
                        }
                    }
                    $curso = null;
                    if($this->isAdmin() || $has_priv){
                        $has_priv = true;
                        $curso = 0;
                        if(isset($gets['curso'])){
                            $curso = $gets['curso'];
                        }
                    }else{
                        $arr = $this->myCourses();
                        if (count($arr)==1) {
                            $curso = $arr[0]["id_grade"];
                        }else{
                            $curso = null;
                        }
                    }
                    if ($curso === null) {
                        return back();
                    }
                    $students = $this->matriculas($curso);
                    return view('info_request_1')->with("students",$students)->with("message",$message)->with("has_priv",$has_priv);
                case "timetable":
                    $has_priv = false;
                    foreach ($privileges as $priv) {
                        if ($priv["id_privilege"] == 6) {
                            $has_priv = true;
                        }
                    }
                    if($this->isAdmin() || $has_priv){
                        $cursos = $this->grades();
                        $arr = array(
                            'institution' => getenv("APP_NAME"),
                            'public_key' => getenv("APP_PUBLIC_KEY"),
                            'method' => 'list_schedule_course',
                            'data' => ['id' => 0]
                        );
                        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
                        $data = json_decode($response->body(), true);
                        return view("info_horario_clases")->with("cursos",$cursos)->with("horarios",$data);
                    }
                    return redirect('/home');
                case "checks_points":
                    $has_priv = false;
                    $check_all = false;
                    $can_anr = false;
                    foreach ($privileges as $priv) {
                        if ($priv["id_privilege"] == 5) {
                            $has_priv = true;
                        }
                        if($priv["id_privilege"] == 9){
                            $check_all = true;
                            $has_priv = true;
                        }
                        if($priv["id_privilege"] == 10){
                            $can_anr = true;
                            $has_priv = true;
                        }
                    }
                    if($this->isAdmin() || $has_priv){
                        $class = [];
                        $period = $this->periods()["active_period"];
                        if($this->isAdmin() || $check_all){
                            $class = $this->list_checked("all",$period);
                        }else{
                            $class = $this->list_checked(Session::get('account')['dni'],$period);
                        }
                        if($this->isAdmin()){
                            $can_anr = true;
                        }
                        $curso = 0;
                        $alumnos = [];
                        $enabled_days = [];
                        $assistance_data = [];
                        $horarios = [];
                        $teacher = null;
                        $id_clase = null;
                        if(isset($_GET['curso'])){
                            $curso = $_GET['curso'];
                            if(isset($_GET['materia'])){
                                $id_materia = $gets['materia'];
                                $alumnos = $this->matriculas($curso);
                                if(isset($_GET['profesor'])){
                                    $teacher = $_GET['profesor'];
                                }
                                foreach ($class as $row) {
                                    if($row["id_curso"] == $curso && $row["id_materia"] == $id_materia){
                                        $horarios = $this->list_class_scheduler($row["id_curso_periodo"]);
                                    }
                                }
                                foreach($horarios as $row){
                                    if($row["id_materia"] == $id_materia){
                                        $year = Session::get('period');
                                        $enabled_days = $this->list_class_enabled_days($row["id_clase"],null,$year);
                                        $assistance_data = $this->list_assistance_class($row["id_clase"],null);
                                        $id_clase = $row["id_clase"];
                                    }
                                }
                            }
                        }
                        return view('ldc/asistencia')->with("clases",$class)->with("id_clase",$id_clase)->with("alumnos",$alumnos)->with("dias_activos",$enabled_days)->with("assistance_data",$assistance_data)->with("horarios",$horarios)->with("anr",$can_anr);
                    }
                    return redirect('/home');
                    
                case "fileManager":
                    $has_priv = false;
                    $check_all = false;
                    
                    foreach ($privileges as $priv) {
                        if ($priv["id_privilege"] == 13) {
                            $has_priv = true;
                        }
                        if($priv["id_privilege"] == 14){
                            $check_all = true;
                            $has_priv = true;
                        }
                    }
                    if($this->isAdmin() || $has_priv){
                        $class = [];
                        $year = "";
                        if(isset($_GET["year"])){
                            $year = $_GET["year"];
                        }else{
                            $year = Session::get('period');
                        }
                        if($this->isAdmin() || $check_all){
                            $class = $this->list_checked("all",$year);
                        }else{
                            $class = $this->list_checked(Session::get('account')['dni'],$year);
                        }
                        $curso = 0;
                        $alumnos = [];
                        $horarios = [];
                        $teacher = null;
                        $id_clase = null;
                        $id_curso ="";
                        $id_materia = "";
                        $list_files_fm = [];
                        // dd($class);
                        $periods = [];
                        
                        if(isset($_GET['curso'])){
                            $id_curso = $_GET['curso'];
                            $periods = $this->periods();
                        }
                        if(isset($_GET["materia"])){
                            $id_materia = $_GET["materia"];
                            $path = "public/FileManager/$year/$id_curso/$id_materia";
                            if(isset($_GET["path"])){
                                $flag = false;
                                $explode = explode("/",$_GET["path"]);
                                if($explode[3] != $_GET["curso"]){
                                    $flag = true;
                                }
                                if($explode[4] != $_GET["materia"]){
                                    $flag = true;
                                }
                                if($flag){
                                    return redirect("/fileManager?curso=$id_curso&materia=$id_materia");
                                }
                                $path =  $_GET["path"];
                                $validation = $this->validate_path($path);
                                // dd($validation);
                                if($validation == "NO EXISTE"){
                                    return redirect("/fileManager?curso=$id_curso&materia=$id_materia");
                                }
                            }
                            $list_files_fm = $this->list_files_fm($path);
                        }           
                        // dd($list_files_fm);
                        return view('ldc/file_manager/file_manager')->with("clases",$class)->with("list_files_fm", $list_files_fm)->with("path", $path)->with("selected_year",$year)->with("periods",$periods);
                    }
                    return redirect('/home');
                case "tickets":
                    $all_tickets = null;
                    $arr = array(
                        'institution' => getenv("APP_NAME"),
                        'public_key' => getenv("APP_PUBLIC_KEY"),
                        'method' => 'get_tickets',
                        'data' => ['dni' => Session::get('account')['dni']]
                    );
                    $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
                    $data = json_decode($response->body(), true);
                    $view_all = false;
                    foreach ($privileges as $row) {
                        if($row["id_privilege"] == 12){
                            $view_all = true;
                        }
                    }
                    if($view_all){
                        $arr = array(
                            'institution' => getenv("APP_NAME"),
                            'public_key' => getenv("APP_PUBLIC_KEY"),
                            'method' => 'get_tickets'
                        );
                        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
                        $all_tickets = json_decode($response->body(), true);
                        
                    }
                    return view('tickets')->with('tickets',$data)->with('all_tickets',$all_tickets);
                case "my_info":                    
                    $dni = Session::get('account')['dni'];
                    $data = $this->get_user_data($dni);
                    $banks = $this->get_banks();
                    $certificados = $this->get_certificados($dni);
                    $degree_data = $this->get_user_formation();
                    return view('user/user_base')->with('data',$data)->with('banks',$banks)->with('certificados',$certificados)->with("degree_data", $degree_data);
                default:
                    return view('not_found')->with("path",$path);
            }
        }else{
            return redirect('/logout');
        }
    }
    public function generatePDF(request $request){
        
        $gets = $request->input();
        $crypt = $gets["data"];
        try{
            $qEncoded=Crypt::decryptString($crypt);
        }catch (DecryptException $e){
            return "CODIGO INVALIDO";
        }
        $values = explode("-", $qEncoded);
        $id_apo = $values[0];
        $id_stu = $values[1];
        $year = $values[2];
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'getMatricula',
            'data' => [
                "id_zmail" => $id_apo,
                "id_stu" => $id_stu,
                "year" => $year
            ]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //
        $data[0]["codigo"] = strtoupper(bin2hex(random_bytes(8)));
        $name = str_replace(' ', '_', $data[0]["nombre_stu"]);
        $path = 'public/certificados/alumno_regular/'.$name.'_'.date("Y_m_d").'.pdf';
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'validateStuCertCrypt',
            'data' => [
                "id_zmail" => $id_apo,
                "id_stu" => $id_stu,
                "year" => $year,
                "crypt" => $crypt,
                "code" => $data[0]["codigo"],
                "path" => $path
            ]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $validate = json_decode($response->body(), true);
        $data[0]["endpoint"] = urlencode("https://saintcharlescollege.cl/ins/validar?codigo=".$data[0]["codigo"]);
        //
        $flag = false;
        if($validate != null){
            $data[0]["codigo"] = $validate[0]["code"];
            $data[0]["endpoint"] = urlencode("https://saintcharlescollege.cl/ins/validar?codigo=".$data[0]["codigo"]);
        }else{
            $flag = true;
        }
        $pdf = PDF::loadView('pdf/certificado_alumno_regular', $data[0]);
        if($flag){
            $content = $pdf->download()->getOriginalContent();
            Storage::put($path,$content);
        }
        return $pdf->stream('Certificado Alumno Regular.pdf');
    }
    public function validar(request $request){
        $gets = $request->input();
        $codigo = $gets["codigo"];
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'validateStuCertCode',
            'data' => [
                "code" => $codigo
            ]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $validate = json_decode($response->body(), true);
        if($validate == null){
            return "EL CODIGO NO EXISTE";
        }
        Storage::url($validate[0]["path"]);
        $data = Storage::get($validate[0]["path"]);
        return response()->make($data, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="Certificado Alumno Regular.pdf"'
        ]);
    }
    
    public function modal_ficha(request $request){
        $gets = $request->input();
        $id_stu = $gets["id_stu"];
        $id_apo = $gets["id_apo"];
        $year = $gets["year"];
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'downloadPdf',
            'data' => [
                "id" => $id_stu,
                "id_apo" => $id_apo,
                "year" => $year
            ]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-apoderado");
        $data = json_decode($response->body(), true);
        return view('includes/mdl_ficha')->with("data",$data)->with("year",$year);
    }
    public function iframe_news(){
        //header('Access-Control-Allow-Origin: https://saintcharlescollege.cl/wp/comunicaciones-2021/'); 
        $noticias = $this->listar_noticias();
        return view('iframe_news')->with("news",$noticias);
    }
    private function myCourses(){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'myCourses',
            'data' => ['dni' => Session::get('account')['dni']]
        );
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;
    }
    private function inscriptions($id_curso){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'inscriptions',
            'data' => [ "id_curso" => $id_curso ]
        );
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;
    }
    private function matriculas($id_curso){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'matriculas',
            'data' => [ "id_curso" => $id_curso ]
        );
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;
    }
    private function listar_noticias(){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_news'
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        return $data;       
    }
    private function valSession(){
        if (Session::has('account')){
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'val_session_staff',
                'data' => ['dni' => Session::get('account')['dni']]);
            $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
            $status = $response->json()['status'];
            if($status == false){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }
    private function checkAdmin(){
        if (Session::has('account')){
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'check_is_admin',
                'data' => ['dni' => Session::get('account')['dni']]);
            $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
            $status = $response->json()['status'];
            if($status == false){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }
    private function isAdmin(){
        $validate = $this->checkAdmin();
        if(Session::get('account')['is_admin']=='YES' && $validate){
            return true;
        }else{
            return false;
        }
    }
    private function periods(){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_periods'
        );

        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        if($data["active_period"] != ''){
            Session::put(['period' => $data["active_period"]] );
        }
        else{
            Session::put(['period' => null] );
        }
        return $data;       
    }
    private function get_personal(){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'get_all_personal'
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        return $data;      
    }
    private function staff(){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_staff'
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        return $data;       
    }
    private function grades(){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_grades'
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;       
    }
    private function students_enrollment(){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_students_matriculated'
        );
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;       
    }
    private function students($id_curso){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_students',
            'data' => [ "id_curso" => $id_curso ]
        );
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;       
    }
    private function subject_list(){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_all_matters'
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;       
    }
    private function subject_current_list(){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_matters_in'
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;
    }
    public function modal_privileges(Request $request){
        $gets = $request->input();
        $dni = $gets["dni"];
        $all_privileges = $this->all_privileges();
        $user_privileges = $this->user_privileges($dni);
        return view("includes/mdl_privileges")->with("all_privileges",$all_privileges)->with("user_privileges",$user_privileges)->with("dni",$dni);
    }
    //schedule
    public function show_block(Request $request){
        if(Session::get('account')['is_admin']=='YES'){
            $gets = $request->input();
            //dd($gets);
            $id_curso = $gets["id_curso"];
            $active = $gets["current_course"];
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'list_schedule_course',
                'data' => ['id' => $id_curso]
            );
            //dd($arr);
            $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
            $data = json_decode($response->body(), true);
            //dd($data);  
            $arr2 = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'list_teachers_course',
                'data' => ['id_curso' => $id_curso]
            );
            //dd($arr);
            $response2 = Http::withBody(json_encode($arr2), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
            $data2 = json_decode($response2->body(), true);
            return view("/includes/schedule/sch_course")->with("active", $active)->with("id_curso",$id_curso)->with("sched_course",$data)->with("clase_curso",$data2); 
        }else{
            return ('/');
        }
    }
    public function list_teacher(Request $request){
        if(Session::get('account')['is_admin']=='YES'){
            $gets = $request->input();
            $id_curso = $gets["id_curso"];
            $active = $gets["current_course"];
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'list_teachers_course',
                'data' => [ "id_curso" => $id_curso ]
            );
            $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
            $data = json_decode($response->body(), true);
            $arr2 = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'list_schedule_course',
                'data' => ['id' => $id_curso,]
            );
            //dd($arr);
            $response2 = Http::withBody(json_encode($arr2), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
            $data2 = json_decode($response2->body(), true);
            //dd($data);
            return view("/includes/schedule/sch_teachers")->with("active", $active)->with("id_curso",$id_curso)->with("teacherList",$data)->with("sched_course_t",$data2);
        }else{
            return ('/');
        }
    }
    //
    public function modal_apoderados(Request $request){
        $gets = $request->input();
        $dni = $gets["dni"];
        $apoderado = $this->get_apoderado_by_dni_stu($dni);
        if($apoderado == null){
            return null;
        }
        return view("includes/mdl_apoderado")->with("apoderado",$apoderado);
    }
    public function modal_asignatura(Request $request){
        if(Session::get('account')['is_admin']=='YES'){
            $gets = $request->input();
            $full_name = $gets["full_name"];
            $dni = $gets["dni"];
            $period = $this->periods()["active_period"];
            $data = $this->list_checked($dni,$period);
            //dd($data); 
            $cursos = $this->grades();
            $asignaturas = $this->subject_current_list();
            return view("includes/mdl_asignaturas")->with("full_name",$full_name)->with("cursos",$cursos)->with("activos",$data)->with("asignaturas",$asignaturas)->with("dni",$dni);
        }
        else{
            return ('/');
        }
    }
    public function all_privileges(){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'all_privileges'
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;
    }
    public function user_privileges($dni){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'user_privileges',
            'data' => ['dni' => $dni]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;
    }
    public function get_apoderado_by_dni_stu($dni){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'proxy_info',
            'data' => ['dni' => $dni]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;
    }
    // Sent Mails
    public function info_sent_mails($filter){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'mails_sended',
            'data' => ['filter' => $filter]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;
    }
    public function destinatarios_sent_mails(Request $request){
        $gets = $request->input();        
        $id_mail = $gets["id_mail"];
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'mails_sended_to',
            'data' => ['id_mail' => $id_mail]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return view('includes/mdl_sent_mails')->with('correos',$data);
    }
    // Sent Mails
    private function contarCursosYAsignaturas($staffs){
        $cclass = array();
        foreach($staffs as $staff){
            $data = null;
            $data["dni_staff"] = $staff["dni"];
            $period = $this->periods()["active_period"];
            $list = $this->list_checked($staff["dni"],$period);
            $curs = array();
            $asig = array();
            foreach($list as $row){
                array_push($curs,$row["id_curso_periodo"]);
                array_push($asig,$row["id_materia"]);
            }
            $data["cursos"] = count(array_unique($curs));
            $data["asignaturas"] = count(array_unique($asig));
            array_push($cclass,$data);
        }
        return $cclass;
    }
    private function list_checked($dni,$period){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_param_class',
            'data' => [
                'dni' => $dni , 'periodo' => $period,
            ]
        );
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;
    }
    private function list_to(){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_mail_to',
            'data' => [
                'dni' => Session::get('account')['dni']
            ]
        );
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;  
    }
    private function list_groups(){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_mail_groups'
        );
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;       
    }
    private function list_students_groups(){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_students_groups'
        );
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;       
    }
    public function modal_edit_group(Request $request){
        $gets = $request->input();
        $nombre = $gets["nombre"];
        $encargado = $gets["encargado"];
        $id_grupo = $gets["id_grupo"];
        $list_groups = $this->list_groups();
        $students_enrollment = $this->students_enrollment();
        $list_students_items_groups = $this->list_students_items_groups($id_grupo);
        $staff = $this->staff();
        return view("includes/mdl_edit_group")->with("staff",$staff)->with("nombre",$nombre)->with("students_enrollment",$students_enrollment)->with("encargado",$encargado)->with("list_groups",$list_groups)->with("id_grupo",$id_grupo)->with("list_students_items_groups",$list_students_items_groups);    
    }
    private function list_students_items_groups($id_grupo){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_item_mail_groups',
            'data' => [ "id_grupo" => $id_grupo ]
        );
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;
    }
    private function list_class_enabled_days($id_class,$id_grade,$year){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'assistance_date',
            'data' => [ "id_class" => $id_class , "id_grade" => $id_grade , "year" => $year ]
        );
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;
    }
    private function list_assistance_class($id_class,$id_grade){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_assistance_class',
            'data' => [ "id_class" => $id_class , "id_grade" => $id_grade ]
        );
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;
    }
    private function list_class_scheduler($id_curso_periodo){
        //0 PARA TODOS LOS CURSOS
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_schedule_course',
            'data' => ['id' => $id_curso_periodo]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        return $data;
    }
    private function list_class_scheduler_by_user(){
        //0 PARA TODOS LOS CURSOS
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_schedule_course_by_user',
            'data' => ['dni' => Session::get('account')['dni']]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        return $data;
    }
    private function list_files_fm($path){
        $app_status = getenv("APP_STATUS");
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_filemanager',
            'data' => ["path" => $path, "app_status" => $app_status]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        return $data;
    }
    private function validate_path($path){        
        $app_status = getenv("APP_STATUS");
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'validate_filemanager_path',
            'data' => ["path" => $path, "app_status" => $app_status ]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        return $data;
    }
    private function get_user_data($dni){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'get_user_data',
            'data' => ["dni" => $dni ]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);
        return $data;
    }
    public function get_banks(){
        $response = Http::get(getenv("API_ENDPOINT").'api/getBanks');
        $data = json_decode($response->body(), true);
        
        return $data;
    }
    private function get_certificados($dni){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'get_user_documents',
            'data' => ["dni" => $dni ]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);        
        return $data;
    }
    public function get_user_formation(){
        $id_staff = Session::get('account')['dni'];
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'get_formation_data',
            'data' => ["dni" => $id_staff]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post(getenv("API_ENDPOINT")."api-ins");
        $data = json_decode($response->body(), true);  
        return $data;
    }
    
}