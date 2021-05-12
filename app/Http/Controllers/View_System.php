<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class View_System extends Controller {
    public function main(request $request) {
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
                    $info = $this->info_sent_mails();
                    //dd($info);
                    return view('home')->with("info_mails",$info);
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
                        $staff = $this->staff();
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
                    $info = $this->info_sent_mails();
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
                            $class = $this->list_checked(Session::get('account')['dni']);
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
                default:
                    return view('not_found')->with("path",$path);
            }
        }else{
            return redirect('/logout');
        }
    }
    public function modal_ficha(request $request){
        $gets = $request->input();
        $id_stu = $gets["id_stu"];
        $id_apo = $gets["id_apo"];
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'downloadPdf',
            'data' => ["id" => $id_stu,
                        "id_apo" => $id_apo
                    ]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://scc.cloupping.com/api-apoderado");
        $data = json_decode($response->body(), true);
        return view('includes/mdl_ficha')->with("data",$data);
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
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
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
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
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
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
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
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
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
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
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
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
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

        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
        $data = json_decode($response->body(), true);
        if($data["active_period"] != ''){
            Session::put(['period' => $data["active_period"]] );
        }
        else{
            Session::put(['period' => null] );
        }
        return $data;       
    }
    private function staff(){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_staff'
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
        $data = json_decode($response->body(), true);
        return $data;       
    }
    private function grades(){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_grades'
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
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
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
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
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
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
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
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
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
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
    public function save_block(Request $request){
        if(Session::get('account')['is_admin']=='YES'){
            $gets = $request->input();
            if(Session::has('account')){
                $dni = Session::get('account')['dni'];
                $arr = array(
                    'institution' => getenv("APP_NAME"),
                    'public_key' => getenv("APP_PUBLIC_KEY"),
                    'method' => 'save_block_course',
                    'data' => [
                        'dni'=>$dni,
                        'desde'=>$gets["hour_in"],
                        'hasta'=>$gets["hour_out"],
                        'day'=>$gets["day"],
                        'asignatura'=>$gets["asignatura"],
                        'profesor'=>$gets["profesor"],
                        'id_clase'=>$gets["id_clase"]
                    ]
                );
                $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
                $status = $response->status();
                //dd($status);
                return $status;
                
                //return $data;
            }else{
                return ('/');
            }
        }
    }
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
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $data = json_decode($response->body(), true);
            //dd($data);  
            $arr2 = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'list_teachers_course',
                'data' => ['id_curso' => $id_curso]
            );
            //dd($arr);
            $response2 = Http::withBody(json_encode($arr2), 'application/json')->post("https://cloupping.com/api-ins");
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
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $data = json_decode($response->body(), true);
            $arr2 = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'list_schedule_course',
                'data' => ['id' => $id_curso,]
            );
            //dd($arr);
            $response2 = Http::withBody(json_encode($arr2), 'application/json')->post("https://cloupping.com/api-ins");
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
        return view("includes/mdl_apoderado")->with("apoderado",$apoderado);
    }
    public function modal_asignatura(Request $request){
        if(Session::get('account')['is_admin']=='YES'){
            $gets = $request->input();
            $full_name = $gets["full_name"];
            $dni = $gets["dni"];
            $data = $this->list_checked($dni);
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
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
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
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
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
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;
    }
    // Sent Mails
    public function info_sent_mails(){
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'mails_sended'
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
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
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
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
            $list = $this->list_checked($staff["dni"]);
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
    private function list_checked($dni){
        $period = $this->periods()["active_period"];
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_param_class',
            'data' => [
                'dni' => $dni , 'periodo' => $period,
            ]
        );
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
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
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
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
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
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
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
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
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
        $data = json_decode($response->body(), true);
        //dd($data);
        return $data;       
    }
}

