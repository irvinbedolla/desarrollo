@extends('layouts.app')

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
                            <h3 class="text-center">Solicitudes Pendientes</h3>
                            
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

                            @can('crear-seer')
                                <form class="needs-validation novalidate" method="POST" action="{{route('confirmar_solicitud')}}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label for="name">Datos Generales</label>
                                                <input type="date" class="form-control" value="<?=$general["fecha"];?>" >
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
                                                    <label for="confirm-password">Traductor</label>
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
                                                    <label for="password">Télefono</label>
                                                    <input type="text" class="form-control" name="telefono2" value="<?=$solicitante["telefono2"];?>">   
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="password">Email</label>
                                                    <input type="text" class="form-control" name="email" value="<?=$solicitante["email"];?>">   
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
                                            <div class="col-xs-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="password">Pago</label>
                                                    <input type="text" class="form-control" name="pago" value="<?=$solicitante["pago"];?>">   
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

                                        <br>
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
                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Nombre</label>
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
                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Colonia</label>
                                                    <input type="text" class="form-control" name="colonia" value="<?=$citado["colonia"];?>">   
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Calle</label>
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
                                        @endforeach

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
                                        </div><br><br>


                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <button type="submit" class="btn btn-primary" style="background-color:#CEA845; border-color:#CEA845;">Confirmar</button>
                                            <a class="btn btn-danger" href="{{ route('rechazar_solicitud') }}">Rechazar</a>
                                        </div>
                                    </div>
                                </form>
                            @endcan


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
    <script src="../../public/js/estadistica/estadistica.js"></script>
@endsection

