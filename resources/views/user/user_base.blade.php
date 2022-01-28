<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
My Info 
@endsection

@section("headex")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" />
    @livewireStyles
@endsection
@section("context")
    <div class="row" style="margin:auto">
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <div class="text-center" style="font-weight: bold; font-size: x-large;">
                        Información <i class="far fa-id-card"></i>
                    </div>
                </div>              
                <div class="card-body">                    
                    <a class="btn btn-md btn-outline-info w-100 my-1 text-info" href="my_info?section=1">Información de usuario @if($data[0]['nombres'] != '')<span class="text-success">[Completado]</span>@else <span class="text-danger">[No completado]</span> @endif  </a>
                    <a class="btn btn-md btn-outline-info w-100 my-1 text-info" href="my_info?section=4">Datos bancarios @if($data[0]['banco'] != '')<span class="text-success">[Completado]</span>@else <span class="text-danger">[No completado]</span> @endif</a>
                    <a class="btn btn-md btn-outline-info w-100 my-1 text-info" href="my_info?section=2">Formación @if($data[0]['certificados_titulo'] != '')<span class="text-success">[Completado]</span>@else <span class="text-secondary">[Opcional]</span> @endif</a>
                    <a class="btn btn-md btn-outline-info w-100 my-1 text-info" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Documentos</a>
                    <div class="collapse @if(isset($_GET['section'])) @if($_GET['section'] == '3') show @endif @endif " id="collapseExample">
                        <div class="card card-body" style="font-size: 0.9rem">
                            <a class="nav-link"  data="1" id="nav-antecedentes-tab" href="my_info?section=3&cert=1" >CERTIFICADO DE ANTECEDENTES @if($data[0]['certificado_antecedentes'] != '') <span class="text-success">[Completado]</span>@else <span class="text-danger">[No completado]</span> @endif </a>
                            <a class="nav-link"  data="2" id="nav-afp-tab"  href="my_info?section=3&cert=2" >CERTIFICADO DE AFP @if($data[0]['certificado_afp'] != '') <span class="text-success">[Completado]</span>@else <span class="text-danger">[No completado]</span>@endif</a>
                            <a class="nav-link"  data="3" id="nav-isapre-tab"  href="my_info?section=3&cert=3" >CERTIFICADO DE ISAPRE @if($data[0]['certificado_isapre'] != '') <span class="text-success">[Completado]</span>@else <span class="text-danger">[No completado]</span>@endif</a>
                            <a class="nav-link"  data="5" id="nav-hijo-tab"  href="my_info?section=3&cert=5" >CERTIFICADO NACIMIENTO HIJO @if($data[0]['certificados_nacimientos'] != 0) <span class="text-success">[Completado]</span>@else <span class="text-secondary">[Opcional]</span>@endif</a>
                            <a class="nav-link"  data="6" id="nav-hijo-tab"  href="my_info?section=3&cert=6" >CERTIFICADO CARGA FAMILIAR @if($data[0]['certificados_carga_familiar'] != 0) <span class="text-success">[Completado]</span>@else <span class="text-secondary">[Opcional]</span>@endif</a>
                            <hr>
                            <span>
                                No docentes:
                            </span>
                            <a class="nav-link"  data="7" id="nav-hijo-tab"  href="my_info?section=3&cert=7" >CERTIFICADO DE INHABILIDADES PARA TRABAJAR CON MENORES DE EDAD @if($data[0]['certificado_inhabilidad'] != '') <span class="text-success">[Completado]</span>@else <span class="text-secondary">[Opcional]</span>@endif</a>
                            <hr>
                            <span>Docentes:</span>
                            <a class="nav-link"  data="8" id="nav-docente-tab"  href="my_info?section=3&cert=8" >CERTIFICADO DE IDONEIDAD DOCENTE @if($data[0]['certificado_idoneidad_docente'] != '') <span class="text-success">[Completado]</span>@else <span class="text-secondary">[Opcional]</span>@endif</a>
                            <a class="nav-link"  data="4" id="nav-docente-tab"  href="my_info?section=3&cert=4" >CERTIFICADO DE EVALUACIÓN DOCENTE @if($data[0]['certificado_evaluacion_docente'] != '') <span class="text-success">[Completado]</span>@else <span class="text-secondary">[Opcional]</span>@endif</a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            @if (isset($_GET['section']))
                @if ($_GET['section'] == '1')
                    @include('user.user_info.user_form')  
                @elseif($_GET['section'] == '2')
                    @include('user.user_studies.formulario-estudios')
                @elseif($_GET['section'] == '3')
                    @include('user.user_documents.user_documents')    
                @elseif($_GET['section'] == '4')
                    @include('user.user_bank.user_bank_info')
                @else
                    @include('user.user_info.user_form') 
                @endif                 
            @else
                @include('user.user_info.user_form') 
            @endif
        </div>
        
    </div>

    @livewireScripts
@endsection