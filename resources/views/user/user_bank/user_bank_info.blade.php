@php
    $bank = '';
    $account_type = '';
    $account_number = '';
    $bank_user = '';
    if(isset($data) && isset($data[0]["banco"])){
        $data = $data[0];
        $bank_user = $data["banco"];
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
                    @if (isset($banks))
                        <option selected value="">Seleccione</option>
                        @foreach ($banks as $bank)
                            <option value="{{$bank['name']}}">{{$bank['name']}}</option>                            
                        @endforeach                        
                    @endif                   
                </select>
                @if ($bank_user != '')
                    <script>
                        $(document).ready(function(){
                            $('#user_bank_opt option[value="{{$bank_user}}"').prop('selected', true);
                            
                        });
                        
                    </script>                    
                @endif
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
            <div class="text-center">
                <button type="submit" class="btn btn-lg btn-success">Guardar</button>
            </div>
        </form>
        <script>
            $("#user_bank_opt").change(function(){
                $('#user_account_type_opt option[value=""').prop('selected', true);
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