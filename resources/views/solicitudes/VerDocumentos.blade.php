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
                                            <td>CURP de Solicitante</td>
                                            <td>{{$documento_solicitante->documentoCurp}}</td>
                                            <td><a target='_blank' href="../storage/app/documentosSolicitud/{{$documento_solicitante->documentoCurp}}">PDF</a><br></td>
                                        </tr>
                                        <tr>
                                            <td>Identificación de Solicitante</td>
                                            <td>{{$documento_solicitante->documentoIdentificacion}}</td>
                                            <td><a target='_blank' href="../storage/app/documentosSolicitud/{{$documento_solicitante->documentoIdentificacion}}">PDF</a></td>
                                        </tr>
                                        @if(count($documento_abogado) != 0)
                                            <tr>
                                                <td>Identificación de Citado</td>
                                                <td>{{$documento_abogado->ine}}</td>
                                                <td><a target='_blank' href="../storage/app/documentosSolicitud/{{$documento_abogado->ine}}">PDF</a></td>
                                            </tr>
                                            <tr>
                                                <td>Identificación de Citado</td>
                                                <td>{{$documento_abogado->representacion}}</td>
                                                <td><a target='_blank' href="../storage/app/documentosSolicitud/{{$documento_abogado->representacion}}">PDF</a></td>
                                            </tr>
                                            <tr>
                                                <td>Identificación de Citado</td>
                                                <td>{{$documento_abogado->anexo}}</td>
                                                <td><a target='_blank' href="../storage/app/documentosSolicitud/{{$documento_abogado->anexo}}">PDF</a></td>
                                            </tr>
                                            <tr>
                                                <td>Identificación de Citado</td>
                                                <td>{{$documento_abogado->cedula}}</td>
                                                <td><a target='_blank' href="../storage/app/documentosSolicitud/{{$documento_abogado->cedula}}">PDF</a></td>
                                            </tr>
                                        @endif
                                        @if(count($documento_fisica) != 0)
                                            <tr>
                                                <td>Identificación de Citado(Persona Fisica)</td>
                                                <td>{{$documento_fisica->documentoIdentificacion}}</td>
                                                <td><a target='_blank' href="../storage/app/documentosSolicitud/{{$documento_fisica->documentoIdentificacion}}">PDF</a></td>
                                            </tr>
                                        @endif
                                        @if(count($documento_subidos) != 0)
                                            @foreach($documento_subidos as $solicitud)
                                                <tr>
                                                    <td colspan="2">{{$solicitud->nombre_documento}}</td> 
                                                    <td><a target='_blank' href="../storage/app/documentosSolicitud/{{$solicitud->nombre_documento}}">PDF</a></td>
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