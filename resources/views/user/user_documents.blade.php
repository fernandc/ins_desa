
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
                $cert_id = 'antecedentes';
            }elseif ($active == 2) {
                $cert_name = 'AFP';       
                $cert_id = 'afp';
            }elseif ($active == 3) {
                $cert_name = 'Isapre';   
                $cert_id = 'isapre'; 
            }elseif ($active == 4) {
                $cert_name = 'Titulo';  
                $cert_id = 'titulo';         
            }elseif ($active == 5) {
                $cert_name = 'Idoneidad docente'; 
                $cert_id = 'idoneidad_docente';         
            }elseif ($active == 6) {
                $cert_name = 'Bono escolar - nacimiento hijo';
                $cert_id = 'bono_hijo';
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
            @include('user.user_add_certificado')
        @endif
        
    </div>
</ul>



      
      

