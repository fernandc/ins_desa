
<ul class="nav nav-tabs my-3 justify-content-center" id="myTab" >
    <li class="nav-item">
        <a class="nav-link text-success" data="0" href="my_info?section=3">---</a>
    </li>
    <li class="nav-item">
        <a class="nav-link"  data="1" id="nav-antecedentes-tab" href="my_info?section=3&cert=1" >CERTIFICADO DE ANTECEDENTES</a>
    </li>
    <li class="nav-item">
        <a class="nav-link"  data="2" id="nav-afp-tab"  href="my_info?section=3&cert=2" >CERTIFICADO DE AFP</a>
    </li>
    <li class="nav-item">
        <a class="nav-link"  data="3" id="nav-isapre-tab"  href="my_info?section=3&cert=3" >CERTIFICADO DE ISAPRE</a>
    </li>
    <li class="nav-item">
        <a class="nav-link"  data="4" id="nav-docente-tab"  href="my_info?section=3&cert=4" >CERTIFICADO DE EVALUACIÓN DOCENTE</a>
    </li>
    <li class="nav-item">
        <a class="nav-link"  data="5" id="nav-hijo-tab"  href="my_info?section=3&cert=5" >CERTIFICADO NACIMIENTO HIJO</a>
    </li>
    <li class="nav-item">
        <a class="nav-link"  data="6" id="nav-hijo-tab"  href="my_info?section=3&cert=6" >CERTIFICADO CARGA FAMILIAR</a>
    </li>

    @php
        $active = 0;
        $cert_name = '';
    @endphp
    @if(isset($_GET['cert']))
        @php
            $active = $_GET['cert'];
            if ($active == 1) {
                $cert_name = 'Antecedentes';
                $cert_id = 'certificado_antecedentes';
                $link = 'https://www.registrocivil.cl/principal/servicios-en-linea/certificado-de-antecedentes';
            }elseif ($active == 2) {
                $cert_name = 'AFP';       
                $cert_id = 'certificado_afp';
                $link = 'https://www.chileatiende.gob.cl/fichas/3310-certificado-de-afiliacion-a-una-afp';
            }elseif ($active == 3) {
                $cert_name = 'Isapre';   
                $cert_id = 'certificado_isapre'; 
                $link = 'https://www.chileatiende.gob.cl/fichas/3505-certificado-de-afiliacion-al-sistema-de-isapres';
            }elseif ($active == 4) {
                $cert_name = 'Evaluación docente'; 
                $cert_id = 'documento_evaluación_docente';         
                $link = '';
            }elseif ($active == 5) {
                $cert_name = 'nacimiento hijo o hija ';
                $cert_id = 'certificado_nacimiento_hijo';
                $link = 'https://www.registrocivil.cl/principal/servicios-en-linea/certificado-de-nacimiento';
            }elseif ($active == 6) {
                $cert_name = 'carga familiar';
                $cert_id = 'certificado_carga_familiar';
                $link = 'https://www.chileatiende.gob.cl/fichas/25878-reconocimiento-de-cargas-para-asignacion-familiar-trabajadores-dependientes';
            }
        @endphp
    @endif
    <script>
        $(document).ready(function(){
            $("[data={{$active}}]").addClass("active");
        });
    </script>
    <div class="container">
        @if (isset($_GET['cert']))
            @include('user.user_documents.user_add_certificado')
        @endif
        
    </div>
</ul>



      
      

