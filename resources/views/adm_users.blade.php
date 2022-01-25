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
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="false">Informacion detallada de Personal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="privileges-tab" data-toggle="tab" href="#privileges" role="tab" aria-controls="privileges" aria-selected="true">Administrar Privilegios</a>
            </li>
        </ul>
        <div class="tab-content mt-2" id="myTabContent">
            <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                <table class="table display responsive nowrap"style="width: 100%;" id="lista_staff_detail">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Rut</th>
                            <th scope="col">Nombre</th>
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
                            @if ($row["estado"] == 1)
                                <tr>
                                    <td>{{$row["rut"]}}</td>
                                    <td>{{$row["nombre_completo"]}}</td>
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
            <div class="tab-pane fade" id="privileges" role="tabpanel" aria-labelledby="privileges-tab">
                <div class="table-responsive">
                    <table class="table " style="text-align: center;" id="lista_staff">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Rut</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Email Institucional</th>
                                <th scope="col">Administrador</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Privilegios</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staff as $row)
                                <tr>
                                    <td>{{$row["rut"]}}</td>
                                    <td>{{$row["nombre_completo"]}}</td>
                                    <td>{{$row["email_institucional"]}}</td>
                                    <td>
                                        @if($row["administrador"]=="YES")
                                            <a href="change_staff_admin?dni={{$row["rut"]}}" class="btn btn-primary btn-sm text-white" style="width: 45px">Si</a>
                                        @else   
                                            <a href="change_staff_admin?dni={{$row["rut"]}}" class="btn btn-secondary btn-sm text-white" style="width: 45px">No</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($row["estado"] == 1)
                                            <a href="change_staff_status?dni={{$row["rut"]}}" class="btn btn-primary btn-sm">Activado</a>    
                                        @else
                                            <a href="change_staff_status?dni={{$row["rut"]}}" class="btn btn-secondary btn-sm">Desactivado</a>
                                        @endif
                                    </td>
                                    <td><button class="btn btn-outline-primary btn-sm data-priv" data="{{$row["rut"]}}" data-toggle="modal" data-target=".bd-example-modal-xl">Administrar</button></td>
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
            </div>
            
        </div>


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
            } );
        </script>
    </div>
@endsection