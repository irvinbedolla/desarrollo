<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Ing. ISBM">
        <title>Si Concilio</title>
        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="icon" href="../../public/assets/images/logo-ccl.png" type="image/x-icon">

    <style>
        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('../../public/assets/images/pageLoader.gif') 50% 50% no-repeat rgb(249,249,249);
            opacity: .8;
        }
        
    </style>   
</head>

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="">
            <img src="../../public/assets/images/Logos 2.png" class="img" style="" width="250" height="90">
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
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <h4 class="text-center">Documentos del expediente</h4>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="table-responsive">
                                            <table id="tabla_solicitud" class="table-striped" style="margin: 0 center; text-align:center; width:100%;">
                                                <thead style="background-color: #D2D3D5;">
                                                    <th style="color: black;">Citatorios</th>
                                                    <th style="color: black;">Acción</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($SolicitudPDFs as $ArchivoPDF)
                                                        <tr>
                                                            <td style="text-align: left;">
                                                                {{ $ArchivoPDF }}&nbsp;&nbsp;
                                                            </td>
                                                            <td>
                                                                <a href="{{ asset('storage/app/documentosCitatorios/' . $ArchivoPDF) }}" target="_blank" class="btn btn-primary btn-sm" style="background-color:#CEA845; border-color:#CEA845;"> Visualizar </a>&nbsp;&nbsp;
                                                                <a href="{{ asset('storage/app/documentosCitatorios/' . $ArchivoPDF) }}" download class="btn btn-success btn-sm" style="background-color:#920808; border-color:#920808;"> Descargar </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </section>
    </div>
    