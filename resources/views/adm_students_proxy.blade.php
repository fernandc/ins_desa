@extends("layouts.mcdn")
@section("title")
    Cambio de apoderado
@endsection

@section("headex")
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endsection

@section("context")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <h2>
                        Cambio de Apoderado
                    </h2>
                </div>
            </div> 
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="inputPassword" class="col-md-6 col-form-label">Para alumnos matriculados en</label>
                    <div class="col-md-6">
                        <select id="input-year" class="form-control">
                            <option value="">Seleccione</option>
                            <option>{{Session::get('period')}}</option>
                            <option>{{Session::get('period')+1}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div id="card2" style="display: none;">
                    <div class="card">
                        <div class="card-header">
                            Apoderado actual
                        </div>
                        <div class="card-body">
                            <select id="select2" class="form-control form-control-sm"></select>
                            <div id="lista2" style="display: none;">
                                <hr>
                                <b>Alumnos matriculados:</b>
                                <div id="listaAlumnos2">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div id="card3" style="display: none;">
                    <div class="card">
                        <div class="card-header">
                            Apoderado destino
                        </div>
                        <div class="card-body">
                            <select id="select3" class="form-control form-control-sm"></select>
                            <div id="lista3" style="display: none;">
                                <hr>
                                <b>Alumnos matriculados:</b>
                                <div id="listaAlumnos3">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center">
                <hr>
                <button id="btnChangeProxy" class="btn btn-success" disabled="">Cambiar apoderado</button>
            </div>
        </div>
    </div>
    <script>
        var current_proxy = "";
        var new_proxy = "";
        var year = "";
        $("#input-year").change(function(){
            year = $(this).val();
            if(year != ""){
                $("#card2").show();
                $("#card3").show();
                $("#listaAlumnos2").empty();
                $("#listaAlumnos3").empty();
                $("#lista2").hide();
                $("#lista3").hide();
                $.ajax({
                    url: "get_proxys",
                    type: "POST",
                    data:{
                    "_token": "{{ csrf_token() }}",
                    year
                    },
                    success:function(data){
                        $("#select2").empty();
                        $("#select2").append('<option value="">Seleccione un apoderado</option>');
                        $.each(data, function(index, value){
                            $("#select2").append('<option value="'+value.id+'">'+value.names + ' ' + value.last_f + ' ' + value.last_m +' - '+value.dni+'</option>');
                        });
                        $("#select2").select2({
                            placeholder: "Seleccione un apoderado",
                            allowClear: true
                        });
                        $("#select3").empty();
                        $("#select3").append('<option value="">Seleccione un apoderado</option>');
                        $.each(data, function(index, value){
                            $("#select3").append('<option value="'+value.id+'">'+value.names + ' ' + value.last_f + ' ' + value.last_m +' - '+value.dni+'</option>');
                        });
                        $("#select3").select2({
                            placeholder: "Seleccione un apoderado",
                            allowClear: true
                        });
                    }
                });
            }else{
                $("#btnChangeProxy").prop("disabled", true);
                $("#card2").hide();
                $("#card3").hide();
                $("#select2").empty();
                $("#select2").append('<option value="">Seleccione un apoderado</option>');
                $("#select2").select2({
                    placeholder: "Seleccione un apoderado",
                    allowClear: true
                });
            }
        });
        $("#select2").change(function(){
            $("#btnChangeProxy").prop("disabled", true);
            current_proxy = $(this).val();
            change_proxy();
        });
        $("#select3").change(function(){
            $("#btnChangeProxy").prop("disabled", true);
            new_proxy = $(this).val();
            change_proxy();
        });
        function change_proxy(){
            if(this.current_proxy == undefined || this.new_proxy == undefined){
                return;
            }
            if(this.current_proxy == this.new_proxy){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No puede seleccionar el mismo apoderado',
                });
                $("#listaAlumnos2").empty();
                $("#listaAlumnos3").empty();
                $("#lista2").hide();
                $("#lista3").hide();
                return;
            }
            if(this.current_proxy != "" && this.new_proxy != ""){
                $.ajax({
                    url: "get_students_by_proxy",
                    type: "POST",
                    data:{
                    "_token": "{{ csrf_token() }}",
                    "year" : this.year,
                    "proxy" : this.current_proxy
                    },
                    success:function(data){
                        $("#listaAlumnos2").empty();
                        $.each(data, function(index, value){
                            $("#listaAlumnos2").append('<div class="form-check"><input class="form-check-input checkstu" type="checkbox" value="'+value.id_stu+'" id="check'+value.id_stu+'"><label class="form-check-label" for="check'+value.id_stu+'">'+value.nombre_stu+' - '+value.curso+'</label></div>');
                        });
                        $(".checkstu").click(function(){
                            let id_stu = $(this).val();
                            let student = $(this).parent().children("label").text();
                            if($(this).is(":checked")){
                                //add class to label text-danger
                                $(this).parent().children("label").addClass("text-danger");
                                $(this).parent().children("label").css("text-decoration", "line-through");
                                $("#listaAlumnos3").append(`
                                    <div id="${id_stu}" class='text-success'>
                                        <hr>
                                        + ${student}
                                        <input class="id_zmail" type='hidden' value='${current_proxy}'>
                                        <input class="id_new_zmail" type='hidden' value='${new_proxy}'>
                                        <input class="id_stu" type='hidden' value='${id_stu}'>
                                        <input class="form-control parent" type='text' placeholder='Parentesco'> 
                                    </div>`);
                            }else{
                                $(this).parent().children("label").removeClass("text-danger");
                                $(this).parent().children("label").css("text-decoration", "none");
                                $("#"+id_stu).remove();
                            }
                            $(".parent").keyup(function(){
                                let allParentsFilled = true;
                                $(".parent").each(function() {
                                    if ($(this).val() === "" || $(this).val() === null) {
                                        allParentsFilled = false;
                                        return false;
                                    }
                                });
                                if (allParentsFilled) {
                                    $("#btnChangeProxy").prop("disabled", false);
                                }else{
                                    $("#btnChangeProxy").prop("disabled", true);
                                }
                            });
                        });
                    }
                });
                $.ajax({
                    url: "get_students_by_proxy",
                    type: "POST",
                    data:{
                    "_token": "{{ csrf_token() }}",
                    "year" : this.year,
                    "proxy" : this.new_proxy
                    },
                    success:function(data){
                        $("#listaAlumnos3").empty();
                        $.each(data, function(index, value){
                            $("#listaAlumnos3").append('<div class="form-check"><input class="form-check-input" type="checkbox" disabled=""><label class="form-check-label">'+value.nombre_stu+' - '+value.curso+'</label></div>');
                        });
                    }
                });
                $("#lista2").show();
                $("#lista3").show();
            }
        }
        $("#btnChangeProxy").click(function(){
            if($(this).prop("disabled")){
                return;
            }
            Swal.fire({
                title: '¿Está seguro?',
                text: "Se cambiará el apoderado de los alumnos seleccionados",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Sí, cambiar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    let students = [];
                    $("#listaAlumnos3 > .text-success").each(function(){
                        let id_zmail = $(this).children(".id_zmail").val();
                        let id_new_zmail = $(this).children(".id_new_zmail").val();
                        let id_stu = $(this).children(".id_stu").val();
                        let parent = $(this).children(".parent").val();
                        students.push({
                            "id_zmail" : id_zmail,
                            "id_new_zmail" : id_new_zmail,
                            "id_stu" : id_stu,
                            "parent" : parent
                        });
                    });
                    $.ajax({
                        url: "change_proxy",
                        type: "POST",
                        data:{
                        "_token": "{{ csrf_token() }}",
                        "students" : students,
                        "year" : year
                        },
                        success:function(data){
                            Swal.fire({
                                title: '¡Éxito!',
                                text: 'El apoderado de los alumnos seleccionados ha sido cambiado.',
                                icon: 'success',
                                timer: 5000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection