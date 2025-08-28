<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Si concilio</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 5.3.3 -->
    <link href="../public/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>

    <!-- Ionicons -->
    <link rel="icon" href="public/assets/images/ccl-r.png" type="image/x-icon">
    <link href="//fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link href="../public/assets/css/all.css" rel="stylesheet" type="text/css">
    <link href="../public/assets/css/iziToast.min.css" rel="stylesheet">
    <link href="../public/assets/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="../public/assets/css/select2.min.css" rel="stylesheet" type="text/css"/>
    
    <!-- Agregados para los Select del Formulario Personas-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <style>
        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('public/assets/images/pageLoader.gif') 50% 50% no-repeat rgb(249,249,249);
           /* background-color: #6A0F49;/*<p style="color: #CEA845*/
            opacity: .8;
        }
        .resultado {
            background-color: red;
            color: white;
            font-weight: bold;
        }
        .resultado.ok {
            background-color: green;
        }

        .fc-event {
            padding: 3px 6px !important;
            border-radius: 4px !important;
            font-size: 12px !important;
            cursor: pointer;
        }

        #calendar {
            width: 100%;
            min-height: 500px;
        }

        .fc-event-disponible {
            background-color: #00CE1C !important;
            border-color: #00CE1C !important;
            cursor: pointer;
        }

        .fc-event-ocupado {
            background-color: #DA0909 !important;
            border-color: #DA0909 !important;
            cursor: not-allowed;
        }

        .fc-event-selected {
            border: 2px solid #FFD700 !important;
            box-shadow: 0 0 8px #FFD700;
        }

        .modal-xl {
            max-width: 95% !important;
        }

        .modal-content {
            height: 90vh;
        }

        .modal-body {
            overflow-y: auto;
        }

        .btn-custom-morado {
            height: 50px;
            font-size: 12px;
            padding: 5px 10px;
            background-color: #6A0F49 !important;
            color: #fff !important;
            border: none;
        }
        .btn-custom-morado:hover, .btn-custom-morado:focus {
            background-color: #530c3a !important;
            color: #fff !important;
        }
    </style>
    @livewireStyles

    @yield('page_css')
    <!-- Template CSS <img src="public/assets_seer/images/ccl.png" width="180" height="90" style="position: absolute; left: 100px; top: 10px; right:0px;"/>  -->
    <link rel="stylesheet" href="../public/assets/css/components.css">
    @yield('page_css')
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="">
        <img src="../public/assets/images/Logos 2.png" class="img" width="260" height="90">
    </div> 
