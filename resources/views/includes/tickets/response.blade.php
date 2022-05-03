<div class="row">
    <div class="col-md-12">
        <br class="mt-2">
        <table id="closed" class="table table-hover ">
            <thead>
                <tr>
                    <th scope="col">Emisor</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Asunto</th>
                    <th scope="col">Fechas y Horas</th>
                    <th scope="col">Remuneración</th>
                    <th scope="col">Fecha de envío</th>
                    <th scope="col">Mensajes y documentos</th>
                    <th scope="col">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tickets as $row)
                    @if($row["dni_solicitante"] == Session::get('account')['dni'] || $row["dni_receptor"] == Session::get('account')['dni'])
                        @if ($row["estado"] != "Pendiente")
                            <tr>
                                <td><b class="text-secondary">{{$row["nombre_solicitante"]}}</b></td>
                                <td>
                                    @if ($row["tipo"] == "Solicitud")
                                    <span class="badge badge-primary">Solicitud</span>
                                    @else
                                    <span class="badge badge-info">Justificación</span>
                                    @endif
                                </td>
                                <td>
                                    @if (strlen($row["asunto"]) > 25)
                                        {{substr($row["asunto"], 0, 25)}}...
                                    @else
                                        {{$row["asunto"]}}
                                    @endif
                                </td>
                                <td>
                                    <a href="#" class="badge badge-primary" style="width: 200px;" data-toggle="tooltip" data-placement="top" data-html="true" title="Desde: {{$row["fecha_desde"]}} <br>Hasta: {{$row["fecha_hasta"]}}" >
                                        Inicio y Fin de la {{$row["tipo"]}} <i class="fas fa-calendar-alt"></i>
                                    </a>
                                </td>
                                <td>{{$row["opcional_1"]}}</td>
                                <td>{{$row["fecha_ingreso"]}}</td>
                                <td>
                                    <!-- registers button -->
                                    <button class="btn btn-primary btn-sm trigger-data" data="{{json_encode($row)}}" data-toggle="modal" data-target="#mdl-mensajes-docs">
                                        Mensajes y documentos
                                    </button>
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
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-12">

    </div>
</div>