<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Si concilio</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 5.3.3 -->
    <link href="public/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <!-- Ionicons -->
    <link rel="icon" href="public/assets/images/ccl-r.png" type="image/x-icon">
    <link href="//fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <link href="public/assets/css/all.css" rel="stylesheet" type="text/css">
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
    @livewireStyles

    @yield('page_css')
    <!-- Template CSS <img src="public/assets_seer/images/ccl.png" width="180" height="90" style="position: absolute; left: 100px; top: 10px; right:0px;"/>  -->
    <link rel="stylesheet" href="public/assets/css/components.css">
    @yield('page_css')
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="">
        <img src="public/assets/images/Logos 2.png" class="img" width="260" height="90">
    </div> 
</nav>
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
                                    <div style="background-color:#D2D3D5; width:100%; height:40px;">
                                        <h3 class="text-center" style="color:black">Genera tu cita para ratificación</h3>
                                    </div>    
                                    <!--Se realiza el envío de datos con formulario de Laravel Collective-->
                                    <form class="needs-validation novalidate" method="POST" action="{{route('turnos.publico')}}">
                                        @csrf
                                        <br><br>
                                        <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="btncheck1">¿Cuenta con folio interno de Centro de Conciacion laboral del Estado de Michoacan de Ocampo?<br> 
                                                        Puede registrarse en la siguiente liga (Para tramites posteriores) <a href="{{ route('poder-crear'); }}">Registrar</a>
                                                    </label><br>
                                                    <input name="labora" type="checkbox" class="btn-check" id="check_folio" autocomplete="off"/>
                                                </div>
                                            </div>

                                            <div id="folio" class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">*Folio Interno de CCL</label>
                                                    <input type="text" name="folio" class="form-control"> 
                                                    <div class="invalid-feedback">
                                                        El folio es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="empresa" class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">*Nombre de la empresa o patrón</label>
                                                    <input type="text" name="empresa" class="form-control"> 
                                                    <div class="invalid-feedback">
                                                        El nombre es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="nombre" class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">*Nombre (Persona que Acude a la Cita)</label>
                                                    <input type="text" name="nombre" class="form-control"> 
                                                    <div class="invalid-feedback">
                                                        El nombre es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="edad" class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Email</label>
                                                    <input type="email" name="email" class="form-control"> 
                                                    <div class="invalid-feedback">
                                                        El campo edad es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="sexo" class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                <label for="name">Télefono</label>
                                                <input type="number" name="telefono" class="form-control"> 
                                                    <div class="invalid-feedback">
                                                        El campo sexo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="ine" class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label>*Identificación oficial(PDF,PNG,JPG)</label><br>
                                                    <input type="file" name="documentoIne" class="form-control" accept=".pdf, jpe, .png, .jpeg">
                                                    <div class="invalid-feedback">
                                                        La Identificación es obligatoria.
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="acta" class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label>Acta constitutiva (Si acude en reprecentación *PDF,PNG,JPG) </label><br>
                                                    <input type="file" name="documentoPoder" class="form-control" accept=".pdf, jpe, .png, .jpeg">
                                                    <div class="invalid-feedback">
                                                        La Identificación es obligatoria.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <h4 class="text-center">Trabajador</h4>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Nombre</label>
                                                    <input type="text" name="trabajador" class="form-control" required> 
                                                    <div class="invalid-feedback">
                                                        El nombre es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="div1"  class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Edad</label>
                                                    <input type="number" name="trabajador_edad" class="form-control" required> 
                                                    <div class="invalid-feedback">
                                                        El campo edad es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="div2"  class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                <label for="name">Sexo</label>
                                                    <select name="trabajador_sexo" class="form-control" required>
                                                        <option value="">Seleccione</option>
                                                        <option value="H">Hombre</option>
                                                        <option value="M">Mujer</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El campo sexo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <h4 class="text-center">Datos de la solicitud</h4>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Salario</label>
                                                    <input type="number" name="monto" class="form-control" required> 
                                                    <div class="invalid-feedback">
                                                        Este campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Frecuencia de pago</label>
                                                    <select name="frecuencia" class="form-control"  required>
                                                        <option value="">Seleccione la sede</option>
                                                        <option value="Diario">Diario</option>
                                                        <option value="Semanal">Semanal</option>
                                                        <option value="Quincenal">Quincenal</option>
                                                        <option value="Mensual">Mensual</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Este campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Dias a la semana trabajados</label>
                                                    <input type="number" name="dias" class="form-control" required> 
                                                    <div class="invalid-feedback">
                                                        Este campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Monto del convenio a pagar</label>
                                                    <input type="number" name="monto" class="form-control" required> 
                                                    <div class="invalid-feedback">
                                                        El campo edad es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Forma de pago</label>
                                                    <select name="tipo_pago" class="form-control"  required>
                                                        <option value="">Seleccione el tipo de pago</option>
                                                        <option value="Efectivo">Efectivo</option>
                                                        <option value="Transferencia">Transferencia</option>
                                                        <option value="Cheque">Cheque</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El campo edad es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div  class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">¿Existe procedimiento previo en la JLCA?</label>
                                                    <select name="JLCA" class="form-control"  required>
                                                        <option value="">Seleccione el tipo de pago</option>
                                                        <option value="Si">Si</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Motivo de la conciliación</label>
                                                    <select name="motivo" class="form-control"  required>
                                                        <option value="">Seleccione el motivo</option>
                                                        <option value="Despido">Despido</option>
                                                        <option value="Pago de prestaciones">Pago de prestaciones</option>
                                                        <option value="Rescisión de la relación de trabajo">Rescisión de la relación de trabajo</option>
                                                        <option value="Derecho de preferencia">Derecho de preferencia</option>
                                                        <option value="Derecho de antigüedad">Derecho de antigüedad</option>
                                                        <option value="Derecho de asens">Derecho de asenso</option>
                                                        <option value="Terminación voluntaria de la relación de trabajo">Terminación voluntaria de la relación de trabajo</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3">
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
                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Día</label>
                                                    <input id="fecha" type="date" name="fecha" class="form-control" onchange="diaSemana();" disabled>
                                                    <div class="invalid-feedback">
                                                        El campo conflicto es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-3">
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

                                            <div class="col-xs-12 col-sm-6 col-md-2">
                                                <div class="form-group">
                                                    <label for="name">
                                                    <a href="https://cclmichoacan.gob.mx/Calculadora.html" target="_blank">* Calcula el aproximado de la ratificación.</a>
                                                    </label>
                                                    
                                                    <div class="invalid-feedback">
                                                        El campo conflicto es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div align="center">
                                                <button type="submit" class="btn btn-primary" style="background-color:#CEA845; border-color: #CEA845">Guardar</button>
                                                <a href="{{ route('publico'); }}" class="btn btn-primary" style=" background-color:#CEA845; border-color: #CEA845">Regresar</a>    
                                            </div>
                                        </div>    
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

    <div id="crear_poder" style ="display: none;">
        <div>.</div>
        <div class="loader"></div>
    </div>

