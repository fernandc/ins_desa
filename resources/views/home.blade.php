<!DOCTYPE html> 


@extends("layouts.mcdn")
@section("title")
Inicio
@endsection

@section("headex")
<script src='https://cdn.plot.ly/plotly-latest.min.js'></script>
@endsection

@section("context")
<!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Correos Enviados Periodo 
                        @if(Session::has('period'))
                            {{Session::get('period')}}
                        @endif
                    </h5>
                    <canvas id="myChart1" width="200px" height="200px"></canvas>    
                </div>                              
                <div class="col-md-8">
                    <h5>Correos Enviados y Leídos</h5>
                    <canvas id="myChart2" width="auto" height="auto"></canvas>    
                </div>                              
            </div>
        </div>
    </body>
    <script>
        @php
            $enviados_año_and_mes = [];
        @endphp
        var enviados;
        var env_year = 0;
        var env_month = 0;
        var cont_y = 0;
        var cont_m = 0;
        var c_date = new Date();
        var c_month = c_date.getMonth()+1
        @foreach($info_mails as $datos)
            @if(isset($datos["fecha_emision"]))
                enviados = "{{$datos["fecha_emision"]}}";
                enviados = enviados.split("-");
                var year = enviados[0];
                if(year == {{Session::get('period')}}){
                    cont_y++;
                    var month = enviados[1];
                    month = parseInt(month);
                    if(month == c_month){
                        cont_m++;
                    }
                }
            @endif
        @endforeach
        var enviados_Y_M = [];
        env_month = cont_m;
        env_year = cont_y;
        enviados_Y_M.push(env_year);
        enviados_Y_M.push(env_month);
        var ctx= document.getElementById("myChart1").getContext("2d");
        var myChart= new Chart(ctx,{
            type:"doughnut",
            data:{
                labels:['Enviados este año' , 'Enviados este més'],
                datasets:[{
                    label: 'Correos Enviados',
                    data:[enviados_Y_M[0],enviados_Y_M[1]],
                    backgroundColor:[
                        "rgb(227, 29, 19, 0.5)",
                        "rgb(22, 19, 227, 0.5)"
                    ]
                }]
            },
        });
    </script>
    <script>
        @php
            $meses_correos_enviados = [1,2,1,2,3,3,4,4,5,5,6,6];
            $meses_correos_leidos = [1,2,1,2,3,3,4,4,5,5,6,6];
            $colorEnviados = "rgb(25, 128, 209 )";
            $colorLeidos = "rgb(86, 203, 31)";
        @endphp
        var ctx= document.getElementById("myChart2").getContext("2d");
        var myChart= new Chart(ctx,{
            type:"bar",
            data:{
                labels:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Juilo','Agosto','Septiembre','Noviembre','Diciembre'],
                datasets:[{
                    label: 'Correos Enviados',
                    data:[
                        @foreach($meses_correos_enviados as $mes)
                            {{$mes}},
                        @endforeach
                    ],
                    backgroundColor:[
                        "{{$colorEnviados}}",                    
                        "{{$colorEnviados}}",                    
                        "{{$colorEnviados}}",                    
                        "{{$colorEnviados}}",                    
                        "{{$colorEnviados}}",                    
                        "{{$colorEnviados}}",                    
                        "{{$colorEnviados}}",                    
                        "{{$colorEnviados}}",                    
                        "{{$colorEnviados}}",                    
                        "{{$colorEnviados}}",                    
                        "{{$colorEnviados}}",                    
                        "{{$colorEnviados}}"                    
                    ]
                },{
                    label: 'Correos Leídos',
                        data:[
                            @foreach($meses_correos_leidos as $mes)
                                {{$mes}},
                            @endforeach
                        ],
                        backgroundColor:[
                            "{{$colorLeidos}}",
                            "{{$colorLeidos}}",
                            "{{$colorLeidos}}",
                            "{{$colorLeidos}}",
                            "{{$colorLeidos}}",
                            "{{$colorLeidos}}",
                            "{{$colorLeidos}}",
                            "{{$colorLeidos}}",
                            "{{$colorLeidos}}",
                            "{{$colorLeidos}}",
                            "{{$colorLeidos}}",
                            "{{$colorLeidos}}"
                        ]
                }],

            },

            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</html>

@endsection
