<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
    Solicitudes y Justificaciones
@endsection

@section("headex")

@endsection

@section("context")
    @php
        $solicitudes = [];
        $respuestas = [];
        foreach($tickets as $row){
            if($row["dni_solicitante"] == Session::get('account')['dni']){

            }
            if($row["dni_solicitante"] == Session::get('account')['dni']){
                
            }
        }
    @endphp
    <hr>
    <div class="mx-4">
        <div class="text-center">
            <h2>Solicitudes y Justificaciones</h2>
            <hr>
        </div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="sended-tab" data-toggle="tab" href="#sended" role="tab" aria-controls="sended" aria-selected="true">Enviados y su Estado</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="sendrequest-tab" data-toggle="tab" href="#sendrequest" role="tab" aria-controls="sendrequest" aria-selected="false">Enviar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="responserequest-tab" data-toggle="tab" href="#responserequest" role="tab" aria-controls="responserequest" aria-selected="false">Responder y Respuestas</a>
            </li>
            @if ($all_tickets != null)
            <li class="nav-item">
                <a class="nav-link" id="allrequest-tab" data-toggle="tab" href="#allrequest" role="tab" aria-controls="allrequest" aria-selected="false">Ver Todos</a>
              </li>
            @endif
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="sended" role="tabpanel" aria-labelledby="sended-tab">
                <br class="mt-2">
                <table id="requesttable" class="table table-hover ">
                    <thead>
                      <tr>
                        <th scope="col">Tipo</th>
                        <th scope="col">Asunto</th>
                        <th scope="col">Para el día</th>
                        <th scope="col">Día remunerado</th>
                        <th scope="col">Fecha de envío</th>
                        <th scope="col">Adjuntos</th>
                        <th scope="col">Estado</th>
                        <th scope="col" style="min-width: 300px;">Mensaje de Respuesta</th>
                        <th scope="col">Fecha de Respuesta</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $row)
                            @if($row["dni_solicitante"] == Session::get('account')['dni'])
                                <tr>
                                    <td>
                                        @if ($row["tipo"] == "Solicitud")
                                            <span class="badge badge-primary">Solicitud</span>
                                        @else
                                            <span class="badge badge-info">Justificación</span>
                                        @endif
                                    </td>
                                    <td>{{$row["asunto"]}}</td>
                                    <td>{{substr($row["fecha_para"],0,10)}}</td>
                                    <td>{{$row["opcional_1"]}}</td>
                                    <td>{{$row["fecha_ingreso"]}}</td>
                                    <td class="text-center">
                                        @if (($row["ruta_archivo_1"] == "" || $row["ruta_archivo_1"] == null ) && ($row["ruta_archivo_2"] == "" || $row["ruta_archivo_2"] == null ) && ($row["ruta_archivo_3"] == "" || $row["ruta_archivo_3"] == null ))
                                            <span class="badge badge-light">Sin Documentos</span>
                                        @else
                                            @for ($i = 1; $i <= 3; $i++)
                                                @if($row["ruta_archivo_$i"] != "")
                                                    <a href="download?path={{$row["ruta_archivo_$i"]}}" target="_blank">
                                                    @php
                                                        $path_parts = pathinfo($row["ruta_archivo_$i"]);
                                                        if($path_parts['extension'] == "pdf"){
                                                            echo '<i class="far fa-file-pdf fa-2x text-danger"></i>';
                                                        }else if($path_parts['extension'] == "docx"){
                                                            echo '<i class="far fa-file-word fa-2x text-primary"></i>';
                                                        }else{
                                                            echo '<i class="far fa-file fa-2x"></i>';
                                                        }
                                                    @endphp
                                                    </a>
                                                @endif
                                            @endfor
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row["estado"] == "Pendiente")
                                            <span class="badge badge-secondary">Pendiente</span>
                                        @elseif($row["estado"] == "Aprobado")
                                            <span class="badge badge-success">Aprobado</span>
                                        @else
                                            <span class="badge badge-danger">Rechazado</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row["estado"] == "Pendiente")
                                            <span class="badge badge-secondary">Pendiente</span>
                                        @else
                                            @if ($row["respuesta"] == null)
                                                <span class="badge badge-secondary">Sin mensaje de respuesta</span>
                                            @else
                                                @if (strlen($row["respuesta"]) > 90)
                                                    <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapse{{$row["id"]}}" aria-expanded="false" aria-controls="collapse{{$row["id"]}}">
                                                        Ver mensaje de respuesta
                                                    </button>
                                                    <div class="collapse" id="collapse{{$row["id"]}}">
                                                        <div class="card card-body">
                                                            {{$row["respuesta"]}}
                                                        </div>
                                                    </div>
                                                @else
                                                    
                                                @endif
                                                
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($row["fecha_ingreso"] == $row["fecha_actualizacion"])
                                            <span class="badge badge-secondary">Pendiente</span>
                                        @else
                                            {{$row["fecha_actualizacion"]}}
                                        @endif
                                    </td>
                                </tr>
                            @endif    
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="sendrequest" role="tabpanel" aria-labelledby="sendrequest-tab">
                @include('includes/tickets/request')
            </div>
            <div class="tab-pane fade" id="responserequest" role="tabpanel" aria-labelledby="responserequest-tab">
                @include('includes/tickets/response')
            </div>
            @if ($all_tickets != null)
                <div class="tab-pane fade" id="allrequest" role="tabpanel" aria-labelledby="allrequest-tab">
                    <table id="alltickets" class="table table-hover ">
                        <thead>
                        <tr>
                            <th scope="col">Tipo</th>
                            <th scope="col">De</th>
                            <th scope="col">Asunto</th>
                            <th scope="col">Para el día</th>
                            <th scope="col">Día remunerado</th>
                            <th scope="col">Fecha de envío</th>
                            <th scope="col">Adjuntos</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Respuesta</th>
                            <th scope="col">Fecha de Respuesta</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_tickets as $row)
                                <tr>
                                    <td>
                                        @if ($row["tipo"] == "Solicitud")
                                            <span class="badge badge-primary">Solicitud</span>
                                        @else
                                            <span class="badge badge-info">Justificación</span>
                                        @endif
                                    </td>
                                    <td>{{$row["nombre_solicitante"]}}</td>
                                    <td>{{$row["asunto"]}}</td>
                                    <td>{{substr($row["fecha_para"],0,10)}}</td>
                                    <td>{{$row["opcional_1"]}}</td>
                                    <td>{{$row["fecha_ingreso"]}}</td>
                                    <td class="text-center">
                                        @if (($row["ruta_archivo_1"] == "" || $row["ruta_archivo_1"] == null ) && ($row["ruta_archivo_2"] == "" || $row["ruta_archivo_2"] == null ) && ($row["ruta_archivo_3"] == "" || $row["ruta_archivo_3"] == null ))
                                            <span class="badge badge-light">Sin Documentos</span>
                                        @else
                                            @for ($i = 1; $i <= 3; $i++)
                                                @if($row["ruta_archivo_$i"] != "")
                                                    <a href="download?path={{$row["ruta_archivo_$i"]}}" target="_blank">
                                                    @php
                                                        $path_parts = pathinfo($row["ruta_archivo_$i"]);
                                                        if($path_parts['extension'] == "pdf"){
                                                            echo '<i class="far fa-file-pdf fa-2x text-danger"></i>';
                                                        }else if($path_parts['extension'] == "docx"){
                                                            echo '<i class="far fa-file-word fa-2x text-primary"></i>';
                                                        }else{
                                                            echo '<i class="far fa-file fa-2x"></i>';
                                                        }
                                                    @endphp
                                                    </a>
                                                @endif
                                            @endfor
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row["estado"] == "Pendiente")
                                            <span class="badge badge-secondary">Pendiente</span>
                                        @elseif($row["estado"] == "Aprobado")
                                            <span class="badge badge-success">Aprobado</span>
                                        @else
                                            <span class="badge badge-danger">Rechazado</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($row["respuesta"] == null)
                                            <span class="badge badge-secondary">Sin mensaje de respuesta</span>
                                        @else
                                            @if (strlen($row["respuesta"]) > 90)
                                                <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapse{{$row["id"]}}" aria-expanded="false" aria-controls="collapse{{$row["id"]}}">
                                                    Ver mensaje de respuesta
                                                </button>
                                                <div class="collapse" id="collapse{{$row["id"]}}">
                                                    <div class="card card-body">
                                                        {{$row["respuesta"]}}
                                                    </div>
                                                </div>
                                            @else
                                                {{$row["respuesta"]}}
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($row["fecha_ingreso"] == $row["fecha_actualizacion"])
                                            <span class="badge badge-secondary">Pendiente</span>
                                        @else
                                            {{$row["fecha_actualizacion"]}}
                                        @endif
                                    </td>
                                </tr>   
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <hr>
    <script>
        $(document).ready( function () {
            $(".response-request").click(function(){
                var idrequest = $(this).attr("data");
                var datasel = $(this).attr("datasel");
                var datacolor = $(this).attr("datacolor");
                var message = $("#responsemessage"+idrequest).val();
                var respuesta = $(this).val();
                Swal.fire({
                    title: 'Se ha elegido: '+datasel,
                    text: "Esta respuesta no se puede cambiar",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: datacolor,
                    cancelButtonColor: '',
                    confirmButtonText: datasel,
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: "response_ticket",
                            data:{
                                idrequest,
                                respuesta,
                                message
                            },
                            success: function (data){
                                if(data == 200){
                                    Swal.fire(
                                        'Enviado!',
                                        'La respuesta ha sido enviada',
                                        'success'
                                    );
                                    $("#divrequest"+idrequest).remove();
                                }else{
                                    Swal.fire(
                                        'Error del servidor',
                                        data,
                                        'warning'
                                    );
                                }
                            }
                        });
                    }
                });
            });
            $('#requesttable').DataTable({
                "ordering": true,
                "order": [[4 , "desc"]],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                language: {
                    "decimal": "",
                    "emptyTable": "No hay resultados",
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
            $('#toresponse').DataTable({
                "ordering": true,
                "pageLength" : 5,
                "order": [[5 , "asc"]],
                "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "Todos"]],
                language: {
                    "decimal": "",
                    "emptyTable": "No hay resultados",
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
            $('#answeredtable').DataTable({
                "ordering": true,
                "order": [[5 , "desc"]],
                "pageLength" : 5,
                "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "Todos"]],
                language: {
                    "decimal": "",
                    "emptyTable": "No hay resultados",
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
            @if ($all_tickets != null)
            $('#alltickets').DataTable({
                "ordering": true,
                "order": [[4 , "asc"]],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                language: {
                    "decimal": "",
                    "emptyTable": "No hay resultados",
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
            @endif
        });
    </script>
@endsection