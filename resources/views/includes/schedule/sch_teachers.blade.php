
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
                                            <div class="card-header" id="headingOneT{{$i}}-{{$j}}" style="padding: .75rem .75rem;">
                                                <h2 class="mb-0">
                                                    <select class="form-control form-control-sm" id="selT{{$i}}-{{$j}}">
                                                        <option selected>
                                                            SELECCIONE
                                                        </option>
                                                        <option value="1" id="opt2T">
                                                            
                                                        </option>
                                                    </select>
                                                    <button class="btn btn-link collapsed" id="optbtn1T{{$i}}-{{$j}}" hidden  type="button" data-toggle="collapse" data-target="#collapseOne{{$i}}-{{$j}}" aria-expanded="true" aria-controls="collapseOne{{$i}}-{{$j}}">
                                                        Bloque {{$cont}} 
                                                    </button>
                                                    <button class="btn btn-link collapsed" id="optbtn2{{$i}}-{{$j}}" hidden type="button" data-toggle="collapse" data-target="#collapseTwo{{$i}}-{{$j}}" aria-expanded="true" aria-controls="collapseTwo{{$i}}-{{$j}}">
                                                        Receso {{$cont}} 
                                                    </button>
                                                    <script>
                                                        $("#selT{{$i}}-{{$j}}").change(function(){
                                                            var opt = $(this).val();
                                                            if(opt == 1){
                                                                $("#optbtn1T{{$i}}-{{$j}}").click(); 
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
                                            <div id="collapseOneT{{$i}}-{{$j}}" class="collapse" aria-labelledby="headingOne{{$i}}-{{$j}}" >
                                                <div class="card-body text-white mb-3" style="background:#73c686">
                                                    <label for="">Desde</label>
                                                    <input class="form-control" type="time" name="in1" id="inAt{{$i}}-{{$j}}">
                                                    <br>
                                                    <label for="">Hasta</label>
                                                    <input class="form-control" type="time" name="out1" id="ouAt{{$i}}-{{$j}}">
                                                </div>
                                            </div>
                        
                                        </div>
                                    </div>
                                    <div style="text-align: center;font-size: 0.9rem;">
                                        <span id="badgeint{{$i}}-{{$j}}" class="badge badge-light"></span>-<span id="badgeout{{$i}}-{{$j}}" class="badge badge-light"></span>
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

  <script>
    function selected_squared(day,bloq,hin,hout,type) { 
        if(type == 1){
                $("#headingOneT"+day+"-"+bloq).css("background","#73c686");
            }else{
                $("#headingOneT"+day+"-"+bloq).css("background","#6fc5d3");
            }
            $("#selT"+day+"-"+bloq+" option[value="+type+"]").prop('selected', true);
            $("#badgeint"+day+"-"+bloq).html(hin);
            $("#badgeout"+day+"-"+bloq).html(hout);
        }
    $( document ).ready(function() {
        @foreach ($sched_course_t as $row)
            @php
                $cday = $row["day"];
                $cbloq = $row["bloq"];
                $chour_in = $row["hour_in"];
                $chour_out = $row["hour_out"];
                $ctype = $row["type"];
            @endphp
            
            selected_squared({{$cday}},{{$cbloq}},"{{$chour_in}}","{{$chour_out}}",{{$ctype}});
        @endforeach
    });
</script>