<div class="modal-header">
    <h5 class="modal-title" id="modalEditItemCenterTitle">Cambiando nombre de: <span id="spnEditName"></span> </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form action="renameItem_FM" class="was-validated" method="POST" enctype="multipart/form-data">
    @csrf
    <input id="renameId" class="form-control is-invalid" value="" name="renameId" hidden="">
    <input id="renameName" class="form-control is-invalid" value="" name="renameName" hidden="">
    <input id="renamePath" class="form-control is-invalid" value="" name="renamePath" hidden="">
    <input id="renameParent" class="form-control is-invalid" value="" name="renameParent" hidden="">
    <input id="renameType" class="form-control is-invalid" value="" name="renameType" hidden="">
    <div class="modal-body">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputNewName">Nuevo Nombre</span>
            </div>
            <input type="text" class="form-control" maxlength="50" minlength="3" aria-label="Sizing example input" aria-describedby="inputNewName" id="newNameItem" name="newNameItem">
            <script>
                // Validation Chars
                $('#newNameItem').bind('keypress', function(e) {
                    if($('#newNameItem').val().length >= 0){
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
        <button type="sumbit" class="btn btn-primary" id="smbBtnEditItem">Guardar</button>
    </div>
</form>