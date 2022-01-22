
<div class="tab-pane fade show active" id="nav-{{$cert_id}}" role="tabpanel" aria-labelledby="nav-{{$cert_id}}-tab">
    <div class="form-group">
        <div class="card">
            <div class="card-header" style="font-weight: bold">
                Certificado de {{$cert_name}}
            </div>
            <div class="card-body">
                @php
                    $fileId = [];
                    $filePath = [];
                    $index = 0;
                    $flag = false;
                    foreach($certificados as $row){
                        if(substr($row["name"],0,27) == "certificado_nacimiento_hijo"){
                            $filePath[$index] = str_replace("/","-",$row["path"]);
                            $fileId[$index] = $row["id"];
                            $index++;
                            $flag = true;
                        }
                    }
                    $index++;
                @endphp
                @if($flag)
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @for ($i = 0; $i < $index-1; $i++)
                            <li class="nav-item">
                                <a class="nav-link  @if($i == 0) active @endif" id="certificado-nac-{{$i+1}}-tab" data-toggle="tab" href="#certificado-nac-{{$i+1}}" role="tab" aria-controls="certificado-nac-{{$i+1}}" aria-selected="true">Certificado {{$i+1}}</a>
                            </li>
                        @endfor
                        <li class="nav-item mb-3">
                            <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Nuevo Certificado</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        @for ($i = 0; $i < $index-1; $i++)
                            <div class="tab-pane fade @if($i == 0) show active @endif" id="certificado-nac-{{$i+1}}" role="tabpanel" aria-labelledby="certificado-nac-{{$i+1}}-tab">
                                <form action="user_add_cert" method="post" class="was-validated" enctype="multipart/form-data">
                                    @csrf
                                    <input id="cert_name_input_{{$cert_id}}" class="form-control is-invalid" value="{{$cert_id}}" name="cert_name_input" hidden="">
                                    <input id="cert_name_input_index" class="form-control is-invalid" value="{{$i+1}}" name="cert_name_input_index" hidden="">
                                    <div class="custom-file" style="margin-bottom: 50px;">
                                        <input type="file" class="custom-file-input" onchange="loadFile(event)" accept=".pdf*" autocomplete="off" id="cert_file_{{$cert_id}}_{{$i+1}}" name="cert_file_{{$cert_id}}"  lang="es">
                                        <label id="cert_file_{{$cert_id}}_label_{{$i+1}}" for="cert_file_{{$cert_id}}_{{$i+1}}" class="custom-file-label">Subir archivo...</label>                        
                                    </div>
                                    <div class="text-center">
                                        @if ($filePath[$i] != '')
                                            <embed src="get_file/{{$filePath[$i]}}" id="output_{{$i+1}}" width="100%" height="500px" type="application/pdf">
                                        @else
                                            <div style="font-size: xxx-large">
                                                <i class="fas fa-file-pdf fx-9" style="background:" id="i_output_{{$i+1}}"></i>
                                                <embed src="" id="output_{{$i+1}}" width="100%" height="500px" hidden type="application/pdf">    
                                            </div>
                                        @endif              
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" disabled id="btn_save_cert_{{$i+1}}" class="btn btn-lg btn-success">Guardar archivo</button>
                                        <button class="btn btn-danger btn-lg float-right" id="btn_delete_cert_{{$i+1}}" >Eliminar</button>
                                    </div>
                                    <script>
                                        $("#btn_delete_cert_{{$i+1}}").click(function(){
                                            Swal.fire({
                                                title: 'Quieres borrar este archivo?',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#d33',
                                                cancelButtonColor: '#99A3A4',
                                                confirmButtonText: 'Si, Borrar!',
                                                cancelButtonText: 'Cancelar'
                                                }).then((result) => {
                                                if (result.isConfirmed) {
                                                    Swal.fire({
                                                        icon: 'info',
                                                        title: 'Cargando',
                                                        showConfirmButton: false,
                                                    });
                                                    window.location.href = '/user_del_cert?id={{$fileId[$i]}}&path={{$filePath[$i]}}';                                                        
                                                }
                                            })
                                        })
                                        var loadFile = function(event) {
                                            var output = document.getElementById('output_{{$i+1}}');
                                            output.src = URL.createObjectURL(event.target.files[0]);
                                            output.onload = function() {
                                            URL.revokeObjectURL(output.src) // free memory
                                            }
                                        };
                                        $('#cert_file_{{$cert_id}}_{{$i+1}}').change(function() {
                                            var i = $(this).prev('label').clone();
                                            var file = $('#cert_file_{{$cert_id}}_{{$i+1}}')[0].files[0].name;
                                            var extension = file_extension(file);
                                            if(extension == "pdf" ){
                                                $("#cert_file_{{$cert_id}}_label_{{$i+1}}").html(file);
                                                $("#output_{{$i+1}}").attr("hidden",false);
                                                $("#i_output_{{$i+1}}").attr("hidden",true);
                                                $("#btn_save_cert_{{$i+1}}").attr("disabled",false);
                                            }else{
                                                Swal.fire('Error!', 'el archivo no es válido.', 'error');
                                                file = null;
                                            }  
                                        });
                                    </script>
                                </form>
                            </div>
                        @endfor
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <form action="user_add_cert" method="post" class="was-validated" enctype="multipart/form-data">
                                @csrf
                                <input id="cert_name_input_{{$cert_id}}" class="form-control is-invalid" value="{{$cert_id}}" name="cert_name_input" hidden="">
                                <input id="cert_name_input_index" class="form-control is-invalid" value="{{$index}}" name="cert_name_input_index" hidden="">
                                <div class="custom-file" style="margin-bottom: 50px;">
                                    <input type="file" class="custom-file-input" onchange="loadFile(event)" accept=".pdf*" autocomplete="off" id="cert_file_{{$cert_id}}" name="cert_file_{{$cert_id}}"  lang="es">
                                    <label id="cert_file_{{$cert_id}}_label" for="cert_file_{{$cert_id}}" class="custom-file-label">Subir archivo...</label>                        
                                </div>
                                <div class="text-center">
                                    <div style="font-size: xxx-large">
                                        <i class="fas fa-file-pdf fx-9" style="background:" id="i_output"></i>
                                        <embed src="" id="output" width="100%" height="500px" hidden type="application/pdf">    
                                    </div>          
                                </div>
                                <div class="card-footer">
                                    <div class="text-center">
                                        <button type="submit" disabled id="btn_save_cert" class="btn btn-lg btn-success">Guardar archivo</button>
                                    </div>
                                </div>         
                            </form>
                        </div>
                    </div>
                @else
                    <form action="user_add_cert" method="post" class="was-validated" enctype="multipart/form-data">
                        @csrf
                        <input id="cert_name_input_{{$cert_id}}" class="form-control is-invalid" value="{{$cert_id}}" name="cert_name_input" hidden="">
                        <input id="cert_name_input_index" class="form-control is-invalid" value="{{$index}}" name="cert_name_input_index" hidden="">
                        <div class="custom-file" style="margin-bottom: 50px;">
                            <input type="file" class="custom-file-input" onchange="loadFile(event)" accept=".pdf*" autocomplete="off" id="cert_file_{{$cert_id}}" name="cert_file_{{$cert_id}}"  lang="es">
                            <label id="cert_file_{{$cert_id}}_label" for="cert_file_{{$cert_id}}" class="custom-file-label">Subir archivo...</label>                        
                        </div>
                        <div class="text-center">
                            <div style="font-size: xxx-large">
                                <i class="fas fa-file-pdf fx-9" style="background:" id="i_output"></i>
                                <embed src="" id="output" width="100%" height="500px" hidden type="application/pdf">    
                            </div>   
                        </div>
                        <div class="card-footer">
                            <div class="text-center">
                                <button type="submit" disabled id="btn_save_cert" class="btn btn-lg btn-success">Guardar archivo</button>
                            </div>
                        </div>         
                    </form>
                @endif                
            </div> 
        </div>
    </div>
</div>

