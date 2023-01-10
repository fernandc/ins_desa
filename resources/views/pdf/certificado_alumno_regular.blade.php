<html>
    <head>
        <title>Certificado Alumno Regular</title>
    </head>
    <body style="color: royalblue;">
        <div style="text-align: center;">
          <table>
            <tr>
              <td style="width: 234px"></td>
              <td style="width: 234px"><img src="data:image/png;base64, <?php echo base64_encode(file_get_contents(getenv("API_ENDPOINT").'public/scc_logo.png')); ?>" style="height: 250px;"></td>
              <td style="width: 234px; text-align:right;">
                @php setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish'); echo ucfirst(iconv('ISO-8859-2', 'UTF-8', strftime("%A, %d de %B de %Y", strtotime(date("Y-m-d"))))); @endphp
                <hr>
                <img src="data:image/png;base64, <?php echo base64_encode(file_get_contents('https://api.qrserver.com/v1/create-qr-code/?data='.$endpoint)); ?>" style="height: 112px;">
                <br>
                <span style="font-size: 13px;color: navy">Validar Documento</span>
                <br>
                Código:
                <br>
                <span style="font-size: 13px;color: navy">{{$codigo}}</span>
              </td>
            </tr>
          </table>
        </div>
        <div style="text-align: center;">
          <h2 >CERTIFICADO DE ALUMNO REGULAR</h2>
        </div>
        <div style="font-size: 20px;">
          <p>
            <b>Saint Charles College</b>, emite el presente certificado a:
            <br>
            <span style="color: navy">{{$nombre_stu}}</span>
            RUT: <span style="color: navy">{{$dni_stu}}</span>
          </p>
          <p>
            alumno(a) regular de SAINT CHARLES COLLEGE; RBD 25.382-0, colegio
            <br>
            con Jornada Escolar Completa , quien está matriculado(a) para el año escolar <span style="color: navy">{{$para_periodo}}</span>, en el curso <span style="color: navy">{{$curso}}</span>
          </p>
          Se extiende el siguiente certificado para fines que el portador 
          estime conveniente.
          <br>
          Santiago, @php setlocale(LC_ALL, "es_ES", 'Spanish_Spain', 'Spanish'); echo iconv('ISO-8859-2', 'UTF-8', strftime("%A, %d de %B de %Y", strtotime(date("Y-m-d")))); @endphp
        </div>
        <div class="footer" style="position: fixed; bottom: 260px; left: 0px; right: 0px;height: 50px;line-height: 35px;">
          <div style="text-align: right; margin-bottom: 4rem;" >
            <img src="data:image/png;base64, <?php echo base64_encode(file_get_contents(getenv("API_ENDPOINT").'public/scc_firma2.png')); ?>" style="height: 150px;">
          </div>
          <div style="line-height: 100%;">
            Saint Charles College esta reconocido oficialmente por el Ministerio de Educación de la Republica de chile según Res. Rec. Oficial/Doc. Traspaso Nº 1813 del año  2002, rol Base de Datos 25382-0 .
          </div>
          <hr>
          <table style="width: 100%; font-size:0.9rem">
            <tr>
              <th style="text-align: left;">Pedro Donoso 8743</th>
              <th style="text-align: center;">La Florida</th>
              <th style="text-align: right;">Teléfono 2 2281 01 42</th>
            </tr>
          </table>
        </div>
    </body>
</html>