@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Poderes</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            @can('crear-abogado')
                                <a class="btn btn-warning" href="{{ route('poder-crear') }}" target="_blank">Nuevo</a>
                            @endcan

                            <form action="{{ url()->current() }}" method="GET" style="width: 400px; margin: 0;">
                                <div class="input-group">
                                    <input type="text" name="buscar" class="form-control" placeholder="Buscar por Folio o Nombre..." value="{{ request('buscar') }}">
                                    <button class="btn btn-primary" type="submit" style="background-color: #4A001F; border-color: #4A001F;">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                    @if(request('buscar'))
                                        <a href="{{ url()->current() }}" class="btn btn-secondary">Limpiar</a>
                                    @endif
                                </div>
                            </form>
                        </div>
                        
                        @can('ver-abogado')
                            <div class="table-responsive">
                                <table id="example" class="table table-striped mt-2" style="width:100%">
                                    <thead style="background-color: #4A001F;">
                                        <tr>
                                            <th style="color: #fff;">Folio</th>
                                            <th style="color: #fff;">Nombre / Razón Social</th>
                                            <th style="color: #fff;">RFC</th>
                                            <th style="color: #fff;">Representante Legal</th>
                                            <th style="color: #fff;">Estatus</th>
                                            <th style="color: #fff;">Expediente Digital</th>
                                            <th style="color: #fff;">Acciones</th>
                                            <th style="color: #fff;">Eliminar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($poderesIniciales as $poder)
                                            @php
                                                $esSuperUsuario = (isset($userRole[0]) && $userRole[0] === "Super Usuario");
                                            @endphp
                                            <tr>
                                                <td>{{ $poder->idAbogado }}</td>
                                                <td>{{ $poder->nombre_patronal_combinado }}</td>
                                                <td>{{ $poder->rfc_patronal ?? 'N/A' }}</td>
                                                <td>{{ $poder->nombre_representante_combinado }}</td>
                                                <td>{!! $poder->estatus_badge !!}</td>
                                                <td>{!! $poder->documentos_modal_btn !!}</td>
                                                <td>
                                                    <div class="d-flex gap-1 align-items-center">
                                                        <div class="d-flex flex-column gap-1">
                                                            <a class="btn btn-sm btn-warning" href="{{ route('poderes.edit', $poder->idAbogado) }}" onclick="editar_poder();"><i class="bi bi-pencil"></i> Editar</a>
                                                            @if($esSuperUsuario)
                                                                <a class="btn btn-sm btn-secondary" href="{{ route('poderes.history', $poder->idAbogado) }}"><i class="bi bi-clock-history"></i> Historial</a>
                                                            @endif
                                                        </div>
                                                        @if (auth()->user()->can('editar-abogado'))
                                                            <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal1" data-id="{{ $poder->idAbogado }}" data-tipo="{{ $poder->tipo }}"><i class="bi bi-person-plus"></i> Agregar</a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($esSuperUsuario)
                                                        @can('borrar-abogado')
                                                            <form method="POST" action="{{ route('poderes.destroy', $poder->idAbogado) }}" class="form-eliminar-poder">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button class="btn btn-sm btn-danger" type="submit">Borrar</button>
                                                            </form>
                                                        @endcan
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modalExpedienteDigital" tabindex="-1" aria-labelledby="modalExpedienteLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content" style="box-shadow: 0 5px 15px rgba(0,0,0,.5);">
            <div class="modal-header" style="background-color: #4A001F; color: white;">
                <h5 class="modal-title" id="modalExpedienteLabel">Documentos del Representante</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3"><strong>Abogado:</strong> <span id="expediente_nombre_abogado" class="text-muted"></span></p>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-card-heading text-primary"></i> Identificación Oficial (INE)</span>
                        <div id="wrapper_ine"></div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-journal-bookmark text-primary"></i> Cédula Profesional</span>
                        <div id="wrapper_cedula"></div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-file-earmark-text text-primary"></i> Documento de Representación</span>
                        <div id="wrapper_representacion"></div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-envelope-paper text-primary"></i> Carta Poder</span>
                        <div id="wrapper_cartapoder"></div>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center" id="li_registro">
                        <span><i class="bi bi-file-check text-success"></i> Constancia de Registro Oficial</span>
                        <div id="wrapper_registro"></div>
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection