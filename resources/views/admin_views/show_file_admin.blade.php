@if ($idDoc == 'certificado_nacimiento' || $idDoc == 'certificado_titulo')
    @if ($idDoc == 'certificado_nacimiento' )
        @for ($i = 1; $i <= $documento; $i++)
            @php
                $rut = $row["rut"];
                $rut = str_replace(".","", $rut);
                $rut = str_replace("-","",$rut);
                $year = Session::get('period');
                $filePath = "public-staff-".$rut."-".$year."-";
                $filePath = $filePath.$idDoc."_hijo_".$i.".pdf"; 
                             
            @endphp
            <div class="card">
                <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-sm collapsed" type="button" data-toggle="collapse" data-target="#collapse{{$idDoc}}{{$i}}" aria-expanded="false" aria-controls="collapse{{$idDoc}}{{$i}}">
                        {{$nombreDoc}} Hijo {{$i}}
                    </button>
                </h2>
                </div>
        
                <div id="collapse{{$idDoc}}{{$i}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">                                    
                        <embed src="get_file/{{$filePath}}#toolbar=0&navpanes=0&scrollbar=0" id="output_{{$id_user}}_{{$tipo_doc}}" width="100%" height="450px" type="application/pdf">                                    
                    </div>
                </div>
            </div>
        @endfor
    @else
        @for ($j = 1; $j <= $documento; $j++)
            @php
                $rut = $row["rut"];
                $rut = str_replace(".","", $rut);
                $rut = str_replace("-","",$rut);
                $filePath = "public-staff-".$rut."-2022-";
                $filePath = $filePath.$idDoc."_".$j."pdf";            
            @endphp
            <div class="card">
                <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-sm collapsed" type="button" data-toggle="collapse" data-target="#collapse{{$idDoc}}" aria-expanded="false" aria-controls="collapse{{$idDoc}}">
                        {{$nombreDoc}}
                    </button>
                </h2>
                </div>
        
                <div id="collapse{{$idDoc}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">                                    
                        <embed src="get_file/{{$filePath}}#toolbar=0&navpanes=0&scrollbar=0" id="output_{{$id_user}}_{{$tipo_doc}}" width="100%" height="450px" type="application/pdf">                                    
                    </div>
                </div>
            </div>
        @endfor
    @endif
@else
    
    @php
        $filePath = $documento;
        $filePath = str_replace("/","-",$filePath);
    @endphp                 
    <div class="card">
        <div class="card-header" id="headingOne">
        <h2 class="mb-0">
            <button class="btn btn-link btn-sm collapsed" type="button" data-toggle="collapse" data-target="#collapse{{$idDoc}}" aria-expanded="false" aria-controls="collapse{{$idDoc}}">
                {{$nombreDoc}}
            </button>
        </h2>
        </div>

        <div id="collapse{{$idDoc}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">                                    
                <embed src="get_file/{{$filePath}}#toolbar=0&navpanes=0&scrollbar=0" id="output_{{$id_user}}_{{$tipo_doc}}" width="100%" height="450px" type="application/pdf">                                    
            </div>
        </div>
    </div>
@endif