<div class="modal-header">
    <h5 class="modal-title" id="exampleModalCenterTracingTitle">Apoderado</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <div class="table-responsive">
        <table class="table table-sm">
          <thead class="thead-light">
            <tr>
              <th scope="col">DNI</th>
              <th scope="col">Nombre Completo</th>
              <th scope="col">Telefono Casa</th>
              <th scope="col">Celular</th>
              <th scope="col">Correo Electrónico</th>
              <th scope="col">Telefono de trabajo</th>
            </tr>
          </thead>
          <tbody>
                <tr>
                    <td>{{$apoderado[0]["dni"]}}</td>
                    <td>{{$apoderado[0]["names"]}} {{$apoderado[0]["last_f"]}} {{$apoderado[0]["last_m"]}}</td>
                    <td>{{$apoderado[0]["phone"]}}</td>
                    <td>{{$apoderado[0]["cellphone"]}}</td>
                    <td>{{$apoderado[0]["email"]}}</td>
                    <td>{{$apoderado[0]["work_phone"]}}</td>
                </tr>     
          </tbody>
        </table>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
  </div>