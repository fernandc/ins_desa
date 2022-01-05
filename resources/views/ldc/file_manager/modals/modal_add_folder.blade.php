<div class="modal-header">
    <h5 class="modal-title" id="modalAddCarpetaCenterTitle">Agregar Nueva Carpeta</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form action="addFolder_FM" class="was-validated" method="POST" enctype="multipart/form-data">
    @csrf
    <input id="folder_id_materia" class="form-control is-invalid" value="{{$_GET["materia"]}}" name="id_materia" hidden="">
    <input id="folder_id_curso" class="form-control is-invalid" value="{{$_GET["curso"]}}" name="id_curso" hidden="">
    <input id="folder_year" class="form-control is-invalid" value="{{$year}}" name="year" hidden="">
    <input id="folder_path_file" class="form-control is-invalid" value="{{$path}}" name="path_folder" hidden="">
    <div class="modal-body">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputNombreCarpeta">Nombre</span>
            </div>
            <input type="text" class="form-control" maxlength="50" minlength="3" required aria-label="Sizing example input" aria-describedby="inputNombreCarpeta" id="addFolder" name="addFolder">                            
            <script>
                // Validation Chars
                $('#addFolder').bind('keypress', function(e) {
                    if($('#addFolder').val().length >= 0){
                        var k = e.which;
                        var ok = (k == 32) || //space 
                                (k > 47 && k < 58)|| // 0-9
                                (k >= 65 && k <= 90) || // A-Z
                                (k > 96 && k < 123) ||// a-z
                                (k == 241 || k == 209) || //ñ Ñ
                                (k == 225 || k == 233 || k == 237 || k == 243 || k == 250) || //áéíóú
                                (k == 193 || k == 201 || k == 205 || k == 211 || k == 218); //ÁÉÍÓÚ
                        if (!ok){
                            e.preventDefault();
                        }
                    }
                });
            </script>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="sumbit" class="btn btn-primary">Guardar</button>
    </div>
</form>