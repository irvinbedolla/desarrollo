<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Ing. ISBM">
        <link href="public/assets/css/carousel.css" rel="stylesheet">
        <title>Si Concilio</title>
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
        <link rel="icon" href="public/assets/images/logo-ccl.png" type="image/x-icon">
    
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
</head>

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
                <a class="nav-link" href="#" style="color: black;">INICIO<span class="sr-only"></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#servicios" style="color: black;">SERVICIOS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#contacto"style="color: black;">CONTACTO</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <br><br><br>
</div>
    <div id="app">  
        <section class="section">
            <div class="section-body">
                <div class="row"> 
                    <div class="col-lg-12" >
                        <div class="card">
                            <div class="card-body">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>¡Registro completo!</strong><br>
                                    <label>Tu solicitud fue capturada correctamente, tu número de folio es: {{$folio}}, en un periodo máximo de 3 dias hábiles, recibirás un correo electrónico de confirmación con la fecha y hora de tu audiencia.<br><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NOTA: En caso de detectar algún error en los datos proporcionados, el personal del centro se pondrá en contacto contigo.<br><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Para dudas y/o aclaraciones comunícate al número telefónico (000) 0000 000 o acude a tu Delegación u Oficina de Apoyo del Centro de Conciliación Laboral más cercana.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <a href="{{ route('publico'); }}" class="btn btn-primary" style=" background-color:#CEA845;border-color:#CEA845;">Terminar</a>   
                                </div>
                                
                                 
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="./public/assets/js/estadistica/estadistica.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.5/js/dataTables.bootstrap4.js"></script>
       
