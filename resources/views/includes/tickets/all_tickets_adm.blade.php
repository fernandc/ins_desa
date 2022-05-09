<br class="mt-2">
<table id="alltickets" class="table table-hover ">
    <thead>
        <tr>
            <th scope="col">Código</th>
            <th scope="col">Tipo</th>
            <th scope="col">De</th>
            <th scope="col">Asunto</th>
            <th scope="col">Fechas y Horas</th>
            <th scope="col">Remuneración</th>
            <th scope="col">Mensajes y documentos</th>
            <th scope="col">Fecha de envío</th>
            <th scope="col">Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($all_tickets as $row)
        <tr>
            <td><b>{{$row["id"]}}</b></td>
            <td>
                @if ($row["tipo"] == "Solicitud")
                <span class="badge badge-primary">Solicitud</span>
                @else
                <span class="badge badge-info">Justificación</span>
                @endif
            </td>
            <td>{{$row["nombre_solicitante"]}}</td>
            <td>{{$row["asunto"]}}</td>
            <td>
                <a href="#" class="badge badge-primary" style="width: 200px;" data-toggle="tooltip" data-placement="top" data-html="true" title="Desde: {{$row["fecha_desde"]}} <br>Hasta: {{$row["fecha_hasta"]}}" >
                    Inicio y Fin de la {{$row["tipo"]}} <i class="fas fa-calendar-alt"></i>
                </a>
            </td>
            <td>{{$row["opcional_1"]}}</td>
            <td>
                <button class="btn btn-primary btn-sm trigger-data-show" data="{{json_encode($row)}}" data-toggle="modal" data-target="#mdl-mensajes-docs">
                    Mensajes y documentos
                </button>
            </td>
            <td>{{$row["fecha_ingreso"]}}</td>
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
        @endforeach
    </tbody>
</table>
<script>
    $('.trigger-data-show').click(function() {
            hideMessageBox();
            $("#chatbox").html("");
            var data = $(this).attr('data');
            data = JSON.parse(data);
            //Swal cargando
            Swal.fire({
                title: 'Cargando...',
                allowEscapeKey: false,
                allowOutsideClick: false,
                onOpen: () => {
                    Swal.showLoading()
                }
            });
            //ajax
            $.ajax({
                url: 'get_ticket_messages',
                type: 'GET',
                data: {
                    id: data.id
                },
                success: function(data) {
                    // foreach data
                    $.each(data, function(index, value) {
                        // if is sender
                        @if (Session::get("account")["dni"] == "14.656.819-K")
                            if (value.id_staff == "17") {
                                sendedChatBox(value.full_name, value.message, value.date_in, value.file_path);
                            } else {
                                responseChatBox(value.full_name, value.message, value.date_in , value.file_path);
                            }
                        @else
                            if (value.id_staff != "17") {
                                sendedChatBox(value.full_name, value.message, value.date_in, value.file_path);
                            } else {
                                responseChatBox(value.full_name, value.message, value.date_in , value.file_path);
                            }
                        @endif
                    });
                    $("#chatbox").animate({
                        scrollTop: $("#chatbox").prop("scrollHeight")
                    }, 0);
                    Swal.close();
                    setTimeout(function(){
                        $("#message").focus();
                    }, 500);
                    
                },
                error: function(data) {
                    //Swal error
                    Swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error inesperado, por favor intente nuevamente',
                    });
                }
            });
            $('#mdl-mensajes-docs .modal-title').html(data.asunto);
            $('#mdl-mensajes-docs .modal-body').html(data.mensajes);
        });
</script>