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
                            @can('ver_solicitante')
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped mt-2">
                                        <thead style="background-color: #4A001F;">
                                            <th style="color: #fff;">Folio</th>
                                            <th style="color: #fff;">Fecha</th>
                                            <th style="color: #fff;">Empresa/Patrón(a)</th>
                                            <th style="color: #fff;">Trabajador(a)</th>
                                            <th style="color: #fff;">Teléfono</th>
                                            <th style="color: #fff;">Correo</th>
                                            <th style="color: #fff;">Estatus</th>
                                            <th style="color: #fff;">Informe general</th>
                                            <th style="color: #fff;">Documentos</th>
                                        </thead>
                                        <tbody>
                                            @foreach($solicitudes as $solicitud)
                                                <tr>
                                                    <td>{{$solicitud->id}}</td>
                                                    <td>{{$solicitud->fecha}}</td> 
                                                    <td>{{$solicitud->empresa}}</td>
                                                    <td>{{$solicitud->trabajador}}</td>
                                                    <td>{{$solicitud->telefono}}</td>
                                                    <td>{{$solicitud->email}}</td>
                                                    <td>{{$solicitud->estatus}}</td>
                                                    <td><a class="btn btn-primary" href="{{ route('consultar_ratificacion', $solicitud->id) }}" onclick=consultar_estadistica();>Consultar</a></td>
                                                    <td>
                                                        @if($solicitud->estatus === "Confirmado")
                                                            <a class="btn btn-success" href="{{ route('PDFratifi', $solicitud->id) }}" onclick=consultar_estadistica(); tarjet="_black">Acuse</a>
                                                        @endif
                                                        @if($solicitud->estatus === "Conluida")
                                                            <a class="btn btn-success" href="{{ route('PDFconvenioratificacion', $solicitud->id) }}" onclick=consultar_estadistica(); tarjet="_black">Convenio</a>
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

@section('scripts')
    <script src="./public/assets/js/poderes/general.js"></script>
@endsection
