<!DOCTYPE html> 


@extends("layouts.mcdn")
@section("title")
Administrar Usuarios
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
        <h2 style="text-align: center;">Administrar Usuarios</h2>
        <hr>
        <button class="btn btn-success " type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Agregar nuevo usuario</button>
        <br>
        <div class="collapse mt-2" id="collapseExample">
            <form class="row" action="add_user" method="GET">
                <div class="form-group col-3">
                    <label for="nameAdd">Nombre Completo</label>
                    <input type="text" class="form-control" name="full_name" placeholder="Nombre" required="">
                </div>
                <div class="form-group col-3">
                    <label for="dniAdd">Rut</label>
                    <input type="text" class="form-control" name="dni" placeholder="12.345.678-9" required="">
                </div>
                <div class="form-group col-3">
                    <label for="birth_dateAdd">Fecha de nacimiento</label>
                    <input type="date" class="form-control" name="birth_date" placeholder="" required="">
                </div>
                <div class="form-group col-3">
                    <label for="emailAdd">Correo</label>
                    <input type="email" class="form-control" name="email" placeholder="Correo" required="">
                </div>

                <div class="form-group col-4">
                    <label for="emailAdd" style="color: white;">.</label>
                    <button id="sendform" type="submit" class="form-control btn btn-success">Agregar</button>
                </div>
            </form>
        </div>

        <br>
        <div class="table-responsive">
            <table class="table table-sm" style="text-align: center;" id="lista_staff">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Rut</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Administrador</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Privilegios</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($staff as $row)
                        <tr>
                            <td>{{$row["dni"]}}</td>
                            <td>{{$row["full_name"]}}</td>
                            <td>{{$row["email"]}}</td>
                            <td>
                                @if($row["is_admin"]=="YES")
                                    <a href="change_staff_admin?dni={{$row["dni"]}}" class="btn btn-primary btn-sm text-white" style="width: 45px">Si</a>
                                @else   
                                    <a href="change_staff_admin?dni={{$row["dni"]}}" class="btn btn-secondary btn-sm text-white" style="width: 45px">No</a>
                                @endif
                            </td>
                            <td>
                                @if($row["status"] == 1)
                                    <a href="change_staff_status?dni={{$row["dni"]}}" class="btn btn-primary btn-sm">Activado</a>    
                                @else
                                    <a href="change_staff_status?dni={{$row["dni"]}}" class="btn btn-secondary btn-sm">Desactivado</a>
                                @endif
                            </td>
                            <td><button class="btn btn-outline-primary btn-sm data-priv" data="{{$row["dni"]}}" data-toggle="modal" data-target=".bd-example-modal-xl">Administrar</button></td>
                        </tr>                
                    @endforeach
                </tbody>
            </table>
            <script>
                $(".data-priv").click(function(){
                    var dni = $(this).attr('data');
                    Swal.fire({
                        icon: 'info',
                        title: 'Cargando',
                        showConfirmButton: false,
                    })
                    $.ajax({
                        type: "GET",
                        url: "modal_privileges",
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
                $('#lista_staff').DataTable({
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