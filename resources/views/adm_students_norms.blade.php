<!DOCTYPE html> 


@extends("layouts.mcdn")
@section("title")
    Normas no cumplidas
@endsection

@section("headex")
<style>
    .sw-danger:focus~.custom-control-label::before {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 47, 69, 0.25) !important;
    }

    .sw-danger:checked~.custom-control-label::before {
        border-color: #dc3545 !important;
        background-color: #dc3545 !important;
    }

    .sw-danger:active~.custom-control-label::before {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
    }

    .sw-danger:focus:not(:checked)~.custom-control-label::before {
        border-color: #dc3545 !important;
    }

    .sw-danger:not(:disabled):active~.custom-control-label::before {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
    }
    .sw-success:focus~.custom-control-label::before {
        border-color: #28a745 !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 47, 69, 0.25) !important;
    }

    .sw-success:checked~.custom-control-label::before {
        border-color: #28a745 !important;
        background-color: #28a745 !important;
    }

    .sw-success:active~.custom-control-label::before {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
    }

    .sw-success:focus:not(:checked)~.custom-control-label::before {
        border-color: #28a745 !important;
    }
    .sw-success:not(:disabled):active~.custom-control-label::before {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
    }
    .sw-warning:focus~.custom-control-label::before {
        border-color: #ffc107 !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 47, 69, 0.25) !important;
    }

    .sw-warning:checked~.custom-control-label::before {
        border-color: #ffc107 !important;
        background-color: #ffc107 !important;
    }

    .sw-warning:active~.custom-control-label::before {
        background-color: #ffc107 !important;
        border-color: #ffc107 !important;
    }

    .sw-warning:focus:not(:checked)~.custom-control-label::before {
        border-color: #ffc107 !important;
    }

    .sw-warning:not(:disabled):active~.custom-control-label::before {
        background-color: #ffc107 !important;
        border-color: #ffc107 !important;
    }
</style>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

</script>
@endsection

@section("context")
<script>
        Swal.fire({
        title: 'Cargando',
        text: 'Espere un momento',
        onBeforeOpen: () => {
            Swal.showLoading()
        }
    })
</script>
<div class="mx-2">
    <h2 style="text-align: center;" id="temp1">Normas no cumplidas 
        @if(Session::has('period'))
            {{Session::get('period')}}
        @endif            
    </h2>
    @if(isset($message))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{$message}}',
            });
        </script>
    @endif
    <hr>
    <ul class="nav nav-tabs my-3 justify-content-center">
        <li class="nav-item">
            <a class="nav-link" data="0" href="adm_students_norms">Todos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="1" href="adm_students_norms?curso=1">PK</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="2" href="adm_students_norms?curso=2">KI</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="3" href="adm_students_norms?curso=3">1B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="4" href="adm_students_norms?curso=4">2B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="5" href="adm_students_norms?curso=5">3B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="6" href="adm_students_norms?curso=6">4B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="7" href="adm_students_norms?curso=7">5B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="8" href="adm_students_norms?curso=8">6B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="9" href="adm_students_norms?curso=9">7B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="10" href="adm_students_norms?curso=10">8B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="11" href="adm_students_norms?curso=11">1M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="12" href="adm_students_norms?curso=12">2M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="13" href="adm_students_norms?curso=13">3M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="14" href="adm_students_norms?curso=14">4M</a>
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
    <div class="table-responsive">
        <table class="table table-sm" style="text-align: center;" id="list_students">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Rut</th>
                    <th scope="col">Curso</th>
                    @foreach ($regulations as $regulation)
                        <th scope="col">No {{$regulation["name"]}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($students as $row)
                    @php
                        $flag = false;
                        $list_section = array();
                    @endphp
                    @foreach ($grades as $row2)
                        @if ($row["id_curso"] == $row2["id_curso"])
                            @php
                                array_push($list_section,$row2["seccion"]);
                                $flag = true;
                            @endphp
                        @endif
                    @endforeach
                    <tr>
                        <td>{{$row["nombre_stu"]}} </td>
                        <td>{{$row["dni_stu"]}}</td>
                        <td>@if($flag) <span class="text-success">{{$row["curso"]}}</span> @else <span class="text-danger">{{$row["curso"]}}</span> @endif </td>
                        <td>
                            <div class="custom-control custom-switch">
                                @if($row["no_cumple_uniforme"] == 1)
                                    <input type="checkbox" class="custom-control-input sw-danger" onchange="toggle1({{$row["id_matricula"]}})" data="" id="norm1s{{$row["id_stu"]}}" checked="">
                                    <label class="custom-control-label text-danger" for="norm1s{{$row["id_stu"]}}" ></label>
                                @else
                                    <input type="checkbox" class="custom-control-input sw-danger" onchange="toggle1({{$row["id_matricula"]}})" data="" id="norm1s{{$row["id_stu"]}}" >
                                    <label class="custom-control-label text-danger" for="norm1s{{$row["id_stu"]}}" ></label>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-switch">
                                @if($row["no_vive_con_apoderado"] == 2)
                                    <input type="checkbox" class="custom-control-input sw-danger" onchange="toggle2({{$row["id_matricula"]}})" data="" id="norm2s{{$row["id_stu"]}}" checked="">
                                    <label class="custom-control-label text-danger" for="norm2s{{$row["id_stu"]}}" ></label>
                                @else
                                    <input type="checkbox" class="custom-control-input sw-danger" onchange="toggle2({{$row["id_matricula"]}})" data="" id="norm2s{{$row["id_stu"]}}" >
                                    <label class="custom-control-label text-danger" for="norm2s{{$row["id_stu"]}}" ></label>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready( function () {
            Swal.close();
            Toast.fire({
                icon: 'success', 
                title: 'Carga exitosa'
            })
            $('#list_students').DataTable({
                order: [],
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Filas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Filas",
                    "infoFiltered": "(Filtrado de MAX total Filas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Filas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                        }
                },
            });
            
        });
        @foreach($regulations as $regulation)
            function toggle{{$regulation["id"]}}(matricula){
                $.ajax({
                    type: "GET",
                    url: "student_irregulation",
                    data:{
                        id_inscription: matricula,
                        id_regulations: {{$regulation["id"]}}
                    },
                    success: function (data)
                    {
                        Toast.fire({
                            icon: 'success', 
                            title: 'Completado'
                        })
                    }
                });
            }
        @endforeach
    </script>
</div>

@endsection