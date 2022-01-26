
    <form action="add_staff_documents_from_adm" method="post" class="was-validated" enctype="multipart/form-data">
        @csrf
        <div class="tab-pane fade show active" id="nav-documento" role="tabpanel" aria-labelledby="nav-documento-tab">
            <div class="form-group">
                <input id="id_user_staff" class="form-control is-invalid" value="{{$id_user}}" name="id_user_staff" hidden="">
                <input id="tipo_doc" class="form-control is-invalid" value="{{$tipo_doc}}" name="tipo_doc" hidden="">
                <input id="rut_user" class="form-control is-invalid" value="{{$row["rut"]}}" name="rut_user" hidden="">
                <div class="card">
                    <div class="card-header" style="font-weight: bold">
                        Agregar Documento
                    </div>
                    <div class="card-body">                    
                        <div class="custom-file" style="margin-bottom: 50px;">
                            <input type="file" class="custom-file-input" onchange="loadFile(event,'{{$id_user}}','{{$tipo_doc}}')" accept=".pdf*" autocomplete="off" id="cert_file_documento_{{$id_user}}_{{$tipo_doc}}" name="cert_file_documento_{{$id_user}}_{{$tipo_doc}}"  lang="es">
                            <label id="cert_file_documento_{{$id_user}}_{{$tipo_doc}}_label" for="cert_file_documento_{{$id_user}}_{{$tipo_doc}}" class="custom-file-label">Subir archivo...</label>                        
                        </div>
                        <script>
                            $("#cert_file_documento_{{$id_user}}_{{$tipo_doc}}").change(function() {
                                console.log("se muestra nombre file");
                                var i = $(this).prev('label').clone();
                                var file = $('#cert_file_documento_{{$id_user}}_{{$tipo_doc}}')[0].files[0].name;
                                var extension = file_extension(file);
                                if(extension == "pdf" ){
                                    $("#cert_file_documento_{{$id_user}}_{{$tipo_doc}}_label").html(file);
                                    $("#output{{$id_user}}{{$tipo_doc}}").attr("hidden",false);
                                    $("#i_output{{$id_user}}{{$tipo_doc}}").attr("hidden",true);
                                    $("#btn_save_cert{{$id_user}}{{$tipo_doc}}").attr("disabled",false);
                                }else{
                                    Swal.fire('Error!', 'el archivo no es válido.', 'error');
                                    file = null;
                                }  
                            });
                        </script>
                        <div class="text-center">
                            @if ($file_Path != '')
                                @php                                
                                    $file_Path = str_replace("/","-",$file_Path);
                                @endphp  
                                <embed src="get_file/{{$file_Path}}" id="output{{$id_user}}{{$tipo_doc}}" width="100%" height="500px" type="application/pdf">        
                            @else
                                <div style="font-size: xxx-large">
                                    <i class="fas fa-file-pdf fx-9" style="background:" id="i_output{{$id_user}}{{$tipo_doc}}"></i>
                                    <embed src="" id="output{{$id_user}}{{$tipo_doc}}" width="100%" height="500px" hidden type="application/pdf">    
                                </div>
                            @endif              
                        </div>
                        <script>
                            var loadFile = function(event,a,b) {
                                var ouab = 'output'+a+b;
                                console.log('output'+a+b);
                                var output = document.getElementById(ouab);
                                output.src = URL.createObjectURL(event.target.files[0]);
                                output.onload = function() {
                                    URL.revokeObjectURL(output.src) // free memory
                                }
                             };
                             function file_extension(filename){
                                 return (/[.]/.exec(filename)) ? /[^.]+$/.exec(filename)[0] : undefined;
                             }
                             
                           </script>
                    </div>
                    <div class="card-footer">                        
                        <button type="submit" disabled id="btn_save_cert{{$id_user}}{{$tipo_doc}}" class="btn btn-sm btn-success">Guardar archivo</button>
                        @if ($file_Path != '')
                            <a href="btn_del_document_adm?dni={{$row['rut']}}&doc={{$tipo_doc}}&path={{$file_Path}}" type="button" class="btn btn-sm btn-danger" id="del_btn_doc{{$id_user}}{{$tipo_doc}}">Eliminar archivo</a>                                                    
                        @endif
                    </div>                
                </div>
            </div>
        </div>
    </form> 
