
@livewire('staff.formulario-estudios')
<div class="card">
    <div class="card-header" >       
        Formación
    </div>
    <div class="card-body">
        @foreach ($degree_data as $item)
                <div class="card" >
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="card-subtitle mb-2 text-muted">{{$item["degree"]}}</h6>
                                <h5 class="card-title">
                                    Tipo de titulo: <span class="text-primary">{{$item["degree_type"]}}</span>
                                    <br>
                                    @if ($item["degree_area"] != '')
                                        <span class="badge badge-info" style="font-weight: 400 !important;font-size: small;">{{$item["degree_area"]}}</span>                                        
                                    @endif
                                </h5>
                                @if ($item['specialty'] != '')
                                    <p class="card-text" style="font-size: large;"><span style="font-weight: 500;">Especialidad: </span>{{$item["specialty"]}}</p>                                    
                                @endif                            
                                @if ($item['mentions'] != '')
                                    @php
                                       $mentions = $item['mentions'];
                                       $mentions =  explode( ',', $mentions );
                                    @endphp
                                    <span style="font-weight: 500;font-size: larger;">Menciones:</span>
                                    @foreach ($mentions as $mens)
                                        <span class="badge badge-light">Mención {{$mens}}</span>
                                    @endforeach                                        
                                @endif
                            </div>
                            <div class="col-md-6">
                                <p class="card-text mt-3" style="font-size: large;"><span style="font-weight: 500;">Duración de la carrera: </span> {{$item['semester']}} Semestres</p>
                                <p class="card-text " style="font-size: large;"><span style="font-weight: 500;">Año de titulación: </span> {{$item['degree_year']}}</p>
                                <p class="card-text " style="font-size: large;"><span style="font-weight: 500;">Modalidad de estudio: </span> {{$item['modality']}}</p>
                            </div>
                                
                            <div class="col-md-12">
                                @if ($item['path_file'] != '')                                    
                                    @include('user.user_studies.modal_view_degree',['path_file'=> $item['path_file'], 'id'=>$item['id'] ])
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">                        
                        <a href="/delete_degree_user?id={{$item['id']}}" class="btn btn-danger btn-sm">Eliminar</a>
                    </div>
                </div>
                <hr>     
        @endforeach
    </div>
</div>