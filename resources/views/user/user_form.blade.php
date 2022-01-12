<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
My Info 
@endsection

@section("headex")
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" />
@endsection

@section("context")

<form action="save_user_info" method="post">
    @csrf
    <div class="container">
        <h2>Información del usuario </h2>        
        <br>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputFullName" style="font-weight: bold;">Nombre Completo</label>
                <input type="text" class="form-control" id="inputFullName" name="inputFullName" required minlength="3" maxlength="150">
            </div>
            <div class="form-group col-md-6">
                <label for="inputDni" style="font-weight: bold;">Rut</label>
                <input type="text" class="form-control" id="inputDni" name="inputDni" required minlength="6" maxlength="11" onchange ="checkRut(this)" placeholder="Ingrese rut sin puntos y con guión." >
            </div>
            <div class="form-group col-md-6">
                <h6>Foto</h6>
                <div class="custom-file">
                    <input type="file" class="custom-file-input"  accept=".pdf,image/*" autocomplete="off" id="inputImgFile" name="inputImgFile"  lang="es">
                    <label id="inputImgFileLabel" for="inputImgFile" class="custom-file-label">Subir archivo...</label>
                </div>
            </div>
            <div class="form-group col-md-6">
                <h6>Sexo</h6>
                <select class="custom-select" id="sex_opt" required name="sex_opt">
                    <option selected value="0">Seleccionar</option>
                    <option value="1">Femenino</option>
                    <option value="2">Masculino</option>
                    <option value="3">Otro</option>
                </select>
            </div>            
            <div class="form-group col-md-6">
                <label for="inputBornDate" style="font-weight: bold;">Fecha de Nacimiento</label>
                <input type="text" class="form-control" required id="inputBornDate" name="inputBornDate" value="" min="1900-01-01" max="">
            </div>            
            <div class="form-group col-md-6">
                <label id="inputNationalityLabel" for="inputNationality" style="font-weight: bold;">Nacionalidad</label>
                <input type="text" class="form-control" required placeholder="Ejemplo: Chileno" id="inputNationality" name="inputNationality">
            </div>
            <div class="form-group col-md-6">
                <h6>AFP</h6>
                <select class="custom-select" id="afp_opt" name="afp_opt">
                    <option selected value="0">Seleccione</option>
                    <option value="1">AFP Capital</option>
                    <option value="2">AFP Cuprum</option>
                    <option value="3">AFP Habitat</option>
                    <option value="4">AFP Modelo</option>
                    <option value="5">AFP Planvital</option>
                    <option value="6">AFP Provida</option>
                    <option value="7">AFP Uno</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <h6>Isapre</h6>
                <select class="custom-select" id="isapre_opt" name="isapre_opt">
                    <option selected value="0">Seleccione</option>
                    <option value="1">Fonasa</option>
                    <option value="2">Isapre Banmedica S.A</option>
                    <option value="2">Isapre Colmena Golden Cross S.A</option>
                    <option value="2">Isapre Consalud</option>
                    <option value="2">Isapre Cruz Blanca</option>
                    <option value="2">Isapre Fundación Banco del Estado</option>
                    <option value="2">Isapre Nueva Más Vida</option>
                    <option value="2">Isapre Vida Tres S.A</option>
                    <option value="2">No Informada</option>
                    <option value="2">Oncovida - Ges</option>
                    <option value="2">Particular</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="inputCity" style="font-weight: bold;">Ciudad</label>
                <input type="text" class="form-control" required minlength="3" maxlength="30"  placeholder="Ejemplo: Santiago" id="inputCity" name="inputCity">
            </div>
            <div class="form-group col-md-6">
                <label for="inputCommune" style="font-weight: bold;">Comuna</label>
                <input type="text" class="form-control" required minlength="3" maxlength="30"  placeholder="Ejemplo: La Florida" id="inputCommune" name="inputCommune">
            </div>
            <div class="form-group col-md-6">
                <label for="inputAddress" style="font-weight: bold;">Dirección</label>
                <input type="text" class="form-control" required minlength="3" placeholder="Ejemplo: Pedro Donoso 8741" maxlength="100" id="inputAddress" name="inputAddress">
            </div>
            <div class="form-group col-md-6">
                <label for="inputPhone" style="font-weight: bold;">Telefono</label>
                <input type="number" class="form-control" required minlength="6" maxlength="11" placeholder="2255555555" id="inputPhone" name="inputPhone">
            </div>
            <div class="form-group col-md-3"></div>
            <div class="form-group col-md-6">
                <label for="inputCellPhone" style="font-weight: bold;">Celular</label>
                <input type="text" class="form-control" required minlength="6" maxlength="11" placeholder="56911112222" id="inputCellPhone" name="inputCellPhone">
            </div>
            <div class="form-group col-md-3"></div>            
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-success" id="saveUserInfo" >Guardar</button>
        </div>
    </div>
