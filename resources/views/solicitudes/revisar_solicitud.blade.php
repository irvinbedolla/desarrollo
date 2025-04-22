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

                            @can('crear-seer')
                                <form class="needs-validation novalidate" method="POST" action="{{route('confirmar_solicitud')}}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <h4 class="text-center">Datos Generales</h4>
                                            </div>
                                        </div><br>
                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label for="name">Datos Generales</label>
                                                <input type="text" class="form-control" value="<?=$general["fecha"];?>" >
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <div class="form-group">
                                                <label for="email">Fecha Conflicto</label>
                                                <input type="text" class="form-control" value="<?=$general["fecha_conflicto"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label for="password">Actividad</label>
                                                <input type="text" class="form-control" value="<?=$general["actividad"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-12">
                                            <div class="form-group">
                                                <label for="password">Rama Industrial</label>
                                                <input type="text" class="form-control" value="<?=$rama["rama_industrial"];?>">
                                            </div>
                                        </div>

                                                                             
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <h4 class="text-center">Solicitante(s)</h4>
                                            </div>
                                        </div>

                                        @foreach($solicitantes as $solicitante)
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
                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Nombre</label>
                                                    <input type="text" class="form-control" name="nombre" value="<?=$solicitante["nombre"];?>">   
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
                                                    <input type="text" class="form-control" name="fecha_nacimiento" value="<?=$solicitante["fecha_nacimiento"];?>">   
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
                                                    <input type="text" class="form-control" name="telefono" value="<?=$solicitante["telefono"];?>">   
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="password">Email</label>
                                                    <input type="text" class="form-control" name="email" value="<?=$solicitante["email"];?>">   
                                                </div>
                                            </div>

                                        @endforeach

                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <h4 class="text-center">Datos Citado(s)</h4>
                                            </div>
                                        </div>

                                        @foreach($citados as $citado)
                                            <div class="col-xs-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="confirm-password">Tipo de Persona</label>
                                                    <select name="tipo_persona" class="form-control">
                                                        <option value="Fisica" {{ $citado["tipo_persona"] == 'Fisica' ? "selected" : '' }}>Fisica</option>
                                                        <option value="Moral"  {{ $citado['tipo_persona'] == 'Moral' ? "selected" : '' }}>Moral</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="confirm-password">CURP</label>
                                                    <input type="text" class="form-control" name="curp" value="<?=$citado["curp"];?>">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Nombre(s)</label>
                                                    <input type="text" class="form-control" name="nombre" value="<?=$citado["nombre"];?>">   
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Primer Apellido</label>
                                                    <input type="text" class="form-control" name="nombre" value="<?=$citado["primer_apellido"];?>">   
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Segundo Apellido</label>
                                                    <input type="text" class="form-control" name="nombre" value="<?=$citado["segundo_apellido"];?>">   
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="password">RFC</label>
                                                    <input type="text" class="form-control" name="rfc" value="<?=$citado["rfc"];?>">   
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="password">Fecha Nacimiento</label>
                                                    <input type="text" class="form-control" name="fecha_nacimiento" value="<?=$citado["fecha_nacimiento"];?>">   
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="password">Colonia</label>
                                                    <input type="text" class="form-control" name="colonia" value="<?=$citado["colonia"];?>">   
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="password">Código Postal</label>
                                                    <input type="text" class="form-control" name="cp" value="<?=$citado["cp"];?>">   
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="password">Calle</label>
                                                    <input type="text" class="form-control" name="calle1" value="<?=$citado["calle1"];?>">   
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-6 col-md-3">
                                                <div class="form-group">
                                                    <label for="password">Calle</label>
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
                                        @endforeach

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <h4 class="text-center">Documentos</h4>
                                            </div>
                                        </div><br>

                                        <div class="col-xs-12 col-sm-12 col-md-4">
                                            @if(!isset($general->documentoIne))
                                                Sin documento.
                                            @else
                                                <label for="password">Identificacíon Oficial</label><br>
                                                <a target='_blank' href='../storage/app/documentosSolicitud/{{$general->documentoIne}}'>PDF</a>
                                            @endif
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-4">
                                            @if(!isset($general->documentoIne))
                                                Sin documento.
                                            @else
                                                <label for="password">Acta de Nacimiento</label><br>
                                                <a target='_blank' href='../storage/app/documentosSolicitud/{{$general->documentoActa}}'>PDF</a>
                                            @endif
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-4">
                                            @if(!isset($general->documentoIne))
                                                Sin documento.
                                            @else
                                                <label for="password">CURP</label><br>
                                                <a target='_blank' href='../storage/app/documentosSolicitud/{{$general->documentoCurp}}'>PDF</a>
                                            @endif
                                        </div><br><br>


                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <button type="submit" class="btn btn-primary" style="background-color:#CEA845; border-color:#CEA845;">Confirmar</button>
                                            <a class="btn btn-danger" href="{{ route('solicitud_rechazar') }}">Rechazar</a>
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

