<!DOCTYPE html> 

<?php
    $period = $periods["active_period"];
?>
@extends("layouts.mcdn")
@section("title")
Administrar Periodos
@endsection

@section("headex")

@endsection

@section("context")
    @if(isset($message))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{$message}}',
                })
        </script>
    @endif
    <div class="container">
        <h2 style="text-align: center;">Administrar Periodos</h2>
        <hr>
        <form action="add_new_period" method="GET">
            <div class="form-row">
                <div class="col-3">
                </div>
                <div class="col">
                    <input type="number" min="2000" max="{{(int) date("Y") +1}}" value="{{(int) date("Y") +1}}" class="form-control" name="year">
                </div>
                <div class="col">
                    <button class="btn btn-primary" id="btn_periodo" >Agregar nuevo periodo</button>
                </div>
                <div class="col-3">
                </div>
            </div>
        </form>
        <hr>
        <table class="table table-sm" style="text-align: center;">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Año</th>
                    <th scope="col">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($periods["list_periods"] as $row)
                    <tr>
                        <td>{{$row["year"]}}</td>
                        <td>
                            @if($row["status"] == 1)
                                <a href="change_period?year={{$row["year"]}}" class="btn btn-primary btn-sm">Activado</a>    
                            @else
                                <a href="change_period?year={{$row["year"]}}" class="btn btn-secondary btn-sm">Desactivado</a>
                            @endif
                        </td>
                    </tr>                
                @endforeach             
            </tbody>
        </table>
    </div>
@endsection