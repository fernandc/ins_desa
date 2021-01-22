
<div class="modal-header">
    <h5 class="modal-title" >Editar grupo</h5>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h3 class="ml-1" style="text-decoration: underline;" for="newName" id="spanNombre" >{{$nombre}}</h3>
        </div>
        <form class="col-4">
            <div class="form-group">
                <input type="text" class="form-control ml-1" value="{{$nombre}}" id="newName" name="new_name"  minlength="4">
                <button type="button" class="btn btn-success btn-sm m-1" id="changeName">Cambiar nombre de grupo</button>
                <script>
                    $("#changeName").click(function(){
                        Swal.fire({
                            icon: 'info',
                            title: 'Cargando',
                            showConfirmButton: false,
                        })
                        var temp = $('#newName').val();
                        if(temp.length > 3){
                            $.ajax({
                                type: "GET",
                                url: "/change_name_group",
                                data:{
                                    id_grupo:'{{$id_grupo}}',
                                    nombre: temp
                                },
                                success: function (data)
                                {
                                    
                                    $("#spanNombre").html(temp);
                                    $("#spanRow{{$id_grupo}}").html(temp);
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Completado'
                                    })
                                }
                            });
                        }
                        else{
                            Swal.fire({
                            icon: 'info',
                            title: 'Ingrese 4 o más carácteres.',
                            showConfirmButton: true,
                        })
                        }
                    });
                </script>
            </div>
        </form>
        <div class="col-8">
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header" id="result">
                    Estudiantes
                </div>
                <div class="card-body">
                <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="addStudentToGroup">Agregar Estudiante</label>
                            <input type="text" hidden="" id="idaddStu" name="idaddStu">
                            <input type="text" class="form-control" id="addStudentToGroup" name="addStudentToGroup" placeholder="Nombre estudiante...">
                            <script>
                                var countries = [ 
                                    @foreach($students_enrollment as $row)
                                        { data: '{{$row["id_stu"]}}', value: '{{$row["nombre_stu"]}}' },                    
                                    @endforeach
                                ];
                                $("#addStudentToGroup").keyup(function(){
                                    $("#addStudentToGroup").addClass('is-invalid');
                                    $("#addStudentToGroup").removeClass('is-valid');
                                });
                                
                                $('#addStudentToGroup').autocomplete({
                                    minChars: 3,
                                    lookup: countries,
                                    onSelect: function (suggestion) {
                                        $("#idaddStu").val(suggestion.data);
                                        $("#addStudentToGroup").addClass('is-valid');
                                        $("#addStudentToGroup").removeClass('is-invalid');
                                    }
                                });
                            </script>
                        </div>
                        <div class="form-group col-md-4">
                            <label style="color:transparent;">.</label>
                            <button type="button" class="form-control btn btn-success" id="addStuBtn" >Agregar</button>
                            <script>
                                $("#addStuBtn").click(function(){
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Cargando',
                                        showConfirmButton: false,
                                    })
                                    var id_stu = $("#idaddStu").val()
                                    $.ajax({
                                        type:'GET',
                                        url:'add_student_to_group',
                                        data:{
                                            id_stu,
                                            id_grup:'{{$id_grupo}}',
                                        },
                                        success: function (data){
                                            $("#stuTbody").prepend(data);
                                            $("#addStudentToGroup").val('');                                            
                                            Toast.fire({
                                                icon: 'success',
                                                title: 'Completado'
                                            })
                                        }
                                    });
                                })
                            </script>                           
                        </div>
                    </div>
                    <table class="table table-bordered table-responsive-sm" id="tableStuGroup">
                        <thead>
                            <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="stuTbody">            
                        @foreach($list_students_items_groups as $row2)                  
                            @if($row2["tipo"] == "Estudiante")
                                <tr id="trStu{{$row2["id_item"]}}" style="background-color:#d5e2fb73">
                                    <td>
                                        {{$row2["nombre"]}}
                                    </td>
                                    <td><button type="button" class="btn btn-danger btn-sm btn-del-stu" onclick="funcDelStu({{$row2["id_item"]}})">Eliminar</button></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    <script>
                        function funcDelStu(id_item){
                            Swal.fire({
                                icon: 'info',
                                title: 'Cargando',
                                showConfirmButton: false,
                            })
                            $.ajax({
                                type:'GET',
                                url:'del_student_from_group',
                                data:{
                                    id_item,
                                    id_grup:'{{$id_grupo}}',
                                },
                                success: function (data){
                                    if(data == 200){
                                        $("#trStu" + id_item).remove();
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Completado'
                                        });
                                    }
                                    else{                                        
                                        Toast.fire({
                                            icon: 'error',
                                            title: 'Status' + data
                                        });
                                    }
                                }
                            });
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
    <br>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
</div>
<script>
    $(document).ready( function () {
        $('#tableStuGroup').DataTable({
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
<script>
    $(document).ready( function () {
        $('#tableGroup').DataTable({
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


