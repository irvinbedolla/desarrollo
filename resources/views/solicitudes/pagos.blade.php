@extends('layouts.app_editar')
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
                            <a class="btn btn-warning" href="{{ route('atender_ratificacion') }}"  onclick=nuevo_poder();> Regresar</a>
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped mt-2">
                                        <thead style="background-color: #4A001F;">
                                            <th style="color: #fff;">Folio</th>
                                            <th style="color: #fff;">Fecha</th>
                                            <th style="color: #fff;">Hora</th>
                                            <th style="color: #fff;">Monto</th>
                                            <th style="color: #fff;">Estatus</th>
                                            <th style="color: #fff;">Pagar</th>
                                            <th style="color: #fff;">Documento</th>
                                        </thead>
                                        <tbody>
                                            @foreach($pagos as $pago)
                                                <tr>
                                                    <td>{{$pago->id}}</td>
                                                    <td>{{$pago->fecha}}</td> 
                                                    <td>{{$pago->hora}}</td>
                                                    <td>${{number_format($pago->monto, 2)}}</td>
                                                    <td>{{$pago->estatus}}</td>
                                                    <td>
                                                        @if($pago->estatus == "Pendiente")
                                                            <a class="btn btn-info" href="{{ route('ratificacion_pagoA', $pago->id) }}" onclick=consultar_estadistica();>Pagar</a>
                                                            <a class="btn btn-danger" href="{{ route('ratificacion_pagoR', $pago->id) }}" onclick=consultar_estadistica();>Rechazar</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($pago->estatus == "Pagado")
                                                            <a class="btn btn-info" href="{{ route('PDFcumplimiento', $pago->id) }}" onclick=consultar_estadistica();>PDF</a>
                                                        @elseif($pago->estatus == "No pagado")
                                                            <a class="btn btn-info" href="{{ route('VerPDFIncumplimiento', $pago->id) }}" onclick=consultar_estadistica();>PDF</a>
                                                        @endif

                                                        VerPDFIncumplimiento
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


<div id="nuevo_poder" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>

@section('scripts')
    <script src="../public/assets/js/poderes/general.js"></script>
@endsection
