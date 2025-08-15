<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title></title>
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
           /* background-color: #6A0F49;/<p style="color: #CEA845 */
            opacity: .8;
        }
        #resultado {
            background-color: red;
            color: white;
            font-weight: bold;
        }
        #resultado.ok {
            background-color: green;
        }
    </style>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="">
            <img src="public/assets/images/Logos 2.png" class="img" style="" width="250" height="90"></a>&nbsp;&nbsp;
        </div> 
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent" >
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('publico') }}" style="color: black;">INICIO<span class="sr-only"></span></a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <br><br><br><br>
    </div>
</head>

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
                                        <h3 class="text-center" style="color:black">Datos del Solicitante</h3>
                                    </div>    
                                    <!--Se realiza el envío de datos con formulario de Laravel Collective-->
                                    <form class="needs-validation" novalidate method="POST" action="{{route('parte2')}}" enctype='multipart/form-data'>
                                        @csrf
                                        <input type="hidden" name="id" value="{{$id}}">
                                        <div class="row">
                                            <!--<div class="col-xs-12 col-sm-12 col-md-4">
                                                <label for="name">Tipo de Persona (*)</label>
                                                <select name="tipo" class="form-control" required>
                                                    <option value="">SELECCIONE</option>
                                                    <option value="Fisica">FÍSICA</option>
                                                    <option value="Moral">MORAL</option>
                                                </select>
                                            </div>-->
                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                <div class="form-group">
                                                    <label for="name">Nombre(s) y Apellidos del Solicitante <span style="color:red;">(*)</span></label>
                                                    <input type="text" name="nombre" class="form-control" oninput="this.value = this.value.toUpperCase()" required> 
                                                    <div class="invalid-feedback">
                                                        El campo nombre es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">CURP/No. de Migración <span style="color:red;">(*)</span></label>
                                                    <input type="text" name="curp" id="curp_input" oninput="validarInput(this)"class="form-control" required> 
                                                    <pre id="resultado"></pre>
                                                    <div class="invalid-feedback">
                                                        El campo curp es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="div1" class="col-xs-12 col-sm-12 col-md-2">
                                                <div class="form-group">
                                                    <label for="name">Fecha de Nacimiento <span style="color:red;">(*)</span></label>
                                                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" onchange="validarfechaNacimiento(this)" class="form-control" required> 
                                                    <div class="invalid-feedback">
                                                        El campo fecha de nacimiento es obligatoria.
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="div1" class="col-xs-12 col-sm-12 col-md-1">
                                                <div class="form-group">
                                                    <label for="name">Edad<span style="color:red;">(*)</span></label>
                                                    <input type="number" name="edad" class="form-control" id="años_edad" required> 
                                                    <div class="invalid-feedback">
                                                        El campo edad es obligatoria.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2">
                                                <div class="form-group">
                                                    <label for="name">RFC del Solicitante (Campo opcional)</label>
                                                    <input type="text" name="rfc" class="form-control" minlength="13" maxlength="13" oninput="this.value = this.value.toUpperCase()"> 
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2">
                                                <div class="form-group">
                                                    <label for="name">Sexo <span style="color:red;">(*)</span></label>
                                                    <select name="genero" class="form-control" required>
                                                        <option value="">SELECCIONE</option>
                                                        <option value="H">HOMBRE</option>
                                                        <option value="M">MUJER</option>
                                                        <option value="NC">PREFIERO NO CONTESTAR</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El campo sexo es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2">
                                                <div class="form-group">
                                                    <label for="name">Nacionalidad <span style="color:red;">(*)</span></label>
                                                    <select name="nacionalidad" class="form-control" required>
                                                        <option value="">SELECCIONE</option>
                                                        <option value="Mexicana">MEXICANA</option>
                                                        <option value="Otra">OTRA</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El campo nacionalidad es obligatoria.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Entidad Federativa de Nacimiento <span style="color:red;">(*)</span></label>
                                                    <select id="estado_nacimiento" name="estado_nacimiento" class="form-control" required>
                                                        <option value="">Seleccione</option>
                                                        @foreach($estados as $est)
                                                            <option value="{{$est['id']}}">{{$est['nombre']}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El campo entidad federativa de nacimiento es obligatoria.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-6 col-sm-12 col-md-3"><br>
                                                <spam for="btncheck1">¿Requiere traductor?</spam>
                                                <input type="checkbox" class="btn-check" id="check_lenguaje" name="traductor" autocomplete="off">
                                            </div>
                                            <div class="col-xs-6 col-sm-12 col-md-6" id="lenguaje_señas">
                                                <div class="form-group">
                                                    <label for="name">¿Qué tipo de lenguaje require?</label>
                                                    <input type="text" name="lenguaje" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                                </div>
                                            </div> 
                                            <div class="col-xs-6 col-sm-12 col-md-3"><br>
                                                <spam for="btncheck1">¿Tiene alguna discapacidad?</spam>
                                                <input type="checkbox" class="btn-check" id="check_discapacidad" name="discapacidad" autocomplete="off">
                                            </div>   
                                            <div class="col-xs-6 col-sm-12 col-md-6" id="discapacidad">
                                                <div class="form-group">
                                                    <label for="name">¿Cuál es su discapacidad?</label>
                                                    <input type="text" name="tipo_discapacidad" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                                </div>
                                            </div> 
                                            <div class="col-xs-12 col-sm-12 col-md-12" style="background-color:#D2D3D5; width:100%; height:40px;">
                                                <h3 class="text-center" style="color:black">Contacto</h3>
                                            </div>  
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Teléfono Celular <span style="color:red;">(*)</span></label>
                                                    <input type="text" name="telefono1" minlength="10" maxlength="10" class="form-control numeroTelefonico" required> 
                                                    <div class="invalid-feedback">
                                                        El campo teléfono es obligatorio.
                                                    </div>
                                                </div>   
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Teléfono Fijo (Campo opcional)</label>
                                                    <input type="text" name="telefono2" minlength="10" maxlength="10" class="form-control numeroTelefonico"> 
                                                </div>   
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Correo Electrónico <span style="color:red;">(*)</span></label>
                                                    <input type="mail" name="correo" class="form-control correoElectronico" required> 
                                                    <div class="invalid-feedback">
                                                        El campo correo electrónico es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12" style="background-color:#D2D3D5; width:100%; height:40px;">
                                                <h3 class="text-center" style="color:black">Domicilio</h3>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-2">
                                                <div class="form-group">
                                                    <label for="password">Entidad Federativa del Solicitante <span style="color:red;">(*)</span></label>
                                                    <select id="estado_solicitante" class="form-control" name="estado_solicitante" required>
                                                        <option value="">Seleccione</option>
                                                        @foreach($estados as $est)
                                                            <option value="{{$est['id']}}">{{$est['nombre']}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El campo entidad federativa es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2">
                                                <div class="form-group">
                                                    <label for="name">Tipo de Vialidad <span style="color:red;">(*)</span></label>
                                                    <select name="vialidad" class="form-control" required>
                                                        <option value="">SELECCIONE</option>
                                                        <option value="Calle">CALLE</option>
                                                        <option value="Avenida">AVENIDA</option>
                                                        <option value="Calzada">CALZADA</option>
                                                        <option value="Boulevard">BOULEVARD</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El campo vialidad es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2">
                                                <div class="form-group">
                                                    <label for="name">Nombre de la Vialidad <span style="color:red;">(*)</span></label>
                                                    <input type="text" name="vialidad_calle" class="form-control" oninput="this.value = this.value.toUpperCase()" required> 
                                                    <div class="invalid-feedback">
                                                        El campo vialidad o calle es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2">
                                                <div class="form-group">
                                                    <label for="name">Número Exterior <span style="color:red;">(*)</span></label>
                                                    <input type="number" name="numExt" class="form-control" required> 
                                                    <div class="invalid-feedback">
                                                        El campo número exterior es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2">
                                                <div class="form-group">
                                                    <label for="name">Número Interior (Campo opcional)</label>
                                                    <input type="text" name="numInt" class="form-control" oninput="this.value = this.value.toUpperCase()"> 
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2">
                                                <div class="form-group">
                                                    <label for="name">Colonia <span style="color:red;">(*)</span></label>
                                                    <input type="text" name="colonia_solicitante" class="form-control" oninput="this.value = this.value.toUpperCase()" required> 
                                                    <div class="invalid-feedback">
                                                        El campo colonia es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Nombre del Municipio o Alcaldía <span style="color:red;">(*)</span></label>
                                                    <select id="municipio_solicitante" class="form-control" name="municipio_solicitante" required>
                                                        <option value="">Seleccione</option>
                                                        @foreach($municipios as $mun)
                                                            <option value="{{$mun['id']}}">{{$mun['nombre']}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El campo municipio o alcaldía es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="div1"  class="col-xs-12 col-sm-12 col-md-1">
                                                <div class="form-group">
                                                    <label for="name">Código Postal <span style="color:red;">(*)</span></label>
                                                    <input type="text" name="cp" class="form-control soloNumeros" minlength="5" maxlength="5" required> 
                                                    <div class="invalid-feedback">
                                                        El campo código postal es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Entre calle <span style="color:red;">(*)</span></label>
                                                    <input type="text" name="calle1" class="form-control" oninput="this.value = this.value.toUpperCase()" required> 
                                                    <div class="invalid-feedback">
                                                        El campo entre calle es obligatoria.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">y calle <span style="color:red;">(*)</span></label>
                                                    <input type="text" name="calle2" class="form-control" oninput="this.value = this.value.toUpperCase()" required> 
                                                    <div class="invalid-feedback">
                                                        El campo calle es obligatoria.
                                                    </div>                                    
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Referencias <span style="color:red;">(*)</span></label>
                                                    <textarea class="form-control" placeholder="Ingresa alguna referencia de como llegar" name="referencias" required></textarea>
                                                    <div class="invalid-feedback">
                                                        El campo referencia es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12" style="background-color:#D2D3D5; width:100%; height:40px;">
                                                <h3 class="text-center" style="color:black">Datos laborales</h3>
                                            </div>  
                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Número de Seguro Social (Campo opcional)</label>
                                                    <input type="text" name="seguro" minlength="11" maxlength="12" class="form-control soloNumeros"> 
                                                    <div class="invalid-feedback">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2">
                                                <div class="form-group">
                                                    <label for="name">Puesto <span style="color:red;">(*)</span></label>
                                                    <input type="text" name="puesto" class="form-control" oninput="this.value = this.value.toUpperCase()" required> 
                                                    <div class="invalid-feedback">
                                                        El campo puesto es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2">
                                                <div class="form-group">
                                                    <label for="name">Salario</label>
                                                    <select name="periodo_pago" class="form-control">
                                                        <!--<option value="">SELECCIONE</option>-->
                                                        <option value="Diario">DIARIO</option>
                                                        <!--<option value="Semana">SEMANAL</option>
                                                        <option value="Quincenal">QUINCENAL</option>
                                                        <option value="Mensual">MENSUAL</option>-->
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El campo frecuencia de pago es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-1">
                                                <div class="form-group">
                                                    <label for="name">Salario diario <span style="color:red;">(*)</span></label>
                                                    <input type="text" name="pago" class="form-control soloMontos" required> 
                                                    <div class="invalid-feedback">
                                                        El campo salario es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2">
                                                <div class="form-group">
                                                    <label for="name">Total de horas trabajadas por semana <span style="color:red;">(*)</span></label>
                                                    <input type="number" name="horas" class="form-control" required> 
                                                    <div class="invalid-feedback">
                                                        El campo cantidad de horas trabajadas es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-1">
                                                <div class="form-group">
                                                    <label for="btncheck1">¿Laboras actualmente?</label><br>
                                                    <input name="labora" type="checkbox" class="btn-check" id="check_fecha" autocomplete="off"/>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2"> 
                                                <div class="form-group">
                                                    <label for="name">Fecha de Ingreso <span style="color:red;">(*)</span></label>
                                                    <input type="date" name="fecha_ingreso" class="form-control" required> 
                                                    <div class="invalid-feedback">
                                                        El campo fecha de ingreso es obligatoria.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2">
                                                <div class="form-group">
                                                    <label for="name">Jornada <span style="color:red;">(*)</span></label>
                                                    <select name="jornada" class="form-control" required>
                                                        <option value="">SELECCIONE</option>
                                                        <option value="Diurna">DIURNA</option>
                                                        <option value="Nocturna">NOCTURNA</option>
                                                        <option value="Mixta">MIXTA</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El campo jornada laboral es obligatoria.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-2" id="fecha_fin">
                                                <div class="form-group">
                                                    <label for="name">Fecha de Salida</label>
                                                    <input type="date" name="fecha_salida" class="form-control"> 
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12" style="background-color:#D2D3D5; width:100%; height:40px;">
                                                <h3 class="text-center" style="color:black">Documentos</h3>
                                            </div>
                                            
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label>CURP/No. de Migración <span style="color:red;">(*)</span></label>
                                                    <input type="file" name="documentoCurp" class="form-control" accept=".pdf" required>
                                                    <div class="invalid-feedback">
                                                        El campo curp es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <h4 class="text-center">En caso de ser mayor de edad subir su identificación y en caso de ser menor su identificación es su Acta de Nacimiento</h4>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="name">Tipo de identificación <span style="color:red;">(*)</span></label>
                                                    <select name="identificacion" class="form-control" required>
                                                        <option value="">SELECCIONE</option>
                                                        <option value="ine">INE</option>
                                                        <option value="pasaporte">PASAPORTE</option>
                                                        <option value="cedula">CÉDULA PROFESIONAL</option>
                                                        <option value="licencia">LICENCIA PARA CONDUCIR</option>
                                                        <option value="otros">OTROS</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El tipo de identificaión es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <div class="form-group">
                                                    <label>Identificación oficial <span style="color:red;">(*)</span></label>
                                                    <input type="file" name="documentoIdentificacion" class="form-control" accept=".pdf" required>
                                                    <div class="invalid-feedback">
                                                        La Identificación es obligatoria.
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <h4 class="text-center">En caso de ser menor de edad Acta de nacimiento</h4>
                                                </div>
                                            </div>
                                            <div id="documentacionMenor" class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label>Acta de nacimiento</label>
                                                    <input type="file" name="documentoActa" class="form-control" accept=".pdf">
                                                    <div class="invalid-feedback">
                                                        La Identificación es obligatoria.
                                                    </div>
                                                </div>
                                            </div>-->
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div align="center">
                                                <button type="submit" class="btn btn-primary" style="background-color:#CEA845; border-color:#CEA845;">Guardar</button>   
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
    <script src="public/assets/js/moment.js"></script>

    <!-- Template JS File -->
    <script src="public/assets/js/stisla.js"></script>
    <script src="public/assets/js/scripts.js"></script>
    <script src="public/assets/js/profile.js"></script>
    <script src="public/assets/js/custom.js"></script>

    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap4.js"></script>
    @yield('page_js')


    @yield('scripts')
    <script src="./public/assets/js/validaciones.js"></script> 
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
        //Fechas inicio y fin
        document.addEventListener("DOMContentLoaded", function () {
            const inicio = document.querySelector('input[name="fecha_ingreso"]');
            const termino = document.querySelector('input[name="fecha_salida"]');

            // Función para obtener hoy en formato 'YYYY-MM-DD'
            function obtenerFechaHoyFormato() {
                const hoy = new Date();
                const año = hoy.getFullYear();
                const mes = String(hoy.getMonth() + 1).padStart(2, '0');
                const dia = String(hoy.getDate()).padStart(2, '0');
                return `${año}-${mes}-${dia}`;
            }
            function esFechaValida(fechaStr) {
                return /^\d{4}-\d{2}-\d{2}$/.test(fechaStr) && !isNaN(new Date(fechaStr).getTime());
            }
            function validarFechas() {
                const fechaHoyStr = obtenerFechaHoyFormato();
                const fechaHoy = new Date(fechaHoyStr);
                const fechaInicioStr = inicio.value;
                const fechaTerminoStr = termino.value;

                if (!esFechaValida(fechaInicioStr) && fechaInicioStr !== "") return;
                if (!esFechaValida(fechaTerminoStr) && fechaTerminoStr !== "") return;

                const fechaInicio = new Date(fechaInicioStr);
                const fechaTermino = new Date(fechaTerminoStr);
                // Validar que fecha inicio no sea la fecha de hoy
                if (fechaInicioStr === fechaHoyStr) {
                    alert("La fecha de ingreso no puede ser la fecha actual.");
                    inicio.value = "";
                    return;
                }

                if (fechaInicio > fechaHoy) {
                    alert("La fecha de ingreso no puede ser mayor a la fecha actual.");
                    inicio.value = "";
                    return;
                }

                if (fechaTerminoStr && fechaTermino > fechaHoy) {
                    alert("La fecha de término no puede ser mayor a la fecha actual.");
                    termino.value = "";
                    return;
                }

                if (fechaInicioStr && fechaTerminoStr && fechaInicio > fechaTermino) {
                    alert("La fecha de ingreso no puede ser mayor que la fecha de término.");
                    termino.value = "";
                    return;
                }
            }

            inicio.addEventListener("blur", validarFechas);
            termino.addEventListener("blur", validarFechas);
        });
    </script>