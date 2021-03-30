
<!DOCTYPE html> 


@extends("layouts.mcdn")
@section("title")
Administrar Estudiantes
@endsection

@section("headex")

@endsection

@section("context")

<div class="container">
        <h2 style="text-align: center;">Administrar Cursos 
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
        <button class="btn btn-success " type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Agregar Curso</button>
        <br>
        @php
            $collapsed = "";
        @endphp
        @if(isset($_GET["add_course"]))
            @php
                $collapsed = "show";
            @endphp
        @endif
        <div class="collapse {{$collapsed}} mt-2" id="collapseExample">
            <form class="row" style="margin: 0px;" id="formAdd" action="add_course" method="GET">
                <div class="input-group">
                    <br>
                    <div class="input-group-prepend ">
                        <label for="grade_id" class="input-group-text" for="inputGroupSelect01">Curso</label>
                        <br>
                    </div>
                    <select class="custom-select" id="inputGroupSelect01" name="grade_id" required="">
                        <option selected value="0">Seleccionar</option>
                        <option value="1">Pre-Kinder</option>
                        <option value="2">Kinder</option>
                        <option value="3">Primero Básico</option>
                        <option value="4">Segundo Básico</option>
                        <option value="5">Tercero Básico</option>
                        <option value="6">Cuarto Básico</option>
                        <option value="7">Quinto Básico</option>
                        <option value="8">Sexto Básico</option>
                        <option value="9">Séptimo Básico</option>
                        <option value="10">Octavo Básico</option>
                        <option value="11">Primero Medio</option>
                        <option value="12">Segundo Medio</option>
                        <option value="13">Tercero Medio</option>
                        <option value="14">Cuarto Medio</option>                        
                    </select>
                </div>
                <br>
                <div class="input-group">
                    <br>
                    <div class="input-group-prepend ">
                        <label for="letter" class="input-group-text" for="inputGroupSelect02">Letra</label>
                    </div>
                    <select class="custom-select" id="inputGroupSelect02" name="letter" required="">
                        <option selected value="0">Seleccionar</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                    </select>
                </div>
                <br>

                <div class="form-group col-4">
                    <br>
                    <label for="year" style="color: white;">.</label>
                    <button id="sendform" type="button" class="form-control btn btn-success">Agregar</button>
                </div>
            </form>
            <script>
                $("#sendform").click(function(){
                    var curso = $("#inputGroupSelect01").val(); 
                    var seccion = $("#inputGroupSelect02").val(); 
                    if(curso != 0 && seccion != 0){
                         $("#formAdd").submit() 
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Seleccione campos faltantes.',
                        })
                    }
                });
            </script>
        </div>
        <br>
        <br>
        <br>
        <div class="table-responsive">
            <table class="table table-sm" style="text-align: center;" id="list_course">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Curso</th>
                        <th scope="col">Sección</th>
                        <th scope="col">Docente</th>
                        <th scope="col">Horario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grades as $row)
                        <tr>
                            <td>{{$row["nombre_curso"]}}</td>
                            <td>{{$row["seccion"]}}</td>
                            <!-- {{$row["profesor"]}} -->
                            <td>
                                @if($row["profesor"] == null)
                                    <a href="adm_teachers">Asignar Profesor Jefe</a>
                                @else
                                    <strong>{{$row["profesor"]}}</strong> 
                                @endif 
                            </td> 
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalHorario" id="modalBloqueHorario{{$row["id"]}}">Asignar Bloques</button> 
                                <script>
                                    $("#modalBloqueHorario{{$row["id"]}}").click(function(){
                                        Swal.fire({
                                            icon: 'info',
                                            title: 'Cargando',
                                            showConfirmButton: false,
                                        })
                                        $("#modalContent").html("");
                            
                                        $.ajax({
                                            type: "GET",
                                            url: "modal_bloqueHorario",
                                            
                                            success: function (data)
                                            {
                                                $("#modalContent").html(data);
                                            }, 
                                            error: function (request, status, error) {
                                                alert(request.responseText);
                                            }

                                        });
                                    });
                                </script>
                            </td>
                            <div class="modal" id="modalHorario" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content" id="modalContent"> 
                                    </div>
                                </div>
                            </div>                                                  
                        </tr>               
                    @endforeach                      
                </tbody>
            </table>
        </div>
        <script>
            $(document).ready( function () {
                $('#list_course').DataTable({
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