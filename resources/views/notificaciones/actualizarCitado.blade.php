@extends('layouts.app_editar')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Notificaciones</h3>
        </div>
        <div class="section-body">
            <?php $fecha_actual = date('d-m-Y');?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!--<h3 class="text-center">Notificación</h3>-->
                            
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
                            <form method="POST" action="{{ route('seer.cambioEstatus') }}" class="needs-validation" novalidate enctype='multipart/form-data'>
                                @csrf
                                <input type="hidden" name="id" value="{{$id}}">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="name">NUE</label>
                                            <input type="text" name="nue" class="form-control" value="<?=$NUE;?>" readonly> 
                                            <div class="invalid-feedback">
                                                El campo nombre es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="name">Nombre del Citado</label>
                                            <input type="text" name="nombre_citado" class="form-control" value="{{ trim($citado->nombre . ' ' . ($citado->primer_apellido ?? '') . ' ' . ($citado->segundo_apellido ?? '')) }}" readonly> 
                                            <div class="invalid-feedback">
                                                El campo nombre es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="name">Dirección del citado</label>
                                            <input type="text" name="nombre_citado" class="form-control" value="{{ trim($citado->tipo_vialidad . ' ' . ($citado->calle ?? '') . ', ' . ($citado->n_ext ?? '') . ', ' . ($citado->n_int ?? '') . ', ' . ($citado->colonia ?? '') . ', ' . ($citado->cp ?? '') . ', ' . ($nombre_municipio ?? '') . ', ' . ($nombre_estado ?? '')) . '.' }}" readonly> 
                                            <div class="invalid-feedback">
                                                El campo nombre es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 mb-3">
                                        <label for="name">Referencia 1</label><br>
                                        @if (!empty($citado->imagen_domicilio1) && $citado->imagen_domicilio1 !== 'Sin documento')
                                            <a target='_blank' href="{{ asset('storage/app/documentosSolicitud/'.$citado->imagen_domicilio1) }}">VER IMAGEN</a>
                                        @else
                                            <span class="text-muted">No se subió imagen</span>
                                        @endif
                                        <input type="hidden" name="imagen_domicilio1" value="{{ $citado->imagen_domicilio1 }}">
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 mb-3">
                                        <label for="name">Referencia 2</label><br>
                                        @if (!empty($citado->imagen_domicilio2) && $citado->imagen_domicilio2 !== 'Sin documento')
                                            <a target='_blank' href="{{ asset('storage/app/documentosSolicitud/'.$citado->imagen_domicilio2) }}">VER IMAGEN</a><br>
                                        @else
                                            <span class="text-muted">No se subió imagen</span>
                                        @endif
                                        <input type="hidden" name="imagen_domicilio2" value="{{ $citado->imagen_domicilio2 }}">
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12" style="background-color:#D2D3D5; width:100%; height:25px;">
                                        <h5 class="text-center" style="color:black">Expediente</h5>
                                    </div>
                                </div>    
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Tipo de guardado <span style="color:red;">(*)</span></label>
                                            <select class="form-control" name="tipo_llenado" required>
                                                <option value="">Seleccione</option>
                                                <option value="1">Actualizar unicamente esta notificicación</option>
                                                <option value="2">Actualizar todo el Expediente</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label>¿Quién atiende? <span style="color:red;">(*)</span></label>
                                            <select name="quien_atiende" id="quien_atiende"class="form-control" required>
                                                <option value="">Selecciona</option>
                                                <option value="CITADO O REPRESENTANTE">El citado o representante legal</option>
                                                <option value="OTRA PERSONA">Otra persona</option>
                                                <option value="NADIE">Nadie</option>
                                            </select>
                                        </div>
                                        <div class="invalid-feedback">
                                            El campo es obligatorio.
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12" style="background-color:#D2D3D5; width:100%; height:25px;">
                                        <h5 class="text-center" style="color:black">Medios de cercioramiento de domicilio</h5>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label>Medio <span style="color:red;">(*)</span></label>
                                            <select name="medio[]" id="medio" class="form-select select2" multiple required>
                                                <option value="">Selecciona</option>
                                                <option value="PLACAS OFICIALES">Placas oficiales</option>
                                                <option value="NÚMERO VISIBLE">Número visible</option>
                                                <option value="NUMERACIÓN CONSISTENTE">Numeración consistente</option>
                                                <option value="INFORMES DE VECINOS">Informes de vecinos</option>
                                                <option value="RÓTULOS VISIBLES">Rótulos visibles</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-xs-12 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label>Tipo de vialidad <span style="color:red;">(*)</span></label>
                                            <select name="vialidad_notificacion" class="form-control" required>
                                                <option value="">Selecciona</option>
                                                <option value="AMPLIACION">Ampliación</option>
                                                <option value="ANDADOR">Andador</option>
                                                <option value="AUTOPISTA">Autopista</option>
                                                <option value="AVENIDA">Avenida</option>
                                                <option value="BOULEVARD">Boulevard</option>
                                                <option value="CALLE">Calle</option>
                                                <option value="CALLEJÓN">Callejón</option>
                                                <option value="CALZADA">Calzada</option>
                                                <option value="CARRETERA">Carretera</option>
                                                <option value="CERRADA">Cerrada</option>
                                                <option value="CIRCUITO">Circuito</option>
                                                <option value="CIRCUNVALACIÓN">Circunvalación</option>
                                                <option value="CONTINUACIÓN">Continuación</option>
                                                <option value="CORREDOR">Corredor</option>
                                                <option value="DIAGONAL">Diagonal</option>
                                                <option value="EJE VIAL">Eje vial</option>
                                                <option value="PERIFÉRICO">Periférico</option>
                                                <option value="PROLONGACIÓN">Prolongación</option>
                                                <option value="PRIVADA">Privada</option>
                                                <option value="RETORNO">Retorno</option>
                                                <option value="VIADUCTO">Viaducto</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Abundar área <span style="color:red;">(*)</span></label>
                                            <textarea class="form-control" name="abundar_area" rows="4" oninput="this.value = this.value.toUpperCase()" required></textarea>
                                            <div class="invalid-feedback">
                                                El campo abundar área es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Abundar inmueble <span style="color:red;">(*)</span></label>
                                            <textarea class="form-control" name="abundar_inmueble" rows="4" oninput="this.value = this.value.toUpperCase()" required></textarea>
                                            <div class="invalid-feedback">
                                                El campo abundar inmueble es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 dqr-group" style="background-color:#D2D3D5; width:100%; height:25px;">
                                        <h5 class="text-center" style="color:black">Datos de quien recibe</h5>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 dqr-group">
                                        <div class="form-group">
                                            <label for="name">Nombre <span style="color:red;">(*)</span></label>
                                            <input type="text" name="nombre_notificacion" class="form-control" oninput="this.value = this.value.toUpperCase()" required data-required-default="true"> 
                                            <div class="invalid-feedback">
                                                El campo nombre es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 dqr-group">
                                        <div class="form-group">
                                            <label for="name">Relación (respecto al domicilio) <span style="color:red;">(*)</span></label>
                                            <select name="relacion_notificacion" class="form-control" required data-required-default="true">
                                                <option value="">Selecciona</option>
                                                <option value="RESIDE">Reside</option>
                                                <option value="TRABAJA">Trabaja</option>
                                            </select> 
                                            <div class="invalid-feedback">
                                                El campo relación inmueble es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 dqr-group">
                                        <div class="form-group">
                                            <label for="name">Puesto <span style="color:red;">(*)</span> </label>
                                            <input type="text" name="puesto" class="form-control" oninput="this.value = this.value.toUpperCase()" required data-required-default="true"> 
                                            <div class="invalid-feedback">
                                                El campo puesto es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6 dqr-group">
                                        <div class="form-group">
                                            <label for="name">Identificación <span style="color:red;">(*)</span></label>
                                            <select name="identificacion_notificacion" id="identificacion_notificacion" class="form-control" required data-required-default="true">
                                                <option value="">Selecciona</option>
                                                <option value="NO PROPORCIONA">No proporciona</option>
                                                <option value="NO ATIENDE PRESENCIALMENTE">No atiende presencialmente (Persona no visible)</option>
                                                <option value="CREDENCIAL PARA VOTAR">Credencial para votar</option>
                                                <option value="LICENCIA O PERMISO PARA CONDUCIR">Licencia o permiso para conducir</option>
                                                <option value="CREDENCIAL DE IDENTIFICACION LABORAL">Credencial de identificación laboral</option>
                                                <option value="CREDENCIAL DE INSTITUCIÓN DE SALUD">Credencial de institución de salud</option>
                                                <option value="CREDENCIAL DE INSTITUCIÓN ESCOLAR">Credencial de institución de escolar</option>
                                                <option value="CARTILLA DE SERVICIO MILITAR">Cartilla de servicio militar</option>
                                                <option value="PASAPORTE">Pasaporte</option>
                                                <option value="CÉDULA PROFESIONAL">Cédula profesional</option>
                                                <option value="RFC">RFC</option>
                                                <option value="OTRA IDENTIFICACIÓN">Otra identificación</option>

                                            </select>
                                            <div class="invalid-feedback">
                                                El campo identificación es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div id="motivo_identificacion" class="col-xs-12 col-sm-12 col-md-12 dqr-group">
                                        <div class="form-group">
                                            <label for="name">Motivo de la no identificación</label>
                                            <input type="text" name="motivo_identificacion" class="form-control" oninput="this.value = this.value.toUpperCase()"> 
                                        </div>
                                    </div>
                                    <div id="media-filiacion" class="dqr-group" style="display: none;">
                                        <div class="col-xs-12 col-sm-12 col-md-12" style="background-color:#D2D3D5; width:100%; height:25px;">
                                            <h5 class="text-center" style="color:black">Media filiación de persona que recibe</h5>
                                        </div>
                                        <div class="row">                                      
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Género <span style="color:red;">(*)</span></label>
                                                    <select name="genero" class="form-control" required data-required-default="true">
                                                        <option value="">Selecciona</option>
                                                        <option value="MASCULINO">MASCULINO</option>
                                                        <option value="FEMENINO">FEMENINO</option>
                                                    </select>
                                                    <div class="invalid-feedback">
                                                        El campo genero es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Tez <span style="color:red;">(*)</span></label>
                                                    <input type="text" name="tez" class="form-control" oninput="this.value = this.value.toUpperCase()" required data-required-default="true"> 
                                                    <div class="invalid-feedback">
                                                        El campo tez es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Edad <span style="color:red;">(*)</span></label>
                                                    <input type="text" name="edad_filiacion" class="form-control" oninput="this.value = this.value.toUpperCase()" required data-required-default="true"> 
                                                    <div class="invalid-feedback">
                                                        El campo edad es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                    
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Altura <span style="color:red;">(*)</span></label>
                                                    <input type="text" name="altura" class="form-control" oninput="this.value = this.value.toUpperCase()" required data-required-default="true"> 
                                                    <div class="invalid-feedback">
                                                        El campo altura es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                    
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Complexión <span style="color:red;">(*)</span></label>
                                                    <input type="text" name="complexion" class="form-control" oninput="this.value = this.value.toUpperCase()" required data-required-default="true"> 
                                                    <div class="invalid-feedback">
                                                        El campo complexión es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                    
                                            <div class="col-xs-12 col-sm-12 col-md-6">
                                                <div class="form-group">
                                                    <label for="name">Cabello <span style="color:red;">(*)</span></label>
                                                    <input type="text" name="cabello" class="form-control" oninput="this.value = this.value.toUpperCase()" required data-required-default="true"> 
                                                    <div class="invalid-feedback">
                                                        El campo cabello es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                    
                                            <div class="col-xs-12 col-sm-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="name">Ojos <span style="color:red;">(*)</span></label>
                                                    <input type="text" name="ojos" class="form-control" oninput="this.value = this.value.toUpperCase()" required data-required-default="true"> 
                                                    <div class="invalid-feedback">
                                                        El campo ojos es obligatorio.
                                                    </div>
                                                </div>
                                            </div>
                    
                                            <div class="col-xs-12 col-sm-12 col-md-9">
                                                <div class="form-group">
                                                    <label for="name">Señas particulares<span style="color:red;">(*)</span> </label>
                                                    <input type="text" name="particulares" class="form-control" oninput="this.value = this.value.toUpperCase()" required data-required-default="true"> 
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <!-- Fin de Media filiación -->
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label>Firma <span style="color:red;">(*)</span></label>
                                            <select name="firma" class="form-control" required>
                                                <option value="">Selecciona</option>
                                                <option value="NO FIRMA">No firma</option>
                                                <option value="FIRMA">Firma</option>
                                                <option value="SELLA">Sella</option>
                                                <option value="FIRMA Y SELLA">Firma y sella</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                El campo firma es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label>Finalización de diligencia <span style="color:red;">(*)</span></label>
                                            <select name="estatus" id="estatus" class="form-control" required>
                                                <option value="">Selecciona</option>
                                                <option value="Finalizado exitosamente">Finalizado exitosamente (persona)</option>
                                                <option value="No notificada">Exitoso por instructivo (fijado en puerta)</option>
                                                <option value="No exitosa se constituye">No exitoso, se constituye</option>
                                                <option value="No exitosa no se constituye">No exitoso, no se constituye (amparo)</option>
                                                <option value="Notificada">Notificado</option>
                                                <option value="Recibe pero no firma">Recibe pero no firma</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                   <!-- Si la respuesta es no existosa, se contituye, beberán contestar está pregunta (Tipo problema)-->
                                    <div class="col-xs-12 col-sm-6 col-md-4" id="tipo_problema1" style="display:none;">
                                        <div class="form-group">
                                            <label for="name">Tipo de problema</label>
                                            <select id="problema1" name="problema_diligencia" class="form-control">
                                                <option value="">Selecciona</option>
                                                    <optgroup label="Domicilio">
                                                        <option value="CERRADO">Cerrado</option>
                                                        <option value="NO ACCESO AL INMUEBLE">No acceso al inmueble</option>
                                                    <optgroup label="Número">
                                                        <option value="NO SEÑALA INTERIOR">No señala interior</option>
                                                        <option value="NÚMERO INTERIOR SEÑALADO NO SE LOCALIZÓ EN DOMICILIO">Número interior señalado no se localizó en domicilio</option>
                                                        <option value="NO LOGRO LOCALIZAR EL NÚMERO">No logro localizar el número</option>
                                                        <option value="NO SE LOCALIZA EL INMUEBLE CON NÚMERO, MANZANA, LOTE, ETC. SEALADOS">No se localiza el inmueble con número, manzana, lote, etc. señalados</option>
                                                    <optgroup label="Calle">
                                                        <option value="NO EXISTE EN COLONIA">No existe en colonia</option>
                                                    <optgroup label="Colonia">
                                                        <option value="NO EXISTE EN MUNICIPIO">No existe en municipio</option>
                                                    <optgroup label="Alguien atiende">
                                                        <option value="RAZÓN SOCIAL DIVERSA">Razón social diversa</option>
                                                    <optgroup label="Otros">
                                                        <option value="OTROS">Otros</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Cuando es no existoso, no se contituye, mostrar estas opciones en (Tipo de problema)-->
                                    <div class="col-xs-12 col-sm-6 col-md-4" id="tipo_problema2" style="display:none;">
                                        <div class="form-group">
                                            <label for="name">Tipo de problema</label>
                                            <select id="problema2" name="problema_diligencia" class="form-control">
                                                <option value="">Selecciona</option>
                                                    <optgroup label="Domicilio incompleto">
                                                        <option value="OMITE NÚMERO">Omite número</option>
                                                        <option value="OMITE VIALIDAD">Omite vialidad</option>
                                                        <option value="OMITE COLONIA">Omite colonia</option>
                                                        <option value="OMITE MUNICIPIO">Omite municipio</option>
                                                    <optgroup label="Domicilio">
                                                        <option value="FUERA DE LA JURISDICCIÓN">Fuera de la jurisdicción</option>
                                                    <optgroup label="Copias">
                                                        <option value="NO HAY COPIAS SUFICIENTES">No hay copias suficientes</option>
                                     
                                            </select>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-12">
                                        <div class="form-group">
                                            <label for="name">Especificar en caso de que tenga un problema</label>
                                            <input type="text" class="form-control" name="especificar" oninput="this.value = this.value.toUpperCase()">
                                        </div>
                                    </div>
                                    
                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="name">Imagen 1 <span style="color:red;">(*)</span></label>
                                            <input type="file" class="form-control" name="foto" accept="image/*" required>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="name">Imagen 2</label>
                                            <input type="file" class="form-control" name="foto1" accept="image/*">
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6 col-md-4">
                                        <div class="form-group">
                                            <label for="name">Imagen 3</label>
                                            <input type="file" class="form-control" name="foto2" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-12">
                                        <div class="form-group">
                                            <label for="name">Observaciones <span style="color:red;">(*)</span></label>
                                            <textarea class="form-control" name="observaciones" rows="4" oninput="this.value = this.value.toUpperCase()" required></textarea>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Fecha de notificación <span style="color:red;">(*)</span></label>
                                            <input type="date" class="form-control" name="fecha_notificacion" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Hora de notificación <span style="color:red;">(*)</span></label>
                                            <input type="time" class="form-control" name="hora_notificacion" required> 
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <a href="{{ route('seer') }}" class="btn btn-secondary">Cancelar</a>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.getElementById("motivo_identificacion").style.display = "none";
        document.addEventListener('DOMContentLoaded', function () {
            const selectQuienAtiende = document.querySelector('select[name="quien_atiende"]');
            const mediaFiliacionDiv = document.getElementById('media-filiacion');
            const dqrGroups = Array.from(document.querySelectorAll('.dqr-group'));

            function setRequiredInGroups(groups, enabled) {
                groups.forEach(sectionEl => {
                    const fields = sectionEl.querySelectorAll('input, select, textarea');
                    fields.forEach(el => {
                        const shouldBeRequiredByDefault = el.hasAttribute('data-required-default');
                        if (enabled) {
                            if (shouldBeRequiredByDefault) el.setAttribute('required', '');
                        } else {
                            el.removeAttribute('required');
                        }
                    });
                });
            }

            if (selectQuienAtiende) {
                console.log("Select encontrado");
                selectQuienAtiende.addEventListener('change', function () {
                    console.log("Cambio:", this.value);
                    if(this.value === 'NADIE'){
                        dqrGroups.forEach(el => el.style.display = 'none');
                        setRequiredInGroups(dqrGroups, false);
                    } else {
                        dqrGroups.forEach(el => el.style.display = '');
                        setRequiredInGroups(dqrGroups, true);
                    }

                    if (this.value === 'OTRA PERSONA') {
                        mediaFiliacionDiv.style.display = 'block';
                        setRequiredInGroups([mediaFiliacionDiv], true);
                    } else {
                        mediaFiliacionDiv.style.display = 'none';
                        setRequiredInGroups([mediaFiliacionDiv], false);
                    }
                });

                const initial = selectQuienAtiende.value;
                if (initial === 'NADIE') {
                    dqrGroups.forEach(el => el.style.display = 'none');
                    setRequiredInGroups(dqrGroups, false);
                } else {
                    dqrGroups.forEach(el => el.style.display = '');
                    setRequiredInGroups(dqrGroups, true);
                }

                if (initial === 'OTRA PERSONA') {
                    mediaFiliacionDiv.style.display = 'block';
                    setRequiredInGroups([mediaFiliacionDiv], true);
                } else {
                    mediaFiliacionDiv.style.display = 'none';
                    setRequiredInGroups([mediaFiliacionDiv], false);
                }
            } else {
                console.warn("No se encontró el select[name='quien_atiende']");
            }  

        });
        document.addEventListener('DOMContentLoaded', function () {
            const selectEstatus = document.getElementById('estatus');
            const problema1Div = document.getElementById('tipo_problema1');
            const problema2Div = document.getElementById('tipo_problema2');

            function actualizarTipoProblema() {
                const valor = selectEstatus.value;

                // Oculta ambos inicialmente
                problema1Div.style.display = 'none';
                problema2Div.style.display = 'none';

                if (valor === 'No exitosa se constituye') {
                    problema1Div.style.display = 'block';
                } else if (valor === 'No exitosa no se constituye') {
                    problema2Div.style.display = 'block';
                }
            }

            if (selectEstatus) {
                selectEstatus.addEventListener('change', actualizarTipoProblema);
                // Ejecutar al cargar por si ya tiene valor
                actualizarTipoProblema();
            }
        });
        //Ocultar media filiación cuando si se presenta una identificación
        document.addEventListener('DOMContentLoaded', function () {
            const selectQuienAtiende = document.querySelector('select[name="quien_atiende"]');
            const selectIdentificacion = document.getElementById('identificacion_notificacion');
            const mediaFiliacionDiv = document.getElementById('media-filiacion');
            const motivoIdenDiv = document.getElementById('motivo_identificacion');
            const dqrGroups = Array.from(document.querySelectorAll('.dqr-group'));

            function setRequiredInGroups(groups, enabled) {
                groups.forEach(sectionEl => {
                    if (!sectionEl) return;
                    const fields = sectionEl.querySelectorAll('input, select, textarea');
                    fields.forEach(el => {
                        const shouldBeRequiredByDefault = el.hasAttribute('data-required-default') || el.hasAttribute('required');
                        if (enabled) {
                            if (shouldBeRequiredByDefault) el.setAttribute('required', '');
                        } else {
                            el.removeAttribute('required');
                        }
                    });
                });
            }
            function actualizarFormulario() {
                const quienAtiende = selectQuienAtiende ? selectQuienAtiende.value : '';
                const idenValor = selectIdentificacion ? selectIdentificacion.value : '';

                if (idenValor === 'NO PROPORCIONA' || idenValor === 'NO ATIENDE PRESENCIALMENTE') {
                    motivoIdenDiv.style.display = "block";
                } else {
                    motivoIdenDiv.style.display = "none";
                }

                const personasQuePuedenRecibir = ['OTRA PERSONA', 'CITADO O REPRESENTANTE'];
                const sinIdentificacionValida = ['NO PROPORCIONA'];

                if (personasQuePuedenRecibir.includes(quienAtiende) && sinIdentificacionValida.includes(idenValor)) {
                    mediaFiliacionDiv.style.display = 'block';
                    setRequiredInGroups([mediaFiliacionDiv], true);
                } else {
                    mediaFiliacionDiv.style.display = 'none';
                    setRequiredInGroups([mediaFiliacionDiv], false);
                }
            }

            if (selectQuienAtiende) {
                selectQuienAtiende.addEventListener('change', actualizarFormulario);
            }
            if (selectIdentificacion) {
                selectIdentificacion.addEventListener('change', actualizarFormulario);
            }

            actualizarFormulario();
        });
        /*const tipo_iden = document.getElementById('identificacion_notificacion');
        tipo_iden.addEventListener('change', function() {
            const valorSeleccionado = this.value;
            // Realiza la validación o acciones necesarias
            if (valorSeleccionado === 'NO PROPORCIONA') {
                document.getElementById('motivo_identificacion').style.display = "block";
            }
            else {
                document.getElementById('motivo_identificacion').style.display = "none";
            }
        });*/
    </script>
@endsection

<div id="menu_carga" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>

@section('scripts')
    <script src="../../public/assets/js/estadistica/estadistica.js"></script>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Inicializar select2 si aplica
            $('#medio').select2({
                placeholder: "Selecciona uno o más medios",
                allowClear: true
            });
        });
    </script>
@endpush

