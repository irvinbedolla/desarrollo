@extends('layouts.app_editar')
@php
    $fechaActual = date('Y-m-d');
    $contador = 0;
@endphp
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Revisar Ratificación</h3>
        </div>
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Correcto</strong>
                {{ session()->get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped mt-1">
                                    <thead style="background-color: #4A001F;">
                                        <tr> 
                                            <th style="display:none">ID</th>
                                            <th style="color: #ffff;">Tipo parte</th>
                                            <th style="color: #ffff;">Nombre(s)</th>
                                            <th style="color: #ffff;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="display:none">{{$solicitud->id}}</td>
                                            <td style="color: #000000;"><b>Trabajador</b></td>
                                            <td>{{ $solicitud->trabajador }} {{ $solicitud->primero_trabajador }} {{ $solicitud->segundo_trabajador }}</td>
                                            <td>
                                                <a type="button" class="btn btn-warning open-modal" data-bs-toggle="modal" data-bs-target="#exampleModal1" data-id="{{ $idSolicitud }}">Editar</a>
                                            </td>
                                        </tr>
                                       <tr>
                                            <td style="display:none">{{$solicitud->id}}</td>
                                            <td style="color: #000000;"><b>Solicitante(Patronal)</b></td>
                                            <td>{{ $solicitud->nombre_empresa }} {{ $solicitud->primero_empresa }} {{ $solicitud->segundo_empresa }}</td>
                                            <td>
                                                <a type="button" class="btn btn-warning open-modal" data-bs-toggle="modal" data-bs-target="#modalCitados" data-id="{{ $idSolicitud }}">Cambiar</a>
                                            </td>
                                        </tr>     
                                    </tbody> 
                                </table>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <h4 class="text-center">Concepto de Pago</h4>
                                </div>
                            </div>
                            <table class="table table-striped mt-1">
                                            <thead style="background-color: #4A001F;">
                                                <tr> 
                                                    <th style="display:none">ID</th>
                                                    <th style="color: #ffff;">Tipo pago</th>
                                                    <th style="color: #ffff;">Monto</th>
                                                    <th style="color: #ffff;">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($conceptos as $concepto)
                                                    <tr>
                                                    <td  style="display:none">{{$concepto->id}}</td>
                                                        <td>{{ $concepto->descripcion}}</td>
                                                        <td>${{ number_format($concepto->monto,2) }}</td>
                                                        <td>
                                                            <form method="POST" action="{{ route('concepto_eliminar_pago_ratificacion', $concepto->id) }} ">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button class="btn btn-danger" onclick=editar_rol(); type="submit">Eliminar</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @php $contador++; @endphp
                                                @endforeach       
                                            </tbody> 
                            </table>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <h4 class="text-center">Deducciones</h4>
                                </div>
                            </div>
                            <table class="table table-striped mt-1">
                                            <thead style="background-color: #4A001F;">
                                                <tr> 
                                                    <th style="display:none">ID</th>
                                                    <th style="color: #ffff;">Tipo pago</th>
                                                    <th style="color: #ffff;">Monto</th>
                                                    <th style="color: #ffff;">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($deducciones as $concepto)
                                                    <tr>
                                                    <td  style="display:none">{{$concepto->id}}</td>
                                                        <td>{{ $concepto->descripcion}}</td>
                                                        <td>${{ number_format($concepto->monto,2) }}</td>
                                                        <td>
                                                            <form method="POST" action="{{ route('concepto_eliminar_deduccion_ratificacion', $concepto->id) }} ">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button class="btn btn-danger" onclick=editar_rol(); type="submit">Eliminar</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @php $contador++; @endphp
                                                @endforeach       
                                            </tbody> 
                            </table>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <h4 class="text-center">Pagos</h4>
                                    </div>
                                </div>
                            <table class="table table-striped mt-1">
                                            <thead style="background-color: #4A001F;">
                                                <tr> 
                                                    <th style="display:none">ID</th>
                                                    <th style="color: #ffff;">Fecha y Hora</th>
                                                    <th style="color: #ffff;">Descripción</th>
                                                    <th style="color: #ffff;">Monto</th>
                                                    <th style="color: #ffff;">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($pagos as $pago)
                                                    <tr>
                                                        <td  style="display:none">{{$pago->id}}</td>
                                                        <td>{{ $pago->hora }}</td>
                                                        <td>{{ $pago->descripcion}}</td>
                                                        <td>${{ number_format($pago->monto,2) }}</td>
                                                        <td>
                                                            <form method="POST" action="{{ route('pago_eliminar_pago', $pago->id) }} ">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="DELETE">
                                                                <button class="btn btn-danger" onclick=editar_rol(); type="submit">Eliminar</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    @php $contador++; @endphp
                                                @endforeach       
                                            </tbody> 
                            </table>
                            <form class='needs-validation novalidate' method='POST' action="{{route('terminar_ratificacion')}}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $idSolicitud }}">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12"  style="border:1px solid black;">
                                        <div class="form-group">
                                            <label for="name">RESOLUCIÓN PRIMERA MANIFESTACIÓN</label>
                                            <textarea name="primera" class="form-control">{{$solicitud->resolucion_primera}}</textarea>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div id="justificacion"><br>
                                        <div class="col-xs-12 col-sm-12 col-md-12" style="border:1px solid black;">
                                            <div class="form-group">
                                                <label for="name">RESOLUCIÓN JUSTIFICACIÓN PROPUESTA</label>
                                                <textarea name="justificacion" class="form-control" >{{$solicitud->resolucion_justificacion}}</textarea>
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div id="segunda" ><br>
                                        <div class="col-xs-12 col-sm-12 col-md-12" style="border:1px solid black;">
                                            <div class="form-group">
                                                <label for="name">RESOLUCIÓN SEGUNDA MANIFESTACIÓN</label>
                                                <textarea name="segunda" class="form-control" >{{$solicitud->resolucion_segunda}}</textarea>
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="dias" class="row home-shape">
                                        <div class="col-xs-12 col-sm-12 col-md-2"><br>
                                            <div class="form-group">
                                                <label for="name">Días de vacaciones</label>
                                                <input type="number" name="vacaciones" class="form-control" value="{{ $solicitud["vacaciones_dias"] }}"> 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-2"><br>
                                            <div class="form-group">
                                                <label for="name">Días de Aguinaldo</label>
                                                <input type="number" name="aguinaldo" class="form-control" value="{{ $solicitud["aguinaldo_dias"] }}"> 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-2"><br>
                                            <div class="form-group">
                                                <label for="name">Otros</label>
                                                <input type="text" name="otros" class="form-control" value="{{ $solicitud["otros_dias"] }}"> 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3"><br>
                                            <div class="form-group">
                                                <label for="name">Horario laboral</label>
                                                <input type="text" name="horario" class="form-control" value="{{ $solicitud["horario"] }}"> 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3"><br>
                                            <div class="form-group">
                                                <label for="name">Horario de comida</label>
                                                <input type="text" name="comida" class="form-control" value="{{ $solicitud["comida"] }}"> 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="pagos" class="row home-shape">
                                        <div class="col-xs-12 col-sm-12 col-md-12"></div>
                                        <div class="col-xs-12 col-sm-6 col-md-12">
                                            <button id="addRow" type="button" class="btn btn-info">Agregar Concepto de Pago</button>
                                        </div>                                        
                                        <div id="newRow"></div>
                                        <div class="col-xs-12 col-sm-12 col-md-12"><br>
                                            <button id="addRetencion" type="button" class="btn btn-info">Agregar deducción</button>
                                        </div>
                                        <div id="newRowDeduccion"></div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div id="div_pagos_diferidos1"><br>
                                                <button id="addPago" type="button" class="btn btn-info">Agregar Pago</button>
                                                <div id="newRowaPago"></div>
                                            </div>
                                        </div>
                                        <div id="div_pagos_diferidos"></div>
                                    </div>
                                </div><br><br>
                                  <div class="col-xs-12 col-sm-12 col-md-12">
                                            <h4 class="text-center" style="margin-top:20px;">Total a pagar:</h4>
                                            <h3 id="totalCalculado" class="text-center" style="color:green;">$0.00</h3>
                                        </div>
                                <div class="row">    
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <a  class="btn btn-success"href="{{ route('PDFconvenioratificacion', $solicitud->id) }}"  target="_blank">Convenio</a>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <a  class="btn btn-success" href="{{ route('PDFaudiencia', $solicitud->id) }}"  target="_blank">Acta de audiencia</a>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <button type="submit" class="btn btn-success">Terminar</button>
                                    </div>
                                </div>    
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<div id="nuevo_poder" style ="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>
<!-- Modal Solicitantes -->
<div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class='needs-validation novalidate'  method='POST' action="{{route('editar_ratificacion_revisar')}}">
        @csrf
        <input type="hidden" name="id" value="{{$idSolicitud}}">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Solicitante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">Nombre(s)</label>
                                <input type="text" name="nombre" class="form-control" oninput="this.value = this.value.toUpperCase()" value="<?=$solicitud["trabajador"];?>" required> 
                                <div class="invalid-feedback">
                                    El campo nombre es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">Primer Apellido</label>
                                <input type="text" name="primero" class="form-control" oninput="this.value = this.value.toUpperCase()" value="<?=$solicitud["primero_trabajador"];?>" required> 
                                <div class="invalid-feedback">
                                    El campo nombre es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">Segundo Apellido</label>
                                <input type="text" name="segundo" class="form-control" oninput="this.value = this.value.toUpperCase()" value="<?=$solicitud["segundo_trabajador"];?>" required> 
                                <div class="invalid-feedback">
                                    El campo nombre es obligatorio.
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <div class="form-group">
                                <label for="name">CURP del Solicitante (*)</label>
                                <input type="text" name="curp" id="curp_input" oninput="validarInput(this)"class="form-control" value="<?=$solicitud["trabajador_curp"];?>" required> 
                                <pre id="resultado"></pre>
                                <div class="invalid-feedback">
                                    El campo curp es obligatorio.
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
                <form method="POST" action="{{ route('seleccionar_abogado_ratificacion') }} ">
                    @csrf
                    <input type="hidden" id="modal-id" name="citado" value="">
                    <input type="hidden" name="solicitud" value="{{$solicitud->id}}">
                    <table id="tabla1" class="table-striped" style="width:100%">
                        <thead style="background-color: #4A001F;">   
                            <!--<th style="display: none;">ID</th>-->
                            <th style="color: #fff;">Folio</th>
                            <th style="color: #fff;">Nombre</th>
                            <th style="color: #fff;">RFC</th>
                            <th style="color: #fff;">Representante</th>
                            <th style="color: #fff;">Acciones</th>
                        </thead>
                        <tbody class="contenidobusqueda">
                            @foreach($abogados as $abogado)
                                <tr>
                                    <td>{{$abogado->idAbogado}}</td>
                                    <td>{{$abogado->nombres_patronal}} {{$abogado->primer_apellido_patronal}} {{$abogado->segundo_apellido_patronal}}</td>
                                    <td>{{$abogado->rfc_patronal}}</td>
                                    <td>{{$abogado->nombre_representante}} {{$abogado->primer_apellido_representante}} {{$abogado->segundo_apellido_representante}}</td>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
         $('.open-modal').click(function() {
            const id = $(this).data('id'); // Obtiene el valor de data-id

            document.getElementById('modal-id').value = id;
        });

        $( document ).ready(function() {
            // Agregar registro
            $("#addRow").click(function () {
                var html = '';
                html += '<div id="inputFormRow1" class="col-xs-12 col-sm-12 col-md-12">';

                    // Tipo de pago
                    html +='<div class="col-xs-12 col-sm-12 col-md-12">';
                        html +='<div class="form-group">';
                        html +='<label for="confirm-password"><br>Prestación</label>';
                        html +='<select class="form-control tipo-pago-select" name="tipo_pago[]" required>';
                            html +='<option value="">Seleccione</option>';
                            html +='<option value="Aguinaldo">Días de aguinaldo</option>';
                            html +='<option value="DSueldo">Días de sueldo</option>';
                            html +='<option value="Vacaciones">Días de vacaciones</option>';
                            html +='<option value="PrimaVacacional">Prima vacacional</option>';
                            html +='<option value="GratificaciónA">Gratificación A (Con base al salario integrado)</option>';
                            html +='<option value="GratificaciónB">Gratificación B (20 Días por año cumplido)</option>';
                            html +='<option value="GratificaciónC">Gratificación C (Prima de antigüedad topada)</option>';
                            html +='<option value="GratificaciónD">Gratificación D (Incluye cualquier otra prestación)</option>';
                            html +='<option value="GratificaciónE">Gratificación E (Prestaciones en especie)</option>';
                            html +='<option value="GratificaciónF">Gratificación F (Reconocimiento de derechos)</option>';
                            html +='<option value="Otras">Otro concepto de pago</option>';
                        html +='</select>';
                        // Campo para escribir otra prestación (solo si se selecciona "Otras")
                        html += '<div class="otra-prestacion-input" style="display: none; margin-top: 10px;">';
                        html += '<input type="text" class="form-control" name="otra_prestacion[]" placeholder="Especifique la prestación" />';
                        html += '</div>';
                        html +='<div class="invalid-feedback">El tipo de pago es obligatorio.</div>';
                        html += '</div> </div>';

                    // Monto a pagar
                    html += '<div class="col-xs-12 col-sm-12 col-md-12">';
                    html += '<div class="form-group">';
                    html += '<label for="password">Monto a pagar</label>';
                    html +='<input type="text" class="form-control" name="monto_pago[]" oninput="validarNumero(this)" placeholder="$ Solo números y punto para decimales." required>';
                    html += '<div class="invalid-feedback">El monto es obligatorio.</div>';
                    html += '</div> </div>';

                    html += '<div class="input-group-append">';
                    html += '<button class="removeRow btn btn-danger" type="button">Borrar</button>';
                    html += '</div>';
                html += '</div>';

            $('#newRow').append(html);
        });

        // Borrar concepto
        $(document).on('click', '.removeRow', function () {
            $(this).closest('.col-xs-12').remove();
        });

        // Agregar pago
        $("#addPago").click(function () {
                var html = '';
                html += '<div id="inputFormRow2" class="col-xs-12 col-sm-12 col-md-12">';
                
                //TIPO DE PAGO
                html +='<div class="col-xs-12 col-sm-12 col-md-12">';
                //html +='<div class="form-group">';

                    //DÍA A PAGAR
                    html +='<div class="col-xs-12 col-sm-12 col-md-12">';
                    html +='<div class="form-group">';
                    html +='<label for="confirm-password"><br>Días de pago</label>';
                    html +='<input type="date" class="form-control" name="dias_pagos[]" required>';
                    html +='</div> </div>';                                
                    
                    //HORARIO A PAGAR
                    html += '<div class="col-xs-12 col-sm-12 col-md-12">';
                    html += '<div class="form-group">';
                    html += '<label for="password">Hora de pago</label>';
                    html +='<input type="time" class="form-control" name="hora_pagos[]"  oninput="this.value = this.value.toUpperCase()" required>';
                    html += '<div class="invalid-feedback">';
                    html += 'La Hora es obligatoria.';
                    html += '</div> </div> </div>';

                    //MONTO A PAGAR
                    html += '<div class="col-xs-12 col-sm-12 col-md-12">';
                    html += '<div class="form-group">';
                    html += '<label for="password">Monto a pagar</label>';
                    html +='<input type="text" class="form-control" name="monto_pagos[]"  oninput="validarNumero(this)" placeholder="$ Solo números y puntos" required>';
                    html += '<div class="invalid-feedback">';
                    html += 'El monto es obligatorio.';
                    html += '</div> </div> </div>';

                    //DESCRIPCIÓN DE PAGO
                    html += '<div class="col-xs-12 col-sm-12 col-md-12">';
                    html += '<div class="form-group">';
                    html += '<label for="password">Núm. Parcialidad</label>';
                    html +='<input type="text" class="form-control numero_pago" name="descripcion_pagos[]"  readonly >';
                    html += '<div class="invalid-feedback">';
                    html += 'El número de parcialidad es obligatorio.';
                    html += '</div> </div> </div>';

                    html += '<div class="input-group-append">';
                    html += '<button class="removeRow2 btn btn-danger" type="button">Borrar</button>';
                    html += '</div>';
                    
                html += '</div>';

            $('#newRowaPago').append(html);
            actualizaNumeroPago();
        });

        // Borrar pago
        $(document).on('click', '.removeRow2', function () {
            $(this).closest('.col-xs-12').remove();
            actualizaNumeroPago();
        });
        //Actualiza los números de pago
        function actualizaNumeroPago() {
            let pagos = $('.numero_pago');
            if (pagos.length === 1) {
                pagos.eq(0).val("Pago único");
            } else {
                pagos.each(function(index) {
                   $(this).val("Parcialidad " + (index + 1));
                });
            }
        }


        // Agregar deducción
        $("#addRetencion").click(function () {
                var html = '';
                html += '<div id="inputFormRow3" class="row">';
                
                //TIPO DE PAGO
                html +='<div class="col-xs-12 col-sm-12 col-md-12">';
                //html +='<div class="form-group">';

                    //DESCRIPCIÓN DE PAGO
                    html += '<div class="col-xs-12 col-sm-12 col-md-12">';
                    html += '<div class="form-group">';
                    html += '<label for="password">Descripción</label>';
                    html +='<input type="text" class="form-control" name="descripcion_deduccion[]"  oninput="this.value = this.value.toUpperCase()" >';
                    html += '<div class="invalid-feedback">';
                    html += 'La Descripción es obligatoria.';
                    html += '</div> </div> </div>';

                    //MONTO A PAGAR
                    html += '<div class="col-xs-12 col-sm-12 col-md-12">';
                    html += '<div class="form-group">';
                    html += '<label for="password">Monto a pagar</label>';
                    html +='<input type="text" class="form-control" name="monto_deduccion[]"  oninput="validarNumero(this)" placeholder="$ Solo números y puntos" >';
                    html += '<div class="invalid-feedback">';
                    html += 'El monto es obligatorio.';
                    html += '</div> </div> </div>';

                    html += '<div class="input-group-append">';
                    html += '<button class="removeRow3 btn btn-danger" type="button">Borrar</button>';
                    html += '</div>';

                    
                html += '</div>';

            $('#newRowDeduccion').append(html);
        });

        // Borrar pago
        $(document).on('click', '.removeRow3', function () {
            $(this).closest('.col-xs-12').remove();
        });

        });

        
        function validarNumero(input) {
            // La expresión regular permite cualquier número (0-9) y un solo punto (.)
            // El 'g' al final asegura que se reemplace globalmente
            let valor = input.value;
            input.value = valor.replace(/[^0-9.]/g, '');

            // Esta parte se encarga de que solo haya un punto en el valor
            let partes = input.value.split('.');
            if (partes.length > 2) {
                input.value = partes[0] + '.' + partes.slice(1).join('');
            }
        }

        //Muestra un input cuando en prestaciones se selecciona la opción Otros concepto de pago
        $(document).on('change', '.tipo-pago-select', function () {
            var selected = $(this).val();
            var container = $(this).closest('.form-group').find('.otra-prestacion-input');

            if (selected === 'Otras') {
                container.show();
                container.find('input').attr('required', true);
            } else {
                container.hide();
                container.find('input').val('').removeAttr('required');
            }
        });
        //Muestra el total a pagar en base a las prestaciones y deducciones capturadas
        function formatoMoneda(num) {
            return num.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
    
        function calcularTotal() {
            let totalPrestaciones = 0;
            let totalDeducciones = 0;

            // NUEVAS PRESTACIONES
            $('input[name="monto_pago[]"]').each(function () {
                let val = parseFloat($(this).val());
                if (!isNaN(val)) totalPrestaciones += val;
            });

            // NUEVAS DEDUCCIONES
            $('input[name="monto_deduccion[]"]').each(function () {
                let val = parseFloat($(this).val());
                if (!isNaN(val)) totalDeducciones += val;
            });

            // PRESTACIONES YA GUARDADAS
            @foreach($conceptos as $c)
                totalPrestaciones += {{ floatval($c->monto) }};
            @endforeach

            // DEDUCCIONES YA GUARDADAS
            @foreach($deducciones as $d)
                totalDeducciones += {{ floatval($d->monto) }};
            @endforeach

            let total = totalPrestaciones - totalDeducciones;
            $("#totalCalculado").text('$' + formatoMoneda(total));
        }

        $(document).on('input', 'input[name="monto_pago[]"]', calcularTotal);
        $(document).on('input', 'input[name="monto_deduccion[]"]', calcularTotal);
        $(document).on('click', '.removeRow, .removeRow3', function () {
            setTimeout(calcularTotal, 100);
        });
        calcularTotal();
    </script>
    <script src="../../public/assets/js/poderes/general.js"></script>
@endsection