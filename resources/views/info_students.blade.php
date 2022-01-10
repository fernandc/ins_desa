<!DOCTYPE html> 


@extends("layouts.mcdn")
@section("title")
Admin Cursos
@endsection

@section("headex")
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
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
})
</script>
@endsection

@section("context")

<div class="mx-2">
    <h2 style="text-align: center;" id="temp1">Alumnos
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
                })
        </script>
    @endif
    <hr>
    @if ($has_priv)
    <ul class="nav nav-tabs my-3 justify-content-center">
        <li class="nav-item">
            <a class="nav-link" data="0" href="students">Todos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="1" href="students?curso=1">PK</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="2" href="students?curso=2">KI</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="3" href="students?curso=3">1B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="4" href="students?curso=4">2B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="5" href="students?curso=5">3B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="6" href="students?curso=6">4B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="7" href="students?curso=7">5B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="8" href="students?curso=8">6B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="9" href="students?curso=9">7B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="10" href="students?curso=10">8B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="11" href="students?curso=11">1M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="12" href="students?curso=12">2M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="13" href="students?curso=13">3M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="14" href="students?curso=14">4M</a>
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
    @endif
    <hr>
    <div class="table-responsive">
        <table class="table table-sm" style="text-align: center;" id="list_students">
            <thead class="thead-light">
                <tr>
                    <th scope="col"># Matricula</th>
                    <th scope="col">Rut</th>
                    <th scope="col">Nombre Completo</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Etiquetas</th>
                    <th scope="col">Celular</th>
                    <th scope="col">Apoderado</th>
                    <th scope="col">Ficha del Alumno</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $row)
                    <tr>
                        <td>
                            @if ($row["numero_matricula"] == 0)
                                <span class="text-danger">Sin # Matricula</span>
                            @else
                                <span class="text-primary">{{$row["numero_matricula"]}}</span>
                            @endif
                        </td>
                        <td>{{$row["dni_stu"]}} </td>
                        <td>{{$row["nombre_stu"]}} </td>
                        <td>{{$row["curso"]}}</td>
                        <td>
                            @if ($row["es_nuevo"] == "si")
                                <span class="badge badge-primary"  data-toggle="tooltip" data-placement="top" title="Nuevo">N</span>
                            @endif
                            @if ($row["es_repitente"] == "si")
                                <span class="badge badge-danger"  data-toggle="tooltip" data-placement="top" title="Repitiente">R</span>
                            @endif
                            @if ($row["fecha_retiro"] != null)
                                <span class="badge badge-warning"  data-toggle="tooltip" data-placement="top" title="Retirado: {{$row["fecha_retiro"]}}">R</span>
                            @endif
                        </td>
                        <td>{{$row["cellphone_stu"]}} </td>
                        <td><button class="btn btn-outline-secondary btn-sm data-apo" data="{{$row["dni_stu"]}}" data-toggle="modal" data-target=".bd-example-modal-xl">Ver Apoderado</button></td>
                        <td><button class="btn btn-outline-primary btn-sm data-ficha" data="{{$row["id_stu"]}}" data2="{{$row["id_zmail"]}}" data-toggle="modal" data-target="#ficha">Ver Ficha de Alumno</button></td>
                    </tr>             
                @endforeach                      
            </tbody>
        </table>
    </div>
    <script>
        $(".data-apo").click(function(){
            var dni = $(this).attr('data');
            Swal.fire({
                icon: 'info',
                title: 'Cargando',
                showConfirmButton: false,
            })
            $.ajax({
                type: "GET",
                url: "modal_apoderados",
                data:{
                    dni
                },
                success: function (data)
                {
                    if(data == "" || data == null){
                        Swal.fire({
                            icon: 'info',
                            title: 'Apoderado No Completado'
                        });
                    }else{
                        $("#modalContent").html(data);
                        Toast.fire({
                            icon: 'success',
                            title: 'Completado'
                        })
                    }
                    
                }
            });
        });
        $(".data-ficha").click(function(){
                var id_stu = $(this).attr('data');
                var id_apo = $(this).attr('data2');
                var year = "@if(Session::has('period')){{Session::get('period')}}@endif";
                Swal.fire({
                    icon: 'info',
                    title: 'Cargando',
                    showConfirmButton: false,
                })
                $.ajax({
                    type: "GET",
                    url: "modal_ficha",
                    data:{
                        id_stu,id_apo,year
                    },
                    success: function (data)
                    {
                        $("#modalContentFicha").html(data);
                        Toast.fire({
                            icon: 'success',
                            title: 'Completado'
                        })
                    }
                });
            });
    </script>
    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" >
            <div class="modal-content" id="modalContent">
            </div>
        </div>
    </div>
    <div id="ficha" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" >
            <div class="modal-content" id="modalContentFicha">
            </div>
        </div>
    </div>
    <script>
        $(document).ready( function () {
            $('#list_students').DataTable({
                    "ordering": true,
                    "order": [],
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
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
                    }
                });
        });
    </script>
</div>
@endsection