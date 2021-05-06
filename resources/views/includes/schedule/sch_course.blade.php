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
            @for ($j = 1; $j <= 10; $j++)
                @php
                    $cont = $j;    
                @endphp
                <tr>
                    <th>{{$cont}}</th>
                    @for ($i = 1; $i <= 6; $i++)
                        
                        <td>
                            <div class="accordion">
                                <div class="card"  id="card{{$i}}-{{$j}}">
                                    <div class="card-header" id="headingOne{{$i}}-{{$j}}" style="padding: .75rem .75rem;">
                                        <h2 class="mb-0">
                                            <select class="form-control form-control-sm" id="sel{{$i}}-{{$j}}">
                                                <option selected>
                                                    NINGUNO
                                                </option>
                                                <option value="1" id="opt2">
                                                    ASIGNATURA
                                                </option>
                                                <option value="2" id="opt2">
                                                    RECESO
                                                </option>
                                            </select>
                                            <button class="btn btn-link collapsed" id="optbtn1{{$i}}-{{$j}}" hidden  type="button" data-toggle="collapse" data-target="#collapseOne{{$i}}-{{$j}}" aria-expanded="true" aria-controls="collapseOne{{$i}}-{{$j}}">
                                                Bloque {{$cont}} 
                                            </button>
                                            <button class="btn btn-link collapsed" id="optbtn2{{$i}}-{{$j}}" hidden type="button" data-toggle="collapse" data-target="#collapseTwo{{$i}}-{{$j}}" aria-expanded="true" aria-controls="collapseTwo{{$i}}-{{$j}}">
                                                Receso {{$cont}} 
                                            </button>
                                            <script>
                                                $("#sel{{$i}}-{{$j}}").change(function(){
                                                    var opt = $(this).val();
                                                    if(opt == 1){
                                                        $("#optbtn1{{$i}}-{{$j}}").click(); 
                                                        $("#collapseTwo{{$i}}-{{$j}}").removeClass("show");
                                                        $("#headingOne{{$i}}-{{$j}}").css("background","#73c686");
                                                        $("select.form-control").attr("disabled",true);
                                                        $(this).attr("disabled",false);
                                                    }else{
                                                        if(opt == 2){
                                                            $("#optbtn2{{$i}}-{{$j}}").click();
                                                            $("#collapseOne{{$i}}-{{$j}}").removeClass("show");
                                                            $("#headingOne{{$i}}-{{$j}}").css("background","#6fc5d3");
                                                            $("select.form-control").attr("disabled",true);
                                                            $(this).attr("disabled",false);
                                                        }
                                                        else{
                                                            $("#collapseOne{{$i}}-{{$j}}").removeClass("show");
                                                            $("#collapseTwo{{$i}}-{{$j}}").removeClass("show");
                                                            $("#headingOne{{$i}}-{{$j}}").css("background","");
                                                            $("select.form-control").attr("disabled",false);
                                                        }
                                                    }
                                                });
                                            </script>
                                        </h2>
                                    </div>
                                    <div id="collapseOne{{$i}}-{{$j}}" class="collapse" aria-labelledby="headingOne{{$i}}-{{$j}}" >
                                        <div class="card-body text-white mb-3" style="background:#73c686">
                                            <label for="">Desde</label>
                                            <input class="form-control" type="time" name="in1" id="inA{{$i}}-{{$j}}">
                                            <br>
                                            <label for="">Hasta</label>
                                            <input class="form-control" type="time" name="out1" id="ouA{{$i}}-{{$j}}">
                                            <button class="btn btn-success btn-sm mt-4 mb-2 float-right" id="btnA{{$i}}-{{$j}}"  > Guardar</button>
                                        </div>
                                    </div>
                                    <div id="collapseTwo{{$i}}-{{$j}}" class="collapse" aria-labelledby="headingTwo{{$i}}-{{$j}}" >
                                        <div class="card-body text-white mb-3" style="background:#6fc5d3">
                                            <label for="">Desde</label>
                                            <input class="form-control" type="time" name="in2" id="inR{{$i}}-{{$j}}">
                                            <br>
                                            <label for="">Hasta</label>
                                            <input class="form-control" type="time" name="out2" id="ouR{{$i}}-{{$j}}">
                                            <button class="btn btn-success btn-sm mt-4 mb-2 float-right" id="btnR{{$i}}-{{$j}}" > Guardar</button>
                                        </div>
                                    </div>
                                    <script>                                       
                                        $("#btnA{{$i}}-{{$j}}").click(function(){
                                            var inputInA = $("#inA{{$i}}-{{$j}}").val();
                                            var inputOuA = $("#ouA{{$i}}-{{$j}}").val();
                                            var type = $("#sel{{$i}}-{{$j}}").val();
                                            if(inputInA != "" && inputOuA != ""){
                                                if(inputOuA > inputInA){
                                                    $.ajax({
                                                        type: "GET",
                                                        url: "save_block",
                                                        data:{
                                                            inputIn:inputInA,
                                                            inputOu:inputOuA,
                                                            course:"{{$id_curso}}",
                                                            val: type,
                                                            block:"{{$j}}",
                                                            day:"{{$i}}" 
                                                        },
                                                        success: function (data){
                                                            //$("#test").html(data);
                                                            if(data == 200 ){
                                                                $("#collapseOne{{$i}}-{{$j}}").removeClass("show");
                                                                $("select.form-control").attr("disabled",false);
                                                            }else{
                                                                alert("Failed");
                                                            }
                                                        }
                                                    });
                                                }else{
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Oops...',
                                                        text: 'La hora final debe ser mayor a la hora inicio',
                                                    });
                                                }
                                            }else{
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Oops...',
                                                    text: 'No se ha completado los campos',
                                                })
                                            }
                                        })
                                    </script>
                                </div>
                            </div>
                            <div style="text-align: center;font-size: 0.9rem;">
                                <span id="badgein{{$i}}-{{$j}}" class="badge badge-light"></span>-<span id="badgeou{{$i}}-{{$j}}" class="badge badge-light"></span>
                            </div>
                        </td>
                    @endfor
                </tr>                
            @endfor
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
                    ...
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
    function selected_square(day,bloq,hin,hout,type) {
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
                $cbloq = $row["bloq"];
                $chour_in = $row["hour_in"];
                $chour_out = $row["hour_out"];
                $ctype = $row["type"];
            @endphp
            selected_square({{$cday}},{{$cbloq}},"{{$chour_in}}","{{$chour_out}}",{{$ctype}});
        @endforeach
    });
</script>
