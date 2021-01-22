<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class App_Controller extends Controller {
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
            return back();
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
}
