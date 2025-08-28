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
                                    <div class="col-xs-12 col-sm-12 col-md-12"  style="border:1px solid black;">
                                        <div class="form-group">
                                            <label for="name">RESOLUCIÓN PRIMERA MANIFESTACIÓN</label>
                                            <textarea name="primera" class="form-control" required></textarea>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-2 col-sm-2 col-md-2"><br>
                                        <a class="btn btn-primary" onclick="mostrar_resolicion()">Continuar</a>
                                    </div>
                                    
                                    <div class="col-xs-2 col-sm-2 col-md-2"><br>
                                        <button type="button" class="btn btn-danger open-modal" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $id }}">
                                            Archivar
                                        </button><br><br>
                                    </div>
                                    <br>
                                    <!--
                                    <div id="" class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <label for="name">RESOLUCIÓN PROPUESTAS TRABAJADORES</label>
                                            <textarea name="trabajadores" class="form-control" required></textarea>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>
                                    -->
                                    <div id="justificacion" style="display:none">
                                        <div class="col-xs-12 col-sm-12 col-md-12" style="border:1px solid black;">
                                            <div class="form-group">
                                                <label for="name">RESOLUCIÓN JUSTIFICACIÓN PROPUESTA</label>
                                                <textarea name="justificacion" class="form-control" required></textarea>
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-2 col-sm-2 col-md-2"><br>
                                            <a class="btn btn-primary" onclick="mostrar_segunda()">Continuar</a>
                                        </div><br>
                                    </div>
                                
                                    <div id="segunda" style="display:none">
                                        <div class="col-xs-12 col-sm-12 col-md-12" style="border:1px solid black;">
                                            <div class="form-group">
                                                <label for="name">RESOLUCIÓN SEGUNDA MANIFESTACIÓN</label>
                                                <textarea name="segunda" class="form-control" required></textarea>
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2"><br>
                                            <a class="btn btn-primary" onclick="mostrar_vacaciones()">Continuar</a>
                                        </div>
                                    </div>

                                    <div id="dias" class="row home-shape">
                                        <div class="col-xs-12 col-sm-12 col-md-2"><br>
                                            <div class="form-group">
                                                <label for="name">Días de vacaciones</label>
                                                <input type="number" name="vacaciones" class="form-control" required> 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-2">
                                            <div class="form-group"><br>
                                                <label for="name">Días de Aguinaldo</label>
                                                <input type="number" name="aguinaldo" class="form-control" required> 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-1">
                                            <div class="form-group"><br>
                                                <label for="name">Otros</label>
                                                <input type="text" name="otros" class="form-control" required> 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-2">
                                            <div class="form-group"><br>
                                                <label for="name">Horario laboral</label>
                                                <input type="text" name="horario" class="form-control" required> 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>                                       
                                        <div class="col-xs-12 col-sm-12 col-md-2">
                                            <div class="form-group"><br>
                                                <label for="name">Horario de comida</label>
                                                <input type="text" name="comida" class="form-control" required> 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>                                       
                                        <div class="col-xs-12 col-sm-6 col-md-3">
                                            <div class="form-group"><br>
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
                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                            <a class="btn btn-primary" onclick="mostrar_pagos()">Continuar</a>
                                        </div>
                                    </div>

                                    <div id="pagos" style="display:none">
                                        <div class="col-xs-12 col-sm-12 col-md-12"></div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <h4 class="text-center">Montos</h4>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-12"><br>
                                            <button id="addRow" type="button" class="btn btn-info">Agregar Concepto de Pago</button>
                                        </div>
                                        
                                        <div id="newRow"></div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div id="div_pagos_diferidos1"><br><br>
                                                <button id="addPago" type="button" class="btn btn-info">Agregar Pago</button>
                                                <div id="newRowaPago"></div>
                                            </div>
                                        </div>

                                        <div id="div_pagos_diferidos"></div>

                                        
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <br><button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class='needs-validation novalidate'  method='POST' action="{{route('archivar_ratificacion')}}">
        @csrf
        <input type="hidden" id="modal-id" name="id" value="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Motivo de Archivo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea name="observaciones" style="width:100%"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="nuevo_turno" style="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>


@section('scripts')
    <script src="../../public/assets/js/turnos/turnos.js"></script>


    <script>
       document.getElementById("div_pagos_diferidos").style.display = "none";
       document.getElementById("dias").style.display = "none";
       
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
                    html +='<option value="Aguinaldo">Días de aguinaldo</option>';
                    html +='<option value="DSueldo">Días de sueldo</option>';
                    html +='<option value="Vacaciones">Días de vacaciones</option>';
                    html +='<option value="PrimaVacacional">Prima vacacional</option>';
                    html +='<option value="GratificaciónA">Graficación A (Con base al salario integrado)</option>';
                    html +='<option value="GratificaciónB">Graficación B (20 Días por año cumplido)</option>';
                    html +='<option value="GraficaciónC">Graficación C (Prima de antigüedad topada)</option>';
                    html +='<option value="GratificaciónD">Graficación D (Incluye cualquier otra prestación)</option>';
                    html +='<option value="GratificaciónE">Graficación E (Prestaciones en especie)</option>';
                    html +='<option value="GratificaciónF">Graficación F (Reconocimiento de derechos)</option>';
                    html +='<option value="Otras">Otros concepto de pago</option>';
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
                html +='<label for="confirm-password"><br>Días de pago</label>';
                html +='<input type="date" class="form-control" name="dias_pagos[]" required>';
                html +='</div> </div>';                                
                
                //HORARIO A PAGAR
                html += '<div class="col-xs-12 col-sm-12 col-md-12">';
                html += '<div class="form-group">';
                html += '<label for="password">Hora de pago</label>';
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
                html += '<label for="password">Descripción</label>';
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

        function mostrar_resolicion() {
            document.getElementById("justificacion").style.display = "block";
        }
        function mostrar_segunda() {
            document.getElementById("segunda").style.display = "block";
        }
        function mostrar_vacaciones(){
            document.getElementById('dias').removeAttribute("style");
        }
        function mostrar_pagos(){
            document.getElementById("pagos").style.display = "block";
        }

         $('.open-modal').click(function() {
            const id = $(this).data('id'); // Obtiene el valor de data-id
            document.getElementById('modal-id').value = id;
        });
    </script>
@endsection