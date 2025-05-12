@extends('layouts.app')
@php
    $fechaActual = date('Y-m-d');
@endphp
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Ratificaciones</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped mt-2">
                                        <thead style="background-color: #4A001F;">
                                            <th style="color: #fff;">Folio</th>
                                            <th style="color: #fff;">Fecha</th>
                                            <th style="color: #fff;">Empresa</th>
                                            <th style="color: #fff;">Telefono</th>
                                            <th style="color: #fff;">Correo</th>
                                            <th style="color: #fff;">Trabajador</th>
                                            <th style="color: #fff;">Estatus</th>
                                            <th style="color: #fff;">Detalles</th>
                                            <th style="color: #fff;">Concluir</th>
                                            <th style="color: #fff;">Documentos</th>
                                        </thead>
                                        <tbody>
                                            @foreach($solicitudes as $solicitud)
                                                <tr>
                                                    <td>{{$solicitud->id}}</td>
                                                    <td>{{$solicitud->fecha}}</td> 
                                                    <td>{{$solicitud->empresa}}</td>
                                                    <td>{{$solicitud->telefono}}</td>
                                                    <td>{{$solicitud->email}}</td>
                                                    <td>{{$solicitud->trabajador}}</td>
                                                    <td>{{$solicitud->estatus}}</td>
                                                    <td><a class="btn btn-primary" href="{{ route('seer.estadistica_consultar', $solicitud->id) }}" onclick=consultar_estadistica();>Consultar</a></td>
                                                    <td>
                                                        @if($solicitud->estatus == "Confirmado")
                                                            <a class="btn btn-info" href="{{ route('ratificacion_concluir', $solicitud->id) }}" onclick=consultar_estadistica();>Concluir</a>
                                                        @endif
                                                        @if($solicitud->estatus == "Concluida Pagos")
                                                            <a class="btn btn-info" href="{{ route('ratificacion_pagar', $solicitud->id) }}" onclick=consultar_estadistica();>Pagar</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($solicitud->estatus == "Conluida" || $solicitud->estatus == "Concluida Pagos")
                                                            <a class="btn btn-success" href="{{ route('PDFconvenio', $solicitud->id) }}" onclick=consultar_estadistica(); tarjet="_black">Convenio</a>
                                                        @elseif($solicitud->estatus == "Confirmado")
                                                            <a class="btn btn-success" href="{{ route('PDFratifi', $solicitud->id) }}" onclick=consultar_estadistica(); tarjet="_black">Acuse</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            <!-- Centramos la paginación a la derecha-->
                            <div class="pagination justify-content-end">
                            </div>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class='needs-validation novalidate'  method='POST' action="{{route('rechazar_turnos')}}">
        @csrf
        <input type="hidden" id="modal-id" name="id" value="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Motivo de rechazo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea name="observaciones" style="width:100%"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="nuevo_poder" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>

@section('scripts')
    <script>
        $('.open-modal').click(function() {
            const id = $(this).data('id'); // Obtiene el valor de data-id
            document.getElementById('modal-id').value = id;
        });
    </script>
    <script src="../public/assets/js/poderes/general.js"></script>
@endsection
