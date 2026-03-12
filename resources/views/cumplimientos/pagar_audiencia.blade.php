@extends('layouts.app_editar')
@php
    $fechaActual = date('Y-m-d');
@endphp
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Cumplimiento en Audiencias</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!--<a class="btn btn-warning" href="{{ route('todas_audiencias') }}"  onclick=nuevo_poder();> Regresar</a>-->
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped mt-2">
                                        <thead style="background-color: #4A001F;">
                                            <th style="color: #fff;">Fecha</th> 
                                            <th style="color: #fff;">Hora</th>
                                            <th style="color: #fff;">Monto</th>
                                            <th style="color: #fff;">Estatus</th>
                                            <th style="color: #fff;">Pagar</th>
                                            <th style="color: #fff;">Documentos</th>
                                        </thead>
                                        <tbody>
                                            @foreach($cumplimientos as $pago)
                                                <tr>
                                                    <td>{{date_format($pago->fecha,"d-m-Y")}}</td> 
                                                    <td>{{date_format($pago->hora,"h:m:s")}}</td>
                                                    <td>${{number_format($pago->monto, 2)}}</td>
                                                    <td>{{$pago->estatus}}</td>
                                                    <td>
                                                        @if($pago->estatus == "Pendiente")
                                                            <button type="button" class="btn btn-info open-modal" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $pago->id }}">
                                                                Pagar
                                                            </button>
                                                            <a class="btn btn-danger" href="{{ route('cumplimiento_rechazar', $pago->id) }}" onclick=consultar_estadistica();>Rechazar</a>
                                                            <a class="btn btn-danger" href="{{ route('cumplimiento_incomparecencia', $pago->id) }}" onclick=consultar_estadistica();>No comparece trabajador</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @php
                                                            $totalRegistros = $cumplimientos->count();
                                                        @endphp

                                                        @if($pago->estatus == "Pagado")
                                                            @if($totalRegistros == 1)
                                                                <a class="btn btn-success" href="{{ route('PDFcumplimientoTotal', $pago->id_solicitud) }}" target="_blank">
                                                                    PDF
                                                                </a>
                                                            @else
                                                                <a class="btn btn-success" href="{{ route('PDFcumplimientoParcial', $pago->id) }}" target="_blank">
                                                                    PDF
                                                                </a>
                                                            @endif
                                                        {{--@if($pago->estatus == "Pagado")
                                                            <a class="btn btn-success" href="{{ route('PDFcumplimientoParcial', $pago->id) }}" target="_blank">PDF</a>--}}
                                                        @elseif($pago->estatus == "No pagado")
                                                            <a class="btn btn-info" href="{{ route('PDFincumplimientoAudiencia', $pago->id) }}" target="_blank">PDF</a>
                                                        @elseif($pago->estatus == "Incomparecencia trabajador")
                                                            <a class="btn btn-info" href="{{ route('PDFIncomparecenciaCumplimiento', $pago->id) }}" target="_blank">PDF</a>
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
    <form class='needs-validation novalidate'  method='POST' action="{{route('pagoA_audiencia')}}">
        @csrf
        <input type="hidden" id="modal-id" name="id" value="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Descripción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea name="observaciones" style="width:100%"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
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
    <script src="../../public/assets/js/poderes/general.js"></script>
@endsection
