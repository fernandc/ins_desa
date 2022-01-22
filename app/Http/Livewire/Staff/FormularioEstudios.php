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
    // Validations
    public $btn_disabled;
    public $anio_disabled;
    public $modalidad_disabled;
    public $duracion_disabled;

    public function actualizar_menciones_sm(){        
        if (isset($this->menciones_seleccionadas[1])) {
            if($this->menciones_seleccionadas[1] == true ){
                for ($i=2; $i <= 26; $i++) {
                    if (isset($this->menciones_seleccionadas[$i])) {
                        $this->menciones_seleccionadas[$i] = false;                    
                    }
                }
            }
        }
    }
    public function actualizar_menciones(){        
        if(count($this->menciones_seleccionadas)!=0){
            for ($j=2; $j <=26 ; $j++) {
                if (isset($this->menciones_seleccionadas[$j])) {                    
                    if($this->menciones_seleccionadas[$j] == true){
                        $this->menciones_seleccionadas[1] = false;   
                    }        
                }
            }            
        }
    }
    public function enviar_datos(){
        $controller = new App_Controller();
        $get = [];
        $get["titulo_seleccionado"] = $this->titulo_seleccionado;
        $get["tipo_titulo_seleccionado"] = $this->tipo_titulo_seleccionado;
        $get["menciones_seleccionadas"] = $this->menciones_seleccionadas;
        $get["area_seleccionada"] = $this->area_seleccionada;
        $get["semestres"] = $this->semestres;
        $get["anio_titulacion"] = $this->anio_titulacion;
        $get["modalidad"] = $this->modalidad;
        $get["tipo_institucion"] = $this->tipo_institucion;
        $controller->send_user_formation_info($get);  
    }
    public function obtener_tipo_titulo(){
        $controller = new App_Controller();
        $this->tipo_titulo = $controller->get_user_type_titles($this->titulo_seleccionado);

    }
    public function obtener_especialidad(){
        $controller = new App_Controller();
        $this->especialidades = $controller->get_user_specialty($this->tipo_titulo_seleccionado);
    }
    public function validar_campos(){
        $titulo = $this->titulo_seleccionado;
        $tipo_titulo = $this->tipo_titulo_seleccionado;
        $area_titulo = $this->area_seleccionada;
        $this->btn_disabled = "disabled";
        $this->anio_disabled = "";
        $this->modalidad_disabled = "";
        $this->duracion_disabled = "";
        if($titulo != ""){
            if($titulo == "No Titulado"){
                $this->anio_disabled = "hidden";
                $this->modalidad_disabled = "hidden";
                $this->duracion_disabled = "hidden";
            }
            if($titulo == "Titulado en Otras Áreas"){
                if($area_titulo != "" && $tipo_titulo != "" ){
                    $this->btn_disabled = "";
                }
            }
            if($tipo_titulo != ""){
                $this->btn_disabled = "";
            }
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
