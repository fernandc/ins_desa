
<div class="accordion" id="accordionExample">

    @if($row['certificado_antecedentes'] != '')
        @include('admin_views.show_file_admin',["documento" => $row['certificado_antecedentes'], "nombreDoc" => "Certificado de Antecedentes", "idDoc" => "certificado_antecedentes"])        
    @else
        <div class="card">
            <div class="card-header">
                <div style="font-size: x-large">
                    <i class="fas fa-file-pdf fx-9 text-danger" id="i_output"></i>
                    Certificado de Antecedentes 
                    <span class="text-danger">[No Cargado]</span>
                    <embed src="" id="output_{{$id_user}}_{{$tipo_doc}}" width="100%" height="500px" hidden type="application/pdf">    
                </div>
            </div>
        </div>
    @endif
    @if($row['certificado_afp'] != '')
        @include('admin_views.show_file_admin',["documento" => $row['certificado_afp'], "nombreDoc" => "Certificado de AFP", "idDoc" => "certificado_afp"])
    @else
        <div class="card">
            <div class="card-header">
                <div style="font-size: x-large">
                    <i class="fas fa-file-pdf fx-9 text-danger" id="i_output"></i>
                    Certificado de AFP 
                    <span class="text-danger">[No Cargado]</span>
                    <embed src="" id="output_{{$id_user}}_{{$tipo_doc}}" width="100%" height="500px" hidden type="application/pdf">    
                </div>
            </div>
        </div>
    @endif
    @if($row['certificado_isapre'] != '')
        @include('admin_views.show_file_admin',["documento" => $row['certificado_isapre'], "nombreDoc" => "Certificado de Isapre", "idDoc" => "certificado_isapre"])
    @else
        <div class="card">
            <div class="card-header">
                <div style="font-size: x-large">
                    <i class="fas fa-file-pdf fx-9 text-danger" id="i_output"></i>
                    Certificado de Isapre 
                    <span class="text-danger">[No Cargado]</span>
                    <embed src="" id="output_{{$id_user}}_{{$tipo_doc}}" width="100%" height="500px" hidden type="application/pdf">    
                </div>
            </div>
        </div>
    @endif
    @if($row['certificado_idoneidad_docente'] != '')
        @include('admin_views.show_file_admin',["documento" => $row['certificado_idoneidad_docente'], "nombreDoc" => "Certificado de Idoneidad Docente", "idDoc" => "certificado_idoneidad_docente"])
    @else
        <div class="card">
            <div class="card-header">
                <div style="font-size: x-large">
                    <i class="fas fa-file-pdf fx-9 text-danger" id="i_output"></i>
                    Certificado de Idoneidad Docente 
                    <span class="text-danger">[No Cargado]</span>
                    <embed src="" id="output_{{$id_user}}_{{$tipo_doc}}" width="100%" height="500px" hidden type="application/pdf">    
                </div>
            </div>
        </div>
    @endif
    @if($row['certificado_inhabilidad'] != '')
        @include('admin_views.show_file_admin',["documento" => $row['certificado_inhabilidad'], "nombreDoc" => "Certificado de Inhabilidad para trabajar con menores de edad", "idDoc" => "certificado_trabajar_con_menores"])
    @else
        <div class="card">
            <div class="card-header">
                <div style="font-size: x-large">
                    <i class="fas fa-file-pdf fx-9 text-danger" id="i_output"></i>
                    Certificado de Inhabilidad para trabajar con menores de edad
                    <span class="text-danger">[No Cargado]</span>
                    <embed src="" id="output_{{$id_user}}_{{$tipo_doc}}" width="100%" height="500px" hidden type="application/pdf">    
                </div>
            </div>
        </div>
    @endif
    @if($row['certificado_evaluacion_docente'] != '')
        @include('admin_views.show_file_admin',["documento" => $row['certificado_evaluacion_docente'], "nombreDoc" => "Certificado de Evaluación Docente", "idDoc" => "certificado_evaluacion_docente"])
    @else
        <div class="card">
            <div class="card-header">
                <div style="font-size: x-large">
                    <i class="fas fa-file-pdf fx-9 text-danger" id="i_output"></i>
                    Certificado de Evaluación Docente
                    <span class="text-danger">[No Cargado]</span>
                    <embed src="" id="output_{{$id_user}}_{{$tipo_doc}}" width="100%" height="500px" hidden type="application/pdf">    
                </div>
            </div>
        </div>
    @endif
    @if ($row['certificados_nacimientos'] != 0)
        @include('admin_views.show_file_admin',["documento" => $row['certificados_nacimientos'], "nombreDoc" => "Certificados de Nacimiento", "idDoc" => "certificado_nacimiento"])    
    @else
        <div class="card">
            <div class="card-header">
                <div style="font-size: x-large">
                    <i class="fas fa-file-pdf fx-9 text-danger" id="i_output"></i>
                    Certificado de nacimiento (hijos)
                    <span class="text-info">[Sin Certificados]</span>
                    <embed src="" id="output_{{$id_user}}_{{$tipo_doc}}" width="100%" height="500px" hidden type="application/pdf">    
                </div>
            </div>
        </div>
    @endif
    @if ($row['certificados_carga_familiar'] != 0)
        @include('admin_views.show_file_admin',["documento" => $row['certificados_carga_familiar'], "nombreDoc" => "Certificados de Carga Familiar", "idDoc" => "certificado_carga_familiar"])    
    @else
        <div class="card">
            <div class="card-header">
                <div style="font-size: x-large">
                    <i class="fas fa-file-pdf fx-9 text-danger" id="i_output"></i>
                    Certificados de Carga Familiar
                    <span class="text-info">[Sin Certificados]</span>
                    <embed src="" id="output_{{$id_user}}_{{$tipo_doc}}" width="100%" height="500px" hidden type="application/pdf">    
                </div>
            </div>
        </div>
    @endif
    @if ($row['certificados_titulo'] != '')
        @include('admin_views.show_file_admin',["documento" => $row['certificados_titulo'], "nombreDoc" => "Certificados de Título", "idDoc" => "certificado_titulo"])            
    @else
        <div class="card">
            <div class="card-header">
                <div style="font-size: x-large">
                    <i class="fas fa-file-pdf fx-9 text-danger" id="i_output"></i>
                    Certificados de Títulos
                    <span class="text-info">[Sin Titulo]</span>
                    <embed src="" id="output_{{$id_user}}_{{$tipo_doc}}" width="100%" height="500px" hidden type="application/pdf">    
                </div>
            </div>
        </div>
    @endif
</div>
                                   
                    
                