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
            <a class="nav-link text-success" data="0" href="fileManager">---</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="1" href="fileManager?year={{$selected_year}}&curso=1">PK</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="2" href="fileManager?year={{$selected_year}}&curso=2">KI</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="3" href="fileManager?year={{$selected_year}}&curso=3">1B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="4" href="fileManager?year={{$selected_year}}&curso=4">2B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="5" href="fileManager?year={{$selected_year}}&curso=5">3B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="6" href="fileManager?year={{$selected_year}}&curso=6">4B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="7" href="fileManager?year={{$selected_year}}&curso=7">5B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="8" href="fileManager?year={{$selected_year}}&curso=8">6B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="9" href="fileManager?year={{$selected_year}}&curso=9">7B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="10" href="fileManager?year={{$selected_year}}&curso=10">8B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="11" href="fileManager?year={{$selected_year}}&curso=11">1M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="12" href="fileManager?year={{$selected_year}}&curso=12">2M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="13" href="fileManager?year={{$selected_year}}&curso=13">3M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="14" href="fileManager?year={{$selected_year}}&curso=14">4M</a>
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

        $year =  Session::get('period');
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
                    $id_curso =$_GET['curso'];                    
                }
            }
        @endphp
    @endforeach
    <div class="row" style="margin: 0px;">
        @if (isset($_GET["curso"]))
            <div id="contentmat" class="col-md-2" style="margin-top: 42px;">
                
                <select id="changePeriod" class="custom-select custom-select-lg mb-3">
                    <option selected>AÑO: {{$selected_year}}</option>
                    @foreach ($periods["list_periods"] as $item)
                        @if ($selected_year != $item["year"])
                            <option value="{{$item["year"]}}">Cambiar a {{$item["year"]}}</option>
                        @endif
                    @endforeach
                </select>
                <script>
                    $("#changePeriod").change(function(){
                        Swal.fire({
                            icon: 'info',
                            title: 'Cargando',
                            showConfirmButton: false,
                        });
                        var toyear = $(this).val();
                        window.location.href = "fileManager?year="+toyear+"&curso={{$_GET["curso"]}}";
                    })
                </script>
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
                                    <a class="nav-link text-secondary" href="fileManager?year={{$selected_year}}&curso={{$active}}&materia={{array_search($materia,$materias)}}">{{$materia}}</a>
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
