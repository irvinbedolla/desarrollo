@extends('layouts.app')
@php
    $fechaActual = date('Y-m-d');
@endphp
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Cumplimientos</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                                @if(session()->has('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>¡Registro correcto!</strong>
                                        {{ session()->get('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div align="center">
                                        <a href="{{ route('cumplimiento_actual') }}" class="btn btn-primary">Cumplimiento hoy</a>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div align="center">
                                        <button type="button" class="btn btn-primary open-modal" data-bs-toggle="modal" data-bs-target="#ModalArchivar">
                                            Buscar Cumplimientos
                                        </button>
                                     </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div align="center">
                                        <a href="{{ route('crear_cumplimiento') }}" class="btn btn-primary">Agregar Nuevo</a>
                                    </div>
                                </div> 
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

<div class="modal fade bd-example-modal-lg" id="ModalArchivar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class='needs-validation novalidate'  method='POST' action="{{route('cumplimientos_busqueda')}}">
        @csrf
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filtros de busqueda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label>Fecha inicio</label>
                            <input type="date" name="inicio" class="form-control">
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label>Fecha final</label>
                            <input type="date" name="final" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </form>
</div>

@section('scripts')
    <script src="../public/assets/js/poderes/general.js"></script>
@endsection