@section('scripts')
    <script src="public/assets/js/poderes/general.js"></script>
@endsection



    <script src="public/assets/js/jquery.min.js"></script>
    <script src="public/assets/js/popper.min.js"></script>
    <script src="public/assets/js/bootstrap.min.js"></script>
    <script src="public/assets/js/sweetalert.min.js"></script>
    <script src="public/assets/js/select2.min.js"></script>
    <script src="public/assets/js/jquery.nicescroll.js"></script>

    <!-- Template JS File -->
    <script src="public/assets/js/stisla.js"></script>
    <script src="public/assets/js/scripts.js"></script>
    <script src="public/assets/js/profile.js"></script>
    <script src="public/assets/js/custom.js"></script>

    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap4.js"></script>
    @yield('page_js')


    @yield('scripts')
    <script>
        document.getElementById("folio").style.display = "none";
        document.getElementById("empresa").style.display = "none";
        document.getElementById("nombre").style.display = "none";
        document.getElementById("edad").style.display = "none";
        document.getElementById("sexo").style.display = "none";
        document.getElementById("ine").style.display = "none";
        document.getElementById("acta").style.display = "none";


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

        $(function(){
            $('#check_folio').on('change', validarcheckfolio);
        })

        function validarcheckfolio(){
            tipo = document.getElementById("folio").style.display;
            if (tipo == "none") {
                document.getElementById("folio").style.display = "block";
                document.getElementById("empresa").style.display = "none";
                document.getElementById("nombre").style.display = "none";
                document.getElementById("edad").style.display = "none";
                document.getElementById("sexo").style.display = "none";
                document.getElementById("ine").style.display = "none";
                document.getElementById("acta").style.display = "none";
            }
            else{
                document.getElementById("folio").style.display = "none";
                document.getElementById("empresa").style.display = "block";
                document.getElementById("nombre").style.display = "block";
                document.getElementById("edad").style.display = "block";
                document.getElementById("sexo").style.display = "block";
                document.getElementById("ine").style.display = "block";
                document.getElementById("acta").style.display = "block";
            }
        }

    </script>
<div id="crear_poder" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>

@section('scripts')
    <script src="public/js/poderes/general.js"></script>
    
@endsection
