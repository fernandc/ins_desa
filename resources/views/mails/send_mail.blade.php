<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Test Section
@endsection

@section("headex")
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.11/jquery.autocomplete.min.js" integrity="sha512-uxCwHf1pRwBJvURAMD/Gg0Kz2F2BymQyXDlTqnayuRyBFE7cisFCh2dSb1HIumZCRHuZikgeqXm8ruUoaxk5tA==" crossorigin="anonymous"></script>
<style>.autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
.autocomplete-selected { background: #F0F0F0; }
.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
.autocomplete-group { padding: 2px 5px; }
.autocomplete-group strong { display: block; border-bottom: 1px solid #000; }</style>
@endsection

@section("context")
<div class="container">
    <div>
        <h2 style="text-align: center;">
            Enviar Correos
        </h2>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <input type="text" hidden="" id="idMateria" name="idMateria">
                <input type="text" class="form-control"  placeholder="Buscar...(ej: Matemática)" id="autocomplete">
                <script>
                    var lista_to = [];
                    var countries = [ 
                        @foreach($lista_para as $row)
                            { data: '{{$row["id"]}}-{{$row["tipo"]}}-{{$row["nombre"]}}', value: '{{$row["nombre"]}}' },                    
                        @endforeach
                    ];
                    $("#autocomplete").keyup(function(){
                        $("#autocomplete").addClass('is-invalid');
                        $("#autocomplete").removeClass('is-valid');
                    });
                    $('#autocomplete').autocomplete({
                        minChars: 3,
                        lookup: countries,
                        onSelect: function (suggestion) {
                            var dataget = suggestion.data;
                            var array = dataget.split("-");
                            lista_to.push(array);
                            var id_item = array[0];
                            var tipo_item = array[1];
                            var nombre_item = array[2];
                            var badge = "";
                            if(tipo_item=="PERSONAL"){
                                badge = "primary";
                            }else if(tipo_item=="ESTUDIANTE"){
                                badge = "info";
                            }else if(tipo_item=="GRUPO"){
                                badge = "warning";
                            }
                            $('#autocomplete').val('');
                            $("#destinatarios").append('<span class="badge badge-'+badge+' px-2 mr-2" datatype="'+tipo_item+'" dataid="'+id_item+'" px-2" style="border-radius: 0px 40px 35px 35px;">'+nombre_item+'</span>')
                        }
                    });
                </script>
            </div>
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
                <a href="#" class="btn btn-primary mb-2">Enviar</a>
                
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
                        <span class="badge badge-primary" style="width: 84px;text-align: left;">@Grupo</span>: Grupo Seleccionado
                    </div>
                    <div class="col" style="white-space: nowrap;">
                        <span class="badge badge-primary" style="width: 84px;text-align: left;">@hoy </span>: Fecha Actual
                    </div>
                </div>
              </div>
        </div>
    </div>
    <script>
        $("#addStu").keyup(function(){
            
        });
        $("#inlineFormCustomSelect").change(function(){
            $("#bgmail").removeClass('bg-primary');
            $("#bgmail").removeClass('bg-info');
            $("#bgmail").removeClass('bg-success');
            $("#bgmail").removeClass('bg-danger');
            var type = $(this).val();
            if(type == 1){$("#bgmail").addClass('bg-primary');}
            if(type == 2){$("#bgmail").addClass('bg-info');}
            if(type == 3){$("#bgmail").addClass('bg-success');}
            if(type == 4){$("#bgmail").addClass('bg-danger');}
        })
        $("#title").keyup(function(){
            var mensaje = $("#title").val();
            //mensaje = mensaje.replace('@apoderado', 'Kevin Delva')
            $("#bgmail").html(mensaje);
        });
        $("#context").keyup(function(){
            var mensaje = $("#context").val();
            mensaje = mensaje.replace('@Apoderado', '<span class="badge badge-primary">Apoderado</span>')
            mensaje = mensaje.replace('@Alumno', '<span class="badge badge-info">Alumno</span>')
            mensaje = mensaje.replace('@Curso', '<span class="badge badge-info">Curso</span>')
            mensaje = mensaje.replace('@Grupo', '<span class="badge badge-info">Grupo</span>')
            mensaje = mensaje.replace('@Hoy', '<span class="badge badge-info">Hoy</span>')
           $("#viewContent").html(mensaje);
        });
    </script>
</div>
@endsection