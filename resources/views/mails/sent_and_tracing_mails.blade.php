<!DOCTYPE html> 
@extends("layouts.mcdn")
@section("title")
Seguimiento 
@endsection

@section("headex")
  
@endsection

@section("context")
<div class="mx-5">
    <h3 id="result">Correos Enviados y Seguimiento</h3>
    <hr>
    <div class="table-responsive">
      <table class="table table-sm" id="tableSentMails">
          <thead class="thead-light">
              <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Asunto</th>
                <th scope="col"><i class="fas fa-envelope tooltip-info" data-toggle="tooltip" data-placement="top" title="Cantidad de destinatarios"></i></th>
                <th scope="col"><i class="fas fa-paper-plane tooltip-info" data-toggle="tooltip" data-placement="top" title="Cantidad de correos enviados"></i></th>
                <th scope="col"><i class="fas fa-envelope-open tooltip-info" data-toggle="tooltip" data-placement="top" title="Cantidad de correos leídos"></i></th>
                <th scope="col">Seguimiento</th>
              </tr>
          </thead>
          <tbody>
              @foreach ($info_mails as $row)
                  @if ($row["dni_staff"] == Session::get('account')["dni"] || (Session::get('account')['is_admin']=='YES'))
                      <tr>
                          <td>
                            @if(isset($row["fecha_para"]))
                              @if($row["estado"] == "ENVIADO")
                              <span class="text-success">{{$row["fecha_para"]}}</span> <span class="badge badge-warning tooltip-info" data-toggle="tooltip" data-placement="top" title="Correo Programado">P</span>  
                              @else
                              <span class="text-warning">{{$row["fecha_para"]}}</span> <span class="badge badge-warning tooltip-info" data-toggle="tooltip" data-placement="top" title="Correo Programado">P</span>
                              @endif
                            @else
                              <span class="text-success">{{$row["fecha_emision"]}}</span>    
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
                              <a href="" data-toggle="modal" data-target="#modalCorreo{{$row["id_mail"]}}" ><i class="far fa-envelope mr-2" ></i> <span class="text-primary">{{$row["titulo"]}}</span> <i class="fas fa-exclamation-circle text-danger"></i></a>
                              @elseif($row["tipo_mail"] == 5)  
                              <a href="" data-toggle="modal" data-target="#modalCorreo{{$row["id_mail"]}}" ><i class="far fa-envelope mr-2" ></i> <span class="text-primary">{{$row["titulo"]}}</span> <i class="fas fa-exclamation-circle text-danger"></i></a>
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
                                          <span style="white-space: pre-line;">{!! $row["mensaje"] !!}</span>                   
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
                                    @if(isset($row["fecha_para"]))
                                      <p id="timeRem" style="display: none;">
                                        <span id="days{{$row["id_mail"]}}" class="text-warning"></span ><span class="text-warning"> días / </span><span id="hours{{$row["id_mail"]}}" class="text-warning"></span><span class="text-warning"> horas / </span><span id="minutes{{$row["id_mail"]}}" class="text-warning"></span><span class="text-warning"> minutos / </span><span id="seconds{{$row["id_mail"]}}"  class="text-warning"></span><span class="text-warning"> segundos </span>                                    
                                      </p>  
                                      <button type="button" style="display: none;" id="delMail{{$row["id_mail"]}}" class="btn btn-danger btn-sm" onclick='val_date("{{$row["id_mail"]}}")'>Eliminar</button>
                                    @endif
                                    {{-- script --}}
                                    <script>
                                      @if(isset($row["fecha_para"]))
                                        document.addEventListener('DOMContentLoaded', () => { 
                                          //===
                                          var dateins = '{{$row["fecha_para"]}}';
                                          var id = '{{$row["id_mail"]}}';
                                          var fdateC = dateins.split(" ");
                                          var dateF = fdateC[0];
                                          var hourF = fdateC[1];
                                          dateF = dateF.split("-");
                                          hourF = hourF.split(":");
                                          var DATE_TARGET = new Date(dateF[0],dateF[1]-1,dateF[2],hourF[0],hourF[1],hourF[2])
                                          const asd = new Date();
                                          //===
                                          // DOM for render
                                          const SPAN_DAYS = document.querySelector('span#days'+id);
                                          const SPAN_HOURS = document.querySelector('span#hours'+id);
                                          const SPAN_MINUTES = document.querySelector('span#minutes'+id);
                                          const SPAN_SECONDS = document.querySelector('span#seconds'+id);
                                          // Milliseconds for the calculations
                                          const MILLISECONDS_OF_A_SECOND = 1000;
                                          const MILLISECONDS_OF_A_MINUTE = MILLISECONDS_OF_A_SECOND * 60;
                                          const MILLISECONDS_OF_A_HOUR = MILLISECONDS_OF_A_MINUTE * 60;
                                          const MILLISECONDS_OF_A_DAY = MILLISECONDS_OF_A_HOUR * 24
                                          function updateCountdown() {
                                            // Calcs
                                            const NOW = new Date();
                                            const DURATION = DATE_TARGET - NOW;
                                            const REMAINING_DAYS = Math.floor(DURATION / MILLISECONDS_OF_A_DAY);
                                            const REMAINING_HOURS = Math.floor((DURATION % MILLISECONDS_OF_A_DAY) / MILLISECONDS_OF_A_HOUR);
                                            const REMAINING_MINUTES = Math.floor((DURATION % MILLISECONDS_OF_A_HOUR) / MILLISECONDS_OF_A_MINUTE);
                                            const REMAINING_SECONDS = Math.floor((DURATION % MILLISECONDS_OF_A_MINUTE) / MILLISECONDS_OF_A_SECOND);
                                            // Render
                                            SPAN_DAYS.textContent = REMAINING_DAYS;
                                            SPAN_HOURS.textContent = REMAINING_HOURS;
                                            SPAN_MINUTES.textContent = REMAINING_MINUTES;
                                            SPAN_SECONDS.textContent = REMAINING_SECONDS;
                                            if(REMAINING_MINUTES >= 5 ){
                                              $('#delMail{{$row["id_mail"]}}').show();
                                              $('#timeRem').show();
                                              
                                            }
                                          }
                                          
                                          //===
                                          // INIT
                                          //===
                                          updateCountdown();
                                          // Refresh every second
                                          setInterval(updateCountdown, MILLISECONDS_OF_A_SECOND);
                                                
                                        });
                                      @endif
                                      
                                    </script>
                                    {{-- script --}}
                                    <button type="button" id="btnCerrarModal{{$row["id_mail"]}}" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td>{{$row["destinatarios"]}}</td>
                          <td>{{$row["enviados"]}}</td>
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
              <script>
                function val_date(id){
                  Swal.fire({
                    icon: 'info',
                    title: 'Cargando',
                    showConfirmButton: false                  
                    })
                  $.ajax({
                          type: "GET",
                          url: "eliminar_correo",
                          data:{
                            id_mail: id
                          },
                          success: function (data)
                          {                                                                                            
                            location.reload();                                                                                          
                          }
                    });
                }
              </script>
              <!-- Modal -->
              <div class="modal fade" id="exampleModalCenterTracing" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTracingTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
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
    $('.tooltip-info').tooltip();
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