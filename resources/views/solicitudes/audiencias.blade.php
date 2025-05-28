@extends('layouts.app_editar')
@php
    $fechaActual = date('Y-m-d');
@endphp
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Audiencia iniciada</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped mt-1">
                                        <thead style="background-color: #4A001F;">
                                            <tr>
                                                <button type="button" class="btn btn-danger open-modal" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    Reagendar
                                                </button>
                                            </tr>
                                            <tr> 
                                                <th>Tipo parte</th>
                                                <th>Nombre de la parte</th>
                                                <th>Conciliador</th>
                                                <th>Sala</th>
                                                <th>Acciones</th>
                                            </tr>
                                            <tr>
                                                <tr>
                                                    <td style="color: #000000;"><b>Solicitante</b></td>
                                                    <td>{{ $solicitante->nombre }}</td>
                                                    <td>{{ $conciliador->name }}</td>
                                                    <td style="color: #000000;"><b>Sala</b></td>
                                                    <td><button type="button" class="btn btn-primary">Editar</button></td>
                                                </tr>
                                                @foreach($citados as $citado)
                                                <tr>
                                                    <td style="color: #000000;"><b>Citado</b></td>
                                                    <td>{{$citado->nombre}} {{$citado->primer_apellido}} {{$citado->segundo_apellido}}</td>
                                                    <td>{{ $conciliador->name }}</td>
                                                    <td style="color: #000000;"><b>Sala</b></td>
                                                    <td><button type="button" class="btn btn-primary">Editar</button></td>
                                                </tr>
                                                @endforeach  
                                            </tr> 
                                            <tr>
                                                <td style="color: #000000;"><b>Documentos</b></td>
                                                <td>
                                                    <button type="button" class="btn btn-danger open-modal" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                        Incompetencia
                                                    </button>
                                                </td> 
                                                @foreach($solicitudes as $solicitud)   
                                                <td>
                                                    @if($solicitud->estatus == "Conciliacion")   
                                                        <a class="btn btn-info" href="{{ route('inicioAudiencia', $solicitud->id) }}">Acta de audiencia</a>
                                                        <a class="btn btn-info" href="{{ route('inicioAudiencia', $solicitud->id) }}">Convenio de terminación</a>
                                                    @elseif($solicitud->estatus == "No conciliacion")
                                                        <a class="btn btn-info" href="{{ route('inicioAudiencia', $solicitud->id) }}">Acta de no conciliación</a>
                                                    @elseif($solicitud->estatus == "Reagendada")
                                                        <a class="btn btn-info" href="{{ route('inicioAudiencia', $solicitud->id) }}">Notificación al solicitante</a>
                                                        <a class="btn btn-info" href="{{ route('inicioAudiencia', $solicitud->id) }}">Citatorios</a>
                                                    @endif
                                                </td>
                                                @endforeach
                                            </tr>
                                        </thead>
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