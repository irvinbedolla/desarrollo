<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Si concilio</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 5.3.3 -->
    <link href="{{ asset('public/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js'></script>

    <!-- Ionicons -->
    <link rel="icon" href="{{ asset('public/assets/images/ccl-r.png') }}" type="image/x-icon">
    <link href="//fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link href="{{ asset('public/assets/css/all.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/assets/css/iziToast.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/assets/css/sweetalert.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('public/assets/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    
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
            background: url('{{ asset('public/assets/images/pageLoader.gif') }}') 50% 50% no-repeat rgb(249,249,249);
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
    <link rel="stylesheet" href="{{ asset('public/assets/css/components.css') }}">
    @yield('page_css')
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="">
    <img src="{{ asset('public/assets/images/Logos 2.png') }}" class="img" width="260" height="90">
    </div> 
</nav>
<body onload="validarcheckfolio()">
    <main>
        <div class="container">
            <br><br><br><br>
        </div>
        <div id="app">  
        <section class="section"> 
            <div class="section-body">
                <div class="row"> 
                    <div class="col-lg-12" >
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
                                @if (session()->has('error'))
                                    <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                        <strong>¡Revise los campos!</strong>
                                        {{ session()->get('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <div style="background-color:#D2D3D5; width:100%; height:40px;">
                                    <h3 class="text-center" style="color:black">Genera tu constancia</h3>
                                </div>
                                <form method="POST" target="_self" action="{{ route('ValidarConstancia') }}" id="formConstancia">
                                    @csrf
                                    <div class="row align-items-end">
                                        <div class="col-md-4">
                                            <input type="hidden" name="folio" value="{{ $id }}">
                                            <p>Folio: {{$id}}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="constancia" class="form-label fw-bold">Conferencia / Conversatorio</label>
                                            <select name="constancia" id="constancia" class="form-control" required>
                                                @if(isset($constancia) && count($asistencias) > 0)
                                                    <option value="">Seleccione una opción</option>
                                                    @foreach($asistencias as $campo => $nombre)
                                                        <option value="{{ $nombre }}">{{ $nombre }}</option>
                                                    @endforeach
                                                @elseif(isset($constancia))
                                                    <option value="">No tiene asistencias registradas</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-success">Generar constancia</button>
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
@section('scripts')
    <script src="{{ asset('public/assets/js/validaciones-ratificacion.js') }}"></script> 
    <script src="{{ asset('public/assets/js/poderes/general.js') }}"></script>
@endsection

    <script src="{{ asset('public/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/select2.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/jquery.nicescroll.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/locales-all.min.js"></script>

    <!-- Template JS File -->
    <script src="{{ asset('public/assets/js/stisla.js') }}"></script>
    <script src="{{ asset('public/assets/js/scripts.js') }}"></script>
    <script src="{{ asset('public/assets/js/profile.js') }}"></script>
    <script src="{{ asset('public/assets/js/custom.js') }}"></script>

    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap4.js"></script>
    @yield('page_js')