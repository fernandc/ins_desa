
<div class="row" >
    <div class="col-sm-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Profesores</h5>
          <div class="table table-responsive table-bordered">
            <table class="table" id="test_t">
            <thead>
              <tr>
                <th scope="col">Nombre</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($teacherList as $item)
                    <tr>
                        <td >
                            - {{$item["nombre_personal"]}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
           </table>
            </div>
        </div>
      </div>
    </div>
    <div class="col-sm-9">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Horario</h5>
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
                                    <div class="accordion" id="accordionExample" >
                                        <div class="card"  id="card{{$i}}-{{$j}}" disabled>
                                            <div class="card-header" id="headingOne{{$i}}-{{$j}}" style="padding: .75rem .75rem;">
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
                                                                $("#headingOne{{$i}}-{{$j}}").css("background","#73c686");
                                                                $("select.form-control").attr("disabled",true);
                                                                $(this).attr("disabled",false);
                                                            }else{
                                                                $("#collapseOne{{$i}}-{{$j}}").removeClass("show");
                                                                $("#collapseTwo{{$i}}-{{$j}}").removeClass("show");
                                                                $("#headingOne{{$i}}-{{$j}}").css("background","");
                                                                $("select.form-control").attr("disabled",false);
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
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endfor
                        </tr>                
                    @endfor
                </tbody>          
            </table>
        </div>
        </div>
      </div>
    </div>
  </div>