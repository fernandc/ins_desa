<!DOCTYPE html> 


@extends("layouts.mcdn")
@section("title")
Admin Cursos
@endsection

@section("headex")
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
})
</script>
@endsection

@section("context")

<div class="container">
    <h2 style="text-align: center;" id="temp1">Alumnos Inscritos y Pendientes
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
            <a class="nav-link" data="0" href="inscriptions">Todos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="1" href="inscriptions?curso=1">PK</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="2" href="inscriptions?curso=2">KI</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="3" href="inscriptions?curso=3">1B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="4" href="inscriptions?curso=4">2B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="5" href="inscriptions?curso=5">3B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="6" href="inscriptions?curso=6">4B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="7" href="inscriptions?curso=7">5B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="8" href="inscriptions?curso=8">6B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="9" href="inscriptions?curso=9">7B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="10" href="inscriptions?curso=10">8B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="11" href="inscriptions?curso=11">1M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="12" href="inscriptions?curso=12">2M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="13" href="inscriptions?curso=13">3M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="14" href="inscriptions?curso=14">4M</a>
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
    @php $cantidad_mat = 0; @endphp
    @foreach($students as $rowM)
        @if($rowM["id_reg"] != null)
            @php $cantidad_mat++; @endphp
        @endif
    @endforeach
    <span>Inscritos <span class="badge badge-primary" id="cantidadMat">{{$cantidad_mat}}</span> de <span class="badge badge-light">{{count($students)}}</span></span>
    <hr>
    <div class="table-responsive">
        <table class="table table-sm" style="text-align: center;" id="list_students">
            <thead class="thead-light">
                <tr>
                    <th scope="col"># Matricula</th>
                    <th scope="col">Rut</th>
                    <th scope="col">Nombre Completo</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Apoderado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $row)
                <tr>
                        <td>
                            @if ($row["reg_mat"] == 0)
                                <span class="text-danger">Sin # Matricula</span>
                            @else
                                <span class="text-primary">{{$row["reg_mat"]}}</span>
                            @endif
                        </td>
                        <td>{{$row["dni"]}} </td>
                        <td>{{$row["full_name"]}} </td>
                        <td>{{$row["curso"]}}</td>
                        <td>
                            @if ($row["id_reg"] != null)
                            <span class="badge badge-success">Completado</span>
                            @else
                            <span class="badge badge-danger">No Completado</span>
                            @endif
                        </td>
                        <td>
                            @if ($row["id_reg"] != null)
                            <button class="btn btn-outline-secondary btn-sm data-apo" data="{{$row["dni"]}}" data-toggle="modal" data-target=".bd-example-modal-xl">Ver Apoderado</button>
                            @endif
                        </td>
                    </tr>             
                @endforeach                      
            </tbody>
        </table>
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
                        $("#modalContent").html(data);
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
        } );
    </script>
</div>
@endsection