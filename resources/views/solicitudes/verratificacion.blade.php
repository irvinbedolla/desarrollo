@extends('layouts.app_editar')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Ratificación</h3>
        </div>
        <div class="section-body">
            <?php $fecha_actual = date('d-m-Y');?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Ratificación </h3>
                            
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

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="name">Folio de solicitud</label>
                                                <input type="text" class="form-control" value="<?=$folio["id"];?>"readonly>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                                <div class="form-group">
                                                    <label for="email">Nombre de la empresa</label>
                                                    <input type="text" class="form-control" value="<?=$folio["empresa"];?>">
                                                </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Primer apellido</label>
                                                <input type="text" class="form-control" value="<?=$folio["primero_empresa"];?>">
                                            </div>
                                        </div>
                                         <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Segundo apellido</label>
                                                <input type="text" class="form-control" value="<?=$folio["segundo_empresa"];?>">
                                             </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Nombre</label>
                                                <input type="text" class="form-control" value="<?=$folio["nombre_empresa"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" value="<?=$folio["email"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Telefono</label>
                                                <input type="text" class="form-control" value="<?=$folio["telefono"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Curp</label>
                                                <input type="text" class="form-control" value="<?=$folio["curp_solicitante"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <h4 class="text-center">Datos del trabajador</h4>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Edad</label>
                                                <input type="text" class="form-control" value="<?=$folio["edad"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Sexo</label>
                                                <input type="text" class="form-control" value="<?=$folio["sexo"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Salario</label>
                                                <input type="text" class="form-control" value="<?=$folio["salario"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Monto acordado</label>
                                                <input type="text" class="form-control" value="<?=$folio["monto"];?>">
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Nombre</label>
                                                <input type="text" class="form-control" value="<?=$folio["trabajador"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Fecha</label>
                                                <input type="text" class="form-control" value="<?=$folio["fecha"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Hora inicio</label>
                                                <input type="text" class="form-control" value="<?=$folio["hora"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Auxiliar</label>
                                                <input type="text" class="form-control" value="<?=$folio["auxiliar"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Primer apellido</label>
                                                <input type="text" class="form-control" value="<?=$folio["primero_trabajador"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Segundo apellido</label>
                                                <input type="text" class="form-control" value="<?=$folio["segundo_trabajador"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Frecuencia</label>
                                                <input type="text" class="form-control" value="<?=$folio["frecuencia"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Dias</label>
                                                <input type="text" class="form-control" value="<?=$folio["dias"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Estatus</label>
                                                <select class="form-control" name="estatus" required>
                                                    <option value="Pendiente" @php if($folio->estatus === "Pendiente") echo "selected"  @endphp>Pendiente</option>
                                                    <option value="Atendido" @php if($folio->estatus === "atendido") echo "selected"  @endphp>Atendido</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Sede</label>
                                                <input type="text" class="form-control" value="<?=$folio["delegacion"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">INE</label>
                                                <a target="_blank" class="btn btn-primary" href="../../storage/app/documentosSolicitud/{{$folio->ine}}">Existente</a>
                                                <input type="file" name="documentoIne" class="form-control-file" accept=".pdf">        
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label>*Documento que acredite la representación</label><br>
                                                <a target="_blank" class="btn btn-primary" href="../../storage/app/documentosSolicitud/{{$folio->representacion}}">Existente</a>
                                                <input type="file" name="documentoRepresentacion" class="form-control-file" accept=".pdf">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="text" class="form-control" value="<?=$folio["email"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Telefono</label>
                                                <input type="text" class="form-control" value="<?=$folio["telefono"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">JLCA</label>
                                                <input type="text" class="form-control" value="<?=$folio["JLCA"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Motivo</label>
                                                <input type="text" class="form-control" value="<?=$folio["motivo"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Curp trabajador</label>
                                                <input type="text" class="form-control" value="<?=$folio["trabajador_curp"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email"> Documento curp</label>
                                                <a target="_blank" class="btn btn-primary" href="../../storage/app/documentosSolicitud/{{$folio->documentoCurp}}">Existente</a>
                                                <input type="file" name="documentoCurp" class="form-control-file" accept=".pdf">        
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Tipo identificación</label>
                                                <input type="text" class="form-control" value="<?=$folio["tipo_identificacion"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Documento identificación</label>
                                                <a target="_blank" class="btn btn-primary" href="../../storage/app/documentosSolicitud/{{$folio->documentoidentificacion}}">Existente</a>
                                                <input type="file" name="documentoidentificacion" class="form-control-file" accept=".pdf">        
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Prima vacacional</label>
                                                <input type="text" class="form-control" value="<?=$folio["PrimaVacacional"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Fecha inicio</label>
                                                <input type="text" class="form-control" value="<?=$folio["fecha_inicio"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Fecha termino</label>
                                                <input type="text" class="form-control" value="<?=$folio["fecha_termino"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Categoria</label>
                                                <input type="text" class="form-control" value="<?=$folio["categoria"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Tipo pago</label>
                                                <input type="text" class="form-control" value="<?=$folio["tipo_pago"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Aguinaldo</label>
                                                <input type="text" class="form-control" value="<?=$folio["Aguinaldo"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Vacaciones</label>
                                                <input type="text" class="form-control" value="<?=$folio["Vacaciones"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Pago PTU</label>
                                                <input type="text" class="form-control" value="<?=$folio["PagoPTU"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Prima antiguedad</label>
                                                <input type="text" class="form-control" value="<?=$folio["PrimaAntigüedad"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Horario</label>
                                                <input type="text" class="form-control" value="<?=$folio["horario"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-4">
                                            <div class="form-group">
                                                <label for="email">Domicilio</label>
                                                <input type="text" class="form-control" value="<?=$folio["domicilio"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-12">
                                            <div class="form-group">
                                                <label for="email">Observaciones</label>
                                                <input type="text" class="form-control" value="<?=$folio["observaciones"];?>">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <a class="btn btn-primary" href="{{ route('Ratificacion') }}">Regresar</a>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>    
                                    </div>


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
