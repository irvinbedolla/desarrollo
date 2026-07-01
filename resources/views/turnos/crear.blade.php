@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Turnos</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Generar turno</h3>

                                    @if(session()->has('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>¡Registro correcto!</strong>
                                            {{ session()->get('success') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    <!--Se realiza la validación de campos para ver si dejó alguno vacío-->
                                    @if (session()->has('error'))
                                        <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                            <strong>¡Revise los campos!</strong>
                                            {{ session()->get('error') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif


                            <!--Se realiza el envío de datos con formulario de Laravel Collective-->
                            <form class='needs-validation novalidate' id='form_roles' method='POST' action="{{route('turnos_guardar_nuevo')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Nombre del Solicitante</label>
                                            <input type="text" name="nombre" class="form-control" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();" required> 
                                            <div class="invalid-feedback">
                                                El nombre es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="name">Tipo de Trámite</label>
                                            <select name="tipo" class="form-control" onchange="blockCalendar();" required>
                                                <option value="">Seleccione</option>
                                                <option value="Solicitud">Solicitudes y Asesorías</option>
                                                <option value="Ratificación">Ratificación</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                El tipo de solicitud es obligatoria.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="name">Edad</label>
                                            <input type="number" name="edad" class="form-control" required> 
                                            <div class="invalid-feedback">
                                                El campo edad es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="name">Área de adscripción</label>
                                            <input type="text" name="area" maxlength="50" class="form-control" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();" required> 
                                            <div class="invalid-feedback">
                                                El campo área es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="name">Puesto</label>
                                            <input type="text" name="puesto" maxlength="50" class="form-control" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();" required> 
                                            <div class="invalid-feedback">
                                                El campo puesto es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="name">Número de Teléfono</label>
                                            <input type="number" name="telefono" maxlength="10" class="form-control" required> 
                                            <div class="invalid-feedback">
                                                El campo puesto es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="name">Correo</label>
                                            <input type="text" name="correo" maxlength="30" class="form-control" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();" required> 
                                            <div class="invalid-feedback">
                                                El campo correo es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="name">Nombre de la Empresa</label>
                                            <input type="text" name="empresa" maxlength="50" class="form-control" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();" required> 
                                            <div class="invalid-feedback">
                                                El campo empresa es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="name">Sexo</label>
                                            <select name="sexo" class="form-control" required>
                                                <option value="">Seleccione</option>
                                                <option value="H">Hombre</option>
                                                <option value="M">Mujer</option>
                                                <option value="NB">No Binarios</option>
                                                <option value="Otros">Otros</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                El campo sexo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">

                                            <label for="name">Posible caso de excepción 
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                                    ?
                                                </button>
                                            </label>

                                            <select name="excepcion" class="form-control" onchange="cambiaExcepcion(this); blockCalendar();" required>
                                                <option value="">Seleccione</option>
                                                <option value="Si">Si</option>
                                                <option value="No">No</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tipo_caso"  class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="name">Tipo de caso de excepción</label>
                                            <select name="tipo_caso" class="form-control">
                                                <option value="">Seleccione</option>
                                                <option value="Discriminación">Maternidad</option>
                                                <option value="Acoso u hostigamiento sexual">Riesgos de trabajo</option>
                                                <option value="Discriminación">Accidentes de Trabajo</option>
                                                <option value="Discriminación">Invalidez</option>
                                                <option value="Discriminación">Seguros de Vida</option>
                                                <option value="Discriminación">Otras</option>
                                                <option value="Discriminación">Libertad y Asociación Sindical</option>
                                                <option value="Discriminación">Trata Laboral y Trabajo Forzoso</option>
                                                <option value="Discriminación">Trabajo Infantil</option>
                                                <option value="Discriminación">Disputa de titularidad de Contrato Coletivo y Contrato Ley</option>
                                                <option value="Discriminación">Impugnación de estatutos de Sindicato y su Modificación</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                                                        
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="name">Grupos vulnerables</label>
                                            <select name="vulnerables" class="form-control" required>
                                                <option value="">Seleccione</option>
                                                <option value="Menores de edad">Menores de edad</option>
                                                <option value="Adultos mayores">Adultos mayores</option>
                                                <option value="Personas con discapacidad">Personas con discapacidad</option>
                                                <option value="Población indígena">Población indígena</option>
                                                <option value="Personas Migrantes">Personas Migrantes</option>
                                                <option value="LGBTTTIQ">LGBTTTIQ+</option>
                                                <option value="No aplica">No aplica</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="name">Requiere Asesoria/Orientación Juridica</label>
                                            <select name="orientacion" class="form-control" required>
                                                <option value="">Seleccione</option>
                                                <option value="Si">Si</option>
                                                <option value="No">No</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                El campo sexo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    
                                     <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="name">Delegación/Oficina</label>
                                            <select name="delegacion" class="form-control" onchange="blockCalendar();" required>
                                                <option value="">Seleccione</option>
                                                <option value="Morelia">Morelia</option>
                                                <option value="Zitácuaro">Zitácuaro</option>
                                                <option value="Uruapan">Uruapan</option>
                                                <option value="Lázaro Cárdenas">Lázaro Cárdenas</option>
                                                <option value="Zamora">Zamora</option>
                                                <option value="Sahuayo">Sahuayo</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="name">Observaciones</label>
                                            <textarea name="conflicto" class="form-control"></textarea>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                        <input type="hidden" name="fecha_turno" id="fecha_turno" value="">
                                        <input type="hidden" name="hora_turno" id="hora_turno" value="">
                                        <button type="button" id="botonCalendar" class="btn btn-lg btn-custom-morado" data-bs-toggle="modal" data-bs-target="#calendarModal" disabled>
                                            Seleccionar Fecha y Horario
                                        </button>
                                        <div id="resumenTurno" class="alert alert-info mt-2" style="display:none;"></div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Posibles Casos</h5>
                        </div>
                        <div class="modal-body">
                            La Ley Federal del Trabajo en el articulo 685-Ter establece que no estas obligado a agotar la etapa conciliatoria en estos supuestos<br>
                            -Discriminación<br>
                            -Acoso u hostigamiento sexual<br>
                            -Designación de beneficiarios<br>
                            -Prestaciones de Seguridad Social
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="calendarModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Seleccionar Fecha y Horario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="calendarTurno"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" id="confirmarTurno" disabled>Confirmar</button>
                        </div>
                    </div>
                </div>
            </div>

            <style>
        .fc-event {
            padding: 3px 6px !important;
            border-radius: 4px !important;
            font-size: 12px !important;
            cursor: pointer;
        }

        #calendarTurno {
            width: 100%;
            min-height: 500px;
        }

        .fc-event-disponible {
            color: #ffff !important;
            background-color: #00CE1C !important;
            border-color: #00CE1C !important;
            cursor: pointer;
        }

        .fc-event-expirado {
            color: #ffff !important;
            background-color: #F59727 !important;
            border-color: #F59727 !important;
            cursor: not-allowed;
        }

        .fc-event-inhabil {
            color: #ffff !important;
            background-color: #3B78DB !important;
            border-color: #3B78DB !important;
            cursor: not-allowed;
        }

        .fc-event-ocupado {
            color: #ffff !important;
            background-color: #DA0909 !important;
            border-color: #DA0909 !important;
            cursor: not-allowed;
        }

        .fc-event-turnos {
            color: #ffff !important;
            background-color: #00CE1C !important;
            border-color: #00CE1C !important;
            cursor: pointer;
        }

        .fc-event-selected {
            border: 2px solid #FFD700 !important;
            box-shadow: 0 0 8px #FFD700;
        }
            </style>

        </section>
    @endsection

    @section('scripts')
    <script>
        document.getElementById("tipo_caso").style.display="none";

        function cambiaExcepcion(elemento){
            var valor = elemento.value;
            var tipoCasoDiv = document.getElementById("tipo_caso");
            var tipoCasoSelect = tipoCasoDiv.querySelector('select[name="tipo_caso"]');
            if(valor == "Si"){
                tipoCasoDiv.style.display="block";
                tipoCasoSelect.setAttribute("required", "required");
            }
            else{
                tipoCasoDiv.style.display="none";
                tipoCasoSelect.removeAttribute("required");
                tipoCasoSelect.value = "";
            }
        }

        // El botón solo se habilita cuando ya se eligió delegación y tipo de trámite,
        // pues ambos datos determinan los horarios que ofrecerá el calendario.
        function blockCalendar(){
            const delegacion = document.querySelector('select[name="delegacion"]').value;
            const tipo = document.querySelector('select[name="tipo"]').value;
            const boton = document.getElementById("botonCalendar");

            if(delegacion !== "" && tipo !== ""){
                boton.removeAttribute("disabled");
            } else {
                boton.disabled = true;
            }

            limpiarTurnoSeleccionado();
        }

        function limpiarTurnoSeleccionado(){
            turnoSeleccionado = null;
            document.getElementById("fecha_turno").value = "";
            document.getElementById("hora_turno").value = "";
            document.getElementById("resumenTurno").style.display = "none";
            document.getElementById("confirmarTurno").setAttribute("disabled", "disabled");
        }

        function pad(numero){
            return String(numero).padStart(2, "0");
        }

        function formatoFechaLocal(fecha){
            return fecha.getFullYear() + "-" + pad(fecha.getMonth() + 1) + "-" + pad(fecha.getDate());
        }

        function formatoHoraLocal(fecha){
            return pad(fecha.getHours()) + ":" + pad(fecha.getMinutes()) + ":" + pad(fecha.getSeconds());
        }

        let calendarTurno = null;
        let turnoSeleccionado = null;

        document.getElementById("calendarModal").addEventListener("shown.bs.modal", function () {
            if (calendarTurno) {
                calendarTurno.destroy();
            }

            turnoSeleccionado = null;
            document.getElementById("confirmarTurno").setAttribute("disabled", "disabled");

            const delegacion = document.querySelector('select[name="delegacion"]').value;
            const tipo = document.querySelector('select[name="tipo"]').value;
            const excepcion = document.querySelector('select[name="excepcion"]').value;
            const calendarEl = document.getElementById("calendarTurno");

            calendarTurno = new FullCalendar.Calendar(calendarEl, {
                initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridWeek',
                locale: 'es',
                firstDay: 1,
                headerToolbar: { left: 'prev,next today', center: 'title', right: '' },
                validRange: {
                    start: new Date().toISOString().split('T')[0],
                },
                events: function (fetchInfo, successCallback, failureCallback) {
                    const params = new URLSearchParams({
                        sede: delegacion,
                        tipo: tipo,
                        excepcion: excepcion,
                        start: fetchInfo.startStr,
                        end: fetchInfo.endStr,
                    });

                    fetch("{{ url('/api/obtenerTurnosDisponibles') }}?" + params.toString())
                        .then(function (res) { return res.json(); })
                        .then(function (data) { successCallback(data); })
                        .catch(function (err) {
                            console.error('Error al cargar horarios disponibles', err);
                            failureCallback('Error al cargar horarios disponibles');
                        });
                },
                eventTimeFormat: { hour: '2-digit', minute: '2-digit' },
                eventClick: function (info) {
                    const estado = info.event.extendedProps.estado;
                    if (estado !== 'disponible' && estado !== 'turnos') {
                        alert('Este horario no está disponible. Por favor seleccione otro.');
                        return;
                    }

                    document.querySelectorAll('.fc-event-selected').forEach(function (el) {
                        el.classList.remove('fc-event-selected');
                    });
                    info.el.classList.add('fc-event-selected');

                    turnoSeleccionado = info.event;
                    document.getElementById("confirmarTurno").removeAttribute("disabled");
                },
                eventDidMount: function (info) {
                    info.el.classList.add('fc-event-' + info.event.extendedProps.estado);
                },
            });

            calendarTurno.render();
            setTimeout(function () {
                if (calendarTurno) {
                    calendarTurno.updateSize();
                    calendarTurno.refetchEvents();
                }
            }, 200);
        });

        document.getElementById("confirmarTurno").addEventListener("click", function () {
            if (!turnoSeleccionado) {
                alert("Por favor selecciona un horario disponible.");
                return;
            }

            const inicio = turnoSeleccionado.start;
            document.getElementById("fecha_turno").value = formatoFechaLocal(inicio);
            document.getElementById("hora_turno").value = formatoHoraLocal(inicio);

            const resumen = document.getElementById("resumenTurno");
            resumen.textContent = "Turno seleccionado: " + formatoFechaLocal(inicio) + " a las " + pad(inicio.getHours()) + ":" + pad(inicio.getMinutes());
            resumen.style.display = "block";

            bootstrap.Modal.getOrCreateInstance(document.getElementById('calendarModal')).hide();
        });

        document.getElementById("form_roles").addEventListener("submit", function (e) {
            const fecha = document.getElementById("fecha_turno").value;
            const hora = document.getElementById("hora_turno").value;
            if (!fecha || !hora) {
                e.preventDefault();
                alert("Debes seleccionar la fecha y el horario del turno antes de guardar.");
            }
        });
    </script>
    @endsection
