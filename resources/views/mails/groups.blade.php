<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Correos
@endsection

@section("headex")
<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
})
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.11/jquery.autocomplete.min.js" integrity="sha512-uxCwHf1pRwBJvURAMD/Gg0Kz2F2BymQyXDlTqnayuRyBFE7cisFCh2dSb1HIumZCRHuZikgeqXm8ruUoaxk5tA==" crossorigin="anonymous"></script>
<style>.autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
.autocomplete-selected { background: #F0F0F0; }
.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
.autocomplete-group { padding: 2px 5px; }
.autocomplete-group strong { display: block; border-bottom: 1px solid #000; }</style>
@endsection

@section("context")
<br>
<h5 class="card-title m-3" >Grupos</h5>
<div class="row" style="margin:0;">
  <div class="col-3">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
      <a class="nav-link active" id="v-pills-select_group-tab" data-toggle="pill" href="#v-pills-select_group" role="tab" aria-controls="v-pills-select_group" aria-selected="true">Ver y Editar Grupos</a>
      <a class="nav-link" id="v-pills-create_group-tab" data-toggle="pill" href="#v-pills-create_group" role="tab" aria-controls="v-pills-create_group" aria-selected="false">Crear Grupo</a>   
    </div>
  </div>
  <div class="col-9">
    <div class="tab-content" id="v-pills-tabContent">
      <div class="tab-pane fade show active" id="v-pills-select_group" role="tabpanel" aria-labelledby="v-pills-select_group-tab">
      <div class="card card-mt-3 ml-3 mr-3"  >
            <div class="card-body">      
                <form  action="" method="GET">
                    <div class="table-responsive-sm table-bordered ">
                        <table class="table" id="createdGroups">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Encargado</th>
                                    <th scope="col">Editar</th>
                                    <th scope="col">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list_groups as $row)
                                    @if($row["dni_creador"] == Session::get('account')['dni'] || Session::get('account')['is_admin']=='YES' && $row["id_creador"] != "INS")
                                        <tr>                                                                                                                      
                                            <td>
                                                @if($row["id_creador"] != "INS")
                                                    <span id="spanRow{{$row["id_grupo"]}}">{{$row["nombre"]}}</span>
                                                @else
                                                    {{$row["nombre"]}}
                                                @endif
                                            </td>
                                            <td>{{$row["encargado"]}}</td>
                                            @if($row["dni_creador"] == Session::get('account')['dni'] || Session::get('account')['is_admin']=='YES')
                                                @if(Session::get('account')['is_admin']=='YES' && $row["id_creador"] == "INS")
                                                    <td>
                                                        <button type="button" class="btn btn-primary" disabled="" data-toggle="modal" data-target=".bd-example-modal-xl" >Editar</button>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-danger btn-sm" disabled="">Eliminar</button>
                                                    </td>
                                                @else
                                                    <td>
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-xl" id="modalEditGroup{{$row["id_grupo"]}}">Editar</button>
                                                        <script>
                                                            $("#modalEditGroup{{$row["id_grupo"]}}").click(function(){
                                                                Swal.fire({
                                                                    icon: 'info',
                                                                    title: 'Cargando',
                                                                    showConfirmButton: false,
                                                                })
                                                                $.ajax({
                                                                    type: "GET",
                                                                    url: "/modal_edit_group",
                                                                    data:{
                                                                        nombre:'{{$row["nombre"]}}',
                                                                        encargado:'{{$row["encargado"]}}',
                                                                        id_grupo:'{{$row["id_grupo"]}}'
                                                                    },
                                                                    success: function (data)
                                                                    {
                                                                        $("#modalContent").html(data);
                                                                        Toast.fire({
                                                                            icon: 'success',
                                                                            title: 'Completado'
                                                                        })
                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                    </td>
                                                    <td>
                                                        <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelBtn({{$row["id_grupo"]}})" >Eliminar</a>
                                                        <script>
                                                            
                                                            function confirmDelBtn(id_grupo_del){                                                            
                                                                Swal.fire({
                                                                    title: 'Estas seguro?',
                                                                    icon: 'warning',
                                                                    showCancelButton: true,
                                                                    confirmButtonColor: '#3085d6',
                                                                    cancelButtonColor: '#d33',
                                                                    confirmButtonText: 'Si, eliminar!'
                                                                    }).then((result) => {
                                                                    if (result.isConfirmed) {
                                                                        Swal.fire(
                                                                        'Borrado!',
                                                                        'El grupo se ha eliminado correctamente.',
                                                                        'success',
                                                                        window.location.href = "del_group?id="+id_grupo_del
                                                                        )
                                                                    }
                                                                })
                                                            }
                                                        </script>
                                                    </td>
                                                @endif
                                            @else
                                                <td>
                                                    <button type="button" class="btn btn-primary" disabled="" data-toggle="modal" data-target=".bd-example-modal-xl">Editar</button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger btn-sm" disabled="">Eliminar</button>
                                                </td>
                                            @endif
                                            
                                        </tr>
                                    @endif
                                @endforeach
                                <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" >
                                        <div class="modal-content" id="modalContent">
                                        </div>
                                    </div>
                                </div> 
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
      </div>
      <div class="tab-pane fade" id="v-pills-create_group" role="tabpanel" aria-labelledby="v-pills-create_group-tab">
        <div class="card card-mt-3 ml-3 mr-3"  >
            <div class="card-body">      
                <form  action="/create_group" method="GET">
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <input type="text" class="form-control" name="nombre_grupo" minlength="4" placeholder="Nombre de Grupo" id="nombre_grupo" required="">
                        </div>
                        <div class="form-group col-md-4">
                            <label style="color:transparent;">.</label>
                            <button type="submit" class="btn btn-success">Agregar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
      
    </div>
  </div>
</div>
<script>
        $(document).ready( function () {
            $('#createdGroups').DataTable({
                    order: [1],
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Filas",
                        "infoEmpty": "Mostrando 0 to 0 of 0 Filas",
                        "infoFiltered": "(Filtrado de MAX total Filas)",
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
@endsection