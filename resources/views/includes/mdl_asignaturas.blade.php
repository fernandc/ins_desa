
<div class="modal-header">
    <h5 class="modal-title" id="result">Cursos y Asignaturas de {{$full_name}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="table-responsive table-bordered">
        <table class="table table-sm" style="text-align: center;" id="">
            <thead class="thead-light">
                <tr>
                    <th scope="col"  style="width: 30px"></th>
                    @foreach($cursos as $curso)
                        <th scope="col" style="width: 30px">{{$curso["abreviado"]}}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($asignaturas as $asignatura)
                <tr>
                    <td>{{$asignatura["materia"]}}</td>
                    @foreach($cursos as $curso)
                        <?php $checked = ""; ?>
                        @foreach($activos as $active)
                            @if($active["id_curso_periodo"] == $curso["id"] && $active["id_materia"] == $asignatura["id_materia"])
                                <?php $checked = 'checked=""'; ?>
                            @endif
                        @endforeach
                        <td scope="col">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" {{$checked}} class="custom-control-input input-trigger" datac="{{$curso["id"]}}" datam="{{$asignatura["id_materia"]}}"  id="cursos{{$curso["id"]}}-{{$asignatura["id_materia"]}}" >
                                <label class="custom-control-label text-success" for="cursos{{$curso["id"]}}-{{$asignatura["id_materia"]}}"></label>
                            </div>
                        </td>
                    @endforeach
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
    var id_curso = $(this).attr('datac');
    var id_materia = $(this).attr('datam');
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
        url: "set_asignatura",
        data:{
            dni: '{{$dni}}',
            idCurso: id_curso,
            idMateria: id_materia,
            method: metodo,
        },
        success: function (data)
        {
            //$("#result").html(data);
           
            Toast.fire({
                icon: 'success',
                title: 'Completado'
            })
        }
    });
});
</script>