<!DOCTYPE html> 

@extends("layouts.mcdn")

@section("title")
Gestor de Archivos
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
            <a class="nav-link text-success" data="0" href="fileManager">HOY</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="1" href="fileManager?curso=1">PK</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="2" href="fileManager?curso=2">KI</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="3" href="fileManager?curso=3">1B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="4" href="fileManager?curso=4">2B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="5" href="fileManager?curso=5">3B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="6" href="fileManager?curso=6">4B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="7" href="fileManager?curso=7">5B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="8" href="fileManager?curso=8">6B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="9" href="fileManager?curso=9">7B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="10" href="fileManager?curso=10">8B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="11" href="fileManager?curso=11">1M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="12" href="fileManager?curso=12">2M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="13" href="fileManager?curso=13">3M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="14" href="fileManager?curso=14">4M</a>
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
        $materias = [];
        $id_curso_periodo = "";
        
    @endphp
    @foreach ($clases as $clase)
        @php
            if(isset($_GET['curso'])){
                if($clase["id_curso"] == $_GET['curso']){
                    $materias[$clase["id_materia"]] = $clase["materia"];
                    $curso = $clase["curso"];
                    $id_curso_periodo = $clase["id_curso_periodo"];
                    
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
                                    <a class="nav-link text-secondary" href="fileManager?curso={{$active}}&materia={{array_search($materia,$materias)}}&mes={{date('m')}}">{{$materia}}</a>
                                @endif
                            @endforeach
                        </nav>
                    </div>
                </div>
            </div>
            @if (isset($_GET["materia"]) && isset($materias[$_GET["materia"]]))
                <div id="contentFileManager" class="col-md-10">
                    @include('ldc.file_manager.archivos_table')
                </div>
            @endif
        @else
            <div class="container">
                
            </div>
        @endif
    </div>
@endsection

{{-- Mobile View  actual problema con data table--}}
{{-- <script>
    $(document).ready( function (){
        const pageWidth  = document.documentElement.scrollWidth;
        const pageHeight = document.documentElement.scrollHeight;
        var z = document.getElementById("cardTableFiles");
        document.ready
        if(pageWidth < 500){

            $("#contentFileManager").attr("disabled","disabled");
            $("#contentmat").attr("disabled","disabled");
        }
    });
</script> --}}
