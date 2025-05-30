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
                                                        <button type="button" class="btn btn-danger open-modal" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $audiencia->id }}">
                                                            Archivar
                                                        </button><br>
                                                        <button type="button" class="btn btn-danger open-modal" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $audiencia->id }}">
                                                            Incompetencia
                                                        </button><br>
                                                        <button type="button" class="btn btn-danger open-modal" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $audiencia->id }}">
                                                            Incomparecencia
                                                        </button><br>
                                                        <a class="btn btn-primary">Reagendar</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($audiencia->estatus == "Archivada")
                                                        <a class="btn btn-success" href="{{ route('PDFinteres', $audiencia->id) }}"  target="_blank">Acta de Archivo</a><br>
                                                    @elseif($audiencia->estatus == "Incompetencia")
                                                        <a class="btn btn-success" href="{{ route('PDFincompetencia', $audiencia->id) }}"  target="_blank">Incompetencia</a><br>
                                                    @elseif($audiencia->estatus == "Incomparecencia")
                                                        <a class="btn btn-success" href="{{ route('PDFincomparecencia', $audiencia->id) }}"  target="_blank">Acta de Incomparecencia</a><br>
                                                    @elseif($audiencia->estatus == "Reagendada")
                                                        <a class="btn btn-info" href="{{ route('PDFratificacion', $audiencia->id) }}">Notificación al solicitante</a><br>
                                                        <a class="btn btn-success" href="{{ route('PDFcitatorio', $audiencia->id) }}"  target="_blank">Citatorios</a><br>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class='needs-validation novalidate'  method='POST' action="{{route('archivar_audiencia')}}">
        @csrf
        <input type="hidden" id="modal-id" name="id" value="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Observaciones</h5>
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

