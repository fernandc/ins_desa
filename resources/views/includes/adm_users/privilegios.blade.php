<div class="tab-pane fade show active" id="privileges" role="tabpanel" aria-labelledby="privileges-tab">
    <div class="table-responsive">
        <table class="table " style="text-align: center;" id="lista_staff">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Rut</th>
                    <th scope="col">Nombre Completo</th>
                    <th scope="col">Email Institucional</th>
                    <th scope="col">Administrador</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Privilegios</th>
                </tr>
            </thead>
            <tbody>
                @foreach($staff as $row)
                    @if ($row["eliminado"] != "YES")
                        <tr>
                            <td>{{$row["rut"]}}</td>
                            <td>{{$row["nombres"]}} {{$row["apellido_paterno"]}} {{$row["apellido_materno"]}}</td>
                            <td>{{$row["email_institucional"]}}</td>
                            <td>
                                @if($row["administrador"]=="YES")
                                    <a href="change_staff_admin?dni={{$row["rut"]}}" class="btn btn-primary btn-sm text-white" style="width: 45px">Si</a>
                                @else   
                                    <a href="change_staff_admin?dni={{$row["rut"]}}" class="btn btn-secondary btn-sm text-white" style="width: 45px">No</a>
                                @endif
                            </td>
                            <td>
                                @if($row["estado"] == 1)
                                    <a href="change_staff_status?dni={{$row["rut"]}}" class="btn btn-primary btn-sm">Activado</a>    
                                @else
                                    <a href="change_staff_status?dni={{$row["rut"]}}" class="btn btn-secondary btn-sm">Desactivado</a>
                                    <button class="fas fa-trash-alt btn btn-danger bdelete" data="{{$row["rut"]}}" ></button>  
                                @endif
                            </td>
                            <td><button class="btn btn-outline-primary btn-sm data-priv" data="{{$row["rut"]}}" data-toggle="modal" data-target=".bd-example-modal-xl">Administrar</button></td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <script>
             $(".data-priv").click(function(){
                var dni = $(this).attr('data');
                Swal.fire({
                    icon: 'info',
                    title: 'Cargando',
                    showConfirmButton: false,
                })
                $.ajax({
                    type: "GET",
                    url: "modal_privileges",
                    data:{
                        dni
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
            $(".bdelete").on("click", function() {
                var dni = $(this).attr("data");
                Swal.fire({
                    title: '¿Estás seguro de eliminar al usuario con rut: '+dni+'?',
                    text: "Importante: este usuario no será eliminado dentro del sistema, ya que toda la informacion cargada o relacionada con este usuario conservará su registro. " +
                        "El usuario será desactivado permanentemente y no será visible en el sistema.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#8c8c8c',
                    confirmButtonText: 'Si, Eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                         url: "delete_user",
                         type: "POST",
                         data:{
                            "_token": "{{ csrf_token() }}",
                            dni
                         },
                         success:function(data){
                            //console.log("data: ",data);
                            $("*[data=\"" + dni + "\"]").parent().parent().remove();
                            Toast.fire({
                                icon: 'success',
                                title: 'Eliminando'
                            })}
                        });
                    }
                  })
            });
        </script>
        <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" >
                <div class="modal-content" id="modalContent">
                </div>
            </div>
        </div>
    </div>
</div>