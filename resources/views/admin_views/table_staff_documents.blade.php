
<div class="accordion" id="accordionExample">

    @if($row['certificado_antecedentes'] != '')
        @include('admin_views.show_file_admin',["documento" => $row['certificado_antecedentes'], "nombreDoc" => "Certificado de Antecedentes", "idDoc" => "certificado_antecedentes"])        
    @else
        <div class="card">
            <div class="card-header">
                <div style="font-size: x-large">
                    <i class="fas fa-file-pdf fx-9" style="color: red;" id="i_output">Certificado de Antecedentes</i>
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
                    <i class="fas fa-file-pdf fx-9" style="color: red;" id="i_output">Certificado de AFP</i>
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
                    <i class="fas fa-file-pdf fx-9" style="color: red;" id="i_output">Certificado de Isapre</i>
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
                    <i class="fas fa-file-pdf fx-9" style="color: red;" id="i_output">Certificado de Idoneidad Docente</i>
                    <embed src="" id="output_{{$id_user}}_{{$tipo_doc}}" width="100%" height="500px" hidden type="application/pdf">    
                </div>
            </div>
        </div>
    @endif
    @if($row['certificado_evaluacion_docente'] != '')
        @include('admin_views.show_file_admin',["documento" => $row['certificado_evaluacion_docente'], "nombreDoc" => "Documento de Evaluación Docente", "idDoc" => "certificado_evaluacion_docente"])
    @else
        <div class="card">
            <div class="card-header">
                <div style="font-size: x-large">
                    <i class="fas fa-file-pdf fx-9" style="color: red;" id="i_output">Documento de Evaluación Docente</i>
                    <embed src="" id="output_{{$id_user}}_{{$tipo_doc}}" width="100%" height="500px" hidden type="application/pdf">    
                </div>
            </div>
        </div>
    @endif
    @if ($row['certificados_nacimientos'] != '' || $row['certificados_nacimientos'] != 0)
        @include('admin_views.show_file_admin',["documento" => $row['certificados_nacimientos'], "nombreDoc" => "Certificados de Nacimiento", "idDoc" => "certificado_nacimiento"])    
    @else
        <div class="card">
            <div class="card-header">
                <div style="font-size: x-large">
                    <i class="fas fa-file-pdf fx-9" style="color: red;" id="i_output">Certificados de Nacimiento</i>
                    <embed src="" id="output_{{$id_user}}_{{$tipo_doc}}" width="100%" height="500px" hidden type="application/pdf">    
                </div>
            </div>
        </div>
    @endif
    @if ($row['certificados_titulo'] != '' || $row['certificados_titulo'] != 0)
        @include('admin_views.show_file_admin',["documento" => $row['certificados_titulo'], "nombreDoc" => "Certificados de Título", "idDoc" => "certificado_titulo"])            
    @else
        <div class="card">
            <div class="card-header">
                <div style="font-size: x-large">
                    <i class="fas fa-file-pdf fx-9" style="color: red;" id="i_output">Certificados de Título</i>
                    <embed src="" id="output_{{$id_user}}_{{$tipo_doc}}" width="100%" height="500px" hidden type="application/pdf">    
                </div>
            </div>
        </div>
    @endif
</div>
                                   
                    
                