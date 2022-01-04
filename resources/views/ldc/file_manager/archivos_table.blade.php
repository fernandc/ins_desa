<div class="card" id="cardTableFiles">
    <div class="card-header" style="overflow-x: auto" >
        <div>
            <h3>Gestor de Archivos <i>{{$materias[$_GET["materia"]]}}</i> </h3>
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
        <br>
        <div class="row">
            <div class="col-md-12">
                @include('ldc.file_manager.nav_breadcrumb_file_manager')
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
                            <th scope="col">Fecha de creación</th>
                            <th scope="col">Creador</th>
                            <th scope="col">Editar</th>
                            <th scope="col">Descargar</th>
                            {{-- <th scope="col">Eliminar</th> --}}
                            </tr>
                        </thead>
                        <tbody>

                            @if (isset($_GET["path"]) && (strlen("public/FileManager/$year/$id_curso/".$_GET['materia']) < strlen($_GET['path'])) )
                                
                            <tr style="text-align:center;">                                    
                                <td>                       
                                    <a href="{{substr($_SERVER["REQUEST_URI"],0,strpos($_SERVER["REQUEST_URI"],"&path"))."&path="}}{{str_replace(strrchr($_GET["path"],'/'), '',$_GET["path"])}}">Volver</a>                                            
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                {{-- <td></td> --}}
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
                                        {{$item["date_in"]}}
                                    </td>
                                    <td>
                                        {{-- creador --}}
                                        {{$item["creator"]}}
                                    </td>
                                    <td>
                                        <button class="btn btn-md bg-warning text-white btn-edit-name" data-id="{{$item["id"]}}" data-name="{{$item["name"]}}" data-path="{{$item["path"]}}" data-parent="{{$item["parent_folder"]}}" data-type="{{$item["type"]}}" id="editBtn" data-toggle="modal" data-target="#modalEditItem">  
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </td>
                                    <td>
                                        @if ($item["type"] != "folder")
                                            <a class="btn btn-md bg-primary text-white" target="_blank" href="/downloadFile_FM?path={{$item["path"]}}" id="downloadBtn">  
                                                <i class="fas fa-cloud-download-alt"></i>
                                            </a>                                              
                                        @endif
                                    </td>
                                    {{-- <td>
                                        <button class="btn btn-md bg-danger text-white" hidden="true"> <i class="fas fa-trash"></i> </button>                    
                                    </td> --}}
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
                @include('ldc.file_manager.modals.modal_add_file')
            </div>
        </div>
    </div>
    {{-- Modal Agregar Carpeta --}}
    <div class="modal fade" id="modalAddCarpeta" tabindex="-1" role="dialog" aria-labelledby="modalAddCarpetaCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                @include('ldc.file_manager.modals.modal_add_folder')
            </div>
        </div>
    </div>
    {{-- Modal Editar Item --}}
    <script>
        $(".btn-edit-name").click(function(){
            var id = $(this).attr("data-id");
            var name = $(this).attr("data-name");
            var path = $(this).attr("data-path");
            var parent = $(this).attr("data-parent");
            var type = $(this).attr("data-type");
            $("#spnEditName").html(name);
            $("#renameId").val(id);
            $("#renameName").val(name);
            $("#renamePath").val(path);
            $("#renameParent").val(parent);
            $("#renameType").val(type);
            if(type == "folder"){
                $("#newNameItem").val(name);
            }else{
                $("#newNameItem").val(name.substring(0,name.length - type.length - 1));
            }
            
        });
    </script>
    <div class="modal fade" id="modalEditItem" tabindex="-1" role="dialog" aria-labelledby="modalEditItemCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                @include('ldc.file_manager.modals.modal_edit_item')
            </div>
        </div>
    </div>
    {{-- Alert Error Carpeta/Archivo --}}
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