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
                                <div class="table-responsive">
                                    <table id="example">
                                        <thead style="background-color: #4A001F;">
                                            <th style="color: #fff;">Folio</th>
                                            <th style="color: #fff;">Fecha</th>
                                            <th style="color: #fff;">Solicitante</th>
                                            <th style="color: #fff;">Estatus</th>
                                            <th style="color: #fff;">Resumen</th>
                                            <th style="color: #fff;">Documentos</th>
                                        </thead>
                                        <tbody>
                                            @foreach($solicitudes as $solicitud)
                                                <tr>
                                                    <td>{{$solicitud->id}}</td>
                                                    <td>{{ \Carbon\Carbon::parse($solicitud->fecha)->translatedFormat('d/m/y') }}</td> 
                                                    <td>{{$solicitud->nombre}}</td>
                                                    <td>{{$solicitud->estatus}}</td>
                                                    <td><a class="btn btn-primary" href="{{ route('consulta_solicitante', $solicitud->id) }}" onclick=consultar_estadistica();>Consultar</a></td>
                                                    <td>
                                                        @if(($solicitud->estatus !== "Pendiente") && ($solicitud->estatus !== "Prevencion"))
                                                            <div class="dropdown  mt-2">
                                                                <button class="btn btn-warning dropdown-toggle load-pdfs" type="button" id="dropdownCitatoriosBtn-{{ $solicitud->id }}" data-id="{{ $solicitud->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    Documentos
                                                                </button>
                                                                <ul class="dropdown-menu" aria-labelledby="dropdownCitatoriosBtn-{{ $solicitud->id }}">
                                                                    <li><a class="btn btn-info" style="width: 100%" href="{{ route('VerDocumentosAudiencia', $solicitud->id) }}" >Citatorios</a></li>
                                                                    @if(($solicitud->estatus !== "Pendiente") && ($solicitud->estatus !== "Prevencion"))
                                                                        <li><a class="btn btn-info" style="width: 100%"  href="{{ route('PDFnotificacion_solicitante', $solicitud->id) }}" target="_blank">Notificación al solicitante</a></li>
                                                                        <li><a class="btn btn-info" style="width: 100%"  href="{{ route('PDFacuseConfirmada', $solicitud->id) }}"  target="_blank">Acuse de solicitud confirmada</a></li>
                                                                        <li><a class="btn btn-info" href="{{ route('PDFacuse_solicitud', $solicitud->id) }}"  target="_blank">Acuse de solicitud</a></li>
                                                                    @endif
                                                                </ul>
                                                            </div>                                           
                                                        @endif
                                                        @if(($solicitud->estatus === "Pendiente"))
                                                            <a class="btn btn-info" href="{{ route('PDFacuse_solicitud', $solicitud->id) }}"  target="_blank">Acuse de solicitud</a>
                                                        @endif
                                                        @if($solicitud->estatus === "Concluida")
                                                            <a class="btn btn-info" style="width: 100%" href="{{ route('VerDocumentosAudiencia', $solicitud->id) }}"    target="_blank">Documentos Digitales</a>
                                                            <a class="btn btn-success" style="width: 100%"  href="{{ route('PDFconveniosolicitud', $solicitud->id) }}"  target="_blank">Convenio</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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

@section('scripts')
<script src="../public/assets/js/poderes/general.js"></script>
<script>
    const pdfsUrlBase = "{{ url('solicitud/pdfs') }}";
</script>
<script>
    $(document).ready(function () {
        $('.load-pdfs').click(function () {
            const id = $(this).data('id');
            const $listContainer = $(`#citatorios-list-${id}`);
            $listContainer.html('<li class="dropdown-item text-muted">Cargando citatorios...</li>');

            $.ajax({
                url: `${pdfsUrlBase}/${id}`,
                method: 'GET',
                success: function (response) {
                    $listContainer.empty();

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

                            $listContainer.append(`
                                <li><a class="dropdown-item" href="${url}" target="_blank">${pdfName}</a></li>
                            `);
                        });
                    } else {
                        $listContainer.append('<li class="dropdown-item text-muted">No hay citatorios disponibles.</li>');
                    }
                },
                error: function () {
                    $listContainer.html('<li class="dropdown-item text-danger">Error al cargar citatorios.</li>');
                }
            });
        });
    });
</script>
@endsection


