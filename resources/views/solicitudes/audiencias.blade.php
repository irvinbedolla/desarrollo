@extends('layouts.app_editar')
@php
    $fechaActual = date('Y-m-d');
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
                            <button type="button" class="btn btn-danger open-modal" data-bs-toggle="modal" data-bs-target="#ModalArchivar" data-id="{{ $solicitud->id }}">
                                Archivar
                            </button>
                            <button type="button" class="btn btn-danger open-modal" data-bs-toggle="modal" data-bs-target="#ModalReagendar" data-id="{{ $solicitud->id }}">
                                Reagendar
                            </button>
                            <button type="button" class="btn btn-danger open-modal" data-bs-toggle="modal" data-bs-target="#ModalIncopentencia" data-id="{{ $solicitud->id }}">
                                Incompetencia
                            </button>
                            <div class="table-responsive">
                                <table class="table table-striped mt-1">
                                    <thead style="background-color: #4A001F;">
                                        <tr> 
                                            <th style="display:none">ID</th>
                                            <th style="color: #ffff;">Tipo parte</th>
                                            <th style="color: #ffff;">Nombre de la parte</th>
                                            <th style="color: #ffff;">Conciliador</th>
                                            <th style="color: #ffff;">Representante legal</th>
                                            <th style="color: #ffff;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="display:none">{{$solicitante->id}}</td>
                                            <td style="color: #000000;"><b>Solicitante</b></td>
                                            <td>{{ $solicitante->nombre }}</td>
                                            <td>{{ $conciliador->name }}</td>
                                            <td>
                                                
                                            </td>
                                            <td>
                                                <a type="button" class="btn btn-warning open-modal" data-bs-toggle="modal" data-bs-target="#exampleModal1" data-id="{{ $id }}">Editar</a>
                                            </td>
                                        </tr>
                                        @foreach($citados as $citado)
                                            <tr>
                                                <td  style="display:none">{{$citado->id}}</td>
                                                <td style="color: #000000;"><b>Citado</b></td>
                                                <td>{{$citado->nombre}} {{$citado->primer_apellido}} {{$citado->segundo_apellido}}</td>
                                                <td>{{ $conciliador->name }}</td>
                                                <td>
                                                    @if($citado->id_abogado == null)
                                                        Por asignar
                                                    @else
                                                        {{ $citado->id_abogado }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary open-modal" data-id="{{ $citado->id }}" data-bs-toggle="modal" data-bs-target="#modalCitados"> Citado </button>
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
    </section>
@endsection
<!-- Modal Citados -->
<div class="modal fade" id="modalCitados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Citados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <form method="POST" action="{{ route('seleccionar_abogado') }} ">
                    @csrf
                    <input type="hidden" id="modal-id" name="id3" value="">
                    <input type="hidden" name="id2" value="{{$solicitud->id}}">
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
                                            <input type="text" name="id" value="{{$abogado->idAbogado}}">
                                            <button class="btn btn-info" onclick=editar_rol(); type="submit">Seleccionar</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-citado-id="{{ $id }}" data-bs-toggle="modal" data-bs-target="#modalAgregarCitados">Agregar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Agregar Citados -->
<div class="modal fade" id="modalAgregarCitados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class='needs-validation novalidate'  method='POST' name="AgregarRepresentante" id="AgregarRepresentante" action="{{route('insertar_citado')}}">
        @csrf
        <input type="hidden" name="id_citado_2" id="id_citado_2" value="">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Citado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
<!-- Modal -->
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
                    <input type="date" class="form-control" name="fecha" value="fecha">
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
            document.getElementById('modal-id-incopentencia').value = id;
            document.getElementById('id_citado').value =id;
            document.getElementById('modal-id-archivar').value = id;
            document.getElementById('modal-id-reagendar').value = id;
            document.getElementById('modal-id-incopentencia').value = id;
        });
    </script>
    <script src="../../public/assets/js/validaciones.js"></script> 
    <script src="../../public/assets/js/poderes/general.js"></script>
@endsection