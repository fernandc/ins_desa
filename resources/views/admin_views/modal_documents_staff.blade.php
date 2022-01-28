<!-- Button trigger modal -->

@if (isset($otros))
  <button type="button" class="btn btn-sm @if(($row['certificado_antecedentes'] != '' && $row['certificado_afp'] != '' && $row['certificado_isapre'] != '' ) && ( ($row['certificado_idoneidad_docente'] != '' && $row['certificados_titulo'] != '') || ($row['certificado_inhabilidad'] != '') ) ) btn-success @else btn-outline-secondary  @endif" data-toggle="modal" data-target="#documentosModal_{{$id_user}}_{{$tipo_doc}}">
          Ver Archivos        
  </button>
@else
  <button type="button" class="btn btn-sm @if($row[$tipo_doc] != '') btn-success @else btn-outline-secondary  @endif" data-toggle="modal" data-target="#documentosModal_{{$id_user}}_{{$tipo_doc}}">
        Ver Archivos        
  </button>
@endif
  
  <!-- Modal -->
  <div class="modal fade" id="documentosModal_{{$id_user}}_{{$tipo_doc}}" tabindex="-1" role="dialog" aria-labelledby="documentosModal_{{$id_user}}_{{$tipo_doc}}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="documentosModal_{{$id_user}}_{{$tipo_doc}}Label">{{$nombreDoc}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @if(isset($otros))
                @include('admin_views.table_staff_documents')
            @else
                @include('admin_views.add_docs_staff')              
            @endif
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
 