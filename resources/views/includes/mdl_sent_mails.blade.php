<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTracingTitle">Seguimiento</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <table class="table table-sm">
      <thead class="thead-light">
        <tr>
          <th scope="col">Destinatario</th>
          <th scope="col">Mail</th>
          <th scope="col">Rol</th>
          <th scope="col">Status</th>
          <th scope="col">Fecha lectura</th>
        </tr>
      </thead>
      <tbody>
            @foreach ($correos as $correo)
                <tr>
                    <td>{{$correo["name"]}}</td>
                    <td>{{$correo["email"]}}</td>
                    <td>{{$correo["team"]}}</td>
                    <td>{{$correo["send_status"]}}</td>
                    <td>
                        @if (isset($correo["date_mail_readed"]))
                            {{$correo["date_mail_readed"]}}
                        @else
                            Pendiente.
                        @endif
                    </td>
                    {{-- <td>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1">
                            <label class="custom-control-label" for="customSwitch1">Leído</label>
                        </div>
                    </td>                             --}}
                </tr>    
            @endforeach
      </tbody>
    </table>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
  </div>