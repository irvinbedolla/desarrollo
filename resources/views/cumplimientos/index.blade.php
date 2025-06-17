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
                            <div class="row">
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div align="center">
                                        <a href="{{ route('cumplimiento_actual') }}" class="btn btn-primary">Cumplimiento hoy</a>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div align="center">
                                        <a href="{{ route('cumplimiento_buscar') }}" class="btn btn-primary">Buscar Cumplimientos</a>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div align="center">
                                        <button type="submit" class="btn btn-primary">Agenda</button>
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

@section('scripts')
    <script src="../public/assets/js/poderes/general.js"></script>
@endsection
