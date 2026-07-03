<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Si concilio</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 4.1.1 -->
    <link href="public/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>

    <!-- Ionicons -->
    <link href="//fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link href="public/assets/css/all.css" rel="stylesheet" type="text/css">
    <link href="public/assets/css/iziToast.min.css" rel="stylesheet">
    <link href="public/assets/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="public/assets/css/select2.min.css" rel="stylesheet" type="text/css"/>
    <link href="public/assets/css/realtime.css" rel="stylesheet" type="text/css"/>

    <!-- Agregados para los Select del Formulario Personas-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('public/assets/images/pageLoader.gif') 50% 50% no-repeat rgb(249,249,249);
            opacity: .8;
        }
        #calendarTurnosRol {
            width: 100% !important;
            display: block;
        }

        .fc-view-harness {
            background-color: #fff;
        }

        .card-body {
            padding: 15px !important;
        }

        .btn-filtro-turnos.active {
            background-color: #530c3a !important;
            border-color: #530c3a !important;
        }

        @media (max-width: 768px) {
            .btn-custom-morado {
                width: 100% !important;
                margin-bottom: 5px !important;
                white-space: normal;
                font-size: 0.85rem;
            }

            .fc .fc-toolbar {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .fc .fc-toolbar-title {
                font-size: 1.2rem !important;
                text-align: center;
                width: 100%;
            }

            .fc .fc-toolbar-chunk {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 5px;
            }

            .fc .fc-button {
                padding: 0.4em 0.6em !important;
                font-size: 0.85em !important;
            }
        }
    </style>

    @livewireStyles

    @yield('page_css')
    <!-- Template CSS -->
    <link rel="icon" href="public/assets/images/ccl-r.png" type="image/x-icon">
    <link rel="stylesheet" href="public/assets/css/style.css">
    <link rel="stylesheet" href="public/assets/css/components.css">
    @yield('page_css')

    @yield('css')
</head>

<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar" style="background-color: #6A0F49">
            <form class="form-inline mr-auto" action="#">
                <ul class="navbar-nav mr-3">
                    <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="bi bi-bricks"></i></a></li>
                </ul>
            </form>
            <ul class="navbar-nav navbar-right">
                @if(\Illuminate\Support\Facades\Auth::user())
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown"
                        class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="public/assets/images/ccl-r.png"
                                class="rounded-circle mr-1 thumbnail-rounded user-thumbnail ">
                            <div class="d-sm-none d-lg-inline-block">
                                Hola, {{\Illuminate\Support\Facades\Auth::user()->name}}</div>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('password_cambiar' ) }}" class="dropdown-item has-icon text-susess">
                                <i class="bi bi-pass"></i>Cambiar contraseña
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item has-icon text-danger d-flex align-items-center" style="border: none; background: none; width: 100%; padding: 10px 20px;">
                                    <i class="bi bi-door-open me-2"></i> Salir
                                </button>
                            </form>
                        </div>
                    </li>
                @else
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        <div class="d-sm-none d-lg-inline-block">{{ __('messages.common.hello') }}</div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-title">{{ __('messages.common.login') }}
                                / {{ __('messages.common.register') }}</div>
                            <a href="{{ route('login') }}" class="dropdown-item has-icon">
                                <i class="fas fa-sign-in-alt"></i> {{ __('messages.common.login') }}
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('register') }}" class="dropdown-item has-icon">
                                <i class="fas fa-user-plus"></i> {{ __('messages.common.register') }}
                            </a>
                        </div>
                    </li>
                @endif
            </ul>
        </nav>
        <div class="main-sidebar main-sidebar-postion">
            <aside id="sidebar-wrapper">
                <div class="sidebar-brand">
                    <img class="navbar-brand-full app-header-logo" src="public/assets/images/ccl-r.png" width="65"
                        alt="Infyom Logo">
                    <a href="{{ url('/') }}"></a>
                </div>
                <div class="sidebar-brand sidebar-brand-sm">
                    <a href="{{ url('/') }}" class="small-sidebar-text">
                        <img class="navbar-brand-full" src="public/assets/images/ccl-r.png" width="45px" alt=""/>
                    </a>
                </div>
                <ul class="sidebar-menu">
                    @include('layouts.menu')
                </ul>
            </aside>
        </div>
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h3 class="page__heading">Sistema integral para la Conciliación</h3>
                </div>
                <div class="section-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <ul class="navbar-nav flex-grow-1 justify-content-center">
                                            <li class="nav-item text-center">
                                                <img src="public/assets/images/ccl-r.png" alt="Logo" class="img-fluid" style="max-height: 100px;">
                                            </li>
                                        </ul><br>
                                        <div class="w-100">
                                            <div class="d-flex flex-wrap justify-content-center mb-3 mt-3" style="gap:5px;">
                                                <button type="button" class="btn btn-md btn-custom-morado btn-filtro-turnos active" data-filtro="Solicitud">Solicitud</button>
                                                <button type="button" class="btn btn-md btn-custom-morado btn-filtro-turnos" data-filtro="Asesoría">Asesorías</button>
                                                <button type="button" class="btn btn-md btn-custom-morado btn-filtro-turnos" data-filtro="Ratificación">Ratificación</button>
                                                <button type="button" class="btn btn-md btn-custom-morado btn-filtro-turnos" data-filtro="Excepcion">Excepción</button>
                                            </div>
                                            <div id="calendarTurnosRol" style="width: 100%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <footer class="main-footer">
        </footer>
    </div>
