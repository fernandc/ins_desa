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
                <div class="row was-validated mt-3">
                    <div class="col-md-4">
                        <label for="optionSelect" class="form-label">Seleccione Solicitud o Justificación</label>
                        <select class="custom-select is-valid" id="optionSelect" autocomplete="off" required="">
                            <option selected="" disabled="" value="">Seleccione una Opción</option>
                            <option>Solicitud</option>
                            <option>Justificación</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <span>Ejemplos de Solicitudes y Justificaciones: </span>
                        <ul>
                            <li>Por ausencia de día(s) </li>
                            <li>Retiros dentro de la jornada laboral o atrasos </li>
                            <li class="text-danger">Las Solicitudes deben ser con al menos 48 horas de anticipación</li>
                        </ul>
                    </div>
                    <div class="col-md-12 team-b" style="display: none;">
                        <label for="txtSubject">Asunto de la <span class="referer-team"></span> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control is-invalid" id="txtSubject" minlength="5" required="" autocomplete="off">
                    </div>
                    <div class="col-md-12 team-b" style="display: none;">
                        <label for="txtBody">Detalles y/o Mensaje de la <span class="referer-team"> </span> <span class="text-secondary">(Importante)</span></label>
                        <textarea class="form-control is-invalid" id="txtBody" rows="2"  autocomplete="off"></textarea>
                    </div>
                    <div class="col-md-6 team-b" style="display: none;">
                        <label for="optionSelect" class="form-label"><span class="referer-team"> </span> para la fecha <span class="text-danger">*</span> <span id="datetomessage" class="text-danger"></span></label>
                        <input class="form-control is-invalid" type="date" id="txtDateTo" autocomplete="off" required="">
                    </div>
                    <div class="col-md-6 team-b" style="display: none;">
                        <label for="selRemuneracion" class="form-label">La <span class="referer-team"> </span> ¿debe ser remunerada? <span class="text-danger">*</span></label>
                        <select class="custom-select is-invalid" id="selRemuneracion" autocomplete="off" required="">
                            <option selected="" disabled="" value="">Seleccione una Opción</option>
                            <option>No</option>
                            <option>Si</option>
                        </select>
                    </div>
                    <div class="col-md-4 custom-file team-b mb-5" style="display: none;">
                        <label for="file1" class="form-label mt-2" >Archivo 1 opcional para la <span class="referer-team"> </span></label>
                        <input type="file" class="custom-file-input" id="file1" accept=".docx,.pdf,image/*" autocomplete="off">
                        <label class="custom-file-label" for="file1" style="top: auto;margin-left: 15px;margin-right: 15px;">Adjuntar Archivo</label>
                    </div>
                    <div class="col-md-4 custom-file team-b mb-5" style="display: none;">
                        <label for="file2" class="form-label mt-2" >Archivo 2 opcional para la <span class="referer-team"> </span></label>
                        <input type="file" class="custom-file-input" id="file2" accept=".docx,.pdf,image/*" autocomplete="off">
                        <label class="custom-file-label" for="file2" style="top: auto;margin-left: 15px;margin-right: 15px;">Adjuntar Archivo</label>
                    </div>
                    <div class="col-md-4 custom-file team-b mb-5" style="display: none;">
                        <label for="file3" class="form-label mt-2" >Archivo 3 opcional para la <span class="referer-team"> </span></label>
                        <input type="file" class="custom-file-input" id="file3" accept=".docx,.pdf,image/*" autocomplete="off">
                        <label class="custom-file-label" for="file3" style="top: auto;margin-left: 15px;margin-right: 15px;">Adjuntar Archivo</label>
                    </div>
                    <div class="col-md-4 team-b" style="display: none;">
                    </div>
                    <div class="col-md-4 team-b mt-2" style="display: none;">
                        <button id="btnSubmit" class="btn btn-secondary w-100" disabled="">Enviar <span class="referer-team"> </span></button>
                    </div>
                    <div class="col-md-4 team-b" style="display: none;">
                    </div>
                    <div class="col-md-12 " id="response">
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="responserequest" role="tabpanel" aria-labelledby="responserequest-tab">
                <div class="row">
                    @foreach ($tickets as $row)
                        @if($row["dni_receptor"] == Session::get('account')['dni'])
                            <div class="col-md-6 mt-3" id="divrequest{{$row["id"]}}">
                                <div class="card" >
                                    <div class="card-body">
                                        <h5 class="card-title">{{$row["asunto"]}}</h5>
                                        <h6 class="card-subtitle mb-2">
                                            De: <span class="badge badge-light">{{$row["nombre_solicitante"]}}</span>
                                            <br class="mb-1">
                                            @if ($row["tipo"] == "Solicitud")
                                                <span class="badge badge-primary">Solicitud</span>
                                            @else
                                                <span class="badge badge-info">Justificación</span>
                                            @endif
                                        </h6>
                                        <p class="card-text">
                                            {{$row["mensaje"]}}
                                            <hr>
                                            Fecha de Envío: <span class="badge badge-light">{{$row["fecha_ingreso"]}}</span>
                                            <br>
                                            Fecha de {{$row["tipo"]}}: <span class="badge badge-light">{{substr($row["fecha_para"],0,10)}}</span>
                                            <hr>
                                            Solicita remuneración del día: 
                                            @if ($row["opcional_1"] == "Si")
                                                <span class="badge badge-success">Si</span>
                                            @else
                                                <span class="badge badge-secondary">No</span>
                                            @endif
                                        </p>
                                        <hr>
                                        <div>
                                            @if (($row["ruta_archivo_1"] == "" || $row["ruta_archivo_1"] == null ) && ($row["ruta_archivo_2"] == "" || $row["ruta_archivo_2"] == null ) && ($row["ruta_archivo_3"] == "" || $row["ruta_archivo_3"] == null ))
                                                <span class="badge badge-light">Sin Documentos</span>
                                            @else
                                                Documentos Adjuntos:
                                                @for ($i = 1; $i <= 3; $i++)
                                                    @if($row["ruta_archivo_$i"] != "")
                                                        <a class="ml-3" href="download?path={{$row["ruta_archivo_$i"]}}" target="_blank">
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
                                        </div>
                                        <hr>
                                        <div>
                                            <div class="form-group">
                                                <label for="responsemessage{{$row["id"]}}">Agregar Mensaje</label>
                                                <textarea class="form-control" id="responsemessage{{$row["id"]}}" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button class="btn btn-danger response-request" data="{{$row["id"]}}" datasel="Rechazar" datacolor="#dc3545" value="Rechazado">Rechazar</button>
                                            <button class="btn btn-success response-request" data="{{$row["id"]}}" datasel="Aprobar" datacolor="#28a745" value="Aprobado">Aprobar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    <div class="col-md-12">
                        <hr>
                        <h3 class="mb-3">Registro de Respuestas:</h3>
                        <table id="answeredtable" class="table table-hover ">
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
                                @foreach ($tickets as $row)
                                    @if($row["dni_receptor"] == Session::get('account')['dni'] && $row["estado"] != "Pendiente")
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
                                    @endif    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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
            $('#answeredtable').DataTable({
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
        var flag = false;
        var typeSel = "";
        $("#optionSelect").change(function(){
            $(".referer-team").html($(this).val());
            typeSel = $(this).val();
            $(".team-b").show();
            if($(this).val() == "Solicitud"){
                $("#txtDateTo").attr({ "min" : "{{Date('Y-m-d')}}"})
            }else{
                $("#txtDateTo").removeAttr("min");
            }
            $("#file1").on('change',function(e){
                var fileName = e.target.files[0].name;
                $(this).next('.custom-file-label').html(fileName);
            })
        });
        $(":input").on("keyup change", function(e) {
            var valSubject = 0;
            var valDatetov = 0;
            var valRemuner = 0;
            if(typeSel == "Solicitud"){
                if($("#txtDateTo").val() < "{{Date('Y-m-d', strtotime('+3 days'))}}"){
                    $("#datetomessage").html("La fecha de la Solicitud debe ser con 2 días de anticipación de la fecha Actual");
                }else{
                    $("#datetomessage").html("");
                }
            }else{
                $("#datetomessage").html("");
            }
            if($("#txtSubject").val().length >= 5){
                valSubject = 1;
            }else{
                valSubject = 0;
            }
            if($("#txtDateTo").val() != ""){
                valDatetov = 1;
            }else{
                valDatetov = 0;
            }
            if($("#selRemuneracion option:selected").val() != ""){
                valRemuner = 1;
            }else{
                valRemuner = 0;
            }
            if((valSubject+valDatetov+valRemuner) == 3){;
                $("#btnSubmit").removeClass("btn-secondary").addClass("btn-success");
                $("#btnSubmit").removeAttr("disabled");
                flag = true;
            }else{
                $("#btnSubmit").attr("disabled",true);
                $("#btnSubmit").removeClass("btn-success").addClass("btn-secondary");
            }
        });
        $("#btnSubmit").click(function(){
            if(flag){
                Swal.fire({
                    icon: 'info',
                    title: 'Cargando',
                    showConfirmButton: false,
                });
                var formData = new FormData();
                formData.append('_token', "{{csrf_token()}}");
                formData.append('type', $("#optionSelect option:selected").val());
                formData.append('subject', $("#txtSubject").val());
                formData.append('message', $("#txtBody").val());
                formData.append('dateto', $("#txtDateTo").val());
                formData.append('optional1', $("#selRemuneracion option:selected").val());
                formData.append('file1', $('#file1')[0].files[0]);
                formData.append('file2', $('#file2')[0].files[0]);
                formData.append('file3', $('#file3')[0].files[0]);
                $.ajax({
                    url: "send_ticket",
                    type: "POST",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        if(response == "C"){
                            Swal.fire({
                                icon: 'info',
                                title: 'Importante',
                                text: 'la fecha elegida debe ser 2 días adicionales a hoy'
                            });
                        }else if(response == "A"){
                            Swal.fire({
                                icon: 'success',
                                title: 'Completado!',
                                text: 'La '+typeSel+' ha sido enviada'
                            });
                            location.reload();
                        }
                        
                    }
                });
            }
        });
    </script>
@endsection