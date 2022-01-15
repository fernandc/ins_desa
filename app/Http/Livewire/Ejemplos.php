<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;

class Ejemplos extends Component
{
    public $name = "nombre";
    public $lname = "apellido";
    public $age = "30";
    public $check = false;
    public $multiple = ["op1"];
    public $iteraciones = 0;
    public $evento = "default";
    public $changes = "Sin Cambios";
    
    public function myFunction(){
        $this->iteraciones++;
    }
    public function myFunction2($param){
        $this->evento = $param;
    }
    //Constructor
    public function mount(Request $request, $newAge){
        $this->age = $newAge;
    }
    //Actualizar al Cambiar
    public function updated(){
        $this->changes = "Cambios Aplicados";
    }
    public function render()
    {
        return view('livewire.ejemplos');
    }
}
