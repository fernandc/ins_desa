<div class="container mt-3">
    <input wire:model="name" type="text">
    Respuesta Inmediata {{$name}}
    <hr>
    <input wire:model.debounce.1000ms="lname" type="text">
    Respuesta con delay {{$lname}}
    <hr>
    <input wire:model.lazy="age" type="text">
    Respuesta al cambiar {{$age}}
    <hr>
    <input wire:model="check" type="checkbox">
    @if ($check) seleccionado @else no seleccionado @endif
    <hr>
    <select wire:model="multiple" multiple="">
        <option>op1</option>
        <option>op2</option>
        <option>op3</option>
    </select>
    Selected Multiple: {{ implode(', ',$multiple) }}
    <hr>
    <button wire:click="myFunction">Llamar a función</button>
    Iteraciones : {{$iteraciones}}
    <hr>
    <button wire:click="myFunction2($event.target.innerText)">Este texto</button>
    Respuesta : {{$evento}}
    <hr>
    {{$changes}}
    
</div>