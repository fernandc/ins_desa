<!DOCTYPE html> 

@extends("layouts.mcdn")

@section("title")
Asistencias
@endsection

@section("headex")
    <script>
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
        })
    </script>
    <style>
        .core{
            width: 30px;
            font-size: 0.8rem;
            text-transform:uppercase;
            font-weight: bold;
            display: inline;
            background-color: white !important;
        }
        .text-warning {
            color: #ff8300 !important;
        }
        .card-body nav a.nav-link:hover{
            color: #ff8300 !important
        }
    </style>
@endsection

@section("context")
    <script>
        var total_alumnos = {{count($alumnos)}};
        var cargados_alumnos = 0;
        @if(isset($_GET['curso']))
            Swal.fire({
                icon: 'info',
                title: 'Cargando',
                html: 'Alumnos: <span id="alloaded"> </span> / '+total_alumnos,
                showConfirmButton: false,
            });
        @endif
    </script>
    <ul id="contentcourses" class="nav nav-tabs my-3 justify-content-center">
        <li class="nav-item">
            <a class="nav-link text-success" data="0" href="info_assistance">HOY</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="1" href="info_assistance?curso=1">PK</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="2" href="info_assistance?curso=2">KI</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="3" href="info_assistance?curso=3">1B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="4" href="info_assistance?curso=4">2B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="5" href="info_assistance?curso=5">3B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="6" href="info_assistance?curso=6">4B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="7" href="info_assistance?curso=7">5B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="8" href="info_assistance?curso=8">6B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="9" href="info_assistance?curso=9">7B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="10" href="info_assistance?curso=10">8B</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="11" href="info_assistance?curso=11">1M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="12" href="info_assistance?curso=12">2M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="13" href="info_assistance?curso=13">3M</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data="14" href="info_assistance?curso=14">4M</a>
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
    @php
    $mes[1] = "Ene";
    $mes[2] = "Feb";
    $mes[3] = "Mar";
    $mes[4] = "Abr";
    $mes[5] = "May";
    $mes[6] = "Jun";
    $mes[7] = "Jul";
    $mes[8] = "Ago";
    $mes[9] = "Sep";
    $mes[10] = "Oct";
    $mes[11] = "Nov";
    $mes[12] = "Dic";
    $sem[1] = "Lu";
    $sem[2] = "Ma";
    $sem[3] = "Mi";
    $sem[4] = "Ju";
    $sem[5] = "Vi";
    $sem[6] = "Sá";
    $sem[0] = "Do";
    $year =  Session::get('period');
    $month = 0;
    $lastd = 0;
    if(isset($_GET["mes"])){
        $month = $_GET["mes"];
        $lastd = date("t",strtotime("$year-$month"));
    }
    $dtda = 0;
    $curso = "";
    $id_clase = "";
    $materias = [];
    $dias_contados = [];
@endphp
@foreach ($clases as $clase)
    @php
        if(isset($_GET['curso'])){
            if($clase["id_curso"] == $_GET['curso']){
                $materias[$clase["id_materia"]] = $clase["materia"];
                $curso = $clase["curso"];
                if(isset($_GET['materia'])){
                    if($clase["id_materia"] == $_GET['materia']){
                        //dd($clase);
                        $id_clase = $clase["id_clase"];
                    }
                }
            }
        }
    @endphp
