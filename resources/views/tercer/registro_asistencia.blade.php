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
                                <h4>Registrar asistencia de: {{ $persona->nombre }} {{ $persona->primer_apellido }} {{ $persona->segundo_apellido }}</h4>
                                <p>Correo: {{ $persona->correo ?? 'N/A' }}</p> 
                                <p>Tel: {{ $persona->telefono ?? 'N/A' }}</p>
                                <form method="POST" action="{{ route('registro_asistencia_te.guardar', $persona->id) }}">
                                    @csrf
                                    <input type="hidden" name="id_asistente" value="{{ $persona->id }}">
                                    <div class="form-group">
                                        <label>Conferencias / Asistencias</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="conferencia1" id="conferencia1" {{ optional($asistencia)->conferencia1 ? 'checked disabled' : '' }}>
                                            <label class="form-check-label {{ optional($asistencia)->conferencia1 ? 'text-success fw-semibold' : '' }}" for="conferencia1">Conferencia 1
                                                @if(optional($asistencia)->conferencia1)
                                                    <i class="bi bi-check-circle-fill text-success ms-1"></i>
                                                @endif
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="conferencia2" id="conferencia2" {{ optional($asistencia)->conferencia2 ? 'checked disabled' : '' }}>
                                            <label class="form-check-label {{ optional($asistencia)->conferencia2 ? 'text-success fw-semibold' : '' }}" for="conferencia2">Conferencia 2
                                                @if(optional($asistencia)->conferencia2)
                                                    <i class="bi bi-check-circle-fill text-success ms-1"></i>
                                                @endif
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="conferencia3" id="conferencia3" {{ optional($asistencia)->conferencia3 ? 'checked disabled' : '' }}>
                                            <label class="form-check-label {{ optional($asistencia)->conferencia3 ? 'text-success fw-semibold' : '' }}" for="conferencia3">Conferencia 3
                                                @if(optional($asistencia)->conferencia3)
                                                    <i class="bi bi-check-circle-fill text-success ms-1"></i>
                                                @endif
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="conferencia4" id="conferencia4" {{ optional($asistencia)->conferencia4 ? 'checked disabled' : '' }}>
                                            <label class="form-check-label {{ optional($asistencia)->conferencia4 ? 'text-success fw-semibold' : '' }}" for="conferencia4">Conferencia 4
                                                @if(optional($asistencia)->conferencia4)
                                                    <i class="bi bi-check-circle-fill text-success ms-1"></i>
                                                @endif
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="conferencia5" id="conferencia5" {{ optional($asistencia)->conferencia5 ? 'checked disabled' : '' }}>
                                            <label class="form-check-label {{ optional($asistencia)->conferencia5 ? 'text-success fw-semibold' : '' }}" for="conferencia5">Conferencia 5
                                                @if(optional($asistencia)->conferencia5)
                                                    <i class="bi bi-check-circle-fill text-success ms-1"></i>
                                                @endif
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="conferencia6" id="conferencia6" {{ optional($asistencia)->conferencia6 ? 'checked disabled' : '' }}>
                                            <label class="form-check-label {{ optional($asistencia)->conferencia6 ? 'text-success fw-semibold' : '' }}" for="conferencia6">Conferencia 6
                                                @if(optional($asistencia)->conferencia6)
                                                    <i class="bi bi-check-circle-fill text-success ms-1"></i>
                                                @endif
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="conferencia7" id="conferencia7" {{ optional($asistencia)->conferencia7 ? 'checked disabled' : '' }}>
                                            <label class="form-check-label {{ optional($asistencia)->conferencia7 ? 'text-success fw-semibold' : '' }}" for="conferencia7">Conferencia 7
                                                @if(optional($asistencia)->conferencia7)
                                                    <i class="bi bi-check-circle-fill text-success ms-1"></i>
                                                @endif
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="conferencia8" id="conferencia8" {{ optional($asistencia)->conferencia8 ? 'checked disabled' : '' }}>
                                            <label class="form-check-label {{ optional($asistencia)->conferencia8 ? 'text-success fw-semibold' : '' }}" for="conferencia8">Conferencia 8
                                                @if(optional($asistencia)->conferencia8)
                                                    <i class="bi bi-check-circle-fill text-success ms-1"></i>
                                                @endif
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="conferencia9" id="conferencia9" {{ optional($asistencia)->conferencia9 ? 'checked disabled' : '' }}>
                                            <label class="form-check-label {{ optional($asistencia)->conferencia9 ? 'text-success fw-semibold' : '' }}" for="conferencia9">Conferencia 9
                                                @if(optional($asistencia)->conferencia9)
                                                    <i class="bi bi-check-circle-fill text-success ms-1"></i>
                                                @endif
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="conferencia10" id="conferencia10" {{ optional($asistencia)->conferencia10 ? 'checked disabled' : '' }}>
                                            <label class="form-check-label {{ optional($asistencia)->conferencia10 ? 'text-success fw-semibold' : '' }}" for="conferencia10">Conferencia 10
                                                @if(optional($asistencia)->conferencia10)
                                                    <i class="bi bi-check-circle-fill text-success ms-1"></i>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Guardar asistencia</button>
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