<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTracingTitle"><Fieldset>Ficha de Alumno</Fieldset></h5>
    <button id="imprimir" class="btn btn-outline-info btn-sm ml-2">Imprimir</button>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <header style=" padding: 10px 0; margin-bottom: 30px;">
        <div class="float-left" style="width: 80px; heigth:80px; ">
            <img src="https://scc.cloupping.com/public/scc_logo.png" alt="" class="img-fluid">
        </div>
        <div class="d-flex">
            <p class="text-secondary" style="font-size:30px; font-weight:bold;">&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;FICHA DE MATRÍCULA {{Session::get('period')}} </p>
        </div>
      </header>
      <!--
        <div class="float-right" style="width:118px; heigth:139px;">
            <img src="" alt="Alumno">
        </div>
      -->
      <main id="content">
          <div >
              <div class="my-3">
                <p class="pt-3 my-3 text-center" style="font-size: 24px; font-weight:bold">Antecedentes del Estudiante</p>
              </div>

              <div class="my-3">
                <p class="font-weight-bold" style="font-size: 10pt;">N° de matrícula: &nbsp;&nbsp;<span style="text-decoration: underline;white-space: break-spaces;"><?php echo str_pad($data["inscription"]["numero_matricula"], 20, " ", STR_PAD_BOTH); ?></span></p>
                <p class="font-weight-bold" style="font-size: 10pt;">Centro de padres: <span style="text-decoration: underline;white-space: break-spaces;"><?php echo str_pad($data["inscription"]["centro_padres"], 20, " ", STR_PAD_BOTH); ?></span></p>
                <p class="font-weight-bold" style="font-size: 10pt;">Curso al que postula {{Session::get('period')}}: {{$data["inscription"]["curso"]}} </p>
                <p class="font-weight-bold" style="font-size: 10pt;">RUT Estudiante: {{$data["student"]["dni"]}}</p>
              </div>

              <div class="my-3">
                <table class="table table-sm table-striped" style="font-size: 10pt;">
                  <tr>
                    <th>{{$data["student"]["last_f"]}}</th>
                    <th>{{$data["student"]["last_m"]}}</th>
                    <th>{{$data["student"]["names"]}}</th>
                  </tr>
                  <tr>


                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Nombres</th>
                  </tr>
                  <tr>
                    <th>Sexo: @if($data["student"]["sex"] == "VAR") Masculino @else Femenino @endif</th>
                    <th>F. Nacimiento: {{$data["student"]["born_date"]}} </th>
                    <th>Nacionalidad: {{$data["student"]["nationality"]}} </th>
                  </tr>
                  <tr>
                    <th colspan="2">Pertenece a etnia: {{$data["student"]["ethnic"]}} </th>
                    <th>Teléfono estudiante: {{$data["student_background"]["cellphone"]}}</th>
                  </tr>
                  <tr>
                    <th colspan="3">Contacto de emergencia: {{$data["student_background"]["emergency_data"]}} </th>
                  </tr>
                  <tr>
                    <th colspan="3">Establecimiento de procedencia: {{$data["student_background"]["school_origin"]}} </th>
                  </tr>
                  <tr>
                    <th>Año Ingreso al establecimiento: {{$data["student_background"]["school_origin_year_in"]}} </th>
                    <th>Pertenece a PIE 2020: @if($data["student_background"]["has_pie"]=="true") Si @else No @endif</th>
                    <th>Postula a PIE 2021: @if($data["student_background"]["apply_pie_next_year"]=="true") Si @else no @endif</th>
                  </tr>
                  <tr>
                    <th colspan="3">Enfermedad de riesgo del estudiante: {{$data["student_background"]["risk_disease"]}}</th>
                  </tr>
                  <tr>
                    <th colspan="3">Tratamiento Médico: {{$data["student_background"]["medical_treatment"]}}</th>
                  </tr>
                  <tr>
                    <th colspan="3">Dificultad o tratamiento sensorial: {{$data["student_background"]["sensory_difficulties"]}} </th>
                  </tr>
                  <tr>
                    <th colspan="2">Tratamiento especial recibido: @if($data["student_background"]["has_special_treatment"]=="true")Si @else No @endif</th>
                    <th>Continúa tratamiento: @if($data["student_background"]["does_keep_st"]=="true")Si @else No @endif</th>
                  </tr>
                  <tr>
                    <th colspan="3">Motivo Continuidad del tratamiento: {{$data["student_background"]["why_does_keep_st"]}} </th>
                  </tr>
                  <tr>
                    <th>Comuna: {{$data["student_background"]["district"]}} </th>
                    <th colspan="2">Dirección: {{$data["student_background"]["address"]}} </th>
                  </tr>
                </table>
              </div>
          </div>
          
          <div style="page-break-before: always;">
              <div class="my-3">
                  <p class="pt-3 my-3 text-center" style="font-size: 24px; font-weight:bold">Antecedentes de la Madre</p>
              </div>
              <table style="margin-left:auto; margin-right:auto; font-size: 10pt;" class="my-3 table table-sm table-striped" >
                  <tr>
                      <th colspan="3" class="text-center">Nombre completo</th>
                  </tr>
                  <tr>
                      <th colspan="3" class="text-center">{{$data["mother"]["last_f"]}} {{$data["mother"]["last_m"]}} {{$data["mother"]["names"]}}</th>
                  </tr>
                  <tr>
                      <th colspan="2" style="text-align: left">RUN: {{$data["mother"]["dni"]}}</th>
                      <th style="text-align: left">F. Nacimiento: {{$data["mother"]["born_date"]}}</th>
                  </tr>
                  <tr>
                      <th colspan="2" style="text-align: left">Estado Civil legal: {{$data["mother"]["legal_civil_status"]}} </th>
                      <th style="text-align: left">Estado Civil actual: {{$data["mother"]["current_civil_status"]}} </th>
                  </tr>
                  <tr>
                      <th colspan="2" style="text-align: left">Vive con el alumno: @if($data["mother"]["live_with"]=='Si') Si @elseif($data["mother"]["live_with"]=='No')No @else No respondido @endif </th>
                      <th style="text-align: left">Visitas al mes {{$data["mother"]["visits_per_months"]}}</th>
                  </tr>
                  <tr>
                      <th colspan="2" style="text-align: left">Dirección: {{$data["mother"]["address"]}}</th>
                      <th style="text-align: left">Comuna: {{$data["mother"]["district"]}}</th>
                  </tr>
                  <tr>
                      <th colspan="2" style="text-align: left">Teléfono: {{$data["mother"]["phone"]}} </th>
                      <th style="text-align: left">Celular: {{$data["mother"]["cellphone"]}} </th>
                  </tr>
                  <tr>
                      <th colspan="2" style="text-align: left">E-mail: {{$data["mother"]["email"]}} </th>
                      <th style="text-align: left">Nivel de estudios: {{$data["mother"]["educational_level"]}}</th>
                  </tr>
                  <tr>
                      <th colspan="2" style="text-align: left">Actividad laboral: {{$data["mother"]["work"]}}</th>
                      <th style="text-align: left">Teléfono laboral: {{$data["mother"]["work_phone"]}}</th>
                  </tr>
                  <tr>
                      <th colspan="3" style="text-align: left">Dirección laboral: {{$data["mother"]["work_address"]}}</th>
                  </tr>
              </table>

              <div class="my-3">
                  <p class="text-center" style="font-size: 24px; font-weight:bold">Antecedentes del Padre</p>
              </div>

              <table style="margin-left:auto; margin-right:auto; font-size: 10pt" class="my-3 table table-sm table-striped">
                  <tr>
                      <th colspan="3" class="text-center">Nombre completo</th>
                  </tr>
                  <tr>
                      <th colspan="3" class="text-center">{{$data["father"]["last_f"]}} {{$data["father"]["last_m"]}} {{$data["father"]["names"]}}</th>
                  </tr>
                  <tr>
                      <th colspan="2" style="text-align: left">RUN: {{$data["father"]["dni"]}}</th>
                      <th style="text-align: left">F. de nacimiento: {{$data["father"]["born_date"]}}</th>
                  </tr>
                  <tr>
                      <th colspan="2" style="text-align: left">Estado Civil legal: {{$data["father"]["legal_civil_status"]}}</th>
                      <th style="text-align: left">Estado Civil actual: {{$data["father"]["current_civil_status"]}}</th>
                  </tr>
                  <tr>
                      <th colspan="2" style="text-align: left">Vive con el alumno: @if($data["father"]["live_with"]==true) Si @elseif($data["father"]["live_with"]==false)No @else No respondido @endif </th>
                      <th style="text-align: left">Visitas al mes {{$data["father"]["visits_per_months"]}}</th>
                  </tr>
                  <tr>
                      <th colspan="2" style="text-align: left">Dirección: {{$data["father"]["address"]}}</th>
                      <th style="text-align: left">Comuna: {{$data["father"]["district"]}} </th>
                  </tr>
                  <tr>
                      <th colspan="2"style="text-align: left">Teléfono: {{$data["father"]["cellphone"]}}</th>
                      <th style="text-align: left">Celular: {{$data["father"]["cellphone"]}} </th>
                  </tr>
                  <tr>
                      <th colspan="2" style="text-align: left">E-mail: {{$data["father"]["email"]}}</th>
                      <th style="text-align: left">Nivel de estudios: {{$data["father"]["educational_level"]}}</th>
                  </tr>
                  <tr>
                      <th colspan="2" style="text-align: left">Actividad laboral: {{$data["father"]["work"]}} </th>
                      <th style="text-align: left">Teléfono laboral : {{$data["father"]["work_phone"]}}</th>
                  </tr>
                  <tr>
                      <th colspan="3" style="text-align: left">Dirección laboral: {{$data["father"]["work_address"]}} </th>
                  </tr>
              </table>
          </div>
          @if(isset($data["proxy"]))
          <div style="page-break-before: always;">
              <div class="my-3">
                  <p class="text-center" style="font-size: 24px; font-weight:bold">Antecedentes del Apoderado</p>
                  <p class="text-center" style="font-size:19px; font-weight:bold">Identidad Apoderado: {{$data["student"]["parent_type"]}} </p>
              </div>
              <table class="table table-sm table-striped my-3" style="font-size: 10pt;">
                <tr>
                  <th colspan="2" class="text-center">Nombre completo</th>
                </tr>
                <tr>
                  <th colspan="2" class="text-center"> {{$data["proxy"]["last_f"]}} {{$data["proxy"]["last_m"]}} {{$data["proxy"]["names"]}}</th>
                </tr>
                <tr>
                  <th>RUN: {{$data["proxy"]["dni"]}}</th>
                  <th>F. de nacimiento: {{$data["proxy"]["born_date"]}} </th>
                </tr>
                <tr>
                  <th colspan="2">Parentesco con el alumno: {{$data["student"]["parent_type"]}}</th>
                </tr>
                <tr>
                  <th>Dirección: {{$data["proxy"]["address"]}}</th>
                  <th>Comuna: {{$data["proxy"]["district"]}}</th>
                </tr>
                <tr>
                  <th colspan="2">Teléfono: {{$data["proxy"]["cellphone"]}}</th>
                </tr>
                <tr>
                  <th colspan="2">E-mail: {{$data["proxy"]["email"]}} </th>
                </tr>
                <tr>
                  <th>Actividad laboral: {{$data["proxy"]["work"]}} </th>
                  <th>Teléfono laboral: {{$data["proxy"]["work_phone"]}}</th>
                </tr>
                <tr>
                  <th colspan="2">Dirección laboral: {{$data["proxy"]["work_address"]}}</th>
                </tr>
                <tr>
                  <th colspan="2">Tiempo de traslado al colegio (min): {{$data["misc"]["time_from_to"]}}</th>
                </tr>
                <tr>
                  <th colspan="2">Forma de traslado al colegio (ida): {{$data["misc"]["meth_go"]}}</th>
                </tr>
                <tr>
                  <th colspan="2">Forma de traslado al colegio (vuelta): {{$data["misc"]["meth_back"]}}</th>
                </tr>
                <tr>
                  <th colspan="2">Persona autorizada a retirarlo: {{$data["misc"]["auth_quit"]}}</th>
                </tr>
              </table>
          </div>
          @endif
          <div style="page-break-before: always;">
              <p class="text-center" style="font-size:19px; font-weight:bold">Personas que viven con el apoderado</p>

              <table class="table table-sm table-striped table-condensed">
                <tr>
                  <th>Nombre</th>
                  <th>Parentezco</th>
                  <th>¿Mismo Colegio?</th>
                  <th>Edad</th>
                  <th>Ocupación</th>
                </tr>
                  @foreach($data["circle"] as $row)
                  <tr>
                      <th>{{$row["full_name"]}}</th>
                      <th>{{$row["kinship"]}}</th>
                      <th>{{$row["same_ins"]}}</th>
                      <th>{{$row["years_old"]}}</th>
                      <th>{{$row["occupation"]}}</th>
                  </tr>
                  @endforeach
              </table>
              <div style="margin: 50px 40px 0px 40px;">
                <div style="text-align: left" class="float-left">
                  <p>______________________</p>
                  <p style="font-weight:bold">Firma Apoderado</p>
                </div>
                <div style="text-align: right">
                  <p>______________________</p>
                  <p style="font-weight:bold">Firma y timbre de Recepción</p>
                </div>
              </div>
          </div>
      </main>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
  </div>
  <script>
    $('#imprimir').click(function() {
      var element = document.getElementById('content');
      html2pdf(element);
    });
  </script>