<div class="card" id="cardTableFiles">
    <div class="card-header" style="overflow-x: auto" >
        <div>
            <h3>Gestor de Archivos <i>{{$materias[$_GET["materia"]]}} {{$year}} {{$id_curso_periodo}} {{$_GET["materia"]}}  </i> </h3>
        </div>
        <div class="row">
            <div class="class col-md-6">
            <button class="btn btn-md bg-success text-white" data-toggle="modal" data-target="#modalAddArchivo">
                    <i class="fas fa-plus-circle"></i> Agregar Nuevo Archivo
                </button> 
            </div>
            <div class="class col-md-6">
                <button class="btn btn-md bg-info text-white"  data-toggle="modal" data-target="#modalAddCarpeta">
                    <i class="fas fa-plus-circle"></i> Agregar Nueva Carpeta
                </button> 
            </div>
        </div>
    </div>
    
    <div class="card-body table-responsive" style="padding: 0px">
        <div class="row" style="margin: 0px">
            <div class="class col-md-12"  >
                <div class="table-responsive">      

                    <table class="table table-hover" id="gestorArchivosTable">
                        <thead class="thead-dark">
                            <tr style="text-align:center;">
                            <th scope="col">Nombre</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Visualizar</th>
                            <th scope="col">Fecha de creación</th>
                            <th scope="col">Creador</th>
                            <th scope="col">Editar</th>
                            <th scope="col">Descargar</th>
                            <th scope="col">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if (isset($_GET["path"]) && (strlen("public/FileManager/$year/$id_curso_periodo/".$_GET['materia']) < strlen($_GET['path'])) )
                                
                            <tr style="text-align:center;">                                    
                                <td>                       
                                    <a href="{{substr($_SERVER["REQUEST_URI"],0,strpos($_SERVER["REQUEST_URI"],"&path"))."&path="}}{{str_replace(strrchr($_GET["path"],'/'), '',$_GET["path"])}}">Volver</a>                                            
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @endif
                            @foreach ($list_files_fm as $item)
                                <tr style="text-align:center;">                                    
                                    <td>
                                        @if ($item["type"] != "folder")
                                            {{$item["name"]}}  
                                        @else
                                            @if (strpos($_SERVER["REQUEST_URI"],"&path") !== false)
                                                <a href="{{substr($_SERVER["REQUEST_URI"],0,strpos($_SERVER["REQUEST_URI"],"&path"))."&path=".$item["path"]}}">{{$item["name"]}}</a>
                                            @else
                                                <a href="{{$_SERVER["REQUEST_URI"]."&path=".$item["path"]}}">{{$item["name"]}}</a>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        {{$item["type"]}}                                                  
                                    </td>
                                    <td>
                                        @if ($item["type"] != "folder")
                                            <button class="btn btn-md bg-info text-white">
                                                <i class="fas fa-eye"></i>
                                            </button>                                              
                                        @endif
                                    </td>
                                    <td>
                                        {{$item["date_in"]}}
                                    </td>
                                    <td>
                                        {{-- creador --}}
                                        {{$item["creator"]}}
                                    </td>
                                    <td>
                                        <button class="btn btn-md bg-primary text-white">  
                                            <i class="far fa-edit"></i>
                                        </button>  
                                    </td>
                                    <td>
                                        @if ($item["type"] != "folder")
                                            <button class="btn btn-md bg-primary text-white">  
                                                <i class="fas fa-cloud-download-alt"></i>
                                            </button>                                              
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-md bg-danger text-white"> <i class="fas fa-trash"></i> </button>                    
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
   
    {{-- Modal Agregar Archivo --}}
    <div class="modal fade" id="modalAddArchivo"  tabindex="-1" role="dialog" aria-labelledby="modalAddArchivoCenterTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddArchivoCenterTitle">Agregar Nuevo Archivo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="save_file_fm" id="newFile" class="was-validated" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input id="id_materia" class="form-control is-invalid" value="{{$_GET["materia"]}}" name="id_materia" hidden="">
                    <input id="id_curso_periodo" class="form-control is-invalid" value="{{$id_curso_periodo}}" name="id_curso_periodo" hidden="">
                    <input id="year" class="form-control is-invalid" value="{{$year}}" name="year" hidden="">
                    
                    <div class="modal-body">
                        
                        <div class="form-group">
                            <div class="custom-file" style="width:100%" >
                                <input type="file" class="custom-file-input" accept=".pdf,image/*" autocomplete="off" id="fileAdded" name="fileAdded"  onchange="loadFile(event)" required="" lang="es">
                                <label id="label_vac_file" for="fileAdded" class="custom-file-label" lang="es" >
                                    <i class="fa fa-cloud-upload"></i>Subir archivo...
                                </label>
                                <hr>
                                <div class="text-center">
                                    <img id="output" style="width:100%"/>
                                </div>                            
                                <br>
                            </div>                                
                        </div>                        
                    </div>
                    {{-- Image Functions --}}
                    <script>
                        var loadFile = function(event) {
                            var output = document.getElementById('output');
                            output.src = URL.createObjectURL(event.target.files[0]);
                            output.onload = function() {
                                URL.revokeObjectURL(output.src) // free memory
                            }
                        };
                        // Send vaccine file
                        function file_extension(filename){
                            return (/[.]/.exec(filename)) ? /[^.]+$/.exec(filename)[0] : undefined;
                        }
                        $('#fileAdded').change(function() {
                            var i = $(this).prev('label').clone();
                            var file = $('#fileAdded')[0].files[0].name;
                            var extension = file_extension(file);
                            if(extension == "pdf" || extension == "jpg" || extension == "png" || extension == "jpeg"){
                                if(extension == "pdf"){
                                    $("#output").hide();
                                }else{
                                    $("#output").show();
                                }
                                $("#saveNewFile").attr("disabled",false);
                            }else{
                                Swal.fire('Error!', 'el archivo no es válido.', 'error');
                                $("#saveNewFile").attr("disabled",true);
                                file = null;
                            }
                            $(this).prev('label').text(file);
                            console.log(extension);
                        });

                    </script>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="closeModalBtn" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success" id="saveNewFile" disabled >Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal Agregar Carpeta --}}
    <div class="modal fade" id="modalAddCarpeta" tabindex="-1" role="dialog" aria-labelledby="modalAddCarpetaCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAddCarpetaCenterTitle">Agregar Nueva Carpeta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="addFolder_FM" class="was-validated" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input id="id_materia" class="form-control is-invalid" value="{{$_GET["materia"]}}" name="id_materia" hidden="">
                    <input id="id_curso_periodo" class="form-control is-invalid" value="{{$id_curso_periodo}}" name="id_curso_periodo" hidden="">
                    <input id="year" class="form-control is-invalid" value="{{$year}}" name="year" hidden="">
                    <input id="path_folder" class="form-control is-invalid" value="{{$path}}" name="path_folder" hidden="">
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputNombreCarpeta">Nombre</span>
                            </div>
                            <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputNombreCarpeta" id="addFolder" name="addFolder">
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="sumbit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if (Session::has('msj'))
        <script>                                
            Swal.fire('Error!', "{{Session::get('msj')}}", 'error');
            
        </script>  
        @php
            Session::forget('msj');
        @endphp
    @endif
    {{-- Data Table --}}
    <script>
        $(document).ready( function () {
            $('#gestorArchivosTable').DataTable({
                "order": [1, "asc" ],
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Filas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Filas",
                    "infoFiltered": "(Filtrado de _MAX_ total Filas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Filas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                        }
                },
            });
        } );
    </script>
</div>