<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Enviar correo
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.11/jquery.autocomplete.min.js" integrity="sha512-uxCwHf1pRwBJvURAMD/Gg0Kz2F2BymQyXDlTqnayuRyBFE7cisFCh2dSb1HIumZCRHuZikgeqXm8ruUoaxk5tA==" crossorigin="anonymous"></script>
<style>.autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
.autocomplete-selected { background: #F0F0F0; }
.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
.autocomplete-group { padding: 2px 5px; }
.autocomplete-group strong { display: block; border-bottom: 1px solid #000; }</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" />

@endsection

@section("context")

<div class="container">
    <div>
        <h2 style="text-align: center;" id="result">
            Enviar Correos
        </h2>
        <hr>
    </div>

    <form class="row" id="formSendMails" >
        <div class="col-md-4">
            <div class="">
                <input type="text" hidden="" id="idMateria" name="idMateria">
                <input type="text" class="form-control"  placeholder="Buscar destinatario(s)..." id="autocomplete">
                <script>            
                    var lista_to = new Array();
                    var countries = [ 
                        //Filtro de cursos de usuario
                        { data: '0-PERSONAL-TODO PERSONAL', value: 'TODO PERSONAL' },
                        @foreach($lista_para as $row)
                            @if(($row["tipo"] == "CURSO" && in_array($row["id"],$cursos)) || Session::get('account')['is_admin']=='YES')
                                { data: '{{$row["id"]}}-{{$row["tipo"]}}-{{$row["nombre"]}}', value: '{{$row["nombre"]}}' },
                            @elseif($row["tipo"] == "ALUMNO" && in_array($row["id_curso"],$cursos))
                                { data: '{{$row["id"]}}-{{$row["tipo"]}}-{{$row["nombre"]}}', value: '{{$row["nombre"]}}' },
                            @elseif($row["tipo"] == "PERSONAL")
                                { data: '{{$row["id"]}}-{{$row["tipo"]}}-{{$row["nombre"]}}', value: '{{$row["nombre"]}}' },
                            @elseif(($row["tipo"] == "GRUPO" && Session::get('account')['dni'] == $row["creador"]) || Session::get('account')['is_admin']=='YES')
                                { data: '{{$row["id"]}}-{{$row["tipo"]}}-{{$row["nombre"]}}', value: '{{$row["nombre"]}}' },
                            @endif
                        @endforeach
                    ];
                    $('#autocomplete').autocomplete({
                        minChars: 3,
                        lookup: countries,
                        onSelect: function (suggestion) {
                            var dataget = suggestion.data;
                            var array = dataget.split("-");
                            lista_to.push([array]);
                            var id_item = array[0];
                            var tipo_item = array[1];
                            var nombre_item = array[2];
                            var badge = "";
                            if(tipo_item=="PERSONAL"){
                                badge = "primary";
                            }else if(tipo_item=="ALUMNO"){
                                badge = "info";
                            }else if(tipo_item=="GRUPO"){
                                badge = "warning";
                            }
                            else if(tipo_item=="CURSO"){
                                badge = "warning";
                            }
                            $('#autocomplete').val('');
                            $("#destinatarios").append('<span id="'+tipo_item+id_item+'" class="badge badge-'+badge+' px-2 mr-2 destinatario" datatype="'+tipo_item+'" dataid="'+id_item+'" onclick="eliminarDes('+id_item+',\''+tipo_item+'\',\''+nombre_item+'\')" style="border-radius: 0px 40px 35px 35px;">'+nombre_item+' - '+tipo_item+'</span>')
                        }
                    });
                </script>
            </div>
        </div>
        <div class="col-md-4">
            <select class="custom-select " id="selectWhenSend" required="" autocomplete="off">
                <option value="1">Enviar ahora</option>
                <option value="2">Programar</option>
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" readonly="" style="display:none;" id="meeting-time" name="meeting-time" value="" min="2021-01-01T00:00" max="" class="form-control" placeholder="Seleccione fecha y hora">
            <script>
                $('#selectWhenSend').change(function (){
                    var sele = $(this).val();
                    if(sele == 2){
                        $("#meeting-time").attr('readonly',false);
                        $("#meeting-time").show();
                        jQuery('#meeting-time').datetimepicker({
                            minDate:0,
                            dayOfWeekStart:1,
                            step:10,
                            validateOnBlur:true,
                            weeks:true,
                            todayButton:true,
                            format:'Y-m-d H:i a'
                            });
                        $.datetimepicker.setLocale('es');
                    }
                    else{
                        $("#meeting-time").attr('readonly',true);
                        $("#meeting-time").hide();                       
                    }
                })
            </script>
        </div>
        <div class="col-md-12 my-2">
            <span>Destinatarios Seleccionados:</span>
            <br>
            <div id="destinatarios">              
            </div>
            <script>
                function eliminarDes(id,tipo,nombre){
                    var new_list = lista_to;
                    $("#"+tipo+id).remove();
                    if(lista_to){
                        for (var item = 0 ; item < lista_to.length ; item ++){                            
                            if(new_list[item][0][0] == id && new_list[item][0][1] == tipo && new_list[item][0][2] == nombre){
                                new_list.splice(item,1)
                            }
                        lista_to = new_list;
                        }
                    }
                }
            </script>
        </div>
        <div class="col-md-6">
            <div class="mb-1">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">Tipo de Correo</div>
                </div>
                <select class="custom-select " id="inlineFormCustomSelect">
                    <option value="1">General</option>
                    <option value="2">Informativo</option>
                    <option value="3">Buenas Noticias</option>
                    <option value="4">Malas Noticias</option>
                </select>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                 <input id="title" class="form-control" placeholder="Asunto del Correo">
              </div>
              <div class="card-body">
                <p class="card-text">
                    <textarea class="form-control" id="context" rows="10" placeholder="Mensaje"></textarea>
                </p>
                <div class="input-group form-control-sm ">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" name="files[]" id="inputGroupFile04" multiple="" aria-describedby="inputGroupFileAddon04">
                      <label class="custom-file-label" for="inputGroupFile04">Adjuntar archivo </label>
                      <script>
                        var filesADD = [];
                        $("#inputGroupFile04").change(function(ev){
                            var input = ev.target;
                            if (input.files) {
                                $(".file-names").html("");
                                var names = [];
                                $.each(input.files, function(i, e){
                                    var addext = "";
                                    names[i] = e.name;
                                    var ext = names[i].split('.').pop();
                                    if(ext == "pdf"){
                                        addext = ' <i class="far fa-file-pdf text-danger"></i>'
                                    }
                                    else if(ext == "xlsx"){
                                        addext = '<i class="far fa-file-excel text-success"></i>'
                                    }
                                    else if(ext == "csv"){
                                        addext = '<i class="fas fa-file-csv text-success"></i>'
                                    }
                                    else if(ext == "docx" || ext == "txt"){
                                        addext = '<i class="far fa-file-word text-primary"></i>'
                                    }
                                    else if(ext == "pptx" || ext == "ppt"){
                                        addext = '<i class="far fa-file-powerpoint" style="color: #d14424;"></i>'
                                    }
                                    else if(ext == "mpg" || ext == "avi" || ext == "mp4"){
                                        addext = '<i class="far fa-file-video"></i>'
                                    }
                                    else if(ext == "mp3" || ext == "wav" || ext == "flac" || ext == "wma"){
                                        addext = '<i class="far fa-file-audio"></i>'
                                    }
                                    else if(ext == "zip" || ext == "rar" || ext == "tar" || ext == "rar5" || ext == "7z"){
                                        addext = '<i class="far fa-file-archive"></i>'
                                    }
                                    else{
                                        addext = '<i class="far fa-file"></i>'
                                    }
                                    $(".file-names").append("-" + e.name + " " + addext + '<br>');
                                    filesADD.push(e)
                                });
                            }
                        });
                      </script>
                    </div>
                    
                </div>
                <button class="btn btn-success mt-3" id="reset" type="reset" hidden style="width:100%"></button>
                <button class="btn btn-success mt-3" type="button" id="SendMailBtn" style="width:100%">Enviar</button>
              </div>
            </div>
        </div>
        <div class="col-md-6">
            <h3>Vista Previa</h3>
            <div class="card  mb-3">
              <div id="bgmail" class="card-header text-white bg-primary">Asunto del Correo</div>
              <div class="card-body">
                <p class="card-text" id="viewContent" style="white-space: pre-line;">Cuerpo</p>
              </div>
              <div class="card-footer">
                <div class="file-names">
                </div>
              </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Escritura rápida
                </div>
                <div class="card-body row">
                    <div class="col" style="white-space: nowrap;">
                        <span class="badge badge-primary" style="width: 84px;text-align: left;">@Apoderado</span>: Nombre del Apoderado 
                    </div>
                    <div class="col" style="white-space: nowrap;">
                        <span class="badge badge-primary" style="width: 84px;text-align: left;">@Alumno</span>: Nombre del Alumno
                    </div>
                    <div class="col" style="white-space: nowrap;">
                        <span class="badge badge-primary" style="width: 84px;text-align: left;">@Curso</span>: Curso del Alumno
                    </div>
                    <div class="col" style="white-space: nowrap;">
                        <span class="badge badge-primary" style="width: 84px;text-align: left;">@Hoy </span>: Fecha Actual
                    </div>
                </div>
              </div>
        </div>
    </form>
    <script>
        var selected = 1;
        var type = 1;
        var meet = '';
        var mensajeT = '';
        var mensaje;
        $("#addStu").keyup(function(){
            
        });
        $("#inlineFormCustomSelect").change(function(){
            $("#bgmail").removeClass('bg-primary');
            $("#bgmail").removeClass('bg-info');
            $("#bgmail").removeClass('bg-success');
            $("#bgmail").removeClass('bg-danger');
            type = $(this).val();
            if(type == 1){$("#bgmail").addClass('bg-primary');}
            if(type == 2){$("#bgmail").addClass('bg-info');}
            if(type == 3){$("#bgmail").addClass('bg-success');}
            if(type == 4){$("#bgmail").addClass('bg-danger');}
        })
        $("#selectWhenSend").change(function(){
            selected = $(this).val();
        })
        $("#meeting-time").change(function(){
            meet = $(this).datetimepicker('getValue');
            var d = meet
            var year = d.getFullYear();
            var month = d.getMonth()+1;
            var day = d.getDate();
            var hours = d.getHours();
            var mins = d.getMinutes();
            if(month<10){month = "0"+month;}
            if(day<10){day = "0"+day;}
            if(hours<10){hours = "0"+hours;}
            if(mins<10){mins = "0"+mins;}
            var fulldate = year+"-"+month+"-"+day+" "+hours+":"+mins+":00";
            meet = fulldate;
        })

        $("#title").keyup(function(){
            mensajeT = $("#title").val();
            $("#bgmail").html(mensajeT);
        });
        $("#context").keyup(function(){
            mensaje = $("#context").val();
            mensaje = mensaje.replace('@Apoderado', '<span class="badge badge-primary">Apoderado</span>')
            mensaje = mensaje.replace('@apoderado', '<span class="badge badge-primary">Apoderado</span>')
            mensaje = mensaje.replace('@Alumno', '<span class="badge badge-info">Alumno</span>')
            mensaje = mensaje.replace('@alumno', '<span class="badge badge-info">Alumno</span>')
            mensaje = mensaje.replace('@Curso', '<span class="badge badge-info">Curso</span>')
            mensaje = mensaje.replace('@curso', '<span class="badge badge-info">Curso</span>')
            mensaje = mensaje.replace('@Hoy', '<span class="badge badge-info">Hoy</span>')
            mensaje = mensaje.replace('@hoy', '<span class="badge badge-info">Hoy</span>')
           $("#viewContent").html(mensaje);
        });
        $("#SendMailBtn").click(function(){
            
            var temp = $("#context").val();
            if(lista_to.length < 1){
                Swal.fire({
                    icon: 'error',
                    title: 'Ingrese destinatario.'
                })
            }
            else if(meet == '' && selected == 2 ){
                Swal.fire({
                    icon: 'error',
                    title: 'Fecha y hora'

                })
            }
            else if(mensajeT == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'Ingrese asunto del correo'
                })
            }
            else if(temp == ""){
                Swal.fire({
                    icon: 'error',
                    title: 'Ingrese mensaje'
                })
            }
            else{
                if(lista_to.length > 0 && mensajeT != "" && temp != ""){
                    $("#SendMailBtn").attr('disabled',true);
                    var files = $("#inputGroupFile04")[0].files;
                    var formData = new FormData();
                    for(var i = 0; i < files.length; i++) {
                        formData.append('files[]', files[i]);
                    }
                    formData.append('lista_destinatarios',lista_to);
                    formData.append('send_when',selected);
                    formData.append('meet',meet);
                    formData.append('title',mensajeT);
                    formData.append('body',temp);
                    formData.append('type',type);
                    $.ajax({
                        type: "POST",
                        url: "send_mail_info",
                        processData: false,
                        contentType: false,
                        data: formData,
                        success: function (data){
                            $("#result").html(data);
                            $('#SendMailBtn').attr('disabled',false);
                            $("#reset").click();
                            $("#bgmail").html("Asunto del correo");
                            $("#viewContent").html("Cuerpo");
                            $(".file-names").html("");
                            $("#destinatarios").html("");
                            $("#meeting-time").hide();
                            $("#bgmail").removeClass('bg-primary');
                            $("#bgmail").removeClass('bg-info');
                            $("#bgmail").removeClass('bg-success');
                            $("#bgmail").removeClass('bg-danger');
                            $("#bgmail").addClass('bg-primary');

                            selected = 1;
                            type = 1;
                            meet = '';
                            mensajeT = '';
                            mensaje = '';
                            temp = '';
                            lista_to = [];
                            Toast.fire({
                                icon: 'success',
                                title: 'Enviado'
                            })
                        }
                    })
                }
            }
            
        })
    </script>
</div>
@endsection