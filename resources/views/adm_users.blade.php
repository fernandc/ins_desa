<!DOCTYPE html> 


@extends("layouts.mcdn")
@section("title")
Administrar Usuarios
@endsection

@section("headex")

@endsection

@section("context")
    <div class="container">
        <br>
        <h2 style="text-align: center;">Administrar Usuarios</h2>
        <br>
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
                        <th scope="col">Fecha de nacimiento</th>
                        <th scope="col">Administrador</th>
                        <th scope="col">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($staff as $row)
                        <tr>
                            <td>{{$row["dni"]}}</td>
                            <td>{{$row["full_name"]}}</td>
                            <td>{{$row["email"]}}</td>
                            <td>{{$row["birth_date"]}}</td>
                            <td>
                                @if($row["is_admin"]=="YES")
                                    <a href="/change_staff_admin?dni={{$row["dni"]}}" class="btn btn-primary btn-sm text-white" style="width: 45px">Si</a>
                                @else   
                                    <a href="/change_staff_admin?dni={{$row["dni"]}}" class="btn btn-secondary btn-sm text-white" style="width: 45px">No</a>
                                @endif
                            </td>
                            <td>
                                @if($row["status"] == 1)
                                    <a href="/change_staff_status?dni={{$row["dni"]}}" class="btn btn-primary btn-sm">Activado</a>    
                                @else
                                    <a href="/change_staff_status?dni={{$row["dni"]}}" class="btn btn-secondary btn-sm">Desactivado</a>
                                @endif
                            </td>
                        </tr>                
                    @endforeach             
                </tbody>
            </table>
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