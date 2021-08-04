<!DOCTYPE html> 

@extends("layouts.mcdn")

@section("title")
Asistencias
@endsection

@section("headex")
    <script>
        
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
    </style>
@endsection

@section("context")
    <ul id="contentcourses" class="nav nav-tabs my-3 justify-content-center">
        <li class="nav-item">
            <a class="nav-link text-success" data="0" href="info_assistance">HOY</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="1" href="info_assistance?curso=1">PK</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="2" href="info_assistance?curso=2">KI</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="3" href="info_assistance?curso=3">1B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="4" href="info_assistance?curso=4">2B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="5" href="info_assistance?curso=5">3B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="6" href="info_assistance?curso=6">4B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="7" href="info_assistance?curso=7">5B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="8" href="info_assistance?curso=8">6B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="9" href="info_assistance?curso=9">7B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="10" href="info_assistance?curso=10">8B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="11" href="info_assistance?curso=11">1M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="12" href="info_assistance?curso=12">2M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="13" href="info_assistance?curso=13">3M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="14" href="info_assistance?curso=14">4M</a>
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
        <div id="contentlist" class="col-md-12">
            <div class="card">
                <div class="card-header scroll1" style="overflow-x: auto;">
                    <div id="scrollw">
                        Asistencia de <span class='text-primary'>{{$curso}}</span>
                    </div>
                </div>
                <div class="card-body table-responsive scroll2" style="padding: 0px;">
                    <table id="listtable" class="table table-hover table-bordered table-sm" style="font-size: 0.9rem;">
                        <thead>
                          <tr>
                            <th scope="col" style="text-align: center;">#</th>
                            <th scope="col" style="min-width: 260px">Alumnos</th>
                                @foreach ($dias_activos as $horario)
                                    @php
                                        $type = "";
                                        $idc = $horario["id_materia"];
                                        if($idc == "20009" || $idc == "14" || $idc == "9200" || $idc == "20000" || $idc == "20001" || $idc == "11224" || $idc == "4487" || $idc == "27"){$type = '<a href="#" class="badge badge-danger" style="background-color: red;">LEN </a>';}
                                        if($idc == "288"){$type = '<a href="#" class="badge badge-danger" style="background-color: #e597fb;">MUS </a>';}
                                        if($idc == "20010" || $idc == "5" || $idc == "9201" || $idc == "6616" || $idc == "2972"){$type = '<a href="#" class="badge badge-primary">MAT </a>';}
                                        if($idc == "249"){$type = '<a href="#" class="badge badge-light" style="background-color: #ffe300;">ING </a>';}
                                        if($idc == "28"){$type = '<a href="#" class="badge badge-primary" style="background-color: #ff57b6;">ART </a>';}
                                        if( $idc == "517"){$type = '<a href="#" class="badge badge-primary" style="background-color: #8b4fbd;">TEC </a>';}
                                        if($idc == "20013" || $idc == "6" || $idc == "20003" || $idc == "4474"){$type = '<a href="#" class="badge badge-primary" style="background-color: #00c61f;">CIE </a>';}
                                        if($idc == "9845" || $idc == "20005" ){$type = '<a href="#" class="badge badge-light" style="background-color: aqua;">DEP </a>';}
                                        if($idc == "20004"){$type = '<a href="#" class="badge badge-light" style="background-color: #ffdac4;">DEP </a>';}
                                        if($idc == "22"){$type = '<a href="#" class="badge badge-light" style="background-color: #f4d3c6;">ORI </a>';}
                                        if($idc == "474"){$type = '<a href="#" class="badge badge-light" style="background-color: #f4d3c6;">ETI </a>';}
                                        if($idc == "20012" || $idc == "2280" || $idc == "20002" || $idc == "2971"){$type = '<a href="#" class="badge badge-primary" style="background-color: #ec9422;">HIS </a>';}
                                        if($idc == "999"){$type = '<a href="#" class="badge badge-primary" style="background-color: #a8a8a8;">PSY </a>';}
                                        if($idc == "1493"){$type = '<a href="#" class="badge badge-primary" style="background-color: #006166;">PRO </a>';}
                                    @endphp
                                    <th scope="col" style="min-width: 40px;text-align: center">
                                        {{$mes[intval(substr($horario["date_day"],5,2))]}}
                                        <hr style="margin: 0px">
                                        <span class="text-secondary">{{$sem[date('w',strtotime($horario["date_day"]))]}}</span>
                                        <br>
                                        <span class="text-secondary">{{intval(substr($horario["date_day"],8))}}</span>
                                        <br>
                                        {!!$type!!}
                                        <div style="font-weight: lighter;">
                                            {{substr($horario["hora_inicio"],0,5)}}<br>|<br>{{substr($horario["hora_fin"],0,5)}}
                                        </div>
                                    </th>
                                @endforeach
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
                                    @foreach ($dias_activos as $horario)
                                        <th style="text-align: center;">
                                            <div id="tooltip{{$alumno["id_stu"]}}-class{{$horario["id_class"]}}-bloq{{$horario["id_bloq"]}}-date{{$horario["date_day"]}}">
                                                <input id="input-stu{{$alumno["id_stu"]}}-class{{$horario["id_class"]}}-bloq{{$horario["id_bloq"]}}-date{{$horario["date_day"]}}" class="form-control form-control-sm refdate-all refdate-bloq{{$horario["id"]}}-{{$horario["date_day"]}}" stu="{{$alumno["id_stu"]}}" data="{{$horario["date_day"]}}" bloq="{{$horario["id"]}}" type="text" style="width: 30px;font-size: 0.8rem;text-transform:uppercase;font-weight: bold;display: inline;background-color: white;" maxlength="1" placeholder="" readonly="">
                                            </div>
                                        </th>
                                    @endforeach
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
                            @elseif($row["type_a"] == "1")
                                $("#input-stu{{$row["id_student"]}}-class{{$row["id_class"]}}-bloq{{$row["id_bloq"]}}-date{{$row["assistance"]}}").css("color","red");
                            @elseif($row["type_a"] == "R")
                                $("#input-stu{{$row["id_student"]}}-class{{$row["id_class"]}}-bloq{{$row["id_bloq"]}}-date{{$row["assistance"]}}").css("color","darkorange");
                            @endif
                            $("#input-stu{{$row["id_student"]}}-class{{$row["id_class"]}}-bloq{{$row["id_bloq"]}}-date{{$row["assistance"]}}").val("{{$row["type_a"]}}");
                            //justify
                            @if($row["type_a"] == "J" || $row["type_a"] == "A" || $row["type_a"] == "R")
                                $("#tooltip{{$row["id_student"]}}-class{{$row["id_class"]}}-bloq{{$row["id_bloq"]}}-date{{$row["assistance"]}}").attr("data-toggle","tooltip");
                                $("#tooltip{{$row["id_student"]}}-class{{$row["id_class"]}}-bloq{{$row["id_bloq"]}}-date{{$row["assistance"]}}").attr("data-placement","top");
                                $("#tooltip{{$row["id_student"]}}-class{{$row["id_class"]}}-bloq{{$row["id_bloq"]}}-date{{$row["assistance"]}}").attr("title","{{$row["justify"]}}");
                            @endif
                        @endforeach
                        $(function () {
                            $('[data-toggle="tooltip"]').tooltip()
                        })
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
    @else
        <div class="container">
            
        </div>
    @endif
</div>
@endsection