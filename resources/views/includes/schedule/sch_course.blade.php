@php
    $course = $active;       
    $materias = array();
@endphp  
@foreach ($clase_curso as $item)
    @php
        array_push($materias,$item["materia"]);                                        
    @endphp
@endforeach
@php                                    
    $materias = array_unique($materias);
@endphp

<style>
    .table tbody td{
        padding-bottom: 0px;
    }
</style>
<div class="table table-responsive table-bordered">
    <table class="table" id="test">
        <thead>
            <tr style="text-align: center;">
                
                <th scope="col">
                    Lunes
                    <br>
                    <a href="#" class="badge badge-primary mdl-new" data="1" data-toggle="modal" data-target="#mdladd">Agregar Bloque</a>
                </th>
                <th scope="col">
                    Martes
                    <br>
                    <a href="#" class="badge badge-primary mdl-new" data="2" data-toggle="modal" data-target="#mdladd">Agregar Bloque</a>
                </th>
                <th scope="col">
                    Miércoles
                    <br>
                    <a href="#" class="badge badge-primary mdl-new" data="3" data-toggle="modal" data-target="#mdladd">Agregar Bloque</a>
                </th>
                <th scope="col">
                    Jueves
                    <br>
                    <a href="#" class="badge badge-primary mdl-new" data="4" data-toggle="modal" data-target="#mdladd">Agregar Bloque</a>
                </th>
                <th scope="col">
                    Viernes
                    <br>
                    <a href="#" class="badge badge-primary mdl-new" data="5" data-toggle="modal" data-target="#mdladd">Agregar Bloque</a>
                </th>
                <th scope="col">
                    Sábado
                    <br>
                    <a href="#" class="badge badge-primary mdl-new" data="6" data-toggle="modal" data-target="#mdladd">Agregar Bloque</a>
                </th>
            </tr>
        </thead>
        <tbody>
            @php
                $dia1 = array();        
                $dia2 = array();        
                $dia3 = array();        
                $dia4 = array();        
                $dia5 = array();        
                $dia6 = array();            
            @endphp
            @foreach ($sched_course as $item)
                @php
                    if($item["dia"]==1){
                        array_push($dia1,$item);
                    }
                    if($item["dia"]==2){
                        array_push($dia2,$item);
                    }
                    if($item["dia"]==3){
                        array_push($dia3,$item);
                    }
                    if($item["dia"]==4){
                        array_push($dia4,$item);
                    }
                    if($item["dia"]==5){
                        array_push($dia5,$item);
                    }
                    if($item["dia"]==6){
                        array_push($dia6,$item);
                    }
                @endphp
            @endforeach
            <tr>
                <th>
                    @foreach ($dia1 as $item)
                        <div class="card text-center mb-2">
                            <div class="card-header">
                                {{$item["nombre_personal"]}}
                            </div>
                            <div class="card-body" style="padding: 0.75rem;">
                                <h6 class="card-title">{{$item["nombre_materia"]}}</h6>
                                <p class="card-text">{{$item["hora_inicio"]}} - {{$item["hora_fin"]}}</p>
                            </div>
                        </div>
                    @endforeach
                </th>
                <td>
                    @foreach ($dia2 as $item)
                        <div class="card text-center mb-2">
                            <div class="card-header">
                                {{$item["nombre_personal"]}}
                            </div>
                            <div class="card-body" style="padding: 0.75rem;">
                                <h6 class="card-title">{{$item["nombre_materia"]}}</h6>
                                <p class="card-text">{{$item["hora_inicio"]}} - {{$item["hora_fin"]}}</p>
                            </div>
                        </div>
                    @endforeach
                </td>
                <td>
                    @foreach ($dia3 as $item)
                        <div class="card text-center mb-2">
                            <div class="card-header">
                                {{$item["nombre_personal"]}}
                            </div>
                            <div class="card-body" style="padding: 0.75rem;">
                                <h6 class="card-title">{{$item["nombre_materia"]}}</h6>
                                <p class="card-text">{{$item["hora_inicio"]}} - {{$item["hora_fin"]}}</p>
                            </div>
                        </div>
                    @endforeach
                </td>
                <td>
                    @foreach ($dia4 as $item)
                        <div class="card text-center mb-2">
                            <div class="card-header">
                                {{$item["nombre_personal"]}}
                            </div>
                            <div class="card-body" style="padding: 0.75rem;">
                                <h6 class="card-title">{{$item["nombre_materia"]}}</h6>
                                <p class="card-text">{{$item["hora_inicio"]}} - {{$item["hora_fin"]}}</p>
                            </div>
                        </div>
                    @endforeach
                </td>
                <td>
                    @foreach ($dia5 as $item)
                        <div class="card text-center mb-2">
                            <div class="card-header">
                                {{$item["nombre_personal"]}}
                            </div>
                            <div class="card-body" style="padding: 0.75rem;">
                                <h6 class="card-title">{{$item["nombre_materia"]}}</h6>
                                <p class="card-text">{{$item["hora_inicio"]}} - {{$item["hora_fin"]}}</p>
                            </div>
                        </div>
                    @endforeach
                </td>
                <td>
                    @foreach ($dia6 as $item)
                        <div class="card text-center mb-2">
                            <div class="card-header">
                                {{$item["nombre_personal"]}}
                            </div>
                            <div class="card-body" style="padding: 0.75rem;">
                                <h6 class="card-title">{{$item["nombre_materia"]}}</h6>
                                <p class="card-text">{{$item["hora_inicio"]}} - {{$item["hora_fin"]}}</p>
                            </div>
                        </div>
                    @endforeach
                </td>
              </tr>
        </tbody>               
    </table>
    <div id="mdladd" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mdltitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputAS">Asignatura</label>
                            <select id="inputAS" class="form-control">
                                <option selected>Seleccionar</option>
                                
                                @foreach ($materias as $row)                                   
                                    <option>
                                        {{$row}}
                                    </option>                                    
                                @endforeach
                            </select>
                            <script>
                                var jsn = ' @php echo json_encode($clase_curso); @endphp ';
                                var parse = JSON.parse(jsn);
                                $("#inputAS").change(function(){
                                    $("#inputPR").html("");
                                    var asign = $(this).val();
                                    $("#inputPR").attr("disabled",false);
                                    var result = buscarProfAsign(asign);
                                    $("#inputPR").append("<option value='' > Seleccionar </option>"); 
                                    result.forEach(element => {
                                        $("#inputPR").append("<option>" + element['nombre_personal'] + "</option>");
                                    });                                
                                });
                                $("#inputPR").change(function(){
                                    var some = $(this).val();
                                    if(some == ""){
                                        $("#hourIn").attr("disabled",true);
                                        $("#hourOut").attr("disabled",true);
                                    }else{
                                        $("#hourIn").attr("disabled",false);
                                        $("#hourOut").attr("disabled",false);
                                    }
                                });

                                function buscarProfAsign(asignatura){
                                    var arr = [];
                                    
                                    parse.forEach(element => {
                                        if(element["materia"] == asignatura){
                                            arr.push(element);
                                        } 
                                    });
                                    return arr;
                                }
                            </script>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPR">Profesor</label>
                            <select id="inputPR" disabled class="form-control">
                            <option selected>Seleccionar</option>
                            
                            </select>
                        </div>
                        </div>
                        <br>
                        <h5 style="text-align: center">Horario</h5>
                        <div class="form-row">
                            <div class="form-group col-md-6" >
                                <label for="hourIn">Desde</label>
                                <input class="form-control" disabled type="time" name="in" id="hourIn">
                            </div>
                            <div class="form-group col-md-6" >
                                <label for="hourOut">Hasta</label>
                                <input class="form-control" disabled type="time" name="out" id="hourOut">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="saveBloq" type="button" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var cday = 0;
        $(".mdl-new").click(function(){
            var day = $(this).attr("data");
            cday = day;
            var title = "";
            if(day == 1){title = "Bloque para día Lunes"}
            if(day == 2){title = "Bloque para día Martes"}
            if(day == 3){title = "Bloque para día Miercoles"}
            if(day == 4){title = "Bloque para día Jueves"}
            if(day == 5){title = "Bloque para día Vuernes"}
            if(day == 6){title = "Bloque para día Sábado"}
            $("#mdltitle").html(title);
        })
        $("#saveBloq").click(function(){
            var hin = $("#hourIn").val();
            var hou = $("#hourOut").val();
            var asig = $("#inputAS").val();
            var prof = $("#inputPR").val();
            var id_class = "";
            if(hin != "" && hou != "" && asig != "" && prof != ""){
                parse.forEach(element => {
                    if(element["nombre_personal"] == prof && element["materia"] == asig){
                        id_class = element["id_clase"];
                    }
                });
                $.ajax({
                type: "GET",
                url: "save_block",
                data:{
                    hour_in:hin,
                    hour_out:hou,
                    asignatura:asig,
                    profesor:prof,
                    day:cday,
                    id_clase:id_class
                },
                success: function (data){
                    //console.log(data);
                    if(data == 200){
                        Swal.fire({
                        icon: 'success',
                        title: 'Completado!',
                        text: 'El bloque se ha guardado con éxito.'
                        })
                        location.reload();
                    }
                }
            });
            }else{
                Swal.fire({
                icon: 'error',
                title: 'Ops...',
                text: 'Se debe fijar un horario.'
                })
            }
            //ajax
        })
    </script>

</div>


