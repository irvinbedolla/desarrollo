@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Sedes</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Éxito:</strong> {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error:</strong> {{ $errors->first() }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                                <div class="tab">
                                    <a class="btn btn-info" onclick="mostrar_sedes()">Bloqueos de Sedes</a>
                                    <a class="btn btn-info" onclick="mostrar_conciliador()">Bloqueos de Conciliadores</a>
                                    <a class="btn btn-info" href="{{ route('configuracion') }}">Regresar</a>
                                </div>
                                <!-- TABLA DE BLOQUEOS DE SEDES -->
                                <div id="sedes" style="display:none">
                                    <div class="card mt-4">
                                         <div class="card-header text-white" style="background-color: #496163;">
                                            <h5>Bloqueos de Sedes</h5>
                                        </div>
                                        <div class="card-body table-responsive">
                                            <table class="table table-striped">
                                                <thead style="background-color: #4A001F;">
                                                    <tr>
                                                        <th style="color: #fff;">Sede</th>
                                                        <th style="color: #fff;">Fecha inicio</th>
                                                        <th style="color: #fff;">Fecha final</th>
                                                        <th style="color: #fff;">Hora inicio</th>
                                                        <th style="color: #fff;">Hora final</th>
                                                        <th style="color: #fff;">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($bloqueos->whereNull('user_id') as $bloqueo)
                                                        <tr>
                                                            <td>{{ $bloqueo->centro }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($bloqueo->fecha_inicio)->format('d-m-Y') }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($bloqueo->fecha_final)->format('d-m-Y') }}</td>
                                                            <td>{{ $bloqueo->horario_inicio }}</td>
                                                            <td>{{ $bloqueo->horario_final }}</td>
                                                            <td>
                                                                <form action="{{ route('eliminarBloqueo', $bloqueo->id) }}" method="POST" 
                                                                    onsubmit="return confirm('¿Seguro que deseas eliminar este bloqueo?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center">No hay bloqueos de sedes registrados.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- TABLA DE BLOQUEOS DE CONCILIADORES -->
                                <div id="solicitante" style="display:none">
                                    <div class="card mt-4">
                                        <div class="card-header text-white" style="background-color: #496163;">
                                            <h5>Bloqueos de Conciliadores</h5>
                                        </div>
                                        <div class="card-body table-responsive">
                                            <table class="table table-striped">
                                                <thead style="background-color: #4A001F;">
                                                    <tr>
                                                        <th style="color: #fff;">Conciliador</th>
                                                        <th style="color: #fff;">Sede</th>
                                                        <th style="color: #fff;">Fecha inicio</th>
                                                        <th style="color: #fff;">Fecha final</th>
                                                        <th style="color: #fff;">Hora inicio</th>
                                                        <th style="color: #fff;">Hora final</th>
                                                        <th style="color: #fff;">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($bloqueos->whereNotNull('user_id') as $bloqueo)
                                                        <tr>
                                                            <td>{{ $conciliadores->firstWhere('id', $bloqueo->user_id)->name ?? 'N/A' }}</td>
                                                            <td>{{ $sedes->firstWhere('id', $bloqueo->centro)->delegacion ?? $bloqueo->centro }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($bloqueo->fecha_inicio)->format('d-m-Y') }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($bloqueo->fecha_final)->format('d-m-Y') }}</td>
                                                            <td>{{ $bloqueo->horario_inicio }}</td>
                                                            <td>{{ $bloqueo->horario_final }}</td>
                                                            <td>
                                                                <form action="{{ route('eliminarBloqueo', $bloqueo->id) }}" method="POST" 
                                                                    onsubmit="return confirm('¿Seguro que deseas eliminar este bloqueo?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center">No hay bloqueos de conciliadores registrados.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="example" class="table table-striped mt-1">
                                        <thead style="background-color: #4A001F;">
                                            <tr>
                                                <th style="color: #fff;">Delegación</th>
                                                <th style="color: #fff; text-align: center;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sedes as $sede)
                                                <tr>
                                                    <td>{{ $sede instanceof \App\Models\Sedes ? ($sede->delegacion ?? $sede->nombre ?? $sede->name ?? '') : $sede }}</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-success text-white" data-toggle="modal" data-target="#modalBloqueo"
                                                                data-sede="{{ $sede instanceof \App\Models\Sedes ? ($sede->delegacion ?? $sede->nombre ?? $sede->name ?? '') : $sede }}">
                                                            Agregar
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                            <!-- Centramos la paginación a la derecha-->
                            <div class="pagination justify-content-end">
                            </div>                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<!-- Modal para bloqueo de sede / conciliador -->
<div class="modal fade" id="modalBloqueo" tabindex="-1" role="dialog" aria-labelledby="modalBloqueoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header" style="background:#4A001F;">
                <h5 class="modal-title text-white">Bloqueo de sede o conciliador</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- Bloquear toda la sede --}}
                <div class="mb-4 p-3 border rounded">
                    <h5 class="mb-2"><b>Bloquear toda la sede</b></h5>
                    <p>Este bloqueo aplica para TODAS las audiencias de esta sede.</p>

                    <form action="{{ route('bloqueoSede') }}" method="POST">
                        @csrf
                        <input type="hidden" name="sede_id" id="modal_sede_id" value="">

                        <div class="form-group">
                            <label><b>Fecha de inicio:</b></label>
                            <input type="date" name="fecha_inicio" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label><b>Fecha final:</b></label>
                            <input type="date" name="fecha_final" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-danger mt-2">Bloquear sede completa</button>
                    </form>
                </div>

                <hr>

                {{-- Bloquear conciliador --}}
                <div class="p-3 border rounded">
                    <h5 class="mb-2"><b>Bloquear conciliador</b></h5>
                    <p>Seleccione el conciliador y el horario que NO estará disponible.</p>

                    <form action="{{ route('bloqueoConciliador') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label><b>Conciliador:</b></label>
                            <select name="conciliador_id" class="form-control" required>
                                <option value="">Seleccione</option>
                                @foreach($conciliadores as $con)
                                    <option value="{{ $con->id }}">{{ $con->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label><b>Fecha de inicio:</b></label>
                            <input type="date" name="fecha_inicio" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label><b>Fecha final:</b></label>
                            <input type="date" name="fecha_final" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label><b>Hora inicio:</b></label>
                            <input type="time" name="hora_inicio" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label><b>Hora fin:</b></label>
                            <input type="time" name="hora_final" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-warning mt-2">Bloquear conciliador</button>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>

<div id="menu_carga" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>


@section('scripts')
    <script src="../public/assets/js/estadistica/estadistica.js"></script>
    
    <script>
        // Asignar la sede seleccionada al input del modal
        $('#modalBloqueo').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var sede = button.data('sede');
            var modal = $(this);
            modal.find('#modal_sede_id').val(sede);
        });
        function mostrar_sedes() {
            alert("Consulta Correcta");
            document.getElementById("sedes").style.display = "block";
            document.getElementById("solicitante").style.display = "none";
        }
        function mostrar_conciliador(){
            alert("Consulta Correcta");
            document.getElementById("sedes").style.display = "none";
            document.getElementById("solicitante").style.display = "block";
        }
    </script>

@endsection