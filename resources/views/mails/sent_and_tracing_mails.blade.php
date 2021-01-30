<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Seguimiento 
@endsection

@section("headex")

@endsection

@section("context")
<div class="container">
    <h3>Correos Enviados y Seguimiento</h3>
    <hr>
    <div class="table-responsive">
      <table class="table table-sm" id="tableSentMails">
          <thead class="thead-light">
              <tr>
                  <th scope="col">Fecha</th>
                  <th scope="col">Asunto</th>
                  <th scope="col"><i class="fas fa-paper-plane"></i></th>
                  <th scope="col"><i class="fas fa-glasses"></i></th>
                  <th scope="col">Seguimiento</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($info_mails as $row)
                  @if ($row["dni_staff"] == Session::get('account')["dni"] || (Session::get('account')['is_admin']=='YES'))
                      <tr>
                          <td>
                              @if(isset($row["fecha_para"]))
                                  {{$row["fecha_para"]}} <span class="badge badge-warning">P</span>
                              @else
                                  {{$row["fecha_emision"]}}    
                              @endif
                          </td>
                          <td>
                            @if ($row["tipo_mail"] == 1)
                              <a href="" data-toggle="modal" data-target="#modalCorreo{{$row["id_mail"]}}"><i class="far fa-envelope mr-2" ></i> <span class="text-primary">{{$row["titulo"]}}</span> <i class="fas fa-info-circle text-primary"></i></a>
                            @elseif($row["tipo_mail"] == 2)  
                              <a href="" data-toggle="modal" data-target="#modalCorreo{{$row["id_mail"]}}"><i class="far fa-envelope mr-2" ></i> <span class="text-info">{{$row["titulo"]}}</span> <i class="fas fa-info-circle text-info"></i></a>
                            @elseif($row["tipo_mail"] == 3)  
                              <a href="" data-toggle="modal" data-target="#modalCorreo{{$row["id_mail"]}}"><i class="far fa-envelope mr-2" ></i> <span class="text-succes">{{$row["titulo"]}}</span> <i class="fas fa-info-circle text-succes"></i></a>
                            @elseif($row["tipo_mail"] == 4)  
                              <a href="" data-toggle="modal" data-target="#modalCorreo{{$row["id_mail"]}}" ><i class="far fa-envelope mr-2" ></i> <span class="text-danger">{{$row["titulo"]}}</span> <i class="fas fa-exclamation-circle text-danger"></i></a>             
                            @endif
                            
                            <div class="modal fade" id="modalCorreo{{$row["id_mail"]}}" tabindex="-1" role="dialog" aria-labelledby="modalCorreoTitle" aria-hidden="true">
                              <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content" >
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="modalCorreoLabel">Correo enviado por: {{$row["nombre_staff"]}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <div class="card">
                                      @if ($row["tipo_mail"] == 1)
                                        <div class="card-header bg-primary text-white">
                                          {{$row["titulo"]}}
                                        </div>
                                      @elseif($row["tipo_mail"] == 2)
                                        <div class="card-header bg-info text-white">
                                          {{$row["titulo"]}}
                                        </div>
                                      @elseif($row["tipo_mail"] == 3)
                                        <div class="card-header bg-success text-white">
                                          {{$row["titulo"]}}
                                        </div>
                                      @elseif($row["tipo_mail"] == 4)  
                                        <div class="card-header bg-danger text-white">
                                          {{$row["titulo"]}}
                                        </div> 
                                      @endif
                                      <div class="card-body">
                                        <span>{{$row["mensaje"]}}</span>                   
                                      </div>
                                    </div>
                                  </div>
                                  <div class="container mx-3">
                                    <br>
                                    @if (isset($row["attachments"]))
                                        <footer class="blockquote-footer">{{count($row["attachments"])}} Archivo(s) adjuntos</footer> 
                                    @endif
                                    <br>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>     
                          <td>{{$row["destinatarios"]}}</td>      
                          <td>{{$row["leidos"]}}</td>      
                          <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalCenterTracing" id="modalCorreoSent{{$row["id_mail"]}}">
                              Seguimiento
                            </button>
                            <script>
                              $("#modalCorreoSent{{$row["id_mail"]}}").click(function(){
                                  $.ajax({
                                      type: "GET",
                                      url: "destinatarios_sent_mails",
                                      data:{
                                        id_mail: "{{$row["id_mail"]}}"
                                      },
                                      success: function (data)
                                      {
                                          $("#modalContentSent").html(data);
                                      }
                                  });
                              });
                            </script>
                                      
                          </td>
                      </tr> 
                  @endif  
              @endforeach
              <!-- Modal -->
              <div class="modal fade" id="exampleModalCenterTracing" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTracingTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                  <div class="modal-content" id="modalContentSent">
                  </div>
                </div>
              </div>
              <!-- Modal -->
          </tbody>
      </table>
    </div>
</div>
<script>
  $(document).ready( function () {
      $('#tableSentMails').DataTable({
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
@endsection