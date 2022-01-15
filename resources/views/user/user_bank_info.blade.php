@php
    $bank = '';
    $account_type = '';
    $account_number = '';
    if(isset($data) && isset($data[0]["banco"])){
        $data = $data[0];
        $bank = $data["banco"];
        $account_type = $data["tipo_cuenta"];
        $account_number = $data["numero_cuenta"];
    }
@endphp
<div class="card">
    <div class="card-header" style="font-weight: bold;">       
        Información bancaria        
    </div>
    <div class="card-body">
        <form action="user_bank_data" method="post" class="was-validated" enctype="multipart/form-data">
            @csrf
            <div class="form-group">            
              <label for="user_bank_opt" style="font-weight: bold;">Banco</label>
              <select  class="custom-select" required name="user_bank_opt" id="user_bank_opt">
                    <option selected value="">Seleccione</option>
                    <option value="Banco BICE">Banco BICE</option>
                    <option value="Banco Consorcio">Banco Consorcio</option>
                    <option value="Banco Corpbanca">Banco Corpbanca</option>
                    <option value="Banco Crédito e inversiones">Banco Crédito e inversiones</option>
                    <option value="Banco Estado">Banco Estado</option>
                    <option value="Banco Falabella">Banco Falabella</option>
                    <option value="Banco Internacional">Banco Internacional</option>
                    <option value="Banco Paris">Banco Paris</option>
                    <option value="Banco Ripley">Banco Ripley</option>
                    <option value="Banco Santander">Banco Santander</option>
                    <option value="Banco Security">Banco Security</option>
                    <option value="Banco de Chile / Edwards-Citi">Banco de Chile / Edwards-Citi</option>
                    <option value="Banco del Desarrollo">Banco del Desarrollo</option>
                    <option value="Copeuch">Copeuch</option>
                    <option value="HSBC Bank">HSBC Bank</option>
                    <option value="Itaú">Itaú</option>
                    <option value="Rabobank">Rabobank</option>
                    <option value="Tenpo Prepago">Tenpo Prepago</option>
                    <option value="Prepago Los Héroes">Prepago Los Héroes</option>
                    <option value="Scotiabank">Scotiabank</option>
                    <option value="Scotiabank Azul">Scotiabank Azul</option>
                </select>
                <script>
                    $(document).ready(function(){
                        $('#user_bank_opt option[value="{{$bank}}"').prop('selected', true);
                    });
                </script>
            
            </div>
            <div class="form-group">
              <label for="user_account_type_opt" style="font-weight: bold;">Tipo de cuenta</label>
              <select  class="custom-select" required name="user_account_type_opt" id="user_account_type_opt">
                    <option selected value="">Seleccione</option>
                    <option value="Corriente" id="opt_corriente" >Corriente</option>
                    <option value="Vista" id="opt_vista" >Vista</option>
                    <option value="Rut" id="opt_rut" style="display:none">Rut</option>
                    <option value="Ahorro" id="opt_ahorro" >Ahorro</option>
                    <option value="Chequera Electrónica"id="opt_electronica" >Chequera Electrónica</option>
                </select>
                
                <script>
                    $(document).ready(function(){
                        $('#user_account_type_opt option[value="{{$account_type}}"').prop('selected', true);
                    });
                </script>
            </div>
            <div class="form-group">
                @if ($account_number != '')
                    <label for="user_bank_account_type" style="font-weight: bold;">Número de cuenta</label>
                    <input type="number" value="{{$account_number}}" class="form-control" required min="5" max="9999999999999999999" name="user_bank_account_type" id="user_bank_account_type" aria-describedby="helpId" placeholder="">                    
                @else
                    <label for="user_bank_account_type" style="font-weight: bold;">Número de cuenta</label>
                    <input type="number" class="form-control" required min="5" max="9999999999999999999" name="user_bank_account_type" id="user_bank_account_type" aria-describedby="helpId" placeholder="">
                @endif
            </div>
            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
        <script>
            $("#user_bank_opt").change(function(){
                var val = $(this).val();
                $("#opt_vista").show();
                $("#opt_corriente").show();
                $("#opt_electronica").show();                    
                $("#opt_ahorro").show();
                $("#opt_rut").show();
                if(val == "Banco Estado"){
                    $("#opt_rut").show();
                }else{
                    $("#opt_rut").hide();
                }
                if(val == "Tenpo Prepago"){
                    $("#opt_corriente").hide();
                    $("#opt_electronica").hide();                    
                    $("#opt_ahorro").hide();
                    $("#opt_rut").hide();
                }else if(val == "Prepago Los Héroes"){
                    $("#opt_corriente").hide();             
                    $("#opt_ahorro").hide();
                    $("#opt_rut").hide();
                }
                
            })
            
        </script>
    </div>
</div>