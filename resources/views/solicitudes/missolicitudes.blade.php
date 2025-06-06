@extends('layouts.app')
@php
    $fechaActual = date('Y-m-d');
@endphp
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Solicitudes</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('ver_solicitante')
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped mt-2">
                                        <thead style="background-color: #4A001F;">
                                            <th style="color: #fff;">Folio</th>
                                            <th style="color: #fff;">Fecha</th>
                                            <th style="color: #fff;">Trabajador(a)</th>
                                            <th style="color: #fff;">Estatus</th>
                                            <th style="color: #fff;">Resumen</th>
                                            <th style="color: #fff;">Documentos</th>
                                        </thead>
                                        <tbody>
                                            @foreach($solicitudes as $solicitud)
                                                <tr>
                                                    <td>{{$solicitud->id}}</td>
                                                    <td>{{$solicitud->fecha}}</td> 
                                                    <td>{{$solicitud->nombre}}</td>
                                                    <td>{{$solicitud->estatus}}</td>
                                                    <td><a class="btn btn-primary" href="{{ route('consultar_solicitud', $solicitud->id) }}" onclick=consultar_estadistica();>Consultar</a></td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning open-modal" data-id="{{ $solicitud->id }}">Citatorios</button><br><br>
                                                        <a class="btn btn-success" href="{{ route('PDFnotificacion_solicitante', $solicitud->id) }}" onclick=consultar_estadistica(); tarjet="_black">Notificación al solicitante</a><br><br>
                                                        <a class="btn btn-success" href="{{ route('PDFacuse_solicitud', $solicitud->id) }}" onclick=consultar_estadistica(); tarjet="_black">Acuse de solicitud</a>
                                                        @if($solicitud->estatus === "Concluida")
                                                            <a class="btn btn-success" href="{{ route('PDFconveniosolicitud', $solicitud->id) }}" onclick=consultar_estadistica(); tarjet="_black">Convenio</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endcan
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

<div id="nuevo_poder" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>
<!-- Modal Documentos -->
<div class="modal fade" id="documentos" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">DOCUMENTOS</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <table class="table table-striped" style="width: 100%; text-align: center;">
                <thead style="background-color: #D2D3D5;">
                  <tr>
                    <th>Citatorios</th>
                    <th>Acción</th>
                  </tr>
                </thead>
                <tbody id="pdf-list">
    
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>
@section('scripts')
    <script src="../public/assets/js/poderes/general.js"></script>
    <script>
        const pdfsUrlBase = "{{ url('solicitud/pdfs') }}";
    </script>
    <script>
        $(document).ready(function() {
            $('.open-modal').click(function() {
                const id = $(this).data('id');
                $('#pdf-list').empty();
    
                // Mostrar modal
                var myModal = new bootstrap.Modal(document.getElementById('documentos'));
                myModal.show();
    
                $.ajax({
                    url: `${pdfsUrlBase}/${id}`,
                    method: 'GET',
                    success: function(response) {
                        if (response.length > 0) {
                            response.forEach(pdf => {
                                const row = `
                                <tr>
                                    <td style="text-align: left;">${pdf.nombre}</td>
                                    <td>
                                        <a href="${pdf.url}" target="_blank" class="btn btn-primary btn-sm">Ver PDF</a>
                                    </td>
                                </tr>`;
                                $('#pdf-list').append(row);
                            });
                        } else {
                            $('#pdf-list').append('<tr><td colspan="2">No hay documentos disponibles.</td></tr>');
                        }
                    },
                    error: function() {
                        $('#pdf-list').append('<tr><td colspan="2">Error al cargar documentos.</td></tr>');
                    }
                });
            });
        });
    </script>
@endsection

