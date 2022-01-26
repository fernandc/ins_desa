<!DOCTYPE html> 


@extends("layouts.mcdn")
@section("title")
Administrar Usuarios
@endsection

@section("headex")
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
    })
    </script>
@endsection

@section("context")
    <div class="mx-4">
        <h2 style="text-align: center;">Administrar Usuarios</h2>
        <button class="btn btn-success " type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Agregar nuevo usuario</button>
        <div class="collapse mt-2" id="collapseExample">
            <form class="row" action="add_user" method="GET">
                <div class="form-group col-3">
                    <label for="nameAdd">Nombre Completo</label>
                    <input type="text" class="form-control" name="full_name" placeholder="Nombre" required="">
                </div>
                <div class="form-group col-3">
                    <label for="dniAdd">Rut</label>
                    <input type="text" class="form-control" name="dni" placeholder="12.345.678-9" required="">
                </div>
                <div class="form-group col-3">
                    <label for="birth_dateAdd">Fecha de nacimiento</label>
                    <input type="date" class="form-control" name="birth_date" placeholder="" required="">
                </div>
                <div class="form-group col-3">
                    <label for="emailAdd">Correo</label>
                    <input type="email" class="form-control" name="email" placeholder="Correo" required="">
                </div>

                <div class="form-group col-4">
                    <label for="emailAdd" style="color: white;">.</label>
                    <button id="sendform" type="submit" class="form-control btn btn-success">Agregar</button>
                </div>
            </form>
        </div>
        <hr>
        @php
            $documents = false;
            if(isset($_GET['documents'])){
                $documents = true;
            }
        @endphp
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link @if(!$documents) active @endif" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="false">Informacion detallada de Personal</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " id="privileges-tab" data-toggle="tab" href="#privileges" role="tab" aria-controls="privileges" aria-selected="true">Administrar Privilegios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($documents) active @endif " id="documents-tab" data-toggle="tab" href="#documents" role="tab" aria-controls="documents" aria-selected="true">Administrar documentos y cargos de usuarios</a>
            </li>
        </ul>
        <div class="tab-content mt-2" id="myTabContent">
            <div class="tab-pane fade @if(!$documents) show active @endif" id="details" role="tabpanel" aria-labelledby="details-tab">
                <table class="table display responsive nowrap"style="width: 100%;" id="lista_staff_detail">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Rut</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Cargo</th>
                            <th scope="col">Fecha Nacimiento</th>
                            <th scope="col">Sexo</th>
                            <th scope="col">Nacionalidad</th>
                            <th scope="col">Estado Civil</th>
                            <th scope="col">AFP</th>
                            <th scope="col">ISAPRE</th>
                            <th scope="col">Dirección de Domicilio</th>
                            <th scope="col">Celular</th>
                            <th scope="col">Email Institucional</th>
                            <th scope="col">Email Personal</th>
                            <th scope="col">Banco</th>
                            <th scope="col">Tipo Cuenta</th>
                            <th scope="col">Numero de Cuenta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staff as $row)
                            @if ($row["estado"] == 1)
                                <tr>
                                    <td>{{$row["rut"]}}</td>
                                    <td>{{$row["nombre_completo"]}}</td>
                                    <td>{{$row["cargo"]}}</td>
                                    <td>{{$row["fecha_nacimiento"]}}</td>
                                    <td>{{$row["sexo"]}}</td>
                                    <td>{{$row["nacionalidad"]}}</td>
                                    <td>{{$row["estado_civil"]}}</td>
                                    <td>{{$row["afp"]}}</td>
                                    <td>{{$row["isapre"]}}</td>
                                    <td>{{$row["direccion"]}} - {{$row["comuna"]}} - {{$row["ciudad"]}}</td>
                                    <td>{{$row["celular"]}}</td>
                                    <td>{{$row["email_institucional"]}}</td>
                                    <td>{{$row["email_personal"]}}</td>
                                    <td>{{$row["banco"]}}</td>
                                    <td>{{$row["tipo_cuenta"]}}</td>
                                    <td>{{$row["numero_cuenta"]}}</td>
                                </tr> 
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="privileges" role="tabpanel" aria-labelledby="privileges-tab">
                <div class="table-responsive">
                    <table class="table " style="text-align: center;" id="lista_staff">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Rut</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Email Institucional</th>
                                <th scope="col">Administrador</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Privilegios</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staff as $row)
                                <tr>
                                    <td>{{$row["rut"]}}</td>
                                    <td>{{$row["nombre_completo"]}}</td>
                                    <td>{{$row["email_institucional"]}}</td>
                                    <td>
                                        @if($row["administrador"]=="YES")
                                            <a href="change_staff_admin?dni={{$row["rut"]}}" class="btn btn-primary btn-sm text-white" style="width: 45px">Si</a>
                                        @else   
                                            <a href="change_staff_admin?dni={{$row["rut"]}}" class="btn btn-secondary btn-sm text-white" style="width: 45px">No</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($row["estado"] == 1)
                                            <a href="change_staff_status?dni={{$row["rut"]}}" class="btn btn-primary btn-sm">Activado</a>    
                                        @else
                                            <a href="change_staff_status?dni={{$row["rut"]}}" class="btn btn-secondary btn-sm">Desactivado</a>
                                        @endif
                                    </td>
                                    <td><button class="btn btn-outline-primary btn-sm data-priv" data="{{$row["rut"]}}" data-toggle="modal" data-target=".bd-example-modal-xl">Administrar</button></td>
                                </tr>                
                            @endforeach
                        </tbody>
                    </table>
                    <script>
                        $(".data-priv").click(function(){
                            var dni = $(this).attr('data');
                            Swal.fire({
                                icon: 'info',
                                title: 'Cargando',
                                showConfirmButton: false,
                            })
                            $.ajax({
                                type: "GET",
                                url: "modal_privileges",
                                data:{
                                    dni
                                },
                                success: function (data)
                                {
                                    $("#modalContent").html(data);
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Completado'
                                    })
                                }
                            });
                        });
                    </script>
                    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" >
                            <div class="modal-content" id="modalContent">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade @if($documents) show active @endif" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                <div class="table-responsive">
                    <table class="table " style="text-align: center;" id="lista_staff_documents">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Nombre</th>
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
                                        <td>{{$row['nombre_completo']}}</td>
                                        <td>
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
                                        </td>
                                        <td>
                                            @if ($row['isapre'] != '' && $row['numero_cuenta'] != '')
                                                <button id="btnficha{{$row["id_staff"]}}" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ficha{{$row["id_staff"]}}">
                                                    Ver Ficha
                                                </button>
                                              
                                                <!-- Modal -->
                                                <div class="modal fade" id="ficha{{$row["id_staff"]}}" tabindex="-1" role="dialog" aria-labelledby="ficha{{$row["id_staff"]}}Label" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content" id="modalContentFicha"><div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTracingTitle"><fieldset>Ficha de {{$row["nombre_completo"]}}</fieldset></h5>
                                                            <button id="imprimir" class="btn btn-outline-info btn-sm ml-2">Imprimir</button>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                              <span aria-hidden="true">×</span>
                                                            </button>
                                                          </div>
                                                          <div class="modal-body">
                                                            <header style=" padding: 10px 0; margin-bottom: 30px;">
                                                                
                                                              </header>
                                                              <!--
                                                                <div class="float-right" style="width:118px; heigth:139px;">
                                                                    <img src="" alt="Alumno">
                                                                </div>
                                                              -->
                                                              <main id="content" class="border" style="padding: 40px;">
                                                                <div class="float-left" style="width: 80px; heigth:80px;">
                                                                    <img src="data:image/png;base64, <?php echo base64_encode(file_get_contents('https://scc.cloupping.com/public/scc_logo.png')); ?>" alt="" class="img-fluid">
                                                                  </div>
                                                                  <div class="d-flex">
                                                                      <p class="text-secondary" style="font-size:30px; font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; Ficha Funcionario {{Session::get('period')}} </p>
                                                                  </div>
                                                                  <div>
                                                                      <div class="my-3 mt-5">
                                                                          <h3>Datos Personales</h3>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label text-left">Nombre completo</label>
                                                                            <div class="col-sm-8 mb-3">
                                                                                <input type="text" class="form-control bg-white" readonly="" value="{{$row["nombre_completo"]}}">
                                                                            </div>

                                                                            <label class="col-sm-4 col-form-label text-left">Cargo</label>
                                                                            <div class="col-sm-8 mb-3">
                                                                                <input type="text" class="form-control bg-white" readonly="" value="@if($row["cargo"] == "")Sin Cargo @else {{$row["cargo"]}} @endif">
                                                                            </div>

                                                                            <label class="col-sm-4 col-form-label text-left">Rut</label>
                                                                            <div class="col-sm-8 mb-3">
                                                                                <input type="text" class="form-control bg-white" readonly="" value="{{$row["rut"]}}">
                                                                            </div>

                                                                            <label class="col-sm-4 col-form-label text-left">Sexo</label>
                                                                            <div class="col-sm-8 mb-3">
                                                                                <input type="text" class="form-control bg-white" readonly="" value="{{$row["sexo"]}}">
                                                                            </div>
                                                                            
                                                                            <label class="col-sm-4 col-form-label text-left">Fecha Nacimiento</label>
                                                                            <div class="col-sm-8 mb-3">
                                                                                <input type="text" class="form-control bg-white" readonly="" value="{{$row["fecha_nacimiento"]}}">
                                                                            </div>

                                                                            <label class="col-sm-4 col-form-label text-left">Nacionalidad</label>
                                                                            <div class="col-sm-8 mb-3">
                                                                                <input type="text" class="form-control bg-white" readonly="" value="{{$row["nacionalidad"]}}">
                                                                            </div>

                                                                            <label class="col-sm-4 col-form-label text-left">Estado civil</label>
                                                                            <div class="col-sm-8 mb-3">
                                                                                <input type="text" class="form-control bg-white" readonly="" value="{{$row["estado_civil"]}}">
                                                                            </div>

                                                                            <label class="col-sm-4 col-form-label text-left">Cargas Familiares</label>
                                                                            <div class="col-sm-8 mb-3">
                                                                                <input type="text" class="form-control bg-white" readonly="" value="@if($row["certificados_nacimientos"]==0)Sin cargas familiares @else {{$row["certificados_nacimientos"]}} @endif">
                                                                            </div>

                                                                            <label class="col-sm-4 col-form-label text-left">Domicilio</label>
                                                                            <div class="col-sm-8 mb-3">
                                                                                <input type="text" class="form-control bg-white" readonly="" value="{{$row["direccion"]}}">
                                                                            </div>

                                                                            <label class="col-sm-4 col-form-label text-left">Ciudad y Comuna</label>
                                                                            <div class="col-sm-8 mb-3">
                                                                                <input type="text" class="form-control bg-white" readonly="" value="{{$row["ciudad"]}} - {{$row["comuna"]}}">
                                                                            </div>

                                                                            <label class="col-sm-4 col-form-label text-left">Correo</label>
                                                                            <div class="col-sm-8 mb-3">
                                                                                <input type="text" class="form-control bg-white" readonly="" value="{{$row["email_personal"]}}">
                                                                            </div>

                                                                            <label class="col-sm-4 col-form-label text-left">Celular</label>
                                                                            <div class="col-sm-8 mb-3">
                                                                                <input type="text" class="form-control bg-white" readonly="" value="{{$row["celular"]}}">
                                                                            </div>

                                                                            <label class="col-sm-4 col-form-label text-left">AFP</label>
                                                                            <div class="col-sm-8 mb-3">
                                                                                <input type="text" class="form-control bg-white" readonly="" value="{{$row["afp"]}}">
                                                                            </div>

                                                                            <label class="col-sm-4 col-form-label text-left">Isapre</label>
                                                                            <div class="col-sm-8">
                                                                                <input type="text" class="form-control bg-white" readonly="" value="{{$row["isapre"]}}">
                                                                            </div>
                                                                        </div>
                                                                        <div style="page-break-before: always;">
                                                                            <h3>Cta. Cte. o de abono Remuneracion</h3>
                                                                            <div class="form-group row">
                                                                                <label class="col-sm-4 col-form-label text-left">Banco</label>
                                                                                <div class="col-sm-8 mb-3">
                                                                                    <input type="text" class="form-control bg-white" readonly="" value="{{$row["banco"]}}">
                                                                                </div>

                                                                                <label class="col-sm-4 col-form-label text-left">Tipo de cuenta</label>
                                                                                <div class="col-sm-8 mb-3">
                                                                                    <input type="text" class="form-control bg-white" readonly="" value="{{$row["tipo_cuenta"]}}">
                                                                                </div>

                                                                                <label class="col-sm-4 col-form-label text-left">Numero de cuenta</label>
                                                                                <div class="col-sm-8 mb-3">
                                                                                    <input type="text" class="form-control bg-white" readonly="" value="{{$row["numero_cuenta"]}}">
                                                                                </div>
                                                                            </div>
                                                                            <h3>Post Grados / Post Titulos</h3>
                                                                            <div id="degrees{{$row["id_staff"]}}">

                                                                            </div>
                                                                            <div style="margin: 100px 40px 0px 40px;">
                                                                                <div style="text-align: left" class="float-left">
                                                                                    <p>________________________________</p>
                                                                                    <p class="text-center" style="font-weight:bold">Firma</p>
                                                                                </div>
                                                                                <div style="text-align: right">
                                                                                    <p class="text-white">_</p>
                                                                                    @php
                                                                                    setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish');
                                                                                    @endphp
                                                                                    <p style="font-weight:bold">
                                                                                        {{ucfirst(iconv('ISO-8859-2', 'UTF-8', strftime("%A, %d  ", strtotime(date("Y-m-d")))))}}
                                                                                        de
                                                                                        {{ucfirst(iconv('ISO-8859-2', 'UTF-8', strftime("%B ", strtotime(date("Y-m-d")))))}}
                                                                                        de
                                                                                        {{iconv('ISO-8859-2', 'UTF-8', strftime("%Y", strtotime(date("Y-m-d"))))}}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                      </div>
                                                                  </div>
                                                              </main>
                                                          </div>
                                                          <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                          </div>
                                                          <script>
                                                            $('#imprimir').click(function() {
                                                              var element = document.getElementById('content');
                                                              var opt = {
                                                                margin:       0.5,
                                                                filename:     'Ficha {{$row["nombre_completo"]}}.pdf',
                                                                image:        { type: 'jpg', quality: 0.98 },
                                                                html2canvas:  { scale: 2 },
                                                                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
                                                              };
                                                              html2pdf().set(opt).from(element).save();
                                                              //html2pdf(element);
                                                            });
                                                          </script></div>
                                                    </div>
                                                </div>
                                                <script>
                                                    $("#btnficha{{$row["id_staff"]}}").click(function(){
                                                        var dni = "{{$row["rut"]}}";
                                                        Swal.fire({
                                                            icon: 'info',
                                                            title: 'Cargando',
                                                            showConfirmButton: false,
                                                        })
                                                        $.ajax({
                                                            type: "GET",
                                                            url: "get_user_formation",
                                                            data:{
                                                                dni
                                                            },
                                                            success: function (data)
                                                            {
                                                                var htmldata = ``;
                                                                data.forEach(function (obj) {
                                                                    var degreearea = ``;
                                                                    var degreespeciality = ``;
                                                                    var mentions = ``;
                                                                    if(obj.mentions != ''){
                                                                        mentions = `<span style="font-weight: 500;font-size: larger;">Menciones:</span>`;
                                                                        var array = obj.mentions.split(",");
                                                                        for (i = 0; i < array.length; i++) {
                                                                            mentions = mentions + `<span class="badge badge-light">Mención ` +  array[i] + `</span>`;
                                                                        }
                                                                    }
                                                                    if(obj.degree_area != ''){
                                                                        degreearea = `<span class="badge badge-info" style="font-weight: 400 !important;font-size: small;">`+obj.degree_area+`</span>`;
                                                                    }
                                                                    if(obj.specialty){
                                                                        degreespeciality = `<p class="card-text" style="font-size: large;"><span style="font-weight: 500;">Especialidad: </span>`+obj.specialty+`</p>`
                                                                    }
                                                                    htmldata = htmldata + `<div class="card" style="text-align: left;">
                                                                                        <div class="card-body">
                                                                                            <div class="row">
                                                                                                <div class="col-md-6">
                                                                                                    <h6 class="card-subtitle mb-2 text-muted">`+obj.degree+`</h6>
                                                                                                    <h5 class="card-title">
                                                                                                        Tipo de titulo: <span class="text-primary">`+obj.degree_type+`</span>
                                                                                                        <br> 
                                                                                                        `+ degreearea+`
                                                                                                    </h5>
                                                                                                    `+degreespeciality+`
                                                                                                    `+mentions+`
                                                                                                </div>
                                                                                                <div class="col-md-6">
                                                                                                    <p class="card-text mt-3" style="font-size: large;"><span style="font-weight: 500;">Duración de la carrera: </span> `+obj.semester+` Semestres</p>
                                                                                                    <p class="card-text " style="font-size: large;"><span style="font-weight: 500;">Año de titulación: </span> `+obj.degree_year+`</p>
                                                                                                    <p class="card-text " style="font-size: large;"><span style="font-weight: 500;">Modalidad de estudio: </span> `+obj.modality+`</p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <hr>`

                                                                });
                                                                $("#degrees{{$row["id_staff"]}}").html(htmldata);
                                                                Toast.fire({
                                                                    icon: 'success',
                                                                    title: 'Completado'
                                                                });
                                                            }
                                                        });
                                                    });
                                                </script>
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
        </div>


        <br>
        
        <script>
            $(document).ready( function () {
                $('#lista_staff').DataTable({
                    order: [3, "desc" ],
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Filas",
                        "infoEmpty": "Mostrando 0 to 0 of 0 Filas",
                        "infoFiltered": "(Filtrado de MAX total Filas)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Filas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                            }
                    },
                });
                $('#lista_staff_detail').DataTable({
                    dom: 'Blfrtip',
                    lengthMenu: [
                        [ 10, 25, 50, -1 ],
                        [ '10', '25', '50', 'Todas las' ]
                    ],
                    buttons: {
                        buttons: [
                            { extend: 'csv', className: 'btn-info mb-2', text: "Descargar CSV" },
                            { extend: 'excel', className: 'bg-primary mb-2', text: "Descargar Excel (xlsx)" }
                        ]
                    },
                    order: [3, "desc" ],
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Filas",
                        "infoEmpty": "Mostrando 0 to 0 of 0 Filas",
                        "infoFiltered": "(Filtrado de MAX total Filas)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Filas",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "search": "Buscar:",
                        "zeroRecords": "Sin resultados encontrados",
                        "paginate": {
                            "first": "Primero",
                            "last": "Ultimo",
                            "next": "Siguiente",
                            "previous": "Anterior"
                            }
                    },
                });
                $('#lista_staff_documents').DataTable({

                });
            } );
        </script>
    </div>
@endsection