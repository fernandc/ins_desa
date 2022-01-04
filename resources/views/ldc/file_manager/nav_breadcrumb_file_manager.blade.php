<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @if (isset($_GET["path"]))
            @php                                
                $breadPath = $_GET["path"];
                $arrBread = explode("/", $breadPath);
                $contBread = 0;     
                $currentPath = "";                           
            @endphp

            <li class="breadcrumb-item"><a href="{{substr($_SERVER["REQUEST_URI"],0,strpos($_SERVER["REQUEST_URI"],"&path"))}}">Inicio</a></li>
            @foreach ($arrBread as $rowItem)
                @php
                    $currentPath .= $rowItem."/";                                   
                @endphp
                @if ($contBread > 4)
                    @if (($contBread+1) == count($arrBread))                                    
                        <li class="breadcrumb-item active" aria-current="page">{{$rowItem}}</li>
                    @else
                        <li class="breadcrumb-item"><a href="{{substr($_SERVER["REQUEST_URI"],0,strpos($_SERVER["REQUEST_URI"],"&path"))."&path="}}{{substr($currentPath,0, -1)}}">{{$rowItem}}</a></li>
                    @endif
                @endif
                @php
                    $contBread++;
                @endphp
            @endforeach
        @elseif((!isset($_GET["path"])) || $_GET["path"] == "public/FileManager/$year/$id_curso/".$_GET['materia'])
            <li class="breadcrumb-item active" aria-current="page">Inicio</li>
        @endif
    </ol>
</nav>