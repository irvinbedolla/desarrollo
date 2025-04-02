<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Sí Conciliación</title>
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
    <link rel="stylesheet" href="public/assets/css/style.css">
    <link rel="stylesheet" href="public/assets/css/components.css">
    @yield('page_css')
</head>

    <div id="app">  
        <section class="section">
            <div class="col-lg-12" >
                <div style="background-color:#6A0F49">
                    <div align="right"><br>
                        <img src="public/assets/images/ccl-r.png" style="max-width: 10%" class="text-center">
                    </div>
                    <h3 class="text-center" style="color:#CEA845">Registro de representaciones legales</h3>    
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
                                    <h3 class="text-center" style="color:#CEA845">Datos del representante legal</h3>
                                </div>    
                                <!--Se realiza el envío de datos con formulario de Laravel Collective-->
                                <form class="needs-validation novalidate" method="POST" action="{{route('poderes.publico')}}" enctype="multipart/form-data">
                                @csrf
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="name">Nombres</label>
                                                <input type="text" class="form-control" placeholder="*Nombre(s)" name="nombresAbogadoAlta" oninput="this.value = this.value.toUpperCase()" required>
                                                <div class="invalid-feedback">
                                                    El nombre es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Primer Apellido</label>
                                                <input type="text" class="form-control" placeholder="*Apellidos" name="primer_apellido" id="apellidosAbogadoAlta" oninput="this.value = this.value.toUpperCase()" required>
                                                <div class="invalid-feedback">
                                                    El primer apellido es obligatorio.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Segundo Apellido</label>
                                                <input type="text" class="form-control" placeholder="*Apellidos" name="segundo_apellido" oninput="this.value = this.value.toUpperCase()" required>
                                                <div class="invalid-feedback">
                                                    El segundo apellido es obligatorio.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Teléfono</label>
                                                <input type="text" class="form-control" placeholder="*Telefono"  name="telefonoAbogadoAlta" maxlength="10" pattern="[0-9]+" required>
                                                <div class="invalid-feedback">
                                                    El telefono es obligatorio.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Correo</label>
                                                <input type="email" class="form-control" placeholder="*Correo" name="correoAbogadoAlta" id="correoAbogadoAlta" required>
                                                <div class="invalid-feedback">
                                                    El correo es obligatorio.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">CURP</label>
                                                <input type="text" class="form-control" placeholder="*CURP" aria-label="CURP" name="curpAbogadoAlta" minlength="18" maxlength="18" oninput="this.value = this.value.toUpperCase()" required>
                                                <div class="invalid-feedback">
                                                    La CURP es obligatoria.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <h4 class="text-center" style="color:#CEA845">Datos de la empresa</h4>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Empresa</label>
                                                <input type="text" class="form-control" placeholder="*Empresa representación" name="empresaAbogadoAlta" oninput="this.value = this.value.toUpperCase()" required>
                                                <div class="invalid-feedback">
                                                    La empresa es obligatoria.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Domicilio</label>
                                                <input type="text" class="form-control" placeholder="*Domicilio" name="domicilioAbogadoAlta" id="domicilioAbogadoAlta" oninput="this.value = this.value.toUpperCase()" required>
                                                <div class="invalid-feedback">
                                                    El domicilio es obligatoria.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">RFC</label>
                                                <input type="text" class="form-control" placeholder="RFC Empresa" name="RFCAbogadoAlta" minlength="13" maxlength="13" oninput="this.value = this.value.toUpperCase()">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Fecha vigencia</label>
                                                <input type="date" class="form-control" aria-describedby="basic-addon1" name="fechaVigenciaAlta" id="fechaVigenciaAlta" min="<?= date("Y-m-d") ?>" required>
                                                <div class="invalid-feedback">
                                                    La fecha es obligatoria.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Giro Comercial</label>
                                                <input type="text" class="form-control" placeholder="Giro Comercial" name="industriaAlta" required>
                                                <div class="invalid-feedback">
                                                    La industria es obligatoria.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <span class="" id="basic-addon1">*Seleccione la region(nes).</i></i></span>
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
                                                <textarea class="form-control" aria-describedby="basic-addon1" name="descripcionpoderAlta" required></textarea>
                                                <div class="invalid-feedback">
                                                    La descripción es obligatoria.
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
                                                <label>*Identificación oficial</label><br>
                                                <input type="file" name="documentoIne" class="form-control" accept=".pdf" required>
                                                <div class="invalid-feedback">
                                                    La Identificación es obligatoria.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>*Documento que acredite la representación</label><br>
                                                <input type="file" name="documentoRepresentacion" class="form-control" accept=".pdf" required>
                                                <div class="invalid-feedback">
                                                    El documento de representación es obligatorio.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>Anexos(Solo si se requiere)</label><br>
                                                <input type="file" name="documentoAnexo" class="form-control" accept=".pdf" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label>Anexos 2(Solo si se requiere)</label><br>
                                                <input type="file" name="documentoPoder" class="form-control" accept=".pdf" required>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div align="center">
                                            <button type="submit" class="btn btn-primary" style="background-color:#CEA845;">Guardar</button>
                                            <a href="{{ route('publico'); }}" class="btn btn-primary" style=" background-color:#CEA845;">Regresar</a>    
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

@section('scripts')
    <script src="public/js/poderes/general.js"></script>
@endsection
