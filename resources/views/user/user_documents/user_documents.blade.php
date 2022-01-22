
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
        <a class="nav-link"  data="4" id="nav-titulo-tab"  href="my_info?section=3&cert=4" >CERTIFICADO DE TÍTULO</a>
    </li>
    <li class="nav-item">
        <a class="nav-link"  data="5" id="nav-docente-tab"  href="my_info?section=3&cert=5" >CERTIFICADO DE IDONEIDAD DOCENTE</a>
    </li>
    <li class="nav-item">
        <a class="nav-link"  data="7" id="nav-hijo-tab"  href="my_info?section=3&cert=7" >DOCUMENTO DE EVALUACIÓN DOCENTE</a>
    </li>
    <li class="nav-item">
        <a class="nav-link"  data="6" id="nav-hijo-tab"  href="my_info?section=3&cert=6" >CERTIFICADO DE BONO ESCOLAR - NACIMIENTO HIJO</a>
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
            }elseif ($active == 2) {
                $cert_name = 'AFP';       
                $cert_id = 'certificado_afp';
            }elseif ($active == 3) {
                $cert_name = 'Isapre';   
                $cert_id = 'certificado_isapre'; 
            }elseif ($active == 4) {
                $cert_name = 'Titulo';  
                $cert_id = 'certificado_titulo';         
            }elseif ($active == 5) {
                $cert_name = 'Idoneidad docente'; 
                $cert_id = 'certificado_idoneidad_docente';         
            }elseif ($active == 7) {
                $cert_name = 'Evaluación docente'; 
                $cert_id = 'documento_evaluación_docente';         
            }elseif ($active == 6) {
                $cert_name = 'Bono escolar - certificado de nacimiento (hij@)';
                $cert_id = 'certificado_nacimiento_hijo';
                $cert_id_hijo = 'certificado_nacimiento_hijo';
                $cert_id_bono = 'certificado_bono_escolar';
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



      
      

