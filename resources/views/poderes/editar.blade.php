@extends('layouts.app_editar')

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
                            <h3 class="text-center">Editar representante legal</h3>

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

                            <!--Se realiza el envío de datos con formulario de Laravel Collective-->
                            <form class='needs-validation novalidate' id='form_roles' method='POST' action="{{route('poderes.update' ,$poder->idAbogado)}}" enctype='multipart/form-data'>
                                <input type="hidden" name="_method" value="PATCH">
                                <input type="hidden" name="id" value="{{ Auth::id() }}">
                                @csrf
                                <div class="row">
                                    @if($poder->tipo == "Moral")
                                        <div class="col-xs-12 col-sm-12 col-md-10">
                                            <div class="form-group">
                                                <label for="name">Razón social <span style="color:red;">(*)</span></label>
                                                <input type="text" name="razon" value="{{$poder->nombres}}" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                <div class="invalid-feedback">
                                                    La razón social es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Teléfono</label>
                                                <input type="text" class="form-control" value="{{$poder->telefono}}"  name="telefono_moral" maxlength="10" pattern="[0-9]+" >
                                                <div class="invalid-feedback">
                                                    El telefono es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Correo</label>
                                                <input type="email" class="form-control" value="{{$poder->email}}" name="correo_moral" id="correoAbogadoAlta" >
                                                <div class="invalid-feedback">
                                                    El correo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">CURP</label>
                                                <input type="text" class="form-control" value="{{$poder->curp}}" aria-label="CURP" name="curp_moral" minlength="18" maxlength="18" oninput="this.value = this.value.toUpperCase()" >
                                                <div class="invalid-feedback">
                                                    La CURP es obligatoria.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <h4 class="text-center" style="color:#CEA845">Datos de la fuente laboral</h4>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Empresa</label>
                                                <input type="text" class="form-control" value="{{ $poder->empresa }}" name="empresaAbogadoAlta" oninput="this.value = this.value.toUpperCase()" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">RFC</label>
                                                <input type="text" class="form-control" placeholder="RFC Empresa" name="RFCAbogadoAlta" maxlength="10" oninput="this.value = this.value.toUpperCase()">
                                            </div>
                                        </div>
                                    
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="password">Entidad Federativa</label>
                                                <select class="form-control" name="estado_poder">
                                                    <option value="">Seleccione</option>
                                                    @foreach($estados as $est)
                                                        <option value="{{$est['id']}}" {{$poder['estado_poder'] == $est['id'] ? "selected" : '' }}>{{$est['nombre']}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    El campo Estado es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="name">Nombre del Municipio o Alcaldía</label>
                                                <select id="municipio_poder" class="form-control" name="municipio_poder">
                                                    <option value="">Seleccione</option>
                                                    @foreach($municipios as $mun)
                                                        <option value="{{$mun['id']}}" {{ $poder['municipio_poder'] == $mun['id'] ? "selected" : '' }}>{{$mun['nombre']}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    El campo municipio o alcaldía es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="name">Tipo de Vialidad</label>
                                                <select name="vialidadPoder" class="form-control">
                                                    <option value="Calle" {{ $poder["vialidadPoder"] == 'Calle' ? "selected" : '' }}>CALLE</option>
                                                    <option value="Avenida"  {{ $poder['vialidadPoder'] == 'Avenida' ? "selected" : '' }}>AVENIDA</option>
                                                    <option value="Calzada"  {{ $poder['vialidadPoder'] == 'Calzada' ? "selected" : '' }}>CALZADA</option>
                                                    <option value="Boulevard"  {{ $poder['vialidadPoder'] == 'Boulevard' ? "selected" : '' }}>BOULEVARD</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    El campo vialidad o calle es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="name">Nombre de la Vialidad</label>
                                                    <input type="text" class="form-control" name="vialidad_callePoder" value="{{ $poder->vialidad_callePoder }}" oninput="this.value = this.value.toUpperCase()" required>
                                                <div class="invalid-feedback">
                                                    El campo vialidad o calle es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="">Colonia</label>
                                                <input type="text" class="form-control" name="coloniaAbogadoAlta" id="coloniaAbogadoAlta" value="{{ $poder->coloniaAbogadoAlta }}" oninput="this.value = this.value.toUpperCase()" required>
                                                <div class="invalid-feedback">
                                                    El domicilio es obligatoria.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="">Núm. Ext.</label>
                                                <input type="text" class="form-control" name="NExtAbogadoAlta" id="NExtAbogadoAlta" value="{{ $poder->NExtAbogadoAlta }}" oninput="this.value = this.value.toUpperCase()" required>
                                                <div class="invalid-feedback">
                                                    El domicilio es obligatoria.
                                                </div>
                                            </div>
                                        </div>
                
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="">Núm. Int.</label>
                                                <input type="text" class="form-control" name="NIntAbogadoAlta" id="NIntAbogadoAlta" value="{{ $poder->NIntAbogadoAlta }}" oninput="this.value = this.value.toUpperCase()">
                                                <div class="invalid-feedback">
                                                    El domicilio es obligatoria.
                                                </div>
                                            </div>
                                        </div>
                
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="">Código postal</label>
                                                <input type="text" class="form-control" name="cpAbogadoAlta" id="cpAbogadoAlta" value="{{ $poder->cpAbogadoAlta }}" oninput="this.value = this.value.toUpperCase()" required>
                                                <div class="invalid-feedback">
                                                    El domicilio es obligatoria.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Fecha vigencia</label>
                                                <input type="date" class="form-control" value="{{ $poder->fechaVigencia }}" name="fechaVigenciaAlta" id="fechaVigenciaAlta" min="<?= date("Y-m-d") ?>" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Industria</label>
                                                <input type="text" class="form-control" value="{{ $poder->industria }}" name="industriaAlta" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <span class="" id="basic-addon1">*Seleccione la region(nes).</i></i></span>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="moreliaSucursal" value="Si" @php if($poder->regionMorelia === "Si") echo "checked"  @endphp>
                                                    <label class="form-check-label" for="flexCheckDefault">Morelia</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="uruapanSucursal" value="Si" @php if($poder->regionUruapan === "Si") echo "checked"  @endphp>
                                                    <label class="form-check-label" for="flexCheckChecked">Uruapan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="zamoraSucursal" value="Si" @php if($poder->regionZamora === "Si") echo "checked"  @endphp>
                                                    <label class="form-check-label" for="flexCheckDefault">Zamora</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="">Descripción del poder</label>
                                                <textarea class="form-control" aria-describedby="basic-addon1" name="descripcionpoderAlta" required>{{ $poder->poder }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="">Estatus</label>
                                                <select class="form-control" name="estatus" required>
                                                    <option value="Pendiente" @php if($poder->estatus === "Pendiente") echo "selected"  @endphp>Pendiente</option>
                                                    <option value="Validado" @php if($poder->estatus === "Validado") echo "selected"  @endphp>Validado</option>
                                                </select>
                                            </div>
                                        </div>
                                    
                                    @elseif($poder->tipo == "FisicaR")
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="name">Nombre(s)</label>
                                                <input type="text" class="form-control" value="{{ $poder->nombres }}" name="nombresAbogadoAlta" oninput="this.value = this.value.toUpperCase()" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Primer Apellido</label>
                                                <input type="text" class="form-control" value="{{ $poder->primer_apellido }}" name="primer_apellido" id="apellidosAbogadoAlta" oninput="this.value = this.value.toUpperCase()" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Segundo Apellido</label>
                                                <input type="text" class="form-control" value="{{ $poder->segundo_apellido }}" name="segundo_apellido"  oninput="this.value = this.value.toUpperCase()" required>
                                            </div>
                                        </div>                        

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Teléfono</label>
                                                <input type="text" class="form-control" value="{{ $poder->telefono }}"  name="telefonoAbogadoAlta" maxlength="10" pattern="[0-9]+" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Correo</label>
                                                <input type="email" class="form-control" value="{{ $poder->email }}" name="correoAbogadoAlta" id="correoAbogadoAlta" required>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">CURP</label>
                                                <input type="text" class="form-control" value="{{ $poder->curp }}" aria-label="CURP" name="curpAbogadoAlta"maxlength="18" oninput="this.value = this.value.toUpperCase()" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <h4 class="text-center" style="color:#CEA845">Datos de la fuente laboral</h4>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Empresa</label>
                                                <input type="text" class="form-control" value="{{ $poder->empresa }}" name="empresaAbogadoAlta" oninput="this.value = this.value.toUpperCase()" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">RFC</label>
                                                <input type="text" class="form-control" placeholder="RFC Empresa" name="RFCAbogadoAlta" maxlength="10" oninput="this.value = this.value.toUpperCase()">
                                            </div>
                                        </div>
                                    
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="password">Entidad Federativa</label>
                                                <select class="form-control" name="estado_poder">
                                                    <option value="">Seleccione</option>
                                                    @foreach($estados as $est)
                                                        <option value="{{$est['id']}}" {{$poder['estado_poder'] == $est['id'] ? "selected" : '' }}>{{$est['nombre']}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    El campo Estado es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="name">Nombre del Municipio o Alcaldía</label>
                                                <select id="municipio_poder" class="form-control" name="municipio_poder">
                                                    <option value="">Seleccione</option>
                                                    @foreach($municipios as $mun)
                                                        <option value="{{$mun['id']}}" {{ $poder['municipio_poder'] == $mun['id'] ? "selected" : '' }}>{{$mun['nombre']}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">
                                                    El campo municipio o alcaldía es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="name">Tipo de Vialidad</label>
                                                <select name="vialidadPoder" class="form-control">
                                                    <option value="Calle" {{ $poder["vialidadPoder"] == 'Calle' ? "selected" : '' }}>CALLE</option>
                                                    <option value="Avenida"  {{ $poder['vialidadPoder'] == 'Avenida' ? "selected" : '' }}>AVENIDA</option>
                                                    <option value="Calzada"  {{ $poder['vialidadPoder'] == 'Calzada' ? "selected" : '' }}>CALZADA</option>
                                                    <option value="Boulevard"  {{ $poder['vialidadPoder'] == 'Boulevard' ? "selected" : '' }}>BOULEVARD</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    El campo vialidad o calle es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="name">Nombre de la Vialidad</label>
                                                    <input type="text" class="form-control" name="vialidad_callePoder" value="{{ $poder->vialidad_callePoder }}" oninput="this.value = this.value.toUpperCase()" required>
                                                <div class="invalid-feedback">
                                                    El campo vialidad o calle es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="">Colonia</label>
                                                <input type="text" class="form-control" name="coloniaAbogadoAlta" id="coloniaAbogadoAlta" value="{{ $poder->coloniaAbogadoAlta }}" oninput="this.value = this.value.toUpperCase()" required>
                                                <div class="invalid-feedback">
                                                    El domicilio es obligatoria.
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="">Núm. Ext.</label>
                                                <input type="text" class="form-control" name="NExtAbogadoAlta" id="NExtAbogadoAlta" value="{{ $poder->NExtAbogadoAlta }}" oninput="this.value = this.value.toUpperCase()" required>
                                                <div class="invalid-feedback">
                                                    El domicilio es obligatoria.
                                                </div>
                                            </div>
                                        </div>
                
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="">Núm. Int.</label>
                                                <input type="text" class="form-control" name="NIntAbogadoAlta" id="NIntAbogadoAlta" value="{{ $poder->NIntAbogadoAlta }}" oninput="this.value = this.value.toUpperCase()">
                                                <div class="invalid-feedback">
                                                    El domicilio es obligatoria.
                                                </div>
                                            </div>
                                        </div>
                
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="">Código postal</label>
                                                <input type="text" class="form-control" name="cpAbogadoAlta" id="cpAbogadoAlta" value="{{ $poder->cpAbogadoAlta }}" oninput="this.value = this.value.toUpperCase()" required>
                                                <div class="invalid-feedback">
                                                    El domicilio es obligatoria.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Fecha vigencia</label>
                                                <input type="date" class="form-control" value="{{ $poder->fechaVigencia }}" name="fechaVigenciaAlta" id="fechaVigenciaAlta" min="<?= date("Y-m-d") ?>" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Industria</label>
                                                <input type="text" class="form-control" value="{{ $poder->industria }}" name="industriaAlta" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <span class="" id="basic-addon1">*Seleccione la region(nes).</i></i></span>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="moreliaSucursal" value="Si" @php if($poder->regionMorelia === "Si") echo "checked"  @endphp>
                                                    <label class="form-check-label" for="flexCheckDefault">Morelia</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="uruapanSucursal" value="Si" @php if($poder->regionUruapan === "Si") echo "checked"  @endphp>
                                                    <label class="form-check-label" for="flexCheckChecked">Uruapan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="zamoraSucursal" value="Si" @php if($poder->regionZamora === "Si") echo "checked"  @endphp>
                                                    <label class="form-check-label" for="flexCheckDefault">Zamora</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="">Descripción del poder</label>
                                                <textarea class="form-control" aria-describedby="basic-addon1" name="descripcionpoderAlta" required>{{ $poder->poder }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="">Estatus</label>
                                                <select class="form-control" name="estatus" required>
                                                    <option value="Pendiente" @php if($poder->estatus === "Pendiente") echo "selected"  @endphp>Pendiente</option>
                                                    <option value="Validado" @php if($poder->estatus === "Validado") echo "selected"  @endphp>Validado</option>
                                                </select>
                                            </div>
                                        </div>
                                    @elseif($poder->tipo == "FisicaD")
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="name">Nombre(s)</label>
                                                <input type="text" class="form-control" value="{{ $poder->nombres }}" name="nombresAbogadoAlta" oninput="this.value = this.value.toUpperCase()" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Primer Apellido</label>
                                                <input type="text" class="form-control" value="{{ $poder->primer_apellido }}" name="primer_apellido" id="apellidosAbogadoAlta" oninput="this.value = this.value.toUpperCase()" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Segundo Apellido</label>
                                                <input type="text" class="form-control" value="{{ $poder->segundo_apellido }}" name="segundo_apellido"  oninput="this.value = this.value.toUpperCase()" required>
                                            </div>
                                        </div>                        

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Teléfono</label>
                                                <input type="text" class="form-control" value="{{ $poder->telefono }}"  name="telefonoAbogadoAlta" maxlength="10" pattern="[0-9]+" required>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">Correo</label>
                                                <input type="email" class="form-control" value="{{ $poder->email }}" name="correoAbogadoAlta" id="correoAbogadoAlta" required>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="">CURP</label>
                                                <input type="text" class="form-control" value="{{ $poder->curp }}" aria-label="CURP" name="curpAbogadoAlta"maxlength="18" oninput="this.value = this.value.toUpperCase()" required>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="name">Giro Comercial <span style="color:red;">(*)</span></label>
                                                <input type="text" name="giro_derecho" value="{{ $poder->industria }}"  class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                <div class="invalid-feedback">
                                                    El nombre es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="name">Vialidad (calle,avenida,etc.) <span style="color:red;">(*)</span></label>
                                                <input type="text" name="vialidad_derecho" value="{{ $poder->vialidad_callePoder }}"  class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                <div class="invalid-feedback">
                                                    El nombre es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label for="name">Colonia <span style="color:red;">(*)</span></label>
                                                <input type="text" name="colonia_derecho" value="{{ $poder->coloniaAbogadoAlta }}" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                <div class="invalid-feedback">
                                                    El nombre es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <label for="name">Num Int <span style="color:red;">(*)</span></label>
                                                <input type="text" name="num_int_derecho" value="{{ $poder->NExtAbogado }}" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                <div class="invalid-feedback">
                                                    El nombre es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <label for="name">Nun Ext</span></label>
                                                <input type="text" name="num_ext_derecho" value="{{ $poder->NIntAbogadoAlta }}" class="form-control" oninput="this.value = this.value.toUpperCase()" > 
                                                <div class="invalid-feedback">
                                                    El nombre es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <label for="name">C.P. <span style="color:red;">(*)</span></label>
                                                <input type="text" name="cp_derecho" value="{{ $poder->cpAbogadoAlta }}" class="form-control" minlength="5" maxlength="5" oninput="this.value = this.value.toUpperCase()" > 
                                                <div class="invalid-feedback">
                                                    El nombre es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <h4 class="text-center" style="color:#CEA845">Datos de la fuente laboral</h4>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="name">RFC <span style="color:red;">(*)</span></label>
                                                <input type="text" name="RFC_derecho" value="{{ $poder->rfc }}" class="form-control" minlength="13" maxlength="13" oninput="this.value = this.value.toUpperCase()" > 
                                                <div class="invalid-feedback">
                                                    El nombre es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-8">
                                            <div class="form-group">
                                                <label for="">Giro Comercial</label>
                                                <input type="text" class="form-control" value="{{ $poder->industria }}" name="industriaAlta" >
                                                <div class="invalid-feedback">
                                                    La industria es obligatoria.
                                                </div>
                                            </div>
                                        </div>        
                                    @endif

                                    






                                    
                                    


                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label>*Identificación oficial</label><br>
                                            <a target="_blank" class="btn btn-primary" href="../../storage/app/documentos_abogados/{{$poder->ine}}">Existente</a>
                                            <input type="file" name="documentoIne" class="form-control-file" accept=".pdf">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label>*Documento que acredite la representación</label><br>
                                            <a target="_blank" class="btn btn-primary" href="../../storage/app/documentos_abogados/{{$poder->representacion}}">Existente</a>
                                            <input type="file" name="documentoRepresentacion" class="form-control-file" accept=".pdf">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label>Anexos</label><br>
                                            @php
                                                if($poder->anexo === "Sin anexo")
                                                    echo "<td>S/A</td>";
                                                else
                                                    echo "<a target='_blank'  class='btn btn-primary' href='../../storage/app/documentos_abogados/$poder->anexo'>Existente</a>";
                                            @endphp
                                            <input type="file" name="documentoAnexo" class="form-control-file" accept=".pdf">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label>Anexos 2</label><br>
                                            @php
                                                if($poder->cedula === "Sin carta poder")
                                                    echo "<td>S/A</td>";
                                                else
                                                    echo "<a target='_blank' class='btn btn-primary' href='../../storage/app/documentos_abogados/$poder->cedula'>Existente</a>";
                                            @endphp
                                            <input type="file" name="documentoPoder" class="form-control-file" accept=".pdf">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">                               
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div
                                </div>
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
    <script src="../public/assets/js/poderes/general.js"></script>
@endsection
