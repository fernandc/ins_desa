<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Admin Profesores
@endsection

@section("headex")
<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
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
    <h2 style="text-align: center;">Administrar Profesores 
            @if(Session::has('period'))
                {{Session::get('period')}}
            @endif
    </h2>
    <hr>
    @if(isset($message))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{$message}}',
            })
        </script>
    @endif
    
    <div class="table-responsive">
        <table class="table table-sm" style="text-align: center;" id="list_teachers">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Rut</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Jefatura</th>
                    <th scope="col">Clases</th>
                </tr>
            </thead>
            <tbody>
                @foreach($staff as $row)
                    @php
                        $cursos = 0;
                        $asignaturas = 0;
                    @endphp
                    <?php $id_staff = str_replace([".","-"], "", $row["dni"]);?>
                    <tr>
                        <td>{{$row["dni"]}}</td>
                        <td>{{$row["full_name"]}}</td> 
                        <td>
                            <select name="select" class="form-control" id="select{{$id_staff}}">
                                <option value="0">Seleccionar...</option>
                                @foreach($grades as $row2)
                                    @if($row["full_name"] == $row2["profesor"] )
                                        <option selected value="{{$row2["id"]}}" >{{$row2["nombre_curso"]}} - {{$row2["seccion"]}}</option>
                                    @else
                                        <option value="{{$row2["id"]}}" >{{$row2["nombre_curso"]}} - {{$row2["seccion"]}}</option>  
                                    @endif
                                @endforeach
                            </select>
                            <script>
                                //var table = $('#list_teachers').DataTable();
                                $("#select{{$id_staff}}").change(function(){
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Cargando',
                                        showConfirmButton: false,
                                    });
                                    var id_curso = $(this).val();
                                    $.ajax({
                                        type: "GET",
                                        url: "set_jefatura",
                                        data:{
                                            dni:'{{$row["dni"]}}',
                                            id: id_curso,  
                                        },
                                        success: function (data)
                                        {
                                            location.reload(true);
                                        }
                                    });
                                })
                            </script>
                        </td> 
                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl" id="modalAsignatura{{$id_staff}}">Administrar</button>                           
                            <script>
                                $("#modalAsignatura{{$id_staff}}").click(function(){
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Cargando',
                                        showConfirmButton: false,
                                    })
                                    $.ajax({
                                        type: "GET",
                                        url: "modal_asignatura",
                                        data:{
                                            full_name:'{{$row["full_name"]}}',
                                            dni:'{{$row["dni"]}}'
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
                        </td>
                    </tr>               
                @endforeach   
                <div class="modal fade bd-example-modal-xl" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" >
                        <div class="modal-content" id="modalContent">
                        </div>
                    </div>
                </div>   
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready( function () {
            $('#list_teachers').DataTable({
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
        } );
    </script>
</div>
@endsection