</div>

<div class="modal fade" id="modalDetalleTurno" tabindex="-1" role="dialog" aria-labelledby="modalDetalleTurnoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetalleTurnoLabel">Detalle del turno</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped mb-0">
                    <tbody>
                        <tr>
                            <th>Folio</th>
                            <td id="detalleFolio"></td>
                        </tr>
                        <tr>
                            <th style="width:40%;">Fecha</th>
                            <td id="detalleFecha"></td>
                        </tr>
                        <tr>
                            <th>Hora</th>
                            <td id="detalleHora"></td>
                        </tr>
                        <tr>
                            <th>Nombre</th>
                            <td id="detalleNombre"></td>
                        </tr>
                        <tr>
                            <th>Tipo</th>
                            <td id="detalleTipo"></td>
                        </tr>
                        <tr>
                            <th>Usuario Asignado</th>
                            <td id="detalleCreador"></td>
                        </tr>
                        <tr>
                            <th>Estatus</th>
                            <td id="detalleEstatus"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="menu_carga" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>

@section('scripts')
    <script src="public/assets/js/general/menu.js"></script>
@endsection

</body>

    <script src="public/assets/js/jquery.min.js"></script>
    <script src="public/assets/js/popper.min.js"></script>
    <script src="public/assets/js/bootstrap.min.js"></script>
    <script src="public/assets/js/sweetalert.min.js"></script>
    <script src="public/assets/js/select2.min.js"></script>
    <script src="public/assets/js/jquery.nicescroll.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/locales-all.min.js"></script>

    <!-- Template JS File -->
    <script src="public/assets/js/stisla.js"></script>
    <script src="public/assets/js/scripts.js"></script>
    <script src="public/assets/js/profile.js"></script>
    <script src="public/assets/js/custom.js"></script>
@yield('page_js')
@yield('scripts')

<script>
    function capitalizarPalabras(texto) {
        return texto.replace(/\S+/g, function (palabra) {
            return palabra.charAt(0).toUpperCase() + palabra.slice(1).toLowerCase();
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendarTurnosRol');
        const botones = document.querySelectorAll('.btn-filtro-turnos');
        let filtroActual = 'Solicitud';

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'listWeek',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            buttonText: {
                today: 'Hoy'
            },
            events: function (fetchInfo, successCallback, failureCallback) {
                const params = new URLSearchParams({
                    filtro: filtroActual,
                    start: fetchInfo.startStr,
                    end: fetchInfo.endStr,
                });

                fetch("{{ route('recepcion.eventos') }}?" + params.toString())
                    .then(function (res) { return res.json(); })
                    .then(function (data) { successCallback(data); })
                    .catch(function (err) {
                        console.error('Error al cargar los turnos', err);
                        failureCallback('Error al cargar los turnos');
                    });
            },
            eventTimeFormat: { hour: '2-digit', minute: '2-digit' },
            eventClick: function (info) {
                const props = info.event.extendedProps;
                document.getElementById('detalleFolio').textContent = props.folio || '';
                document.getElementById('detalleFecha').textContent = props.fecha || '';
                document.getElementById('detalleHora').textContent = props.hora || '';
                document.getElementById('detalleNombre').textContent = props.solicitante || '';
                document.getElementById('detalleTipo').textContent = props.tipo || '';
                document.getElementById('detalleCreador').textContent = props.creador || '';
                document.getElementById('detalleEstatus').textContent = capitalizarPalabras(props.estatus || '');
                $('#modalDetalleTurno').modal('show');
            },
        });

        calendar.render();

        botones.forEach(function (boton) {
            boton.addEventListener('click', function () {
                filtroActual = this.getAttribute('data-filtro');
                botones.forEach(function (b) { b.classList.remove('active'); });
                this.classList.add('active');
                calendar.refetchEvents();
            });
        });
    });
</script>
</html>
