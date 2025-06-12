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
                <button type="button" class="btn btn-primary" data-id="{{ $id }}" data-bs-toggle="modal" data-bs-target="#modalAgregarCitados">Agregar en reprecentantación</button>
                <button type="button" class="btn btn-primary" data-id="{{ $id }}" data-bs-toggle="modal" data-bs-target="#modalAgregarDerecho">Agregar por propio derecho</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Agregar Citados -->
<div class="modal fade" id="modalAgregarCitados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class='needs-validation novalidate'  method='POST' name="AgregarRepresentante" id="AgregarRepresentante" action="{{route('insertar_citado')}}">
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
                                <h4 class="text-center">Datos del reprecentante</h4>
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

                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="">CURP</label>
                                <input type="text" class="form-control" placeholder="*CURP" aria-label="CURP" name="curpAbogadoAlta" minlength="18" maxlength="18" oninput="this.value = this.value.toUpperCase()" required>
                                <div class="invalid-feedback">
                                    La CURP es obligatoria.
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    @if($bandera != 0)
                        Si no seleccionas todos los representantes se va multar los que no selecciones.
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
            <div class="modal-content">
                <div class="modal-header">
                    @if($bandera != 0)
                        <span>Si no seleccionas todos los representantes debes seleccionar un fecha para que proxima audiencia.<br>
                        Va notificar el centro</span>
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
    <form class='needs-validation novalidate'  method='POST' enctype="multipart/form-data" name="AgregarPersonaFisica" id="AgregarPersonaFisica" action="{{route('insertar_citado_PF')}}">
        @csrf
        <input type="text" name="id" value="{{$id}}">
        <input type="text" name="id_citado_pf" id="id_citado_pf" value="">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Persona Fisica</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
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
            //*document.getElementById('modal-id-terminar').value =id;
            document.getElementById('modal-id-archivar').value = id;
            document.getElementById('modal-id-reagendar').value = id;
            document.getElementById('modal-id-incopentencia').value = id;

            console.log(id);
        });
    </script>
    <script src="../../public/assets/js/validaciones.js"></script> 
    <script src="../../public/assets/js/poderes/general.js"></script>
@endsection