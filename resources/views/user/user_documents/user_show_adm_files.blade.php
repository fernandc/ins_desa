@php
    $certificado = '';
    $filePath = '';
    if (isset($certificados)) {
        foreach ($certificados as $certificado) {
            $name = $certificado['name'];                     
            $name = explode(".",$name);            
            if ($name[0] == $cert_id) {                
                $filePath = $certificado["path"];
                $filePath = str_replace("/","-",$filePath);
            }                        
        }
    }
@endphp
<div class="card">
    <div class="card-header" style="font-weight: bold">                    
        {{$cert_name}}                            
    </div>
    <div class="card-body">                            
        <div class="text-center">
            @if ($filePath != '')
                <embed src="get_file/{{$filePath}}" id="output" width="100%" height="700px" type="application/pdf">
            @else
                <div style="font-size: xxx-large">
                    <i class="fas fa-file-pdf fx-9" style="background:" id="i_output"></i>
                    <embed src="" id="output" width="100%" height="500px" hidden type="application/pdf">    
                </div>
            @endif              
        </div>
    </div>             
</div>