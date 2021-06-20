<!DOCTYPE html> 

@extends("layouts.mcdn")

@section("title")
Pagina
@endsection

@section("headex")

@endsection

@section("context")
        <nav>
            <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                @foreach ($cursos as $curso)
                    <a class="nav-item nav-link" id="nav-curso{{$curso["id"]}}" data-toggle="tab" href="#nav-curso-c{{$curso["id"]}}" role="tab" aria-controls="nav-curso-c{{$curso["id"]}}">{{$curso["abreviado"]}}</a>
                @endforeach
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
                @foreach ($cursos as $curso)
                    
                    <div class="tab-pane fade" id="nav-curso-c{{$curso["id"]}}" role="tabpanel" aria-labelledby="nav-curso-t{{$curso["id"]}}">
                        <div class=" mt-2">
                            <div class="card text-center">
                                <div class="card-header">
                                    {{$curso["nombre_curso"]." ".$curso["seccion"]}}
                                    @php
                                        $totC = 0;
                                        foreach ($horarios as $horario) {
                                            if ($curso["id"] == $horario["id_curso_periodo"]) {
                                                $totC++;
                                            }
                                        }
                                    @endphp
                                    - <span class="badge badge-primary">{{$totC}} </span> Bloques
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered table-sm" style="font-size: 0.9rem;">
                                        <thead>
                                          <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Lunes</th>
                                            <th scope="col">Martes</th>
                                            <th scope="col">Miércoles</th>
                                            <th scope="col">Jueves</th>
                                            <th scope="col">Viernes</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row" style="font-size: 10px;">
                                                </th>
                                                <td id="rowc{{$curso["id"]}}d1">
                                                    
                                                </td>
                                                <td id="rowc{{$curso["id"]}}d2">
                                                </td>
                                                <td id="rowc{{$curso["id"]}}d3">
                                                </td>
                                                <td id="rowc{{$curso["id"]}}d4">
                                                </td>
                                                <td id="rowc{{$curso["id"]}}d5">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer text-muted">
                                    -
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        @foreach ($horarios as $horario)
                            @if ($curso["id"] == $horario["id_curso_periodo"])
                                var type = "";
                                var idc = "{{$horario["id_materia"]}}";
                                if(idc == "20009" || idc == "14" || idc == "9200" || idc == "20000" || idc == "20001" || idc == "11224" || idc == "4487" || idc == "27"){type = `<a href="#" class="badge badge-danger" style="background-color: red;">LEN </a>`}
                                if(idc == "288"){type = `<a href="#" class="badge badge-danger" style="background-color: #e597fb;">MUS </a>`}
                                if(idc == "20010" || idc == "5" || idc == "9201" || idc == "6616" || idc == "2972"){type = `<a href="#" class="badge badge-primary">MAT </a>`}
                                if(idc == "249"){type = `<a href="#" class="badge badge-light" style="background-color: #ffe300;">ING </a>`}
                                if(idc == "28"){type = `<a href="#" class="badge badge-primary" style="background-color: #ff57b6;">ART </a>`}
                                if( idc == "517"){type = `<a href="#" class="badge badge-primary" style="background-color: #8b4fbd;">TEC </a>`}
                                if(idc == "20013" || idc == "6" || idc == "20003" || idc == "4474"){type = `<a href="#" class="badge badge-primary" style="background-color: #00c61f;">CIE </a>`}
                                if(idc == "9845" || idc == "20005" ){type = `<a href="#" class="badge badge-light" style="background-color: aqua;">DEP </a>`}
                                if(idc == "20004"){type = `<a href="#" class="badge badge-light" style="background-color: #ffdac4;">DEP </a>`}
                                if(idc == "22"){type = `<a href="#" class="badge badge-light" style="background-color: #f4d3c6;">ORI </a>`}
                                if(idc == "474"){type = `<a href="#" class="badge badge-light" style="background-color: #f4d3c6;">ETI </a>`}
                                if(idc == "20012" || idc == "2280" || idc == "20002" || idc == "2971"){type = `<a href="#" class="badge badge-primary" style="background-color: #ec9422;">HIS </a>`}
                                if(idc == "999"){type = `<a href="#" class="badge badge-primary" style="background-color: #a8a8a8;">PSY </a>`}
                                if(idc == "1493"){type = `<a href="#" class="badge badge-primary" style="background-color: #006166;">PRO </a>`}
                                var bloq = `<div class="card mb-2" style="height: 136px;">
                                    <div class="card-body" style="padding: 7px;">
                                        <h6 style="margin: 0px;">{{$horario["nombre_materia"]}} `+type+`</h6>
                                        <small class="text-muted" style="font-size: xx-small;">ID: {{$horario["id_materia"]}}</small>
                                        <p class="card-text">{{$horario["nombre_personal"]}}</p>
                                        <p class="card-text"><small class="text-muted">{{$horario["hora_inicio"]}} - {{$horario["hora_fin"]}}</small></p>
                                    </div>
                                </div>`;
                                $("#rowc{{$curso["id"]}}d{{$horario["dia"]}}").append(bloq);
                            @endif
                        @endforeach
                    </script>
                @endforeach
        </div>
@endsection