@extends('layouts.app')

<style>
    /* Style the tab */
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }
    
    /* Style the buttons that are used to open the tab content */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
    }
    
    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }
    
    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #ccc;
    }
    
    /* Style the tab content */
    .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }

    <style>
    body {font-family: Arial;}

    /* Style the tab */
    .tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
    }

    /* Style the buttons inside the tab */
    .tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
    background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
    background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
    }
    .span {
        width: 100%;
        height: 50px;
    }
</style>
    

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Revisar Solicitud</h3>
        </div>
        <div class="section-body">
            <?php $fecha_actual = date('d-m-Y');?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Solicitud</h3>
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

                             <form class="needs-validation novalidate" method="POST" enctype='multipart/form-data'>
                                    @csrf
                                    <input type="hidden" name="id" value="{{$id}}">
                                    <div class="tab">
                                        <a class="btn btn-info" onclick="openCity(event, 'detalles')">Detalles</a>
                                        <a class="btn btn-info" onclick="openCity(event, 'solicitante')">Solicitante</a>
                                        <a class="btn btn-info" onclick="openCity(event, 'documentos')">Citado(s)</a>
                                    </div>

                                    <div id="detalles" class="tabcontent">
                                        <div id="tabla_detalles" class="row">
                                            <div class="col-xs-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Fecha de registro</label>
                                                    <input type="date" class="form-control" value="<?=$general["fecha"];?>" readonly>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-9">
                                                <div class="form-group">
                                                    <label for="password">Actividad</label>
                                                    <input type="text" name="actividad_economica" class="form-control" value="<?=$general["actividad"];?>">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Rama industrial del negocio</label>
                                                    <select class="form-control" name="ramaIndustrial">
                                                        <option value="">Seleccione</option>
                                                        @foreach($ramas as $rama)
                                                            <option value="{{$rama['id']}}" {{ $rama["id"] == $general["id_rama"] ? "selected" : '' }} >{{$rama['rama_industrial']}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        

                                            <div class="col-xs-12 col-sm-12 col-md-12"><br>
                                                <table  class="table table-striped mt-1" style="margin: 0 center; text-align:center;">
                                                    <thead style="background-color: #D2D3D5;">
                                                        <th style="color: black;">Motivo capturado</th>
                                                    </thead>
                                                    <tbody>
                                                         @foreach($motivos as $motivo)
                                                            <tr>
                                                                <td>
                                                                    <option value="{{$motivo['id']}}">{{$motivo['motivo']}}</option>
                                                                </td>   
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="solicitante" class="tabcontent">
                                        <div id="tabla_solicitante" class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <h4 class="text-center">Solicitante</h4>
                                                </div>
                                            </div>
                                            @foreach($solicitantes as $solicitante)
                                                <div class="col-xs-12 col-sm-6 col-md-12">
                                                    <div class="form-group">
                                                        <label for="password">Nombre</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["nombre"] == 'NULL' ? "" : $solicitante["nombre"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="confirm-password">Tipo de Persona</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["tipo_persona"] == 'NULL' ? "" : $solicitante["tipo_persona"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="confirm-password">CURP</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["curp"] == 'NULL' ? "" : $solicitante["curp"] }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">RFC</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["rfc"] == 'NULL' ? "" : $solicitante["rfc"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="confirm-password">Sexo</label><br>
                                                        <select name="sexo_solicitante" class="form-control">
                                                            <option value="H" {{ $solicitante["sexo"] == 'H' ? "selected" : '' }}>Hombre</option>
                                                            <option value="M"  {{ $solicitante['sexo'] == 'M' ? "selected" : '' }}>Mujer</option>
                                                            <option value="NB"  {{ $solicitante['sexo'] == 'NB' ? "selected" : '' }}>No Binario</option>
                                                            <option value="LGBTTTIQ"  {{ $solicitante['sexo'] == 'LGBTTTIQ' ? "selected" : '' }}>LGBTTTIQ+</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="confirm-password">Nacionalidad</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["nacionalidad"] == 'NULL' ? "" : $solicitante["nacionalidad"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Estado del solicitante</label><br>
                                                        <select id="estado_solicitante" class="form-control" name="estado_solicitante">
                                                            @foreach($estados as $est)
                                                                <option value="{{$est['id']}}" {{ $solicitante['estado'] == $est['id'] ? "selected" : '' }}>{{$est['nombre']}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            El Estado es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Municipio del solicitante</label><br>
                                                        <select class="form-control" name="municipio_solicitante">
                                                            @foreach($municipios as $mun)
                                                                <option value="{{$mun['id']}}" {{ $solicitante['municipio_domicilio'] == $mun['id'] ? "selected" : '' }}>{{$mun['nombre']}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            El Estado es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Email</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["email"] == 'NULL' ? "" : $solicitante["email"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Fecha Nacimiento</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["fecha_nacimiento"] == 'NULL' ? "" : $solicitante["fecha_nacimiento"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Edad</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["edad"] == 'NULL' ? "" : $solicitante["edad"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Télefono</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["telefono1"] == 'NULL' ? "" : $solicitante["telefono1"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Télefono (Opcional)</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["telefono2"] == 'NULL' ? "" : $solicitante["telefono2"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="confirm-password">Requiere Traductor</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["traductor"] == 'NULL' ? "" : $solicitante["traductor"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Lenjuage requerido</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["lenguaje"] == 'NULL' ? "" : $solicitante["lenguaje"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="confirm-password">Tiene Discapacidad</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["discapacidad"] == 'NULL' ? "" : $solicitante["discapacidad"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Lenjuage requerido</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["tipo_discapacidad"] == 'NULL' ? "" : $solicitante["tipo_discapacidad"] }}</span>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h4 class="text-center">Dirección</h4>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Tipo de Vialidad</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["tipo_vialidad"] == 'NULL' ? "" : $solicitante["tipo_vialidad"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-9">
                                                    <div class="form-group">
                                                        <label for="password">Calle</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["calle"] == 'NULL' ? "" : $solicitante["calle"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Núm. Ext.</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["num_ext"] == 'NULL' ? "" : $solicitante["num_ext"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Núm. Int.</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["num_int"] == 'NULL' ? "" : $solicitante["num_int"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Código postal</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["codigo_postal"] == 'NULL' ? "" : $solicitante["codigo_postal"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Referencia</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["referencia"] == 'NULL' ? "" : $solicitante["referencia"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Colonia</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["colonia"] == 'NULL' ? "" : $solicitante["colonia"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Entre calle</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["calle2"] == 'NULL' ? "" : $solicitante["calle2"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Y entre calle</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["calle3"] == 'NULL' ? "" : $solicitante["calle3"] }}</span>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h4 class="text-center">Datos del trabajo</h4>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Seguro Social</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["nss"] == 'NULL' ? "" : $solicitante["nss"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Puesto</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["puesto"] == 'NULL' ? "" : $solicitante["puesto"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="name">Periodo de pago</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["periodo_pago"] == 'NULL' ? "" : $solicitante["periodo_pago"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Sueldo</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["pago"] == 'NULL' ? "" : $solicitante["pago"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Fecha de Ingreso</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["fecha_ingreso"] == 'NULL' ? "" : $solicitante["fecha_ingreso"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Fecha de Salida</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["fecha_salida"] == 'NULL' ? "" : $solicitante["fecha_salida"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">Jornada</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["jornada"] == 'NULL' ? "" : $solicitante["jornada"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Horas trabajadas a la semana</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["horas_semana"] == 'NULL' ? "" : $solicitante["horas_semana"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Labora Actualmente</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $solicitante["labora"] == 'NULL' ? "" : $solicitante["labora"] }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div id="documentos" class="tabcontent">
                                        <div id="tabla_documentos" class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <h4 class="text-center">Datos Citado(s)</h4>
                                                </div>
                                            </div><br>

                                            @foreach($citados as $citado)
                                                <div class="col-xs-12 col-sm-12 col-md-12" style="background-color:#D2D3D5; width:100%; height:30px;">
                                                    <div class="form-group">
                                                        <h4 class="text-center">Citado</h4>
                                                    </div>
                                                </div><br>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Nombre Citado</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $citado["nombre"] == 'NULL' ? "" : $citado["nombre"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Primer apellido</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $citado["primer_apellido"] == 'NULL' ? "" : $citado["primer_apellido"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Segundo apellido</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $citado["segundo_apellido"] == 'NULL' ? "" : $citado["segundo_apellido"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">Tipo de persona</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $citado["tipo_persona"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">CURP</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $citado["curp"] == 'NULL' ? "" : $citado["curp"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">RFC</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $citado["rfc"] == 'NULL' ? "" : $citado["rfc"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h4 class="text-center">Dirección</h4>
                                                    </div>
                                                </div><br>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Colonia del citado</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $citado["colonia"] == 'NULL' ? "" : $citado["colonia"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">Tipo de Vialidad</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $citado["tipo_vialidad"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Calle del citado</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $citado["calle"] == 'NULL' ? "" : $citado["calle"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Entre Calle</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $citado["calle1"] == 'NULL' ? "" : $citado["calle1"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Entre Calle</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $citado["calle2"] == 'NULL' ? "" : $citado["calle2"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">N° Ext.</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $citado["n_ext"] == 'NULL' ? "" : $citado["n_ext"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">N° Int.</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $citado["n_int"] == 'NULL' ? "" : $citado["n_int"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-4">
                                                    <div class="form-group">
                                                        <label for="password">Código Postal</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $citado["cp"] == 'NULL' ? "" : $citado["cp"] }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="name">Municipio o Alcaldía del citado *</label>
                                                        <select class="form-control" name="municipio_citado" id="municipio_citado">
                                                            @foreach($municipios as $mun)
                                                                <option value="{{$mun['id']}}" {{ $citado['municipio_citado'] == $mun['id'] ? "selected" : '' }}>{{$mun['nombre']}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            El campo municipio o alcaldía es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-12">
                                                    <div class="form-group">
                                                        <label for="password">Referencia</label><br>
                                                        <span class="badge badge-pill badge-secondary">{{ $citado["referencia"] == 'NULL' ? "" : $citado["referencia"] }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </form>
                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


<!-- Modal -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form class='needs-validation novalidate'  method='POST' action="{{route('agregar_citado_edicion')}}">
            @csrf
            <input type="hidden" name="id" value="{{$id}}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Citado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <h4 class="text-center">Dirección del citado</h4>
                                </div>
                            </div>                                        

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">Agregar "Quien resulte responsable"</label>
                                    <select name="responsable" class="form-control" required>
                                        <option value="">SELECCIONE</option>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        El campo es obligatorio.
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">Tipo de Vialidad del citado *</label>
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

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">Calle del citado *</label>
                                    <input type="text" name="calle" class="form-control" required> 
                                    <div class="invalid-feedback">
                                        El campo calle es obligatorio.
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">Colonia del citado *</label>
                                    <input type="text" name="colonia" class="form-control" required> 
                                    <div class="invalid-feedback">
                                        El campo colonia es obligatorio.
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">Código Postal del citado *</label>
                                    <input type="text" name="cp" class="form-control" minlength="5" maxlength="5" required> 
                                    <div class="invalid-feedback">
                                        El campo Código Postal es obligatorio.
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">Entre calle del domicilio del citado *</label>
                                    <input type="text" name="calle1" class="form-control"> 
                                    <div class="invalid-feedback">
                                        El campo calle es obligatorio.
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">y calle del domicilio del citado *</label>
                                    <input type="text" name="calle2" class="form-control"> 
                                    <div class="invalid-feedback">
                                        El campo calle es obligatorio.
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">Núm ext. del citado *</label>
                                    <input type="text" name="exterior" class="form-control" required> 
                                    <div class="invalid-feedback">
                                        El campo c
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label for="name">Núm int. del citado</label>
                                    <input type="text" name="interior" class="form-control" > 
                                    <div class="invalid-feedback">
                                        El campo calle es obligatorio.
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="name">Nombre del Municipio o Alcaldía del citado *</label>
                                    <select id="municipio_citado" class="form-control" name="municipio_citado" required>
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

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                <label for="floatingTextarea">Referencias del domicilio del citado *</label>
                                    <textarea class="form-control" placeholder="Ingresa alguna referencia de como llegar" name="referencia"></textarea>
                                    <div class="invalid-feedback">
                                        El campo referencias es obligatorio.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
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

                            <div class="col-xs-12 col-sm-12 col-md-6">
                                <label for="name">Requiere algun lenguaje</label>
                                <select name="lenguaje" class="form-control" required>
                                    <option value="">SELECCIONE</option>
                                    <option value=" ">Si</option>
                                    <option value="No">No</option>
                                </select>
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<!-- Modal -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        @csrf
        <input type="hidden" name="id" value="{{$id}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Motivo de rechazo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped mt-2">
                            <thead style="background-color: #4A001F;">
                                <th style="color: #fff;">Nombre</th>
                                <th style="color: #fff;">CURP</th>
                                <th style="color: #fff;">Dirección</th>
                                <th style="color: #fff;">Acciones</th>
                            </thead>
                            <tbody>
                                @foreach($citados as $citado)
                                <tr>
                                    <td>{{$citado->nombre}}</td>
                                    <td>{{$citado->curp}}</td>
                                    <td>{{$citado->colonia}}." ".{{$citado->calle}}</td>
                                    <td>
                                        <form method="POST" action="{{ route('borrar_citado_edicion') }} ">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="id" value="{{$id}}">
                                            <input type="hidden" name="borrar" value="{{$citado->id}}">
                                            <button class="btn btn-danger" onclick=editar_rol(); type="submit">Eliminar</button>
                                        </form>
                                    </td>   
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

<div id="menu_carga" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>


@section('scripts')
    <script src="../public/assets/js/estadistica/estadistica.js"></script>
        <script>
            $(function(){
                $('#motivo_solicitud').on('change', validarcheckfolio);
            })


            let motivosSeleccionados = [];

            function validarcheckfolio(){
                var opcionSeleccionada = $(this).val();
                var opcionTexto = $("#motivo_solicitud option:selected").text();

                // Verifica si ya fue agregado ese motivo
                if (motivosSeleccionados.includes(opcionSeleccionada)) {
                    alert('Este motivo ya ha sido seleccionado.');
                    $(this).val('');
                    return;
                }

                motivosSeleccionados.push(opcionSeleccionada);

                $('#tabla tbody').append(
                    '<tr data-id="' + opcionSeleccionada + '">' +
                        '<td>' + opcionTexto + '</td>' +
                        '<td><button type="button" class="eliminar btn btn-danger btn-sm">Eliminar</button></td>' +
                    '</tr>'
                );

                $('#div1').append(
                    '<input type="hidden" name="motivo_solicitud[]" value="' + opcionSeleccionada + '" id="input-motivo-' + opcionSeleccionada + '">'
                );

                // Reinicia el select
                $(this).val('');
            }

            // Eliminar fila e input hidden
            $(document).on('click', '.eliminar', function() {
                var fila = $(this).closest('tr');
                var idMotivo = fila.attr('data-id');

                // Elimina input y fila
                $('#input-motivo-' + idMotivo).remove();
                fila.remove();

                // Actualiza la lista de los motivos seleccionados
                motivosSeleccionados = motivosSeleccionados.filter(id => id !== idMotivo);
            });
        
            $('#tabla_detalles').show();
            $('#tabla_solicitante').sow();
            $('#tabla_citados').show();
            $('#tabla_documentos').show();
    </script>
@endsection

