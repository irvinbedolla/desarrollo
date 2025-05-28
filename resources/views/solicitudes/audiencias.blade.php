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
                                                    <td><button type="button" class="btn btn-danger open-modal" data-bs-toggle="modal" data-bs-target="#editarSolicitante" data-id="{{ $solicitud->id }}">Editar</button></td>
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
                                                    <button type="button" class="btn btn-danger open-modal" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $solicitud->id }}">
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

<!-- Modal Edición solicitante-->
<div class="modal fade" id="editarSolicitante" tabindex="-1" aria-labelledby="editarSolicitanteLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form method="POST" action="{{ route('editar_solicitud') }}" enctype="multipart/form-data" class="needs-validation novalidate">
            @csrf
            <!--<input type="hidden" name="id" id="modal-id" value="">-->
            <input type="hidden" name="id" value="{{ $solicitante->id }}">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarSolicitanteLabel">Editar solicitante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                     <!--Se realiza la validación de campos para ver si dejó alguno vacío-->
                    @if ($errors->any())
                        <div class="alert alert-dark alert-dismissible fade show" role="alert">
                            <strong>¡Revise los campos!</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    <!--<span class="badge badge-danger">{{ $error }}</span>-->
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <input type="hidden" name="id" value="{{$id}}">
                    <div class="col-xs-12 col-sm-12 col-md-8">
                        <div class="form-group">
                            <label for="name"><b>Nombre(s) y Apellidos del Solicitante (*) </b></label>
                            <input type="text" name="nombre" value="{{ old('nombre', $solicitante->nombre) }}" class="form-control" oninput="this.value = this.value.toUpperCase()" required><br>
                            <div class="invalid-feedback">
                                El campo nombre es obligatorio.
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="name"><b>CURP del Solicitante (*)</b></label>
                            <input type="text" name="curp" id="curp_input" value="{{ old('curp', $solicitante->curp) }}" oninput="validarInput(this)"class="form-control" required>
                            <pre id="resultado"></pre>
                            <div class="invalid-feedback">
                                El campo curp es obligatorio.
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="name"><b>RFC del Solicitante (*)</b></label>
                            <input type="text" name="rfc" class="form-control" value="{{ old('rfc', $solicitante->rfc) }}" minlength="13" maxlength="13" oninput="this.value = this.value.toUpperCase()" required><br>
                            <div class="invalid-feedback">
                                El campo RFC es obligatorio.
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="name"><b>Número de Seguro Social</b></label>
                            <input type="text" name="seguro" value="{{ old('seguro', $solicitante->seguro) }}" minlength="11" maxlength="12" class="form-control"><br> 
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="name"><b>Puesto (*)</b></label>
                            <input type="text" name="puesto" value="{{ old('puesto', $solicitante->puesto) }}" class="form-control" oninput="this.value = this.value.toUpperCase()" required><br>
                            <div class="invalid-feedback">
                                El campo puesto es obligatorio.
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="name"><b>Frecuencia de Pago (*)</b></label>
                            <select name="periodo_pago" value="{{ old('puesto', $solicitante->periodo_pago) }}" class="form-control" required>
                                <option value="">SELECCIONE</option>
                                <option value="Diario">DIARIO</option>
                                <option value="Semana">SEMANAL</option>
                                <option value="Quincenal">QUINCENAL</option>
                                <option value="Mensual">MENSUAL</option>
                            </select><br>
                            <div class="invalid-feedback">
                                El campo frecuencia de pagos es obligatorio.
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="name"><b>Salario (*)</b></label>
                            <input type="text" name="pago" value="{{ old('pago', $solicitante->pago) }}" class="form-control" required><br> 
                            <div class="invalid-feedback">
                                El campo salario es obligatorio.
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="name"><b>Cantidad total de horas trabajadas por semana (*)</b></label>
                            <input type="number" name="horas" value="{{ old('horas', $solicitante->horas) }}" class="form-control" required><br> 
                            <div class="invalid-feedback">
                                El campo cantidad de horas trabajadas es obligatorio.
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="btncheck1"><b>¿Laboras actualmente?</b></label><br>
                            <input name="labora" type="checkbox" class="btn-check" id="check_fecha" autocomplete="off"/><br><br>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="name"><b>Fecha de Ingreso (*)</b></label>
                            <input type="date" name="fecha_ingreso" value="{{ old('fecha_ingreso', $solicitante->fecha_ingreso) }}" class="form-control" required><br> 
                            <div class="invalid-feedback">
                                El campo fecha de ingreso es obligatoria.
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="name"><b>Jornada (*)</b></label>
                            <select name="jornada" value="{{ old('fecha_salida', $solicitante->jornada) }}" class="form-control" required>
                                <option value="">SELECCIONE</option>
                                <option value="Diurna">DIURNA</option>
                                <option value="Nocturna">NOCTURNA</option>
                                <option value="Mixta">MIXTA</option>
                            </select><br>
                            <div class="invalid-feedback">
                                El campo jornada laboral es obligatoria.
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-4" id="fecha_fin">
                        <div class="form-group">
                            <label for="name"><b>Fecha de Salida</b></label>
                            <input type="date" name="fecha_salida" value="{{ old('fecha_salida', $solicitante->fecha_salida) }}" class="form-control"><br> 
                            <div class="invalid-feedback">
                                El campo fecha de salida es obligatoria.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Fin Modal Solicitante -->

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

    <script>
        var editarModal = document.getElementById('editarSolicitante');
        editarModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var pago = button.getAttribute('data-pago');
            var id = button.getAttribute('data-id');

            editarModal.querySelector('#modal-pago').value = pago || '';
            editarModal.querySelector('#modal-id').value = id || '';
            editarModal.querySelector('#modal-nombre').value = nombre || '';
            editarModal.querySelector('#modal-curp').value = curp || '';
            editarModal.querySelector('#modal-fecha_ingreso').value = fecha_ingreso || '';
            editarModal.querySelector('#modal-fecha_salida').value = fecha_salida || '';
            editarModal.querySelector('#modal-jornada').value = jornada || '';
            editarModal.querySelector('#modal-labora').value = labora || '';
            editarModal.querySelector('#modal-horas').value = horas || '';
            editarModal.querySelector('#modal-periodo_pago').value = periodo_pago || '';
            editarModal.querySelector('#modal-puesto').value = puesto || '';
            editarModal.querySelector('#modal-seguro').value = seguro || '';
            editarModal.querySelector('#modal-rfc').value = rfc || '';
        });

        
    </script>
    <script src="../public/assets/js/poderes/general.js"></script>
@endsection