<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Seguimiento 
@endsection

@section("headex")

@endsection

@section("context")
<div class="container">
    <h3>Correos Enviados</h3>
    
    <table class="table table-sm">
        <thead class="thead-light">
          <tr>
            <th scope="col">Fecha</th>
            <th scope="col">Asunto</th>
            <th scope="col">Seguimiento</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>10/01/2021 08:50:00</td>
            <th><a href=""><i class="far fa-envelope mr-2" ></i> <span class="text-danger">Suspención de clases</span> <i class="fas fa-exclamation-circle text-danger"></i></a></th>           
            <td><button class="btn btn-primary">Seguimiento</button></td>
          </tr>
          <tr>
            <td>10/02/2021 08:30:00</td>
            <th><a href=""><i class="far fa-envelope mr-2"></i><span class="text-success">Tarea de investigación</span> <i class="fas fa-info-circle text-success"></a></i></th>
            <td><button class="btn btn-primary">Seguimiento</button></td>
          </tr>
          <tr>
            <td>10/01/2021 08:50:00</td>
            <th><a href=""><i class="far fa-envelope mr-2"></i><span class="text-info">Reunion de profesores</span> <i class="fas fa-info-circle text-info"></a></th>
            <td><button class="btn btn-primary">Seguimiento</button></td>
          </tr>
        </tbody>
      </table>
</div>

@endsection