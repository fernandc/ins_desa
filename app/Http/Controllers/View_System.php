<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class View_System extends Controller {
    public function main(request $request) {
        
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
                    return view('home');
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
                        return view('adm_courses')->with("grades",$grades);
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
                        return view('adm_teachers')->with("staff",$staff)->with("grades",$grades)->with("message",$message);
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
                    return view('mails/sent_and_tracing_mails');                    
                case "mail_send_mail":
                    $list_to = $this->list_to();
                    return view('mails/send_mail')->with("lista_para",$list_to);                    
                default:
                return view('not_found')->with("path",$path);
            }
        }else{
            return redirect('/logout');
        }
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
            'method' => 'list_mail_to'
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

