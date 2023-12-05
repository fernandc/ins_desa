<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTracingTitle">
        <Fieldset>Contrato</Fieldset>
    </h5>
    <button id="imprimir" class="btn btn-outline-info btn-sm ml-2">Imprimir</button>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="container">
        <div id="content" style="font-size:0.9rem;">
            <div class="border p-5">
                <div class="text-center">
                    <img src="data:image/png;base64, <?php echo base64_encode(file_get_contents(getenv("API_ENDPOINT").'public/scc_logo.png')); ?>" alt="Logo" style="max-height: 120px;">
                </div>
                <div class="row" style="line-height: 1.2;">
                    <div class="col-md-12">
                        <div class="text-center mt-2">
                            <b class="fs-4" style="font-size: 14px;">CONTRATO DE PRESTACIÓN DE SERVICIOS EDUCACIONALES</b>
                        </div>
                        <div class="mt-3">
                            En Santiago, con fecha _________de ____________________del 20___, entre
                            <b>Corporación Educacional Saint Charles College</b>, R.U.N 65.093.233-1 RBD 25382-0, con
                            domicilio en la ciudad
                            de Santiago, calle Pedro Donoso N° 8741/8743 (ambas numeraciones) comuna de La Florida,
                            representada por <b>Nina Borisova Kresteva</b>, cédula de identidad 14.656.819-k por una parte y
                            por la
                            otra parte el apoderado(a),en adelante “el contratante” y el apoderado:
                        </div>
                        <!-- display: flex (sirve para dejar la linea continua-->
                        <!-- display: block (sirve para dejar la linea como bloque-->

                        <div style="display: flex;" class="mt-3">
                            <span class="border-bottom border-dark" style="display: block; width: 400px;">
                                <b id="nombre-apo">&nbsp;{{$data["proxy"]["names"]}} {{$data["proxy"]["last_f"]}} {{$data["proxy"]["last_m"]}}</b>
                            </span>
                            R.U.N:
                            <span class="border-bottom border-dark" style="display: block; width: 200px;">
                                <b id="rut-apo">&nbsp;{{substr($data["proxy"]["dni"],0,-1)}}-{{substr($data["proxy"]["dni"],-1)}}</b>
                            </span>
                        </div>
                        
                        <div class="mt-3">
                            <span>
                                Domiciliado en
                            </span>
                            <span id="direccion-apo" class="border-bottom border-dark" style="display: inline-block; width: 520px">
                                <b>&nbsp;{{$data["proxy"]["address"]}}</b>
                            </span>
                        </div>
                        
                        <div style="display: flex;" class="mt-3">
                            <span>
                                Villa:
                            </span>
                            <span id="villa-apo" class="border-bottom border-dark" style="display: inline-block; width: 280px"></span>
                            Comuna:
                            <span class="border-bottom border-dark" style="display: block; width: 255px;">
                                <b id="comuna-apo">&nbsp;{{$data["proxy"]["district"]}}</b>
                            </span>
                        </div>

                        <div class="mt-3">
                            <span>
                                Teléfono N°:
                            </span>
                            <span id="telefono-apo" class="border-bottom border-dark" style="display: inline-block; width: 230px">
                                <b> &nbsp;{{$data["proxy"]["phone"]}} / {{$data["proxy"]["cellphone"]}} </b>
                            </span>
                            <span>
                                de su mismo domicilio y/o personal, se ha convenido el
                                siguiente contrato de prestación de servicios educacionales.
                            </span>
                        </div>
                        <div class="mt-3">
                            <span><b>Primero:</b> A solicitud del contratante el colegio acepta al alumno(a):</span>
                        </div>
                        <div class="mt-3">
                            <span id="nombre-alumno" class="border-bottom border-dark" style="display: inline-block; width: 620px">
                                <b>&nbsp;{{$data["student"]["names"]}} {{$data["student"]["last_f"]}} {{$data["student"]["last_m"]}}</b>
                            </span>
                            Para el curso
                            <span id="curso-alumno" class="border-bottom border-dark" style="display: inline-block; width: 230px">
                                <b>&nbsp;{{$data["inscription"]["curso"]}}</b>
                            </span>
                            con jornada escolar completa.
                        </div>

                        <div class="mt-3">
                            <b>Segundo:</b> El alumno(a) nuevo al matricularse debe entregar la documentación requerida por el
                            colegio (certificado de notas, informe de personalidad, certificado de nacimiento y otros antecedentes
                            relevantes que pueda solicitar el colegio).
                        </div>

                        <div class="mt-3">
                            <b>
                                Tercero: La Ley de Inclusión 20.845, expresa que, los padres, madres y apoderados, antes de
                                matricular a sus hijos(as), se deben informar del Proyecto Educativo del colegio, de tal forma
                                que elijan libremente el establecimiento en el cual desean educar a sus hijos(as).
                                Las familias deben buscar Proyectos Educativos acordes a sus valores y visiones,
                                adhiriéndose al Proyecto Educativo del establecimiento que están aceptando, debiendo
                                respetar lo estipulado en el Reglamento Interno. Una vez elegido el Establecimiento
                                Educacional, los apoderados se comprometen conjuntamente con sus hijos a cuidar, respetar,
                                apoyar y cumplir los reglamentos del colegio y de su Proyecto Educativo.
                            </b>
                        </div>

                        <div class="mt-3">
                            <b>Cuarto: </b>Las actividades, asignaturas o disciplinas que imparta el colegio durante el año escolar, son
                            aquellas que corresponden al estudio respectivo, aprobado por el Ministerio de Educación. El
                            apoderado acepta que el colegio no imparte la asignatura de Religión, sino Ética y Desarrollo con
                            planes propios aprobados por MINEDUC.
                            El colegio, previo cumplimiento a la reglamentación ministerial vigente podrá modificar los planes de
                            estudio y reglamentos que actualmente rigen, para adaptarlos a las necesidades y requerimientos de
                            la enseñanza que imparte.
                        </div>
                        <div class="mt-3">
                            <b>
                                Actividades de carácter obligatorio, dentro del margen académico que se realizarán los
                                días sábados
                            </b>
                        </div>
                        <div class="mt-3">
                            <ul>
                                <li>Compromiso Apoderado</li>
                                <li>Extracto Manual de Convivencia</li>
                                <li>Extracto Reglamento de Evaluación</li>
                                <li>Contrato de Prestación de Servicios Educacionales</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border px-5" style="page-break-before: always;">
                <div class="mt-3">
                    <b>Quinto: </b>El contratante declara estar en pleno conocimiento de los reglamentos académicos, de
                    convivencia escolar y de normas internas vigentes en Saint Charles College aceptándolas en todas
                    sus partes. y reconoce la facultad que asiste al colegio para dictar normas de convivencia, las cuales
                    <b>se compromete a cumplir y velar por el cumplimiento de su pupilo(a).</b>
                </div>

                <div class="mt-1">
                    <b>
                        <ol>
                            <li>Compromiso Apoderado</li>
                            <li>Extracto Manual de Convivencia</li>
                            <li>Extracto Reglamento de Evaluación</li>
                            <li>Contrato de Prestación de Servicios Educacionales</li>
                        </ol>
                    </b> 
                </div>

                <div class="mt-3">
                    <b>Sexto: </b>Las partes dejan expresa constancia y conocimiento que, no es responsabilidad de Saint
                    Charles College los perjuicios derivados de la pérdida o sustracción de efectos personales del
                    alumno(a). Este reconoce su obligación de mantener el debido resguardo sobre dichos elementos,
                    por lo tanto, <b>será bajo su responsabilidad</b> el ingreso de ellos al establecimiento y es deseable que,
                    en lo posible <b>no los traiga al colegio.</b>
                    (aparatos de música, celulares, tablet, joyas, notebook, juguetes, dinero, etc…).
                </div>

                <div class="mt-3">
                    <b>Séptimo: </b>En el caso de accidente grave del estudiante, o si por cualquier causa este requiere
                    atención médica de urgencia, el colegio lo trasladará a una atención primaria con medios propios o
                    los que le proporcionen al derivarlo a un establecimiento asistencial, sin que ello implique asumir
                    responsabilidad institucional, y/o responsabilidad económica alguna por los hechos que hubiera
                    motivado la atención. Se le avisará al apoderado para que concurra al servicio de urgencia al cuidado
                    del estudiante, liberando al personal del establecimiento. En caso que el apoderado no desee que se
                    proporcione dicha asistencia a su pupilo(a), o que sea derivado a un Servicio de Urgencia y
                    Hospitalario en particular, deberá expresamente indicarlo y solicitarlo por escrito en Inspectoría
                    General, además debe indicar en la Agenda personal del alumno(a), Servicio de Urgencia a utilizar
                    en caso de accidentes y <b>teléfonos de rápida localización del apoderado.</b>
                </div>

                <div class="mt-3">
                    <b>Octavo: </b>Reglamentos y medidas disciplinarias aplicables por Saint Charles College.
                    <div>
                        <div class="mt-2">
                            <b>8.1</b>
                            El (la) Apoderado(a) se compromete a velar por el cumplimiento de los deberes de
                            presentación personal, uso de uniforme institucional y obligaciones académicas del estudiante
                            establecidas en los Reglamentos dictados por Saint Charles College. En forma especial, el
                            (la)Apoderado(a), reconoce y acepta expresamente la <b>facultad del colegio para aplicar las
                            medidas disciplinarias</b> en los términos establecidos en dicho Reglamento y por las causales que allí
                            se establecen <b>colaborando para el cumplimiento de ellas responsablemente.</b>
                        </div>
                        <div class="mt-2">
                            <b>8.2</b>
                            Toda situación no expresada en el presente contrato será regida por las leyes del Ministerio de
                            Educación y aplicadas por la Dirección del colegio.
                        </div>
                        <div class="mt-2">
                            <b>8.3</b>
                            El contratante declara haber leído el presente contrato y estar de acuerdo con él.
                        </div>
                        <div class="mt-2">
                            <b>8.4</b>
                            Las partes fijan como domicilio la ciudad de Santiago para todos los efectos del presente
                            contrato.
                        </div>
                    </div>
                </div>
            </div>
            <div class="border px-5" style="page-break-before: always;">
                <div class="mt-3">
                    <b>Noveno: El Alumno(a) y el Apoderado(a) se comprometen a mantener una conducta de respeto
                    por toda la Comunidad Educativa.</b> Si esta situación no se cumpliera, <b> el colegio tiene plena
                    libertad de solicitar cambio de apoderado según el caso que fuera necesario.</b>
                </div>
                <div class="mt-3">
                    <b>La personería de Nina Borisova Kresteva para representar la Corporación Educacional Saint
                    Charles College, otorgada por el Ministerio de Educación, consta en escritura Pública fechada
                    el 21 de diciembre del 2016, legalizada en la Notaría de don Eugenio Camus Mesa de Puente
                    Alto.</b>
                </div>
                <div class="mt-3">
                    <b>
                        Queda un ejemplar del presente contrato en poder del contratante, responsable de la educación y
                        otro en poder de Saint Charles College, quienes firman en conformidad lo expuesto.
                    </b>
                </div>
                <div class="mt-3">
                    <b>
                        El (La) Apoderado(a) declara haber recibido en su correo personal, leído y aceptado los
                        siguientes documentos:
                        <div class="mt-3">
                            <ul>
                                <li>Compromiso Apoderado</li>
                                <li>Extracto Manual de Convivencia</li>
                                <li>Extracto Reglamento de Evaluación</li>
                                <li>Contrato de Prestación de Servicios Educacionales</li>
                            </ul>
                        </div>
                    </b>
                </div>

                <div class="row" style="margin-top: 420px;">
                    <div class="col-md-5 border-top border-dark" style="text-align: center; border-width: 2px !important;">
                        <b>
                            Firma de Apoderado Contratante Legal
                        </b>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-5 border-top border-dark" style="text-align: center; border-width: 2px !important;">
                        <b>
                            Firma y timbre del Representante
                        </b>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
</div>
<script>
    $('#imprimir').click(function () {
        var element = document.getElementById('content');
        var opt = {
            margin: 0.5,
            filename: 'Contrato.pdf',
            image: { type: 'jpg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        html2pdf().set(opt).from(element).save();
        //html2pdf(element);
    });
</script>