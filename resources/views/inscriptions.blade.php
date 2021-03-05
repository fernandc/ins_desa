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
    <!-- <button class="btn btn-primary btn-sm ">Administrador de Matrículas</button> -->
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
                    <th scope="col">Registro Matricula</th>
                    <th scope="col">Rut</th>
                    <th scope="col">Nombre Completo</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $row)
                <tr>
                        <td>{{$row["reg_mat"]}} </td>
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
                    </tr>             
                @endforeach                      
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready( function () {
            $('#list_students').DataTable({
                    dom: 'Bfrtip',
                    //order: [],
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
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf'
                    ]
                });
        } );
    </script>
</div>
@endsection