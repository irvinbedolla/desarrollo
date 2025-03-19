<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Sí Conciliación</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 4.1.1 -->
    <link href="public/assets_seer/assets/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <!-- Ionicons -->
    <link rel="icon" href="public/assets_seer/images/icono.png" type="image/x-icon">
    <link href="//fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link href="public/assets/css/@fortawesome/fontawesome-free/css/all.css" rel="stylesheet" type="text/css">
    <link href="public/assets/css/iziToast.min.css" rel="stylesheet">
    <link href="public/assets/css/sweetalert.css" rel="stylesheet" type="text/css"/>
    <link href="public/assets/css/select2.min.css" rel="stylesheet" type="text/css"/>
    
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
    </style>

    <style>
       /* .cabecera{   
            width:2000px;
            height:100px;
        }*/
    </style>
    <style>
        /*.img{
            display: flex;
            justify-content: center;
        }
       /* .btn btn-primary{

        }*/
    </style>
    @livewireStyles

    @yield('page_css')
    <!-- Template CSS <img src="public/assets_seer/images/ccl.png" width="180" height="90" style="position: absolute; left: 100px; top: 10px; right:0px;"/>  -->
    <link rel="stylesheet" href="public/web/css/style.css">
    <link rel="stylesheet" href="public/web/css/components.css">
    @yield('page_css')
</head>

    <div id="app">  
        <section class="section">
            <div class="col-lg-12" >
                <div style="background-color:#6A0F49">
                    <div align="right"><br>
                        <img src="public/assets_seer/images/ccl.png" style="max-width: 10%" class="text-center">
                    </div>
                    <h3 class="text-center" style="color:#CEA845">Genera tu cita para ratificación</h3>    
                </div>
            </div>
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
                                <div style="background-color:#6A0f49">
                                    <h3 class="text-center" style="color:#CEA845">Ingresa tus datos</h3>
                                </div>    
                                <!--Se realiza el envío de datos con formulario de Laravel Collective-->
                                {!! Form::open(array('route'=>'turnos.publico', 'method'=>'POST', 'files' => true, 'class' => 'needs-validation','novalidate')) !!}
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="name">Nombre del solicitante</label>
                                                <input type="text" name="nombre" class="form-control" required> 
                                                <div class="invalid-feedback">
                                                    El nombre es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="name">Tipo Solicitud</label>
                                                <select name="tipo" class="form-control" required>
                                                    <option value="">Seleccione</option>
                                                    <option value="Solicitud">Solicitud</option>
                                                    <option value="Ratificación">Ratificación</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    El tipo de solicitud es obligatoria.
                                                </div>
                                            </div>
                                        </div>

                                        <div id="div1"  class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="name">Edad</label>
                                                <input type="number" name="edad" class="form-control" required> 
                                                <div class="invalid-feedback">
                                                    El campo edad es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div id="div2"  class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                            <label for="name">Sexo</label>
                                                <select name="sexo" class="form-control" required>
                                                    <option value="">Seleccione</option>
                                                    <option value="H">Hombre</option>
                                                    <option value="M">Mujer</option>
                                                    <option value="NB">No Binarios</option>
                                                    <option value="LGBTTTIQ">LGBTTTIQ+</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    El campo sexo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="name">Conflicto</label>
                                                <textarea name="conflicto" class="form-control"></textarea>
                                                <div class="invalid-feedback">
                                                    El campo conflicto es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="name">Sedes</label>
                                                <select id="sede" name="sede" class="form-control" onchange="sedes();" required>
                                                    <option value="">Seleccione la sede</option>
                                                    <option value="Morelia">Morelia</option>
                                                    <option value="Uruapan">Uruapan</option>
                                                    <option value="Zamora">Zamora</option>
                                                    <option value="Zitácuaro">Zitácuaro</option>
                                                    <option value="Lázaro Cárdenas">Lázaro Cárdenas</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    La sede es obligatoria.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="name">Dia</label>
                                                <input id="fecha" type="date" name="fecha" class="form-control" onchange="diaSemana();" disabled>
                                                <div class="invalid-feedback">
                                                    El campo conflicto es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="password">Horario Disponible</label>
                                            <select id="horarios" name="hora" class="form-control">
                                                <option value=""> --Primero selecciona un Dia --</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                El Horario es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div align="center">
                                            <button type="submit" class="btn btn-primary" style="background-color:#CEA845;">Guardar</button>
                                            <a href="{{ url('/'); }}" class="btn btn-primary" style=" background-color:#CEA845;">Regresar</a>    
                                        </div>
                                    </div>    
                                {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <div id="crear_poder" style ="display: none;">
        <div>.</div>
        <div class="loader"></div>
    </div>

@section('scripts')
    <script src="public/js/poderes/general.js"></script>
@endsection



    <script src="public/assets/js/jquery.min.js"></script>
    <script src="public/assets/js/popper.min.js"></script>
    <script src="public/assets/js/bootstrap.min.js"></script>
    <script src="public/assets/js/sweetalert.min.js"></script>
    <script src="public/assets/js/select2.min.js"></script>
    <script src="public/assets/js/jquery.nicescroll.js"></script>

    <!-- Template JS File -->
    <script src="public/web/js/stisla.js"></script>
    <script src="public/web/js/scripts.js"></script>
    <script src="public/assets/js/profile.js"></script>
    <script src="public/assets/js/custom/custom.js"></script>

    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap4.js"></script>
    @yield('page_js')


    @yield('scripts')
    <script>
        function sedes(){
            document.getElementById("fecha").removeAttribute("disabled");
        }
        function diaSemana() {
            var dia_semana  = document.getElementById("fecha").value;
            var sede        = document.getElementById("sede").value;

            $.get('api/obtenerHorario/'+dia_semana+'/'+sede, function (data){
                var html_select = '<option value="">--Seleccione un horario --</option>';  
                for(var i=0; i<data.length; ++i)
                    html_select += '<option value= "'+data[i].hora+'">'+data[i].hora+'</option>';
                    $('#horarios').html(html_select);

            });
        }
    </script>
<div id="crear_poder" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>

@section('scripts')
    <script src="public/js/poderes/general.js"></script>
    
@endsection
