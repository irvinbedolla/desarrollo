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
        .resultado {
            background-color: red;
            color: white;
            font-weight: bold;
        }
        .resultado.ok {
            background-color: green;
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
                                        <h3 class="text-center" style="color:black">Genera tu cita para ratificación</h3>
                                    </div>    
                                    <!--Se realiza el envío de datos con formulario de Laravel Collective-->
                                    <form class="needs-validation novalidate" method="POST" action="{{route('turnos.publico')}}" enctype="multipart/form-data" onsubmit="return validacionCamposInput()">
                                        @csrf
                                        <br><br>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="btncheck1">¿Cuenta con Folio Interno de Registro de Representación Legal Patronal?<br> 
                                                        Puede registrarse en la siguiente liga (Para tramites posteriores) <a href="{{ route('poder-crear'); }}">Registrar</a>
                                                    </label><br>
                                                    <input name="labora" type="checkbox" class="btn-check" id="check_folio" autocomplete="off"/>
                                                </div>
                                            </div>

                                            <div id="folio" class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">*Folio Interno de Registro</label>
                                                    <input type="number" name="folio" class="form-control"> 
                                                    <div class="invalid-feedback">
                                                        El folio es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="empresa" class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">*Nombre de la Empresa o Patrón</label>
                                                    <input type="text" name="empresa" id="empresa" class="form-control" oninput="this.value = this.value.toUpperCase()"> 
                                                    <div class="invalid-feedback">
                                                        El nombre es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="primero" class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Primer apellido</label>
                                                    <input type="text" name="primero_empresa" id="primero_empresa" class="form-control soloLetras" oninput="this.value = this.value.toUpperCase()"> 
                                                    <div class="invalid-feedback">
                                                        El campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="segundo" class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Segundo apellido</label>
                                                    <input type="text" name="segundo_empresa" id="segundo_empresa" class="form-control soloLetras" oninput="this.value = this.value.toUpperCase()"> 
                                                    <div class="invalid-feedback">
                                                        El campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div  id="nombre" class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Nombre(s)</label>
                                                    <input type="text" name="nombre_empresa" id="nombre_empresa" class="form-control soloLetras" oninput="this.value = this.value.toUpperCase()"> 
                                                    <div class="invalid-feedback">
                                                        El nombre es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="edad" class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Email</label>
                                                    <input type="email" name="email" id="email" class="form-control correoElectronico"> 
                                                    <div class="invalid-feedback">
                                                        El campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="sexo" class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                <label for="name">Télefono</label>
                                                <input type="text" name="telefono" id="telefono" class="form-control numeroTelefonico" maxlength="10" minlength="10"> 
                                                    <div class="invalid-feedback">
                                                        El campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">CURP (*)</label>
                                                    <input type="text" name="curp" id="curp_input" id="curp_empresa" oninput="validarInput(this, 'resultado_curp_empresa')" class="form-control"> 
                                                    <pre id="resultado_curp_empresa" class="resultado"></pre>
                                                    <div class="invalid-feedback">
                                                        El campo curp es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="ine" class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label>*Identificación oficial (PDF)</label><br>
                                                    <input type="file" name="documentoIne" class="form-control" accept=".pdf">
                                                    <div class="invalid-feedback">
                                                        La Identificación es obligatoria.
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="acta" class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label>Acta constitutiva (Si acude en reprecentación *PDF) </label><br>
                                                    <input type="file" name="documentoPoder" class="form-control" accept=".pdf">
                                                    <div class="invalid-feedback">
                                                        La Identificación es obligatoria.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <h4 class="text-center">Datos del Trabajador</h4>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Primer apellido</label>
                                                    <input type="text" name="primero_trabajador" class="form-control soloLetras" oninput="this.value = this.value.toUpperCase()" required> 
                                                    <div class="invalid-feedback">
                                                        El campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Segundo apellido</label>
                                                    <input type="text" name="segundo_trabajador" class="form-control soloLetras" oninput="this.value = this.value.toUpperCase()" required> 
                                                    <div class="invalid-feedback">
                                                        El campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Nombre(s)</label>
                                                    <input type="text" name="trabajador" class="form-control soloLetras" oninput="this.value = this.value.toUpperCase()" required> 
                                                    <div class="invalid-feedback">
                                                        El nombre es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div  class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Edad</label>
                                                    <input type="number" name="trabajador_edad" class="form-control soloNumeros" required> 
                                                    <div class="invalid-feedback">
                                                        El campo edad es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div   class="col-xs-12 col-sm-12 col-md-3">
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
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">CURP del trabajador (*)</label>
                                                    <input type="text" name="trabajador_curp"  oninput="validarInput(this, 'resultado_curp_trabajador')" class="form-control" required> 
                                                    <pre id="resultado_curp_trabajador" class="resultado"></pre>
                                                    <div class="invalid-feedback">
                                                        El campo curp es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div  class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Documento de la CURP</label>
                                                    <input type="file" name="documentoCurp" class="form-control" accept=".pdf" required> 
                                                    <div class="invalid-feedback">
                                                        El campo edad es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Identificación Oficial</label>
                                                    <select id="tipo_identificacion" name="tipo_identificacion" class="form-control"  required>
                                                        <option value="">Seleccione el tipo de indentificación</option>
                                                        <option value="INE">INE</option>
                                                        <option value="Pasaporte">Pasaporte</option>
                                                        <option value="CédulaProfesional">Cédula Profesional</option>
                                                        <option value="Licencia">Licencia para Conducir</option>
                                                        <option value="Otro">Otros</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        Este campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="espesificar_tipo_identificacion" class="col-xs-12 col-sm-12 col-md-4" style="display:none">
                                                <div class="form-group">
                                                    <label for="name">Especificar</label>
                                                    <input type="text" name="tipo_otros" class="form-control" > 
                                                    <div class="invalid-feedback">
                                                        El campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div  class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Subir Identificación Ofícial</label>
                                                    <input type="file" name="documentoidentificacion" class="form-control" accept=".pdf" required> 
                                                    <div class="invalid-feedback">
                                                        El campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <h4 class="text-center">Datos de la Relación Laboral</h4>
                                                </div>
                                            </div>
                                            
                                            <div  class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">¿Existe procedimiento previo en la junta local de conciliación y arbitraje?</label>
                                                    <select name="JLCA" class="form-control"  required>
                                                        <option value="">Seleccione</option>
                                                        <option value="Si">Si</option>
                                                        <option value="No">No</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xs-12 col-sm-12 col-md-2">
                                                <div class="form-group">
                                                    <label for="fecha_inicio">Fecha de inicio de la relación laboral</label>
                                                    <input type="date" name="fecha_inicio" class="form-control" required> 
                                                    <div class="invalid-feedback">
                                                        El campo edad es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="fecha_termino">Fecha de término de la relación laboral</label>
                                                    <input type="date" name="fecha_termino" class="form-control" > 
                                                    <div class="invalid-feedback">
                                                        El campo edad es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div  class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Categoria o Puesto que desempeña</label>
                                                    <input type="text" name="categoria" class="form-control" > 
                                                    <div class="invalid-feedback">
                                                        El campo edad es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Frecuencia de pago</label>
                                                    <select name="frecuencia" class="form-control"  required>
                                                        <option value="">Seleccione</option>
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
                                                    <label for="name">Salario</label><br>
                                                    <input type="text" name="salario" placeholder="$" class="form-control soloMontos" class="myInput" required> 
                                                    <div class="invalid-feedback">
                                                        Este campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Dias a la semana trabajados</label>
                                                    <input type="number" name="dias" class="form-control soloNumeros" required> 
                                                    <div class="invalid-feedback">
                                                        Este campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Motivo de la conciliación</label>
                                                    <select id="motivo" name="motivo" class="form-control"  required>
                                                        <option value="">Seleccione</option>
                                                        <option value="Pago de prestaciones">Pago de prestaciones</option>
                                                        <option value="Terminación voluntaria de la relación de trabajo">Terminación voluntaria de la relación de trabajo</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="motivo_pago" class="col-xs-12 col-sm-12 col-md-2" style="display:none">
                                                <div class="form-group">
                                                    <label for="name">* Selecciona las casillas correspondientes</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="Aguinaldo">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                        Aguinaldo
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="Vacaciones">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                        Vacaciones
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="PrimaVacacional">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                        Prima Vacacional
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="PagoPTU">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            Pago de PTU
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="Gratificación">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                        Gratificación
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="PrimaAntigüedad">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                        Prima de Antigüedad
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="Otras" id="otras">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                        Otras
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="div_otras" class="col-xs-12 col-sm-12 col-md-3" style="display:none">
                                                <div class="form-group">
                                                    <label for="name">Especifique</label>
                                                    <input type="text" name="Especifique" class="form-control" > 
                                                    <div class="invalid-feedback">
                                                        El campo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Monto total del convenio a pagar</label>
                                                    <input type="text" name="monto" class="form-control soloMontos" required> 
                                                    <div class="invalid-feedback">
                                                        El campo edad es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <div class="col-xs-12 col-sm-6 col-md-2">
                                                <div class="form-group">
                                                    <label for="name"><br>
                                                    <center><a href="https://cclmichoacan.gob.mx/Calculadora.html" target="_blank">* Calcula el monto aproximado del convenio.</a></center>
                                                    </label>
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
                                                        <option value="Cheque Electronio">Cheque Electronio</option>
                                                        <option value="Orden de Pago">Orden de Pago</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El campo edad es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Sube tu cuantificación(Opcional)</label>
                                                    <input type="file" name="cuantificacion" class="form-control" accept=".pdf"> 
                                                    <div class="invalid-feedback">
                                                        El campo edad es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <h4 class="text-center">Seleccionar la fecha</h4>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Sedes</label>
                                                    <select id="sede" name="sede" class="form-control" onchange="sedes();" required>
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
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Día</label>
                                                    <input id="fecha" type="date" name="fecha" class="form-control" onchange="diaSemana();" disabled>
                                                    <div class="invalid-feedback">
                                                        El campo conflicto es obligatorio.
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
    
    <script src="public/assets/js/validaciones-ratificacion.js"></script> 
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
        document.getElementById("empresa").style.display = "block";
        document.getElementById("primero").style.display = "block";
        document.getElementById("segundo").style.display = "block";
        document.getElementById("nombre").style.display = "block";
        document.getElementById("edad").style.display = "block";
        document.getElementById("sexo").style.display = "block";
        document.getElementById("ine").style.display = "block";
        document.getElementById("acta").style.display = "block";


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
                document.getElementById("primero").style.display = "none";
                document.getElementById("segundo").style.display = "none";
                document.getElementById("nombre").style.display = "none";
                document.getElementById("edad").style.display = "none";
                document.getElementById("sexo").style.display = "none";
                document.getElementById("ine").style.display = "none";
                document.getElementById("acta").style.display = "none";
                

                
                document.getElementById("primero_empresa").removeAttribute("required");
                document.getElementById("segundo_empresa").removeAttribute("required");
                document.getElementById("nombre_empresa").removeAttribute("required");
                document.getElementById("email").removeAttribute("required");
                document.getElementById("telefono").removeAttribute("required");
                document.getElementById("curp_empresa").removeAttribute("required");

                //document.getElementById("folio").setAttribute('required', ''); // Agrega el atributo 'required'
            }
            else{
                document.getElementById("folio").style.display = "none";
                document.getElementById("empresa").style.display = "block";
                document.getElementById("primero").style.display = "block";
                document.getElementById("segundo").style.display = "block";
                document.getElementById("nombre").style.display = "block";
                document.getElementById("edad").style.display = "block";
                document.getElementById("sexo").style.display = "block";
                document.getElementById("ine").style.display = "block";
                document.getElementById("acta").style.display = "block";
               

                
                document.getElementById("primero_empresa").setAttribute("required", "");
                document.getElementById("segundo_empresa").setAttribute("required", "");
                document.getElementById("nombre_empresa").setAttribute("required", "");
                document.getElementById("email").setAttribute("required", "");
                document.getElementById("telefono").setAttribute("required", "");
                document.getElementById("curp_empresa").setAttribute("required", "");
                
            }
        }

        const tipo_iden = document.getElementById('tipo_identificacion');
        tipo_iden.addEventListener('change', function() {
            const valorSeleccionado = this.value;
            // Realiza la validación o acciones necesarias
            if (valorSeleccionado === 'Otro') {
                document.getElementById('espesificar_tipo_identificacion').style.display = "block";
            } else {
                document.getElementById('espesificar_tipo_identificacion').style.display = "none";
            }
        });

        const motivo = document.getElementById('motivo');
        motivo.addEventListener('change', function() {
            const valorSeleccionado = this.value;
            // Realiza la validación o acciones necesarias
            if (valorSeleccionado === 'Pago de prestaciones') {
                document.getElementById('motivo_pago').style.display = "block";
            } else {
                document.getElementById('motivo_pago').style.display = "none";
            }
        });        
        
        const otras = document.getElementById('otras');
        otras.addEventListener('click', function() {
            const valorSeleccionado = this.value;
                document.getElementById('div_otras').style.display = "block";
        });
        

        //Fechas inicio y fin
        document.addEventListener("DOMContentLoaded", function () {
            const inicio = document.querySelector('input[name="fecha_inicio"]');
            const termino = document.querySelector('input[name="fecha_termino"]');

            // Función para obtener hoy en formato 'YYYY-MM-DD'
            function obtenerFechaHoyFormato() {
                const hoy = new Date();
                const año = hoy.getFullYear();
                const mes = String(hoy.getMonth() + 1).padStart(2, '0');
                const dia = String(hoy.getDate()).padStart(2, '0');
                return `${año}-${mes}-${dia}`;
            }

            function validarFechas() {
                const fechaHoyStr = obtenerFechaHoyFormato();

                // Validar que fecha inicio no sea la fecha de hoy
                if (inicio.value === fechaHoyStr) {
                    alert("La fecha de inicio no puede ser la fecha actual.");
                    inicio.value = "";
                    return;
                }

                // Validar que fecha inicio no sea mayor a hoy
                if (inicio.value && new Date(inicio.value) > new Date(fechaHoyStr)) {
                    alert("La fecha de inicio no puede ser mayor a la fecha actual.");
                    inicio.value = "";
                    return;
                }

                if (termino.value && new Date(termino.value) > new Date(fechaHoyStr)) {
                    alert("La fecha de término no puede ser mayor a la fecha actual.");
                    termino.value = "";
                    return;
                }

                // Validar que fecha inicio no sea mayor que fecha término
                if (inicio.value && termino.value && new Date(inicio.value) > new Date(termino.value)) {
                    alert("La fecha de inicio no puede ser mayor que la fecha de término.");
                    termino.value = "";
                    return;
                }
            }
            inicio.addEventListener("change", validarFechas);
            termino.addEventListener("change", validarFechas);
        });
    </script>

    <div id="crear_poder" style ="display: none;">
        <div>.</div>
        <div class="loader"></div>
    </div>
