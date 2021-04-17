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

<div class="mx-2">
    <h2 style="text-align: center;" id="temp1">Apoderados
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
            <a class="nav-link" data="0" href="proxys">Todos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="1" href="proxys?curso=1">PK</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="2" href="proxys?curso=2">KI</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="3" href="proxys?curso=3">1B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="4" href="proxys?curso=4">2B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="5" href="proxys?curso=5">3B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="6" href="proxys?curso=6">4B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="7" href="proxys?curso=7">5B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="8" href="proxys?curso=8">6B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="9" href="proxys?curso=9">7B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="10" href="proxys?curso=10">8B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="11" href="proxys?curso=11">1M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="12" href="proxys?curso=12">2M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="13" href="proxys?curso=13">3M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="14" href="proxys?curso=14">4M</a>
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
                    <th scope="col">Rut</th>
                    <th scope="col">Nombre Completo</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Celular</th>
                    <th scope="col">Alumno</th>
                    <th scope="col">Parentezco</th>
                    <th scope="col">Curso</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $row)
                    <tr>
                        <td>{{$row["dni"]}} </td>
                        <td>{{$row["nombre_apo"]}} </td>
                        <td>{{$row["zmail"]}} </td>
                        <td>{{$row["phone"]}} </td>
                        <td>{{$row["cell_phone"]}} </td>
                        <td>{{$row["nombre_stu"]}} </td>
                        <td>{{$row["apoderado"]}} </td>
                        <td>{{$row["curso"]}}</td>
                    </tr>             
                @endforeach                      
            </tbody>
        </table>
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