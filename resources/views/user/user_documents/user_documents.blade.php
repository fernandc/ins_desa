
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
            $cert_name = 'evaluación docente'; 
            $cert_id = 'documento_evaluación_docente';         
            $link = '';
        }elseif ($active == 5) {
            $cert_name = 'nacimiento hijo o hija';
            $cert_id = 'certificado_nacimiento_hijo';
            $link = 'https://www.registrocivil.cl/principal/servicios-en-linea/certificado-de-nacimiento';
        }elseif ($active == 6) {
            $cert_name = 'carga familiar ';
            $cert_id = 'certificado_carga_familiar';
            $link = 'https://www.chileatiende.gob.cl/fichas/25878-reconocimiento-de-cargas-para-asignacion-familiar-trabajadores-dependientes';        
        }elseif ($active == 7) {
            $cert_name = 'inhabilidad para trabajar con menores de edad ';
            $cert_id = 'certificado_trabajar_con_menores_edad';
            $link = 'https://inhabilidades.srcei.cl/ConsInhab/consultaInhabilidad.do';            
        }elseif ($active == 8) {
            $cert_name = 'idoneidad docente';
            $cert_id = 'idoneidad_docente';
            $link = 'https://inhabilidades.srcei.cl/ConsInhab/consultaInhabilidad.do';
        }elseif ($active == 9){
            $cert_name = "Contrato";
            $cert_id = "contrato";
        }elseif ($active == 10){
            $cert_name = "Anexo Reloj";
            $cert_id = "anexo_reloj";
        }elseif ($active == 11){
            $cert_name = "Horario";
            $cert_id = "horario";
        }elseif ($active == 12){
            $cert_name = "Liquidación Marzo";
            $cert_id = "liquidacion_marzo";
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




      
      

