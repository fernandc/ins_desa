
@php
$fullname = '';
$dni = '';
$sex = '';
$bornDate = '';
$nationality = '';
$afp = '';
$isapre = '';
$city = '';
$commune = '';
$address = '';
$personal_email = '';
$cellPhone = '';
$foto = '';
$civil_status = '';
if(isset($data)){
    $data = $data[0];
    // dd($data);
    $names = $data["nombres"];
    $f_last_name = $data["apellido_paterno"];
    $m_last_name = $data["apellido_materno"];
    $dni = $data['rut'];
    $sex = $data['sexo'];
    $nationality = $data['nacionalidad'];
    $afp = $data['afp'];
    $isapre = $data['isapre'];
    $city = $data['ciudad'];
    $commune = $data['comuna'];
    $address = $data['direccion'];
    $cellPhone = $data['celular'];
    $civil_status = $data['estado_civil'];
    $bornDate = $data['fecha_nacimiento'];

    $bornDate = explode("-",$bornDate);
    $newBornDate = $bornDate[2]."-".$bornDate[1]."-".$bornDate[0]; 

    if($data['email_personal'] != '' || $data['email_personal'] != null){
        $personal_email = $data['email_personal'];
    }
    if($data['ruta_foto'] != '' || $data['ruta_foto'] != null){
        $foto = $data['ruta_foto'];
        $foto = str_replace("/","-",$foto);
    }
}   
@endphp
<form action="save_user_info" method="post" class="was-validated" enctype="multipart/form-data">
@csrf
<h2>Información del usuario </h2>        
<hr>
<div class="form-row card my-3" style="flex-direction: unset !important; ">
    <div class="form-group col-md-4">
        <label for="output" style="font-weight: bold;">Foto de carnet (frontal)</label>
        <div class="text-center">
            @if ($foto != '')
                <img class="rounded mt-2" id="output" style="max-height:232px; max-width:90%;"  src="get_file/{{$foto}}"/>                    
            @else                    
                <img class="rounded mb-3" id="output" style="max-height:232px; max-width:90%" onchange="loadFile(event)" src="images/dni-ejemplo.png"/>
            @endif
        </div>                    
        <div class="custom-file" style="position: absolute;bottom: 0px;left: 10px;width: 95%;"">
            <input type="file" class="custom-file-input" onchange="loadFile(event)" accept="image/*" autocomplete="off" id="inputImgFile" name="inputImgFile"  lang="es">
            <label id="inputImgFileLabel" for="inputImgFile" data-browse="Buscar" class="custom-file-label">Subir archivo...</label>
        </div>
    </div>                
    <div class="form-group col-md-4">
        @if ($dni != '')
            <label for="inputDni" style="font-weight: bold;">Rut</label>
            <input type="text" value="{{$dni}}" class="form-control is-valid" id="inputDni" name="inputDni" required minlength="6" maxlength="11" oninput="checkRut(this)" placeholder="Ingrese rut sin puntos y con guión." >                    
        @else
            <label for="inputDni" style="font-weight: bold;">Rut</label>
            <input type="text" class="form-control is-valid" id="inputDni" name="inputDni" required minlength="6" maxlength="11" oninput="checkRut(this)" placeholder="Ingrese rut sin puntos y con guión." >                    
        @endif
        @if ($names != '')
            <label for="inputNameStaff" style="font-weight: bold;">Nombres</label>
            <input type="text" value="{{$names}}" class="form-control" id="inputNameStaff" name="inputNameStaff" required minlength="3" maxlength="150" placeholder="Nombres">
        @else
            <label for="inputNameStaff" style="font-weight: bold;">Nombres</label>
            <input type="text" class="form-control" id="inputNameStaff" name="inputNameStaff" required minlength="3" maxlength="150" placeholder="Nombres">
        @endif
        @if ($f_last_name != '')
            <label for="input_ln_f" style="font-weight: bold;">Apellido paterno</label>
            <input type="text" value="{{$f_last_name}}" class="form-control" id="input_ln_f" name="input_ln_f" required minlength="3" maxlength="150" placeholder="Apellido paterno">
        @else
            <label for="input_ln_f" style="font-weight: bold;">Apellido paterno</label>
            <input type="text" class="form-control" id="input_ln_f" name="input_ln_f" required minlength="3" maxlength="150" placeholder="Apellido paterno">
        @endif
        @if ($m_last_name != '')
            <label for="input_ln_m" style="font-weight: bold;">Apellido materno</label>
            <input type="text" value="{{$m_last_name}}" class="form-control" id="input_ln_m" name="input_ln_m" required minlength="3" maxlength="150" placeholder="Apellido materno">
        @else
            <label for="input_ln_m" style="font-weight: bold;">Apellido materno</label>
            <input type="text" class="form-control" id="input_ln_m" name="input_ln_m" required minlength="3" maxlength="150" placeholder="Apellido materno">
        @endif
       
    </div>
    <div class="form-group col-md-4">
        <label for="sex_opt" style="font-weight: bold;">Sexo</label>
        <select class="custom-select" id="sex_opt" required name="sex_opt">
            <option selected value="">Seleccionar</option>
            <option value="Femenino">Femenino</option>
            <option value="Masculino">Masculino</option>
            <option value="Otro">Otro</option>
        </select>                
        @if ($sex != '')
            <script>
                $(document).ready(function(){
                    $('#sex_opt option[value="{{$sex}}"').prop('selected', true);
                });
            </script>
        @endif
        @if ($bornDate != '')
            <label for="inputBornDate" style="font-weight: bold;">Fecha de Nacimiento</label>
            <input type="text" value="{{$newBornDate}}" class="form-control" required id="inputBornDate" name="inputBornDate" value="" min="1900-01-01" max="">
        @else
            <label for="inputBornDate" style="font-weight: bold;">Fecha de Nacimiento</label>
            <input type="text" class="form-control" required id="inputBornDate" name="inputBornDate" value="" min="1900-01-01" max="">                    
        @endif
        {{-- <h6 class="mb-2">Nacionalidad</h6> --}}
        <label id="inputNationalityLabel" for="inputNationality" style="font-weight: bold;">Nacionalidad</label>
        <select class="custom-select" id="inputNationality" required name="inputNationality">
            <option selected value="">Seleccione</option>
            <option value="Alemana" >Alemana</option>
            <option value="Argentina" >Argentina</option>
            <option value="Australiana" >Australiana</option>
            <option value="Boliviana" >Boliviana</option>
            <option value="Brasilera" >Brasilera</option>
            <option value="Chilena" >Chilena</option>
            <option value="China" >China</option>
            <option value="Colombiana" >Colombiana</option>
            <option value="Coreana" >Coreana</option>
            <option value="Cubana" >Cubana</option>
            <option value="Dominicana" >Dominicana</option>
            <option value="Ecuatoriana" >Ecuatoriana</option>
            <option value="Española" >Española</option>
            <option value="Estadounidense" >Estadounidense</option>
            <option value="Francesa" >Francesa</option>
            <option value="Haitiana" >Haitiana</option>
            <option value="Italiana" >Italiana</option>
            <option value="Japonesa" >Japonesa</option>
            <option value="Mexicana" >Mexicana</option>
            <option value="Panameña" >Panameña</option>
            <option value="Paraguaya" >Paraguaya</option>
            <option value="Peruana" >Peruana</option>
            <option value="Rusa" >Rusa</option>
            <option value="Sueca" >Sueca</option>
            <option value="Suiza" >Suiza</option>
            <option value="Uruguaya" >Uruguaya</option>
            <option value="Venezolana" >Venezolana</option>
            <option value="Apátrida (sin nacionalidad)" >Apátrida (sin nacionalidad)</option>
            <option value="Otra">Otra</option>
        </select>
        @if ($nationality != '')
            <script>
                $(document).ready(function(){
                    $('#inputNationality option[value="{{$nationality}}"').prop('selected', true);
                });
            </script>
        @endif
        <label id="inputCivilStatusLabel" for="inputCivilStatus" style="font-weight: bold;">Estado Civil</label>
        <select class="custom-select" name="inputCivilStatus" id="inputCivilStatus" required>
            <option selected value="">Seleccione</option>
            <option value="Soltero / Soltera">Soltero / Soltera</option>
            <option value="Casado / Casada">Casado / Casada</option>
            <option value="Viudo / Viuda">Viudo / Viuda</option>
            <option value="Divorciado / Divorciada">Divorciado / Divorciada</option>
            <option value="Conviviente civil">Conviviente civil</option>
        </select>
        @if ($civil_status != '')
            <script>
                $(document).ready(function(){
                    $('#inputCivilStatus option[value="{{$civil_status}}"').prop('selected', true);
                });
            </script>
        @endif
    </div>
