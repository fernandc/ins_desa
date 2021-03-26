<!DOCTYPE html> 


@extends("layouts.mcdn")
@section("title")
Inicio
@endsection

@section("headex")
<script>
    Chart.pluginService.register({
        beforeDraw: function (chart) {
            if (chart.config.options.elements.center) {
        //Get ctx from string
        var ctx = chart.chart.ctx;
        
        //Get options from the center object in options
        var centerConfig = chart.config.options.elements.center;
          var fontStyle = centerConfig.fontStyle || 'Arial';
                var txt = centerConfig.text;
        var color = centerConfig.color || '#000';
        var sidePadding = centerConfig.sidePadding || 20;
        var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2)
        //Start with a base font of 30px
        ctx.font = "30px " + fontStyle;
        
        //Get the width of the string and also the width of the element minus 10 to give it 5px side padding
        var stringWidth = ctx.measureText(txt).width;
        var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

        // Find out how much the font can grow in width.
        var widthRatio = elementWidth / stringWidth;
        var newFontSize = Math.floor(30 * widthRatio);
        var elementHeight = (chart.innerRadius * 2);

        // Pick a new font size so it will not be larger than the height of label.
        var fontSizeToUse = Math.min(newFontSize, elementHeight);

        //Set font settings to draw it correctly.
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
        var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
        ctx.font = fontSizeToUse+"px " + fontStyle;
        ctx.fillStyle = color;
        
        //Draw text in center
        ctx.fillText(txt, centerX, centerY);
            }
        }
    });
</script>
@endsection

@section("context")

<!DOCTYPE html>
<script>
    @php
        $colorEnviados = "rgb(25, 128, 209 )";
        $colorLeidos = "rgb(121, 223, 73)";
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
    //Last
    var last_12_names = [];
    var last_12_total_send = [];
    var last_12_total_sended = [];
    var last_12_total_read = [];
    //var year = "", month = "";
	@if(isset($info_mails))
        @php $contador = 0; @endphp
		@foreach($info_mails as $datos)
            @php $contador++; @endphp
			@if(Session::get("account")["is_admin"] == "YES" || $datos["dni_staff"] == Session::get("account")["dni"])
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
				@else
					enviados = "{{$datos["fecha_emision"]}}";
                    if({{$contador}} <= 4){
                        last_12_names.push("{{$datos["titulo"]}}");
                        last_12_total_send.push("{{$datos["destinatarios"]}}");
                        last_12_total_sended.push("{{$datos["enviados"]}}");
                        last_12_total_read.push("{{$datos["leidos"]}}");
                    }
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
			@endif
		@endforeach
	@endif
    var tipos = [contTypeM1,contTypeM2,contTypeM3,contTypeM4];
    var envMes = [contM1,contM2,contM3,contM4,contM5,contM6,contM7,contM8,contM9,contM10,contM11,contM12]
    var enviados_Y_M = [];
    env_year = cont_y;
    env_month = cont_m;
    enviados_Y_M.push(env_year);
    enviados_Y_M.push(env_month);
</script>

<div class="container">
    <div class="row">
        
        <div class="col-md-12">
            <hr>
            <h5>Últimos 4 correos Enviados</h5> 
        </div>
        @for ($i = 0; $i < 4; $i++)
            <div class="col-md-3" style="height: 100%;">
                <canvas id="chart{{$i}}" width="auto" height="280"></canvas>
                <hr>
            </div>
            <script>
                var leidos = parseInt(last_12_total_read[{{$i}}]);
                var enviados = parseInt(last_12_total_sended[{{$i}}]) - leidos;
                var total = parseInt(last_12_total_send[{{$i}}]) - enviados - leidos;
                var failChartData = {
                    type: 'pie',
                    data: {
                    labels: ["Leídos","Enviados","Por Enviar"],
                    datasets: [
                            {
                                data: [leidos,enviados,total],
                                backgroundColor: [
                                    "#79df49",
                                    "#1980d1",
                                    "#ededed"
                                ],
                                //hoverBackgroundColor: [
                                //    "#ff2e2e",
                                //    "#ededed",
                                //],
                                //hoverBorderColor: ["#666666","#666666"]
                            }
                        ]
                    },
                    options: {
                        elements: {
                            center: {
                                display: true,
                                text: "Total "+last_12_total_send[{{$i}}],
                                color: '#666666', // Default is #000000
                                fontStyle: 'Arial', // Default is Arial
                                sidePadding: 20 // Defualt is 20 (as a percentage)
                            }
                        },
                        title: {
                            display: true,
                            text: last_12_names[{{$i}}],
                            fontSize: 12,
                            position: 'top',
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            enabled: true
                        },
                        cutoutPercentage: 65,
                    }
                }
                var canvasFail = document.getElementById('chart{{$i}}');
                var failsChart = new Chart(canvasFail, failChartData);
            </script>
        @endfor
    </div>
</div>


@endsection
