
<div class="card my-3">
    <div class="card-header">
        Ingresar Nueva Formación
    </div>
    
    <div class="form-row card-body"  >
        {{-- izq --}}
        <div class="form-group col-md-6" >
            <label for="user_titulo_id">Título</label>
            <select wire:model="titulo_seleccionado" class="form-control" name="user_titulo_id" id="user_titulo_id">                    
                <option selected value="">Seleccione Título</option> 
                @foreach ($titulos as $titulo)
                    <option value="{{$titulo['name']}}">{{$titulo['name']}}</option>                        
                @endforeach                    
            </select>
            <script>
                $('#user_titulo_id').change(function(){
                    @this.obtener_tipo_titulo();
                });
            </script>
        </div>
        @if ($titulo_seleccionado != "")
            <div class="form-group col-md-6" >
                <label for="user_tipo_titulo_id">Tipo del Título</label>
                <select wire:model="tipo_titulo_seleccionado" class="form-control" name="user_tipo_titulo_id" id="user_tipo_titulo_id">
                    <option selected value="">Seleccione Tipo Título</option>
                    @foreach ($tipo_titulo as $item)
                        <option value="{{$item['name']}}">{{$item['name']}}</option>                            
                    @endforeach
                </select>
                <script>
                    $('#user_tipo_titulo_id').change(function(){
                        @this.obtener_especialidad();
                    });
                </script>
            </div>
            @if ($titulo_seleccionado == 'Titulado en Otras Áreas' && $tipo_titulo_seleccionado != '')
                <div class="form-group col-md-12" >   
                    <label for="user_area_titulo_id">Área del Título</label>
                    <select wire:model="area_seleccionada" class="form-control" name="user_area_titulo_id" id="user_area_titulo_id">
                        <option selected value="">Seleccione Área del Título</option>
                        @foreach ($area_titulo as $area)
                            <option value="{{$area['name']}}">{{$area['name']}}</option>                            
                        @endforeach                            
                    </select>                                       
                </div>
            @endif
            @if ($tipo_titulo_seleccionado != '')
                @if($tipo_titulo_seleccionado == 'Básica')
                    {{-- Menciones --}}
                    <div class="form-group col-md-12">
                        <hr>
                        <h6>Menciones</h6>
                        <div class="row">
                            @php
                                $cont_mentions = 1;
                            @endphp
                            @foreach ($basic_mentions as $mention)
                                <div class="col-md-4">                                                                                                            
                                    <div class="custom-control custom-switch">
                                        <input wire:model="menciones_seleccionadas.{{$cont_mentions}}" type="checkbox" value="{{$mention['name']}}" class="custom-control-input" id="customSwitch{{$mention['id']}}">
                                        <label class="custom-control-label" for="customSwitch{{$mention['id']}}">{{$mention['name']}}</label>
                                    </div>                                                        
                                </div>                    
                                @php
                                    $cont_mentions++;                                
                                @endphp
                            @endforeach
                        </div>                        
                    </div>    
                @endif
                @if (($titulo_seleccionado == 'Titulado en Otras Áreas' && $area_seleccionada != "") || $titulo_seleccionado != 'Titulado en Otras Áreas')
                    <div class="form-group col-md-6" >
                        <label for="user_especialidad_id">Especialidad</label>
                        <select wire:model="especialidad_seleccionada" class="form-control" name="user_especialidad_id" id="user_especialidad_id">
                            @if (count($especialidades) == 0)
                                <option selected value="">Sin Especialidad</option>
                            @else
                                <option selected value="">Seleccione Especialidad</option>
                            @endif
                            
                            @foreach ($especialidades as $especialidad)
                                <option value="{{$especialidad['name']}}">{{$especialidad['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if ($especialidad_seleccionada != "" || count($especialidades) == 0)
                        <div class="form-group col-md-6" >                  
                            <label for="user_modalidad_estudio_id">Modalidad Estudio</label>
                            <select wire:model="modalidad" class="form-control" name="user_modalidad_estudio_id" id="user_modalidad_estudio_id">
                                <option selected value="">Seleccione Modalidad de Estudio</option>
                                <option value="Presencial">Presencial</option>
                                <option value="Semi Presencial">Semi Presencial</option>
                                <option value="A distancia">A distancia</option>                    
                            </select>       
                        </div>
                        @if ($modalidad != "" )
                            <div class="form-group col-md-4" >   
                                <label for="user_tipo_institucion_id">Tipo Institución</label>
                                <select wire:model="tipo_institucion" class="form-control" name="user_tipo_institucion_id" id="user_tipo_institucion_id">
                                    <option selected value="">Seleccione Tipo de Institución</option>
                                    <option value="Universidad" >Universidad</option>                        
                                    <option value="Centro de formación Técnica">Centro de formación Técnica</option>                        
                                    <option value="Instituto Profesional">Instituto Profesional</option>                        
                                    <option value="Escuela Normal">Escuela Normal</option>                        
                                    <option value="Otro tipo de institución">Otro tipo de institución</option>                        
                                </select>                      
                            </div>
                            @if($tipo_institucion != "")
                                <div class="form-group col-md-4" >
                                    <label  for="user_semestres">Semestres de la carrera</label>
                                    <input wire:model="semestres" type="number"class="form-control" name="user_semestres" min="1" id="user_semestres" aria-describedby="helpId" placeholder="Ejemplo: 6">
                                </div>
                                @if ($semestres != "")
                                    <div class="form-group col-md-4" >                            
                                        <label for="user_anio_titulacion_id">Año Titulación</label>
                                        <input wire:model="anio_titulacion" type="number"class="form-control" name="user_anio_titulacion_id" id="user_anio_titulacion_id" min="1930" max="3000" aria-describedby="helpId" placeholder="Ejemplo: 2021">                                
                                    </div>
                                    @if ($anio_titulacion != '')
                                        <div class="form-group col-md-12">                                            
                                            <label for="">Certificado de Título</label>
                                            <input wire:model="certificado" type="file" onchange="loadFile(event)" class="custom-file-input" id="input_cert_degree" name="input_cert_degree" accept=".pdf*" autocomplete="off">
                                            <label wire:ignore class="custom-file-label" id="input_cert_degree_label" for="input_cert_degree" data-browse="Buscar"  style="margin-top: 30px;">Subir archivo...</label>     
                                            @error('certificado') <span class="error">{{ $message }}</span> @enderror                                                 
                                            <embed wire:ignore src=""  id="output" width="100%" height="500px" hidden type="application/pdf">                                                                                                                                                                                        
                                            <script>
                                                function file_extension(filename){
                                                    return (/[.]/.exec(filename)) ? /[^.]+$/.exec(filename)[0] : undefined;
                                                }                                                
                                                $("#input_cert_degree").change(function() {
                                                    var i = $(this).prev('label').clone();
                                                    var file = $('#input_cert_degree')[0].files[0].name;
                                                    console.log(file);
                                                    var extension = file_extension(file);
                                                    if(extension == "pdf" ){
                                                        $("#input_cert_degree_label").html(file);
                                                        $("#output").attr("hidden",false);
                                                    }else{
                                                        Swal.fire('Error!', 'el archivo no es válido.', 'error');
                                                        file = null;
                                                    }  
                                                });                                                    
                                            </script>                                       
                                        </div>                                        
                                    @endif
                                @endif
                            @endif
                        @endif
                    @endif                    
                @endif
            @endif
        @endif
    </div>
    <div class="card-footer">
        <div class="text-center">
            <button wire:click="enviar_datos()" {{$btn_disabled}} type="button" id="send_user_formation" class="btn btn-lg btn-success">Guardar</button>
            <script>                
                $("#send_user_formation").click(function(){
                    Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'La información se ha guardado exitosamente.',
                    showConfirmButton: false,
                    // timer: 4500
                    })
                })                
                var loadFile = function(event) {
                    var output = document.getElementById('output');
                    output.src = URL.createObjectURL(event.target.files[0]);
                    output.onload = function() {
                    URL.revokeObjectURL(output.src) // free memory
                    }
                };
            </script>
        </div>
    </div>
</div>                



