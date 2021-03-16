
<div class="modal-header">
    <h5 class="modal-title" id="result">Privilegios de usuario</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="table-responsive ">
        <table class="table table-bordered table-sm" style="text-align: center;" id="">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Sección</th>
                    <th scope="col">Nombre del Privilegio</th>
                    <th scope="col">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($all_privileges as $privileges)
                <tr>
                    <td>{{$privileges["section"]}}</td>
                    <td>{{$privileges["name"]}}</td>
                    <td>
                        @php
                            $checked = "";
                        @endphp
                        @foreach ($user_privileges as $user_privs)
                            @if ($user_privs["id_privilege"] == $privileges["id"])
                                @php
                                    $checked = 'checked=""';
                                @endphp
                            @endif
                        @endforeach
                        <div class="custom-control custom-switch">
                            <input type="checkbox" {{$checked}} class="custom-control-input input-trigger" data="{{$privileges["id"]}}" id="privilege{{$privileges["id"]}}">
                            <label class="custom-control-label text-success" for="privilege{{$privileges["id"]}}"></label>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
</div>
<script>
    $(".input-trigger").click(function(){
        Swal.fire({
            icon: 'info',
            title: 'Cargando',
            showConfirmButton: false,
            timer: 3000,
        });
        var id_priv = $(this).attr('data');
        var metodo = null
        if($(this).is(":checked")){
            metodo = "add";
        }
        else{
            metodo = "del";
        }
        //alert(metodo);
        $.ajax({
            type: "GET",
            url: "change_privilege",
            data:{
                dni: '{{$dni}}',
                id_priv: id_priv,
                method: metodo
            },
            success: function (data)
            {
                Toast.fire({
                    icon: 'success',
                    title: 'Completado'
                })
            }
        });
    });
    </script>