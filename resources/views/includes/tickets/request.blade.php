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
    <div class="col-md-6 team-b" style="display: none;">
        <label for="txtSubject">Asunto de la <span class="referer-team"></span> <span class="text-danger">*</span></label>
        <select class="custom-select is-valid valinput" id="txtSubject" autocomplete="off" required="">
            <option>Asunto Personal</option>
            <option>Asunto Médico</option>
            <option>Otros Asuntos</option>
        </select>
    </div>
    <div class="col-md-6 team-b" style="display: none;">
        <label for="dates" class="form-label">Fecha y hora Inicio - Fecha y hora Fin de la Ausencia<span class="text-danger">*</span></label>
        <input class="form-control is-invalid valinput" id="dateBeet" type="text" autocomplete="off" required="" />
    </div>
    <div class="col-md-12 team-b" style="display: none;">
        <label for="txtBody">Detalles y/o Mensaje de la <span class="referer-team"> </span> </span> <span class="text-danger">*</span></label>
        <textarea class="form-control is-invalid valinput" id="txtBody" rows="2" autocomplete="off" minlength="6" required=""></textarea>
    </div>
    <div class="col-md-4 custom-file team-b mb-5" style="display: none;">
        <label id="labelFile1" for="file1" class="form-label mt-2">Archivo 1 opcional para la <span class="referer-team"> </span></label>
        <input type="file" class="custom-file-input is-invalid valinput" id="file1" accept=".docx,.pdf,image/*" autocomplete="off">
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
    var totalsValidates = 2;
    var dateIn = "";
    var dateOut = "";
    $("#txtSubject").change(function(){
        if($(this).val() == "Asunto Médico"){
            totalsValidates = 3;
            $("#file1").attr("required");
            $("#labelFile1").html("<b>Adjuntar boleta de pago</b> <span class='text-danger'>*</span>");
        }else{
            totalsValidates = 2;
            $("#labelFile1").html("Archivo 1 opcional para la <span class='referer-team'> </span>");
        }
    });
    $("#optionSelect").change(function(){
        $(".referer-team").html($(this).val());
        typeSel = $(this).val();
        $(".team-b").show();
        if($(this).val() == "Solicitud"){
            $('#dateBeet').daterangepicker({
                timePicker24Hour: true,
                minDate: "{{Date('d/m/Y', strtotime('+3 days'))}}",
                autoUpdateInput: true,
                showDropdowns: true,
                timePicker: true,
                autoApply: true,
                //startDate: moment().startOf('hour'),
                endDate: "{{Date('d/m/Y', strtotime('+4 days'))}}",
                locale: {
                    format: 'DD/MM/Y hh:mm A',
                    cancelLabel: 'Cancelar',
                    applyLabel: "Seleccionar",
                    fromLabel: "De",
                    toLabel: "a",
                    daysOfWeek: ["Do","Lu","Ma","Mi","Ju","Vi","Sa"
                    ],
                    monthNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
                    firstDay: 1
                }
            });
        }else{
            $('#dateBeet').daterangepicker({
                timePicker24Hour: true,
                autoUpdateInput: true,
                showDropdowns: true,
                timePicker: true,
                autoApply: true,
                //startDate: moment().startOf('hour'),
                //endDate: moment().startOf('hour').add(32, 'hour'),
                locale: {
                    format: 'DD/MM/Y hh:mm A',
                    cancelLabel: 'Cancelar',
                    applyLabel: "Seleccionar",
                    fromLabel: "De",
                    toLabel: "a",
                    daysOfWeek: ["Do","Lu","Ma","Mi","Ju","Vi","Sa"
                    ],
                    monthNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
                    firstDay: 1
                }
            });
        }
        $("#file1").on('change',function(e){
            var fileName1 = e.target.files[0].name;
            $(this).next('.custom-file-label').html(fileName1);
        })
        $("#file2").on('change',function(e){
            var fileName2 = e.target.files[0].name;
            $(this).next('.custom-file-label').html(fileName2);
        })
        $("#file3").on('change',function(e){
            var fileName3 = e.target.files[0].name;
            $(this).next('.custom-file-label').html(fileName3);
        })
    });
    $("#dateBeet").change(function(){
        var dates = $("#dateBeet").val().split(" - ");
        dateIn = formatHours(dates[0]);
        dateOut = formatHours(dates[1]);
        dateIn = dateIn.replace(/\//g, "-");
        dateOut = dateOut.replace(/\//g, "-");
        console.log(dateIn);
        console.log(dateOut);
    });
    $(".valinput").on("keyup change", function(e) {
        var valDatetov = 0;
        var valBody = 0;
        var valFile = 0;
        if(typeSel == "Solicitud"){
            if($("#dateBeet").val() < "{{Date('Y-m-d', strtotime('+3 days'))}}"){
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
        if($("#dateBeet").val() != ""){
            valDatetov = 1;
        }else{
            valDatetov = 0;
        }
        if($("#file1").val() != ""){
            valFile = 1;
        }else{
            valFile = 0;
        }
        if((valBody+valDatetov+valFile) >= totalsValidates){
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
            formData.append('dateFrom', dateIn);
            formData.append('dateTo', dateOut);
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