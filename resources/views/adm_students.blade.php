<!DOCTYPE html> 


@extends("layouts.mcdn")
@section("title")
Admin Cursos
@endsection

@section("headex")
<style>
    .sw-danger:focus~.custom-control-label::before {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 47, 69, 0.25) !important;
    }

    .sw-danger:checked~.custom-control-label::before {
        border-color: #dc3545 !important;
        background-color: #dc3545 !important;
    }

    .sw-danger:active~.custom-control-label::before {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
    }

    .sw-danger:focus:not(:checked)~.custom-control-label::before {
        border-color: #dc3545 !important;
    }

    .sw-danger:not(:disabled):active~.custom-control-label::before {
        background-color: #dc3545 !important;
        border-color: #dc3545 !important;
    }
    .sw-success:focus~.custom-control-label::before {
        border-color: #28a745 !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 47, 69, 0.25) !important;
    }

    .sw-success:checked~.custom-control-label::before {
        border-color: #28a745 !important;
        background-color: #28a745 !important;
    }

    .sw-success:active~.custom-control-label::before {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
    }

    .sw-success:focus:not(:checked)~.custom-control-label::before {
        border-color: #28a745 !important;
    }
    .sw-success:not(:disabled):active~.custom-control-label::before {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
    }
    .sw-warning:focus~.custom-control-label::before {
        border-color: #ffc107 !important;
        box-shadow: 0 0 0 0.2rem rgba(255, 47, 69, 0.25) !important;
    }

    .sw-warning:checked~.custom-control-label::before {
        border-color: #ffc107 !important;
        background-color: #ffc107 !important;
    }

    .sw-warning:active~.custom-control-label::before {
        background-color: #ffc107 !important;
        border-color: #ffc107 !important;
    }

    .sw-warning:focus:not(:checked)~.custom-control-label::before {
        border-color: #ffc107 !important;
    }

    .sw-warning:not(:disabled):active~.custom-control-label::before {
        background-color: #ffc107 !important;
        border-color: #ffc107 !important;
    }
</style>
<script>
    function isValidDate(dateString) {
        var regEx = /^\d{4}-\d{2}-\d{2}$/;
        if(!dateString.match(regEx)) return false;  // Invalid format
        var d = new Date(dateString);
        var dNum = d.getTime();
        if(!dNum && dNum !== 0) return false; // NaN value, Invalid date
        return d.toISOString().slice(0,10) === dateString;
    }
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
    });

</script>
@endsection

@section("context")
<script>
        Swal.fire({
        title: 'Cargando',
        text: 'Espere un momento',
        onBeforeOpen: () => {
            Swal.showLoading()
        }
    })
