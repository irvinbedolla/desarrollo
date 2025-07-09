@extends('layouts.app')

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
                            <h3 class="text-center">Historial</h3>
                            @can('ver-seer')
                                <div class="table-responsive">
                                    <table id="HistorialSolicitudes" class="table table-striped mt-1">
                                        <thead style="background-color: #4A001F;">
                                            <th style="display: none;">ID</th>
                                            <th style="color: #fff;">Fecha de audiencia</th>
                                            <th style="color: #fff;">Número único de identificación</th>
                                            <th style="color: #fff;">Solicitante</th>
                                            <th style="color: #fff;">Estatus</th>
                                            <th style="color: #fff;">Detalles</th>
                                            <th style="color: #fff;">Documentos</th>
                                        </thead>
                                        <tbody>
                                            @foreach($audiencias as $audiencia)
                                                <tr>
                                                    <td style="display: none;">{{$audiencia->id_solicitud}}</td>
                                                    <td>{{$audiencia->fecha}}</td> 
                                                    <td>{{$audiencia->NUE}}</td>
                                                    <td>{{$audiencia->nombre}}</td>
                                                    <td>{{$audiencia->estatus}}</td>
                                                    <td>{{$audiencia->observaciones}}
                                                    <td>
                                                        @if($audiencia->estatus == "Archivada")
                                                            <a class="btn btn-success" href="{{ route('PDFfalltaInteres', $audiencia->id_solicitud) }}"  target="_blank">Acta de Archivo</a><br>
                                                        @elseif($audiencia->estatus == "Incompetencia")
                                                            <a class="btn btn-success" href="{{ route('PDFincompetencia', $audiencia->id_solicitud) }}"  target="_blank">Incompetencia</a><br>
                                                        @elseif($audiencia->estatus == "Comparecencia")
                                                            <a class="btn btn-success" href="{{ route('PDFincomparecencia', $audiencia->id_solicitud) }}"  target="_blank">Acta de incomparecencia</a><br>
                                                        @elseif($audiencia->estatus == "Reagendada")
                                                        <div class="dropdown  mt-2">
                                                            <button class="btn btn-warning dropdown-toggle load-pdfs" type="button" id="dropdownCitatoriosBtn-{{ $audiencia->id_solicitud }}" data-id="{{ $audiencia->id_solicitud }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Documentos
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownCitatoriosBtn-{{ $audiencia->id_solicitud }}">
                                                                <li><a class="dropdown-item" href="{{ route('PDFnotificacion_solicitante', $audiencia->id_solicitud) }}" target="_blank">Notificación al solicitante</a></li>
                                                                <li class="dropdown-divider"></li>
                                                                <li class="dropdown-item text-muted">Citatorios</li>
                                                                <div id="citatorios-list-{{ $audiencia->id_solicitud }}"></div>
                                                            </ul>
                                                        </div> 
                                                            <a class="btn btn-info" target="_blank" href="{{ route('PDFnotificacion_solicitante', $audiencia->id_solicitud) }}">Notificación al solicitante</a><br><br>
                                                            <button type="button" class="btn btn-warning open-modal" data-bs-toggle="modal" data-bs-target="#documentos" data-id="{{ $audiencia->id_solicitud }}">Citatorios</button>
                                                        @elseif($audiencia->estatus == "No conciliacion")
                                                            <a class="btn btn-success" target="_blank" href="{{ route('PDFno_conciliacion', $audiencia->id_solicitud) }}">Constancia de no conciliación</a><br>
                                                        @elseif($audiencia->estatus == "Conciliacion")
                                                            <a class="btn btn-success" href="{{ route('PDFconveniosolicitud', $audiencia->id_solicitud) }}" target="_blank">Convenio</a>
                                                        @endif 
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>      
                                </div>

                            @endcan
                            <!-- Centramos la paginación a la derecha-->
                            <div class="pagination justify-content-end"></div>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="menu_carga" style ="display: none;">
            <div>.</div>
            <div class="loader"></div>
        </div>
        
        @section('scripts')
            <script src="../../public/js/estadistica/estadistica.js"></script>
        @endsection
    </section>

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
