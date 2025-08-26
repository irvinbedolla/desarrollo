@extends('layouts.app')


@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Documentos</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                 <table class="table table-striped mt-2">
                                    <thead style="background-color: #4A001F;">
                                        <th style="color: #fff;">Nombre del Documento</th>
                                        <th style="color: #fff;">Documento</th>
                                        <th style="color: #fff;">Acciones</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>CURP del Trabajador</td>
                                            <td>{{$documento_general->trabajador_curp}}</td>
                                            <td><a target='_blank' href="../storage/app/documentos_ratificacion/{{$documento_general->documentoCurp}}">PDF</a><br></td>
                                        </tr>
                                        <tr>
                                            <td>Identificación del Trabajador</td>
                                            <td>{{$documento_general->tipo_identificacion}}</td>
                                            <td><a target='_blank' href="../storage/app/documentos_ratificacion/{{$documento_general->documentoidentificacion}}">PDF</a></td>
                                        </tr>
                                        <tr>
                                            <td>Identificación de Solicitante</td>
                                            <td>{{$documento_general->ine}}</td>
                                            <td><a target='_blank' href="../storage/app/documentos_ratificacion/{{$documento_general->ine}}">PDF</a></td>
                                        </tr>
                                        <tr>
                                            <td>Identificación de Solicitante</td>
                                            <td>{{$documento_general->representacion}}</td>
                                            <td><a target='_blank' href="../storage/app/documentos_ratificacion/{{$documento_general->representacion}}">PDF</a></td>
                                        </tr>

                                        @if(count($documento_abogado) != 0)
                                            @foreach($documento_abogado as $documento)
                                                <tr>
                                                    <td colspan="3" style="text-align: center; background-color:#7c7c7b">REPRESENTANTE LEGAL</td>
                                                </tr>
                                                <tr>
                                                    <td>Identificación de Citado:{{$documento->empresa}}</td>
                                                    <td>{{$documento->ine}}</td>
                                                    <td><a target='_blank' href="../storage/app/documentosSolicitud/{{$documento->ine}}">PDF</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Poder de Citado:{{$documento->empresa}}</td>
                                                    <td>{{$documento->representacion}}</td>
                                                    <td><a target='_blank' href="../storage/app/documentosSolicitud/{{$documento->representacion}}">PDF</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Anexo de Citado:{{$documento->empresa}}</td>
                                                    <td>{{$documento->anexo}}</td>
                                                    <td><a target='_blank' href="../storage/app/documentosSolicitud/{{$documento->anexo}}">PDF</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Anexo de Citado:{{$documento->empresa}}</td>
                                                    <td>{{$documento->cedula}}</td>
                                                    <td><a target='_blank' href="../storage/app/documentosSolicitud/{{$documento->cedula}}">PDF</a></td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<div id="nuevo_turno" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>


@section('scripts')
    <script src="../public/assets/js/turnos/turnos.js"></script>
@endsection