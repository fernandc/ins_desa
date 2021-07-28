<div class="col-md-6">
    <div class="card">
        <div class="card-header text-white" style="background-color: #00b2ff!important;">
            <b>Mis Clases de Hoy</b>
        </div>
        <div class="card-body">
          <blockquote class="blockquote mb-0" style="font-size: 1rem !important;">
            <ul class="list-group list-group-flush">
                @foreach ($scheduler_by_user as $row)
                    @if ($row["dia"] == date('w'))
                        <li class="list-group-item pl-0">
                            <div class="row">
                                <div class="col-6">
                                    <b>{{$row["nombre_materia"]}} </b>
                                </div>
                                <div class="col-3 text-center">
                                    <span class="badge badge-light">{{substr($row["hora_inicio"],0,5)}}</span>
                                    <br>
                                    <span class="badge badge-light">{{substr($row["hora_fin"],0,5)}}</span>
                                </div>
                                <div class="col-3">
                                    <a href="checks_points?curso={{$row["id_curso"]}}&materia={{$row["id_materia"]}}&mes={{date('m')}}" class="badge badge-primary align-middle">Pasar Asistencia</a>
                                </div>
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
            
          </blockquote>
        </div>
    </div>
    
</div>