@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Notificaciones</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            
                            
                            @can('ver-seer')
                                @if($userRole[0] == "Enlace")
                                    <div class="table-responsive">
                                        <table id="example" class="table table-striped mt-1" style="text-align:center">
                                            <thead style="background-color: #4A001F;">
                                                <th style="display: none;">ID</th>
                                                <th style="color: #fff;">Expediente</th>
                                                <th style="color: #fff;">Citado</th>
                                                <th style="color: #fff;">Dirección</th>
                                                <th style="color: #fff;">Estatus</th>
                                                <th style="color: #fff;">Acciones</th>
                                                <th style="color: #fff;">Documentos</th>
                                            </thead>
                                            <tbody>
                                                @foreach($notificaciones as $notificacion)
                                                    <tr>
                                                        <td style="display: none;">{{$notificacion->id_solicitud}}</td>
                                                        <td>{{$notificacion->NUE}}</td>
                                                        <td>{{$notificacion->nombre}}</td>
                                                        <td>{{$notificacion->colonia}}</td>
                                                        <td>{{$notificacion->estatus}}</td>
                                                        <td>
                                                            <form method="POST" action="{{ route('seer.store_enlace') }}" class="needs-validation novalidate">
                                                                @csrf
                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                    <button type="submit" class="btn btn-primary">Asignar</button>
                                                                </div>
                                                                <div class="col-xs-12 col-sm-12 col-md-12">
                                                                    <button type="button" class="btn btn-info open-modal" data-bs-toggle="modal" data-bs-target="#editarNotificacion" data-id="{{$notificacion->id}}">Editar</button>
                                                                </div>
                                                                <input type="hidden" name="id" value="{{$notificacion->id_citado}}">
                                                                <select class="form-control" name="notificador">
                                                                    <option value="">Seleccione</option>
                                                                    @foreach($personas as $persona)
                                                                        <option value="{{$persona->id}}">{{$persona->name}}</option>
                                                                    @endforeach
                                                                </select>  
                                                            </form>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            @endcan
                            <!-- Centramos la paginación a la derecha-->
                            <div class="pagination justify-content-end">
                            </div>                        
                        </div>
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
@endsection
        
    </section>
    
    <!-- Modal -->
    <div class="modal fade" id="editarNotificacion" tabindex="-1" aria-labelledby="editarNotificacionlLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form class='needs-validation novalidate'  method='POST' enctype="multipart/form-data" action="{{ route('editar_citado_enlace') }}">
            @csrf
                <input type="hidden" name="id" value="{{$notificacion->id_citado}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Citado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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
                        <input type="hidden" name="id" value="{{$notificacion->id_citado}}">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="name">Nombre(s) del citado (*)</label>
                                <input type="text" name="nombre" value="{{ old('nombre', $notificacion->nombre) }}" class="form-control" oninput="this.value = this.value.toUpperCase()" required>
                                <div class="invalid-feedback">
                                    El campo nombre es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="name">Primer apellido *</label>
                                <input type="text" name="primer_apellido" value="{{ old('primer_apellido', $notificacion->primer_apellido) }}" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                <div class="invalid-feedback">
                                    El nombre es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="name">Segundo apellido *</label>
                                <input type="text" name="segundo_apellido" value="{{ old('segundo_apellido', $notificacion->segundo_apellido) }}" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                <div class="invalid-feedback">
                                    El nombre es obligatorio.
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="name">RFC</label>
                                <input type="text" name="rfc" value="{{ old('rfc', $notificacion->rfc) }}" class="form-control" minlength="13" maxlength="13" > 
                                <div class="invalid-feedback">
                                    El campo conflicto es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="name">Tipo de personas</label>
                                <select name="tipo" value="{{ old('tipo', $notificacion->tipo_persona) }}" class="form-control">
                                    <option value="">Seleccione</option>
                                    <option value="Fisica">Fisica</option>
                                    <option value="Moral">Moral</option>
                                </select>
                                <div class="invalid-feedback">
                                    El tipo de persona es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="name">CURP</label>
                                <input type="text" name="curp" id="curp_input" value="{{ old('curp', $notificacion->curp) }}"oninput="validarInput(this)" class="form-control"> 
                                <pre id="resultado"></pre>
                                <div class="invalid-feedback">
                                    El nombre es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="name">Tipo de Vialidad del citado *</label>
                                <select name="vialidad" value="{{ old('vialidad', $notificacion->tipo_vialidad) }}" class="form-control" required>
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
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="name">Calle del citado *</label>
                                <input type="text" name="calle" value="{{ old('calle', $notificacion->calle) }}" class="form-control" required> 
                                <div class="invalid-feedback">
                                    El campo calle es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="name">Colonia del citado *</label>
                                <input type="text" name="colonia" value="{{ old('colonia', $notificacion->colonia) }}" class="form-control" required> 
                                <div class="invalid-feedback">
                                    El campo colonia es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="name">Código Postal del citado *</label>
                                <input type="text" name="cp" value="{{ old('cp', $notificacion->cp) }}" class="form-control" minlength="5" maxlength="5" required> 
                                <div class="invalid-feedback">
                                    El campo Código Postal es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="name">Entre calle del domicilio del citado</label>
                                <input type="text" name="calle1" value="{{ old('calle1', $notificacion->calle1) }}" class="form-control"> 
                                <div class="invalid-feedback">
                                    El campo calle es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="name">y calle del domicilio del citado</label>
                                <input type="text" name="calle2" value="{{ old('calle2', $notificacion->calle2) }}" class="form-control"> 
                                <div class="invalid-feedback">
                                    El campo calle es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="name">Num ext. del citado</label>
                                <input type="text" name="exterior" value="{{ old('exterior', $notificacion->n_ext) }}" class="form-control" required> 
                                <div class="invalid-feedback">
                                    El campo calle es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="name">Num int. del citado</label>
                                <input type="text" name="interior" value="{{ old('interior', $notificacion->n_int) }}" class="form-control" > 
                                <div class="invalid-feedback">
                                    El campo calle es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">    
                                <label for="floatingTextarea">Referencias del domicilio del citado</label>
                                <textarea class="form-control" value="{{ old('referencia', $notificacion->referencia) }}"placeholder="Ingresa alguna referencia de como llegar" name="referencia"></textarea>
                                <div class="invalid-feedback">
                                    El campo referencias es obligatorio.
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
@endsection




