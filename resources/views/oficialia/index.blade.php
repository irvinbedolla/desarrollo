@extends('layouts.app')
@php
    $fechaActual = date('Y-m-d');
@endphp
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Oficialia de Partes</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                @if ($userRole == 'Turnos')
                                    <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-id="{{ $id }}" data-bs-target="#oficialiaModal"> Agregar</a>
                                @endif

                            </div>
                            
                            
                                
                                <div class="table-responsive">
                                    <table id="tablaPoderesEstatica" class="table table-striped mt-2" style="width:100%">
                                        <thead style="background-color: #4A001F;">
                                            <tr>
                                                
                                                <th style="color: #fff;">Fecha</th>
                                                <th style="color: #fff;">Tipo de Tramite</th>
                                                <th style="color: #fff;">Oficio</th>
                                                <th style="color: #fff;">Area de Turno</th>
                                                <th style="color: #fff;">Usuario Responsable</th>
                                                <th style="color: #fff;">Estado</th>
                                                <th style="color: #fff;"></th>
                                                <th style="color: #fff;"></th>
                                                <th style="color: #fff;">Conclusiones</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($oficialias as $oficialia)
                                                <tr>
                                                    <td>{{ $oficialia->fecha }} {{ $oficialia->hora}}</td>
                                                    <td>{{ $oficialia->tipo_tramite }}</td>
                                                    <td>{{ $oficialia->oficio }}</td>
                                                    <td>{{ $oficialia->area_turno }}</td>
                                                    <td>{{ strtoupper($oficialia->usuarioResponsable->name )}}</td>
                                                    <td>@if($oficialia->estatus == 'creado')Pendiente @elseif ($oficialia->estatus == 'turnado') Turnado @else Concluido @endif</td>

                                                    <td>
                                                        @if($oficialia->estatus == 'creado')
                                                        <a href="#" class="btn btn-success" data-bs-toggle="modal" data-id="{{ $oficialia->id }}" data-bs-target="#concluirModal">Concluir</a>
                                                            <!--form action="{{ route('concluir_oficialia', $oficialia->id) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                <button type="submit" class="btn btn-success">
                                                                    Concluir
                                                                </button>
                                                            </form-->
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($oficialia->estatus == 'creado')
                                                            <a href="#" class="btn btn-info" data-bs-toggle="modal" data-id="{{ $oficialia->id }}" data-bs-target="#turnarModal"> Turnar</a>
                                                        @endif
                                                    </td>
                                                    <td>@if($oficialia->conclusion){{ $oficialia->conclusion }} @endif</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                      
                            <div class="d-flex justify-content-end mt-2">
                                {{ $oficialias->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
//Modal generar
    <div class="modal fade" id="oficialiaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form class='needs-validation novalidate' method='POST' action="{{ route('generar_oficialia') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="oficialia_id" id="oficialia_id_input" value="">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Oficialia</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-xs-12 col-sm-12 col-md-12" id="Conrepresentante">
                                            <div class="row">
                                                
                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                    <div class="form-group">
                                                        <h5 class="text-center">Datos de identificación</h5>
                                                    </div>
                                                </div>

                                                <!--div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Nombre(s) del representante <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="nombre_representante_pF" id="nombre_representante_pF" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El nombre es obligatorio.
                                                        </div>
                                                    </div>
                                                </div-->
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Tipo de Tramite <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="tipo_tramite" id="tipo_tramite" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El tipo de tramite es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Area de Turno <span style="color:red;">(*)</span></label>
                                                        <select name="area_turno" id="area_turno" class="form-control">
                                                            <option value="">Seleccione</option>
                                                            <option value="Dirección general">Dirección General</option>
                                                            <option value="Dirección Administrativa">Dirección Administrativa</option>
                                                            <option value="Unidad Jurídica">Unidad Jurídica</option>
                                                            <option value="Delegación Morelia">Delegación Morelia</option>
                                                            <option value="Delegación Uruapan">Delegación Uruapan</option>
                                                            <option value="Delegación Zamora">Delegación Zamora</option>
                                                            
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            El area de turno es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-12 col-md-6">  
                                                    <div class="form-group">
                                                        <label for="name">Usuario Responsable<span style="color:red;">(*)</span></label>
                                                        <select name="usuario_responsable" id="usuario_responable" class="form-control">
                                                            <option value="">Seleccione</option>
                                                            @foreach ($usuariosR as $usuarioR )
                                                                <option value="{{ $usuarioR->id }}">{{$usuarioR->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="invalid-feedback">
                                                            El campo es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label for="name">Oficio <span style="color:red;">(*)</span></label>
                                                        <input type="text" name="oficio" id="oficio" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                        <div class="invalid-feedback">
                                                            El segundo apellido es obligatorio.
                                                        </div>
                                                    </div>
                                                </div>  
                                                <div class="col-xs-12 col-sm-12 col-md-6">
                                                    <div class="form-group">
                                                        <label>Documento de Oficio</label><br>
                                                        <input type="file" name="documento_oficio" id="documento_oficio" class="form-control" accept=".pdf" >

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" style="background-color:#CEA845; border-color:#CEA845;">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    //ModalTurnar
<div class="modal fade" id="turnarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Turnar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <form method="POST" action="{{ route('turnar_oficialia') }} ">
                    @csrf
                    <input type="hidden" id="modal-id" name="oficialia_id" value="">
                    <input type="hidden" name="origen" value="previa">
                    <table id="tabla1" class="table-striped" style="width:100%">
                        <thead style="background-color: #4A001F;">   
                            <!--<th style="display: none;">ID</th>-->
                            <th style="color: #fff;">ID</th>
                            <th style="color: #fff;">Nombre</th>
                            <th style="color: #fff;">Acciones</th>
                        </thead>
                        <tbody class="contenidobusqueda">
                            @foreach ($usuariosR as $usuarioR )
                                <tr>
                                    <td>{{$usuarioR->id}}</td>
                                    <td>{{$usuarioR->name}}</td>
                                    <td>
                                        <button class="btn btn-info" onclick="editar_rol()" type="submit" name="usuario_responsable" value="{{$usuarioR->id}}">Seleccionar</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
                </div>
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="concluirModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form class='needs-validation novalidate' method='POST' action="{{ route('concluir_oficialia') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="oficialia_id" id="oficialia_id_input" value="">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Finalización del Proceso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-xs-12 col-sm-12 col-md-12" id="Conrepresentante">
                            <div class="row">
                                
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <h5 class="text-center">Conclusión</h5>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="name">Motivo de Conclusión <span style="color:red;">(*)</span></label>
                                        <textarea name="conclusion" id="conclusion" class="form-control" oninput="this.value = this.value.toUpperCase()" > </textarea>
                                        <div class="invalid-feedback">
                                            La conclusion es obligatoria.
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                            </div>
                        </div>
                        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" style="background-color:#CEA845; border-color:#CEA845;">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    
@endsection

<div id="nuevo_poder" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>

@section('scripts')
    <script src="../public/js/poderes/general.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            //modal de generar oficialia
            var oficialiaModal = document.getElementById('oficialiaModal');
            if (oficialiaModal) {
                document.body.appendChild(oficialiaModal);

                oficialiaModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var oficialia_id= button.getAttribute('data-id');
                    var modalBodyInput = oficialiaModal.querySelector('#oficialia_id_input');
                    if (modalBodyInput) {
                        modalBodyInput.value = oficialia_id;
                    }
                });
            }
             //modal turnar
            var turnarModal = document.getElementById('turnarModal');
            if (turnarModal) {
                
                document.body.appendChild(turnarModal);

                turnarModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    
                    var oficialia_id = button.getAttribute('data-id');
                    
                    var modalInputId = turnarModal.querySelector('#modal-id');
                    if (modalInputId) {
                        modalInputId.value = oficialia_id;
                    }
                });
            }

            //modal conclusión
            var concluirModal = document.getElementById('concluirModal');
            if (concluirModal) {
                document.body.appendChild(concluirModal);

                concluirModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var oficialia_id= button.getAttribute('data-id');
                    var modalBodyInput = concluirModal.querySelector('#oficialia_id_input');
                    if (modalBodyInput) {
                        modalBodyInput.value = oficialia_id;
                    }
                });
            }

        });
    </script>
    
@endsection