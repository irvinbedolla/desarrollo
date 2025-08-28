<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Si concilio</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 4.1.1 -->
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
    <link rel="stylesheet" href="public/assets/css/components.css">
    @yield('page_css')
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top" style="background-color:#f8f9fa;">
    <div class="">
        <img src="public/assets/images/Logos 2.png" class="img" width="260" height="90">
    </div> 
</nav>
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
                                <div style="background-color:#D2D3D5">
                                    <h3 class="text-center" style="color:black">Registro de Representación Legal Patronal</h3>
                                </div>    
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <h4 class="text-center" style="color:#CEA845">Datos del representante legal</h4>
                                    </div>
                                </div>
                                <!--Se realiza el envío de datos con formulario de Laravel Collective-->
                                <form class="needs-validation novalidate" method="POST" action="{{route('poderes.publico')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <label for="name">Tipo de persona <span style="color:red;">(*)</span></label>
                                                <select name="tipo" id="tipo" class="form-control">
                                                    <option value="">Seleccione</option>
                                                    <option value="FisicaR">Física, cuento con representante legal</option>
                                                    <option value="FisicaD">Física, derecho propio</option>
                                                    <option value="Moral">Moral</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    El tipo de persona es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12" id="tipoPersona_razon" style="display:none;">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-10">
                                                    <div class="form-group">
                                                        <label for="name">Razón social <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="razon" id="razon" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            La razón social es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Teléfono</label>
                                                        <input type="text" class="form-control" placeholder="*Telefono"  name="telefono_moral" maxlength="10" pattern="[0-9]+" >
                                                        <div class="invalid-feedback">
                                                            El telefono es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Correo</label>
                                                        <input type="email" class="form-control" placeholder="*Correo" name="correo_moral" id="correoAbogadoAlta" >
                                                        <div class="invalid-feedback">
                                                            El correo es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">CURP</label>
                                                        <input type="text" class="form-control" placeholder="*CURP" aria-label="CURP" name="curp_moral" minlength="18" maxlength="18" oninput="this.value = this.value.toUpperCase()" >
                                                        <div class="invalid-feedback">
                                                            La CURP es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  

                                        <div class="col-xs-12 col-sm-12 col-md-12" id="tipoPersona_nombre" style="display:none;">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Nombre(s) <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="nombresAbogadoAlta" id="nombre" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El nombre es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                        
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Primer apellido <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="primer_apellido" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El primer apellido es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Segundo apellido <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="segundo_apellido" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El segundo apellido es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>  
                                                
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Teléfono</label>
                                                        <input type="text" class="form-control" placeholder="*Telefono"  name="telefonoAbogadoAlta" maxlength="10" pattern="[0-9]+" >
                                                        <div class="invalid-feedback">
                                                            El telefono es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Correo</label>
                                                        <input type="email" class="form-control" placeholder="*Correo" name="correoAbogadoAlta" id="correoAbogadoAlta" >
                                                        <div class="invalid-feedback">
                                                            El correo es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">CURP</label>
                                                        <input type="text" class="form-control" placeholder="*CURP" aria-label="CURP" name="curpAbogadoAlta" minlength="18" maxlength="18" oninput="this.value = this.value.toUpperCase()" >
                                                        <div class="invalid-feedback">
                                                            La CURP es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  

                                        <div class="col-xs-12 col-sm-12 col-md-12" id="tipoPersona_propio" style="display:none;">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">Nombre(s) <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="nombre_derecho" id="nombre" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El nombre es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                    
                                                <div class="col-xs-12 col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">Primer apellido <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="primero_derecho" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El primer apellido es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">Segundo apellido <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="segundo_derecho" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El segundo apellido es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Teléfono</label>
                                                        <input type="text" class="form-control" placeholder="*Telefono"  name="telefono_derecho" maxlength="10" pattern="[0-9]+" >
                                                        <div class="invalid-feedback">
                                                            El telefono es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Correo</label>
                                                        <input type="email" class="form-control" placeholder="*Correo" name="correo_derecho" id="correoAbogadoAlta" >
                                                        <div class="invalid-feedback">
                                                            El correo es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">CURP</label>
                                                        <input type="text" class="form-control" placeholder="*CURP" aria-label="CURP" name="curp_derecha" minlength="18" maxlength="18" oninput="this.value = this.value.toUpperCase()" >
                                                        <div class="invalid-feedback">
                                                            La CURP es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Giro Comercial <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="giro_derecho" id="nombre" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El nombre es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Vialidad (calle,avenida,etc.) <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="vialidad_derecho" id="nombre" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El nombre es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Colonia <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="colonia_derecho" id="nombre" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El nombre es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">Num Int <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="num_int_derecho" id="nombre" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El nombre es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">Nun Ext</span></label>
                                                        <input type="text" name="num_ext_derecho" id="nombre" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El nombre es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">C.P. <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="cp_derecho" id="nombre" class="form-control" minlength="5" maxlength="5" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El nombre es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h4 class="text-center" style="color:#CEA845">Datos de la fuente laboral</h4>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">RFC <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="RFC_derecho" id="nombre" class="form-control" minlength="13" maxlength="13" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El nombre es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-8">
                                                    <div class="form-group">
                                                        <label for="">Giro Comercial</label>
                                                        <input type="text" class="form-control" placeholder="Giro Comercial" name="industriaAlta" >
                                                        <div class="invalid-feedback">
                                                            La industria es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>

                                        

                                        <div class="col-xs-12 col-sm-12 col-md-12" id="datos_empresa" style="display:none;">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h4 class="text-center" style="color:#CEA845">Datos de la fuente laboral</h4>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Empresa</label>
                                                        <input type="text" class="form-control" placeholder="*Empresa representación" name="empresaAbogadoAlta" oninput="this.value = this.value.toUpperCase()" >
                                                        <div class="invalid-feedback">
                                                            La empresa es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">RFC</label>
                                                        <input type="text" class="form-control" placeholder="RFC Empresa" name="RFCAbogadoAlta" minlength="13" maxlength="13" oninput="this.value = this.value.toUpperCase()">
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Entidad Federativa</label>
                                                        <select id="estado_poder" class="form-control" name="estado_poder" placeholder="*Entidad Federativa" >
                                                            <option value="">Seleccione</option>
                                                            @foreach($estados as $est)
                                                                <option value="{{$est['id']}}">{{$est['nombre']}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            El campo Estado es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="name">Nombre del Municipio o Alcaldía (*)</label>
                                                        <select id="municipio_poder" class="form-control" name="municipio_poder" placeholder="*Municipio" >
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

                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="name">Tipo de Vialidad (*)</label>
                                                        <select name="vialidadPoder" id="vialidadPoder" class="form-control" placeholder="*Vialidad" >
                                                            <option value="">SELECCIONE</option>
                                                            <option value="AMPLIACIÓN">Ampliación</option>
                                                            <option value="ANDADOR">Andador</option>
                                                            <option value="AUTOPISTA">Autopista</option>
                                                            <option value="AVENIDA">Avenida</option>
                                                            <option value="BOULEVARD">Boulevard</option>
                                                            <option value="CALLE">Calle</option>
                                                            <option value="CALLEJÓN">Callejón</option>
                                                            <option value="CALZADA">Calzada</option>
                                                            <option value="CARRETERA">Carretera</option>
                                                            <option value="CERRADA">Cerrada</option>
                                                            <option value="CIRCUITO">Circuito</option>
                                                            <option value="CIRCUNVALACIÓN">Circunvalación</option>
                                                            <option value="CONTINUACIÓN">Continuación</option>
                                                            <option value="CORREDOR">Corredor</option>
                                                            <option value="DIAGONAL">Diagonal</option>
                                                            <option value="EJE VIAL">Eje vial</option>
                                                            <option value="PERIFÉRICO">Periférico</option>
                                                            <option value="PROLONGACIÓN">Prolongación</option>
                                                            <option value="RETORNO">Retorno</option>
                                                            <option value="VIADUCTO">Viaducto</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            El campo vialidad es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="name">Nombre de la Vialidad (*)</label>
                                                        <input type="text" name="vialidad_callePoder" id="vialidad_callePoder" class="form-control" placeholder="*Nombre vialidad" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El campo vialidad o calle es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Colonia</label>
                                                        <input type="text" class="form-control" placeholder="*Colonia" name="coloniaAbogadoAlta" id="coloniaAbogadoAlta" oninput="this.value = this.value.toUpperCase()" >
                                                        <div class="invalid-feedback">
                                                            El domicilio es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Núm. Ext.</label>
                                                        <input type="text" class="form-control" placeholder="*Número exterior" name="NExtAbogadoAlta" id="NExtAbogadoAlta" oninput="this.value = this.value.toUpperCase()" >
                                                        <div class="invalid-feedback">
                                                            El domicilio es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
            
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Núm. Int.</label>
                                                        <input type="text" class="form-control" placeholder="Número interior" name="NIntAbogadoAlta" id="NIntAbogadoAlta" oninput="this.value = this.value.toUpperCase()">
                                                        <div class="invalid-feedback">
                                                            El domicilio es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
            
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Código postal</label>
                                                        <input type="text" class="form-control" placeholder="*Código postal" name="cpAbogadoAlta" id="cpAbogadoAlta" oninput="this.value = this.value.toUpperCase()" >
                                                        <div class="invalid-feedback">
                                                            El domicilio es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Fecha vigencia</label>
                                                        <input type="date" class="form-control" aria-describedby="basic-addon1" name="fechaVigenciaAlta" id="fechaVigenciaAlta" min="<?= date("Y-m-d") ?>" >
                                                        <div class="invalid-feedback">
                                                            La fecha es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Giro Comercial</label>
                                                        <input type="text" class="form-control" placeholder="Giro Comercial" name="industriaAlta" >
                                                        <div class="invalid-feedback">
                                                            La industria es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <span class="" id="basic-addon1">*Seleccione la región(nes).</i></i></span>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="moreliaSucursal" value="Si">
                                                            <label class="form-check-label" for="flexCheckDefault">Morelia</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="uruapanSucursal" value="Si" >
                                                            <label class="form-check-label" for="flexCheckChecked">Uruapan</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="zamoraSucursal" value="Si">
                                                            <label class="form-check-label" for="flexCheckDefault">Zamora</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Descripción del poder</label>
                                                        <textarea class="form-control" aria-describedby="basic-addon1" name="descripcionpoderAlta" ></textarea>
                                                        <div class="invalid-feedback">
                                                            La descripción es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <h4 class="text-center" style="color:#CEA845">Documentos</h4>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>*Identificación oficial del representante</label><br>
                                                <input type="file" name="documentoIne" class="form-control" accept=".pdf" required>
                                                <div class="invalid-feedback">
                                                    La Identificación es obligatoria.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>*Identificación oficial del representado</label><br>
                                                <input type="file" name="documentoRepresentacion" class="form-control" accept=".pdf" required>
                                                <div class="invalid-feedback">
                                                    El documento de representación es obligatorio.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>Anexos (Opcional)</label><br>
                                                <input type="file" name="documentoAnexo" class="form-control" accept=".pdf">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>Anexos 2 (Opcional)</label><br>
                                                <input type="file" name="documentoPoder" class="form-control" accept=".pdf">
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div align="center">
                                            <button type="submit" class="btn btn-primary" style="background-color:#CEA845; border-color:#CEA845;">Guardar</button>
                                            <a href="{{ route('publico'); }}" class="btn btn-primary" style=" background-color:#CEA845; border-color:#CEA845;">Regresar</a>    
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

    <!-- Template JS File -->
    <script src="public/assets/js/stisla.js"></script>
    <script src="public/assets/js/scripts.js"></script>
    <script src="public/assets/js/profile.js"></script>
    <script src="public/assets/js/custom.js"></script>

    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap4.js"></script>
    @yield('page_js')


    @yield('scripts')


<div id="crear_poder" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>

    <script>
        document.getElementById('tipo').addEventListener('change', function() {
            
            const selectTipo = document.getElementById('tipo');
            const nombreDiv = document.getElementById('tipoPersona_nombre');
            const razonDiv = document.getElementById('tipoPersona_razon');
            const propioDiv = document.getElementById('tipoPersona_propio')
            const empresaDiv = document.getElementById('datos_empresa')
            

            function actualizarTipoPersona() {
                const valor = selectTipo.value;

                // Oculta ambos inicialmente
                nombreDiv.style.display = 'none';
                razonDiv.style.display = 'none';
                propioDiv.style.display = 'none';
                empresaDiv.style.display = 'none';

                if (valor === 'FisicaR') {
                    nombreDiv.style.display = 'block';
                    empresaDiv.style.display = 'block';
                } else if (valor === 'FisicaD') {
                    propioDiv.style.display = 'block';
                } else if (valor === 'Moral') {
                    razonDiv.style.display = 'block';
                    empresaDiv.style.display = 'block';
                }
            }

            if (selectTipo) {
                selectTipo.addEventListener('change', actualizarTipoPersona);
                // Ejecutar al cargar por si ya tiene valor
                actualizarTipoPersona();
            }
        });
    </script>

@section('scripts')
    <script src="public/js/poderes/general.js"></script>
@endsection
