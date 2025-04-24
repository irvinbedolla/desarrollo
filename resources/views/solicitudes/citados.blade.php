<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Ing. ISBM">
        <title>Si Concilio</title>
    <!-- Bootstrap 5.3.3 -->
    <link href="../public/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

    <!-- Ionicons -->
    <link rel="icon" href="../public/assets/images/ccl-r.png" type="image/x-icon">
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
            background: url('../public/assets/images/pageLoader.gif') 50% 50% no-repeat rgb(249,249,249);
           /* background-color: #6A0F49;/*<p style="color: #CEA845*/
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

   
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="">
        <img src="../public/assets/images/Logos 2.png" class="img" style="" width="330" height="80"></a>&nbsp;&nbsp;
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
                                        <h3 class="text-center" style="color:black">Ingresa los datos de citado (Debes capturar al menos un Citado)</h3>
                                    </div>    

                                    <!--Se realiza el envío de datos con formulario de Laravel Collective-->
                                    <form class="needs-validation novalidate" method="POST" action="{{route('seer.citados')}}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <h4 class="text-center">Dirección del citado</h4>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Colonia</label>
                                                    <input type="text" name="colonia" class="form-control" required> 
                                                    <div class="invalid-feedback">
                                                        El campo colonia es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Tipo de Vialidad</label>
                                                    <input type="text" name="vialidad" class="form-control" placeholder="Calle, Avenida " required> 
                                                    <div class="invalid-feedback">
                                                        El campo colonia es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Calle</label>
                                                    <input type="text" name="calle" class="form-control" required> 
                                                    <div class="invalid-feedback">
                                                        El campo colonia es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Código Postal</label>
                                                    <input type="text" name="cp" class="form-control" minlength="5" maxlength="5" required> 
                                                    <div class="invalid-feedback">
                                                        El campo Código Postal es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Entre calle</label>
                                                    <input type="text" name="calle1" class="form-control"> 
                                                    <div class="invalid-feedback">
                                                        El campo calle es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">y calle</label>
                                                    <input type="text" name="calle2" class="form-control"> 
                                                    <div class="invalid-feedback">
                                                        El campo calle es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Num ext.</label>
                                                    <input type="text" name="exterior" class="form-control" required> 
                                                    <div class="invalid-feedback">
                                                        El campo calle es obligatorio.

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Num int.</label>
                                                    <input type="text" name="interior" class="form-control" > 
                                                    <div class="invalid-feedback">
                                                        El campo calle es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                <label for="floatingTextarea">Referencia</label>
                                                    <textarea class="form-control" placeholder="Ingresa alguna referencia de como llegar" name="referencia"></textarea>
                                                    <div class="invalid-feedback">
                                                        El campo calle es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                                <spam for="btncheck1">Cuenta con los datos del Patron/Empresa</spam>
                                                <input type="checkbox" class="btn-check" id="check_datos" autocomplete="off">
                                            </div>
                                            
                                        <div class="row" id="div_datos_citado" style="display:none">
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Tipo de personas</label>
                                                    <select name="tipo" class="form-control">
                                                        <option value="">Seleccione</option>
                                                        <option value="Fisica">Fisica</option>
                                                        <option value="Moral">Moral</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El tipo de persona es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">CURP</label>
                                                    <input type="text" name="curp" id="curp_input" oninput="validarInput(this)" class="form-control"> 
                                                    <pre id="resultado"></pre>
                                                    <div class="invalid-feedback">
                                                        El nombre es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Nombre(s) *</label>
                                                    <input type="text" name="nombre" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                    <div class="invalid-feedback">
                                                        El nombre es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Primer apellido *</label>
                                                    <input type="text" name="primer_apellido" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                    <div class="invalid-feedback">
                                                        El nombre es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Segundo apellido *</label>
                                                    <input type="text" name="segundo_apellido" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                    <div class="invalid-feedback">
                                                        El nombre es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">RFC</label>
                                                    <input type="text" name="rfc" class="form-control" minlength="13" maxlength="13" > 
                                                    <div class="invalid-feedback">
                                                        El campo conflicto es obligatorio.
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Estado del solicitante</label>
                                                    <select id="estado_solicitante" class="form-control" name="estado_solicitante" required>
                                                        <option value="">Seleccione</option>
                                                        @foreach($estados as $est)
                                                            <option value="{{$est['id']}}">{{$est['nombre']}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El Estado es obligatorio.
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <spam for="btncheck1">Requiere Traductor</spam>
                                                <input type="checkbox" class="btn-check" id="check_lenguaje" name="traductor" autocomplete="off">
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-6" id="lenguaje_señas">
                                                <div class="form-group">
                                                    <label for="name">Que tipo de lenguaje require</label>
                                                    <input type="text" name="lenguaje" class="form-control">
                                                    <div class="invalid-feedback">
                                                        La nacionalidad es obligatoria.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div align="center">
                                                <button type="submit" class="btn btn-primary" style="background-color:#CEA845; border-color:#CEA845;">Agregar</button>
                                                <a href="{{ route('agregar_documentos', $id); }}" class="btn btn-primary" style=" background-color:#CEA845;border-color:#CEA845;">Continuar</a>    
                                                </div>
                                        </div>    
                                    </form>
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
    <script src="../public/assets/js/poderes/general.js"></script>
@endsection



    <script src="../public/assets/js/jquery.min.js"></script>
    <script src="../public/assets/js/popper.min.js"></script>
    <script src="../public/assets/js/bootstrap.min.js"></script>
    <script src="../public/assets/js/sweetalert.min.js"></script>
    <script src="../public/assets/js/select2.min.js"></script>
    <script src="../public/assets/js/jquery.nicescroll.js"></script>
    <script src="../public/assets/js/moment.js"></script>

    <!-- Template JS File -->
    <script src="../public/assets/js/stisla.js"></script>
    <script src="../public/assets/js/scripts.js"></script>
    <script src="../public/assets/js/profile.js"></script>
    <script src="../public/assets/js/custom.js"></script>

    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap4.js"></script>
    @yield('page_js')


    @yield('scripts')
    <script src="../public/assets/js/validaciones.js"></script> 
    <script>
        
        $(function(){
            $('#check_datos').on('change', mostrarDatos);
            console.log("llego");
        })

        function mostrarDatos(){
            var check = document.getElementById("div_datos_citado").style.display;
            console.log(check);
            if (check == "none") {
                document.getElementById("div_datos_citado").style.display = "block";
            }
            else{
                document.getElementById("div_datos_citado").style.display = "none";
            }
        }

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