</script>
<div class="mx-2">
    <h2 style="text-align: center;" id="temp1">Administrar Estudiantes 
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
            });
        </script>
    @endif
    <hr>
    <ul class="nav nav-tabs my-3 justify-content-center">
        <li class="nav-item">
            <a class="nav-link" data="0" href="adm_students">Todos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="1" href="adm_students?curso=1">PK</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="2" href="adm_students?curso=2">KI</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="3" href="adm_students?curso=3">1B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="4" href="adm_students?curso=4">2B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="5" href="adm_students?curso=5">3B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="6" href="adm_students?curso=6">4B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="7" href="adm_students?curso=7">5B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="8" href="adm_students?curso=8">6B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="9" href="adm_students?curso=9">7B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="10" href="adm_students?curso=10">8B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="11" href="adm_students?curso=11">1M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="12" href="adm_students?curso=12">2M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="13" href="adm_students?curso=13">3M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="14" href="adm_students?curso=14">4M</a>
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
    <div class="table-responsive">
        <table class="table table-sm" style="text-align: center;" id="list_students">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Rut</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Sección</th>
                    <th scope="col"># Matrícula</th>
                    <th scope="col">Centro de Padres</th>
                    <th scope="col">Matriculado</th>
                    <th scope="col">Repitiente</th>
                    <th scope="col">Nuevo</th>
                    <th scope="col">Reincorporado</th>
                    <th scope="col">Fecha de Retiro</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $row)
                    @php
                        $flag = false;
                        $list_section = array();
                    @endphp
                    @foreach ($grades as $row2)
                        @if ($row["id_curso"] == $row2["id_curso"])
                            @php
                                array_push($list_section,$row2["seccion"]);
                                $flag = true;
                            @endphp
                        @endif
                    @endforeach
                    <tr>
                        <td>{{$row["nombre_stu"]}} </td>
                        <td>{{$row["dni_stu"]}}</td>
                        <td>@if($flag) <span class="text-success">{{$row["curso"]}}</span> @else <span class="text-danger">{{$row["curso"]}}</span> @endif </td>                        
                        <td>
                            @php
                                $selec_en = 'disabled=""';
                            @endphp
                            @if($row["matricula"] == "si")
                                @php
                                    $selec_en = "";
                                @endphp
                            @endif
                            <select {{$selec_en}} value="{{$row["seccion"]}}" class="form-control" id="selectSection{{$row["id_stu"]}}" name="selectSection">
                                @foreach ($list_section as $item)
                                    <option value="{{$item}}">{{$item}}</option>
                                @endforeach
                            </select>                     
                            <script>
                                $(document).ready(function(){
                                    $("#selectSection{{$row["id_stu"]}} [value={{$row["seccion"]}}]").prop('selected',true);
                                });
                                $("#selectSection{{$row["id_stu"]}}").change(function (){
                                    var val_sel = $(this).val();
                                    $.ajax({
                                        type: "GET",
                                        url: "change_student_section",
                                        data:{
                                            id_stu: '{{$row["id_stu"]}}',
                                            id_curso: '{{$row["id_curso"]}}',
                                            id_matricula:'{{$row["id_matricula"]}}',                                           
                                            section: val_sel
                                        },
                                        success: function (data)
                                        {
                                            //$("#temp1").html(data);
                                        }
                                    });
                                    Toast.fire({
                                        icon: 'success', 
                                        title: 'Completado'
                                    })
                                });
                            </script>
                        </td>
                        <td>
                            <span style="display: none;">{{$row["numero_matricula"]}}</span>
                            <input class="form-control" type="number" min="0" max="999" value="{{$row["numero_matricula"]}}" id="inputNM{{$row["id_stu"]}}" required="">
                            <script>
                                // $(document).ready(function(){
                                //     $("#selectSection{{$row["id_stu"]}} [value={{$row["seccion"]}}]").prop('selected',true);
                                // });
                                $("#inputNM{{$row["id_stu"]}}").focus(function(){
                                    Toast.fire({
                                        icon: 'info', 
                                        title: 'Para guardar presione enter.'
                                    })
                                });
                                $("#inputNM{{$row["id_stu"]}}").on('keypress', function (e){
                                    var input= $(this).val();
                                   // alert('many');
                                    
                                    if(e.which == 13) {
                                     //   alert('You pressed enter!');
                                        if(input > 0 && input < 999){
                                            $("#inputNM{{$row["id_stu"]}}").removeClass('is-invalid');
                                            $("#inputNM{{$row["id_stu"]}}").addClass('is-valid');
                                            $.ajax({
                                                type: "GET",
                                                url: "change_student_NM",
                                                data:{
                                                    id_stu: '{{$row["id_stu"]}}',
                                                    id_curso:'{{$row["id_curso"]}}',
                                                    id_matricula:'{{$row["id_matricula"]}}',
                                                    inNM: input
                                                },
                                                success: function (data)
                                                {
                                                    if(data == ""){
                                                        Toast.fire({
                                                            icon: 'success', 
                                                            title: 'Completado'
                                                        });
                                                    }else{
                                                        $("#inputNM{{$row["id_stu"]}}").removeClass('is-valid');
                                                        $("#inputNM{{$row["id_stu"]}}").addClass('is-invalid');
                                                        Toast.fire({
                                                            icon: 'error', 
                                                            title: data
                                                        });
                                                    }
                                                }
                                            });
                                        }
                                        else{
                                            $("#inputNM{{$row["id_stu"]}}").removeClass('is-valid');
                                            $("#inputNM{{$row["id_stu"]}}").addClass('is-invalid');
                                        }
                                    }
                                });
                            </script>
                        </td>
                        <td>
                            @if($row["matricula"] == "si")
                                <input class="form-control" type="number" min="1" max="999999" value="{{$row["centro_padres"]}}" id="inputCP{{$row["id_stu"]}}" required="">
                            @else
                                <input readonly class="form-control" type="number" min="1"  max="999999"  value="{{$row["centro_padres"]}}" id="inputCP{{$row["id_stu"]}}" required="">
                            @endif
                            <script>
                                // $(document).ready(function(){
                                //     $("#selectSection{{$row["id_stu"]}} [value={{$row["seccion"]}}]").prop('selected',true);
                                // });
                                $("#inputCP{{$row["id_stu"]}}").focus(function(){
                                    Toast.fire({
                                        icon: 'info', 
                                        title: 'Para guardar presione enter.'
                                    })
                                });
                                $("#inputCP{{$row["id_stu"]}}").on('keypress', function (e){
                                    var input= $(this).val();
                                   // alert('many');
                                    
                                    if(e.which == 13) {
                                     //   alert('You pressed enter!');
                                        if(input > 0 && input < 999999){
                                            $("#inputCP{{$row["id_stu"]}}").removeClass('is-invalid');
                                            $("#inputCP{{$row["id_stu"]}}").addClass('is-valid');
                                            $.ajax({
                                                type: "GET",
                                                url: "change_student_CP",
                                                data:{
                                                    id_stu: '{{$row["id_stu"]}}',
                                                    id_curso:'{{$row["id_curso"]}}',
                                                    id_matricula:'{{$row["id_matricula"]}}',
                                                    inCp: input
                                                },
                                                success: function (data)
                                                {
                                                    if(data == ""){
                                                        Toast.fire({
                                                            icon: 'success', 
                                                            title: 'Completado'
                                                        });
                                                    }else{
                                                        $("#inputCP{{$row["id_stu"]}}").removeClass('is-valid');
                                                        $("#inputCP{{$row["id_stu"]}}").addClass('is-invalid');
                                                        Toast.fire({
                                                            icon: 'error', 
                                                            title: data
                                                        });
                                                    }
                                                }
                                            });
                                        }
                                        else{
                                            $("#inputCP{{$row["id_stu"]}}").removeClass('is-valid');
                                            $("#inputCP{{$row["id_stu"]}}").addClass('is-invalid');
                                        }
                                    }
                                });
                            </script>
                        </td>
                        <td>
                            @if($flag)
                                <div class="custom-control custom-switch">
                                    @if($row["matricula"] == "si")
                                        <input type="checkbox" class="custom-control-input sw-success" id="customSwitch{{$row["id_stu"]}}" checked="">
                                        <label class="custom-control-label text-success" for="customSwitch{{$row["id_stu"]}}" style="width:112px" id="labelMatricula{{$row["id_stu"]}}">Matriculado</label>
                                    @else
                                        <input type="checkbox" class="custom-control-input sw-success" id="customSwitch{{$row["id_stu"]}}" >
                                        <label class="custom-control-label text-danger" for="customSwitch{{$row["id_stu"]}}" style="width:112px" id="labelMatricula{{$row["id_stu"]}}">No Matriculado</label>
                                    @endif
                                </div>
                                <script>
                                    $("#customSwitch{{$row["id_stu"]}}").click(function (){
                                        Swal.fire({
                                            icon: 'info',
                                            title: 'Cargando',
                                            showConfirmButton: false,
                                        })
                                        $.ajax({
                                            type: "GET",
                                            url: "student_activate",
                                            data:{
                                                id_stu: '{{$row["id_stu"]}}',
                                                id_matricula: '{{$row["id_matricula"]}}'  
                                            },
                                            success: function (data)
                                            {
                                                $("#result").html(data);
                                                if($("#customSwitch{{$row["id_stu"]}}").is(":checked")){                                       
                                                    $("#labelMatricula{{$row["id_stu"]}}").removeClass('text-danger');
                                                    $("#labelMatricula{{$row["id_stu"]}}").addClass('text-success');
                                                    $("#labelMatricula{{$row["id_stu"]}}").html('Matriculado');
                                                    $("#selectSection{{$row["id_stu"]}}").removeAttr('disabled');
                                                    $("#inputCP{{$row["id_stu"]}}").removeAttr('readonly');
                                                    var cantidad = parseInt($("#cantidadMat").html());
                                                    cantidad++;
                                                    $("#cantidadMat").html(cantidad)
                                                }
                                                else{                                       
                                                    $("#labelMatricula{{$row["id_stu"]}}").removeClass('text-succes');
                                                    $("#labelMatricula{{$row["id_stu"]}}").addClass('text-danger');
                                                    $("#labelMatricula{{$row["id_stu"]}}").html('No Matriculado');
                                                    $("#selectSection{{$row["id_stu"]}}").attr('disabled',true);
                                                    $("#inputCP{{$row["id_stu"]}}").attr('readonly',true);                                        
                                                    var cantidad = parseInt($("#cantidadMat").html());
                                                    cantidad--;
                                                    $("#cantidadMat").html(cantidad)
                                                }
                                                Toast.fire({
                                                    icon: 'success', 
                                                    title: 'Completado'
                                                })
                                            }
                                        });
                                    });
                                </script>
                            @else
                                <a href="adm_courses?add_course" class="badge badge-primary">Agregar curso</a>
                            @endif
                        </td>
                        <td>
                            <div class="custom-control custom-switch">
                                @if($row["es_repitente"] == "si")
                                    <input type="checkbox" class="custom-control-input sw-danger" id="repitente{{$row["id_stu"]}}" checked="">
                                    <label class="custom-control-label text-success" for="repitente{{$row["id_stu"]}}" ></label>
                                @else
                                    <input type="checkbox" class="custom-control-input sw-danger" id="repitente{{$row["id_stu"]}}" >
                                    <label class="custom-control-label text-danger" for="repitente{{$row["id_stu"]}}" ></label>
                                @endif
                            </div>
                            <script>
                                $("#repitente{{$row["id_stu"]}}").click(function (){
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Cargando',
                                        showConfirmButton: false,
                                    })
                                    $.ajax({
                                        type: "GET",
                                        url: "student_is_repeater",
                                        data:{
                                            id_stu: '{{$row["id_stu"]}}',
                                            id_matricula: '{{$row["id_matricula"]}}'  
                                        },
                                        success: function (data)
                                        {
                                            Toast.fire({
                                                icon: 'success', 
                                                title: 'Completado'
                                            })
                                        }
                                    });
                                });
                            </script>
                        </td>
                        <td>
                            <div class="custom-control custom-switch">
                                @if($row["es_nuevo"] == "si")
                                    <input type="checkbox" class="custom-control-input" id="nuevo{{$row["id_stu"]}}" checked="">
                                    <label class="custom-control-label text-success" for="nuevo{{$row["id_stu"]}}" ></label>
                                @else
                                    <input type="checkbox" class="custom-control-input" id="nuevo{{$row["id_stu"]}}" >
                                    <label class="custom-control-label text-danger" for="nuevo{{$row["id_stu"]}}" ></label>
                                @endif
                            </div>
                            <script>
                                $("#nuevo{{$row["id_stu"]}}").click(function (){
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Cargando',
                                        showConfirmButton: false,
                                    })
                                    $.ajax({
                                        type: "GET",
                                        url: "student_is_new",
                                        data:{
                                            id_stu: '{{$row["id_stu"]}}',
                                            id_matricula: '{{$row["id_matricula"]}}'  
                                        },
                                        success: function (data)
                                        {
                                            Toast.fire({
                                                icon: 'success', 
                                                title: 'Completado'
                                            })
                                        }
                                    });
                                });
                            </script>
                        </td>
                        <td>
                            <div class="custom-control custom-switch">
                                @if($row["es_reincorporado"] == "si")
                                    <input type="checkbox" class="custom-control-input sw-success" id="rein{{$row["id_stu"]}}" checked="">
                                    <label class="custom-control-label text-success" for="rein{{$row["id_stu"]}}" ></label>
                                @else
                                    <input type="checkbox" class="custom-control-input sw-success" id="rein{{$row["id_stu"]}}" >
                                    <label class="custom-control-label text-danger" for="rein{{$row["id_stu"]}}" ></label>
                                @endif
                            </div>
                            <script>
                                $("#rein{{$row["id_stu"]}}").click(function (){
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Cargando',
                                        showConfirmButton: false,
                                    })
                                    $.ajax({
                                        type: "GET",
                                        url: "student_is_reincorporated",
                                        data:{
                                            id_stu: '{{$row["id_stu"]}}',
                                            id_matricula: '{{$row["id_matricula"]}}'  
                                        },
                                        success: function (data)
                                        {
                                            Toast.fire({
                                                icon: 'success', 
                                                title: 'Completado'
                                            })
                                        }
                                    });
                                });
                            </script>
                        </td>
                        <td>
                            <input class="form-control @if($row["fecha_retiro"] != null) border-warning @endif" type="date" value="{{$row["fecha_retiro"]}}" id="inputFR{{$row["id_stu"]}}">
                            <script>
                                $("#inputFR{{$row["id_stu"]}}").focus(function(){
                                    Toast.fire({
                                        icon: 'warning', 
                                        title: 'Esta entrada tiene Autoguardado.'
                                    })
                                });
                                $("#inputFR{{$row["id_stu"]}}").on("keyup change", function(e) {
                                    var flag = false;
                                    var input = $(this).val();
                                    if(isValidDate($(this).val())){
                                        $("#inputFR{{$row["id_stu"]}}").addClass('border-warning');
                                        flag=true;
                                    }else if($(this).val() == ""){
                                        $("#inputFR{{$row["id_stu"]}}").removeClass('border-warning');
                                        flag=true;
                                    }
                                    if(flag){
                                        $.ajax({
                                            type: "GET",
                                            url: "change_student_FR",
                                            data:{
                                                id_stu: '{{$row["id_stu"]}}',
                                                id_curso:'{{$row["id_curso"]}}',
                                                id_matricula:'{{$row["id_matricula"]}}',
                                                inNM: input
                                            },
                                            success: function (data)
                                            {
                                                if(data == ""){
                                                    Toast.fire({
                                                        icon: 'success', 
                                                        title: 'Actualizado'
                                                    });
                                                }else{
                                                    Toast.fire({
                                                        icon: 'error', 
                                                        title: data
                                                    });
                                                }
                                            }
                                        });
                                    }
                                })
                            </script>
                        </td>
                    </tr>             
                @endforeach                      
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready( function () {
            Swal.close();
            Toast.fire({
                icon: 'success', 
                title: 'Carga exitosa'
            })
            $('#list_students').DataTable({
                    order: [],
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
        } );
    </script>
</div>

@endsection