</form>
<script>
        // Verificar si el rut es válido
    function checkRut(rut) {
        // if exist - s true
        var valor = rut.value.replace('.','');
        var arrRut = valor.split("");
        var dv = arrRut[arrRut.length-1];
        var rut = arrRut;
        var cuerporut = "";
        rut.forEach(element => {
            cuerporut = cuerporut.concat('',element);    
        });
        cuerporut = parseInt(cuerporut);
        if(dv != dgv(cuerporut)){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'El rut ingresado no es válido intente nuevamente.',
            });
            $("#inputDni").val("");
        }  
    }
    //digito verificador
    function dgv(T){  
        var M=0,S=1;
        for(;T;T=Math.floor(T/10))
        S=(S+T%10*(9-M++%6))%11;
        return S?S-1:'k';
    }
    // Upload File
    function file_extension(filename){
        return (/[.]/.exec(filename)) ? /[^.]+$/.exec(filename)[0] : undefined;
    }
    $('#inputImgFile').change(function() {
        var i = $(this).prev('label').clone();
        var file = $('#inputImgFile')[0].files[0].name;
        var extension = file_extension(file);
        if(extension == "pdf" || extension == "jpg" || extension == "png" || extension == "jpeg"){
            $("#inputImgFileLabel").html(file);
        }else{
            Swal.fire('Error!', 'el archivo no es válido.', 'error');
            file = null;
        }  
    });
    // BornDate DatePicker
    jQuery('#inputBornDate').datetimepicker({
        timepicker:false,
        format:'Y-m-d',
        maxDate:'+1970/01/01'
    });
    $.datetimepicker.setLocale('es');
    // UpperCase inputs with spaces
    function upperCaseInputLong(fullname){
        var name = fullname
        var arr = name.split(" ");
        for (let index = 0; index < arr.length; index++) {
            var element = arr[index];
            arr[index] = arr[index].charAt(0).toUpperCase() + arr[index].slice(1); 
        }
        newName = arr.join(" ");
        return newName;
    }
    // uppercaseinputs
    function upperCaseinput(data){
        var dataInput = data;
        dataInput.toString();
        var newdata = dataInput.charAt(0).toUpperCase() + dataInput.slice(1);
        return newdata;
    }
    $("#inputFullName").change(function(){
        var dataInput = $("#inputFullName").val();
        var newData = upperCaseInputLong(dataInput);
        $("#inputFullName").val(newData);
    });
    $("#inputCity").change(function(){
        var dataInput = $("#inputCity").val();
        var newData = upperCaseInputLong(dataInput);
        $("#inputCity").val(newData);
    });
    $("#inputCommune").change(function(){
        var dataInput = $("#inputCommune").val();
        var newData = upperCaseInputLong(dataInput);
        $("#inputCommune").val(newData);
    });
    $("#inputAddress").change(function(){
        var dataInput = $("#inputAddress").val();
        var newData = upperCaseInputLong(dataInput);
        $("#inputAddress").val(newData);
    });
    $("#inputNationality").change(function(){
        var dataInput = $("#inputNationality").val();
        var newData = upperCaseinput(dataInput);
        $("#inputNationality").val(newData);
    });
   
</script>
@endsection