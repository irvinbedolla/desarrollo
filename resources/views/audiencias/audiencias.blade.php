@extends('layouts.app_editar')
@php
    $fechaActual = date('Y-m-d');
    $contador = 0;
@endphp
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Audiencia iniciada</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="" type="button" class="btn btn-info">
                                Actualizar representantes
                            </a>
                            <button type="button" class="btn btn-danger open-modal" data-bs-toggle="modal" data-bs-target="#ModalArchivar" data-id="{{ $id }}">
                                Archivar
                            </button>
                            <button type="button" class="btn btn-danger open-modal" data-bs-toggle="modal" data-bs-target="#ModalReagendar" data-id="{{ $id }}">
                                Reagendar
                            </button>
                            <button type="button" class="btn btn-danger open-modal" data-bs-toggle="modal" data-bs-target="#ModalIncopentencia" data-id="{{ $id }}">
                                Incompetencia
                            </button>
                            <div class="table-responsive">
                                <table class="table table-striped mt-1">
                                    <thead style="background-color: #4A001F;">
                                        <tr> 
                                            <th style="display:none">ID</th>
                                            <th style="color: #ffff;">Tipo parte</th>
                                            <th style="color: #ffff;">Nombre de la parte</th>
                                            <th style="color: #ffff;">Notificación</th>
                                            <th style="color: #ffff;">Estatus Notificación</th>
                                            <th style="color: #ffff;">Representante legal</th>
                                            <th style="color: #ffff;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="display:none">{{$solicitante->id}}</td>
                                            <td style="color: #000000;"><b>Solicitante</b></td>
                                            <td>{{ $solicitante->nombre }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <a type="button" class="btn btn-warning open-modal" data-bs-toggle="modal" data-bs-target="#exampleModal1" data-id="{{ $id }}">Editar</a>
                                            </td>
                                        </tr>
                                       
                                        @foreach($representantes as $representante)
                                            <tr>
                                                <td  style="display:none">{{$representante->id}}</td>
                                                <td style="color: #000000;"><b>Citado</b></td>
                                                <td>{{$representante->nombre}} {{$representante->primer_apellido}} {{$representante->segundo_apellido}}</td>
                                                <td>{{ $representante->notificacion }}</td>
                                                <td>{{ $representante->estatus }}</td>
                                                <td>
                                                    @if($representante->id_abogado == null && $representante->id_fisica == null)
                                                        Por asignar
                                                    @else
                                                        @if($representante->id_abogado != null && $representante->id_fisica == null)
                                                            {{ $representante->nombre_abogado }} {{ $representante->primero_abogado }} {{ $representante->segundo_abogado }}
                                                        @else
                                                            {{ $representante->nombre_fisica }} {{ $representante->primer_fisica }} {{ $representante->segundo_fisica }}
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary open-modal" data-id="{{ $representante->id }}" data-bs-toggle="modal" data-bs-target="#modalCitados"> Citado </button>
                                                    @if($representante->id_abogado != null)
                                                        <a class="btn btn-success" href="{{ route('PDFcompareceSP', $solicitud->id) }}"  target="_blank">Comparece sin poder</a>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php $contador++; @endphp
                                        @endforeach       
                                    </tbody> 
                                </table>
                            </div>
                            <a type="button" class="btn btn-success open-modal" data-bs-toggle="modal" data-bs-target="#ModalTerminar" data-id="{{ $id }}">Continuar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<!-- Modal Solicitantes -->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class='needs-validation novalidate'  method='POST' action="{{route('editar_solicitud')}}">
        @csrf
        <input type="hidden" name="id" value="{{$id}}">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Solicitante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-8">
                            <div class="form-group">
                                <label for="name">Nombre(s) y Apellidos del Solicitante</label>
                                <input type="text" name="nombre" class="form-control" oninput="this.value = this.value.toUpperCase()" value="<?=$solicitante["nombre"];?>" required> 
                                <div class="invalid-feedback">
                                    El campo nombre es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">CURP del Solicitante</label>
                                <input type="text" name="curp" id="curp_input" oninput="validarInput(this)"class="form-control" value="<?=$solicitante["curp"];?>" required> 
                                <pre id="resultado"></pre>
                                <div class="invalid-feedback">
                                    El campo curp es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">RFC del Solicitante</label>
                                <input type="text" name="rfc" class="form-control" minlength="13" maxlength="13" oninput="this.value = this.value.toUpperCase()" value="<?=$solicitante["rfc"];?>" required> 
                                <div class="invalid-feedback">
                                    El campo RFC es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">Número de Seguro Social</label>
                                <input type="text" name="seguro" minlength="11" maxlength="12" class="form-control" value="<?=$solicitante["nss"];?>"> 
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">Puesto</label>
                                <input type="text" class="form-control" name="puesto" value="<?=$solicitante["puesto"];?>" oninput="this.value = this.value.toUpperCase()" required> 
                                <div class="invalid-feedback">
                                    El campo puesto es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">Frecuencia de Pago</label>
                                <select name="periodo_pago" class="form-control" value="<?=$solicitante["periodo_pago"];?>" required>
                                    <option value="">SELECCIONE</option>
                                    <option value="Diario" {{ $solicitante['periodo_pago'] == 'Diario' ? "selected" : '' }}>DIARIO</option>
                                    <option value="Semana" {{ $solicitante['periodo_pago'] == 'Semana' ? "selected" : '' }}>SEMANAL</option>
                                    <option value="Quincenal" {{ $solicitante['periodo_pago'] == 'Quincenal' ? "selected" : '' }}>QUINCENAL</option>
                                    <option value="Mensual" {{ $solicitante['periodo_pago'] == 'Mensual' ? "selected" : '' }}>MENSUAL</option>
                                </select>
                                <div class="invalid-feedback">
                                    El campo frecuencia de pago es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">Salario</label>
                                <input type="text" name="pago" class="form-control" value="<?=$solicitante["pago"];?>" required> 
                                <div class="invalid-feedback">
                                    El campo salario es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">Cantidad total de horas trabajadas por semana</label>
                                <input type="number" name="horas" class="form-control" value="<?=$solicitante["horas_semana"];?>" required> 
                                <div class="invalid-feedback">
                                    El campo cantidad de horas trabajadas es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="password">¿Laboras actualmente?</label>
                                <input type="text" class="form-control" name="labora" value="<?=$solicitante["labora"];?>">   
                            </div>  
                        </div>    
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">Fecha de Ingreso</label>
                                <input type="date" name="fecha_ingreso" class="form-control" value="<?=$solicitante["fecha_ingreso"];?>" required> 
                                <div class="invalid-feedback">
                                    El campo fecha de ingreso es obligatoria.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">Jornada</label>
                                <input name="jornada" class="form-control" value="<?=$solicitante["jornada"];?>" required>
                                   {{-- <option value="">SELECCIONE</option>
                                    <option value="Diurna" {{ $solicitante['jornada'] == 'Diurna' ? "selected" : '' }}>DIURNA</option>
                                    <option value="Nocturna" {{ $solicitante['jornada'] == 'Nocturna' ? "selected" : '' }}>NOCTURNA</option>
                                    <option value="Mixta" {{ $solicitante['jornada'] == 'Mixta' ? "selected" : '' }}>MIXTA</option>
                                </select>--}}
                                <div class="invalid-feedback">
                                    El campo jornada laboral es obligatoria.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4" id="fecha_fin">
                            <div class="form-group">
                                <label for="name">Fecha de Salida</label>
                                <input type="date" name="fecha_salida" class="form-control" value="<?=$solicitante["fecha_salida"];?>"> 
                                <div class="invalid-feedback">
                                    El campo fecha de salida es obligatoria.
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
<!-- Modal Citados -->
<div class="modal fade" id="modalCitados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Representantes Legales</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <form method="POST" action="{{ route('seleccionar_abogado') }} ">
                    @csrf
                    <input type="hidden" id="modal-id" name="citado" value="">
                    <input type="hidden" name="solicitud" value="{{$solicitud->id}}">
                    <table id="tabla1" class="table-striped" style="width:100%">
                        <thead style="background-color: #4A001F;">   
                            <!--<th style="display: none;">ID</th>-->
                            <th style="color: #fff;">Folio</th>
                            <th style="color: #fff;">Nombre</th>
                            <th style="color: #fff;">RFC</th>
                            <th style="color: #fff;">Reprecentante</th>
                            <th style="color: #fff;">Acciones</th>
                        </thead>
                        <tbody class="contenidobusqueda">
                            @foreach($abogados as $abogado)
                                <tr>
                                    <td>{{$abogado->idAbogado}}</td>
                                    <td>{{$abogado->nombres_patronal}} {{$abogado->primer_apellido_patronal}} {{$abogado->segundo_apellido_patronal}}</td>
                                    <td>{{$abogado->rfc_patronal}}</td>
                                    <td>{{$abogado->nombre_representante}} {{$abogado->primer_apellido_representante}} {{$abogado->segundo_apellido_representante}}</td>
                                    <td>
                                        <button class="btn btn-info" onclick=editar_rol(); type="submit" name="abogado" value="{{$abogado->idAbogado}}">Seleccionar</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-id="{{ $id }}" data-bs-toggle="modal" data-bs-target="#modalAgregarCitados">Agregar en representación</button>
                <button type="button" class="btn btn-primary" data-id="{{ $id }}" data-bs-toggle="modal" data-bs-target="#modalAgregarDerecho">Agregar por propio derecho</button>
                <button type="button" class="btn btn-primary" data-id="{{ $id }}" data-bs-toggle="modal" data-bs-target="#modalActualizaCitados">Actualizar citado</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Agregar Citados -->
<div class="modal fade" id="modalAgregarCitados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class='needs-validation novalidate'  method='POST'  enctype="multipart/form-data" name="AgregarRepresentante" id="AgregarRepresentante" action="{{route('insertar_citado')}}">
        @csrf
        <input type="hidden" name="id" value="{{$id}}">
        <input type="hidden" name="id_citado_2" id="id_citado_2" value="">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Representante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="name">Tipo de persona <span style="color:red;">(*)</span></label>
                                                <select name="tipoPersona" id="tipo_persona" class="form-control" required>
                                                    <option value="">Seleccione</option>
                                                    <option value="Fisica">Física</option>
                                                    <option value="Moral">Moral</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    El tipo de persona es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12" id="persona_fisica" style="display:none;">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <h4 class="text-center" style="color:#CEA845">Información Patronal</h4>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <h5 class="text-center">Datos de identificación</h5>
                                            </div>
                                        </div>
                                        <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">Nombre(s) del Empleador(a) <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="nombre_pF" id="nombre_pF" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El nombre es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">Primer apellido <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="primero_PF" id="primero_PF" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El primer apellido es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-4">
                                                    <div class="form-group">
                                                        <label for="name">Segundo apellido <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="segundo_Pf" id="segundo_Pf" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El segundo apellido es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">CURP <span style="color:red;">(*)</span></label>
                                                        <input type="text" class="form-control" aria-label="CURP" name="curp_PF" id="curp_PF" minlength="18" maxlength="18" oninput="this.value = this.value.toUpperCase()" >
                                                        <div class="invalid-feedback">
                                                            La CURP es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">RFC <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="RFC_pF" id="RFC_pF" class="form-control" minlength="13" maxlength="13" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El nombre es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="name">Sexo <span style="color:red;">(*)</span></label>
                                                        <select name="sexo_pf" id="sexo_pf" class="form-control">
                                                            <option value="">Seleccione</option>
                                                            <option value="Femenino">Femenino</option>
                                                            <option value="Masculino">Masculino</option>
                                                            <option value="Prefiero no responder">Prefiero no responder</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            El tipo de persona es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-9">
                                                    <div class="form-group">
                                                        <label for="name">Giro Comercial <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="giro_pF" id="giro_pF" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El nombre es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                   <div class="form-group">
                                                        <h5 class="text-center">Datos de contacto</h5>
                                                    </div>
                                                </div> 

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Correo electrónico <span style="color:red;">(*)</span></label>
                                                        <input type="email" class="form-control"  name="correo_pF" id="electrónico_pF" >
                                                        <div class="invalid-feedback">
                                                            El Correo electrónico es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Teléfono <span style="color:red;">(*)</span></label>
                                                            <input type="text" class="form-control"  name="telefono_PF" id="telefono_PF" maxlength="10" pattern="[0-9]+" >
                                                        <div class="invalid-feedback">
                                                            El telefono es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h5 class="text-center">Domicilio fiscal</h5>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Entidad Federativa <span style="color:red;">(*)</span></label>
                                                        <select id="estado_pF" class="form-control" name="estado_pF" placeholder="*Entidad Federativa" >
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
                                                        <label for="name">Nombre del Municipio o Alcaldía <span style="color:red;">(*)</span></label>
                                                        <select id="municipio_pF" class="form-control" name="municipio_pF" placeholder="*Municipio" >
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
                                                        <label for="name">Tipo de Vialidad <span style="color:red;">(*)</span></label>
                                                        <select name="vialidad_pF" id="vialidad_pF" class="form-control" placeholder="*Vialidad" >
                                                            <option value="">Seleccione</option>
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
                                                            <option value="PRIVADA">Privada</option>
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
                                                        <label for="name">Nombre de la Vialidad <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="vialidad_calle_pF" id="vialidad_calle_pF" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El campo vialidad o calle es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Colonia <span style="color:red;">(*)</span></label>
                                                        <input type="text" class="form-control" name="colonia_pF" id="colonia_pF" oninput="this.value = this.value.toUpperCase()" >
                                                        <div class="invalid-feedback">
                                                            La colonia es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Núm. Ext. <span style="color:red;">(*)</span></label>
                                                        <input type="text" class="form-control" placeholder="*Número exterior" name="num_ext_pF" id="num_ext_pF" oninput="this.value = this.value.toUpperCase()" >
                                                        <div class="invalid-feedback">
                                                            El Núm. ext. es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Núm. Int.</label>
                                                        <input type="text" class="form-control" placeholder="Número interior" name="num_int_pF"  oninput="this.value = this.value.toUpperCase()">
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Código Postal <span style="color:red;">(*)</span></label>
                                                        <input type="text" class="form-control" placeholder="*Código Postal" name="cp_pF" id="cp_pF" minlength="5" maxlength="5" oninput="this.value = this.value.toUpperCase()" >
                                                        <div class="invalid-feedback">
                                                            El código postal es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="name">¿Desea registrar Representante Legal? <span style="color:red;">(*)</span></label>
                                                        <select name="representate" id="representate" class="form-control">
                                                            <option value="">Seleccione</option>
                                                            <option value="Si">Si</option>
                                                            <option value="No">No</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            El tipo de persona es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12" id="Conrepresentante" style="display:none;">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h5 class="text-center" style="color:#CEA845">Información del Representante Legal</h5>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h5 class="text-center">Datos de identificación</h5>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Nombre(s) del representante <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="nombre_representante_pF" id="nombre_representante_pF" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El nombre es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Primer apellido <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="primer_representante_pF" id="primer_representante_pF" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El primer apellido es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Segundo apellido <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="segundo_representante_pF" id="segundo_representante_pF" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El segundo apellido es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>  
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">CURP</label>
                                                        <input type="text" class="form-control"  aria-label="CURP" name="curp_representante_pF" id="curp_representante_pF" minlength="18" maxlength="18" oninput="this.value = this.value.toUpperCase()" >
                                                        <div class="invalid-feedback">
                                                            La CURP es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Sexo <span style="color:red;">(*)</span></label>
                                                        <select name="sexo_representante_pF" id="sexo_representante_pF" class="form-control">
                                                            <option value="">Seleccione</option>
                                                            <option value="Femenino">Femenino</option>
                                                            <option value="Masculino">Masculino</option>
                                                            <option value="Prefiero no responder">Prefiero no responder</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            El tipo de persona es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                   <div class="form-group">
                                                        <h5 class="text-center">Datos de contacto</h5>
                                                    </div>
                                                </div> 

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Correo electrónico <span style="color:red;">(*)</span></label>
                                                        <input type="email" class="form-control" name="correo_representante_pF" id="correo_representante_pF" >
                                                        <div class="invalid-feedback">
                                                            El Correo electrónico es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Teléfono <span style="color:red;">(*)</span></label>
                                                        <input type="text" class="form-control"  name="telefono_representante_pF" id="telefono_representante_pF" maxlength="10" pattern="[0-9]+" >
                                                        <div class="invalid-feedback">
                                                            El telefono es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h5 class="text-center" style="color:#CEA845">Datos de la documentación que acredite la personeria</h5>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-4">  
                                                    <div class="form-group">
                                                        <label for="name">Tipo de documento <span style="color:red;">(*)</span></label>
                                                        <select name="tipo_documento_pF" id="tipo_documento_pF" class="form-control">
                                                            <option value="">Seleccione</option>
                                                            <option value="Carta Poder">Carta Poder</option>
                                                                <option value="Instrumento Notarial">Instrumento Notarial</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            El campo es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Fecha expedición <span style="color:red;">(*)</span></label>
                                                        <input type="date" class="form-control" aria-describedby="basic-addon1" name="fecha_expedicion_pF" id="fecha_expedicion_pF" >
                                                        <div class="invalid-feedback">
                                                            La fecha es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-2"><br><label for="btncheck1">Sin fecha de vigencia</label>
                                                    <input name="fecha_vigencia_pF" type="checkbox" class="btn-check" id="check_vigencia" autocomplete="off"/>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3" id="fecha_vigencia_pF">
                                                    <div class="form-group">
                                                        <label for="fecha_vigencia_pF">Fecha vigencia</label>
                                                        <input type="date" class="form-control" aria-describedby="basic-addon1" name="fecha_vigencia_pF" id="fecha_vigencia_pF" min="<?= date("Y-m-d") ?>" >
                                                        <div class="invalid-feedback">
                                                            La fecha es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>  
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Descripción del documento que acredite la personaria <span style="color:red;">(*)</span></label>
                                                        <textarea class="form-control" aria-describedby="basic-addon1" name="descripcion_pF" id="descripcion_pF" 
                                                        placeholder="Ejemplo: Carta poder simple de fecha___, firmada ante dos testigos, suscrita a favor del compareciente por el (C., Lic., Ing., etc.,)_____, en cuanto ___ de la moral citada, personalidad que acredite en terminos de___ número(45 Cuarenta y Cinco), de fecha___, pasada ante la fe del(Lic., Mtro., etc.,)___, Notario Público Número ___, del Estado de ____, y cuyas facultades no han sido revocadas ni mofificadas a la fecha."></textarea>
                                                        <div class="invalid-feedback">
                                                            La descripción es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h5 class="text-center" style="color:#CEA845">Cargar Documentos</h5>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label><span style="color:red;">*</span>Identificación del Empleador</label><br>
                                                        <input type="file" name="documentoIne_pF" id="documentoIne_pF" class="form-control" accept=".pdf" >
                                                        <div class="invalid-feedback">
                                                            La Identificación es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label><span style="color:red;">*</span>Identificación del Representante Legal</label><br>
                                                        <input type="file" name="documentoRepresentacion_pF" id="documentoRepresentacion_pF" class="form-control" accept=".pdf" >
                                                        <div class="invalid-feedback">
                                                            El documento de representación es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label><span style="color:red;">*</span>Documento que acredite la personería</label><br>
                                                        <input type="file" name="documentoPoder_pF" id="documentoPoder_pF" class="form-control" accept=".pdf">
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label>Anexo (Documentos Complementarios)</label><br>
                                                        <input type="file" name="documentoAnexo_pF" class="form-control" accept=".pdf">
                                                    </div>
                                                </div>
                                                 
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12" id="Sinrepresentante" style="display:none;">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <h5 class="text-center" style="color:#CEA845">Cargar Documentos</h5>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label><span style="color:red;">*</span>Identificación Oficial</label><br>
                                                        <input type="file" name="documentoIne_pFSR" id="documentoIne_pFSR" class="form-control" accept=".pdf" >
                                                        <div class="invalid-feedback">
                                                            La Identificación es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label>Anexo (Documentos Complementarios)</label><br>
                                                        <input type="file" name="documentoAnexo_pFSR" class="form-control" accept=".pdf">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-12 col-md-12" id="persona_moral" style="display:none;">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <h4 class="text-center" style="color:#CEA845">Información Patronal</h4>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <h5 class="text-center">Datos de identificación</h5>
                                            </div>
                                        </div>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label for="name">Razón Social <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="razon" id="razon" placeholder="Ejemplo: Patos Asados S.A. de C.V." class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El nombre es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">RFC <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="rfc_moral" id="rfc_moral" class="form-control" minlength="13" maxlength="13" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El nombre es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Giro Comercial <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="giro_moral" id="giro_moral" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El nombre es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h5 class="text-center">Domicilio fiscal</h5>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="password">Entidad Federativa <span style="color:red;">(*)</span></label>
                                                        <select id="estado_moral" class="form-control" name="estado_moral" placeholder="*Entidad Federativa" >
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
                                                        <label for="name">Nombre del Municipio o Alcaldía <span style="color:red;">(*)</span></label>
                                                        <select id="municipio_moral" class="form-control" name="municipio_moral" placeholder="*Municipio" >
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
                                                        <label for="name">Tipo de Vialidad <span style="color:red;">(*)</span></label>
                                                        <select name="vialidad_Moral" id="vialidad_Moral" class="form-control" placeholder="*Vialidad" >
                                                            <option value="">Seleccione</option>
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
                                                        <label for="name">Nombre de la Vialidad <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="vialidad_calleMoral" id="vialidad_calleMoral" class="form-control" placeholder="*Nombre vialidad" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El campo vialidad o calle es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Colonia <span style="color:red;">(*)</span></label>
                                                        <input type="text" class="form-control" name="colonia_moral" id="colonia_moral" oninput="this.value = this.value.toUpperCase()" >
                                                        <div class="invalid-feedback">
                                                            La colonia es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Núm. Ext. <span style="color:red;">(*)</span></label>
                                                        <input type="text" class="form-control" placeholder="*Número exterior" name="num_ext_moral" id="num_ext_moral" oninput="this.value = this.value.toUpperCase()" >
                                                        <div class="invalid-feedback">
                                                            El Núm. ext. es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Núm. Int.</label>
                                                        <input type="text" class="form-control" placeholder="Número interior" name="num_int" oninput="this.value = this.value.toUpperCase()">
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Código Postal <span style="color:red;">(*)</span></label>
                                                        <input type="text" class="form-control" name="cp_moral" id="cp_moral"  minlength="5" maxlength="5" oninput="this.value = this.value.toUpperCase()" >
                                                        <div class="invalid-feedback">
                                                            El código postal es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h5 class="text-center" style="color:#CEA845">Información del Representante Legal</h5>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h5 class="text-center">Datos de identificación</h5>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Nombre(s) del Representante Legal<span style="color:red;">(*)</span></label>
                                                        <input type="text" name="nombre_representante_Moral" id="nombre_representante_Moral" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El nombre es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Primer apellido <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="primer_Moral" id="primer_Moral" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El primer apellido es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Segundo apellido <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="segundo_Moral" id="segundo_Moral" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El segundo apellido es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>  
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">CURP</label>
                                                        <input type="text" class="form-control"  aria-label="CURP" name="curp_moral" id="curp_moral" minlength="18" maxlength="18" oninput="this.value = this.value.toUpperCase()" >
                                                        <div class="invalid-feedback">
                                                            La CURP es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Sexo <span style="color:red;">(*)</span></label>
                                                        <select name="sexo_Moral" id="sexo_Moral" class="form-control">
                                                            <option value="">Seleccione</option>
                                                            <option value="Femenino">Femenino</option>
                                                            <option value="Masculino">Masculino</option>
                                                            <option value="Prefiero no responder">Prefiero no responder</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            El tipo de persona es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                   <div class="form-group">
                                                        <h5 class="text-center">Datos de contacto</h5>
                                                    </div>
                                                </div> 

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Correo electrónico <span style="color:red;">(*)</label>
                                                        <input type="email" class="form-control" name="correo_Moral" id="correo_Moral" >
                                                        <div class="invalid-feedback">
                                                            El Correo electrónico es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Teléfono <span style="color:red;">(*)</label>
                                                        <input type="text" class="form-control" placeholder="*Telefono"  name="telefono_Moral" id="telefono_Moral" maxlength="10" pattern="[0-9]+" >
                                                        <div class="invalid-feedback">
                                                            El telefono es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h5 class="text-center" style="color:#CEA845">Datos de la documentación que acredite la personeria</h5>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-4">  
                                                    <div class="form-group">
                                                        <label for="name">Tipo de documento <span style="color:red;">(*)</span></label>
                                                        <select name="tipo_Moral" id="tipo_Moral" class="form-control">
                                                            <option value="">Seleccione</option>
                                                            <option value="Carta Poder">Carta Poder</option>
                                                                <option value="Instrumento Notarial">Instrumento Notarial</option>
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            El campo es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3">
                                                    <div class="form-group">
                                                        <label for="">Fecha expedición <span style="color:red;">(*)</span></label>
                                                        <input type="date" class="form-control" aria-describedby="basic-addon1" name="fecha_expedicicion_Moral" id="fecha_expedicicion_Moral" >
                                                        <div class="invalid-feedback">
                                                            La fecha es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-2"><br><label for="btncheck1">Sin fecha de vigencia</label>
                                                    <input name="fecha_vigencia_Moral" type="checkbox" class="btn-check" id="check_vigenciaM" autocomplete="off"/>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-3" id="fecha_vigencia_Moral">
                                                    <div class="form-group">
                                                        <label for="fecha_vigencia_Moral">Fecha vigencia</label>
                                                        <input type="date" class="form-control" aria-describedby="basic-addon1" name="fecha_vigencia_Moral" id="fecha_vigencia_Moral" min="<?= date("Y-m-d") ?>" >
                                                        <div class="invalid-feedback">
                                                            La fecha es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>   
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Descripción del documento que acredite la personaria <span style="color:red;">(*)</span></label>
                                                        <textarea class="form-control" aria-describedby="basic-addon1" name="descripcion_Moral"  id="descripcion_Moral" 
                                                        placeholder="Ejemplo: Carta poder simple de fecha___, firmada ante dos testigos, suscrita a favor del compareciente por el (C., Lic., Ing., etc.,)_____, en cuanto ___ de la moral citada, personalidad que acredite en terminos de___ número(45 Cuarenta y Cinco), de fecha___, pasada ante la fe del(Lic., Mtro., etc.,)___, Notario Público Número ___, del Estado de ____, y cuyas facultades no han sido revocadas ni mofificadas a la fecha."></textarea>
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
                                                        <label><span style="color:red;">*</span>Acta Constitutiva</label><br>
                                                        <input type="file" name="documentoIne_Moral" id="documentoIne_Moral" class="form-control" accept=".pdf" >
                                                        <div class="invalid-feedback">
                                                            La Identificación es obligatoria.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label><span style="color:red;">*</span>Identificación del Representante Legal</label><br>
                                                        <input type="file" name="documentoRepresentacion_Moral" id="documentoRepresentacion_Moral" class="form-control" accept=".pdf" >
                                                        <div class="invalid-feedback">
                                                            El documento de representación es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label><span style="color:red;">*</span>Documento que acredite la personería</label><br>
                                                        <input type="file" name="documentoPoder" id="documentoPoder" class="form-control" accept=".pdf">
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label>Anexo (Documentos Complementarios)</label><br>
                                                        <input type="file" name="documentoAnexo" class="form-control" accept=".pdf">
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
<div class="modal fade" id="ModalArchivar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class='needs-validation novalidate'  method='POST' action="{{route('archivar_audiencia')}}">
        @csrf
        <input type="hidden" id="modal-id-archivar" name="id" value="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Motivo del archivo de audiencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea name="observaciones" style="width:100%"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="ModalReagendar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class='needs-validation novalidate'  method='POST' action="{{route('reagendar_audiencia')}}">
        @csrf
        <input type="hidden" id="modal-id-reagendar" name="id" value="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Fecha de la reagenda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="date" class="form-control" name="fecha">
                    <input type="time" class="form-control" name="hora">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="ModalIncopentencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class='needs-validation novalidate'  method='POST' action="{{route('incopentencia_audiencia')}}">
        @csrf
        <input type="hidden" id="modal-id-incopentencia" name="id" value="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Motivo de Incompetencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea name="observaciones" style="width:100%"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="ModalTerminar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    {{ $bandera = 0; }}
    @foreach($representantes as $representante)
        @if($representante->id_abogado == null && $representante->id_fisica == null)
            {{ $bandera = 1; }}
        @endif        
    @endforeach
    {{$bandera;}}

    @if($representantes[$contador-1]->notificacion == "Centro")
        <div class="modal-dialog modal-l">
            <div class="modal-content">
                <div class="modal-header">
                    @if($bandera != 0)
                        Se multará a los citados que no tengan un representante asignado.
                    @else
                        Continuar con la audiencia.
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form class="needs-validation novalidate" method="POST" action="{{route('audiencia_parte2')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$id}}">
                        <input type="hidden" name="bandera" value="{{$bandera}}">
                        <button type="submit" class="btn btn-success">Continuar</button>
                    </form>                    
                </div>
            </div>
        </div>
    @else
        <div class="modal-dialog">
            <div class="modal-content modal-xl">
                <div class="modal-header">
                    @if($bandera != 0)
                        <span>Si no seleccionas todos los representantes debes seleccionar una fecha para que próxima audiencia.<br>
                        Notificará el centro</span>
                        <input type="date" name="fecha" class="form-control">
                    @else
                        Continuar con la audiencia.
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <form class="needs-validation novalidate" method="POST" action="{{route('audiencia_parte2')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$id}}">
                        <input type="hidden" name="bandera" value="{{$bandera}}">
                        <button type="submit" class="btn btn-success">Continuar</button>
                    </form> 
                </div>
            </div>
        </div>
    @endif
</div>
<div class="modal fade" id="modalAgregarDerecho" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class='needs-validation' novalidate method='POST' enctype="multipart/form-data" name="AgregarPersonaFisica" id="AgregarPersonaFisica" action="{{route('insertar_citado_PF')}}">
        @csrf
        <input type="hidden" name="id" value="{{$id}}">
        <input type="hidden" name="id_citado_pf" id="id_citado_pf" value="">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Persona Física</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Nombre del citado <span style="color:red;">(*)</span></label>
                                <input type="text" name="nombre" class="form-control" oninput="this.value = this.value.toUpperCase()" required>
                                <div class="invalid-feedback">
                                    La Identificación es obligatoria.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Primer apellido <span style="color:red;">(*)</span></label>
                                <input type="text" name="primer_apellido" class="form-control" oninput="this.value = this.value.toUpperCase()" required>
                                <div class="invalid-feedback">
                                    La Identificación es obligatoria.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Segundo apellido <span style="color:red;">(*)</span></label>
                                <input type="text" name="segundo_apellido" class="form-control" oninput="this.value = this.value.toUpperCase()" required>
                                <div class="invalid-feedback">
                                    La Identificación es obligatoria.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="name">Tipo de identificación <span style="color:red;">(*)</span></label>
                                <select name="identificacionAlta" class="form-control" required>
                                    <option value="">SELECCIONE</option>
                                    <option value="Credencial de elector">CREDENCIAL DE ELECTOR</option>
                                    <option value="Pasaporte">PASAPORTE</option>
                                    <option value="Cédula profesional">CÉDULA PROFESIONAL</option>
                                    <option value="Licencia de conducir">LICENCIA DE CONDUCIR</option>
                                    <option value="Credencial de inapam">CREDENCIAL DE INAPAM</option>
                                    <option value="Cartilla militar">CARTILLA MILITAR</option>
                                    <option value="Documento migratorio">DOCUMENTO MIGRATORIO</option>
                                    <option value="Constancia de identidad">CONSTANCIA DE IDENTIDAD</option>
                                    <option value="Otro">OTROS</option>
                                </select>
                                <div class="invalid-feedback">
                                    El tipo de identificaión es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Subir Identificación oficial <span style="color:red;">(*)</span></label>
                                <input type="file" name="documentoIdentificacion" class="form-control" accept=".pdf" required>
                                <div class="invalid-feedback">
                                    La Identificación es obligatoria.
                                </div>
                            </div>
                        </div>

                        <div>
                            <input type="hidden" name="id_usuario_registro" value="{{ Auth::id() }}">
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
<div class="modal fade" id="modalActualizaCitados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class='needs-validation novalidate'  method='POST' name="AgregarPersonaFisica" id="AgregarPersonaFisica" action="{{route('actualiza_citados')}}">
        @csrf
        <input type="hidden" name="id" value="{{$id}}">
        <input type="hidden" name="id_citado_pf" id="modal-id-citado" value="">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar Citado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Nombre del citado</label>
                                <input type="text" name="nombre" class="form-control" required>
                                <div class="invalid-feedback">
                                    La Identificación es obligatoria.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Primer apellido</label>
                                <input type="text" name="primer_apellido" class="form-control" required>
                                <div class="invalid-feedback">
                                    La Identificación es obligatoria.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Segudno apellido</label>
                                <input type="text" name="segundo_apellido" class="form-control" required>
                                <div class="invalid-feedback">
                                    La Identificación es obligatoria.
                                </div>
                            </div>
                        </div>

                        <div>
                            <input type="hidden" name="id_usuario_registro" value="{{ Auth::id() }}">
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

<div id="nuevo_poder" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>

@section('scripts')
    <script>
         $('.open-modal').click(function() {
            const id = $(this).data('id'); // Obtiene el valor de data-id

            document.getElementById('modal-id').value = id;
            document.getElementById('modal-id-reagendar').value = id;
            document.getElementById('id_citado_2').value = id;
            document.getElementById('id_citado_pf').value = id;
            document.getElementById('modal-id-archivar').value = id;
            document.getElementById('modal-id-reagendar').value = id;
            document.getElementById('modal-id-incopentencia').value = id;
            document.getElementById('modal-id-citado').value = id;
        });

        document.getElementById('tipo_persona').addEventListener('change', function() {
            var selectTipo = document.getElementById('tipo_persona');
            const nombreDiv = document.getElementById('persona_fisica');
            const empresaDiv = document.getElementById('persona_moral');
            
            function actualizarTipoPersona() {
                const valor = selectTipo.value;

                // Oculta ambos inicialmente
                nombreDiv.style.display = 'none';
                empresaDiv.style.display = 'none';

                if (valor === 'Fisica') {
                    nombreDiv.style.display = 'block';
                    empresaDiv.style.display = 'none';
                    //Poner los campos requeridos
                    document.getElementById('nombre_pF').setAttribute('required', 'true');
                    document.getElementById('primero_PF').setAttribute('required', 'true');
                    document.getElementById('segundo_Pf').setAttribute('required', 'true');
                    document.getElementById('curp_PF').setAttribute('required', 'true');
                    document.getElementById('RFC_pF').setAttribute('required', 'true');
                    document.getElementById('sexo_pf').setAttribute('required', 'true');
                    document.getElementById('giro_pF').setAttribute('required', 'true');
                    document.getElementById('electrónico_pF').setAttribute('required', 'true');
                    document.getElementById('telefono_PF').setAttribute('required', 'true');
                    document.getElementById('estado_pF').setAttribute('required', 'true');
                    document.getElementById('municipio_pF').setAttribute('required', 'true');
                    document.getElementById('vialidad_pF').setAttribute('required', 'true');
                    document.getElementById('vialidad_calle_pF').setAttribute('required', 'true');
                    document.getElementById('colonia_pF').setAttribute('required', 'true');
                    document.getElementById('num_ext_pF').setAttribute('required', 'true');
                    document.getElementById('cp_pF').setAttribute('required', 'true');
                    //Quitar los campos requeridos
                    document.getElementById('razon').removeAttribute('required');
                    document.getElementById('rfc_moral').removeAttribute('required');
                    document.getElementById('giro_moral').removeAttribute('required');
                    document.getElementById('estado_moral').removeAttribute('required');
                    document.getElementById('municipio_moral').removeAttribute('required');
                    document.getElementById('vialidad_Moral').removeAttribute('required');
                    document.getElementById('vialidad_calleMoral').removeAttribute('required');
                    document.getElementById('colonia_moral').removeAttribute('required');
                    document.getElementById('num_ext_moral').removeAttribute('required');
                    document.getElementById('cp_moral').removeAttribute('required');
                    document.getElementById('nombre_representante_Moral').removeAttribute('required');
                    document.getElementById('primer_Moral').removeAttribute('required');
                    document.getElementById('segundo_Moral').removeAttribute('required');
                    document.getElementById('curp_moral').removeAttribute('required');
                    document.getElementById('sexo_Moral').removeAttribute('required');
                    document.getElementById('correo_Moral').removeAttribute('required');
                    document.getElementById('telefono_Moral').removeAttribute('required');
                    document.getElementById('tipo_Moral').removeAttribute('required');
                    document.getElementById('fecha_expedicicion_Moral').removeAttribute('required');
                    document.getElementById('fecha_vigencia_Moral').removeAttribute('required');
                    document.getElementById('descripcion_Moral').removeAttribute('required');
                    document.getElementById('documentoIne_Moral').removeAttribute('required');
                    document.getElementById('documentoRepresentacion_Moral').removeAttribute('required');
                    document.getElementById('documentoPoder').removeAttribute('required');

                } else if (valor === 'Moral') {
                    empresaDiv.style.display = 'block';
                    nombreDiv.style.display = 'none';
                    //Las personas fisicas quitar requerido
                    document.getElementById('nombre_pF').removeAttribute('required');
                    document.getElementById('nombre_pF').removeAttribute('required');
                    document.getElementById('primero_PF').removeAttribute('required');
                    document.getElementById('segundo_Pf').removeAttribute('required');
                    document.getElementById('curp_PF').removeAttribute('required');
                    document.getElementById('RFC_pF').removeAttribute('required');
                    document.getElementById('sexo_pf').removeAttribute('required');
                    document.getElementById('giro_pF').removeAttribute('required');
                    document.getElementById('electrónico_pF').removeAttribute('required');
                    document.getElementById('telefono_PF').removeAttribute('required');
                    document.getElementById('estado_pF').removeAttribute('required');
                    document.getElementById('municipio_pF').removeAttribute('required');
                    document.getElementById('vialidad_pF').removeAttribute('required');
                    document.getElementById('vialidad_calle_pF').removeAttribute('required');
                    document.getElementById('colonia_pF').removeAttribute('required');
                    document.getElementById('num_ext_pF').removeAttribute('required');
                    document.getElementById('cp_pF').removeAttribute('required');
                    //Poner los campos requeridos
                    document.getElementById('razon').setAttribute('required', 'true');
                    document.getElementById('rfc_moral').setAttribute('required', 'true');
                    document.getElementById('giro_moral').setAttribute('required', 'true');
                    document.getElementById('estado_moral').setAttribute('required', 'true');
                    document.getElementById('municipio_moral').setAttribute('required', 'true');
                    document.getElementById('vialidad_Moral').setAttribute('required', 'true');
                    document.getElementById('vialidad_calleMoral').setAttribute('required', 'true');
                    document.getElementById('colonia_moral').setAttribute('required', 'true');
                    document.getElementById('num_ext_moral').setAttribute('required', 'true');
                    document.getElementById('cp_moral').setAttribute('required', 'true');
                    document.getElementById('nombre_representante_Moral').setAttribute('required', 'true');
                    document.getElementById('primer_Moral').setAttribute('required', 'true');
                    document.getElementById('segundo_Moral').setAttribute('required', 'true');
                    document.getElementById('curp_moral').setAttribute('required', 'true');
                    document.getElementById('sexo_Moral').setAttribute('required', 'true');
                    document.getElementById('correo_Moral').setAttribute('required', 'true');
                    document.getElementById('telefono_Moral').setAttribute('required', 'true');
                    document.getElementById('tipo_Moral').setAttribute('required', 'true');
                    document.getElementById('fecha_expedicicion_Moral').setAttribute('required', 'true');
                    //document.getElementById('fecha_vigencia_Moral').setAttribute('required', 'true');
                    document.getElementById('descripcion_Moral').setAttribute('required', 'true');
                    document.getElementById('documentoIne_Moral').setAttribute('required', 'true');
                    document.getElementById('documentoRepresentacion_Moral').setAttribute('required', 'true');
                    document.getElementById('documentoPoder').setAttribute('required', 'true');

                    
                }
            }

            if (selectTipo) {
                selectTipo.addEventListener('change', actualizarTipoPersona);
                // Ejecutar al cargar por si ya tiene valor
                actualizarTipoPersona();
            }
        });
        document.getElementById('representate').addEventListener('change', function() {
            var reprecentante = document.getElementById('representate');
            const razonDiv = document.getElementById('Conrepresentante');
            const propioDiv = document.getElementById('Sinrepresentante');

            function actualizarRepresentante() {
                const valor = reprecentante.value;

                // Oculta ambos inicialmente
                razonDiv.style.display = 'none';
                propioDiv.style.display = 'none';

                if (valor === 'Si') {
                    razonDiv.style.display = 'block';
                    propioDiv.style.display = 'none';
                    //Poner requeridos los campos
                    document.getElementById('nombre_representante_pF').setAttribute('required', 'true');
                    document.getElementById('primer_representante_pF').setAttribute('required', 'true');
                    document.getElementById('segundo_representante_pF').setAttribute('required', 'true');
                    document.getElementById('curp_representante_pF').setAttribute('required', 'true');
                    document.getElementById('sexo_representante_pF').setAttribute('required', 'true');
                    document.getElementById('correo_representante_pF').setAttribute('required', 'true');
                    document.getElementById('telefono_representante_pF').setAttribute('required', 'true');
                    document.getElementById('tipo_documento_pF').setAttribute('required', 'true');
                    document.getElementById('fecha_expedicion_pF').setAttribute('required', 'true');
                    //document.getElementById('fecha_vigencia_pF').setAttribute('required', 'true');
                    document.getElementById('descripcion_pF').setAttribute('required', 'true');
                    document.getElementById('documentoIne_pF').setAttribute('required', 'true');
                    document.getElementById('documentoRepresentacion_pF').setAttribute('required', 'true');
                    document.getElementById('documentoPoder_pF').setAttribute('required', 'true');              
                    //Quitar requeridos los campos
                    document.getElementById('documentoIne_pFSR').removeAttribute('required');

                } else if (valor === 'No') {
                    razonDiv.style.display = 'none';
                    propioDiv.style.display = 'block';
                    //Poner requeridos los campos
                    document.getElementById('documentoIne_pFSR').setAttribute('required', 'true');
                    //Poner requeridos los campos
                    document.getElementById('nombre_representante_pF').removeAttribute('required');
                    document.getElementById('primer_representante_pF').removeAttribute('required');
                    document.getElementById('segundo_representante_pF').removeAttribute('required');
                    document.getElementById('curp_representante_pF').removeAttribute('required');
                    document.getElementById('sexo_representante_pF').removeAttribute('required');
                    document.getElementById('correo_representante_pF').removeAttribute('required');
                    document.getElementById('telefono_representante_pF').removeAttribute('required');
                    document.getElementById('tipo_documento_pF').removeAttribute('required');
                    document.getElementById('fecha_expedicion_pF').removeAttribute('required');
                    document.getElementById('fecha_vigencia_pF').removeAttribute('required');
                    document.getElementById('descripcion_pF').removeAttribute('required');
                    document.getElementById('documentoIne_pF').removeAttribute('required');
                    document.getElementById('documentoRepresentacion_pF').removeAttribute('required');
                    document.getElementById('documentoPoder_pF').removeAttribute('required'); 
                }
            }

            if (reprecentante) {
                reprecentante.addEventListener('change', actualizarRepresentante);
                // Ejecutar al cargar por si ya tiene valor
                actualizarRepresentante();
            }
        });

         //PERSONA FÍSICA
        document.getElementById("fecha_vigencia_pF").style.display = "block";
        $(function(){
            $('#check_vigencia').on('change', validarcheckvigencia);
        })
        function validarcheckvigencia(){
            vigencia = document.getElementById("fecha_vigencia_pF").style.display;
            if (vigencia == "none") {
                document.getElementById("fecha_vigencia_pF").style.display = "block";
            }
            else{
                document.getElementById("fecha_vigencia_pF").style.display = "none";
            }
        }

        //PERSONA MORAL
        document.getElementById("fecha_vigencia_Moral").style.display = "block";
        $(function(){
            $('#check_vigenciaM').on('change', validarcheckvigenciaM);
        })
        function validarcheckvigenciaM(){
            vigenciaM = document.getElementById("fecha_vigencia_Moral").style.display;
            if (vigenciaM == "none") {
                document.getElementById("fecha_vigencia_Moral").style.display = "block";
            }
            else{
                document.getElementById("fecha_vigencia_Moral").style.display = "none";
            }
        }
    </script>
    <script src="../../public/assets/js/validaciones.js"></script> 
    <script src="../../public/assets/js/poderes/general.js"></script>
@endsection