@endforeach
<div class="row" style="margin: 0px;">
    @if (isset($_GET["curso"]))
        <div id="contentlist" class="col-md-12">
            <div id="content" class="card">
                <div class="card-header">
                    <div id="scrollw">
                        Asistencia de <span class='text-primary'>{{$curso}}</span> 
                        <button id="triggerHideShow" class="btn btn-info btn-sm" style="float: right;">Descargar Resumen</button>
                        <script>
                            $("#triggerHideShow").click(function(){
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Cargando',
                                    showConfirmButton: false,
                                });
                                $(".todis").hide();
                                var heightvalue = $(".table-responsive").css("height");
                                $(".table-responsive").css("height", "");
                                $("#triggerHideShow").hide();
                                setTimeout(function () {
                                    var element = document.getElementById('content');
                                    var opt = {
                                        margin:       0.5,
                                        filename:     'Asistencia.pdf',
                                        image:        { type: 'jpg', quality: 0.98 },
                                        html2canvas:  { scale: 2 },
                                        jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
                                    };
                                    html2pdf().set(opt).from(element).save();
                                }, 1000);
                                setTimeout(function () {
                                    location.reload();
                                }, 10000);
                            });
                        </script>
                    </div>
                </div>
                <div class="card-body table-responsive" style="padding: 0px;">
                    <table id="listtable" class="table table-hover table-bordered table-sm" style="font-size: 0.9rem;">
                        <thead>
                          <tr>
                            <th scope="col" style="text-align: center;">#</th>
                            <th scope="col" style="min-width: 260px">Alumnos</th>
                            <th scope="col" style="text-align: center;" data-toggle="tooltip" data-placement="top" title="Presente">Total<br>[ <span class="text-success">P</span> ]</th>
                            <th scope="col" style="text-align: center;" data-toggle="tooltip" data-placement="top" title="Atrasado">Total<br><span style="color: #0058ff;">A</span></th>
                            <th scope="col" style="text-align: center;" data-toggle="tooltip" data-placement="top" title="Retirado">Total<br><span style="color: darkorange;">R</span></th>
                            <th scope="col" style="text-align: center;" data-toggle="tooltip" data-placement="top" title="Sin Camara">Total<br><span style="color: #0058ff;">S</span></th>
                            <th scope="col" style="text-align: center;" data-toggle="tooltip" data-placement="top" title="Eximido">Total<br>E</th>
                            <th scope="col" style="text-align: center;" data-toggle="tooltip" data-placement="top" title="Ausente">Total<br><span style="color: red;">1</span></th>
                            <th scope="col" style="text-align: center;" data-toggle="tooltip" data-placement="top" title="Justificado">Total<br><span style="color: #ea00ea;">J</span></th>
                            <th scope="col" style="text-align: center;min-width: 120px">Total<br>Asistencia</th>
                            <th scope="col" style="text-align: center;">Total<br>Inasistencia</th>
                            <th scope="col" style="text-align: center;">% Asistido</th>
                                @foreach ($dias_activos as $horario)
                                    @php
                                        $dias_contados[$dtda]["bloq"] = $horario["id_bloq"];
                                        $dias_contados[$dtda]["date"] = $horario["date_day"];
                                        $dtda++;
                                        $type = "";
                                        $idc = $horario["id_materia"];
                                        if($idc == "20009" || $idc == "14" || $idc == "9200" || $idc == "20000" || $idc == "20001" || $idc == "11224" || $idc == "4487" || $idc == "27"){$type = '<a href="#" class="badge badge-danger" style="background-color: red;">LEN </a>';}
                                        if($idc == "288"){$type = '<a href="#" class="badge badge-danger" style="background-color: #e597fb;">MUS </a>';}
                                        if($idc == "20010" || $idc == "5" || $idc == "9201" || $idc == "6616" || $idc == "2972"){$type = '<a href="#" class="badge badge-primary">MAT </a>';}
                                        if($idc == "249"){$type = '<a href="#" class="badge badge-light" style="background-color: #ffe300;">ING </a>';}
                                        if($idc == "28"){$type = '<a href="#" class="badge badge-primary" style="background-color: #ff57b6;">ART </a>';}
                                        if( $idc == "517"){$type = '<a href="#" class="badge badge-primary" style="background-color: #8b4fbd;">TEC </a>';}
                                        if($idc == "20013" || $idc == "6" || $idc == "20003" || $idc == "4474"){$type = '<a href="#" class="badge badge-primary" style="background-color: #00c61f;">CIE </a>';}
                                        if($idc == "9845" || $idc == "20005" ){$type = '<a href="#" class="badge badge-light" style="background-color: aqua;">DEP </a>';}
                                        if($idc == "20004"){$type = '<a href="#" class="badge badge-light" style="background-color: #ffdac4;">DEP </a>';}
                                        if($idc == "22"){$type = '<a href="#" class="badge badge-light" style="background-color: #f4d3c6;">ORI </a>';}
                                        if($idc == "474"){$type = '<a href="#" class="badge badge-light" style="background-color: #f4d3c6;">ETI </a>';}
                                        if($idc == "20012" || $idc == "2280" || $idc == "20002" || $idc == "2971"){$type = '<a href="#" class="badge badge-primary" style="background-color: #ec9422;">HIS </a>';}
                                        if($idc == "999"){$type = '<a href="#" class="badge badge-primary" style="background-color: #a8a8a8;">PSY </a>';}
                                        if($idc == "1493"){$type = '<a href="#" class="badge badge-primary" style="background-color: #006166;">PRO </a>';}
                                    @endphp
                                    <th class="todis" scope="col" style="min-width: 40px;text-align: center">
                                        {{$mes[intval(substr($horario["date_day"],5,2))]}}
                                        <hr style="margin: 0px">
                                        <span class="text-secondary">{{$sem[date('w',strtotime($horario["date_day"]))]}}</span>
                                        <br>
                                        <span class="text-secondary">{{intval(substr($horario["date_day"],8))}}</span>
                                        <br>
                                        {!!$type!!}
                                        <div style="font-weight: lighter;">
                                            {{substr($horario["hora_inicio"],0,5)}}<br>|<br>{{substr($horario["hora_fin"],0,5)}}
                                        </div>
                                    </th>
                                @endforeach
                          </tr>
                        </thead>
                        <tbody>
                            @php
                                $nrolista = 1;
                            @endphp
                            @foreach ($alumnos as $alumno)
                                @php
                                    $pre = $dtda;
                                @endphp
                                <tr>
                                    <th scope="row" style="text-align: center;">{{$nrolista++}}</th>
                                    <th>{{$alumno["nombre_stu"]}}</th>
                                    <th style="text-align: center;">
                                        <span id="typeP{{$alumno["id_stu"]}}" class="badge badge-info">{{$pre}}</span>
                                    </th>
                                    <th style="text-align: center;">
                                        <span id="typeA{{$alumno["id_stu"]}}" class="badge badge-light">0</span>
                                    </th>
                                    <th style="text-align: center;">
                                        <span id="typeR{{$alumno["id_stu"]}}" class="badge badge-light">0</span>
                                    </th>
                                    <th style="text-align: center;">
                                        <span id="typeS{{$alumno["id_stu"]}}" class="badge badge-light">0</span>
                                    </th>
                                    <th style="text-align: center;">
                                        <span id="typeE{{$alumno["id_stu"]}}" class="badge badge-light">0</span>
                                    </th>
                                    <th style="text-align: center;">
                                        <span id="typeX{{$alumno["id_stu"]}}" class="badge badge-light ">0</span>
                                    </th>
                                    <th style="text-align: center;">
                                        <span id="typeJ{{$alumno["id_stu"]}}" class="badge badge-light">0</span>
                                    </th>
                                    <th style="text-align: center;">
                                        <span id="typeIN{{$alumno["id_stu"]}}" class="badge badge-success">0</span> de <span class="badge badge-light">{{$pre}}</span>
                                    </th>
                                    <th style="text-align: center;">
                                        <span id="typeINA{{$alumno["id_stu"]}}" class="badge badge-light">0</span>
                                    </th>
                                    <th style="text-align: center;" >
                                        <span id="typePER{{$alumno["id_stu"]}}" >0%</span>
                                    </th>
                                    @foreach ($dias_activos as $horario)
                                        <th class="todis" style="text-align: center;">
                                            <div id="tooltip{{$alumno["id_stu"]}}-class{{$horario["id_class"]}}-bloq{{$horario["id_bloq"]}}-date{{$horario["date_day"]}}">
                                                <span id="input-stu{{$alumno["id_stu"]}}-class{{$horario["id_class"]}}-bloq{{$horario["id_bloq"]}}-date{{$horario["date_day"]}}" class="core" > </span>
                                            </div>
                                        </th>
                                    @endforeach
                                </tr>
                                <script>
                                    $("#alloaded").html({{$nrolista}}-1);
                                </script>
                            @endforeach
                        </tbody>
                      </table>
                      
                </div>
                
                <script>
                    $(document).ready(function(){
                        //LIST CURRENT ASSISTANCES
                        var item = "";
                        function throwData(item){
                            console.log(item);
                            var currentNum = 0;
                            if(item.type_a == "J"){
                                $("#input-stu"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).css("color","#ea00ea");
                                if($("#input-stu"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).length != 0) {
                                    currentNum = $("#typeJ"+item.id_student).html();
                                    currentNum++;
                                    $("#typeJ"+item.id_student).removeClass("badge-light");
                                    $("#typeJ"+item.id_student).addClass("badge-warning");
                                    $("#typeJ"+item.id_student).html(currentNum);
                                }
                            }
                            else if(item.type_a == "S"){
                                $("#input-stu"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).css("color","#0058ff");
                                if($("#input-stu"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).length != 0) {
                                    currentNum = $("#typeS"+item.id_student).html();
                                    currentNum++;
                                    $("#typeS"+item.id_student).removeClass("badge-light");
                                    $("#typeS"+item.id_student).addClass("badge-info");
                                    $("#typeS"+item.id_student).html(currentNum);
                                }
                            }
                            else if(item.type_a == "A"){
                                $("#input-stu"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).css("color","#0058ff");
                                if($("#input-stu"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).length != 0) {
                                    currentNum = $("#typeS"+item.id_student).html();
                                    currentNum++;
                                    $("#typeA"+item.id_student).removeClass("badge-light");
                                    $("#typeA"+item.id_student).addClass("badge-info");
                                    $("#typeA"+item.id_student).html(currentNum);
                                }
                            }
                            else if(item.type_a == "1"){
                                $("#input-stu"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).css("color","red");
                                if($("#input-stu"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).length != 0) {
                                    currentNum = $("#typeX"+item.id_student).html();
                                    currentNum++;
                                    $("#typeX"+item.id_student).removeClass("badge-light");
                                    $("#typeX"+item.id_student).addClass("badge-warning");
                                    $("#typeX"+item.id_student).html(currentNum);
                                }
                            }
                            else if(item.type_a == "R"){
                                $("#input-stu"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).css("color","darkorange");
                                if($("#input-stu"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).length != 0) {
                                    currentNum = $("#typeR"+item.id_student).html();
                                    currentNum++;
                                    $("#typeR"+item.id_student).removeClass("badge-light");
                                    $("#typeR"+item.id_student).addClass("badge-info");
                                    $("#typeR"+item.id_student).html(currentNum);
                                }
                            }
                            else if(item.type_a == "E"){
                                $("#input-stu"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).css("color","black");
                                if($("#input-stu"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).length != 0) {
                                    currentNum = $("#typeE"+item.id_student).html();
                                    currentNum++;
                                    $("#typeE"+item.id_student).removeClass("badge-light");
                                    $("#typeE"+item.id_student).addClass("badge-info");
                                    $("#typeE"+item.id_student).html(currentNum);
                                }
                            }
                            $("#input-stu"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).html(item.type_a);
                            //
                            if(item.type_a == "J" || item.type_a == "A" || item.type_a == "R"){
                                $("#tooltip"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).attr("data-toggle","tooltip");
                                $("#tooltip"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).attr("data-placement","top");
                                $("#tooltip"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).attr("title",item.justify);
                            }
                            if(item.type_a == "S"){
                                $("#tooltip"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).attr("data-toggle","tooltip");
                                $("#tooltip"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).attr("data-placement","top");
                                $("#tooltip"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).attr("title","Sin Cámara");
                            }
                            if(item.type_a == "E"){
                                $("#tooltip"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).attr("data-toggle","tooltip");
                                $("#tooltip"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).attr("data-placement","top");
                                $("#tooltip"+item.id_student+"-class"+item.id_class+"-bloq"+item.id_bloq+"-date"+item.assistance).attr("title","Eximido");
                            }
                            var totTA = parseInt($("#typeA"+item.id_student).html(),10);
                            var totTR = parseInt($("#typeR"+item.id_student).html(),10);
                            var totTS = parseInt($("#typeS"+item.id_student).html(),10);
                            var totTE = parseInt($("#typeE"+item.id_student).html(),10);
                            var totTX = parseInt($("#typeX"+item.id_student).html(),10);
                            var totTJ = parseInt($("#typeJ"+item.id_student).html(),10);
                            $("#typeP"+item.id_student).html({{$pre}}-totTA-totTR-totTS-totTE-totTX-totTJ);
                            var totTP = parseInt($("#typeP"+item.id_student).html(),10);
                            $("#typeIN"+item.id_student).html(totTP+totTA+totTR+totTS+totTE);
                            $("#typeINA"+item.id_student).html(totTX+totTJ);
                            if($("#typeINA"+item.id_student).html() != "0"){
                                $("#typeINA"+item.id_student).removeClass("badge-light");
                                $("#typeINA"+item.id_student).addClass("badge-danger");
                            }
                            var percent = (((totTP+totTA+totTR+totTS+totTE))*100)/{{$pre}};
                            $("#typePER"+item.id_student).html(percent.toFixed(2)+"%");
                            $("#typePER"+item.id_student).removeClass("badge");
                            $("#typePER"+item.id_student).removeClass("badge-primary");
                            $("#typePER"+item.id_student).removeClass("text-primary");
                            $("#typePER"+item.id_student).removeClass("text-warning");
                            $("#typePER"+item.id_student).removeClass("text-danger");
                            var totPER = parseInt($("#typePER"+item.id_student).html(),10);
                            if(totPER == 100){
                                $("#typePER"+item.id_student).addClass("badge");
                                $("#typePER"+item.id_student).addClass("badge-primary");
                            }else if(totPER >=90){
                                $("#typePER"+item.id_student).addClass("text-primary");
                            }else if(totPER >=85){
                                $("#typePER"+item.id_student).addClass("text-warning");
                            }else{
                                $("#typePER"+item.id_student).addClass("text-danger");
                            }
                            if(cargados_alumnos == total_alumnos){
                                $(function () {
                                    $('[data-toggle="tooltip"]').tooltip()
                                });
                                Toast.fire({
                    
                                    icon: 'success',
                                    title: 'Completado'
                                });
                            }
                        }
                        $('.table-responsive').height(function(index, height) {
                            let rest = window.innerHeight - $(this).offset().top;
                            return rest -1 ;
                        });
                        @foreach($assistance as $rowA)
                            @php
                            $json = json_encode($rowA);
                            @endphp
                            item = JSON.parse(`{!! $json !!}`);
                            cargados_alumnos++;
                            throwData(item);
                        @endforeach
                    });
                </script>
            </div>
        </div>
    @else
        <div class="container">
            
        </div>
    @endif
</div>
@endsection