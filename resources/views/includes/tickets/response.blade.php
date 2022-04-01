<div class="row">
    <div class="col-md-12">
        <hr>
        <h3 class="mb-3">Registros Pendientes:</h3>
        <table id="toresponse" class="table table-hover ">
            <thead>
            <tr>
                <th scope="col">Tipo</th>
                <th scope="col">De</th>
                <th scope="col">Asunto</th>
                <th scope="col">Para el día</th>
                <th scope="col">Fecha de envío</th>
                <th scope="col">Adjuntos</th>
                <th scope="col">Mensajes</th>
                <th scope="col">Estado</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $row)
                    @if($row["dni_receptor"] == Session::get('account')['dni'] && $row["estado"] == "Pendiente")
                        <tr style="height: 75px;">
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
                            <td><button class="btn btn-info btn-sm"> Ver Mensajes</button></td>
                            <td>
                                @if ($row["estado"] == "Pendiente")
                                    <span class="badge badge-secondary">Pendiente</span>
                                @elseif($row["estado"] == "Aprobado")
                                    <span class="badge badge-success">Aprobado</span>
                                @else
                                    <span class="badge badge-danger">Rechazado</span>
                                @endif
                            </td>
                        </tr>
                    @endif    
                @endforeach
            </tbody>
        </table>
    </div>
    @foreach ($tickets as $row)
        @if($row["dni_receptor"] == Session::get('account')['dni'] && $row["estado"] == "Pendiente")
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