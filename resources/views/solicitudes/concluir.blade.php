@extends('layouts.app_editar')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Ratificación</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Concluir Ratificación</h3>
                            
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
                            <form class='needs-validation novalidate' id='form_roles' method='POST' action="{{route('solicitudes.manidestaciones')}}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="name">RESOLUCION PRIMERA MANIFESTACION</label>
                                            <textarea name="primera" class="form-control" required></textarea>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="name">RESOLUCION PROPUESTAS TRABAJADORES</label>
                                            <textarea name="trabajadores" class="form-control" required></textarea>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="name">RESOLUCION JUSTIFICACION PROPUESTA</label>
                                            <textarea name="justificacion" class="form-control" required></textarea>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="name">RESOLUCION SEGUNDA MANIFESTACION</label>
                                            <textarea name="segunda" class="form-control" required></textarea>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label for="name">Dias de vacaciones</label>
                                            <input type="number" name="vacaciones" class="form-control" required> 
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label for="name">Dias de Aguinaldo</label>
                                            <input type="number" name="aguinaldo" class="form-control" required> 
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-2">
                                        <div class="form-group">
                                            <label for="name">Otros</label>
                                            <input type="text" name="otros" class="form-control" required> 
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="name">Horarios</label>
                                            <input type="text" name="horario" class="form-control" required> 
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="name">Horario de comida</label>
                                            <input type="text" name="comida" class="form-control" required> 
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="name">Domicilio de la empresa</label>
                                            <input type="text" name="domicilio" class="form-control" required> 
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="password">Conciliador</label>
                                            <select class="form-control" name="conciliador_id" required>
                                                <option value="">Seleccione</option>
                                                @foreach($conciliadores as $con)
                                                    <option value="{{$con['id']}}">{{$con['name']}}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                El conciliador es obligatorio.
                                            </div>
                                        </div>
                                            </div>

                                    <div class="col-xs-12 col-sm-12 col-md-12"></div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div id="div_pagos_diferidos1">
                                            <button id="addPago" type="button" class="btn btn-info">Agregar Pago</button>
                                            <div id="newRowaPago"></div>
                                        </div>
                                    </div>

                                    <div id="div_pagos_diferidos"></div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <h4 class="text-center">Montos</h4>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6 col-md-12"><BR>
                                        <button id="addRow" type="button" class="btn btn-info">Agregar Concepto</button>
                                    </div>
                                       
                                    <div id="newRow"></div>

                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <br><button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                    
                                </div>
                            </forms>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<div id="nuevo_turno" style="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>


@section('scripts')
    <script src="../../public/assets/js/turnos/turnos.js"></script>


    <script>
       document.getElementById("div_pagos_diferidos").style.display = "none";
       $( document ).ready(function() {
            // Agregar registro
            $("#addRow").click(function () {
                var html = '';
                html += '<div id="inputFormRow1" class="col-xs-12 col-sm-6 col-md-12">';

                // Tipo de pago
                html +='<div class="col-xs-12 col-sm-12 col-md-12">';
                    html +='<div class="form-group">';
                    html +='<label for="confirm-password"><br>Prestación</label>';
                    html +='<select class="form-control" name="tipo_pago[]" required>';
                    html +='<option value="">Seleccione</option>';
                    html +='<option value="Fisica">Dias de aguinaldo</option>';
                    html +='<option value="Moral">Dias de sueldo</option>';
                    html +='<option value="Moral">Dias de vacaciones</option>';
                    html +='<option value="Moral">Graficicaión A (Con base al salario integrado)</option>';
                    html +='<option value="Moral">Graficicaión B (20 Días por año cumplido)</option>';
                    html +='<option value="Moral">Graficicaión C (Prima de antiguedad topada)</option>';
                    html +='<option value="Moral">Graficicaión D (Incluye cualquier otra prestación)</option>';
                    html +='<option value="Moral">Graficicaión E (Prestaciones en especie)</option>';
                    html +='<option value="Moral">Graficicaión F (Reconocimiento de derechos)</option>';
                    html +='<option value="Moral">Otros concepto de pago</option>';
                    html +='<option value="Moral">Prima vacacional</option>';
                    html +='</select>';
                    html +='<div class="invalid-feedback">El tipo de pago es obligatorio.</div>';
                    html += '</div> </div>';

                // Monto a pagar
                html += '<div class="col-xs-12 col-sm-12 col-md-12">';
                html += '<div class="form-group">';
                html += '<label for="password">Monto a pagar</label>';
                html +='<input type="text" class="form-control" name="monto_pago[]"  oninput="this.value = this.value.toUpperCase()" required>';
                html += '<div class="invalid-feedback">La Dirección es obligatoria.</div>';
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
                html += '<div id="inputFormRow2" class="col-xs-12 col-sm-6 col-md-12">';
                
                //TIPO DE PAGO
                html +='<div class="col-xs-12 col-sm-12 col-md-12">';
                html +='<div class="form-group">';

                //DÍA A PAGAR
                html +='<div class="col-xs-12 col-sm-12 col-md-12">';
                html +='<div class="form-group">';
                html +='<label for="confirm-password"><br>Dias de pago</label>';
                html +='<input type="date" class="form-control" name="dias_pagos[]" required>';
                html +='</div> </div>';                                
                
                //HORARIO A PAGAR
                html += '<div class="col-xs-12 col-sm-12 col-md-12">';
                html += '<div class="form-group">';
                html += '<label for="password">Hora</label>';
                html +='<input type="text" class="form-control" name="hora_pagos[]"  oninput="this.value = this.value.toUpperCase()" required>';
                html += '<div class="invalid-feedback">';
                html += 'La Dirección es obligatoria.';
                html += '</div> </div> </div>';

                //MONTO A PAGAR
                html += '<div class="col-xs-12 col-sm-12 col-md-12">';
                html += '<div class="form-group">';
                html += '<label for="password">Monto a pagar</label>';
                html +='<input type="text" class="form-control" name="monto_pagos[]"  oninput="this.value = this.value.toUpperCase()" required>';
                html += '<div class="invalid-feedback">';
                html += 'La Dirección es obligatoria.';
                html += '</div> </div> </div>';

                //DESCRIPCIÓN DE PAGO
                html += '<div class="col-xs-12 col-sm-12 col-md-12">';
                html += '<div class="form-group">';
                html += '<label for="password">Descripcion</label>';
                html +='<input type="text" class="form-control" name="descripcion_pagos[]"  oninput="this.value = this.value.toUpperCase()" required>';
                html += '<div class="invalid-feedback">';
                html += 'La Dirección es obligatoria.';
                html += '</div> </div> </div>';

                html += '<div class="input-group-append">';
                html += '<button class="removeRow2 btn btn-danger" type="button">Borrar</button>';
                html += '</div>';
                html += '</div>';

                $('#newRowaPago').append(html);
            });

            // Borrar pago
            $(document).on('click', '.removeRow2', function () {
                $(this).closest('.col-xs-12').remove();
            });
        });

    </script>
@endsection