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
    <hr>
    <div class="table-responsive">
        @php
            $listas = array();
        @endphp
        @foreach($students as $row)
            @php
                $id_curso = $row["id_curso"];
                $listas[$id_curso] = array();
                array_push($listas[$id_curso],$row);
            @endphp
        @endforeach
        @php
            dd($listas);
        @endphp
        <table class="table table-sm" style="text-align: center;" id="list_students">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Nombre Alumno</th>
                    <th scope="col">Rut Alumno</th>
                    <th scope="col">Nombre Apoderado</th>
                    <th scope="col">Rut Apoderado</th>
                    <th scope="col">Telefono Apoderado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $row)
                    <tr>
                        <td>{{$row["nombre_stu"]}} </td>
                        <td>{{$row["dni_stu"]}} </td>
                        <td>{{$row["nombre_apo"]}} </td>
                        <td> @php echo substr($row["dni"],0,-1)."-".substr($row["dni"],-1); @endphp </td>
                        <td>{{$row["cell_phone"]}} </td>
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