</nav>
<body>
    <main>
        <div class="container">
            <br><br><br><br>
        </div>
        <section class="section">
            <div class="section-body">
                <?php $fecha_actual = date('d-m-Y');?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-center">Crear cumplimiento</h3>
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
                                <!--Se realiza el envío de datos con formulario de Laravel Collective-->
                                <form class="needs-validation novalidate" method="POST" action="{{route('turnos.publico')}}" enctype="multipart/form-data" onsubmit="return validacionCamposInput()">
                                    @csrf
                                    <br><br>
                                    <div class="row">
                                        <div id="empresa" class="col-xs-12 col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="name">Número de identificación único<span style="color:red;">(*)</span></label>
                                                <input type="text" name="NUE" id="NUE" class="form-control" oninput="this.value = this.value.toUpperCase()"> 
                                                <div class="invalid-feedback">
                                                    El Número de identificación es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div id="empresa" class="col-xs-12 col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="name">Nombre de la Empresa/Patrón/Representante legal <span style="color:red;">(*)</span></label>
                                                <input type="text" name="empresa" id="empresa" class="form-control" oninput="this.value = this.value.toUpperCase()"> 
                                                <div class="invalid-feedback">
                                                    El nombre empresa/patrón/representante legal es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="name">Nombre(s) y apellidos trabajador <span style="color:red;">(*)</span></label>
                                                <input type="text" name="trabajador" class="form-control soloLetras" oninput="this.value = this.value.toUpperCase()" required> 
                                                <div class="invalid-feedback">
                                                    El nombre es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <label for="name">Monto<span style="color:red;">(*)</span></label>
                                                <input type="text" name="monto" class="form-control soloMontos" required> 
                                                <div class="invalid-feedback">
                                                    El campo edad es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="name">Forma de pago<span style="color:red;">(*)</span></label>
                                                <input type="text" name="forma_pago" class="form-control soloLetras"required>
                                                <div class="invalid-feedback">
                                                    El campo forma de pago es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="name">Sedes <span style="color:red;">(*)</span></label>
                                                <select id="sede" name="sede" class="form-control" onchange="modalCalendar();" required>
                                                    <option value="">Seleccione la sede</option>
                                                    <option value="Morelia">Morelia</option>
                                                    <option value="Uruapan">Uruapan</option>
                                                    <option value="Zamora">Zamora</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    La sede es obligatoria.
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="fecha" id="fechaSeleccionada" required>
                                        <input type="hidden" name="hora" id="horaSeleccionada" required>
                                        <!-- Botón para abrir el modal -->  
                                        <div class="col-xs-12 col-sm-12 col-md-3 d-flex align-items-center">
                                            <div style="display: flex; align-items: center; justify-content: center;">
                                                <button type="button" id="botonCalendar" class="btn btn-lg btn-custom-morado" data-toggle="modal" data-target="#calendarModal" disabled>
                                                    Seleccionar Fecha y Horario
                                                </button>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="calendarModal" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Seleccionar Fecha y Horario</h5>
                                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div id="calendar"></div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                        <button type="button" class="btn btn-primary" id="confirmarSeleccion">Confirmar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="resumenCita" class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 10px; display: none;">
                                        <div class="alert alert-info">
                                            <strong>Cita seleccionada:</strong> <span id="fechaResumen"></span> a las <span id="horaResumen"></span>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div align="center">
                                            <button type="submit" class="btn btn-primary" style="background-color:#CEA845; border-color: #CEA845">Guardar</button>
                                            <a href="{{ route('publico'); }}" class="btn btn-primary" style=" background-color:#CEA845; border-color: #CEA845">Cancelar</a>    
                                        </div>
                                    </div>     
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>   
    <div id="crear_poder" style ="display: none;">
        <div>.</div>
        <div class="loader"></div>
    </div>

    @section('scripts')
       <!-- <script src="../public/assets/js/validaciones-ratificacion.js"></script> -->
        <script src="../public/assets/js/poderes/general.js"></script>
    @endsection
    <script src="../public/assets/js/jquery.min.js"></script>
    <script src="../public/assets/js/popper.min.js"></script>
    <script src="../public/assets/js/bootstrap.min.js"></script>
    <script src="../public/assets/js/sweetalert.min.js"></script>
    <script src="../public/assets/js/select2.min.js"></script>
    <script src="../public/assets/js/jquery.nicescroll.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/locales-all.min.js"></script>

    <!-- Template JS File -->
    <script src="../public/assets/js/stisla.js"></script>
    <script src="../public/assets/js/scripts.js"></script>
    <script src="../public/assets/js/profile.js"></script>
    <script src="../public/assets/js/custom.js"></script>

    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap4.js"></script>

    @yield('page_js')
    @yield('scripts')
    <script>
        function sedes(){
            document.getElementById("fecha").removeAttribute("disabled");
        }

        function modalCalendar(){
            document.getElementById("botonCalendar").removeAttribute("disabled");
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                },
                validRange: {
                    start: (() => {
                        const now = new Date();
                        return new Date(now.getFullYear(), now.getMonth() - 1, 1).toISOString().split('T')[0];
                    })(),
                    end: (() => {
                        const now = new Date();
                        return new Date(now.getFullYear(), now.getMonth() + 3, 0).toISOString().split('T')[0];
                    })()
                },
                events: function(fetchInfo, successCallback, failureCallback) {
                    // Obtener sede seleccionada
                    var sede = document.getElementById('sede').value;
                    
                    // Hacer petición AJAX con parámetro sede
                    $.ajax({
                        url: '/nuevo_siconcilio/api/obtenerEventos',
                        method: 'GET',
                        data: {
                            sede: sede,
                            start: fetchInfo.startStr,
                            end: fetchInfo.endStr
                        },
                        success: function(data) {
                            successCallback(data);
                        },
                        error: function() {
                            failureCallback('Error al cargar eventos');
                        }
                    });
                },


                eventClick: function(info) {
                    // Solo permitir selección de horarios disponibles
                    let ahora = new Date();
                    let slotDate = new Date(info.event.start);

                    if (info.event.extendedProps.estado === 'disponible' && slotDate > ahora) {
                        // Deseleccionar evento anterior
                        document.querySelectorAll('.fc-event-selected').forEach(el => {
                            el.classList.remove('fc-event-selected');
                        });
                        
                        // Seleccionar este evento
                        info.el.classList.add('fc-event-selected');
                        window.selectedEvent = info.event;
                    } else {
                        alert('Este horario no está disponible. Por favor seleccione otro.');
                    }
                },
                eventDidMount: function(info) {
                    // Añade clases CSS según el tipo de evento
                    if (info.event.extendedProps.estado === 'disponible') {
                        info.el.classList.add('fc-event-disponible');
                    } else {
                        info.el.classList.add('fc-event-ocupado');
                    }
                },
            });

            calendar.render();

            $('#calendarModal').on('shown.bs.modal', function () {
                calendar.refetchEvents();
                calendar.updateSize();
            });

            // Confirmar selección
            document.getElementById('confirmarSeleccion').addEventListener('click', function() {
                if (window.selectedEvent) {
                    const fechaHora = new Date(window.selectedEvent.start);
                    const fecha = fechaHora.toISOString().split('T')[0];
                    const hora = fechaHora.toTimeString().substring(0, 8);
                    
                    // Guardar en campos ocultos
                    document.getElementById('fechaSeleccionada').value = fecha;
                    document.getElementById('horaSeleccionada').value = hora;
                    
                    // Mostrar resumen al usuario
                    document.getElementById('fechaResumen').textContent = fecha;
                    document.getElementById('horaResumen').textContent = hora;
                    document.getElementById('resumenCita').style.display = 'block';
                    
                    // Cerrar modal
                    $('#calendarModal').modal('hide');
                } else {
                    alert('Por favor selecciona un horario disponible');
                }
            });
        });
    </script>