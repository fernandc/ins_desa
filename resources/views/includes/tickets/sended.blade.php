<br class="mt-2">
<table id="requesttable" class="table table-hover ">
    <thead>
        <tr>
            <th scope="col">Código</th>
            <th scope="col">Emisor</th>
            <th scope="col">Tipo</th>
            <th scope="col">Asunto</th>
            <th scope="col">Fechas y Horas</th>
            <th scope="col">Fecha de envío</th>
            <th scope="col">Mensajes y documentos</th>
            <th scope="col">Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tickets as $row)
            @if($row["dni_solicitante"] == Session::get('account')['dni'] || $row["dni_receptor"] == Session::get('account')['dni'])
                @if ($row["estado"] == "Pendiente")
                    <tr>
                        <td><b>{{$row["id"]}}</b></td>
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
<script>
    $(document).ready(function() {
        $("#sendMessage").click(function(e) {
            e.preventDefault();
            var message = $("#message").val();
            var dateTime = getDateTime();
            if (message.trim() != "") {
                $("#chatbox").append(
                    '<div class="chat-box mb-3">' +
                    '<div class="chat-box-body" style="margin-left: 15%">' +
                    '<div class="chat-box-message border" style="padding: 0.5rem">' +
                    '<div class="chat-sended border-bottom">' +
                    '<span class="text-primary"> {{Session::get("account")["full_name"]}} </span> - <span>' + dateTime + '</span>' +
                    '</div>' +
                    '<div class="chat-box-message-content">' +
                    message +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
                );
                $.ajax({
                    url: "response_ticket_message",
                    type: "POST",
                    data: {
                        _token: "{{csrf_token()}}",
                        message: message,
                        id_ticket: $("#ticketid").val()
                    },
                    success: function(data) {
                        if(data == "Error"){
                            Swal.fire({
                                title: "Error",
                                text: "No se pudo enviar el mensaje",
                                icon: "error",
                                button: "Aceptar",
                            });
                        }
                    }
                });
                $("#messageForm").trigger("reset");
                $("#chatbox").animate({
                    scrollTop: $("#chatbox").prop("scrollHeight")
                }, 0);
            }
        });
        $("#adjuntar").click(function(){
            $("#chatfile").click();
        });
        // if #chatfile change then swal are you sure?
        $("#chatfile").change(function(){
            var file = $(this).val();
            if (file != "") {
                //get only file name
                var fileName = file.split("\\").pop();
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "¿Deseas adjuntar el archivo " + fileName + "?",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonColor: "#d33",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Sí, adjuntar",
                    cancelButtonText: "Cancelar",
                }).then((willDelete) => {
                    if (willDelete) {
                        document.getElementById("flagButtonSendFile").click();
                    }
                });
            }
        });
        $("#flagButtonSendFile").click(function(){
            var fdata = new FormData();
            fdata.append("file", $("#chatfile")[0].files[0]);
            fdata.append("_token", "{{csrf_token()}}");
            fdata.append("id_ticket", $("#ticketid").val());
            $.ajax({
                url: "response_ticket_message",
                type: "POST",
                processData: false,
                contentType: false,
                data: fdata,
                enctype: 'multipart/form-data',
                success: function(data) {
                    if(data == "Error"){
                        Swal.fire({
                            title: "Error",
                            text: "No se pudo cargar el archivo",
                            icon: "error",
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "Aceptar",
                        });
                    }else{
                        //current datetime
                        var dateTime = getDateTime();
                        sendedChatBox('{{Session::get("account")["full_name"]}}',null, dateTime, data);
                        $("#chatbox").animate({
                            scrollTop: $("#chatbox").prop("scrollHeight")
                        }, 0);
                    }
                }
            });
        });
        $('.trigger-data').click(function() {  
            showMessageBox();
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
            if(data.dni_receptor == '{{Session::get("account")["dni"]}}'){
                console.log("show");
                $("#responseAdmin").show();
            }else{
                console.log("hide");
                $("#responseAdmin").hide();
            }
            $("#ticketid").val(data.id);
            $.ajax({
                url: 'get_ticket_messages',
                type: 'GET',
                data: {
                    id: data.id
                },
                success: function(data) {
                    $.each(data, function(index, value) {
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
            $('#mdl-mensajes-docs .modal-title').html('<span class="text-primary">['+data.tipo+']</span> ' + data.asunto);
            $('#mdl-mensajes-docs .modal-body').html(data.mensajes);
        });
    });
</script>