</div>

<div class="form-row">

    <div class="form-group col-md-4">
        @if ($city != '')
            <label for="inputCity" style="font-weight: bold;">Ciudad <span class="text-secondary" style="font-weight: normal;">(de residencia)</span></label>
            <input type="text" value="{{$city}}" class="form-control" required minlength="3" maxlength="30"  placeholder="Ejemplo: Santiago" id="inputCity" name="inputCity">
        @else
            <label for="inputCity" style="font-weight: bold;">Ciudad <span class="text-secondary" style="font-weight: normal;">(de residencia)</span></label>
            <input type="text" class="form-control" required minlength="3" maxlength="30"  placeholder="Ejemplo: Santiago" id="inputCity" name="inputCity">                    
        @endif
    </div>
    <div class="form-group col-md-4">
        @if ($commune != '')
            <label for="inputCommune" style="font-weight: bold;">Comuna <span class="text-secondary" style="font-weight: normal;">(de residencia)</span></label>
            <input type="text" value="{{$commune}}" class="form-control" required minlength="3" maxlength="50"  placeholder="Ejemplo: La Florida" id="inputCommune" name="inputCommune">
        @else
            <label for="inputCommune" style="font-weight: bold;">Comuna <span class="text-secondary" style="font-weight: normal;">(de residencia)</span></label>
            <input type="text" class="form-control" required minlength="3" maxlength="50"  placeholder="Ejemplo: La Florida" id="inputCommune" name="inputCommune">                    
        @endif
    </div>
    <div class="form-group col-md-4">
        @if ($address != '')
            <label for="inputAddress" style="font-weight: bold;">Dirección <span class="text-secondary" style="font-weight: normal;">(de residencia)</span></label>
            <input type="text" value="{{$address}}" class="form-control" required minlength="3" placeholder="Ejemplo: Pedro Donoso 8741" maxlength="150" id="inputAddress" name="inputAddress">
        @else
            <label for="inputAddress" style="font-weight: bold;">Dirección <span class="text-secondary" style="font-weight: normal;">(de residencia)</span></label>
            <input type="text" class="form-control" required minlength="3" placeholder="Ejemplo: Pedro Donoso 8741" maxlength="150" id="inputAddress" name="inputAddress">                    
        @endif
    </div>
    <div class="form-group col-md-6">
        @if ($personal_email != '')
            <label for="personal_email" style="font-weight: bold;">Correo Personal</label>
            <input type="email" required value="{{$personal_email}}" class="form-control"  minlength="3" maxlength="64" placeholder="Ejemplo: ejemplo@ejemplo.cl" id="personal_email" name="personal_email">                    
        @else                    
            <label for="personal_email" style="font-weight: bold;">Correo Personal</label>
            <input type="email" required class="form-control"  minlength="3" maxlength="64" placeholder="Ejemplo: ejemplo@ejemplo.cl" id="personal_email" name="personal_email">
        @endif
    </div>
    
    <div class="form-group col-md-6">
        @if ($cellPhone != '')
            <label for="inputCellPhone" style="font-weight: bold;">Celular</label>
            <input type="number" value="{{$cellPhone}}" class="form-control" required min="56900000000" max="56999999999" placeholder="Ejemplo: 56911112222" id="inputCellPhone" name="inputCellPhone">                                        
        @else
            <label for="inputCellPhone" style="font-weight: bold;">Celular</label>
            <input type="number" class="form-control" required min="56900000000" max="56999999999" placeholder="Ejemplo: 56911112222" id="inputCellPhone" name="inputCellPhone">                    
        @endif
    </div>
    <div class="form-group col-md-6">
        <h6>AFP</h6>
        <select class="custom-select" id="afp_opt" required name="afp_opt">
            <option selected value="">Seleccione</option>
            <option value="AFP Capital">AFP Capital</option>
            <option value="AFP Cuprum">AFP Cuprum</option>
            <option value="AFP Habitat">AFP Habitat</option>
            <option value="AFP Modelo">AFP Modelo</option>
            <option value="AFP Planvital">AFP Planvital</option>
            <option value="AFP Provida">AFP Provida</option>
            <option value="AFP Uno">AFP Uno</option>
        </select>
        @if ($afp != '')
            <script>
                $(document).ready(function(){
                    $('#afp_opt option[value="{{$afp}}"').prop('selected', true);
                });
            </script>
        @endif
    </div>
    <div class="form-group col-md-6">
        <h6>Isapre</h6>
        <select class="custom-select" id="isapre_opt" required name="isapre_opt">
            <option selected value="">Seleccione</option>
            <option value="Fonasa">Fonasa</option>
            <option value="Isapre Banmedica S.A">Isapre Banmedica S.A</option>
            <option value="Isapre Colmena Golden Cross S.A">Isapre Colmena Golden Cross S.A</option>
            <option value="Isapre Consalud">Isapre Consalud</option>
            <option value="Isapre Cruz Blanca">Isapre Cruz Blanca</option>
            <option value="Isapre Fundación Banco del Estado">Isapre Fundación Banco del Estado</option>
            <option value="Isapre Nueva Más Vida">Isapre Nueva Más Vida</option>
            <option value="Isapre Vida Tres S.A">Isapre Vida Tres S.A</option>
            <option value="No Informada">No Informada</option>
            <option value="Oncovida - Ges">Oncovida - Ges</option>
            <option value="Particular">Particular</option>
        </select>
        @if ($isapre != '')
            <script>
                $(document).ready(function(){
                    $('#isapre_opt option[value="{{$isapre}}"').prop('selected', true);
                });
            </script>
        @endif
    </div>
</div>
<div class="text-center">
    <button type="submit" class="btn btn-lg mb-3 btn-success" id="saveUserInfo" >Guardar</button>
</div>
</form>
<script>
// Verificar rut
function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }

    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');
}
// Upload File
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
    format:'d-m-Y',
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
$("#inputNameStaff").change(function(){
    var dataInput = $("#inputNameStaff").val();
    var newData = upperCaseInputLong(dataInput);
    $("#inputNameStaff").val(newData);
});
$("#input_ln_f").change(function(){
    var dataInput = $("#input_ln_f").val();
    var newData = upperCaseInputLong(dataInput);
    $("#input_ln_f").val(newData);
});
$("#input_ln_m").change(function(){
    var dataInput = $("#input_ln_m").val();
    var newData = upperCaseInputLong(dataInput);
    $("#input_ln_m").val(newData);
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