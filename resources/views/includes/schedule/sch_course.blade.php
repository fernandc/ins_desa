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
    tbody th:first-child {
        font-weight: normal;
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
            <tr>
                <th id="d1">
                </th>
                <td id="d2">
                </td>
                <td id="d3">
                </td>
                <td id="d4">
                </td>
                <td id="d5">
                </td>
                <td id="d6">
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
        function newBloq(id,dia,personal,materia,hini,hfin){
            var line1 = '<div id="sch'+id+'" class="card text-center mb-2" ><div class="card-header row m-0" style="padding: 3px;font-size: larger;">';
            var line2 = '<div class="col-md-8" style="text-align: left;">'+personal+'</div>';
            var line3 = '<div class="col-md-4"><button class="btn btn-outline-danger btn-sm btn-del-sch" data="'+id+'" onclick="delSch('+id+')" style="float: right;"><i class="far fa-trash-alt"></i></button></div>';
            var line4 = '</div><div class="card-body" style="padding: 0.75rem;"><span class="text-secondary" style="font-size: x-small;">ID: '+id+'</span><h6 class="card-title">'+materia+'</h6>';
            var line5 = '<p class="card-text d'+dia+'">'+hini+' - '+hfin+'</p></div></div>';
            if($("#d"+dia).text().trim().length > 0){
                var cid = "";
                $(".d"+dia).each(function(){
                    var ctime = $(this).text().substr(0,5).replaceAll(':', '');
                    var gtime = hini.replaceAll(':', '');
                    //alert(ctime+" "+gtime);
                    if(ctime <= gtime){
                        cid =  $(this).parent().parent().attr('id');
                    }
                });
                if(cid == ""){
                    $("#d"+dia).prepend(line1+line2+line3+line4+line5);
                }else{
                    $("#"+cid).after(line1+line2+line3+line4+line5);
                }
            }else{
                $("#d"+dia).append(line1+line2+line3+line4+line5);
            }
            //return line1+line2+line3+line4+line5;
        }
        @foreach ($sched_course as $item)
            newBloq('{{$item["id"]}}','{{$item["dia"]}}','{{$item["nombre_personal"]}}','{{$item["nombre_materia"]}}','{{substr($item["hora_inicio"],0,5)}}','{{substr($item["hora_fin"],0,5)}}');
        @endforeach
        function delSch(schid){
            Swal.fire({
            title: '¿Eliminar esta clase?',
            text: "Se puede volver a crear",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#sch"+schid).remove();
                    $.ajax({
                        type: "GET",
                        url: "rmv_block",
                        data:{
                            schid,
                        },
                        success: function (data){
                            //console.log(data);
                            if(data == 200){
                                Swal.fire(
                                'Eliminado!',
                                'La clase ha sido eliminada',
                                'success'
                                );
                            }
                        }
                    });
                    
                }
            });
        }

        var cday = 0;
        $(".mdl-new").click(function(){
            var day = $(this).attr("data");
            cday = day;
            var title = "";
            if(day == 1){title = "Bloque para día Lunes"}
            if(day == 2){title = "Bloque para día Martes"}
            if(day == 3){title = "Bloque para día Miercoles"}
            if(day == 4){title = "Bloque para día Jueves"}
            if(day == 5){title = "Bloque para día Viernes"}
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
                        if(data != ""){
                            newBloq(data,cday,prof,asig,hin,hou);
                            $("form").trigger("reset");
                            Swal.fire({
                            icon: 'success',
                            title: 'Completado!',
                            text: 'El bloque se ha guardado con éxito.'
                            })
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
        })
    </script>

</div>


