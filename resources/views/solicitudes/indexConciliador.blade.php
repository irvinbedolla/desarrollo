@extends('layouts.app')
@php
    $fechaActual = date('Y-m-d');
@endphp
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Audiencias</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped mt-1">
                                        <thead style="background-color: #4A001F;">
                                            <th style="color: #fff;">Núm. expediente</th>
                                            <th style="color: #fff;">Fecha</th>
                                            <th style="color: #fff;">Hora</th>
                                            <th style="color: #fff;">Solicitante</th>
                                            <th style="color: #fff;">Estatus</th>
                                            <th style="color: #fff;">Acciones</th>
                                            <th style="color: #fff;">Documentos</th>
                                        </thead>
                                        <tbody>
                                            @foreach($audiencias as $audiencia)
                                            <tr>
                                                <td>{{$audiencia->NUE}}</td>
                                                <td>{{$audiencia->fecha}}</td> 
                                                <td>{{$audiencia->hora}}</td>
                                                <td>{{$audiencia->nombre}}</td>
                                                <td>{{$audiencia->estatus}}</td>
                                                <td>
                                                    @if($audiencia->estatus == "Confirmado")
                                                        <a class="btn btn-info" href="{{ route('inicioAudiencia', $audiencia->id, 'Confirmado') }}">Iniciar</a><br>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($audiencia->estatus == "Archivada")
                                                        <a class="btn btn-success" href="{{ route('PDFfalltaInteres', $audiencia->id) }}"  target="_blank">Acta de Archivo</a><br>
                                                    @elseif($audiencia->estatus == "Incompetencia")
                                                        <a class="btn btn-success" href="{{ route('PDFincompetencia', $audiencia->id) }}"  target="_blank">Incompetencia</a><br>
                                                    @elseif($audiencia->estatus == "Comparecencia")
                                                        <a class="btn btn-success" href="{{ route('PDFincomparecencia', $audiencia->id) }}"  target="_blank">Acta de incomparecencia</a><br>
                                                    @elseif($audiencia->estatus == "Reagendada")
                                                        <a class="btn btn-info" target="_blank" href="{{ route('PDFnotificacion_solicitante', $audiencia->id) }}">Notificación al solicitante</a><br><br>
                                                        <button type="button" class="btn btn-warning open-modal" data-bs-toggle="modal" data-bs-target="#documentos" data-id="{{ $audiencia->id }}">Citatorios</button>
                                                    @elseif($audiencia->estatus == "No conciliacion")
                                                        <a class="btn btn-success" target="_blank" href="{{ route('PDFno_conciliacion', $audiencia->id) }}">Constancia de no conciliación</a><br>
                                                    @endif 
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            <!-- Centramos la paginación a la derecha-->
                            <div class="pagination justify-content-end"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

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
                <tbody id="pdf-list"></tbody>
            </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
</div>

<div id="nuevo_poder" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
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

                var myModal = new bootstrap.Modal(document.getElementById('documentos'));
                myModal.show();

                $.ajax({
                    url: `${pdfsUrlBase}/${id}`,
                    method: 'GET',
                    success: function(response) {
                        if (response.length > 0) {
                            response.forEach(pdf => {
                                const pdfData = pdf.base64;
                                const pdfName = pdf.nombre;

                                const byteCharacters = atob(pdfData);
                                const byteNumbers = new Array(byteCharacters.length);
                                for (let i = 0; i < byteCharacters.length; i++) {
                                    byteNumbers[i] = byteCharacters.charCodeAt(i);
                                }
                                const byteArray = new Uint8Array(byteNumbers);
                                const blob = new Blob([byteArray], { type: 'application/pdf' });
                                const url = URL.createObjectURL(blob);

                                const row = `
                                <tr>
                                    <td style="text-align: left;">${pdfName}</td>
                                    <td>
                                        <a href="${url}" target="_blank" class="btn btn-primary btn-sm">Ver PDF</a>
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

            // Limpiar backdrop y modal-open cuando modal se oculta
            $('#documentos').on('hidden.bs.modal', function () {
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
            });
        });
    </script>
@endsection


