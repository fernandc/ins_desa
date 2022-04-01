<div class="row was-validated mt-3">
    <div class="col-md-4">
        <label for="optionSelect" class="form-label">Seleccione Solicitud o Justificación</label>
        <select class="custom-select is-valid valinput" id="optionSelect" autocomplete="off" required="">
            <option selected="" disabled="" value="">Seleccione una Opción</option>
            <option>Solicitud</option>
            <option>Justificación</option>
        </select>
    </div>
    <div class="col-md-8">
        <span>Ejemplos de Solicitudes y Justificaciones: </span>
        <ul>
            <li>Por ausencia de día(s) </li>
            <li>Retiros dentro de la jornada laboral o atrasos </li>
            <li class="text-danger">Las Solicitudes deben ser con al menos 48 horas de anticipación</li>
        </ul>
    </div>
    <div class="col-md-12 team-b" style="display: none;">
        <label for="txtSubject">Asunto de la <span class="referer-team"></span> <span class="text-danger">*</span></label>
        <select class="custom-select is-valid valinput" id="txtSubject" autocomplete="off" required="">
            <option>Asunto Personal</option>
            <option>Asunto Médico</option>
            <option>Otros Asuntos</option>
        </select>
    </div>
    <div class="col-md-12 team-b" style="display: none;">
        <label for="txtBody">Detalles y/o Mensaje de la <span class="referer-team"> </span> </span> <span class="text-danger">*</span></label>
        <textarea class="form-control is-invalid valinput" id="txtBody" rows="2" autocomplete="off" minlength="6" required=""></textarea>
    </div>
    <div class="col-md-6 team-b" style="display: none;">
        <label for="optionSelect" class="form-label"><span class="referer-team"> </span> para la fecha <span class="text-danger">*</span> <span id="datetomessage" class="text-danger"></span></label>
        <input class="form-control is-invalid valinput" type="date" id="txtDateTo" autocomplete="off" required="">
    </div>
    <div class="col-md-6 team-b" style="display: none;">
        <label for="selRemuneracion" class="form-label">La <span class="referer-team"> </span> ¿debe ser remunerada? <span class="text-danger">*</span></label>
        <select class="custom-select is-invalid valinput" id="selRemuneracion" autocomplete="off" required="">
            <option selected="" disabled="" value="">Seleccione una Opción</option>
            <option>No</option>
            <option>Si</option>
        </select>
    </div>
    <div class="col-md-4 custom-file team-b mb-5" style="display: none;">
        <label for="file1" class="form-label mt-2">Archivo 1 opcional para la <span class="referer-team"> </span></label>
        <input type="file" class="custom-file-input valinput" id="file1" accept=".docx,.pdf,image/*" autocomplete="off">
        <label class="custom-file-label" for="file1" style="top: auto;margin-left: 15px;margin-right: 15px;">Adjuntar Archivo</label>
    </div>
    <div class="col-md-4 custom-file team-b mb-5" style="display: none;">
        <label for="file2" class="form-label mt-2">Archivo 2 opcional para la <span class="referer-team"> </span></label>
        <input type="file" class="custom-file-input valinput" id="file2" accept=".docx,.pdf,image/*" autocomplete="off">
        <label class="custom-file-label" for="file2" style="top: auto;margin-left: 15px;margin-right: 15px;">Adjuntar Archivo</label>
    </div>
    <div class="col-md-4 custom-file team-b mb-5" style="display: none;">
        <label for="file3" class="form-label mt-2">Archivo 3 opcional para la <span class="referer-team"> </span></label>
        <input type="file" class="custom-file-input valinput" id="file3" accept=".docx,.pdf,image/*" autocomplete="off">
        <label class="custom-file-label" for="file3" style="top: auto;margin-left: 15px;margin-right: 15px;">Adjuntar Archivo</label>
    </div>
    <div class="col-md-4 team-b" style="display: none;">
    </div>
    <div class="col-md-4 team-b mt-2" style="display: none;">
        <button id="btnSubmit" class="btn btn-secondary w-100" disabled="">Enviar <span class="referer-team"> </span></button>
    </div>
    <div class="col-md-4 team-b" style="display: none;">
    </div>
    <div class="col-md-12 " id="response">
    </div>
</div>
<script>
    var flag = false;
    var typeSel = "";
    $("#optionSelect").change(function(){
        $(".referer-team").html($(this).val());
        typeSel = $(this).val();
        $(".team-b").show();
        if($(this).val() == "Solicitud"){
            $("#txtDateTo").attr({ "min" : "{{Date('Y-m-d')}}"})
        }else{
            $("#txtDateTo").removeAttr("min");
        }
        $("#file1").on('change',function(e){
            var fileName = e.target.files[0].name;
            $(this).next('.custom-file-label').html(fileName);
        })
    });
    $(".valinput").on("keyup change", function(e) {
        var valDatetov = 0;
        var valRemuner = 0;
        var valBody = 0;
        if(typeSel == "Solicitud"){
            if($("#txtDateTo").val() < "{{Date('Y-m-d', strtotime('+3 days'))}}"){
                $("#datetomessage").html("La fecha de la Solicitud debe ser con 2 días de anticipación de la fecha Actual");
            }else{
                $("#datetomessage").html("");
            }
        }else{
            $("#datetomessage").html("");
        }
        if($("#txtBody").val().length >= 6){
            valBody = 1;
        }else{
            valBody = 0;
        }
        if($("#txtDateTo").val() != ""){
            valDatetov = 1;
        }else{
            valDatetov = 0;
        }
        if($("#selRemuneracion option:selected").val() != ""){
            valRemuner = 1;
        }else{
            valRemuner = 0;
        }
        if((valBody+valDatetov+valRemuner) == 3){;
            $("#btnSubmit").removeClass("btn-secondary").addClass("btn-success");
            $("#btnSubmit").removeAttr("disabled");
            flag = true;
        }else{
            $("#btnSubmit").attr("disabled",true);
            $("#btnSubmit").removeClass("btn-success").addClass("btn-secondary");
        }
    });
    $("#btnSubmit").click(function(){
        if(flag){
            Swal.fire({
                icon: 'info',
                title: 'Cargando',
                showConfirmButton: false,
            });
            var formData = new FormData();
            formData.append('_token', "{{csrf_token()}}");
            formData.append('type', $("#optionSelect option:selected").val());
            formData.append('subject', $("#txtSubject option:selected").val());
            formData.append('message', $("#txtBody").val());
            formData.append('dateto', $("#txtDateTo").val());
            formData.append('optional1', $("#selRemuneracion option:selected").val());
            formData.append('file1', $('#file1')[0].files[0]);
            formData.append('file2', $('#file2')[0].files[0]);
            formData.append('file3', $('#file3')[0].files[0]);
            $.ajax({
                url: "send_ticket",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    if(response == "C"){
                        Swal.fire({
                            icon: 'info',
                            title: 'Importante',
                            text: 'la fecha elegida debe ser 2 días adicionales a hoy'
                        });
                    }else if(response == "A"){
                        Swal.fire({
                            icon: 'success',
                            title: 'Completado!',
                            text: 'La '+typeSel+' ha sido enviada'
                        });
                        location.reload();
                    }
                    
                }
            });
        }
    });
</script>