@php
    $course = $active;       
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
                <th scope="col" style="vertical-align: middle;">Bloque</th>
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
                    @php
                        dd($clase_curso);
                    @endphp
                    <form>
                        <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputAS">Asignatura</label>
                            <select id="inputAS" class="form-control">
                                <option selected>Seleccionar</option>
                                @php
                                    $materias = array();
                                    $profesores = array();
                                @endphp  
                                @foreach ($clase_curso as $item)
                                    @php
                                        array_push($materias,$item["materia"]);
                                        array_push($profesores,$item["nombre_personal"]);
                                    @endphp    
                                @endforeach
                                @php
                                    $materias = array_unique($materias);
                                    $profesores = array_unique($profesores);
                                @endphp
                                @foreach ($materias as $row)
                                    <option>
                                        {{$row}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPR">Profesor</label>
                            <select id="inputPR" class="form-control">
                            <option selected>Seleccionar</option>
                            @foreach ($profesores as $item)
                                <option>
                                    {{$item}}
                                </option>
                            @endforeach
                            </select>
                        </div>
                        </div>
                        <br>
                        <h5 style="text-align: center">Horario</h5>
                        <div class="form-row">
                            <div class="form-group col-md-6" >
                                <label for="">Desde</label>
                                <input class="form-control" type="time" name="in" id="in">
                            </div>
                            <div class="form-group col-md-6" >
                                <label for="">Hasta</label>
                                <input class="form-control" type="time" name="out" id="out">
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
            alert(cday);
            //ajax
        })
    </script>
</div>

<script>
    function selected_square(day,hin,hout) {
        //
        if(type == 1){
                $("#headingOne"+day+"-"+bloq).css("background","#73c686");
            }else{
                $("#headingOne"+day+"-"+bloq).css("background","#6fc5d3");
            }
            $("#sel"+day+"-"+bloq+" option[value="+type+"]").prop('selected', true);
            $("#inA"+day+"-"+bloq).val(hin);
            $("#ouA"+day+"-"+bloq).val(hout);
            $("#badgein"+day+"-"+bloq).html(hin);
            $("#badgeou"+day+"-"+bloq).html(hout);
        }
    $( document ).ready(function() {
        
        @foreach ($sched_course as $row)
            @php
                $cday = $row["day"];
                $chour_in = $row["hour_in"];
                $chour_out = $row["hour_out"];
            @endphp
            selected_square({{$cday}},"{{$chour_in}}","{{$chour_out}}");
        @endforeach
    });
</script>
