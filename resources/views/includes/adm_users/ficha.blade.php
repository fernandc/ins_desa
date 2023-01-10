<!-- Modal -->
<div class="modal fade" id="ficha" tabindex="-1" role="dialog" aria-labelledby="fichaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modalContentFicha"><div class="modal-header">
            <h5 class="modal-title"><fieldset>Ficha de <span id="fichaFullNname"></span></fieldset></h5>
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
                    <img src="data:image/png;base64, <?php echo base64_encode(file_get_contents(getenv("API_ENDPOINT").'public/scc_logo.png')); ?>" alt="" class="img-fluid">
                </div>
                <div class="">
                    <p class="text-secondary" style="font-size:30px; font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; Funcionario {{Session::get('period')}} </p>
                    <p class="text-info" style="font-size:30px; font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; <span id="fichaNombreCompleto"></span> </p>
                </div>
                <div>
                    <div class="my-3 mt-5">
                        <h3>Datos Personales</h3>
                        <div class="form-group row">

                            <label class="col-sm-4 col-form-label text-left">Cargo</label>
                            <div class="col-sm-8 mb-3">
                                <input id="fichaCargo" type="text" class="form-control bg-white" readonly="" value="">
                            </div>

                            <label class="col-sm-4 col-form-label text-left">Rut</label>
                            <div class="col-sm-8 mb-3">
                                <input id="fichaRut" type="text" class="form-control bg-white" readonly="" value="">
                            </div>

                            <label class="col-sm-4 col-form-label text-left">Sexo</label>
                            <div class="col-sm-8 mb-3">
                                <input id="fichaSexo" type="text" class="form-control bg-white" readonly="" value="">
                            </div>
                            
                            <label class="col-sm-4 col-form-label text-left">Fecha Nacimiento</label>
                            <div class="col-sm-8 mb-3">
                                <input id="fichaFechaNacimiento" type="text" class="form-control bg-white" readonly="" value="">
                            </div>

                            <label class="col-sm-4 col-form-label text-left">Nacionalidad</label>
                            <div class="col-sm-8 mb-3">
                                <input id="fichaNacionalidad" type="text" class="form-control bg-white" readonly="" value="">
                            </div>

                            <label class="col-sm-4 col-form-label text-left">Estado civil</label>
                            <div class="col-sm-8 mb-3">
                                <input id="fichaEstadoCivil" type="text" class="form-control bg-white" readonly="" value="">
                            </div>

                            <label class="col-sm-4 col-form-label text-left">Cargas Familiares</label>
                            <div class="col-sm-8 mb-3">
                                <input id="fichaCertificadosNacimientos" type="text" class="form-control bg-white" readonly="" value="">
                            </div>

                            <label class="col-sm-4 col-form-label text-left">Domicilio</label>
                            <div class="col-sm-8 mb-3">
                                <input id="fichaDireccion" type="text" class="form-control bg-white" readonly="" value="">
                            </div>

                            <label class="col-sm-4 col-form-label text-left">Ciudad y Comuna</label>
                            <div class="col-sm-8 mb-3">
                                <input id="fichaCiudadComuna" type="text" class="form-control bg-white" readonly="" value="">
                            </div>

                            <label class="col-sm-4 col-form-label text-left">Correo</label>
                            <div class="col-sm-8 mb-3">
                                <input id="fichaEmailPersonal" type="text" class="form-control bg-white" readonly="" value="">
                            </div>

                            <label class="col-sm-4 col-form-label text-left">Celular</label>
                            <div class="col-sm-8 mb-3">
                                <input id="fichaCelular" type="text" class="form-control bg-white" readonly="" value="">
                            </div>

                            <label class="col-sm-4 col-form-label text-left">AFP</label>
                            <div class="col-sm-8 mb-3">
                                <input id="fichaAfp" type="text" class="form-control bg-white" readonly="" value="">
                            </div>

                            <label class="col-sm-4 col-form-label text-left">Isapre</label>
                            <div class="col-sm-8">
                                <input id="fichaIsapre" type="text" class="form-control bg-white" readonly="" value="">
                            </div>
                        </div>
                        <div style="page-break-before: always;">
                            <h3>Cta. Cte. o de abono Remuneracion</h3>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-left">Banco</label>
                                <div class="col-sm-8 mb-3">
                                    <input id="fichaBanco" type="text" class="form-control bg-white" readonly="" value="">
                                </div>

                                <label class="col-sm-4 col-form-label text-left">Tipo de cuenta</label>
                                <div class="col-sm-8 mb-3">
                                    <input id="fichaTipoCuenta" type="text" class="form-control bg-white" readonly="" value="">
                                </div>

                                <label class="col-sm-4 col-form-label text-left">Numero de cuenta</label>
                                <div class="col-sm-8 mb-3">
                                    <input id="fichaNumeroCuenta" type="text" class="form-control bg-white" readonly="" value="">
                                </div>
                            </div>
                            <h3>Post Grados / Post Titulos</h3>
                            <div id="degrees">

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
                Swal.fire({
                    title: 'Generando PDF...',
                    timer: 2000,
                    showConfirmButton: false,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                })
            var element = document.getElementById('content');
            var opt = {
                margin:       0.5,
                filename:     'Ficha ' + $("#fichaNombreCompleto").html() + '.pdf',
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
    $(".btn-modal-ficha").click(function(){
        var json = $(this).attr("data");
        var object = JSON.parse(json);
        var dni = object.rut;
        //SETDATA
        $("#fichaNombreCompleto").html(object.nombres + " " + object.apellido_paterno + " " + object.apellido_materno);
        var cargo = object.cargo == null ? "Sin Cargo" : object.cargo;
        $("#fichaCargo").val(cargo);
        $("#fichaRut").val(object.rut);
        $("#fichaSexo").val(object.sexo);
        $("#fichaFechaNacimiento").val(object.fecha_nacimiento);
        $("#fichaNacionalidad").val(object.nacionalidad);
        $("#fichaEstadoCivil").val(object.estado_civil);
        var certificadosNacimientos = object.certificados_nacimientos == "" ? "Sin Certificados" : object.certificados_nacimientos;
        $("#fichaCertificadosNacimientos").val(certificadosNacimientos);
        $("#fichaDireccion").val(object.direccion);
        $("#fichaCiudadComuna").val(object.ciudad + " - " + object.comuna);
        $("#fichaEmailPersonal").val(object.email_personal);
        $("#fichaCelular").val(object.celular);
        $("#fichaAfp").val(object.afp);
        $("#fichaIsapre").val(object.isapre);
        $("#fichaBanco").val(object.banco);
        $("#fichaTipoCuenta").val(object.tipo_cuenta);
        $("#fichaNumeroCuenta").val(object.numero_cuenta);
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
                        degreearea = `<span style="font-weight: 400;">Area: </span><span class="badge badge-info" style="font-weight: 400 !important;font-size: small;">`+obj.degree_area+`</span>`;
                    }
                    if(obj.specialty){
                        degreespeciality = `<p class="card-text" style="font-size: large;"><span style="font-weight: 500;">Especialidad: </span>`+obj.specialty+`</p>`
                    }
                    htmldata = htmldata + `<div class="card" style="text-align: left;">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6 class="card-subtitle mb-2 text-muted">`+obj.degree+`</h6>
                                                    <h5 class="card-title mt-3">
                                                        Tipo de titulo: 
                                                        <br>
                                                        <span class="text-primary">`+obj.degree_type+`</span>
                                                        <br>
                                                        `+ degreearea+`
                                                    </h5>
                                                    `+degreespeciality+`
                                                    `+mentions+`
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="card-text mt-4" style="font-size: large;"><span style="font-weight: 500;">Duración de la carrera: </span> `+obj.semester+` Semestres</p>
                                                    <p class="card-text " style="font-size: large;"><span style="font-weight: 500;">Año de titulación: </span> `+obj.degree_year+`</p>
                                                    <p class="card-text " style="font-size: large;"><span style="font-weight: 500;">Modalidad de estudio: </span> `+obj.modality+`</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>`
                });
                $("#degrees").html(htmldata);
                Toast.fire({
                    icon: 'success',
                    title: 'Completado'
                });
            }
        });
    });
</script>