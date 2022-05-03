<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
    Solicitudes y Justificaciones
@endsection

@section("headex")
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <style>
        .chat-box-message-content{
            white-space: pre-line;
        }
    </style>
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
              <a class="nav-link active" id="sended-tab" data-toggle="tab" href="#sended" role="tab" aria-controls="sended" aria-selected="true">Pendientes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="sendrequest-tab" data-toggle="tab" href="#sendrequest" role="tab" aria-controls="sendrequest" aria-selected="false">Enviar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="responserequest-tab" data-toggle="tab" href="#responserequest" role="tab" aria-controls="responserequest" aria-selected="false">Cerrados</a>
            </li>
            @if ($all_tickets != null)
            <li class="nav-item">
                <a class="nav-link" id="allrequest-tab" data-toggle="tab" href="#allrequest" role="tab" aria-controls="allrequest" aria-selected="false">Ver Todos</a>
            </li>
            @endif
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="sended" role="tabpanel" aria-labelledby="sended-tab">
                @include("includes/tickets/sended")
            </div>
            <div class="tab-pane fade" id="sendrequest" role="tabpanel" aria-labelledby="sendrequest-tab">
                @include('includes/tickets/request')
            </div>
            <div class="tab-pane fade" id="responserequest" role="tabpanel" aria-labelledby="responserequest-tab">
                @include('includes/tickets/response')
            </div>
            @if ($all_tickets != null)
                <div class="tab-pane fade" id="allrequest" role="tabpanel" aria-labelledby="allrequest-tab">
                    @include('includes/tickets/all_tickets_adm')
                </div>
            @endif
        </div>
    </div>
    <div class="modal fade" id="mdl-mensajes-docs" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cargando...</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- chat box -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Mensajes</h5>
                                </div>
                                <button id="flagButtonSendFile" style="display: none;"></button>
                                <input id="ticketid" type="hidden" name="ticketid">
                                <div id="chatbox" class="card-body" style="max-height: 420px; overflow-y: auto;">
                                </div>
                                <div>
                                    <div class="card-footer">
                                        <form id="messageForm" class="input-group">
                                            <input id="message" type="text" class="form-control" placeholder="Escribe un mensaje...">
                                            <div class="input-group-append">
                                                <input type="file" name="chatfile" id="chatfile" hidden="" style="display: none;">                                 
                                                <button id="adjuntar" class="btn btn-warning btn-sm" type="button">
                                                    <i class="fa fa-paperclip"></i>
                                                </button>
                                                <button id="sendMessage" type="submit" class="btn btn-primary" type="button">Enviar</button>
                                            </div>
                                        </form>
                                        <form id="responseAdmin" class="mt-1" style="display: none;">
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <select id="responseAdminEstado" class="form-control">
                                                        <option value="Aprobado" selected>Aprobar</option>
                                                        <option value="Rechazado">Rechazar</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <select id="responseAdminRemuneracion" class="form-control">
                                                        <option value="Si" selected>No Remunerado</option>
                                                        <option value="No">Remunerado</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <button id="sendAdminResponse" type="submit" class="btn btn-success w-100">Finalizar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <script>
        function formatHours(date){
            if(date.includes("PM")){
                var d = date.split(" ");
                var dt = d[0].split("/");
                var tm = d[1].split(":");
                var h = parseInt(tm[0])+12;
                if(h == 24){
                    h = 12;
                }
                if(h < 10){
                    h = "0"+h;
                }
                return dt[2]+"-"+dt[1]+"-"+dt[0]+" "+h+":"+tm[1]+":00";
            }else if(date.includes("AM") && parseInt(date.substring(10).split(":")[0]) == 12){
                var d = date.split(" ");
                var dt = d[0].split("/");
                var tm = d[1].split(":");
                var h = parseInt(tm[0])-12;
                if(h < 10){
                    h = "0"+h;
                }
                return dt[2]+"-"+dt[1]+"-"+dt[0]+" "+h+":"+tm[1]+":00";
            }else{
                var d = date.split(" ");
                var dt = d[0].split("/");
                var tm = d[1].split(":");
                var h = parseInt(tm[0])+0;
                if(h < 10){
                    h = "0"+h;
                }
                return dt[2]+"-"+dt[1]+"-"+dt[0]+" "+h+":"+tm[1]+":00";
            }
        }
        function getDateTime(){
            var dt = new Date();
            return `${(dt.getMonth()+1).toString().padStart(2, '0')}/${
                dt.getDate().toString().padStart(2, '0')}/${
                dt.getFullYear().toString().padStart(4, '0')} ${
                dt.getHours().toString().padStart(2, '0')}:${
                dt.getMinutes().toString().padStart(2, '0')}:${
                dt.getSeconds().toString().padStart(2, '0')}`
        }
        function hideMessageBox(){
            $("#messageForm").hide();
        }
        function showMessageBox(){
            $("#messageForm").show();
        }
        function sendedChatBox(emisor,message, date, file) {
            if(file != "" && file != null){
                message = getPathUrl(file);
            }
            $("#chatbox").append(
                '<div class="chat-box mb-3">' +
                '<div class="chat-box-body" style="margin-left: 15%">' +
                '<div class="chat-box-message border" style="padding: 0.5rem">' +
                '<div class="chat-sended border-bottom">' +
                '<span class="text-primary">' + emisor + '</span> - <span>' + date + '</span>' +
                '</div>' +
                '<div class="chat-box-message-content">' +
                message +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>'
            );
        }
        function responseChatBox(emisor,message, date_in, file){
            if(file != "" && file != null){
                message = getPathUrl(file);
            }
            $("#chatbox").append(
                '<div class="chat-box mb-3">' +
                '<div class="chat-box-body" style="margin-right: 15%">' +
                '<div class="chat-box-message border" style="padding: 0.5rem">' +
                '<div class="chat-sended border-bottom">' +
                '<span class="text-primary">' + emisor + '</span> - <span>' + date_in + '</span>' +
                '</div>' +
                '<div class="chat-box-message-content">' +
                message +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>'
            );
        }
        function getPathUrl(path){
            //get extension path
            var ext = path.split('.').pop();
            //replace / with -
            var path = path.replace(/\//g, "-");
            //switch extension with ignore case to icon fontawesome adding href to 'get_file/{path}' target '_blank'
            switch(ext.toLowerCase()){
                case 'pdf':
                    return '<a href="{{url("get_file")}}/'+path+'" target="_blank"><i class="far fa-file-pdf fa-7x"></i></a>';
                case 'doc':
                case 'docx':
                    return '<a href="{{url("get_file")}}/'+path+'" target="_blank"><i class="far fa-file-word fa-7x"></i></a>';
                case 'xls':
                case 'xlsx':
                    return '<a href="{{url("get_file")}}/'+path+'" target="_blank"><i class="far fa-file-excel fa-7x"></i></a>';
                case 'ppt':
                case 'pptx':
                    return '<a href="{{url("get_file")}}/'+path+'" target="_blank"><i class="far fa-file-powerpoint fa-7x"></i></a>';
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'gif':
                    return '<a href="{{url("get_file")}}/'+path+'" target="_blank"><img src="{{url("get_file")}}/'+path+'" style="width: auto; height: 150px;"></a>';
                case 'mp3':
                    return '<audio controls><source src="{{url("get_file")}}/'+path+'" type="audio/mpeg"></audio>';
                case 'mp4':
                case 'avi':
                case 'mkv':
                    return '<video controls><source src="{{url("get_file")}}/'+path+'" type="video/mp4"></video>';
                default:
                    return '<a href="{{url("get_file")}}/'+path+'" target="_blank"><i class="far fa-file fa-7x"></i></a>';
            }
        }
        $(document).ready( function () {
            $("#responseAdmin").submit(function(e){
                e.preventDefault();
                //Swal.fire estás seguro?
                Swal.fire({
                    title: '¿Finalzar?',	
                    text: "Se le notificará al usuario",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Si, responder!'
                }).then((result) => {
                    if (result.value) {
                        var id_ticket = $("#ticketid").val();
                        var estado = $("#responseAdminEstado").val();
                        var optional1 = $("#responseAdminRemuneracion").val();
                        $.ajax({
                            url: "{{url('/close_ticket')}}",
                            type: "GET",
                            data: {
                                id_ticket:id_ticket,
                                estado:estado,
                                optional1:optional1
                            },
                            success: function (data) {
                                if(data == "200"){
                                    Swal.fire(
                                        'Respondido!',
                                        'Tu mensaje ha sido respondido.',
                                        'success'
                                    );
                                    location.reload();
                                }else{
                                    Swal.fire(
                                        'Error!',
                                        'Ha ocurrido un error: ' + data,
                                        'error'
                                    );
                                }
                            }
                        });
                    }
                });
            });
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
            $('#closed').DataTable({
                "ordering": true,
                "pageLength" : 10,
                "order": [[5 , "desc"]],
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
                "order": [[5 , "asc"]],
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