<?php
$periodenable = 'disabled';
if(Session::has('period')){
    if(Session::get('period') != null){
        $periodenable = '';
    }
}
?>
<html>
    <head>
        <title>@yield("title")</title>
        <meta charset="UTF-8"/>
        <!--CDN-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--DATATABLES-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css" integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ==" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.jqueryui.min.css" integrity="sha512-x2AeaPQ8YOMtmWeicVYULhggwMf73vuodGL7GwzRyrPDjOUSABKU7Rw9c3WNFRua9/BvX/ED1IK3VTSsISF6TQ==" crossorigin="anonymous" />	
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-html5-1.6.1/b-print-1.6.1/datatables.min.js"></script>
        <!--CHART JS-->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <!--DATE BEET-->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <!--ACE-->
        <script src="https://pagecdn.io/lib/ace/1.4.6/ace.js" integrity="sha256-CVkji/u32aj2TeC+D13f7scFSIfphw2pmu4LaKWMSY8=" crossorigin="anonymous"></script>
        <!-- animista js -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.css" integrity="sha256-a2tobsqlbgLsWs7ZVUGgP5IvWZsx8bTNQpzsqCSm5mk=" crossorigin="anonymous" />
        <!-- sweet alert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <!-- Animate -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
        <!-- PDF Reader -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfobject/2.1.1/pdfobject.js" integrity="sha256-vZy89JbbMLTO6cMnTZgZKvZ+h4EFdvPFupTQGyiVYZg=" crossorigin="anonymous"></script>
        <!-- HTML2PDF -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js" integrity="sha512-pdCVFUWsxl1A4g0uV6fyJ3nrnTGeWnZN2Tl/56j45UvZ1OMdm9CIbctuIHj+yBIRTUUyv6I9+OivXj4i0LPEYA==" crossorigin="anonymous"></script>
        <!--DRAGULA-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.css" integrity="sha256-EYSmiSz2daAX5Xq+m8lxGFf+qWABUgdCPUvU5X0vpI4=" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.js" integrity="sha256-rVf3H94DblhP4Z6wLSa2mpMwRS5qePBWykE6QWPOaO0=" crossorigin="anonymous"></script>
        <!--jquery.basictable-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.basictable/1.0.9/basictable.css" integrity="sha512-9dSIGfHfnJRuJT/m92iHPvFT2ZTzVwzhG/nNyqUDA+tXCro39TX70VgRJ5O2bD64nywyiTUWtSG1JthOfjUV2w==" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.basictable/1.0.9/jquery.basictable.js" integrity="sha512-nWpIKXCKNcC4VHVCWrWEUdaolGZTe84yIp10hGHjME3g9gBlhJzpPNRKWHUTilZ3zbcPQptz20DDNb+W4aXuWA==" crossorigin="anonymous"></script>
        @yield("headex")
    </head>
    <body style="background-color: white">
        @php
            $privileges = array();
            $array_privs = Session::get("privileges");
            foreach ($array_privs as $row) {
                array_push($privileges,$row["id_privilege"]);
            }
            if (Session::get('account')["is_admin"]=="YES") {
                for ($i=0; $i < 20; $i++) { 
                    array_push($privileges,$i);
                }
            }
        @endphp
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="#">{{ getenv("APP_NAME") }} {{Session::get('period')}} </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="home">Inicio</a>
                    </li>
                    @if (in_array(3,$privileges))
                    <li class="nav-item dropdown">
                        <a  class="nav-link active dropdown-toggle" href="#" id="navbarDropdownCorreo" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Correos</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownCorreo">
                            <a class="dropdown-item" href="mail_send_mail">Enviar Correo</a>
                            <a class="dropdown-item" href="mail_sent_and_tracing_mails">Correos Enviados y Seguimiento</a>
                            <!--<a class="dropdown-item" href="mail_groups">Grupos</a> -->
                        </div>
                    </li>
                    @endif
                    @if(Session::get('account')["is_admin"]=="YES")
                    <li class="nav-item active dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Libro de clases
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Asistencia</a>
                        </div>
                    </li>
                    @endif
                    @if (in_array(1,$privileges) || in_array(2,$privileges))
                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdownInformes" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Información</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownInformes">
                            @if (in_array(1,$privileges))
                            <a class="dropdown-item" href="inscriptions">Alumnos Inscritos y Pendientes</a>
                            @endif
                            @if (in_array(2,$privileges))
                            <a class="dropdown-item" href="proxys">Apoderados</a>
                            @endif
                            @if (in_array(4,$privileges))
                            <a class="dropdown-item" href="info_request_1">Descarga Listado de Alumnos</a>
                            @endif
                        </div>
                    </li>
                    @endif
                    @if(Session::get('account')["is_admin"]=="YES")
						<li class="nav-item active">
							<a class="nav-link" href="noticias">Comunicaciones</a>
						</li>
					@endif
                    @if(Session::get('account')["is_admin"]=="YES")
                    <li class="nav-item active dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Administrar
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="adm_periods">Periodos</a>
                            <a class="dropdown-item" href="adm_users">Usuarios</a>
                            <a class="dropdown-item {{$periodenable}}"  href="adm_courses">Cursos</a>
                            <a class="dropdown-item {{$periodenable}}" href="adm_subject">Asignaturas</a>
                            <a class="dropdown-item {{$periodenable}}" href="adm_teachers">Profesores</a>
                            <a class="dropdown-item {{$periodenable}}" href="adm_horario">Horario de clases</a>
                            <a class="dropdown-item" href="adm_students">Estudiantes</a>
                        </div>
                    </li>
                    @endif
                </ul>
                <a class="btn btn-light mr-2" >
                    <img class="rounded-circle" src="{{ Session::get('account')["url_img"]}}" rel="Profile" height="22px" style="margin-top: -6px;margin-left: -4px;margin-right: 2px;">
                    {{ Session::get('account')["full_name"]}}
                </a> 
                <form action="logout" class="form-inline my-2 my-lg-0">
                    <button class="btn btn-outline-light">Salir <i class="fas fa-power-off"></i></button>
                </form>
            </div>
        </nav>
        <hr>
        @yield("context")
    </body>
</html>