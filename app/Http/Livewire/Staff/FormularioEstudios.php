<?php

namespace App\Http\Livewire\Staff;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\App_Controller;


class FormularioEstudios extends Component
{
    use WithFileUploads;
    public $titulos;
    public $basic_mentions;
    public $area_titulo;
    // Selecteds
    public $titulo_seleccionado;
    public $tipo_titulo_seleccionado;
    public $menciones_seleccionadas;
    public $especialidad_seleccionada;
    public $area_seleccionada;
    public $semestres;
    public $anio_titulacion;
    // misc data 
    public $modalidad;
    public $tipo_titulo;
    public $tipo_institucion;
    public $especialidades;
    public $del_btn;
    // Validations
    public $btn_disabled;
    // data
    public $informacion_usuario;
    public $certificado;
 
    public function eliminar_titulo(){
        $controller = new App_Controller();
        $id = $this->del_btn;
        $controller->delete_degree_user($id);
    }
    public function enviar_datos(){
        $controller = new App_Controller();
        $maxid = $controller->get_added_files();
        $maxid = $maxid[0]['AUTO_INCREMENT'];
        $dniSession = Session::get('account')['dni'];
        $dniSession = str_replace(".","", $dniSession);
        $dniSession = str_replace("-","",$dniSession);
        $pathfile = "public/staff/$dniSession/";
        $name = 'certificado_titulo_'.$maxid.'.pdf';
        $new_path_file = $pathfile.$name;
        $new_path_file = str_replace("/","-",$new_path_file);
        $this->certificado->storePubliclyAs($pathfile, $name);
        $get = [];
        $get["titulo_seleccionado"] = $this->titulo_seleccionado;
        $get["tipo_titulo_seleccionado"] = $this->tipo_titulo_seleccionado;
        $get["menciones_seleccionadas"] = $this->menciones_seleccionadas;
        $get["especialidad_seleccionada"] = $this->especialidad_seleccionada;
        $get["area_seleccionada"] = $this->area_seleccionada;
        $get["semestres"] = $this->semestres;
        $get["anio_titulacion"] = $this->anio_titulacion;
        $get["modalidad"] = $this->modalidad;
        $get["tipo_institucion"] = $this->tipo_institucion;
        $get["certificado"] = $new_path_file;
        $get["maxid"] = $maxid;
       
        $controller->send_user_formation_info($get);  
        return redirect("/my_info?section=2");
    }
    public function obtener_tipo_titulo(){
        $controller = new App_Controller();
        $this->tipo_titulo_seleccionado = "";
        $this->menciones_seleccionadas = "";
        $this->especialidad_seleccionada = "";
        $this->area_seleccionada = "";
        $this->semestres = "";
        $this->anio_titulacion = "";
        $this->modalidad = "";
        $this->tipo_titulo = "";
        $this->tipo_institucion = "";
        $this->especialidades = "";
        $this->tipo_titulo = $controller->get_user_type_titles($this->titulo_seleccionado);

    }
    public function obtener_especialidad(){
        $controller = new App_Controller();
        $this->especialidades = $controller->get_user_specialty($this->tipo_titulo_seleccionado);
    }
    public function validar_campos(){
        $anio_titulacion = $this->anio_titulacion;
        $cert = $this->certificado;
        $this->btn_disabled = "disabled";
        // $anio_titulacion > 1900 && $anio_titulacion <= date("Y")
        if($cert != '' || $cert != null){
             $this->btn_disabled = "";
        }
    }
    public function updated(){
        $this->validar_campos();
    }
    public function mount(){
        $controller = new App_Controller();
        $this->titulos = $controller->get_user_degree_titles();
        $this->area_titulo = $controller->get_user_degree_area();
        $this->basic_mentions = $controller->get_user_basic_mentions();
        $this->btn_disabled = "disabled";
        $this->validar_campos();
    }
    public function render(){
        return view('livewire.staff.formulario-estudios');
    }
    
}
