<div class="tab-pane fade show active" id="documents" role="tabpanel" aria-labelledby="documents-tab">
    <div class="table-responsive">
        <table class="table " style="text-align: center;" id="lista_staff_documents">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Nombre Completo</th>
                    <th scope="col">Cargo</th>
                    <th scope="col">Ficha</th>
                    <th scope="col">Contrato</th>
                    <th scope="col">Horario</th>
                    <th scope="col">Anexo Reloj</th>
                    <th scope="col">Liquidación Marzo</th>                               
                    <th scope="col">Otros</th>                               
                </tr>
            </thead>
            <tbody>           
                @foreach ($staff as $row)
                    @if ($row["estado"] == 1)
                        <tr>
                            <td>
                                @if ($row["nombres"] != '')
                                    {{$row["nombres"]}} {{$row["apellido_paterno"]}} {{$row["apellido_materno"]}}
                                @else
                                    Nombre sin Completar <br>(Rut: {{$row["rut"]}})
                                @endif
                                
                            </td>
                            <td>
                                @if ($row['isapre'] != '' && $row['numero_cuenta'] != '')
                                    <input type="text" value="{{$row['cargo']}}" style="min-width: 120px;" class="form-control" placeholder="Cargo" id="input_cargo_{{$row['id_staff']}}" >                                                                                      
                                    <script>
                                        $("#input_cargo_{{$row['id_staff']}}").focus(function(){
                                            Toast.fire({
                                                icon: 'info', 
                                                title: 'Para guardar presione enter.'
                                            })
                                        });
                                        $("#input_cargo_{{$row['id_staff']}}").on('keypress', function (e){
                                            var input= $(this).val();
                                            if(e.which == 13) {
                                            //   alert('You pressed enter!');
                                                $("#input_cargo_{{$row['id_staff']}}").removeClass('is-invalid');
                                                $("#input_cargo_{{$row['id_staff']}}").addClass('is-valid');

                                                if(input != ''){
                                                    $.ajax({
                                                        type: "GET",
                                                        url: "staff_add_cargo",
                                                        data:{
                                                            id_staff: "{{$row['id_staff']}}" ,
                                                            cargo:input,                                                                                                                                    
                                                        },
                                                        success: function (data)
                                                        {
                                                            if(data == "UPDATED"){
                                                                Toast.fire({
                                                                    icon: 'success', 
                                                                    title: 'Completado'
                                                                });
                                                            }else{
                                                                $("#input_cargo_{{$row['id_staff']}}").removeClass('is-valid');
                                                                $("#input_cargo_{{$row['id_staff']}}").addClass('is-invalid');
                                                                Toast.fire({
                                                                    icon: 'error', 
                                                                    title: data
                                                                });
                                                            }
                                                        }
                                                    }); 
                                                }
                                            }
                                        });
                                    </script>
                                @else
                                    <span class="badge badge-secondary">No Completado</span>
                                @endif
                            </td>
                            <td>
                                @if ($row['isapre'] != '' && $row['numero_cuenta'] != '')
                                    <button id="btnficha{{$row['id_staff']}}" data="{{json_encode($row)}}" type="button" class="btn btn-primary btn-sm btn-modal-ficha" data-toggle="modal" data-target="#ficha">
                                        Ver Ficha
                                    </button>
                                @else
                                    <span class="badge badge-secondary">No Completado</span>
                                @endif    
                            </td>                             
                            <td>
                                @if (isset($row['contrato']))
                                    @include('admin_views.modal_documents_staff', ['file_Path'=>$row['contrato'], 'tipo_doc'=>"contrato", 'id_user'=> $row['id_staff'], "nombreDoc" => "Contrato" ])
                                @else
                                    @include('admin_views.modal_documents_staff', ['file_Path'=>'', 'tipo_doc'=>"contrato", 'id_user'=> $row['id_staff'], "nombreDoc" => "Contrato" ])
                                @endif
                            </td>
                            <td>
                                @if (isset($row['horario']))
                                    @include('admin_views.modal_documents_staff', ['file_Path'=>$row['horario'], 'tipo_doc'=>"horario", 'id_user'=> $row['id_staff'], "nombreDoc" => "Horario"])
                                @else
                                    @include('admin_views.modal_documents_staff', ['file_Path'=>'', 'tipo_doc'=>"horario", 'id_user'=> $row['id_staff'], "nombreDoc" => "Horario"])
                                @endif
                            </td>                               
                            <td>
                                @if (isset($row['anexo_reloj']))
                                    @include('admin_views.modal_documents_staff', ['file_Path'=>$row['anexo_reloj'], 'tipo_doc'=>"anexo_reloj", 'id_user'=> $row['id_staff'], "nombreDoc" => "Anexo Reloj"])
                                @else                                        
                                    @include('admin_views.modal_documents_staff', ['file_Path'=>'', 'tipo_doc'=>"anexo_reloj", 'id_user'=> $row['id_staff'], "nombreDoc" => "Anexo Reloj"])
                                @endif    
                            </td>                               
                            <td>
                                @if (isset($row['liquidacion_marzo']))                                    
                                    @include('admin_views.modal_documents_staff', ['file_Path'=>$row['liquidacion_marzo'], 'tipo_doc'=>"liquidacion_marzo", 'id_user'=> $row['id_staff'], "nombreDoc" => "Liquidación Marzo"])</td>                                                            
                                @else                                        
                                    @include('admin_views.modal_documents_staff', ['file_Path'=>'', 'tipo_doc'=>"liquidacion_marzo", 'id_user'=> $row['id_staff'], "nombreDoc" => "Liquidación Marzo"])</td>                                                            
                                @endif

                            <td>
                                @include('admin_views.modal_documents_staff', ['file_Path'=>'', "otros"=>"otros", 'tipo_doc'=>"otros", 'id_user'=> $row['id_staff'], "nombreDoc" => "Otros"])
                            </td>                                                            
                            @endif
                        </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>