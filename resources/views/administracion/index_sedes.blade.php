@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Gestión de Agenda y Sedes</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Éxito:</strong> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error:</strong> {{ $errors->first() }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="tab mb-4">
                                <button class="btn btn-info" onclick="mostrar_sedes()"><i class="bi bi-building"></i> Bloqueos de Sedes</button>
                                <button class="btn btn-info" onclick="mostrar_conciliador()"><i class="bi bi-person-badge"></i> Bloqueos de Conciliadores</button>
                                <a class="btn btn-secondary" href="{{ route('configuracion') }}"><i class="bi bi-arrow-left"></i> Regresar</a>
                            </div>

                            <div id="sedes" style="display:none">
                                <div class="card shadow-sm mt-2">
                                    <div class="card-header text-white" style="background-color: #496163;">
                                        <h5>Historial de Bloqueos por Sedes</h5>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table class="table table-striped datatable-local">
                                            <thead style="background-color: #4A001F; color: #fff;">
                                                <tr>
                                                    <th>Sede</th>
                                                    <th>Módulo Afectado</th>
                                                    <th>Régimen</th>
                                                    <th>Fecha inicio</th>
                                                    <th>Fecha final</th>
                                                    <th>Horario</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($bloqueos->whereNull('user_id') as $bloqueo)
                                                    <tr>
                                                        <td><b>{{ $bloqueo->centro }}</b></td>
                                                        <td><span class="badge bg-secondary">{{ $bloqueo->tipo }}</span></td>
                                                        <td>
                                                            <span class="badge {{ $bloqueo->descripcion === 'Inhabil' ? 'bg-danger' : 'bg-warning text-dark' }}">
                                                                {{ $bloqueo->descripcion }}
                                                            </span>
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($bloqueo->fecha_inicio)->format('d-m-Y') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($bloqueo->fecha_final)->format('d-m-Y') }}</td>
                                                        <td>
                                                            {{ $bloqueo->horario_inicio === '08:00:00' && $bloqueo->horario_final === '15:00:00' ? 'Jornada Completa' : substr($bloqueo->horario_inicio, 0, 5) . ' a ' . substr($bloqueo->horario_final, 0, 5) }}
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('eliminarBloqueo', $bloqueo->id) }}" method="POST" class="form-eliminar">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="text-center text-muted">No hay bloqueos de sedes registrados.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div id="solicitante" style="display:none">
                                <div class="card shadow-sm mt-2">
                                    <div class="card-header text-white" style="background-color: #496163;">
                                        <h5>Historial de Bloqueos por Conciliadores</h5>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table class="table table-striped datatable-local">
                                            <thead style="background-color: #4A001F; color: #fff;">
                                                <tr>
                                                    <th>Conciliador</th>
                                                    <th>Sede</th>
                                                    <th>Módulo</th>
                                                    <th>Régimen</th>
                                                    <th>Fecha inicio</th>
                                                    <th>Fecha final</th>
                                                    <th>Horario</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($bloqueos->whereNotNull('user_id') as $bloqueo)
                                                    <tr>
                                                        <td><b>{{ $conciliadores->firstWhere('id', $bloqueo->user_id)->name ?? 'N/A' }}</b></td>
                                                        <td>{{ $sedes->firstWhere('id', $bloqueo->centro)->delegacion ?? $bloqueo->centro }}</td>
                                                        <td><span class="badge bg-secondary">{{ $bloqueo->tipo }}</span></td>
                                                        <td>
                                                            <span class="badge {{ $bloqueo->descripcion === 'Inhabil' ? 'bg-danger' : 'bg-warning text-dark' }}">
                                                                {{ $bloqueo->descripcion }}
                                                            </span>
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($bloqueo->fecha_inicio)->format('d-m-Y') }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($bloqueo->fecha_final)->format('d-m-Y') }}</td>
                                                        <td>
                                                            {{ $bloqueo->horario_inicio === '08:00:00' && $bloqueo->horario_final === '15:00:00' ? 'Jornada Completa' : substr($bloqueo->horario_inicio, 0, 5) . ' a ' . substr($bloqueo->horario_final, 0, 5) }}
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('eliminarBloqueo', $bloqueo->id) }}" method="POST" class="form-eliminar">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center text-muted">No hay bloqueos de conciliadores registrados.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mt-3">
                                <table id="example" class="table table-striped mt-1">
                                    <thead style="background-color: #4A001F; color: #fff;">
                                        <tr>
                                            <th>Delegación</th>
                                            <th class="text-center">Configurar Bloqueos</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sedes as $sede)
                                            @php 
                                                $nombreSede = $sede instanceof \App\Models\Sedes ? ($sede->delegacion ?? $sede->nombre ?? $sede->name ?? '') : $sede;
                                            @endphp
                                            <tr>
                                                <td><i class="bi bi-geo-alt-fill text-danger"></i> <b>{{ $nombreSede }}</b></td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-success text-white btn-abrir-bloqueo" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#modalBloqueoUnificado"
                                                            data-sede="{{ $nombreSede }}">
                                                        <i class="bi bi-calendar-plus"></i> Configurar Bloqueo
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modalBloqueoUnificado" tabindex="-1" aria-labelledby="modalBloqueoUnificadoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('bloqueoSede') }}" method="POST" id="formBloqueoMaster">
                    @csrf
                    <input type="hidden" name="sede_id" id="modal_sede_id" value="">

                    <div class="modal-header" style="background:#4A001F; color: white;">
                        <h5 class="modal-title"><i class="bi bi-shield-lock"></i> Configurar Restricción de Agenda: <span id="txtSedeTitulo"></span></h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label d-block fw-bold">1. ¿A quién aplica este bloqueo?</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="cobertura" id="cobSede" value="todos" checked>
                                    <label class="form-check-label" for="cobSede">A toda la Sede / Oficina Completa</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="cobertura" id="cobConciliador" value="individual">
                                    <label class="form-check-label" for="cobConciliador">A un Conciliador específico</label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3" id="div_selector_conciliador" style="display: none;">
                            <div class="col-md-12">
                                <label for="conciliador_id" class="fw-semibold text-danger">Seleccione al Conciliador Afectado:</label>
                                <select name="conciliador_id" id="conciliador_id" class="form-control">
                                    <option value="">-- Seleccione un Conciliador --</option>
                                    @foreach($conciliadores as $con)
                                        <option value="{{ $con->id }}">{{ $con->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <hr class="opacity-25">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="fw-semibold">Fecha de inicio:</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-semibold">Fecha final:</label>
                                <input type="date" name="fecha_final" id="fecha_final" class="form-control" min="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="fw-semibold">Módulo del Centro a Bloquear:</label>
                                <select name="tipo" class="form-control" required>
                                    <option value="Todos">Todos (Bloqueo Total)</option>
                                    <option value="Audiencias">Audiencias</option>
                                    <option value="Ratificaciones">Ratificaciones</option>
                                    <option value="Cumplimientos">Cumplimientos</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-semibold">Régimen Legal del Día:</label>
                                <select name="descripcion" class="form-control" required>
                                    <option value="Inhabil">Inhábil (Oficial / Suspensión de términos)</option>
                                    <option value="No inhabil" selected>No Inhábil (Suspensión interna / Permisos)</option>
                                </select>
                            </div>
                        </div>

                        <hr class="opacity-25">

                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="bloquear_todo_el_dia" name="bloquear_todo_el_dia" value="1" checked style="cursor:pointer;">
                                    <label class="form-check-label fw-bold text-primary" for="bloquear_todo_el_dia" style="cursor:pointer;">
                                        <i class="bi bi-clock-history"></i> Bloquear todo el día (Jornada Completa)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2" id="wrapper_horas_especificas" style="display: none;">
                            <div class="col-md-6">
                                <label class="fw-semibold text-muted">Hora inicio:</label>
                                <input type="time" name="hora_inicio" id="hora_inicio" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="fw-semibold text-muted">Hora fin:</label>
                                <input type="time" name="hora_final" id="hora_final" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger"><i class="bi bi-lock-fill"></i> Aplicar Restricción</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="menu_carga" style="display: none;">
        <div>.</div>
        <div class="loader"></div>
    </div>
@endsection

@section('scripts')
    <script src="../public/assets/js/estadistica/estadistica.js"></script>
    <script>
        $(document).ready(function() {
            // Mover el modal a la raíz para solucionar capas grises opacas
            if ($('#modalBloqueoUnificado').length) {
                $('#modalBloqueoUnificado').appendTo("body");
            }

            // Inicialización de las tablas del historial locales
            $('.datatable-local').each(function() {
                $(this).DataTable({
                    info: false,
                    ordering: false,
                    paging: true,
                    pageLength: 5,
                    searching: false,
                    language: { "paginate": { "next": "Sig.", "previous": "Ant." } }
                });
            });

            // Cachamos los datos del botón que abre el modal unificado
            $(document).on('click', '.btn-abrir-bloqueo', function() {
                let sede = $(this).data('sede');
                $('#modal_sede_id').val(sede);
                $('#txtSedeTitulo').text(sede);
            });

            // CONTROL DE COBERTURA: Mostrar/Ocultar select de conciliadores
            $('input[name="cobertura"]').on('change', function() {
                if ($(this).val() === 'individual') {
                    $('#div_selector_conciliador').slideDown(200);
                    $('#conciliador_id').attr('required', 'required');
                    // Cambiar dinámicamente la ruta del formulario si usas rutas diferentes en tu web.php
                    $('#formBloqueoMaster').attr('action', "{{ route('bloqueoConciliador') }}");
                } else {
                    $('#div_selector_conciliador').slideUp(200);
                    $('#conciliador_id').removeAttr('required').val('');
                    $('#formBloqueoMaster').attr('action', "{{ route('bloqueoSede') }}");
                }
            });

            // CONTROL DE HORARIOS: Ocultar y desmarcar obligatorios si bloquea todo el día
            $('#bloquear_todo_el_dia').on('change', function() {
                if (this.checked) {
                    $('#wrapper_horas_especificas').slideUp(200);
                    $('#hora_inicio').removeAttr('required').val('');
                    $('#hora_final').removeAttr('required').val('');
                } else {
                    $('#wrapper_horas_especificas').slideDown(200);
                    $('#hora_inicio').attr('required', 'required');
                    $('#hora_final').attr('required', 'required');
                }
            });

            // Consistencia simple: la fecha final no puede ser menor a la inicial
            $('#fecha_inicio').on('change', function() {
                $('#fecha_final').attr('min', $(this).val());
            });

            // Confirmación estética antes de eliminar historial
            $(document).on('submit', '.form-eliminar', function() {
                return confirm('¿Seguro que deseas eliminar este bloqueo de la agenda operativa?');
            });
        });

        function mostrar_sedes() {
            document.getElementById("sedes").style.display = "block";
            document.getElementById("solicitante").style.display = "none";
        }
        
        function mostrar_conciliador(){
            document.getElementById("sedes").style.display = "none";
            document.getElementById("solicitante").style.display = "block";
        }
    </script>
@endsection