@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Poderes</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Agregar Poder</h3>

                            <!--Se realiza la validación de campos para ver si dejó alguno vacío-->
                            @if ($errors->any())
                                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                    <strong>¡Revise los campos!</strong>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <!--Se realiza el envío de datos con formulario de Laravel Collective-->
                            <form class='needs-validation novalidate' id='form_roles' method='POST' action="{{route('poderes.store')}}" enctype='multipart/form-data'>
                                @csrf
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
                                            <input type="text" class="form-control" placeholder="*Apellidos" name="primer_apellido" id="apellidosAbogadoAlta" oninput="this.value = this.value.toUpperCase()" required>
                                            <div class="invalid-feedback">
                                                El primer apellido es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="">Segundo Apellido</label>
                                            <input type="text" class="form-control" placeholder="*Apellidos" name="segundo_apellido" oninput="this.value = this.value.toUpperCase()" required>
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
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<div id="crear_poder" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>

@section('scripts')
    <script src="../public/js/poderes/general.js"></script>
@endsection