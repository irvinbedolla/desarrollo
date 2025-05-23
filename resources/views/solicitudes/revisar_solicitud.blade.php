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
</style>
    
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
                            <h3 class="text-center">Solicitud Pendiente</h3>
                            
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

                             <form class="needs-validation novalidate" method="POST" action="{{route('confirmar_solicitud')}}">
                                    @csrf
                                    <div class="tab">
                                        <a class="btn btn-info" onclick="openCity(event, 'detalles')">Detalles</a>
                                        <a class="btn btn-info" onclick="openCity(event, 'solicitante')">Solicitante</a>
                                        <a class="btn btn-info" onclick="openCity(event, 'documentos')">Citado(s)</a>
                                        <a class="btn btn-info" onclick="openCity(event, 'citados')">Documentos</a>
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
                                                    <input type="text" class="form-control" value="<?=$general["actividad"];?>">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Rama industrial del negocio</label>
                                                    <select class="form-control" name="ramaIndustrial" required>
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
                                                        <th style="color: black;">Acción</th>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            @foreach($motivos as $motivo)
                                                                <td>
                                                                    <option value="{{$motivo['id']}}">{{$motivo['motivo']}}</option>
                                                                </td>  
                                                                <td>
                                                                   <a href="{{ route('eliminar_motivo', ['id' => $id, 'id_motivo' => $motivo->id] ) }}" class="eliminar btn btn-danger btn-sm">Eliminar</button>
                                                                </td>   
                                                            @endforeach
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                       
                                            <div class="col-xs-6 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Agregar Otro Motivo a la Solicitud</label>
                                                    <select  class="form-control" id="motivo_solicitud">
                                                        <option value="">Seleccione</option>
                                                        @foreach($mostrarMotivos as $motivo)
                                                            <option value="{{$motivo['id']}}">{{$motivo['motivo']}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El objeto de solicitud es obligatoria.
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="div1"  class="col-xs-12 col-sm-12 col-md-12"><br>
                                                <table id="tabla" name="motivo_solicitud[]" class="table table-striped mt-1" style="margin: 0 center; text-align:center;">
                                                    <thead style="background-color: #D2D3D5;">
                                                        <th style="color: black;">Objeto de la Solicitud</th>
                                                        <th style="color: black;">Acción</th>
                                                    </thead>
                                                    <tbody></tbody>
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
                                                        <label for="password">Nombre</label>
                                                        <input type="text" class="form-control" name="nombre" value="<?=$solicitante["nombre"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="confirm-password">Tipo de Persona</label>
                                                        <select name="tipo_persona" class="form-control">
                                                            <option value="Fisica" {{ $solicitante["tipo_persona"] == 'Fisica' ? "selected" : '' }}>Fisica</option>
                                                            <option value="Moral"  {{ $solicitante['tipo_persona'] == 'Moral' ? "selected" : '' }}>Moral</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="confirm-password">CURP</label>
                                                        <input type="text" class="form-control" name="curp" value="<?=$solicitante["curp"];?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">RFC</label>
                                                        <input type="text" class="form-control" name="rfc" value="<?=$solicitante["rfc"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="confirm-password">Sexo</label>
                                                        <select name="sexo" class="form-control">
                                                            <option value="H" {{ $solicitante["sexo"] == 'H' ? "selected" : '' }}>Hombre</option>
                                                            <option value="M"  {{ $solicitante['sexo'] == 'M' ? "selected" : '' }}>Mujer</option>
                                                            <option value="NB"  {{ $solicitante['sexo'] == 'NB' ? "selected" : '' }}>No Binario</option>
                                                            <option value="LGBTTTIQ"  {{ $solicitante['sexo'] == 'LGBTTTIQ' ? "selected" : '' }}>LGBTTTIQ+</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="confirm-password">Nacionalidad</label>
                                                        <select name="nacionalidad" class="form-control">
                                                            <option value="Mexicana" {{ $solicitante["sexo"] == 'Mexicana' ? "selected" : '' }}>Mexicana</option>
                                                            <option value="Otra"  {{ $solicitante['sexo'] == 'Otra' ? "selected" : '' }}>Otra</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Estado del solicitante</label>
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
                                                        <label for="password">Email</label>
                                                        <input type="text" class="form-control" name="email" value="<?=$solicitante["email"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Fecha Nacimiento</label>
                                                        <input type="date" class="form-control" name="fecha_nacimiento" value="<?=$solicitante["fecha_nacimiento"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Edad</label>
                                                        <input type="text" class="form-control" name="edad" value="<?=$solicitante["edad"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Télefono</label>
                                                        <input type="text" class="form-control" name="telefono1" value="<?=$solicitante["telefono1"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Télefono (Opcional)</label>
                                                        <input type="text" class="form-control" name="telefono2" value="<?=$solicitante["telefono2"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="confirm-password">Requiere Traductor</label>
                                                        <select name="traductor" class="form-control">
                                                            <option value="Si" {{ $solicitante["traductor"] == 'Si' ? "selected" : '' }}>SI</option>
                                                            <option value="No"  {{ $solicitante['traductor'] == 'No' ? "selected" : '' }}>NO</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Lenjuage requerido</label>
                                                        <input type="text" class="form-control" name="lenguaje" value="<?=$solicitante["lenguaje"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="confirm-password">Tiene Discapacidad</label>
                                                        <select name="traductor" class="form-control">
                                                            <option value="Si" {{ $solicitante["discapacidad"] == 'Si' ? "selected" : '' }}>SI</option>
                                                            <option value="No"  {{ $solicitante['discapacidad'] == 'No' ? "selected" : '' }}>NO</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Lenjuage requerido</label>
                                                        <input type="text" class="form-control" name="lenguaje" value="<?=$solicitante["tipo_discapacidad"];?>">   
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h4 class="text-center">Dirección</h4>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Tipo de Vialidad</label>
                                                        <input type="text" class="form-control" name="tipo_vialidad" value="<?=$solicitante["tipo_vialidad"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-9">
                                                    <div class="form-group">
                                                        <label for="password">Calle</label>
                                                        <input type="text" class="form-control" name="calle" value="<?=$solicitante["calle"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Num Ext.</label>
                                                        <input type="text" class="form-control" name="num_ext" value="<?=$solicitante["num_ext"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Num Int.</label>
                                                        <input type="text" class="form-control" name="num_int" value="<?=$solicitante["num_int"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Código postal</label>
                                                        <input type="text" class="form-control" name="codigo_postal" value="<?=$solicitante["codigo_postal"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Num Int.</label>
                                                        <input type="text" class="form-control" name="referencia" value="<?=$solicitante["referencia"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Colonia</label>
                                                        <input type="text" class="form-control" name="colonia" value="<?=$solicitante["colonia"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Entre calle</label>
                                                        <input type="text" class="form-control" name="calle2" value="<?=$solicitante["calle2"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Y entre calle</label>
                                                        <input type="text" class="form-control" name="calle3" value="<?=$solicitante["calle3"];?>">   
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h4 class="text-center">Datos del trabajo</h4>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Seguro Social</label>
                                                        <input type="text" class="form-control" name="nss" value="<?=$solicitante["nss"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Puesto</label>
                                                        <input type="text" class="form-control" name="puesto" value="<?=$solicitante["puesto"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="name">Periodo de pago</label>
                                                        <select name="periodo_pago" class="form-control" required>
                                                            <option value="">SELECCIONE</option>
                                                            <option value="Semana"      {{ $solicitante['periodo_pago'] == 'Semana' ? "selected" : '' }}>SEMANAL</option>
                                                            <option value="Quincenal"   {{ $solicitante['periodo_pago'] == 'Quincenal' ? "selected" : '' }}>QUINCENAL</option>
                                                            <option value="Mensual"     {{ $solicitante['periodo_pago'] == 'Mensual' ? "selected" : '' }}>MENSUAL</option>
                                                            <option value="Diario"      {{ $solicitante['periodo_pago'] == 'Diario' ? "selected" : '' }}>DIARIO</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Sueldo</label>
                                                        <input type="text" class="form-control" name="pago" value="<?=$solicitante["pago"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Fecha de Ingreso</label>
                                                        <input type="date" class="form-control" name="fecha_ingreso" value="<?=$solicitante["fecha_ingreso"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Fecha de Salida</label>
                                                        <input type="date" class="form-control" name="fecha_salida" value="<?=$solicitante["fecha_salida"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">Jornada</label>
                                                        <select name="jornada" class="form-control" required>
                                                            <option value="">SELECCIONE</option>
                                                            <option value="Diurna"   {{ $solicitante['jornada'] == 'Diurna' ? "selected" : '' }}>DIURNA</option>
                                                            <option value="Nocturna" {{ $solicitante['jornada'] == 'Nocturna' ? "selected" : '' }}>NOCTURNA</option>
                                                            <option value="Mixta"    {{ $solicitante['jornada'] == 'Mixta' ? "selected" : '' }}>MIXTA</option>
                                                        </select>
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
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h4 class="text-center">Citado</h4>
                                                    </div>
                                                </div><br>
                                                <div class="col-xs-12 col-sm-6 col-md-12">
                                                    <div class="form-group">
                                                        <label for="password">Nombre Citado</label>
                                                        <input type="text" class="form-control" name="nombre" value="<?=$citado["nombre"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Primer apellido</label>
                                                        <input type="text" class="form-control" name="primer_apellido" value="<?=$citado["primer_apellido"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Segundo apellido</label>
                                                        <input type="text" class="form-control" name="segundo_apellido" value="<?=$citado["segundo_apellido"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">Tipo de persona</label>
                                                        <select name="jornada" class="form-control" required>
                                                            <option value="">SELECCIONE</option>
                                                            <option value="Fisica" {{ $solicitante['tipo_persona'] == 'Fisica' ? "selected" : '' }}>Fisica</option>
                                                            <option value="Moral"  {{ $solicitante['tipo_persona'] == 'Moral' ? "selected" : '' }}>Moral</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-4">
                                                    <div class="form-group">
                                                        <label for="password">CURP</label>
                                                        <input type="text" class="form-control" name="curp" value="<?=$citado["curp"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-4">
                                                    <div class="form-group">
                                                        <label for="password">RFC</label>
                                                        <input type="text" class="form-control" name="rfc" value="<?=$citado["rfc"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h4 class="text-center">Dirección</h4>
                                                    </div>
                                                </div><br>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Colonia del citado</label>
                                                        <input type="text" class="form-control" name="colonia" value="<?=$citado["colonia"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">Tipo de Vialidad (*)</label>
                                                        <select name="vialidad" class="form-control" required>
                                                            <option value="">SELECCIONE</option>
                                                            <option value="Calle"     {{ $solicitante['tipo_vialidad'] == 'Calle' ? "selected" : ''>CALLE</option>
                                                            <option value="Avenida"   {{ $solicitante['tipo_vialidad'] == 'Avenida' ? "selected" : ''>AVENIDA</option>
                                                            <option value="Calzada"   {{ $solicitante['tipo_vialidad'] == 'Calzada' ? "selected" : ''>CALZADA</option>
                                                            <option value="Boulevard" {{ $solicitante['tipo_vialidad'] == 'Boulevard' ? "selected" : ''>BOULEVARD</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            El campo vialidad es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Calle del citado</label>
                                                        <input type="text" class="form-control" name="calle" value="<?=$citado["calle"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Entre Calle</label>
                                                        <input type="text" class="form-control" name="calle1" value="<?=$citado["calle1"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-6">
                                                    <div class="form-group">
                                                        <label for="password">Entre Calle</label>
                                                        <input type="text" class="form-control" name="calle2" value="<?=$citado["calle2"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">N° Ext.</label>
                                                        <input type="text" class="form-control" name="n_ext" value="<?=$citado["n_ext"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">N° Int.</label>
                                                        <input type="text" class="form-control" name="n_int" value="<?=$citado["n_int"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-12">
                                                    <div class="form-group">
                                                        <label for="password">Referencia</label>
                                                        <input type="text" class="form-control" name="referencia" value="<?=$citado["referencia"];?>">   
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-6 col-md-4">
                                                    <div class="form-group">
                                                        <label for="password">Código Postal</label>
                                                        <input type="text" class="form-control" name="cp" value="<?=$citado["cp"];?>">   
                                                    </div>
                                                </div>
                                                
                                            @endforeach
                                        </div>
                                    </div>

                                    <div id="citados" class="tabcontent">
                                        <div id="tabla_citados" class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <h4 class="text-center">Documentos</h4>
                                                </div>
                                            </div><br>

                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <label for="password">Identificacíon Oficial Frente</label><br>
                                                @if(!isset($general->documentoIne))
                                                    Sin documento.
                                                @else
                                                    <a target='_blank' href='../storage/app/documentosSolicitud/{{$general->documentoINEFrente}}'>PDF</a>
                                                @endif
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <label for="password">Identificacíon Oficial Atras</label><br>
                                                @if(!isset($general->documentoIne))
                                                    Sin documento.
                                                @else
                                                    <a target='_blank' href='../storage/app/documentosSolicitud/{{$general->documentoINEAtras}}'>PDF</a>
                                                @endif
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <label for="password">Acta de Nacimiento</label><br>
                                                @if(!isset($general->documentoIne))
                                                    Sin documento.
                                                @else
                                                    <a target='_blank' href='../storage/app/documentosSolicitud/{{$general->documentoActa}}'>PDF</a>
                                                @endif
                                            </div>

                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <label for="password">CURP</label><br>
                                                @if(!isset($general->documentoIne))
                                                    Sin documento.
                                                @else
                                                    <a target='_blank' href='../storage/app/documentosSolicitud/{{$general->documentoCurp}}'>PDF</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <button type="submit" class="btn btn-primary" style="background-color:#CEA845; border-color:#CEA845;">Confirmar</button>
                                        <a class="btn btn-danger" href="{{ route('rechazar_solicitud') }}">Rechazar</a>
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


<div id="menu_carga" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>


@section('scripts')

    <script src="../public/assets/js/estadistica/estadistica.js"></script>
        <script>

        $('#tabla_detalles').show();
        $('#tabla_solicitante').sow();
        $('#tabla_citados').show();
        $('#tabla_documentos').show();

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
        //});
    </script>
@endsection

