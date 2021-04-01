<div class="table table-responsive table-bordered">
    <table class="table" id="test">
        <thead>
            <tr>
                <th scope="col">Bloque</th>
                <th scope="col">Lunes</th>
                <th scope="col">Martes</th>
                <th scope="col">Miércoles</th>
                <th scope="col">Jueves</th>
                <th scope="col">Viernes</th>
                <th scope="col">Sábado</th>
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
                            <div class="accordion" id="accordionExample">
                                <div class="card"  id="card{{$i}}-{{$j}}">
                                    <div class="card-header" id="headingOne{{$i}}-{{$j}}" style="background">
                                        <h2 class="mb-0">
                                            <select class="form-control form-control-sm" id="sel{{$i}}-{{$j}}">
                                                <option selected>
                                                    SELECCIONE
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
        
                                                        
                                                    }else{
                                                        if(opt == 2){
                                                            $("#optbtn2{{$i}}-{{$j}}").click();
                                                            $("#collapseOne{{$i}}-{{$j}}").removeClass("show");
                                                        }
                                                        else{
                                                            $("#collapseOne{{$i}}-{{$j}}").removeClass("show");
                                                            $("#collapseTwo{{$i}}-{{$j}}").removeClass("show");
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
                                            <input class="form-control" type="time" name="in1" id="inR{{$i}}-{{$j}}">
                                            <br>
                                            <label for="">Hasta</label>
                                            <input class="form-control" type="time" name="out1" id="ouR{{$i}}-{{$j}}">
                                            <button class="btn btn-success btn-sm mt-4 mb-2 float-right" id="btnR{{$i}}-{{$j}}" > Guardar</button>
                                        </div>
                                    </div>
                                    <script>
                                        $("#btnA{{$i}}-{{$j}}").click(function(){
                                            var inputInA = $("#inA{{$i}}-{{$j}}").val();
                                            var inputOuA = $("#ouA{{$i}}-{{$j}}").val();
                                            alert(inputInA);
                                            alert(inputOuA);
                                            $.ajax({
                                                type: "GET",
                                                url: "save_block",
                                                data:{
                                                    inputIn:inputInA,
                                                    inputOu:inputOuA,
                                                    
                                                    val: "1",
                                                    block:"{{$j}}",
                                                    day:"{{$i}}" 
                                                },
                                                success: function (data){
                                                    $("#test").html(data);
                                                }
                                            });
        
                                        })
                                        $("#btnR{{$i}}-{{$j}}").click(function(){
                                            var inputInR = $("#inR{{$i}}-{{$j}}").val();
                                            var inputOuR = $("#ouR{{$i}}-{{$j}}").val();
        
                                            alert(inputInR);
                                            alert(inputOuR);
                                            $.ajax({
                                                type: "GET",
                                                url: "save_block",
                                                data:{
                                                    inputIn:inputInR,
                                                    inputOu:inputOuR,
                                                    
                                                    val: "2",
                                                    block:"{{$j}}",
                                                    day:"{{$i}}" 
                                                },
                                                success: function (data){
                                                    $("#test").html(data);
                                                }
                                            });
                                        })
                                    </script>
                                </div>
                            </div>
                        </td>
                    @endfor
                </tr>                
            @endfor
        </tbody>          
    </table>
</div>