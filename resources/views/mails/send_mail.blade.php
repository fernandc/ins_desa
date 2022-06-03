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
        <h2 style="text-align: center;" >
            Enviar Correos
        </h2>
        <hr>
    </div>
    @php
        $acursos = array();
        $aalumnos = array();
        $aapersonal = array();
        $agrupos = array();
    @endphp
    <form class="row" id="formSendMails" >
        <div class="col-md-4">
            <div class="">
                <input type="text" hidden="" id="idMateria" name="idMateria">
                <input type="text" class="form-control"  placeholder="Buscar destinatario(s)..." id="autocomplete" autocomplete="off">
                <script>            
                    var lista_to = new Array();
                    var countries = [ 
                        //Filtro de cursos de usuario
                        { data: '0-PERSONAL-TODO PERSONAL', value: 'TODO PERSONAL' },
                        @foreach($lista_para as $row)
                            @if($row["tipo"] == "CURSO")
                                @php array_push($acursos, $row); @endphp
                            @elseif($row["tipo"] == "PERSONAL")
                                @php array_push($aapersonal, $row); @endphp
                            @elseif($row["tipo"] == "GRUPO")
                                @php array_push($agrupos, $row); @endphp
                            @elseif($row["tipo"] == "ALUMNO")
                                @php array_push($aalumnos, $row); @endphp
                            @endif
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
                            //lista_to.push([array]);
                            var id_item = array[0];
                            var tipo_item = array[1];
                            var nombre_item = array[2];
                            agregarDes(id_item,tipo_item,nombre_item);
                        }
                    });
                </script>
            </div>
        </div>
        <div class="col-md-1">
            <button class="btn btn-info" type="button" data-toggle="modal" data-target="#finder" style="width: 100%;"><i class="fas fa-search"></i></button>
            <!-- Modal -->
            <div class="modal fade" id="finder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buscar Destinatarios</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Cursos</h3>
                                <hr>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" autocomplete="off" id="todocurso">
                                    <label class="custom-control-label text-primary" for="todocurso">Todos</label>
                                </div>
                                @foreach ($acursos as $rowc)
                                    <div class="custom-control custom-checkbox" style="text-align-last: justify;">
                                        <input type="checkbox" class="custom-control-input forlist is-curso" data="{{$rowc["id"]}}-{{$rowc["tipo"]}}-{{$rowc["nombre"]}}" autocomplete="off" id="check{{$rowc["tipo"]}}{{$rowc["id"]}}">
                                        <label class="custom-control-label" for="check{{$rowc["tipo"]}}{{$rowc["id"]}}">{{$rowc["nombre"]}}</label>
                                        <a href="#" class="badge badge-primary select-curso" data1="{{$rowc["nombre"]}}" data2="{{$rowc["id"]}}">Ver Alumnos</a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-4">
                                <h3 id="grupocurso">Curso no seleccionado</h3>
                                <hr>
                                @foreach ($acursos as $rowc)
                                    <div id="base{{$rowc["id"]}}" class="base-cursos" style="display: none;">
                                        @foreach ($aalumnos as $rowa)
                                            @if ($rowa["id_curso"] == $rowc["id"])
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input forlist is-alumno" data="{{$rowa["id"]}}-{{$rowa["tipo"]}}-{{$rowa["nombre"]}}" autocomplete="off" id="check{{$rowa["tipo"]}}{{$rowa["id"]}}">
                                                    <label class="custom-control-label" for="check{{$rowa["tipo"]}}{{$rowa["id"]}}">{{$rowa["nombre"]}}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-4">
                                <h3>Personal</h3>
                                <hr>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" autocomplete="off" id="todopersonal">
                                    <label class="custom-control-label text-primary" for="todopersonal">Todos</label>
                                </div>
                                @foreach ($aapersonal as $rowp)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input forlist is-personal" data="{{$rowp["id"]}}-{{$rowp["tipo"]}}-{{$rowp["nombre"]}}" autocomplete="off" id="check{{$rowp["tipo"]}}{{$rowp["id"]}}">
                                        <label class="custom-control-label" for="check{{$rowp["tipo"]}}{{$rowp["id"]}}">{{$rowp["nombre"]}}</label>
                                    </div>
                                @endforeach
                            </div>
                            <script>
                                $(".select-curso").click(function(){
                                    var nombre = $(this).attr("data1");
                                    var id = $(this).attr("data2");
                                    $("#grupocurso").html(nombre);
                                    $(".base-cursos").hide();
                                    $("#base"+id).show();
                                });
                                $('#todocurso').click(function(event) {   
                                    if(this.checked) {
                                        // Iterate each checkbox
                                        $('.is-curso').each(function() {
                                            var dataget = $(this).attr("data");
                                            var array = dataget.split("-");
                                            var id = array[0];
                                            var tipo = array[1];
                                            var nombre = array[2];
                                            agregarDes(id,tipo,nombre);
                                            this.checked = true;
                                        });
                                    } else {
                                        $('.is-curso').each(function() {
                                            var dataget = $(this).attr("data");
                                            var array = dataget.split("-");
                                            var id = array[0];
                                            var tipo = array[1];
                                            var nombre = array[2];
                                            eliminarDes(id,tipo,nombre);
                                            this.checked = false;
                                        });
                                    }
                                });
                                $('#todopersonal').click(function(event) {   
                                    if(this.checked) {
                                        // Iterate each checkbox
                                        $('.is-personal').each(function() {
                                            var dataget = $(this).attr("data");
                                            var array = dataget.split("-");
                                            var id = array[0];
                                            var tipo = array[1];
                                            var nombre = array[2];
                                            agregarDes(id,tipo,nombre);
                                            this.checked = true;
                                        });
                                    } else {
                                        $('.is-personal').each(function() {
                                            var dataget = $(this).attr("data");
                                            var array = dataget.split("-");
                                            var id = array[0];
                                            var tipo = array[1];
                                            var nombre = array[2];
                                            eliminarDes(id,tipo,nombre);
                                            this.checked = false;
                                        });
                                    }
                                });
                                $(".forlist").change(function(){
                                    var dataget = $(this).attr("data");
                                    var array = dataget.split("-");
                                    var id = array[0];
                                    var tipo = array[1];
                                    var nombre = array[2];
                                    if(this.checked) {
                                        agregarDes(id,tipo,nombre);
                                    }else{
                                        eliminarDes(id,tipo,nombre);
                                    }
                                });
                            </script>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
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
        </div>
        <div class="col-md-6">
            <div class="mb-1">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">Tipo de Correo</div>
                </div>
                <select class="custom-select " id="emailtype" autocomplete="off">
                    <option value="1">General</option>
                    <option value="2">Informativo</option>
                    <option value="3">Buenas Noticias</option>
                    <option value="4">Malas Noticias</option>
                    <option value="5" style="color: #0040ff;background-color: yellow;">[P] INFORMATIVO SEMANAL</option>
                    <option value="6" style="color: #0040ff;background-color: yellow;">[P] INFORMATIVO MENSUAL</option>
                </select>
              </div>
            </div>
            <div class="card">
              <div class="card-header">
                 <input id="title" class="form-control" placeholder="Asunto del Correo" autocomplete="off">
              </div>
              <div class="card-body">
                <p class="card-text">
                    <textarea class="form-control" id="context" rows="10" placeholder="Mensaje" autocomplete="off"></textarea>
                    <div id="context2" class="mb-5" style="display: none;">
                        <div class="form-group">
                            <label for="formGroupExampleInput">Fecha Inicio</label>
                            <input id="p5semin" type="text" class="form-control form-control-sm" autocomplete="off" placeholder="Ej: Lunes 3">
                        </div>
                        <div class="form-group">
                            <label>Fecha Fin</label>
                            <input id="p5semout" type="text" class="form-control form-control-sm" autocomplete="off" placeholder="Ej: Viernes 7">
                        </div>
                        <div class="form-group">
                            <label>Mes referenciado</label>
                            <input id="p5mes" type="text" class="form-control form-control-sm" autocomplete="off" placeholder="Ej: Mayo">
                        </div>
                        <div class="form-group">
                            <label>Horas de Inasistencias</label>
                            <input id="p5faltas" type="text" class="form-control form-control-sm" autocomplete="off" placeholder="Ej: 3">
                        </div>
                        <div class="form-group">
                            <label>Atrasos</label>
                            <input id="p5atrasos" type="text" class="form-control form-control-sm" autocomplete="off" placeholder="Ej: 4">
                        </div>
                        <div class="form-group">
                            <label>Retiros</label>
                            <input id="p5retiros" type="text" class="form-control form-control-sm" autocomplete="off" placeholder="Ej: 1">
                        </div>
                    </div>
                    <div id="context3">
                        <div class="form-group">
                            <label>Mes referenciado</label>
                            <input id="p6mes" type="text" class="form-control form-control-sm" autocomplete="off" placeholder="Ej: Mayo">
                        </div>
                        <div class="form-group">
                            <label>Atrasos</label>
                            <input id="p6atrasos" type="text" class="form-control form-control-sm" autocomplete="off" placeholder="Ej: 4">
                        </div>
                    </div>
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
        //P5
        var p5alumno = '<span class="text-danger">Pendiente</span>';
        var p5curso = '<span class="text-danger">Pendiente</span>';
        var p5semanain = '<span class="text-danger">Pendiente</span>';
        var p5semanaout = '<span class="text-danger">Pendiente</span>';
        var p5mes = '<span class="text-danger">Pendiente</span>';
        var p5faltas = '<span class="text-danger">Pendiente</span>';
        var p5atrasos = '<span class="text-danger">Pendiente</span>';
        var p5retiros = '<span class="text-danger">Pendiente</span>';
        //P6
        var p6alumno = '<span class="text-danger">Pendiente</span>';
        var p6curso = '<span class="text-danger">Pendiente</span>';
        var p6mes = '<span class="text-danger">Pendiente</span>';
        var p6atrasos = '<span class="text-danger">Pendiente</span>';

        $("#p5semin").on("keyup change", function(e) {
            p5semanain = $(this).val();
            updateBodyMessage();
        })
        $("#p5semout").on("keyup change", function(e) {
            p5semanaout = $(this).val();
            updateBodyMessage();
        })
        $("#p5mes").on("keyup change", function(e) {
            p5mes = $(this).val();
            updateBodyMessage();
        })
        $("#p5faltas").on("keyup change", function(e) {
            p5faltas = $(this).val();
            updateBodyMessage();
        })
        $("#p5atrasos").on("keyup change", function(e) {
            p5atrasos = $(this).val();
            updateBodyMessage();
        })
        $("#p5retiros").on("keyup change", function(e) {
            p5retiros = $(this).val();
            updateBodyMessage();
        })
        $("#p6mes").on("keyup change", function(e) {
            p6mes = $(this).val();
            updateBodyMessage();
        });
        $("#p6atrasos").on("keyup change", function(e) {
            p6atrasos = $(this).val();
            updateBodyMessage();
        });
        $("#emailtype").change(function(){
            $("#bgmail").removeClass('bg-primary');
            $("#bgmail").removeClass('bg-info');
            $("#bgmail").removeClass('bg-success');
            $("#bgmail").removeClass('bg-danger');
            type = $(this).val();
            if(type == 1){$("#bgmail").addClass('bg-primary');}
            if(type == 2){$("#bgmail").addClass('bg-info');}
            if(type == 3){$("#bgmail").addClass('bg-success');}
            if(type == 4){$("#bgmail").addClass('bg-danger');}
            if(type == 5){
                $("#bgmail").addClass('bg-danger');
                $("#context").hide();
                $("#contex3").hide();
                $("#context2").show();
                selAlumP5();
            }else if(type == 6){
                $("#bgmail").addClass('bg-danger');
                $("#context").hide();
                $("#contex2").hide();
                $("#context3").show();
                selAlumP6();
            }else{
                $("#context2").hide();
                $("#context3").hide();
                $("#context").show();
                $("#viewContent").html('');
            }
        });
        function selAlumP5(){
            if(lista_to.length == 1){
                if(lista_to[0][0][1]=="ALUMNO"){
                    p5alumno = lista_to[0][0][2];
                    p5curso = obtenerCursoPorId(lista_to[0][0][0]);
                    if(type == 5){
                        $("#title").val("Informativo Inasistencia, atrasos y retiros - "+lista_to[0][0][2]);
                        $("#bgmail").html("Informativo Inasistencia, atrasos y retiros - "+lista_to[0][0][2]);
                    }
                }else{
                    p5alumno = '<span class="text-danger">Debe seleccionar 1 Alumno</span>';
                }
            }else if(lista_to.length > 1){
                p5alumno = '<span class="text-danger">Debe seleccionar 1 Alumno</span>';
            }else if(lista_to.length < 1){
                p5alumno = '<span class="text-danger">Pendiente</span>';
                p5curso = '<span class="text-danger">Pendiente</span>';
            }
            updateBodyMessage();
        }
        function selAlumP6(){
            console.log("A")
            if(lista_to.length == 1){
                console.log("B")
                if(lista_to[0][0][1]=="ALUMNO"){
                    console.log("C")
                    p6alumno = lista_to[0][0][2];
                    p6curso = obtenerCursoPorId(lista_to[0][0][0]);
                    if(type == 6){
                        console.log("D")
                        $("#title").val("Informativo de atrasos - "+lista_to[0][0][2]);
                        $("#bgmail").html("Informativo de atrasos - "+lista_to[0][0][2]);
                    }
                }else{
                    p6alumno = '<span class="text-danger">Debe seleccionar 1 Alumno</span>';
                }
            }else if(lista_to.length > 1){
                p6alumno = '<span class="text-danger">Debe seleccionar 1 Alumno</span>';
            }else if(lista_to.length < 1){
                p6alumno = '<span class="text-danger">Pendiente</span>';
                p6curso = '<span class="text-danger">Pendiente</span>';
            }
            updateBodyMessage();
        }
        function updateBodyMessage(){
            if(type == 5){
                $("#viewContent").html(`Sr. Apoderado de: <strong>`+p5alumno+`</strong>
                    Curso: <strong>`+p5curso+`</strong>
                    Semana de <strong>`+p5semanain+`</strong> al <strong>`+p5semanaout+`</strong> del mes de <strong>`+p5mes+`</strong>
                    Me dirijo a usted para entregar informe semanal de los datos que se detallan a continuación:

                    <strong>`+p5faltas+`</strong> Horas de inasistencias 
                    <strong>`+p5atrasos+`</strong> Atrasos
                    <strong>`+p5retiros+`</strong> Retiro de Clases

                    <strong>Cabe señalar que los datos entregados son por asistencia a cada asignaturas que ingresa diariamente el alumno(a), los que suman o restan  el porcentaje de asistencia mensual.</strong>

                    Recordamos a usted que los justificativos deben ser enviados por el apoderado al correo: justificacioninasistencia@saintcharlescollege.cl, indicando nombre y curso del estudiante, explicando las razones de las inasistencias y/o adjuntando certificados médicos en el caso de tenerlos.
                    Cualquier duda en relación a la información entregada, debe dirigirse al Profesor Jefe, quien le puede entregar con mayor exactitud las fechas y horarios de inasistencia.
                `);
            }else if(type == 6){
                $("#viewContent").html(`Sr. Apoderado de: <strong>`+p6alumno+`</strong>
                    Curso: <strong>`+p6curso+`</strong>
                    Me dirijo a usted para entregar informe de atrasos de su pupilo en el mes de <strong>`+p6mes+`</strong>:

                    <strong>`+p6atrasos+`</strong> Atrasos.

                    <strong>Le recordamos que es obligación del apoderado justificar a su pupilo  por comunicación o llamado telefónico.</strong>

                    Sin otro particular.

                    -Inspectoría.
                `);
            }else{
                $("#viewContent").html(mensaje);
            }
        }
        function obtenerCursoPorId(idstu){
            var cursostu = "";
            var curnombre = "";
            @foreach ($aalumnos as $rowa)
                if(<?php echo $rowa['id']; ?> == idstu){ cursostu = <?php echo $rowa["id_curso"]; ?>; }
            @endforeach

            @foreach ($acursos as $rowc)
                if(<?php echo $rowc["id"]; ?> == cursostu) { return "<?php echo $rowc["nombre"]; ?>" }
            @endforeach
        }
        function eliminarDes(id,tipo,nombre){
            var new_list = lista_to;
            $("#"+tipo+id).remove();
            if(lista_to){
                for (var item = 0 ; item < lista_to.length ; item ++){                            
                    if(new_list[item][0][0] == id && new_list[item][0][1] == tipo && new_list[item][0][2] == nombre){
                        $("#check"+tipo+id).prop('checked', false);
                        new_list.splice(item,1);
                    }
                    lista_to = new_list;
                }
            }
            selAlumP5();
        }
        function agregarDes(id_item,tipo_item,nombre_item){
            var array = [id_item,tipo_item,nombre_item];
            var flag = true;
            for (var item = 0 ; item < lista_to.length ; item ++){                            
                if(lista_to[item][0][0] == id_item && lista_to[item][0][1] == tipo_item && lista_to[item][0][2] == nombre_item){
                    flag = false;
                }
            }
            if (flag) {
                lista_to.push([array]);
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
                $("#check"+tipo_item+id_item).prop('checked', true);
                $('#autocomplete').val('');
                $("#destinatarios").append('<span id="'+tipo_item+id_item+'" class="badge badge-'+badge+' px-2 mr-2 destinatario" datatype="'+tipo_item+'" dataid="'+id_item+'" onclick="eliminarDes('+id_item+',\''+tipo_item+'\',\''+nombre_item+'\')" style="border-radius: 0px 40px 35px 35px;">'+nombre_item+' - '+tipo_item+'</span>');
                if(type == 5){
                    selAlumP5();
                }
                if(type == 6){
                    selAlumP6();
                }
            }
        }
        //
        $("#selectWhenSend").change(function(){
            selected = $(this).val();
        });
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
            if(type == 5){
                var p5si = $("#p5semin").val().trim();
                var p5so = $("#p5semout").val().trim();
                var p5mr = $("#p5mes").val().trim();
                var p5hi = $("#p5faltas").val().trim();
                var p5at = $("#p5atrasos").val().trim();
                var p5re = $("#p5retiros").val().trim();
                if(p5si.length > 0 && p5so.length > 0 && p5mr.length > 0 && p5hi.length > 0 && p5at.length > 0 && p5re.length > 0){
                    //if(true){
                    if(lista_to.length == 1 && lista_to[0][0][1]=="ALUMNO"){
                        $("#SendMailBtn").attr('disabled',true);
                        var files = $("#inputGroupFile04")[0].files;
                        var formData = new FormData();
                        for(var i = 0; i < files.length; i++) {
                            formData.append('files[]', files[i]);
                        }
                        formData.append('lista_destinatarios',lista_to);
                        formData.append('send_when',selected);
                        formData.append('meet',meet);
                        formData.append('title',$("#bgmail").html());
                        formData.append('body',$("#viewContent").html());
                        formData.append('type',type);
                        $.ajax({
                            type: "POST",
                            url: "send_mail_info",
                            processData: false,
                            contentType: false,
                            data: formData,
                            success: function (data){
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
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Los campos no están completos',
                        footer: `Fecha inicio: <strong>`+p5si+`</strong> <br>
                        Fecha Fin: <strong>`+p5so+`</strong> <br>
                        Mes referenciado: <strong>`+p5mr+`</strong> <br>
                        Horas de Inasistencias: <strong>`+p5hi+`</strong> <br>
                        Atrasos: <strong>`+p5at+`</strong> <br>
                        Retiros: <strong>`+p5re+`</strong>`
                    })
                }
            }else if(type == 6){
                var p6mr = $("#p6mes").val().trim();
                var p6at = $("#p6atrasos").val().trim();
                if(p6mr.length > 0 && p6at.length > 0){
                    if(lista_to.length == 1 && lista_to[0][0][1]){
                        $("#SendMailBtn").attr('disabled',true);
                        var files = $("#inputGroupFile04")[0].files;
                        var formData = new FormData();
                        for(var i = 0; i < files.length; i++) {
                            formData.append('files[]', files[i]);
                        }
                        formData.append('lista_destinatarios',lista_to);
                        formData.append('send_when',selected);
                        formData.append('meet',meet);
                        formData.append('title',$("#bgmail").html());
                        formData.append('body',$("#viewContent").html());
                        formData.append('type',type);
                        $.ajax({
                            type: "POST",
                            url: "send_mail_info",
                            processData: false,
                            contentType: false,
                            data: formData,
                            success: function (data){
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
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Los campos no están completos',
                        footer: `Mes referenciado: <strong>`+p6mr+`</strong> <br>
                        Atrasos: <strong>`+p6at+`</strong>`
                    });
                }
            }else{
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
                                if(data == "DONE"){
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
                                }else if(data == "MISS"){
                                    Toast.fire({
                                        icon: 'warning',
                                        title: 'ha ocurrido un error'
                                    });
                                }
                            }
                        });
                    }
                }
            }
        });
    </script>
</div>
@endsection