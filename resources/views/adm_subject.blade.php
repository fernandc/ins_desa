<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Admin Asignaturas
@endsection

@section("headex")
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.11/jquery.autocomplete.min.js" integrity="sha512-uxCwHf1pRwBJvURAMD/Gg0Kz2F2BymQyXDlTqnayuRyBFE7cisFCh2dSb1HIumZCRHuZikgeqXm8ruUoaxk5tA==" crossorigin="anonymous"></script>
<style>.autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
.autocomplete-selected { background: #F0F0F0; }
.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
.autocomplete-group { padding: 2px 5px; }
.autocomplete-group strong { display: block; border-bottom: 1px solid #000; }</style>
@endsection

@section("context")
<div class="container">
    <br>
    <h2 style="text-align: center;">Administrar Asignaturas  
            @if(Session::has('period'))
                {{Session::get('period')}}
            @endif            
    </h2>
    @if(isset($message))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{$message}}',
                })
        </script>
    @endif
    <br>
    <button class="btn btn-success " type="button" data-toggle="collapse" data-target="#collapseStudents" aria-expanded="false" aria-controls="collapseStudents">Agregar Asignatura</button>
    <br>
    <div class="collapse mt-2" id="collapseStudents">
        <!--  -->
        <form  action="/add_subject" method="GET">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" hidden="" id="idMateria" name="idMateria">
                    <input type="text" class="form-control"  placeholder="Buscar...(ej: Matemática)" id="autocomplete">
                    <script>
                        var countries = [ 
                            @foreach($subject_list as $row)
                                { data: '{{$row["id"]}}', value: '{{$row["name"]}}' },                    
                            @endforeach
                        ];
                        $("#autocomplete").keyup(function(){
                            $("#autocomplete").addClass('is-invalid');
                            $("#autocomplete").removeClass('is-valid');
                        });
                        
                        $('#autocomplete').autocomplete({
                            minChars: 3,
                            lookup: countries,
                            onSelect: function (suggestion) {
                                $("#idMateria").val(suggestion.data);
                                $("#autocomplete").addClass('is-valid');
                                $("#autocomplete").removeClass('is-invalid');
                            }
                        });
                    </script>
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </form>
    </div>
    <br>
    <div class="table-responsive" >
        <table class="table table-sm" style="text-align: center;" id="list_subject">
            <thead class="thead-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">#</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subject_current_list as $row)
                    <tr>
                        <td>{{$row["id_materia"]}}</td>
                        <td>{{$row["materia"]}}</td>                        
                        <td>
                            <a href="del_subject?id={{$row["id_materia"]}}" class="btn btn-danger" >Eliminar</a>
                        </td>
                    </tr>               
                @endforeach      
            </tbody>
        </table>
    </div>
    <script>
        $(document).ready( function () {
            $('#list_subject').DataTable({
                    order: [],
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
</div>
@endsection