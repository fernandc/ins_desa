<?php

namespace App\Http\Livewire\Staff;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FormularioEstudios extends Component
{
    public $contador;
    public function contar(){
        $this->contador++;
    }
    public function mount(){
        $this->contador=0;
    }
    public function render()
    {
        return view('livewire.staff.formulario-estudios');
    }
    
}
