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
                                <button class="fas fa-trash-alt btn btn-light bdelete" style="border: white; background-color:transparent; color:red"></button>  
                            @endif
                        </td>
                        <td><button class="btn btn-outline-primary btn-sm data-priv" data="{{$row["rut"]}}" data-toggle="modal" data-target=".bd-example-modal-xl">Administrar</button></td>
                    </tr>                
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
                Swal.fire({
                    title: 'Estás seguro?',
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Continuar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Eliminado',
                            '',
                            'success'
                            )
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