@livewire('staff.formulario-estudios')
<div class="card">
    <div class="card-header" >       
        Formación
    </div>
    <div class="card-body">
        @for ($x = 0; $x < 2; $x++)
            <div class="card" >
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="card-subtitle mb-2 text-muted">{{"Titulado en Otras Áreas"}}</h6>
                            <h5 class="card-title">
                                Tipo de titulo: <span class="text-primary">{{"Técnico de nivel superior"}}</span>
                                <br>
                                <span class="badge badge-info" style="font-weight: 400 !important;font-size: small;">Ciencias Sociales y del Comportamiento</span>
                            </h5>
                            
                            <p class="card-text" style="font-size: large;">{{"Titulado media (Cientifico Humanista)"}}</p>
                            <p class="card-text" style="font-size: large;"><span style="font-weight: 500;">Especialidad: </span>{{"Lenguaje y Comunicación"}}</p>
                            @if (true)
                            <span style="font-weight: 500;font-size: larger;">Menciones:</span>
                                @for ($i = 1; $i < 5; $i++)
                                    @if ($i > 1)
                                        -
                                    @endif
                                    <span class="badge badge-light">Mención {{$i}}</span>
                                @endfor
                            @endif
                        </div>
                        <div class="col-md-6">
                            <p class="card-text mt-3" style="font-size: large;"><span style="font-weight: 500;">Duración de la carrera: </span> {{5}} Semestres</p>
                            <p class="card-text " style="font-size: large;"><span style="font-weight: 500;">Año de titulación: </span> {{2018}}</p>
                            <p class="card-text " style="font-size: large;"><span style="font-weight: 500;">Modalidad de estudio: </span> {{2018}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        @endfor
        
    </div>
</div>