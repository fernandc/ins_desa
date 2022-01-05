<div class="modal-header">
    <h5 class="modal-title" id="modalAddArchivoCenterTitle">Agregar Nuevo Archivo</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form action="save_file_fm" id="newFile" class="was-validated" method="POST" enctype="multipart/form-data">
    @csrf
    <input id="file_id_materia" class="form-control is-invalid" value="{{$_GET["materia"]}}" name="id_materia" hidden="">
    <input id="file_id_curso" class="form-control is-invalid" value="{{$_GET["curso"]}}" name="id_curso" hidden="">
    <input id="file_year" class="form-control is-invalid" value="{{$year}}" name="year" hidden="">
    <input id="file_path_file" class="form-control is-invalid" value="{{$path}}" name="path_file" hidden="">
    
    <div class="modal-body">
        
        <div class="form-group">
            <div class="custom-file" style="width:100%" >
                <input type="file" class="custom-file-input" autocomplete="off" id="fileAdded" name="fileAdded"  required="" lang="es">
                <label id="addFileLabel" for="fileAdded" class="custom-file-label" lang="es" >
                    <i class="fa fa-cloud-upload"></i>Subir archivo...
                </label>
                <hr>
            </div>                                
        </div>                        
    </div>
    {{-- Image Functions --}}
    <script>
        // Send vaccine file
        function file_extension(filename){
            return (/[.]/.exec(filename)) ? /[^.]+$/.exec(filename)[0] : undefined;
        }
        $('#fileAdded').change(function() {
            var i = $(this).prev('label').clone();
            var file = $('#fileAdded')[0].files[0].name;
            var extension = file_extension(file);
            var extensiones = ["pdf","jpg","png","jpeg","xlsx","docx","doc","dot","xls","txt","rar","zip","ppt","pptx","mp3","mp4","avi","csv","gif","m4a","mov","wav","wma"];
            if(extensiones.includes(extension)){                                
                $("#saveNewFile").attr("disabled",false);
                $("#addFileLabel").html(file);
            }else{
                Swal.fire('Error!', 'el archivo no es válido.', 'error');
                $("#saveNewFile").attr("disabled",true);
                file = null;
            }
            $(this).prev('label').text(file);
        });

    </script>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="closeModalBtn" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success" id="saveNewFile" disabled >Guardar</button>
    </div>
</form>