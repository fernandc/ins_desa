<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Horario de Clases
@endsection

@section("headex")

@endsection

@section("context")
<div class="container">
    <ul class="nav nav-tabs my-3 justify-content-center">
        <li class="nav-item">
            <a class="nav-link" data="1" href="adm_students?curso=1">PK</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="2" href="adm_students?curso=2">KI</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="3" href="adm_students?curso=3">1B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="4" href="adm_students?curso=4">2B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="5" href="adm_students?curso=5">3B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="6" href="adm_students?curso=6">4B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="7" href="adm_students?curso=7">5B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="8" href="adm_students?curso=8">6B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="9" href="adm_students?curso=9">7B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="10" href="adm_students?curso=10">8B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="11" href="adm_students?curso=11">1M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="12" href="adm_students?curso=12">2M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="13" href="adm_students?curso=13">3M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="14" href="adm_students?curso=14">4M</a>
        </li>
        @php
            $active = 1;
        @endphp
        
        <script>
            $(document).ready(function(){
                $("[data={{$active}}]").addClass("active");
            });
        </script>
    </ul>
    <ul class="nav nav-tabs my-3 justify-content-center">
        <li class="nav-item" data=""><a class="nav-link" data="1" href="">Bloques de Horario</a></li>
        <li class="nav-item" data=""><a class="nav-link" data="2" href="">Asignaturas</a></li>
        <li class="nav-item" data=""><a class="nav-link" data="3" href="">Profesores</a></li>
        @php
            $active = 1;
        @endphp
        
        <script>
            $(document).ready(function(){
                $("[data={{$active}}]").addClass("active");
            });
        </script>
    </ul>
    <div class="" id="">
        <div class="table table-responsive table-bordered">
            <table class="table" id="test">
                <thead>
                <tr>
                    <th scope="col">Bloque</th>
                    <th scope="col">Lunes</th>
                    <th scope="col">Martes</th>
                    <th scope="col">Miércoles</th>
                    <th scope="col">Jueves</th>
                    <th scope="col">Viernes</th>
                    <th scope="col">Sábado</th>
                </tr>
                </thead>
                <tbody>
                    @for ($j = 0; $j < 10; $j++)
                        @php
                            $cont = $j + 1;    
                        @endphp
                        <tr>
                            <th>{{$cont}}</th>
                            @for ($i = 0; $i < 6; $i++)
                                <td>
                                    <div class="accordion" id="accordionExample">
                                        <div class="card"  id="card{{$i}}-{{$j}}">
                                            <div class="card-header" id="headingOne{{$i}}-{{$j}}" style="background">
                                                <h2 class="mb-0">
                                                    <select class="form-control form-control-sm" id="sel{{$i}}-{{$j}}">
                                                        <option selected>
                                                            SELECCIONE
                                                        </option>
                                                        <option value="1" id="opt2">
                                                            ASIGNATURA
                                                        </option>
                                                        <option value="2" id="opt2">
                                                            RECESO
                                                        </option>
                                                    </select>
                                                    <button class="btn btn-link collapsed" id="optbtn1{{$i}}-{{$j}}" hidden  type="button" data-toggle="collapse" data-target="#collapseOne{{$i}}-{{$j}}" aria-expanded="true" aria-controls="collapseOne{{$i}}-{{$j}}">
                                                        Bloque {{$cont}} 
                                                    </button>
                                                    <button class="btn btn-link collapsed" id="optbtn2{{$i}}-{{$j}}" hidden type="button" data-toggle="collapse" data-target="#collapseTwo{{$i}}-{{$j}}" aria-expanded="true" aria-controls="collapseTwo{{$i}}-{{$j}}">
                                                        Receso {{$cont}} 
                                                    </button>
                                                    <script>
                                                        $("#sel{{$i}}-{{$j}}").change(function(){
                                                            var opt = $(this).val();
                                                            if(opt == 1){
                                                                $("#optbtn1{{$i}}-{{$j}}").click(); 
                                                                $("#collapseTwo{{$i}}-{{$j}}").removeClass("show");
        
                                                                
                                                            }else{
                                                                if(opt == 2){
                                                                    $("#optbtn2{{$i}}-{{$j}}").click();
                                                                    $("#collapseOne{{$i}}-{{$j}}").removeClass("show");
                                                                }
                                                                else{
                                                                    $("#collapseOne{{$i}}-{{$j}}").removeClass("show");
                                                                    $("#collapseTwo{{$i}}-{{$j}}").removeClass("show");
                                                                }
                                                            }
                                                        });
                                                    </script>
                                                </h2>
                                            </div>
                                            <div id="collapseOne{{$i}}-{{$j}}" class="collapse" aria-labelledby="headingOne{{$i}}-{{$j}}" >
                                                <div class="card-body text-white mb-3" style="background:#73c686">
                                                    <label for="">Desde</label>
                                                    <input class="form-control" type="time" name="in1" id="inA{{$i}}-{{$j}}">
                                                    <br>
                                                    <label for="">Hasta</label>
                                                    <input class="form-control" type="time" name="out1" id="ouA{{$i}}-{{$j}}">
                                                    <button class="btn btn-success btn-sm mt-4 mb-2 float-right" id="btnA{{$i}}-{{$j}}"  > Guardar</button>
                                                </div>
                                            </div>
                                            <div id="collapseTwo{{$i}}-{{$j}}" class="collapse" aria-labelledby="headingTwo{{$i}}-{{$j}}" >
                                                <div class="card-body text-white mb-3" style="background:#6fc5d3">
                                                    <label for="">Desde</label>
                                                    <input class="form-control" type="time" name="in1" id="inR{{$i}}-{{$j}}">
                                                    <br>
                                                    <label for="">Hasta</label>
                                                    <input class="form-control" type="time" name="out1" id="ouR{{$i}}-{{$j}}">
                                                    <button class="btn btn-success btn-sm mt-4 mb-2 float-right" id="btnR{{$i}}-{{$j}}" > Guardar</button>
                                                </div>
                                            </div>
                                            <script>
                                                $("#btnA{{$i}}-{{$j}}").click(function(){
                                                    var inputInA = $("#inA{{$i}}-{{$j}}").val();
                                                    var inputOuA = $("#ouA{{$i}}-{{$j}}").val();
                                                    alert(inputInA);
                                                    alert(inputOuA);
                                                    $.ajax({
                                                        type: "GET",
                                                        url: "save_block",
                                                        data:{
                                                            inputIn:inputInA,
                                                            inputOu:inputOuA,
                                                            
                                                            val: "1",
                                                            block:"{{$j}}",
                                                            day:"{{$i}}" 
                                                        },
                                                        success: function (data){
                                                            $("#test").html(data);
                                                        }
                                                    });
        
                                                })
                                                $("#btnR{{$i}}-{{$j}}").click(function(){
                                                    var inputInR = $("#inR{{$i}}-{{$j}}").val();
                                                    var inputOuR = $("#ouR{{$i}}-{{$j}}").val();
        
                                                    alert(inputInR);
                                                    alert(inputOuR);
                                                    $.ajax({
                                                        type: "GET",
                                                        url: "save_block",
                                                        data:{
                                                            inputIn:inputInR,
                                                            inputOu:inputOuR,
                                                            
                                                            val: "2",
                                                            block:"{{$j}}",
                                                            day:"{{$i}}" 
                                                        },
                                                        success: function (data){
                                                            $("#test").html(data);
                                                        }
                                                    });
                                                })
                                            </script>
                                        </div>
                                    </div>
                                </td>
                            @endfor
                        </tr>                
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <div class="table table-responsive table-bordered" id="tableProfesor">
            <table class="table" id="test">
                <thead>
                <tr>
                    <th scope="col">Bloque</th>
                    <th scope="col">Lunes</th>
                    <th scope="col">Martes</th>
                    <th scope="col">Miércoles</th>
                    <th scope="col">Jueves</th>
                    <th scope="col">Viernes</th>
                    <th scope="col">Sábado</th>
                </tr>
                </thead>
                <tbody>
                    @for ($j = 0; $j < 10; $j++)
                        @php
                            $cont = $j + 1;    
                        @endphp
                        <tr>
                            <th>{{$cont}}</th>
                            @for ($i = 0; $i < 6; $i++)
                                <td>
                                    <div class="card"  id="card{{$i}}-{{$j}}">
                                        <div class="card-header" id="headingOne{{$i}}-{{$j}}" style="background">
                                            <h2 class="mb-0">
                                                <select class="form-control form-control-sm" id="sel{{$i}}-{{$j}}">
                                                    <option selected>
                                                        SELECCIONE
                                                    </option>
                                                    <option value="1" id="opt2">
                                                        ASIGNATURA
                                                    </option>
                                                    <option value="2" id="opt2">
                                                        RECESO
                                                    </option>
                                                </select>
                                            </h2>
                                        </div>
                                    </div>
                                </td>
                            @endfor
                        </tr>                
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection