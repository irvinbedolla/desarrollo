@extends('layouts.app')


@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Tercer Encuentro</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success" role="alert">
                                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                                </div>
                            @endif
                            @if(isset($persona))
                                <h4>Editar datos de: {{ $persona->nombre }} {{ $persona->primer_apellido }} {{ $persona->segundo_apellido }}</h4>
                                <p>Correo: {{ $persona->correo ?? 'N/A' }}</p> 
                                <p>Tel: {{ $persona->telefono ?? 'N/A' }}</p>
                                <p>Folio: {{}}</p>
                                <form method="POST" action="{{ route('registro_asistencia_te.guardar', $persona->id) }}">
                                    @csrf
                                    <input type="hidden" name="id_asistente" value="{{ $persona->id }}">
                                    <div class="form-group">
                                        
                                    </div>
                                    <div class="row">
                                        <button class="btn btn-primary col-xs-12 col-sm-4 col-md-1 mr-2 mt-2" type="submit">Guardar</button>
                                        <a type="button" class="btn btn-info col-xs-12 col-sm-4 col-md-1 mt-2" href="{{ route('index_tercer_encuentro') }}">Regresar</a>
                                    </div>
                                </form>
                            @else
                                <p>Persona no encontrada.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection