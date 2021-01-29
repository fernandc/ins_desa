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
<script>
    @php
        $colorEnviados = "rgb(25, 128, 209 )";
        $colorLeidos = "rgb(86, 203, 31)";
    @endphp
    var enviados;
    var env_year = 0;
    var env_month = 0;
    var cont_y = 0;
    var cont_m = 0;
    var c_date = new Date();
    var c_month = c_date.getMonth()+1;
    var contTypeM1 = 0,contTypeM2 = 0,contTypeM3 = 0,contTypeM4 = 0;
    var contM1 = [0,0],contM2 = [0,0],contM3 = [0,0],contM4 = [0,0],contM5 = [0,0],contM6 = [0,0],contM7 = [0,0],contM8 = [0,0],contM9 = [0,0],contM10 = [0,0],contM11 = [0,0],contM12 = [0,0];
    var tipo = "";
    //var year = "", month = "";
    @foreach($info_mails as $datos)
        @if(isset($datos["fecha_para"]))
            enviados = "{{$datos["fecha_para"]}}";
            enviados = enviados.split("-");
            var year = enviados[0];
            if(year == {{Session::get('period')}}){
                cont_y++;
                let month = enviados[1];
                month = parseInt(month);
                if(month == c_month){
                    console.log("entró 4");
                    cont_m++;
                    @if(isset($datos["tipo_mail"]))
                        tipo = "{{$datos["tipo_mail"]}}";
                        if(tipo == 1){
                            contTypeM1++;
                        }
                        else if(tipo == 2){
                            contTypeM2++;
                        }
                        else if(tipo == 3){
                            contTypeM3++;
                        }
                        else if(tipo == 4){
                            contTypeM4++;
                        }
                    @endif

                }
                if(month == 1){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM1[0] = contM1[0] + num;}
                else if(month == 2){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM2[0] = contM2[0] + num;}
                else if(month == 3){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM3[0] = contM3[0] + num;}
                else if(month == 4){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM4[0] = contM4[0] + num;}
                else if(month == 5){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM5[0] = contM5[0] + num;}
                else if(month == 6){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM6[0] = contM6[0] + num;}
                else if(month == 7){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM7[0] = contM7[0] + num;}
                else if(month == 8){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM8[0] = contM8[0] + num;}
                else if(month == 9){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM9[0] = contM9[0] + num;}
                else if(month == 10){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM10[0] = contM10[0] + num;}
                else if(month == 11){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM11[0] = contM11[0] + num;}
                else if(month == 12){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM12[0] = contM12[0] + num;}
            }
        @else
            enviados = "{{$datos["fecha_emision"]}}";
            enviados = enviados.split("-");
            var year = enviados[0];
            if(year == {{Session::get('period')}}){
                cont_y++;
                let month = enviados[1];
                month = parseInt(month);
                if(month == c_month){
                    cont_m++;
                    @if(isset($datos["tipo_mail"]))
                        tipo = "{{$datos["tipo_mail"]}}";
                        if(tipo == 1){
                            contTypeM1++;
                        }
                        else if(tipo == 2){
                            contTypeM2++;
                        }
                        else if(tipo == 3){
                            contTypeM3++;
                        }
                        else if(tipo == 4){
                            contTypeM4++;
                        }
                    @endif
                }
                if(month == 1){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM1[0] = contM1[0] + num;contM1[1] = contM1[1] + num2;}
                else if(month == 2){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM2[0] = contM2[0] + num;contM2[1] = contM2[1] + num2;}
                else if(month == 3){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM3[0] = contM3[0] + num;contM3[1] = contM3[1] + num2;}
                else if(month == 4){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM4[0] = contM4[0] + num;contM4[1] = contM4[1] + num2;}
                else if(month == 5){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM5[0] = contM5[0] + num;contM5[1] = contM5[1] + num2;}
                else if(month == 6){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM6[0] = contM6[0] + num;contM6[1] = contM6[1] + num2;}
                else if(month == 7){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM7[0] = contM7[0] + num;contM7[1] = contM7[1] + num2;}
                else if(month == 8){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM8[0] = contM8[0] + num;contM8[1] = contM8[1] + num2;}
                else if(month == 9){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM9[0] = contM9[0] + num;contM9[1] = contM9[1] + num2;}
                else if(month == 10){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM10[0] = contM10[0] + num;contM10[1] = contM10[1] + num2;}
                else if(month == 11){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM11[0] = contM11[0] + num;contM11[1] = contM11[1] + num2;}
                else if(month == 12){let num ="{{$datos["destinatarios"]}}";let num2 ="{{$datos["leidos"]}}";num = parseInt(num);num2 = parseInt(num2);contM12[0] = contM12[0] + num;contM12[1] = contM12[1] + num2;}
            }
        @endif
    @endforeach
    console.log(contM1)
    var tipos = [contTypeM1,contTypeM2,contTypeM3,contTypeM4];
    var envMes = [contM1,contM2,contM3,contM4,contM5,contM6,contM7,contM8,contM9,contM10,contM11,contM12]
    console.log(tipos);
    var enviados_Y_M = [];
    env_year = cont_y;
    env_month = cont_m;
    enviados_Y_M.push(env_year);
    enviados_Y_M.push(env_month);
</script>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
    </head>

    <body>
        <hr>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5 style="text-align: center">Correos Enviados Este Més </h5>
                    <hr>
                    <canvas id="myChart1" width="200px" height="200px"></canvas>    
                </div>                              
                <div class="col-md-8">
                    <h5 style="text-align: center">Correos Enviados y Leídos Periodo 
                        @if(Session::has('period'))
                            {{Session::get('period')}}
                        @endif
                    </h5>
                    <hr>
                    <canvas id="myChart2" width="auto" height="auto"></canvas>    
                </div>                              
            </div>
        </div>
    </body>
    <script>
        var ctx= document.getElementById("myChart1").getContext("2d");
        var myChart= new Chart(ctx,{
            type:"doughnut",
            data:{
                labels:['Generál' , 'Informativo','Buenas Noticias', 'Malas Noticias'],
                datasets:[{
                    label: 'Correos Enviados',
                    //
                    data:[tipos[0],tipos[1],tipos[2],tipos[3]],
                    backgroundColor:[
                        "rgb(0, 123, 255)",
                        "rgb(40, 167, 69)",
                        "rgb(23, 162, 184)",
                        "rgb(224, 82, 96)"
                    ]
                }]
            },
        });
    </script>

    <script>
        var ctx= document.getElementById("myChart2").getContext("2d");
        var myChart= new Chart(ctx,{
            type:"bar",
            data:{
                labels:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Juilo','Agosto','Septiembre','Noviembre','Diciembre'],
                datasets:[{
                    label: 'Correos Enviados',
                    data:[envMes[0][0],envMes[1][0],envMes[2][0],envMes[3][0],envMes[4][0],envMes[5][0],envMes[6][0],envMes[7][0],envMes[8][0],envMes[9][0],envMes[10][0],envMes[11][0]],
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
                        data:[envMes[0][1],envMes[1][1],envMes[2][1],envMes[3][1],envMes[4][1],envMes[5][1],envMes[6][1],envMes[7][1],envMes[8][1],envMes[9][1],envMes[10][1],envMes[11][1]],
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
