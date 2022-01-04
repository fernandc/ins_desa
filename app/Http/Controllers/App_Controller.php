<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class App_Controller extends Controller {
    public function logo_ins(Request $request){
        $gets = $request->input();
        if (isset($gets["h"]) && isset($gets["key"])) {
            $hash = $gets["h"];
            $id = $gets["key"];
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'update_reader',
                'data' => ['hash' => $hash, 'id' => $id]);
            Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
        }
        $img = $contents = Storage::get('public/ins_logo.png');
        return response($img)->header('Content-type','image/png');
    }
    public function logout() {
        if(Session::has('account')){
            $token = Session::get('account')['token'];
            $response = Http::get("https://accounts.google.com/o/oauth2/revoke?token=$token");
        }    
        Session::forget('account');
        Session::forget('periodo');
        sleep(2);
        return redirect('/');
    }
    public function change_period(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'change_period',
                'data' => ['period' => $gets["year"]]);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            return back();
        }
        else{
            return redirect('/');
        }
    }
    public function add_new_period(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'add_period',
                'data' => ['period' => $gets["year"]]);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            if($response->status() == 400){
                return redirect('adm_periods')->with('message', 'Este periodo ya existe!');
            }
            return back();
        }
        else{
            return redirect('/');
        }
    }
    public function new_new(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            $dni = Session::get('account')['dni'];
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'new_new',
                'data' => [
                    'dni' => $dni,
                    'title' => $gets["title"],
                    'subtitle' => $gets["subtitle"],
                    'body' => $gets["body"],
                    'url' => $gets["url"],
                    'textlink' => $gets["textlink"]
                ]);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            return back();
        }
        else{
            return redirect('/');
        }
    }
    public function change_staff_status(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'change_staff_status',
                'data' => ['dni' => $gets["dni"]]);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            return back();
        }
        else{
            return redirect('/');
        }
    }
    public function change_staff_admin(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'change_staff_admin',
                'data' => ['dni' => $gets["dni"]]);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            if($gets["dni"] == Session::get('account')['dni']){
                $data = Session::get('account');
                $data['is_admin'] = "NO";
                Session::forget('account');
                Session::put('account',$data);
            }
            return back();
        }
        else{
            return redirect('/');
        }
    }
    public function save_block(Request $request){
        if(Session::get('account')['is_admin']=='YES'){
            $gets = $request->input();
            $in = $gets["hour_in"].":00";
            $out = $gets["hour_out"].":00";
            if(Session::has('account')){
                $dni = Session::get('account')['dni'];
                $arr = array(
                    'institution' => getenv("APP_NAME"),
                    'public_key' => getenv("APP_PUBLIC_KEY"),
                    'method' => 'save_block_course',
                    'data' => [
                        'dni'=>$dni,
                        'desde'=>$in,
                        'hasta'=>$out,
                        'day'=>$gets["day"],
                        'asignatura'=>$gets["asignatura"],
                        'profesor'=>$gets["profesor"],
                        'id_clase'=>$gets["id_clase"]
                    ]
                );
                $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
                $status = $response->body();
                //dd($status);
                Log::debug(json_decode($status,true));
                return json_decode($status,true)[0]["id"];
                
                //return $data;
            }else{
                return ('/');
            }
        }
    }
    public function rmv_block(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            $id = $gets["schid"];
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'del_block_course',
                'data' => ['id' => $id]
            );
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
        }
    }
    public function add_user(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            $us = Session::get('account')['full_name'];
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'add_staff',
                'data' => ['enroller' => $us, 'dni' => $gets["dni"],'full_name' => $gets['full_name'],'email' => $gets['email'],'birth_date' => $gets['birth_date']]
            );
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            return back();
        }
        else{
            return ('/');
        }
    }    
    public function add_course(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'add_grade',
                'data' => ['grade_id' => $gets["grade_id"],'section' => $gets["letter"]]
            );
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            if($response->status() == 400){
                return redirect('adm_courses')->with('message', 'Este curso ya existe!'); 
            }
            else{
                return back();
            }
        }
        else{
            return ('/');
        }
    }
    public function add_student(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'add_student',
                'data' => [               
                    "dni" => $gets["rut"],
                    "names" => $gets["nombres"],
                    "last_f" => $gets["apellido_p"],
                    "last_m" => $gets["apellido_m"],
                    "sex" => $gets["ddlgenero"],
                    "born_date" => $gets["fecha_nac"],
                    "nationality" => $gets["nacionalidad"],
                    "ethnic" => $gets["ddletina"],
                    ]
            );
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            if($response->status()==400){
                return redirect('adm_students')->with('message', 'Este estudiante ya existe!');
            }            
            return back();
        }
        else{
            return ('/');
        }
    }    
    public function del_student(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'del_student',
                'data' => [               
                    "dni" => $gets["dni"],
                    ]
            );
            dd($arr);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            return back();
        }
        else{
            return ('/');
        }
    }
    public function get_info(Request $request){
        $gets = $request->input();
        $rut = $gets["rut"];
        $response = Http::get('https://scc.cloupping.com/get_info/?rut='.$rut);
        return $response->body();
    }
    public function modal_student(Request $request){
        $gets = $request->input();
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'select_student',
            'data' => [               
                "id" => $gets["id"],
                ]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
        $data = json_decode($response->body(), true);
        return view("modals/modal_students")->with("stu",$data[0]);
    }
    public function edit_student(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'edit_student',
                'data' => [
                    "id" => $gets["id"],               
                    "dni" => $gets["rut"],
                    "names" => $gets["nombres"],
                    "last_f" => $gets["apellido_p"],
                    "last_m" => $gets["apellido_m"],
                    "sex" => $gets["ddlgenero"],
                    "born_date" => $gets["fecha_nac"],
                    "nationality" => $gets["nacionalidad"],
                    "ethnic" => $gets["ddletina"],
                    ]
            );
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            if($response->status()==400){
                return redirect('adm_students')->with('message', 'Este estudiante ya existe!');
            }            
            return back();
        }
        else{
            return ('/');
        }
    }
    public function add_subject(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            if($gets["idMateria"] > 0 ){
                $arr = array(
                    'institution' => getenv("APP_NAME"),
                    'public_key' => getenv("APP_PUBLIC_KEY"),
                    'method' => 'add_matter',
                    'data' => ['id' => $gets["idMateria"]]
                );
                //dd($arr);
                $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
                $data = json_decode($response->body(), true);
                if($response->status()==400){
                    return redirect('adm_subject')->with('message', 'Esta asignatura ya existe!');
                }  
                //dd($data);
                return back();
            }
            else{
                return redirect('adm_subject')->with('message', 'Asignatura no encontrada!');
            }
        }
        else{
            return ('/');
        }
    }  
    public function del_subject(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'del_matter',
                'data' => ['id' => $gets["id"]]
            );
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $data = json_decode($response->body(), true); 
            return back();
        }
        else{
            return ('/');
        }
    }
    public function add_teacher(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            //dd($gets);
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => '',
                'data' => ['id' => $gets["id"]]
            );
            //dd($arr);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $data = json_decode($response->body(), true); 
            //dd($data);
            return back();
        }
        else{
            return ('/');
        }
    }
    public function student_activate(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            //dd($gets);
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'matriculate_student',
                'data' => ['id' => $gets["id_stu"], 'id_matricula' => $gets["id_matricula"] ]
            );
            //dd($arr);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $data = json_decode($response->body(), true); 
            //dd($data);
            return back();
        }
        else{
            return ('/');
        }
    }
    public function student_is_repeater(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            //dd($gets);
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'student_is_repeater',
                'data' => ['id' => $gets["id_stu"], 'id_matricula' => $gets["id_matricula"] ]
            );
            //dd($arr);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $data = json_decode($response->body(), true); 
            //dd($data);
            return back();
        }
        else{
            return ('/');
        }
    }
    public function student_is_new(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            //dd($gets);
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'student_is_new',
                'data' => ['id' => $gets["id_stu"], 'id_matricula' => $gets["id_matricula"] ]
            );
            //dd($arr);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $data = json_decode($response->body(), true); 
            //dd($data);
            return back();
        }
        else{
            return ('/');
        }
    }
    public function set_jefatura(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            //dd($gets);
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'teacher_leader_course',
                'data' => ['id' => $gets["id"],'dni' =>$gets["dni"]]
            );
            //dd($arr);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $data = json_decode($response->body(), true); 
            //dd($data);
            return back();
        }
        else{
            return ('/');
        }
    }
    public function set_asignatura(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            //dd($gets);
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'teacher_matters',
                'data' => ['dni' =>$gets["dni"],'idCurso' => $gets["idCurso"],'idMateria' => $gets["idMateria"],'method' => $gets["method"],]
            );
            //dd($arr);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $data = json_decode($response->body(), true); 
            //dd($data);
            return back();
        }
        else{
            return ('/');
        }
    }  
    public function create_group(Request $request){
        $gets = $request->input();
        $id = Session::get('account')["dni"];
        //dd($id);
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'add_list_mail_groups',
            'data' => ["id_creador" => $id, "nombre_grupo" => $gets["nombre_grupo"]]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
        $data = json_decode($response->body(), true); 
        //dd($data);
        return back();
    }
    public function change_name_group(Request $request){
        $gets = $request->input();
        $dni = Session::get('account')['dni'];
        //dd($dni);
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'edit_list_mail_groups',
            'data' => ["nombre_grupo" => $gets["nombre"], "id_grupo" => $gets["id_grupo"], "dni" => $dni]
        );
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
        $data = json_decode($response->body(), true); 
        //dd($data);
    }
    public function del_group(Request $request){
        $gets = $request->input();
        $dni = Session::get('account')["dni"];
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'del_list_mail_groups',
            'data' => ["dni_creador" => $dni,"id_grupo" => $gets["id"]]
        );
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
        $data = json_decode($response->body(), true); 
        //dd($data);
        return back();
    }
    public function add_student_to_group(Request $request){
        $gets = $request->input();
        //dd($gets);
        $dni = Session::get('account')['dni'];
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'add_student_mail_group',
            'data' => ["id_grup" => $gets["id_grup"], "id_stu" => $gets["id_stu"], "dni" => $dni]
        );
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
        $data = json_decode($response->body(), true); 
        //dd($data);
        return $response->body();
    }
    public function del_student_from_group(Request $request){
        $gets = $request->input();
        //dd($gets);
        $dni = Session::get('account')['dni'];
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'del_student_mail_group',
            'data' => ["id_grup" => $gets["id_grup"], "id_item" => $gets["id_item"], "dni" => $dni]
        );
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
        $data = json_decode($response->body(), true); 
        //dd($data);
        //return $gets["id_item"];
        return $response->status();
    }
    public function change_student_section(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            //dd($gets);
            $dni_adm = Session::get('account')['dni'];
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'matriculate_student_section',
                'data' => ['dni_adm' => $dni_adm,'id_stu' =>$gets["id_stu"], 'section' => $gets["section"],'id_curso' => $gets["id_curso"], 'id_matricula' => $gets["id_matricula"] ]
            );
            //dd($arr);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $data = json_decode($response->body(), true); 
            //dd($data);
            return back();
        }
        else{
            return ('/');
        }
    }
    public function change_student_CP(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            //dd($gets);
            $dni_adm = Session::get('account')['dni'];
            // matriculate_student_parent_center
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'matriculate_student_parent_center',
                'data' => ['dni_adm' => $dni_adm,'id_stu' =>$gets["id_stu"],'id_curso' =>$gets["id_curso"], 'id_matricula' => $gets["id_matricula"], 'centro_padres' => $gets["inCp"] ]
            );
            //dd($arr);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $data = json_decode($response->body(), true); 
            //dd($data);
            //return back();
        }
        else{
            return "Sin Permiso";
        }
    }
    public function change_student_NM(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            //dd($gets);
            $dni_adm = Session::get('account')['dni'];
            // matriculate_student_parent_center
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'matriculate_student_inscription_number',
                'data' => ['dni_adm' => $dni_adm,'id_stu' =>$gets["id_stu"],'id_curso' =>$gets["id_curso"], 'id_matricula' => $gets["id_matricula"], 'numero_matricula' => $gets["inNM"] ]
            );
            //dd($arr);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $data = json_decode($response->body(), true); 
            //dd($data);
            //return back();
        }
        else{
            return "Sin Permiso";
        }
    }
    public function change_student_FR(Request $request){
        if($this->isAdmin()){
            $gets = $request->input();
            //dd($gets);
            $dni_adm = Session::get('account')['dni'];
            // matriculate_student_parent_center
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'matriculate_student_retired_date',
                'data' => ['dni_adm' => $dni_adm,'id_stu' =>$gets["id_stu"],'id_curso' =>$gets["id_curso"], 'id_matricula' => $gets["id_matricula"], 'fecha_retiro' => $gets["inNM"] ]
            );
            //dd($arr);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $data = json_decode($response->body(), true); 
            //dd($data);
            //return back();
        }
        else{
            return "Sin Permiso";
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
    public function enable_date(Request $request){
        if(isset(Session::get('account')['dni'])){
            $gets = $request->input();
            $id_class =  $gets["id_class"];
            $date =  $gets["date"];
            $bloq =  $gets["bloq"];
            $enabled =  $gets["enabled"];
            if($enabled == 1){
                $this->activity_log("Asistencia","Activar o Desactivar Dia","","","Habilita día $date en bloq $bloq de la clase $id_class");
            }else{
                $this->activity_log("Asistencia","Activar o Desactivar Dia","","","Deshabilita día $date en bloq $bloq de la clase $id_class");
            }
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'enable_assistance_date',
                'data' => ['id_class' => $id_class, 'date' => $date, 'bloq' => $bloq , 'enable' => $enabled]);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            return "DONE";
        }else{
            return "SESSION EXPIRED";
        }
    }
    public function assistance_stu(Request $request){
        if (Session::has('account')){
            $gets = $request->input();
            $id_stu = $gets["id_stu"];
            $id_grade = $gets["id_grade"];
            $year = $gets["year"];
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'assistance_student',
                'data' => [ 'year' => $year, 'id_stu' => $id_stu, 'id_grade' => $id_grade ]
            );
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $data = json_decode($response->body(), true);
            return $data;
        }
    }
    public function full_assistance(Request $request){
        if(isset(Session::get('account')['dni'])){
            $gets = $request->input();
            $id_class =  $gets["id_class"];
            $date =  $gets["date"];
            $bloq =  $gets["bloq"];
            $enabled =  $gets["enabled"];
            if($enabled == 1){
                $this->activity_log("Asistencia","Activar o Desactivar Asistencia Completa","","","Habilita Asistencia Completa en día $date en bloq $bloq de la clase $id_class");
            }else{
                $this->activity_log("Asistencia","Activar o Desactivar Asistencia Completa","","","Deshabilita Asistencia Completa en día $date en bloq $bloq de la clase $id_class");
            }
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'full_asistance',
                'data' => ['id_class' => $id_class, 'date' => $date, 'bloq' => $bloq , 'enable' => $enabled]);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            return "DONE";
        }else{
            return "SESSION EXPIRED";
        }
    }
    public function non_assistance(Request $request){
        if(isset(Session::get('account')['dni'])){
            $gets = $request->input();
            $id_class =  $gets["id_class"];
            $date =  $gets["date"];
            $bloq =  $gets["bloq"];
            $enabled =  $gets["enabled"];
            if($enabled == 1){
                $this->activity_log("Asistencia","Activar o Desactivar No pasó asistencia","","","Habilita No pasó asistencia en día $date en bloq $bloq de la clase $id_class");
            }else{
                $this->activity_log("Asistencia","Activar o Desactivar No pasó asistencia","","","Deshabilita No pasó asistencia en día $date en bloq $bloq de la clase $id_class");
            }
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'non_assistance',
                'data' => ['id_class' => $id_class, 'date' => $date, 'bloq' => $bloq , 'enable' => $enabled]);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            return "DONE";
        }else{
            return "SESSION EXPIRED";
        }
    }
    public function save_assistance(Request $request){
        if(isset(Session::get('account')['dni'])){
            $gets = $request->input();
            $dni_staff = Session::get('account')['dni'];
            $id_student = $gets["id_stu"];
            $id_class =  $gets["id_class"];
            $type_a = $gets["type_a"];
            $bloq = $gets["bloq"];
            $assistance = $gets["assistance"];
            $justify = $gets["justify"];
            $this->activity_log("Asistencia","Clase $id_class","Estudiante $id_student","Fecha $assistance","Registra o Edita \'$type_a\' Comentario: $justify");
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'save_assistance',
                'data' => ['dni_staff' => $dni_staff, 'id_student' => $id_student, 'id_class' => $id_class, 'type_a' => $type_a, 'assistance' => $assistance,'bloq' => $bloq , 'justify' => $justify]);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            return "DONE";
        }else{
            return "SESSION EXPIRED";
        }
    }
    public function send_mail_info(Request $request){
        $gets = $request->input();
        $files = $request->file('files');
        $mail = Session::get('account')['email'];
        $new = explode(",", $gets["lista_destinatarios"]);
        $destinatarios = array();
        $cont = 0;
        $valores = null;
        if(count($new) > 0){
            foreach($new as $row){
                $cont++;
                if($cont==1){
                    $valores["id"] = $row;
                }
                if($cont==2){
                    $valores["tipo"] = $row;
                }
                if($cont==3){
                    $valores["nombre"] = $row;
                    array_push($destinatarios,$valores);
                    $cont=0;
                }
            }
            $filearray= array();
            $cont=0;
            if(isset($files)){
                foreach ($files as $file) {
                    $cont++;
                    $extension = $file->extension();
                    $name = "documento_$cont.$extension";
                    $date = date('Ymd_His');
                    $path = $file->storeAs("correos_enviados/$mail/$date", $name);
                    array_push($filearray,$path);
                }
            }
            //dd($gets['meet']);
            $dni = Session::get('account')['dni'];
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'send_mails',
                'data' => ['dni' =>$dni,'lista_destinatarios' => $destinatarios, 'send_when' => $gets["send_when"], 'meet' => $gets["meet"], 'type' => $gets["type"] , 'title'=>$gets["title"], 'body' => $gets["body"], 'files' => $filearray]
            );
            //dd($arr);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $data = json_decode($response->body(), true); 
            //dd($data);
            return "DONE";
        }else{
            return "MISS";
        }
    }
    public function eliminar_correo(Request $request){
        $gets = $request->input();
        $dni = Session::get('account')['dni'];
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'remove_programed_email',
            'data' => ['dni' =>$dni, 'id_mail' => $gets["id_mail"]]
        );
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
        $data = json_decode($response->body(), true);
        
    }
    public function change_privilege(Request $request){
        $gets = $request->input();
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'change_privilege',
            'data' => ['dni' => $gets["dni"], 'id_priv' => $gets["id_priv"], 'method' => $gets["method"]]
        );
        //dd($arr);
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
        $data = json_decode($response->body(), true);
    }
    public function response_ticket(Request $request){
        $gets = $request->input();
        $dni_staff = Session::get('account')['dni'];
        $idrequest = $gets["idrequest"];
        $status = $gets["respuesta"];
        $response_message = $gets["message"];
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'response_ticket',
            'data' => ['id_request' => $idrequest, 'dni' => $dni_staff, 'status' => $status, 'response_message' => $response_message]);
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
        return $response->status();
    }
    public function send_ticket(Request $request){
        $gets = $request->input();
        $files = $request->file();
        $dni_staff = Session::get('account')['dni'];
        $dni = str_replace([".","-"],"",Session::get('account')['dni']);
        $type = $gets["type"];
        $fileref = "";
        if($type=="Solicitud"){
            $fileref = "solicitudes";
        }else{
            $fileref = "justificaciones";
        }
        $subject = $gets["subject"];
        $message = $gets["message"];
        $dateto = $gets["dateto"];
        $optional1 = $gets["optional1"];
        $filepath1 = null;
        $filepath2 = null;
        $filepath3 = null;
        $cont=0;
        $today = date('Y-m-d');
        if(($type == "Solicitud" && $dateto >= $today) || $type=="Justificación"){
            $id_account_receiver = 17;
            if(isset($files)){
                foreach ($files as $file) {
                    $cont++;
                    $extension = $file->extension();
                    $name = "documento_$cont.$extension";
                    $date = date('Ymd_His');
                    $path = $file->storeAs("tickets/$dni/$fileref/$date"."_to_".str_replace("-","",$dateto), $name);
                    if($cont == 1){
                        $filepath1 = $path;
                    }elseif($cont == 2){
                        $filepath2 = $path;
                    }elseif($cont == 3){
                        $filepath3 = $path;
                    }
                }
            }
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'send_ticket',
                'data' => [
                            'dni' => $dni_staff,
                            'id_account_receiver' => $id_account_receiver, 
                            'type' => $type,  
                            'subject' => $subject,  
                            'message' => $message,  
                            'file_path_1' => $filepath1,
                            'file_path_2' => $filepath2,
                            'file_path_3' => $filepath3,
                            'optional_1' => $optional1,
                            'date_to' => $dateto
                          ]
            );
            $fname = Session::get('account')["full_name"];
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $arr= array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'simple_send_mail',
                'data' => ["subject" => "$type de $fname",
                        "body" => "<b>$subject</b><br>$message<br>Para el día: $dateto <hr> Para más detalles e ingresar una respuesta ingrese a <a href=\"https://saintcharlescollege.cl/ins/tickets\" target=\"_blank\">Charly Notas - sección: Solicitudes y Justificaciones </a> en la pestaña <b>Responder y Respuestas</b>", 
                        "addressees" => [
                            [
                                "email" => "directora.scc@saintcharlescollege.cl"
                            ]
                        ]
                ]
            );
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            return "A";
        }else{
            return "C";
        }
    }
    public function download(Request $request){
        $gets = $request->input();
        $path = $gets["path"];
        return Storage::download($path);
    }
    private function activity_log($sec,$sub,$opA,$opB,$desc){
        if(isset(Session::get('account')['dni'])){
            $dni = Session::get('account')['dni'];
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'activity_log',
                'data' => ['dni' => $dni, 'section' => $sec, 'subsec' => $sub,  'op_a' => $opA,  'op_b' => $opB,  'desc' => $desc]
            );
            //dd($arr);
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $data = json_decode($response->body(), true);
        }
    }

    // File Manager
    // Agregar Archivo 
    public function saveFile_FM(Request $request){
        if(isset(Session::get('account')['dni'])){
            $gets = $request->input();
            $file = $request->file();
            $path_folder = $gets["path_file"];
            $path ="";
            $id_materia = $gets["id_materia"];
            $id_curso_periodo = $gets["id_curso"];
            $year = $gets["year"];
            $dni = Session::get('account')['dni'];
      
            if(isset($file)){
                foreach ($file as $fil) {
                    $extension = $fil->extension();
                    $name = $fil->getClientOriginalName();
                    
                    $duplicated = $this->duplicated_items($gets["path_file"],$name,"file");
                    if($duplicated){
                        return back();
                    }
                    $path = $fil->storeAs("$path_folder", $name);
                }
            }
            $app_status = getenv("APP_STATUS");
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'create_item_filemanager',
                'data' => [ 'name' => $name, "path" => $path, "type" => $extension, "dni" => $dni , "app_status" => $app_status ]
            );
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $data = json_decode($response->body(), true);
            return back();
        }else{
            return "SESSION EXPIRED";
        }
    }
    // Descargar Archivo
    public function downloadFile_FM(Request $request){
        $gets = $request->input();
        $path = $gets["path"];
        return Storage::download($path);
    }
    // Carpetas
    // Agregar Carpeta 
    public function addFolder_FM(Request $request){
        if(isset(Session::get('account')['dni'])){
            $gets = $request->input();
            $name = $gets["addFolder"];
            
            $duplicated = $this->duplicated_items($gets["path_folder"],$name,"folder");
            if($duplicated){
                return back();
            }
            
            $id_materia = $gets["id_materia"];
            $id_curso_periodo = $gets["id_curso"];
            $year = $gets["year"];
            $dni = Session::get('account')['dni'];
            $path = $gets["path_folder"]."/$name";
            Storage::makeDirectory($path);
    
            $app_status = getenv("APP_STATUS");
            $arr = array(   
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'create_item_filemanager',
                'data' => ['name' => $name, "path" => $path, "type" => "folder", "dni" => $dni , "app_status" => $app_status]
            );
            
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $data = json_decode($response->body(), true);
            return back();
        }else{
            return "SESSION EXPIRED";
        }
        
    }
    // Listar archivos, carpetas 
    private function list_files_fm($path){
        $app_status = getenv("APP_STATUS");
        $arr = array(
            'institution' => getenv("APP_NAME"),
            'public_key' => getenv("APP_PUBLIC_KEY"),
            'method' => 'list_filemanager',
            'data' => ["path" => $path, "app_status" => $app_status]
        );
        $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
        $data = json_decode($response->body(), true);
        return $data;
    }
    // Renombrar carpeta/archivo
    public function renameItem_FM(Request $request){
        if(isset(Session::get('account')['dni'])){
            $gets = $request->input();
            // params
            $id = $gets["renameId"];
            $name = $gets["renameName"];
            $path = $gets["renamePath"];
            $parent_path = $gets["renameParent"];
            $type = $gets["renameType"];
            $newNameItem = $gets["newNameItem"];
            $newPath = $parent_path."/".$newNameItem;
            $duplicated = $this->duplicated_items($parent_path,$newNameItem,$type);
            if($duplicated){
                return back();
            }        
            // modificar nombre de carpeta
            if($type == "folder"){
                Storage::move($path, $newPath);
            }else{
                Storage::move($path, $newPath.".".$type);
                $newPath = $newPath.".".$type;
                $newNameItem = $newNameItem.".".$type;
            }
            $arr = array(
                'institution' => getenv("APP_NAME"),
                'public_key' => getenv("APP_PUBLIC_KEY"),
                'method' => 'rename_item',
                'data' => ["path" => $newPath, "name" => $newNameItem , "id" => $id]
            );
            $response = Http::withBody(json_encode($arr), 'application/json')->post("https://cloupping.com/api-ins");
            $data = json_decode($response->body(), true);
            return back(); 
        }else{
            return "SESSION EXPIRED";
        }
        
        
    }
    // Evita que se dupliquen archivos o carpetas 
    private function duplicated_items($path,$name,$type){
        $list_items = $this->list_files_fm($path);
        $flag = false;
        
        foreach($list_items as $item){
            if($item["name"] == $name){
                $flag = true;
            }
        }
        if($type != "folder"){
            if($flag){
                $msj = "Ya existe un archivo con este nombre: ".$name;
                Session::put(["msj" => $msj]);
                return $flag;
            }else{
                return $flag;
            }
        }else{
            if($flag){
                $msj = "Ya existe una carpeta con este nombre: ".$name;
                Session::put(["msj" => $msj]);
                return $flag;
            }
            else{
                return $flag;
            }
            
        }
    }
    // Recuperar archivo con Path no utilizado 
    public function get_file_FM($path){
        $path = str_replace("-","/",$path);
        $ruta = storage_path("app/".$path);
        if(!File::exists($ruta)){
            abort(404);
        }
        $file = File::get($ruta);
        $type = File::mimeType($ruta);
        $response = Response::make($file,200);
        $response->header("Content-Type",$type);
        // dd(gettype($response));
        return $response;
    }
    // Eliminar Carpeta **Pendiente**
    public function deleteItem_FM(){
        return null;
    }

    
}
