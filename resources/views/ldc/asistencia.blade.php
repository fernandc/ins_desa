<!DOCTYPE html> 

@extends("layouts.mcdn")

@section("title")
Asistencias
@endsection

@section("headex")
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <style>
        .card-body nav a.nav-link:hover{
            color: #ff8300 !important
        }
        table tbody th:nth-child(1) {
            position: sticky;
            left: 0px;
            background-color: white;
            background-clip: padding-box;
        }
        table tbody th:nth-child(2) {
            position: sticky;
            left: 27px;
            background-color: white;
            background-clip: padding-box;
            
        }
        .custom-checkbox-red .custom-control-input:checked~.custom-control-label::before{
            background-color:red;
            border-color: red;
        }
        .custom-checkbox-red .custom-control-input:checked:disabled~.custom-control-label::before{
            background-color:red;
            border-color: red;
        }
    
        /** focus shadow pinkish **/
        .custom-checkbox-red .custom-control-input:focus~.custom-control-label::before{
            box-shadow: 0 0 0 1px #fff, 0 0 0 0.2rem rgba(255, 0, 0, 0.555); 
        }
    </style>
@endsection

@section("context")
    <ul id="contentcourses" class="nav nav-tabs my-3 justify-content-center">
        <li class="nav-item">
            <a class="nav-link text-success" data="0" href="checks_points">HOY</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="1" href="checks_points?curso=1">PK</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="2" href="checks_points?curso=2">KI</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="3" href="checks_points?curso=3">1B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="4" href="checks_points?curso=4">2B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="5" href="checks_points?curso=5">3B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="6" href="checks_points?curso=6">4B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="7" href="checks_points?curso=7">5B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="8" href="checks_points?curso=8">6B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="9" href="checks_points?curso=9">7B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="10" href="checks_points?curso=10">8B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="11" href="checks_points?curso=11">1M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="12" href="checks_points?curso=12">2M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="13" href="checks_points?curso=13">3M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="14" href="checks_points?curso=14">4M</a>
        </li>
        @php
            $active = 0;
        @endphp
        @if(isset($_GET['curso']))
            @php
            $active = $_GET['curso'];
            @endphp
        @endif
        <script>
            $(document).ready(function(){
                $("[data={{$active}}]").addClass("active");
            });
        </script>
    </ul>
    @php
        $mes[1] = "Ene";
        $mes[2] = "Feb";
        $mes[3] = "Mar";
        $mes[4] = "Abr";
        $mes[5] = "May";
        $mes[6] = "Jun";
        $mes[7] = "Jul";
        $mes[8] = "Ago";
        $mes[9] = "Sep";
        $mes[10] = "Oct";
        $mes[11] = "Nov";
        $mes[12] = "Dic";
        $sem[1] = "Lu";
        $sem[2] = "Ma";
        $sem[3] = "Mi";
        $sem[4] = "Ju";
        $sem[5] = "Vi";
        $sem[6] = "Sá";
        $sem[0] = "Do";
        $year =  Session::get('period');
        $month = 0;
        $lastd = 0;
        if(isset($_GET["mes"])){
            $month = $_GET["mes"];
            $lastd = date("t",strtotime("$year-$month"));
        }
        $contador = 0;
        $curso = "";
        $id_clase = "";
        $materias = [];
    @endphp
    @foreach ($clases as $clase)
        @php
            if(isset($_GET['curso'])){
                if($clase["id_curso"] == $_GET['curso']){
                    $materias[$clase["id_materia"]] = $clase["materia"];
                    $curso = $clase["curso"];
                    if(isset($_GET['materia'])){
                        if($clase["id_materia"] == $_GET['materia']){
                            //dd($clase);
                            $id_clase = $clase["id_clase"];
                        }
                    }
                }
            }
        @endphp
    @endforeach
    <div class="row" style="margin: 0px;">
        @if (isset($_GET["curso"]))
            <div id="contentmat" class="col-md-2" style="margin-top: 42px;">
                <div class="card">
                    <div class="card-header">
                        Asignaturas
                    </div>
                    <div class="card-body">
                        <nav class="nav flex-column" style="font-size: 0.8rem;">
                            @foreach ($materias as $materia)
                                @if (isset($_GET["materia"]) && array_search($materia,$materias)==$_GET["materia"])
                                    <a class="nav-link disabled text-primary">{{$materia}}</a>
                                @else
                                    <a class="nav-link text-secondary" href="checks_points?curso={{$active}}&materia={{array_search($materia,$materias)}}&mes={{date('m')}}">{{$materia}}</a>
                                @endif
                            @endforeach
                        </nav>
                    </div>
                </div>
            </div>
            @if (isset($_GET["materia"]) && isset($materias[$_GET["materia"]]) && isset($_GET["mes"]))
            <div id="contentlist" class="col-md-10">
                <ul id="contentmonths" class="nav nav-tabs justify-content-center">
                    
                    @for ($i = 1; $i <= 12; $i++)
                        @php
                            $day = $i;
                            if($i < 10){
                                $day = "0$i";
                            }
                        @endphp
                        @if ($_GET["mes"] == $i)
                            <li class="nav-item">
                                <a class="nav-link active">{{$mes[$i]}}</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="checks_points?curso={{$_GET["curso"]}}&materia={{$_GET["materia"]}}&mes={{$day}}">{{$mes[$i]}}</a>
                            </li>
                        @endif
                    @endfor
                </ul>
                <div class="card">
                    <div class="card-header scroll1" style="overflow-x: auto;">
                        <div id="scrollw">
                            <button id="expand" class="btn btn-sm btn-secondary" style="padding-left: 3.8px;padding-right: 4px;padding-bottom: 0px;padding-top: 0px;margin-top: -5px;    margin-right: 1rem;"><i class="fas fa-expand"></i></button>
                            <button  class="btn btn-sm btn-info" data-toggle="modal" data-target="#helpmodal" style="padding-left: 5px;padding-right: 5px;padding-bottom: 0px;padding-top: 0px;margin-top: -5px;    margin-right: 1rem;"><i class="fas fa-question"></i></button>
                            <div class="modal fade" id="helpmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Sistema de Asistencia</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <b class="text-primary">Para habilitar o desactivar un día de asistencia</b> utilice el botón que se encuentra debajo de cáda día
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                                <label class="custom-control-label" for="customSwitch1">Este es un ejemplo del botón.</label>
                                            </div>
                                            <hr>
                                            <b class="text-primary">Para marcar estados de asistencias</b> se debe hacer click en la casilla del respectivo alumno y dicho día de asistencia.
                                            Los estados de asistencia son los siguientes:
                                            <br>
                                            <b style="color: red">1</b> = Ausente
                                            <br>
                                            <b style="color: darkorange">R</b> = Retirado de clases
                                            <br>
                                            <b style="color: #0058ff">A</b> = Atrasado
                                            <br>
                                            <b style="color: #ea00ea">J</b> = Justificación de inasistencia
                                            <br>
                                            <b style="color: red">S</b> = Sin Cámara
                                            <br>
                                            <b>E</b> = Eximido
                                            <br>
                                            Estas serán guardadas automaticamente.
                                            <hr>
                                            <b class="text-primary">Para justificar </b> Se debe ingresar en la casilla la letra <b style="color: #ea00ea">J</b>, <b style="color: darkorange">R</b> o <b style="color: #0058ff">A</b> ,
                                            una vez colocada se mostrará un cuadro a la izquierda de la casilla seleccionada para justificar la inasistencia (Se Autoguardará).
                                            <hr>
                                            <b class="text-primary">Para registrar la asistencia de otro día</b> se debe presionar la tecla <b>ESC</b> (escape) 
                                            para que se habiliten las casillas de los días disponibles.
                                            <hr>
                                            <b class="text-info">Recomendación de asistencia ágil</b> Para cambiar a la siguiente casilla utilice la tecla <b>TAB</b> de esta manera se ahorrará tiempo en hacer click a la siguiente casilla del alumno.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            Asistencia de <span class='text-primary'>{{$materias[$_GET["materia"]]}}</span> - <span class='text-primary'>{{$curso}}</span>
                        </div>
                    </div>
                    <div class="card-body table-responsive scroll2" style="padding: 0px;">
                        <table id="listtable" class="table table-hover table-bordered table-sm" style="font-size: 0.9rem;">
                            <thead>
                              <tr>
                                <th scope="col" style="text-align: center;">#</th>
                                <th scope="col" style="min-width: 260px">Alumnos</th>
                                @for ($i = 1; $i <= $lastd; $i++)
                                    @php
                                        $today = date('w',strtotime("$year-$month-$i"));
                                    @endphp
                                    @if ($today > 0 && $today < 6)
                                        @foreach ($horarios as $horario)
                                            @if ($horario["id_materia"] == $_GET["materia"] && $horario["dia"] == $today)
                                                <th scope="col" style="min-width: 40px;text-align: center">
                                                    {{$sem[$today]}}
                                                    <br>
                                                    <span class="text-secondary">{{$i}}</span>
                                                    <div style="font-weight: lighter;">
                                                        {{substr($horario["hora_inicio"],0,5)}}<br>|<br>{{substr($horario["hora_fin"],0,5)}}
                                                    </div>
                                                    @php
                                                        $checked = "";
                                                        $inputenabled = 'disabled=""';
                                                        $inputcheckedA = '';
                                                        $inputcheckedB = '';
                                                        $day = $i;
                                                        if($i < 10){
                                                            $day = "0$i";
                                                        }
                                                    @endphp
                                                    <div class="custom-control custom-switch">
                                                        @foreach ($dias_activos as $dia_activo)
                                                            @if ($dia_activo["date_day"] == "$year-$month-$day" && $dia_activo["id_bloq"] == $horario["id"])
                                                                @php
                                                                    $checked = 'checked=""';
                                                                    $inputenabled = '';
                                                                @endphp
                                                                @if ($dia_activo["full_assistance"] == 1)
                                                                    @php
                                                                        $inputcheckedA = 'checked=""';
                                                                    @endphp
                                                                @endif
                                                                @if ($dia_activo["non_assistance"] == 1)
                                                                    @php
                                                                        $inputcheckedB = 'checked=""';
                                                                    @endphp
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                        <input type="checkbox" class="custom-control-input enable-date" data="{{$id_clase}}" date="{{$year}}-{{$month}}-{{$day}}" bloq="{{$horario["id"]}}" id="enablecourse{{$_GET["curso"]}}mat{{$_GET["materia"]}}bloq{{$horario["id"]}}date{{$year}}-{{$month}}-{{$day}}" {{$checked}}>
                                                        <label class="custom-control-label" for="enablecourse{{$_GET["curso"]}}mat{{$_GET["materia"]}}bloq{{$horario["id"]}}date{{$year}}-{{$month}}-{{$day}}"></label>
                                                    </div>
                                                    <hr style="margin: 0px 0px 3px 0px;">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input full-asistance" data="{{$id_clase}}" date="{{$year}}-{{$month}}-{{$day}}" bloq="{{$horario["id"]}}" id="ac{{$_GET["curso"]}}mat{{$_GET["materia"]}}bloq{{$horario["id"]}}date{{$year}}-{{$month}}-{{$day}}" {{$inputenabled}} {{$inputcheckedA}}>
                                                        <label class="custom-control-label" for="ac{{$_GET["curso"]}}mat{{$_GET["materia"]}}bloq{{$horario["id"]}}date{{$year}}-{{$month}}-{{$day}}" data-toggle="tooltip" data-placement="top" title="Asistencia Completa">A/C</label>
                                                    </div>
                                                        <hr style="margin: 0px 0px 3px 0px;">
                                                        <div class="custom-control custom-checkbox custom-checkbox-red">
                                                            <input type="checkbox" class="custom-control-input non-assistance" data="{{$id_clase}}" date="{{$year}}-{{$month}}-{{$day}}" bloq="{{$horario["id"]}}" id="anr{{$_GET["curso"]}}mat{{$_GET["materia"]}}bloq{{$horario["id"]}}date{{$year}}-{{$month}}-{{$day}}" @if($anr) {{$inputenabled}} @else disabled="" @endif {{$inputcheckedB}}>
                                                            <label class="custom-control-label" for="anr{{$_GET["curso"]}}mat{{$_GET["materia"]}}bloq{{$horario["id"]}}date{{$year}}-{{$month}}-{{$day}}" data-toggle="tooltip" data-placement="top" title="Asistencia No Realizada">N/R</label>
                                                        </div>
                                                </th>
                                            @endif
                                        @endforeach
                                    @endif
                                @endfor
                              </tr>
                            </thead>
                            <tbody>
                                @php
                                    $nrolista = 1;
                                @endphp
                                @foreach ($alumnos as $alumno)
                                    <tr>
                                        <th scope="row" style="text-align: center;">{{$nrolista++}}</th>
                                        <th>{{$alumno["nombre_stu"]}}</th>
                                        @for ($i = 1; $i <= $lastd; $i++)
                                            @php
                                                $today = date('w',strtotime("$year-$month-$i"));
                                                $day = $i;
                                                if($i < 10){
                                                    $day = "0$i";
                                                }
                                            @endphp
                                            @if ($today > 0 && $today < 6)
                                                @foreach ($horarios as $horario)
                                                    @php
                                                        $inputenabled = 'disabled=""';
                                                    @endphp
                                                    @if ($horario["id_materia"] == $_GET["materia"] && $horario["dia"] == $today)
                                                        @foreach ($dias_activos as $dia_activo)
                                                            @if ($dia_activo["date_day"] == "$year-$month-$day" && $dia_activo["id_bloq"] == $horario["id"])
                                                                @php
                                                                    $inputenabled = '';
                                                                @endphp
                                                            @endif
                                                        @endforeach
                                                        <th style="text-align: center;">
                                                            <input id="input-stu{{$alumno["id_stu"]}}-class{{$id_clase}}-bloq{{$horario["id"]}}-date{{$year}}-{{$month}}-{{$day}}" class="form-control form-control-sm refdate-all refdate-bloq{{$horario["id"]}}-{{$year}}-{{$month}}-{{$day}}" stu="{{$alumno["id_stu"]}}" data="{{$year}}-{{$month}}-{{$day}}" bloq="{{$horario["id"]}}" type="text" style="width: 30px;font-size: 0.8rem;text-transform:uppercase;font-weight: bold;display: inline;" maxlength="1" {{$inputenabled}}  placeholder="">
                                                            <div id="just-stu{{$alumno["id_stu"]}}-class{{$id_clase}}-bloq{{$horario["id"]}}-date{{$year}}-{{$month}}-{{$day}}" class="toast" role="alert" aria-live="assertive" aria-atomic="true" style="opacity: 1;position: sticky;margin-left: -356px;margin-top: -44px;" hidden="">
                                                                <div class="toast-body" style="padding: 0.5rem;">
                                                                    <div class="input-group mb-2" style="margin-bottom: 0px !important;">
                                                                        <div class="input-group-prepend">
                                                                            <div style="background-color:     #e81515;color: white;font-weight: bold;" class="input-group-text">Justificación:</div>
                                                                        </div>
                                                                        <input id="descj-stu{{$alumno["id_stu"]}}-class{{$id_clase}}-bloq{{$horario["id"]}}-date{{$year}}-{{$month}}-{{$day}}" type="text" class="form-control justificacion" stu="{{$alumno["id_stu"]}}" data="{{$year}}-{{$month}}-{{$day}}" bloq="{{$horario["id"]}}" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </th>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endfor
                                    </tr>
                                @endforeach
                            </tbody>
                          </table>
                          
                    </div>
                    
                    <script>
                        $(document).ready(function(){
                            //LIST CURRENT ASSISTANCES
                            @foreach ($assistance_data as $row)
                                @if($row["type_a"] == "J")
                                    $("#input-stu{{$row["id_student"]}}-class{{$row["id_class"]}}-bloq{{$row["id_bloq"]}}-date{{$row["assistance"]}}").css("color","#ea00ea");
                                @elseif($row["type_a"] == "A")
                                    $("#input-stu{{$row["id_student"]}}-class{{$row["id_class"]}}-bloq{{$row["id_bloq"]}}-date{{$row["assistance"]}}").css("color","#0058ff");
                                @elseif($row["type_a"] == "1" || $row["type_a"] == "S")
                                    $("#input-stu{{$row["id_student"]}}-class{{$row["id_class"]}}-bloq{{$row["id_bloq"]}}-date{{$row["assistance"]}}").css("color","red");
                                @elseif($row["type_a"] == "R")
                                    $("#input-stu{{$row["id_student"]}}-class{{$row["id_class"]}}-bloq{{$row["id_bloq"]}}-date{{$row["assistance"]}}").css("color","darkorange");
                                @elseif($row["type_a"] == "E")
                                    $("#input-stu{{$row["id_student"]}}-class{{$row["id_class"]}}-bloq{{$row["id_bloq"]}}-date{{$row["assistance"]}}").css("color","black");
                                @endif
                                //justify
                                //id_staff
                                $("#input-stu{{$row["id_student"]}}-class{{$row["id_class"]}}-bloq{{$row["id_bloq"]}}-date{{$row["assistance"]}}").val("{{$row["type_a"]}}");
                                $("#descj-stu{{$row["id_student"]}}-class{{$row["id_class"]}}-bloq{{$row["id_bloq"]}}-date{{$row["assistance"]}}").val("{{$row["justify"]}}");
                            @endforeach
                            $('input').keypress(function(e) {
                                if (e.which == 13) {
                                    $(this).next('input').focus();
                                    e.preventDefault();
                                }
                            });
                            //Enable Day
                            $(".enable-date").change(function(){
                                var id_class = $(this).attr("data");
                                var date = $(this).attr("date");
                                var bloq = $(this).attr("bloq");
                                var enabled = 0;
                                if($(this).is(":checked")){
                                    enabled = 1;
                                }
                                $.ajax({
                                    type: "GET",
                                    url: "enable_date",
                                    data:{
                                        id_class,
                                        date,
                                        bloq,
                                        enabled
                                    },
                                    success: function (data)
                                    {
                                        if(data != "DONE"){
                                            location.reload();
                                        }else{
                                            if(enabled == 1){
                                                $(".refdate-bloq"+bloq+"-"+date).attr("disabled",false);
                                                $("#ac{{$_GET["curso"]}}mat{{$_GET["materia"]}}bloq"+bloq+"date"+date+"").attr("disabled",false);
                                                $("#anr{{$_GET["curso"]}}mat{{$_GET["materia"]}}bloq"+bloq+"date"+date+"").attr("disabled",false);
                                            }else{
                                                $(".refdate-bloq"+bloq+"-"+date).attr("disabled",true);
                                                $("#ac{{$_GET["curso"]}}mat{{$_GET["materia"]}}bloq"+bloq+"date"+date+"").attr("disabled",true);
                                                $("#anr{{$_GET["curso"]}}mat{{$_GET["materia"]}}bloq"+bloq+"date"+date+"").attr("disabled",true);
                                            }
                                        }
                                    }
                                });
                            });
                            //Full Asistance
                            @if($anr)
                            $(".non-assistance").change(function(){
                                var id_class = $(this).attr("data");
                                var date = $(this).attr("date");
                                var bloq = $(this).attr("bloq");
                                var enabled = 0;
                                if($(this).is(":checked")){
                                    enabled = 1;
                                }
                                $.ajax({
                                    type: "GET",
                                    url: "non_assistance",
                                    data:{
                                        id_class,
                                        date,
                                        bloq,
                                        enabled
                                    },
                                    success: function (data)
                                    {
                                        if(data != "DONE"){
                                            location.reload();
                                        }
                                    }
                                });
                            });
                            @endif
                            $(".full-asistance").change(function(){
                                var id_class = $(this).attr("data");
                                var date = $(this).attr("date");
                                var bloq = $(this).attr("bloq");
                                var enabled = 0;
                                if($(this).is(":checked")){
                                    enabled = 1;
                                }
                                $.ajax({
                                    type: "GET",
                                    url: "full_assistance",
                                    data:{
                                        id_class,
                                        date,
                                        bloq,
                                        enabled
                                    },
                                    success: function (data)
                                    {
                                        if(data != "DONE"){
                                            location.reload();
                                        }
                                    }
                                });
                            });
                            //Focus Column
                            $(".refdate-all").focus(function(){
                                var data = $(this).attr("data");
                                var bloq = $(this).attr("bloq");
                                $('.refdate-all').not(".refdate-bloq"+bloq+"-"+data).attr("disabled",true);
                            });
                            //UNFOCUS WITH ESC
                            $(document).keyup(function(e) {
                                if (e.key === "Escape") { 
                                    $(".toast").attr("hidden",true);
                                    $(".enable-date").each(function( index ) {
                                        if($(this).is(":checked")){
                                            var current = $(this).attr("date");
                                            var bloq = $(this).attr("bloq");
                                            $(".refdate-bloq"+bloq+"-"+current).attr("disabled",false);
                                        }
                                    });
                                }
                            });
                            //Triger Justified
                            $(".refdate-all").on("keyup focus", function(){
                                $(".toast").attr("hidden",true);
                                var data = $(this).attr("data");
                                var id_stu = $(this).attr("stu");
                                var bloq = $(this).attr("bloq");
                                var value = $(this).val().toUpperCase();
                                if(value == "J" || value == "A" || value == "R"){
                                    //alert("a");
                                    $("#just-stu"+id_stu+"-class{{$id_clase}}-bloq"+bloq+"-date"+data).attr("hidden",false);
                                    if(value == "J"){
                                        $("#descj-stu"+id_stu+"-class{{$id_clase}}-bloq"+bloq+"-date"+data).attr("placeholder","Ej: Hora al médico");
                                    }else if(value == "A"){
                                        $("#descj-stu"+id_stu+"-class{{$id_clase}}-bloq"+bloq+"-date"+data).attr("placeholder","Ej: Hora de atraso HH:MM");
                                    }else if(value == "R"){
                                        $("#descj-stu"+id_stu+"-class{{$id_clase}}-bloq"+bloq+"-date"+data).attr("placeholder","Ej: Hora de retiro HH:MM");
                                    }
                                }else{
                                    $("#just-stu"+id_stu+"-class{{$id_clase}}-bloq"+bloq+"-date"+data).attr("hidden",true);
                                }
                            });
                            //SAVE 1 R A
                            $(".refdate-all").on("keyup change", function(){
                                var value = $(this).val().toUpperCase();
                                var data = $(this).attr("data");
                                var id_stu = $(this).attr("stu");
                                var bloq = $(this).attr("bloq");
                                var justify = $("#descj-stu"+id_stu+"-class{{$id_clase}}-bloq"+bloq+"-date"+data).val();
                                if(value == "1" || value == "R" || value == "A" || value == "J" || value == "S" || value == "E" || value == ""){
                                    $(this).css("color","gray");
                                    $.ajax({
                                        type: "GET",
                                        url: "save_assistance",
                                        data:{
                                            id_stu,
                                            id_class:{{$id_clase}},
                                            type_a:value,
                                            assistance:data,
                                            bloq,
                                            justify
                                        },
                                        success: function (data)
                                        {
                                            if(data != "DONE"){
                                                location.reload();
                                            }
                                        }
                                    });
                                    if(value == "1"){
                                        $(this).css("color","red");
                                    }
                                    if(value == "S"){
                                        $(this).css("color","red");
                                    }
                                    if(value == "R"){
                                        $(this).css("color","darkorange");
                                    }
                                    if(value == "A"){
                                        $(this).css("color","#0058ff");
                                    }
                                    if(value == "J"){
                                        $(this).css("color","#ea00ea");
                                    }
                                    if(value == "E"){
                                        $(this).css("color","black");
                                    }
                                }else{
                                    $(this).val("");
                                }
                            });
                            //SAVE J
                            $(".justificacion").change(function(){
                                var justify = $(this).val();
                                var id_stu = $(this).attr("stu");
                                var data = $(this).attr("data");
                                var bloq = $(this).attr("bloq");
                                var type_a = $("#input-stu"+id_stu+"-class{{$id_clase}}-bloq"+bloq+"-date"+data).val().toUpperCase();
                                $.ajax({
                                    type: "GET",
                                    url: "save_assistance",
                                    data:{
                                        id_stu,
                                        id_class:{{$id_clase}},
                                        type_a:type_a,
                                        assistance:data,
                                        bloq,
                                        justify:justify
                                    },
                                    success: function (data)
                                    {
                                        if(data != "DONE"){
                                            location.reload();
                                        }else{
                                        }
                                    }
                                });
                            });
                        });
                        $("#expand").click(function(){
                            $("#expand").removeClass("btn-secondary");
                            $("#expand").removeClass("btn-warning");
                            if($("#contentlist").hasClass("col-md-10")){
                                $("#contentmat").hide();
                                $("#contentmonths").hide();
                                $("#contentcourses").hide();
                                $("#contentlist").removeClass("col-md-10");
                                $("#contentlist").addClass("col-md-12");
                                $("#expand").addClass("btn-warning");
                            }else{
                                $("#contentlist").removeClass("col-md-12");
                                $("#contentlist").addClass("col-md-10");
                                $("#contentmat").show();
                                $("#contentmonths").show();
                                $("#contentcourses").show();
                                $("#expand").addClass("btn-secondary");
                            }
                        });
                        var scroll2 = $('#listtable').get(0).scrollWidth;
                        //scroll2 = scroll2;
                        $("#scrollw").css("width",scroll2);
                        $(function(){
                            $(".scroll1").scroll(function(){
                                $(".scroll2")
                                    .scrollLeft($(".scroll1").scrollLeft());
                            });
                            $(".scroll2").scroll(function(){
                                $(".scroll1")
                                    .scrollLeft($(".scroll2").scrollLeft());
                            });
                        });
                    </script>
                </div>
            </div>
            @endif
            
        @else
            <div class="container">
                
            </div>
        @endif
    </div>
@endsection