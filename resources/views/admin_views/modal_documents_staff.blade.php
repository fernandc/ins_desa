<!-- Button trigger modal -->

<button type="button" class="btn btn-sm @if($file_Path != '') btn-success @else btn-outline-secondary  @endif" data-toggle="modal" data-target="#documentosModal_{{$id_user}}_{{$tipo_doc}}">
    @if (isset($otros))
        Ver Archivos        
    @else
        Ver Archivo
    @endif
</button>
  
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
 