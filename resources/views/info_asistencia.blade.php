<!DOCTYPE html> 

@extends("layouts.mcdn")

@section("title")
Asistencias
@endsection

@section("headex")
    <style>
        .card-body nav a.nav-link:hover{
            color: #ff8300 !important
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
        $mes[1] = "Enero";
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
        $materias = [];
    @endphp
    @foreach ($clases as $clase)
        @php
        
            if(isset($_GET['curso'])){
                if($clase["id_curso"] == $_GET['curso']){
                    $materias[$clase["id_materia"]] = $clase["materia"];
                    $curso = $clase["curso"];
                }
                if(isset($_GET['materia'])){
                    if($clase["id_materia"] == $_GET['materia']){
                        
                    }
                }
            }
        @endphp
    @endforeach
    <div class="row" style="margin: 0px;">
        @if (isset($_GET["curso"]))
            <div id="contentmat" class="col-md-2">
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
            @if (isset($_GET["materia"]) && isset($materias[$_GET["materia"]]))
            <div id="contentlist" class="col-md-10">
                <ul id="contentmonths" class="nav nav-tabs justify-content-center">
                    
                    @for ($i = 1; $i <= 12; $i++)
                        @if ($_GET["mes"] == $i)
                            <li class="nav-item">
                                <a class="nav-link active">{{$mes[$i]}}</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="checks_points?curso={{$_GET["curso"]}}&materia={{$_GET["materia"]}}&mes={{$i}}">{{$mes[$i]}}</a>
                            </li>
                        @endif
                    @endfor
                </ul>
                <div class="card">
                    <div class="card-header scroll1" style="overflow-x: auto;">
                        <div id="scrollw">
                            <button id="expand" class="btn btn-secondary btn-sm"><i class="fas fa-expand"></i></button>
                            Asistencia de <span class='text-primary'>{{$materias[$_GET["materia"]]}}</span> - <span class='text-primary'>{{$curso}}</span>
                            
                        </div>
                    </div>
                    <div class="card-body table-responsive scroll2" style="padding: 0px;">
                        <table id="listtable" class="table table-hover table-bordered table-sm" style="font-size: 0.9rem;">
                            <thead>
                              <tr>
                                <th scope="col" style="min-width: 260px">Alumnos</th>
                                <th scope="col"><i style="font-size: x-large;" class="fas fa-user-check text-success"></i></th>
                                <th scope="col"><i style="font-size: x-large;" class="fas fa-user-clock text-warning"></i></th>
                                <th scope="col"><i style="font-size: x-large;" class="fas fa-user-slash text-danger"></i></th>
                                <th scope="col"><i style="font-size: x-large;" class="fas fa-user-shield text-info"></i></th>
                                <th scope="col"><i style="font-size: x-large;" class="fas fa-user-minus text-secondary"></i></th>
                                @for ($i = 1; $i <= $lastd; $i++)
                                    @php
                                        $today = date('w',strtotime("$year-$month-$i"));
                                        //dd($today);
                                    @endphp
                                    @if ($today < 5)
                                        <th scope="col" style="min-width: 40px;text-align: center">
                                            {{$sem[$today]}}
                                            <br>
                                            <span class="text-secondary">{{$i}}</span>
                                        </th>
                                    @endif
                                @endfor
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($alumnos as $alumno)
                                    <tr>
                                        <th scope="row">{{$alumno["nombre_stu"]}}</th>
                                        <th scope="col" style="text-align: center;"><a href="#" class="badge badge-light">0</a></th>
                                        <th scope="col" style="text-align: center;"><a href="#" class="badge badge-light">0</a></th>
                                        <th scope="col" style="text-align: center;"><a href="#" class="badge badge-light">0</a></th>
                                        <th scope="col" style="text-align: center;"><a href="#" class="badge badge-light">0</a></th>
                                        <th scope="col" style="text-align: center;"><a href="#" class="badge badge-light">0</a></th>
                                        @for ($i = 1; $i <= $lastd; $i++)
                                            @php
                                                $today = date('w',strtotime("$year-$month-$i"));
                                            @endphp
                                            @if ($today < 5)
                                                <th>
                                                    <input class="form-control form-control-sm" type="text" style="width: 30px;font-size: 0.8rem;" maxlength="1" disabled="" placeholder="">
                                                </th>
                                            @endif
                                        @endfor
                                    </tr>
                                @endforeach
                            </tbody>
                          </table>
                    </div>
                    <script>
                        $(document).ready(function(){
                            var scroll2 = $('#listtable').get(0).scrollWidth;
                            scroll2 = scroll2-20;
                            $("#scrollw").css("width",scroll2);
                        })
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