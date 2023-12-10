<!DOCTYPE html> 


@extends("layouts.mcdn")
@section("title")
Admin Cursos
@endsection

@section("headex")
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
</script>
@endsection

@section("context")

<div class="mx-2">
    <h2 style="text-align: center;" id="temp1">Alumnos
        @if(Session::has('period'))
            {{Session::get('period')}}
        @endif
    </h2>
    @if(isset($message))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{$message}}',
                })
        </script>
    @endif
    <hr>
    @if ($has_priv)
    <ul class="nav nav-tabs my-3 justify-content-center">
        <li class="nav-item">
            <a class="nav-link" data="0" href="students">Todos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="1" href="students?curso=1">PK</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="2" href="students?curso=2">KI</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="3" href="students?curso=3">1B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="4" href="students?curso=4">2B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="5" href="students?curso=5">3B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="6" href="students?curso=6">4B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="7" href="students?curso=7">5B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="8" href="students?curso=8">6B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="9" href="students?curso=9">7B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="10" href="students?curso=10">8B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="11" href="students?curso=11">1M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="12" href="students?curso=12">2M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="13" href="students?curso=13">3M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="14" href="students?curso=14">4M</a>
        </li>
        @php
            $active = 0;
        @endphp
        @if(isset($_GET['curso']))
            @php
               $active = $_GET['curso'];
            @endphp
        @endif
        <script>
            $(document).ready(function(){
                $("[data={{$active}}]").addClass("active");
            });
        </script>
    </ul>
    @endif
    <hr>
    <div class="table-responsive">
        <table class="table table-sm" style="text-align: center;" id="list_students">
            <thead class="thead-light">
                <tr>
                    <th scope="col"># Matricula</th>
                    <th scope="col">Rut</th>
                    <th scope="col">Nombre Completo</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Etiquetas</th>
                    <th scope="col">Celular</th>
                    @if($gen_cert)
                        <th scope="col">
                            Cert. Alumno regular
                        </th>
                    @endif
                    <th scope="col">Apoderado</th>
                    <th scope="col">Ficha del Alumno</th>
                    @if($gen_contrato)
                        <th scope="col">
                            Generar Contrato
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($students as $row)
                    <tr>
                        <td>
                            @if ($row["numero_matricula"] == 0)
                                <span class="text-danger">Sin # Matricula</span>
                            @else
                                <span class="text-primary">{{$row["numero_matricula"]}}</span>
                            @endif
                        </td>
                        <td>{{$row["dni_stu"]}} </td>
                        <td>{{$row["nombre_stu"]}} </td>
                        <td>{{$row["curso"]}}</td>
                        <td>
                            @if ($row["es_nuevo"] == "si")
                                <span class="badge badge-primary"  data-toggle="tooltip" data-placement="top" title="Nuevo">N</span>
                            @endif
                            @if ($row["es_repitente"] == "si")
                                <span class="badge badge-danger"  data-toggle="tooltip" data-placement="top" title="Repitiente">R</span>
                            @endif
                            @if ($row["fecha_retiro"] != null)
                                <span class="badge badge-warning"  data-toggle="tooltip" data-placement="top" title="Retirado: {{$row["fecha_retiro"]}}">R</span>
                            @endif
                            @if($row["es_reincorporado"] == "si")
                                <span class="badge badge-success"  data-toggle="tooltip" data-placement="top" title="Reincorporado">R</span>
                            @endif
                        </td>
                        <td>{{$row["cellphone_stu"]}} </td>
                        @if($gen_cert)
                            <td>
                                <a class="btn btn-outline-success btn-sm" href="https://saintcharlescollege.cl/ins/generatePDF?data={{$row["hash"]}}" target="_blank">Generar Certificado</a>
                            </td>
                        @endif
                        <td><button class="btn btn-outline-secondary btn-sm data-apo" data="{{$row["dni_stu"]}}" data-toggle="modal" data-target=".bd-example-modal-xl">Ver Apoderado</button></td>
                        <td><button class="btn btn-outline-primary btn-sm data-ficha" data="{{$row["id_stu"]}}" data2="{{$row["id_zmail"]}}" data-toggle="modal" data-target="#ficha">Ver Ficha de Alumno</button></td>
                        @if($gen_contrato)
                            <td>
                                <button class="btn btn-outline-primary btn-sm data-contrato" data="{{$row["id_stu"]}}" data2="{{$row["id_zmail"]}}" data-toggle="modal" data-target="#ficha">Generar Contrato</button>
                            </td>
                        @endif
                    </tr>             
                @endforeach                      
            </tbody>
        </table>
        @if(isset($_GET['curso']))
            <div class="text-center">
                <button id="generar-contratos" class="btn btn-outline-light">
                    Generar todos los contratos
                    <br>
                    Solo primera hoja 
                    <br>
                    (Puede tardar en generar)
                </button>
            </div>
        @endif
    </div>
    <div id="contratos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" >
            <div class="modal-content" id="modalContentContratos">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <Fieldset>Contratos</Fieldset>
                    </h5>
                    <button id="imprimirContratos" class="btn btn-outline-info btn-sm ml-2">Imprimir Contratos</button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div id="contentContratos" style="font-size:0.9rem;">
                            <div class="border px-5 py-2 item-page" style="page-break-before: always;">
                                <div class="text-center">
                                    <img src="data:image/png;base64, <?php echo base64_encode(file_get_contents(getenv("API_ENDPOINT").'public/scc_logo.png')); ?>" alt="Logo" style="max-height: 120px;">
                                </div>
                                <div class="row" style="line-height: 1.2;">
                                    <div class="col-md-12">
                                        <div class="text-center mt-2">
                                            <b class="fs-4" style="font-size: 14px;">CONTRATO DE PRESTACIÓN DE SERVICIOS EDUCACIONALES</b>
                                        </div>
                                        <div class="mt-3">
                                            En Santiago, con fecha _________de ____________________del 20___, entre
                                            <b>Corporación Educacional Saint Charles College</b>, R.U.N 65.093.233-1 RBD 25382-0, con
                                            domicilio en la ciudad
                                            de Santiago, calle Pedro Donoso N° 8741/8743 (ambas numeraciones) comuna de La Florida,
                                            representada por <b>Nina Borisova Kresteva</b>, cédula de identidad 14.656.819-k por una parte y
                                            por la
                                            otra parte el apoderado(a),en adelante “el contratante” y el apoderado:
                                        </div>
                                        <!-- display: flex (sirve para dejar la linea continua-->
                                        <!-- display: block (sirve para dejar la linea como bloque-->
                            
                                        <div style="display: flex;" class="mt-3">
                                            <span class="border-bottom border-dark" style="display: block; width: 400px;">
                                                <b id="nombre-apo">&nbsp;@P1</b>
                                            </span>
                                            R.U.N:
                                            <span class="border-bottom border-dark" style="display: block; width: 200px;">
                                                <b id="rut-apo">&nbsp;@P2</b>
                                            </span>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <span>
                                                Domiciliado en
                                            </span>
                                            <span id="direccion-apo" class="border-bottom border-dark" style="display: inline-block; width: 520px">
                                                <b>&nbsp;@P3</b>
                                            </span>
                                        </div>
                                        
                                        <div style="display: flex;" class="mt-3">
                                            <span>
                                                Villa:
                                            </span>
                                            <span id="villa-apo" class="border-bottom border-dark" style="display: inline-block; width: 280px"></span>
                                            Comuna:
                                            <span class="border-bottom border-dark" style="display: block; width: 255px;">
                                                <b id="comuna-apo">&nbsp;@P4</b>
                                            </span>
                                        </div>
                            
                                        <div class="mt-3">
                                            <span>
                                                Teléfono N°:
                                            </span>
                                            <span id="telefono-apo" class="border-bottom border-dark" style="display: inline-block; width: 230px">
                                                <b> &nbsp;@P5 </b>
                                            </span>
                                            <span>
                                                de su mismo domicilio y/o personal, se ha convenido el
                                                siguiente contrato de prestación de servicios educacionales.
                                            </span>
                                        </div>
                                        <div class="mt-3">
                                            <span><b>Primero:</b> A solicitud del contratante el colegio acepta al alumno(a):</span>
                                        </div>
                                        <div class="mt-3">
                                            <span id="nombre-alumno" class="border-bottom border-dark" style="display: inline-block; width: 620px">
                                                <b>&nbsp;@P6</b>
                                            </span>
                                            Para el curso
                                            <span id="curso-alumno" class="border-bottom border-dark" style="display: inline-block; width: 230px">
                                                <b>&nbsp;@P7</b>
                                            </span>
                                            con jornada escolar completa.
                                        </div>
                            
                                        <div class="mt-3">
                                            <b>Segundo:</b> El alumno(a) nuevo al matricularse debe entregar la documentación requerida por el
                                            colegio (certificado de notas, informe de personalidad, certificado de nacimiento y otros antecedentes
                                            relevantes que pueda solicitar el colegio).
                                        </div>
                            
                                        <div class="mt-3">
                                            <b>
                                                Tercero: La Ley de Inclusión 20.845, expresa que, los padres, madres y apoderados, antes de
                                                matricular a sus hijos(as), se deben informar del Proyecto Educativo del colegio, de tal forma
                                                que elijan libremente el establecimiento en el cual desean educar a sus hijos(as).
                                                Las familias deben buscar Proyectos Educativos acordes a sus valores y visiones,
                                                adhiriéndose al Proyecto Educativo del establecimiento que están aceptando, debiendo
                                                respetar lo estipulado en el Reglamento Interno. Una vez elegido el Establecimiento
                                                Educacional, los apoderados se comprometen conjuntamente con sus hijos a cuidar, respetar,
                                                apoyar y cumplir los reglamentos del colegio y de su Proyecto Educativo.
                                            </b>
                                        </div>
                            
                                        <div class="mt-3">
                                            <b>Cuarto: </b>Las actividades, asignaturas o disciplinas que imparta el colegio durante el año escolar, son
                                            aquellas que corresponden al estudio respectivo, aprobado por el Ministerio de Educación. El
                                            apoderado acepta que el colegio no imparte la asignatura de Religión, sino Ética y Desarrollo con
                                            planes propios aprobados por MINEDUC.
                                            El colegio, previo cumplimiento a la reglamentación ministerial vigente podrá modificar los planes de
                                            estudio y reglamentos que actualmente rigen, para adaptarlos a las necesidades y requerimientos de
                                            la enseñanza que imparte.
                                        </div>
                                        <div class="mt-2">
                                            <b style="background-color: yellow;">
                                                Actividades de carácter obligatorio, dentro del margen académico que se realizarán los
                                                días sábados
                                            </b>
                                        </div>
                                        <div class="mt-2">
                                            <ul style="color: darkblue;">
                                                <li>
                                                    <b>Evento "Fiesta de la Chilenidad" (18 de Septiembre)</b>
                                                </li>
                                                <li>
                                                    <b>Evento "Día de la Raza"</b>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#generar-contratos").click(function(){
            const students = [
                @foreach($students as $row)
                    {
                        id_stu: "{{$row["id_stu"]}}",
                        id_apo: "{{$row["id_zmail"]}}",
                    },
                @endforeach
            ];
            const year = "@if(Session::has('period')){{Session::get('period')}}@endif";
            const cantidad = students.length;
            // consultar si desea continuar a generar X contratos por Swal
            Swal.fire({
                title: 'Generar Contratos',
                text: "¿Desea generar los " + cantidad + " contratos de todos los alumnos?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Generando',
                        html: 'Generando <span id="contador">0</span> de ' + cantidad + ' contratos',
                        showConfirmButton: false,
                    })
                    var contador = 0;
                    const itemPage = $("#contentContratos").html();
                    $("#contentContratos").html("");
                    students.forEach(function(element){
                        $.ajax({
                            type: "GET",
                            url: "modal_contrato",
                            data:{
                                id_stu: element.id_stu,
                                id_apo: element.id_apo,
                                year: year,
                                only_first: true
                            },
                            success: function (data)
                            {
                                contador++;
                                $("#contador").html(contador);
                                let newPage = itemPage;
                                if(contador == 1){
                                    newPage = newPage.replace("page-break-before: always;", "");
                                }
                                newPage = newPage.replace("@P1", data.proxy.names + " " + data.proxy.last_f + " " + data.proxy.last_m);
                                newPage = newPage.replace("@P2", data.proxy.dni.substr(0,data.proxy.dni.length-1) + "-" + data.proxy.dni.substr(-1));
                                newPage = newPage.replace("@P3", data.proxy.address);
                                newPage = newPage.replace("@P4", data.proxy.district);
                                newPage = newPage.replace("@P5", data.proxy.phone + " / " + data.proxy.cellphone);
                                newPage = newPage.replace("@P6", data.student.names + " " + data.student.last_f + " " + data.student.last_m);
                                newPage = newPage.replace("@P7", data.inscription.curso);
                                $("#contentContratos").append(newPage);
                                if(contador == cantidad){
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Completado'
                                    })
                                    $("#contratos").modal("show");
                                }
                            }
                        });
                    });
                    $('#imprimirContratos').click(function () {
                        Swal.fire({
                            icon: 'info',
                            title: 'Generando PDF',
                            showConfirmButton: false,
                        });
                        var element = document.getElementById('contentContratos');
                        var opt = {
                            margin: 0.5,
                            filename: 'Contratos.pdf',
                            image: { type: 'jpg', quality: 0.98 },
                            html2canvas: { scale: 1 },
                            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
                            pagebreak: { after: '.item-page' }
                        };
                        html2pdf().set(opt).from(element).save();
                        Swal.fire({
                            icon: 'success',
                            title: 'Completado'
                        });
                        //html2pdf(element);
                    });
                }
            })
        })
        $(".data-apo").click(function(){
            var dni = $(this).attr('data');
            var year = "@if(Session::has('period')){{Session::get('period')}}@endif";
            Swal.fire({
                icon: 'info',
                title: 'Cargando',
                showConfirmButton: false,
            })
            $.ajax({
                type: "GET",
                url: "modal_apoderados",
                data:{
                    dni,
                    year
                },
                success: function (data)
                {
                    if(data == "" || data == null){
                        Swal.fire({
                            icon: 'info',
                            title: 'Apoderado No Completado'
                        });
                    }else{
                        $("#modalContent").html(data);
                        Toast.fire({
                            icon: 'success',
                            title: 'Completado'
                        })
                    }
                    
                }
            });
        });
        $(".data-ficha").click(function(){
            var id_stu = $(this).attr('data');
            var id_apo = $(this).attr('data2');
            var year = "@if(Session::has('period')){{Session::get('period')}}@endif";
            Swal.fire({
                icon: 'info',
                title: 'Cargando',
                showConfirmButton: false,
            })
            $.ajax({
                type: "GET",
                url: "modal_ficha",
                data:{
                    id_stu,id_apo,year
                },
                success: function (data)
                {
                    $("#modalContentFicha").html(data);
                    Toast.fire({
                        icon: 'success',
                        title: 'Completado'
                    })
                }
            });
        });
        $(".data-contrato").click(function(){
            var id_stu = $(this).attr('data');
            var id_apo = $(this).attr('data2');
            var year = "@if(Session::has('period')){{Session::get('period')}}@endif";
            Swal.fire({
                icon: 'info',
                title: 'Cargando',
                showConfirmButton: false,
            })
            $.ajax({
                type: "GET",
                url: "modal_contrato",
                data:{
                    id_stu,id_apo,year
                },
                success: function (data)
                {
                    $("#modalContentFicha").html(data);
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
    <div id="ficha" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" >
            <div class="modal-content" id="modalContentFicha">
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready( function () {
            $('#list_students').DataTable({
                    "ordering": true,
                    "order": [],
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
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
                    }
                });
        });
    </script>
</div>
@endsection