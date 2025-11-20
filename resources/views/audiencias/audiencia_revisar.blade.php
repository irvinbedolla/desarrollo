@extends('layouts.app_editar')
@php
    $fechaActual = date('Y-m-d');
    $contador = 0;
@endphp
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Audiencia Vista Previa</h3>
        </div>
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Correcto</strong>
                {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
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
                                            <th style="color: #ffff;">Convenio</th>
                                            <th style="color: #ffff;">Acciones</th>
                                            <th style="color: #ffff;"></th>
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
                                                    <input type="checkbox" name="aparece_convenio[{{ $representante->id }}]" value="1" {{ $representante->aparece_convenio == 1 ? 'checked' : '' }}>
                                                </td>

                                                <td><button type="button" class="btn btn-primary open-modal" data-id="{{ $representante->id }}" data-bs-toggle="modal" data-bs-target="#modalCitados"> Citado </button></td>
                                                <td>
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
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <h4 class="text-center">Concepto de Pago</h4>
                                </div>
                            </div>
                            <table class="table table-striped mt-1">
                                            <thead style="background-color: #4A001F;">
                                                <tr> 
                                                    <th style="display:none">ID</th>
                                                    <th style="color: #ffff;">Tipo pago</th>
                                                    <th style="color: #ffff;">Monto</th>
                                                    <th style="color: #ffff;">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($conceptos as $concepto)
                                                    <tr>
                                                    <td  style="display:none">{{$concepto->id}}</td>
                                                        <td>{{ $concepto->descripcion}}</td>
                                                        <td>${{ number_format($concepto->monto,2) }}</td>
                                                        <td>
                                                            <form method="POST" action="{{ route('concepto_eliminar_pago_ratificacion', $concepto->id) }} ">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button class="btn btn-danger" onclick=editar_rol(); type="submit">Eliminar</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @php $contador++; @endphp
                                                @endforeach       
                                            </tbody> 
                            </table>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <h4 class="text-center">Deducciones</h4>
                                </div>
                            </div>
                            <table class="table table-striped mt-1">
                                            <thead style="background-color: #4A001F;">
                                                <tr> 
                                                    <th style="display:none">ID</th>
                                                    <th style="color: #ffff;">Tipo pago</th>
                                                    <th style="color: #ffff;">Monto</th>
                                                    <th style="color: #ffff;">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($deducciones as $concepto)
                                                    <tr>
                                                    <td  style="display:none">{{$concepto->id}}</td>
                                                        <td>{{ $concepto->descripcion}}</td>
                                                        <td>${{ number_format($concepto->monto,2) }}</td>
                                                        <td>
                                                            <form method="POST" action="{{ route('concepto_eliminar_deduccion_ratificacion', $concepto->id) }} ">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button class="btn btn-danger" onclick=editar_rol(); type="submit">Eliminar</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @php $contador++; @endphp
                                                @endforeach       
                                            </tbody> 
                            </table>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <h4 class="text-center">Pagos</h4>
                                    </div>
                                </div>
                            <table class="table table-striped mt-1">
                                            <thead style="background-color: #4A001F;">
                                                <tr> 
                                                    <th style="display:none">ID</th>
                                                    <th style="color: #ffff;">Fecha y Hora</th>
                                                    <th style="color: #ffff;">Descripción</th>
                                                    <th style="color: #ffff;">Monto</th>
                                                    <th style="color: #ffff;">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pagos as $pago)
                                                    <tr>
                                                        <td  style="display:none">{{$pago->id}}</td>
                                                        <td>{{ $pago->hora }}</td>
                                                        <td>{{ $pago->descripcion}}</td>
                                                        <td>${{ number_format($pago->monto,2) }}</td>
                                                        <td>
                                                            <form method="POST" action="{{ route('pago_eliminar_pago', $pago->id) }} ">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button class="btn btn-danger" onclick=editar_rol(); type="submit">Eliminar</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @php $contador++; @endphp
                                                @endforeach       
                                            </tbody> 
                            </table>
                            <form class='needs-validation novalidate' id='form_roles' method='POST' action="{{route('terminar_audiencia')}}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12"  style="border:1px solid black;">
                                        <div class="form-group">
                                            <label for="name">PRIMERA MANIFESTACIÓN DE LAS PARTES</label>
                                            <textarea name="primera" class="form-control"> {{$conciliadores->resolicion_primera}}</textarea>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div id="justificacion"><br>
                                        <div class="col-xs-12 col-sm-12 col-md-12" style="border:1px solid black;">
                                            <div class="form-group">
                                                <label for="name">PROPUESTA DE CONVENIO CONCILIATORIO</label>
                                                <textarea name="justificacion" class="form-control" >{{$conciliadores->resolicion_justificacion}}</textarea>
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div id="segunda" ><br>
                                        <div class="col-xs-12 col-sm-12 col-md-12" style="border:1px solid black;">
                                            <div class="form-group">
                                                <label for="name">SEGUNDA MANIFESTACIÓN DE LAS PARTES</label>
                                                <textarea name="segunda" class="form-control" >{{$conciliadores->resolicion_segunda}}</textarea>
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6"><br>
                                            <label for="name">Final de la audiencia</label>
                                            <select id="conclucion" name="conclucion" class="form-control">
                                                <option>Seleccione</option>
                                                <option value="Conciliacion" {{ $conciliadores["conclucion"] == "Conciliacion" ? "selected" : '' }}>Hubo Convenio</option>
                                                <option value="No conciliacion" {{ $conciliadores["conclucion"] == "No conciliacion" ? "selected" : '' }}>No hubo Convenio</option>
                                                <option value="Archivada por incomparecencia" {{ $conciliadores["conclucion"] == "Archivada por incomparecencia" ? "selected" : '' }}>Archivar</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="dias" class="row home-shape">
                                        <div class="col-xs-12 col-sm-12 col-md-2"><br>
                                            <div class="form-group">
                                                <label for="name">Días de vacaciones</label>
                                                <input type="number" name="vacaciones" class="form-control" value="{{ $conciliadores["vacaciones"] }}"> 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-2"><br>
                                            <div class="form-group">
                                                <label for="name">Días de Aguinaldo</label>
                                                <input type="number" name="aguinaldo" class="form-control" value="{{ $conciliadores["aguinaldo"] }}"> 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-2"><br>
                                            <div class="form-group">
                                                <label for="name">Otros</label>
                                                <input type="text" name="otros" class="form-control" value="{{ $conciliadores["otros"] }}"> 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3"><br>
                                            <div class="form-group">
                                                <label for="name">Horario laboral</label>
                                                <input type="text" name="horario" class="form-control" value="{{ $conciliadores["horario"] }}"> 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3"><br>
                                            <div class="form-group">
                                                <label for="name">Horario de comida</label>
                                                <input type="text" name="comida" class="form-control" value="{{ $conciliadores["comida"] }}"> 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="pagos" class="row home-shape">
                                        <div class="col-xs-12 col-sm-12 col-md-12"></div>
                                        <div class="col-xs-12 col-sm-6 col-md-12">
                                            <button id="addRow" type="button" class="btn btn-info">Agregar Concepto de Pago</button>
                                        </div>                                        
                                        <div id="newRow"></div>
                                       
                                        <div class="col-xs-12 col-sm-6 col-md-12"><br>
                                            <button id="addRetencion" type="button" class="btn btn-info">Agregar Deducción</button>
                                        </div>
                                        
                                        <div id="newRowDeduccion"></div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div id="div_pagos_diferidos1"><br>
                                                <button id="addPago" type="button" class="btn btn-info">Agregar Pago</button>
                                                <div id="newRowaPago"></div>
                                            </div>
                                        </div>
                                       
                                        <div id="div_pagos_diferidos"></div>
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-12 col-md-6"><br>
                                                    <label for="name">Tipo de audiencia</label>
                                                    <select name="tipo_audiencia" class="form-control">
                                                        <option>Seleccione</option>
                                                        <option value="Presencial" {{ $conciliadores["tipo_audiencia"] == "Presencial" ? "selected" : '' }}>Presencial</option>
                                                        <option value="Virtual" {{ $conciliadores["tipo_audiencia"] == "Virtual" ? "selected" : '' }}>Virtual</option>
                                                    </select>
                                                </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <br><button id="btn-terminar" type="submit" class="btn btn-success">Terminar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<!-- Modal Solicitantes -->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class='needs-validation novalidate'  method='POST' action="{{route('editar_solicitud_audiencia')}}">
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
                                <label for="name">Nombre(s) y Apellidos del Solicitante (*) </label>
                                <input type="text" name="nombre" class="form-control" oninput="this.value = this.value.toUpperCase()" value="<?=$solicitante["nombre"];?>" required> 
                                <div class="invalid-feedback">
                                    El campo nombre es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">CURP del Solicitante (*)</label>
                                <input type="text" name="curp" id="curp_input" oninput="validarInput(this)"class="form-control" value="<?=$solicitante["curp"];?>" required> 
                                <pre id="resultado"></pre>
                                <div class="invalid-feedback">
                                    El campo curp es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">RFC del Solicitante (*)</label>
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
                                <label for="name">Puesto (*)</label>
                                <input type="text" class="form-control" name="puesto" value="<?=$solicitante["puesto"];?>" oninput="this.value = this.value.toUpperCase()" required> 
                                <div class="invalid-feedback">
                                    El campo puesto es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">Frecuencia de Pago (*)</label>
                                <select name="periodo_pago" class="form-control" value="<?=$solicitante["periodo_pago"];?>" required>
                                    <option value="">SELECCIONE</option>
                                    <option value="Diario" {{ $solicitante['periodo_pago'] == 'Diario' ? "selected" : '' }}>DIARIO</option>
                                    <option value="Semana" {{ $solicitante['periodo_pago'] == 'Semana' ? "selected" : '' }}>SEMANAL</option>
                                    <option value="Quincenal" {{ $solicitante['periodo_pago'] == 'Quincenal' ? "selected" : '' }}>QUINCENAL</option>
                                    <option value="Mensual" {{ $solicitante['periodo_pago'] == 'Mensual' ? "selected" : '' }}>MENSUAL</option>
                                </select>
                                <div class="invalid-feedback">
                                    El campo frecuencia de pagos es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">Salario (*)</label>
                                <input type="text" name="pago" class="form-control" value="<?=$solicitante["pago"];?>" required> 
                                <div class="invalid-feedback">
                                    El campo salario es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">Cantidad total de horas trabajadas por semana (*)</label>
                                <input type="number" name="horas" class="form-control" value="<?=$solicitante["horas_semana"];?>" required> 
                                <div class="invalid-feedback">
                                    El campo cantidad de horas trabajadas es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="check_fecha">¿Laboras actualmente?</label>
                                <input type="checkbox" id="check_fecha" name="labora" {{ $solicitante['labora'] == 'Si' ? 'checked' : '' }} />
                            </div>  
                        </div>    
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">Fecha de Ingreso (*)</label>
                                <input type="date" name="fecha_ingreso" class="form-control" value="<?=$solicitante["fecha_ingreso"];?>" required> 
                                <div class="invalid-feedback">
                                    El campo fecha de ingreso es obligatoria.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">Jornada (*)</label>
                                <select name="jornada" class="form-control" value="<?=$solicitante["jornada"];?>" required>
                                    <option value="">SELECCIONE</option>
                                    <option value="Diurna" {{ $solicitante['jornada'] == 'Diurna' ? "selected" : '' }}>DIURNA</option>
                                    <option value="Nocturna" {{ $solicitante['jornada'] == 'Nocturna' ? "selected" : '' }}>NOCTURNA</option>
                                    <option value="Mixta" {{ $solicitante['jornada'] == 'Mixta' ? "selected" : '' }}>MIXTA</option>
                                </select>
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
                <h5 class="modal-title" id="exampleModalLabel">Representante Legales</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <form method="POST" action="{{ route('seleccionar_abogado_audiencia') }} ">
                    @csrf
                    <input type="hidden" id="modal-id" name="citado" value="">
                    <input type="hidden" name="solicitud" value="{{$solicitud->id}}">
                    <table id="tabla1" class="table-striped" style="width:100%">
                        <thead style="background-color: #4A001F;">   
                            <!--<th style="display: none;">ID</th>-->
                            <th style="color: #fff;">Folio</th>
                            <th style="color: #fff;">Nombre</th>
                            <th style="color: #fff;">RFC</th>
                            <th style="color: #fff;">Empresa</th>
                            <th style="color: #fff;">Acciones</th>
                        </thead>
                        <tbody class="contenidobusqueda">
                            @foreach($abogados as $abogado)
                                <tr>
                                    <td>{{$abogado->idAbogado}}</td>
                                    <td>{{$abogado->nombres}} {{$abogado->primer_apellido}} {{$abogado->segundo_apellido}}</td>
                                    <td>{{$abogado->rfc}}</td>
                                    <td>{{$abogado->empresa}}</td>
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
    <form class='needs-validation novalidate'  method='POST'  enctype="multipart/form-data" name="AgregarRepresentante" id="AgregarRepresentante" action="{{route('insertar_citados_audiencia')}}">
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
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <h4 class="text-center">Datos del representante</h4>
                            </div>
                        </div>  
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
                                <input type="text" class="form-control" placeholder="*Apellidos" name="primer_apellido" id="primer_apellido" oninput="this.value = this.value.toUpperCase()" required>
                                <div class="invalid-feedback">
                                    El primer apellido es obligatorio.
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="">Segundo Apellido</label>
                                <input type="text" class="form-control" placeholder="*Apellidos" name="segundo_apellido" id="segundo_apellido" oninput="this.value = this.value.toUpperCase()" required>
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
                                <h4 class="text-center">Datos de la empresa</h4>
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

                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="password">Entidad Federativa</label>
                                <select id="estado_poder" class="form-control" name="estado_poder" placeholder="*Entidad Federativa" required>
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
                                <select id="municipio_poder" class="form-control" name="municipio_poder" placeholder="*Municipio" required>
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
                                <select name="vialidadPoder" id="vialidadPoder" class="form-control" placeholder="*Vialidad" required>
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
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="name">Nombre de la Vialidad (*)</label>
                                <input type="text" name="vialidad_callePoder" id="vialidad_callePoder" class="form-control" placeholder="*Nombre vialidad" oninput="this.value = this.value.toUpperCase()" required> 
                                <div class="invalid-feedback">
                                    El campo vialidad o calle es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="">Colonia</label>
                                <input type="text" class="form-control" placeholder="*Colonia" name="coloniaAbogadoAlta" id="coloniaAbogadoAlta" oninput="this.value = this.value.toUpperCase()" required>
                                <div class="invalid-feedback">
                                    El domicilio es obligatoria.
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-3">
                            <div class="form-group">
                                <label for="">Núm. Ext.</label>
                                <input type="text" class="form-control" placeholder="*Número exterior" name="NExtAbogadoAlta" id="NExtAbogadoAlta" oninput="this.value = this.value.toUpperCase()" required>
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
                                <input type="text" class="form-control" placeholder="*Código postal" name="cpAbogadoAlta" id="cpAbogadoAlta" oninput="this.value = this.value.toUpperCase()" required>
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
                                <label for="">Industria</label>
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

                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>*Identificación oficial</label><br>
                                <input type="file" name="documentoIne" class="form-control" accept=".pdf">
                                <div class="invalid-feedback">
                                    La Identificación es obligatoria.
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>*Documento que acredite la representación</label><br>
                                <input type="file" name="documentoRepresentacion" class="form-control" accept=".pdf">
                                <div class="invalid-feedback">
                                    El documento de representación es obligatorio.
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Anexos</label><br>
                                <input type="file" name="documentoAnexo" class="form-control" accept=".pdf">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Anexos 2</label><br>
                                <input type="file" name="documentoPoder" class="form-control" accept=".pdf">
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
<div class="modal fade" id="modalAgregarDerecho" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class='needs-validation novalidate'  method='POST' enctype="multipart/form-data" name="AgregarPersonaFisica" id="AgregarPersonaFisica" action="{{route('insertar_citado_PF')}}">
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
                                <label>Segundo apellido</label>
                                <input type="text" name="segundo_apellido" class="form-control" required>
                                <div class="invalid-feedback">
                                    La Identificación es obligatoria.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="name">Tipo de identificación (*)</label>
                                <select name="identificacionAlta" class="form-control" required>
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
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Identificación oficial</label>
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
    <form class='needs-validation novalidate'  method='POST' name="AgregarPersonaFisica" id="AgregarPersonaFisica" action="{{route('actualiza_citados_audiencia')}}">
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

        $( document ).ready(function() {
            // Agregar registro
            $("#addRow").click(function () {
                var html = '';
                html += '<div id="inputFormRow1" class="col-xs-12 col-sm-6 col-md-12">';

                // Tipo de pago
                html +='<div class="col-xs-12 col-sm-12 col-md-12">';
                    html +='<div class="form-group">';
                    html +='<label for="confirm-password"><br>Prestación</label>';
                    html +='<select class="form-control" name="tipo_pago[]" >';
                    html +='<option value="">Seleccione</option>';
                    html +='<option value="Aguinaldo">Días de aguinaldo</option>';
                    html +='<option value="DSueldo">Días de sueldo</option>';
                    html +='<option value="Vacaciones">Días de vacaciones</option>';
                    html +='<option value="PrimaVacacional">Prima vacacional</option>';
                    html +='<option value="GratificaciónA">Graficación A (Con base al salario integrado)</option>';
                    html +='<option value="GratificaciónB">Graficación B (20 Días por año cumplido)</option>';
                    html +='<option value="GraficaciónC">Graficación C (Prima de antigüedad topada)</option>';
                    html +='<option value="GratificaciónD">Graficación D (Incluye cualquier otra prestación)</option>';
                    html +='<option value="GratificaciónE">Graficación E (Prestaciones en especie)</option>';
                    html +='<option value="GratificaciónF">Graficación F (Reconocimiento de derechos)</option>';
                    html +='<option value="Otras">Otros concepto de pago</option>';
                    html +='</select>';
                    html +='<div class="invalid-feedback">El tipo de pago es obligatorio.</div>';
                    html += '</div> </div>';

                // Monto a pagar
                html += '<div class="col-xs-12 col-sm-12 col-md-12">';
                html += '<div class="form-group">';
                html += '<label for="password">Monto a pagar</label>';
                html +='<input type="text" class="form-control" name="monto_pago[]" oninput="validarNumero(this)" placeholder="$"  placeholder="$ Solo números y puntos">';
                html += '<div class="invalid-feedback">La Dirección es obligatoria.</div>';
                html += '</div> </div>';

                html += '<div class="input-group-append">';
                html += '<button class="removeRow btn btn-danger" type="button">Borrar</button>';
                html += '</div>';
                html += '</div>';

            $('#newRow').append(html);
        });

        // Borrar concepto
        $(document).on('click', '.removeRow', function () {
            $(this).closest('.col-xs-12').remove();
        });

        // Agregar pago
        $("#addPago").click(function () {
                var html = '';
                html += '<div id="inputFormRow2" class="col-xs-12 col-sm-6 col-md-12">';
                
                //TIPO DE PAGO
                html +='<div class="col-xs-12 col-sm-12 col-md-12">';
                html +='<div class="form-group">';

                //DÍA A PAGAR
                html +='<div class="col-xs-12 col-sm-12 col-md-12">';
                html +='<div class="form-group">';
                html +='<label for="confirm-password"><br>Días de pago</label>';
                html +='<input type="date" class="form-control" name="dias_pagos[]" >';
                html +='</div> </div>';                                
                
                //HORARIO A PAGAR
                html += '<div class="col-xs-12 col-sm-12 col-md-12">';
                html += '<div class="form-group">';
                html += '<label for="password">Hora de pago</label>';
                html +='<input type="text" class="form-control" name="hora_pagos[]"  oninput="this.value = this.value.toUpperCase()" >';
                html += '<div class="invalid-feedback">';
                html += 'La Dirección es obligatoria.';
                html += '</div> </div> </div>';

                //MONTO A PAGAR
                html += '<div class="col-xs-12 col-sm-12 col-md-12">';
                html += '<div class="form-group">';
                html += '<label for="password">Monto a pagar</label>';
                html +='<input type="text" class="form-control" name="monto_pagos[]"  oninput="validarNumero(this)" placeholder="$"  placeholder="$ Solo números y puntos" >';
                html += '<div class="invalid-feedback">';
                html += 'La Dirección es obligatoria.';
                html += '</div> </div> </div>';

                //DESCRIPCIÓN DE PAGO
                html += '<div class="col-xs-12 col-sm-12 col-md-12">';
                html += '<div class="form-group">';
                html += '<label for="password">Descripción</label>';
                html +='<input type="text" class="form-control numero_pago" name="descripcion_pagos[]"  readonly >';
                html += '<div class="invalid-feedback">';
                html += 'La Dirección es obligatoria.';
                html += '</div> </div> </div>';

                html += '<div class="input-group-append">';
                html += '<button class="removeRow2 btn btn-danger" type="button">Borrar</button>';
                html += '</div>';
                html += '</div>';

            $('#newRowaPago').append(html);
            actualizaNumeroPago();
        });

        function actualizaNumeroPago() {
            let pagos = $('.numero_pago');
            if (pagos.length === 1) {
                pagos.eq(0).val("Cumplimiento total de convenio");
            } else {
                pagos.each(function(index) {
                   $(this).val("Cumplimiento " + (index + 1));
                });
            }
        }

        // Borrar pago
        $(document).on('click', '.removeRow2', function () {
            $(this).closest('.col-xs-12').remove();
        });

         // Agregar deducción
        $("#addRetencion").click(function () {
                var html = '';
                html += '<div id="inputFormRow3" class="row">';
                
                //TIPO DE PAGO
                html +='<div class="col-xs-12 col-sm-12 col-md-12"><br>';
                //html +='<div class="form-group">';

                    //DESCRIPCIÓN DE PAGO
                    html += '<div class="col-xs-12 col-sm-12 col-md-12">';
                    html += '<div class="form-group">';
                    html += '<label for="password">Descripción</label>';
                    html +='<input type="text" class="form-control" name="descripcion_deduccion[]"  oninput="this.value = this.value.toUpperCase()" >';
                    html += '<div class="invalid-feedback">';
                    html += 'La Descripción es obligatoria.';
                    html += '</div> </div> </div>';

                    //MONTO A PAGAR
                    html += '<div class="col-xs-12 col-sm-12 col-md-12">';
                    html += '<div class="form-group">';
                    html += '<label for="password">Monto a pagar</label>';
                    html +='<input type="text" class="form-control" name="monto_deduccion[]"  oninput="validarNumero(this)" placeholder="$"  placeholder="$ Solo números y puntos" >';
                    html += '<div class="invalid-feedback">';
                    html += 'El monto es obligatorio.';
                    html += '</div> </div> </div>';

                    html += '<div class="input-group-append">';
                    html += '<button class="removeRow3 btn btn-danger" type="button">Borrar</button>';
                    html += '</div>';

                html += '</div>';

            $('#newRowDeduccion').append(html);
        });

        // Borrar pago
        $(document).on('click', '.removeRow3', function () {
            $(this).closest('.col-xs-12').remove();
        });

    });

        function validarNumero(input) {
            // La expresión regular permite cualquier número (0-9) y un solo punto (.)
            // El 'g' al final asegura que se reemplace globalmente
            let valor = input.value;
            input.value = valor.replace(/[^0-9.]/g, '');

            // Esta parte se encarga de que solo haya un punto en el valor
            let partes = input.value.split('.');
            if (partes.length > 2) {
                input.value = partes[0] + '.' + partes.slice(1).join('');
            }
        }
    </script>
    <!--citados a mostrar en convenio -->
    <script>
        document.getElementById('btn-terminar').addEventListener('click', function(e) {
            var form = document.getElementById('form_roles');

            document.querySelectorAll('.clon-checkbox').forEach(function(el){
                el.remove();
            });

            var checkboxes = document.querySelectorAll('input[type=checkbox][name^="aparece_convenio"]');

            checkboxes.forEach(function(checkbox) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = checkbox.name;
                input.value = checkbox.checked ? 1 : 0; // enviar 0 si no está marcado 1 si lo marcaron
                input.classList.add('clon-checkbox');
                form.appendChild(input);
            });
        });
    </script>

    <script src="../../public/assets/js/validaciones.js"></script> 
    <script src="../../public/assets/js/poderes/general.js"></script>
@endsection