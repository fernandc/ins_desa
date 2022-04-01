@php
    $certificado = '';
    $filePath = '';
    if (isset($certificados) && $active!=6 && $active!=5) {
        foreach ($certificados as $certificado) {
            $name = $certificado['name'];                     
            $name = explode(".",$name);            
            if ($name[0] == $cert_id) {                
                $filePath = $certificado["path"];
                $filePath = str_replace("/","-",$filePath);
            }                        
        }
    }
@endphp
@if ($active == 5 || $active == 6 )
    @include('user.user_documents.user_add_cert_bono_hijo')
@elseif($active == 9 || $active == 10)
    @include('user.user_documents.user_show_adm_files')
@else
    <form action="user_add_cert" method="post" class="was-validated" enctype="multipart/form-data">
        @csrf
        <div class="tab-pane fade show active" id="nav-{{$cert_id}}" role="tabpanel" aria-labelledby="nav-{{$cert_id}}-tab">
            <div class="form-group">
                <input id="cert_name_input_{{$cert_id}}" class="form-control is-invalid" value="{{$cert_id}}" name="cert_name_input" hidden="">
                <div class="card">
                    <div class="card-header" style="font-weight: bold">                    
                        Certificado de {{$cert_name}} @if($link != '')  / <a href="{{$link}}" target="_blank">Puedes encontrarlo aquí.</a> @endif                             
                    </div>
                    <div class="card-body">                    
                        <div class="custom-file" style="margin-bottom: 50px;">
                            <input type="file" class="custom-file-input" onchange="loadFile(event)" accept=".pdf*" autocomplete="off" id="cert_file_{{$cert_id}}" name="cert_file_{{$cert_id}}"  lang="es">
                            <label id="cert_file_{{$cert_id}}_label" for="cert_file_{{$cert_id}}" class="custom-file-label">Subir archivo...</label>                        
                        </div>
                        <div class="text-center">
                            @if ($filePath != '')
                                <embed src="get_file/{{$filePath}}" id="output" width="100%" height="500px" type="application/pdf">
                            @else
                                <div style="font-size: xxx-large">
                                    <i class="fas fa-file-pdf fx-9" style="background:" id="i_output"></i>
                                    <embed src="" id="output" width="100%" height="500px" hidden type="application/pdf">    
                                </div>
                            @endif              
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="text-center">
                            <button type="submit" disabled id="btn_save_cert" class="btn btn-lg btn-success">Guardar archivo</button>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </form>
@endif
<script>
    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
        }
    };
    function file_extension(filename){
        return (/[.]/.exec(filename)) ? /[^.]+$/.exec(filename)[0] : undefined;
    }
    $('#cert_file_{{$cert_id}}').change(function() {
        var i = $(this).prev('label').clone();
        var file = $('#cert_file_{{$cert_id}}')[0].files[0].name;
        var extension = file_extension(file);
        if(extension == "pdf" || extension == "PDF"){
            $("#cert_file_{{$cert_id}}_label").html(file);
            $("#output").attr("hidden",false);
            $("#i_output").attr("hidden",true);
            $("#btn_save_cert").attr("disabled",false);
        }else{
            Swal.fire('Error!', 'el archivo no es válido.', 'error');
            file = null;
        }  
    });
</script>    


  