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
    <div class="mx-4">
        <h2 style="text-align: center;">Administrar Usuarios</h2>
        <button class="btn btn-success " type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Agregar nuevo usuario</button>
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
        <hr>
        @php
            $documents = false;
            if(isset($_GET['documents'])){
                $documents = true;
            }
        @endphp
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link @if((!isset($_GET["tab"])) || (isset($_GET["tab"]) && $_GET["tab"] == "1")) active @endif" id="details-tab" href="?tab=1" role="tab" aria-controls="details" aria-selected="false">Informacion detallada de Personal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(isset($_GET["tab"]) && $_GET["tab"] == "2") active @endif" id="privileges-tab" href="?tab=2" role="tab" aria-controls="privileges" aria-selected="true">Administrar Privilegios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(isset($_GET["tab"]) && $_GET["tab"] == "3") active @endif" id="documents-tab" href="?tab=3" role="tab" aria-controls="documents" aria-selected="true">Administrar documentos y cargos de usuarios</a>
            </li>
        </ul>
        <div class="tab-content mt-2" id="myTabContent">
            @if ((!isset($_GET["tab"])) || (isset($_GET["tab"]) && $_GET["tab"] == "1"))
                <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                    <table class="table display responsive nowrap"style="width: 100%;" id="lista_staff_detail">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Rut</th>
                                <th scope="col">Nombres</th>
                                <th scope="col">Apellido Paterno</th>
                                <th scope="col">Apellido Materno</th>
                                <th scope="col">Cargo</th>
                                <th scope="col">Fecha Nacimiento</th>
                                <th scope="col">Sexo</th>
                                <th scope="col">Nacionalidad</th>
                                <th scope="col">Estado Civil</th>
                                <th scope="col">AFP</th>
                                <th scope="col">ISAPRE</th>
                                <th scope="col">Dirección de Domicilio</th>
                                <th scope="col">Celular</th>
                                <th scope="col">Email Institucional</th>
                                <th scope="col">Email Personal</th>
                                <th scope="col">Banco</th>
                                <th scope="col">Tipo Cuenta</th>
                                <th scope="col">Numero de Cuenta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staff as $row)
                                @if ($row["estado"] == 1 && $row["eliminado"] != "YES")
                                    <tr>
                                        <td>{{$row["rut"]}}</td>
                                        <td>{{$row["nombres"]}}</td>
                                        <td>{{$row["apellido_paterno"]}}</td>
                                        <td>{{$row["apellido_materno"]}}</td>
                                        <td>{{$row["cargo"]}}</td>
                                        <td>{{$row["fecha_nacimiento"]}}</td>
                                        <td>{{$row["sexo"]}}</td>
                                        <td>{{$row["nacionalidad"]}}</td>
                                        <td>{{$row["estado_civil"]}}</td>
                                        <td>{{$row["afp"]}}</td>
                                        <td>{{$row["isapre"]}}</td>
                                        <td>{{$row["direccion"]}} - {{$row["comuna"]}} - {{$row["ciudad"]}}</td>
                                        <td>{{$row["celular"]}}</td>
                                        <td>{{$row["email_institucional"]}}</td>
                                        <td>{{$row["email_personal"]}}</td>
                                        <td>{{$row["banco"]}}</td>
                                        <td>{{$row["tipo_cuenta"]}}</td>
                                        <td>{{$row["numero_cuenta"]}}</td>
                                    </tr> 
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif(isset($_GET["tab"]) && $_GET["tab"] == "2")
                @include('includes.adm_users.privilegios')
            @elseif(isset($_GET["tab"]) && $_GET["tab"] == "3")
                @include('includes.adm_users.documents')	
            @endif
        </div>
        @include('includes.adm_users.ficha')
        <br>
        
        <script>
            $(document).ready( function () {
                $('#lista_staff').DataTable({
                    order: [3, "desc" ],
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
                $('#lista_staff_detail').DataTable({
                    dom: 'Blfrtip',
                    lengthMenu: [
                        [ 10, 25, 50, -1 ],
                        [ '10', '25', '50', 'Todas las' ]
                    ],
                    buttons: {
                        buttons: [
                            { extend: 'csv', className: 'btn-info mb-2', text: "Descargar CSV" },
                            { extend: 'excel', className: 'bg-primary mb-2', text: "Descargar Excel (xlsx)" }
                        ]
                    },
                    order: [2, "desc" ],
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
                $('#lista_staff_documents').DataTable({
                    order: [2, "asc" ],
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