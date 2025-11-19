@extends('layouts.app_editar')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Audiencia</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Concluir Audiencia</h3>
                            
                            @if (session('show_modal'))
                                <script>
                                    $(document).ready(function(){
                                        $('#miModal').modal('show');
                                    });
                                </script>
                            @endif

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

                            <div class="card p-4 shadow-sm">
                                <h5 class="text-muted">Tiempo Restante:</h5>
                                <h1 id="temporizador" class="text-danger font-weight-bold">
                                    --:-- 
                                </h1>
                                <p id="mensaje-estado" class="mt-2"></p>
                            </div>

                            <!--Se realiza el envío de datos con formulario de Laravel Collective-->
                            <form class='needs-validation novalidate' id='form_roles' method='POST' action="{{route('concluir_audiencia_conciliador')}}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12"  style="border:1px solid black;">
                                        <div class="form-group">
                                            <label for="name">PRIMERA MANIFESTACIÓN DE LAS PARTES</label>
                                            <textarea name="primera" class="form-control" required></textarea>
                                            <div class="invalid-feedback">
                                                El campo es obligatorio.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-2 col-sm-2 col-md-2"><br>
                                        <a class="btn btn-primary" onclick="mostrar_resolicion()">Continuar</a>
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
                                    <div id="justificacion" style="display:none"><br>
                                        <div class="col-xs-12 col-sm-12 col-md-12" style="border:1px solid black;">
                                            <div class="form-group">
                                                <label for="name">PROPUESTA DE CONVENIO CONCILIATORIO</label>
                                                <textarea name="justificacion" class="form-control" required></textarea>
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-2 col-sm-2 col-md-2"><br>
                                            <a class="btn btn-primary" onclick="mostrar_segunda()">Continuar</a>
                                        </div>
                                    </div><br>
                                    
                                    <div id="segunda" style="display:none"><br>
                                        <div class="col-xs-12 col-sm-12 col-md-12" style="border:1px solid black;">
                                            <div class="form-group">
                                                <label for="name">SEGUNDA MANIFESTACIÓN DE LAS PARTES</label>
                                                <textarea name="segunda" class="form-control" required></textarea>
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6"><br>
                                            <label for="name">Final de la audiencia</label>
                                            <select id="tipo_de_conclucion" name="conclucion" class="form-control">
                                                <option>Seleccione</option>
                                                <option value="Conciliacion">Hubo Convenio</option>
                                                <option value="No conciliacion">No hubo Convenio</option>
                                                <option value="Archivada por incomparecencia">Archivar</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="dias" class="row gx-2 align-items-end" style="display:none">
                                        <div class="col-xs-12 col-sm-12 col-md-2"><br>
                                            <div class="form-group">
                                                <label for="name">Días de vacaciones</label>
                                                <input type="number" name="vacaciones" class="form-control" > 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-2"><br>
                                            <div class="form-group">
                                                <label for="name">Días de Aguinaldo</label>
                                                <input type="number" name="aguinaldo" class="form-control" > 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-1">
                                            <div class="form-group">
                                                <label for="name">Otros</label>
                                                <input type="text" name="otros" class="form-control" > 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="name">Horario laboral</label>
                                                <input type="text" name="horario" class="form-control" placeholder="Ejemplo: De lunes a viernes de 9Am a 5PM y Sábados de 9 Am a 2 PM" > 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="name">Horario de comida</label>
                                                <input type="text" name="comida" class="form-control" placeholder="De 2PM a 3 PM o 13:30 a 15:00" > 
                                                <div class="invalid-feedback">
                                                    El campo es obligatorio.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="pagos" style="display:none">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <h4 class="text-center">Montos</h4>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-6 col-md-12">
                                            <button id="addRow" type="button" class="btn btn-info">Agregar Concepto de Pago</button>
                                        </div>
                                        
                                        <div id="newRow"></div>

                                        <div class="col-xs-12 col-sm-6 col-md-12"><br>
                                            <button id="addRetencion" type="button" class="btn btn-info">Agregar deducción</button>
                                        </div>
                                        
                                        <div id="newRowDeduccion"></div>

                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div id="div_pagos_diferidos1"><br>
                                                <button id="addPago" type="button" class="btn btn-info">Agregar Cumplimiento</button>
                                                <div id="newRowaPago"></div>
                                            </div>
                                        </div>

                                        <div id="div_pagos_diferidos"></div>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-6"><br>
                                                <label for="name">Tipo de audiencia</label>
                                                <select name="tipo_audiencia" class="form-control">
                                                    <option>Seleccione</option>
                                                    <option value="Presencial">Presencial</option>
                                                    <option value="Virtual">Virtual</option>
                                                </select>
                                            </div> 

                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <br><button type="submit" class="btn btn-primary" name="valor" value="1">Vista Previa</button>
                                        </div>
                                    </div>
 
                                    <div id="no_conciliacion" style="display:none"><br>
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <br><button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </div>

                                    <div id="archivada" style="display:none">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <br><button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
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

<!-- Modal para archivar audiencia-->
<div class="modal fade" id="ModalArchivar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form class='needs-validation novalidate'  method='POST' action="{{route('archivar_audiencia')}}">
        @csrf
        <input type="text" id="solicitud-id" name="id" value="{{ $id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Motivo del archivo de audiencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <textarea name="observaciones" style="width:100%"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="nuevo_turno" style="display: none;">
    <div>.</div>
    <div class="loader"></div>
</div>

<style>
    .fc-event {
            padding: 3px 6px !important;
            border-radius: 4px !important;
            font-size: 12px !important;
            cursor: pointer;
        }

        #calendar {
            width: 100%;
            min-height: 500px;
        }

        .fc-event-disponible {
            color: #ffff !important;
            background-color: #00CE1C !important;
            border-color: #00CE1C !important;
            cursor: pointer;
        }

        .fc-event-expirado {
            color: #ffff !important;
            /*background-color: #F0DF24 !important;
            border-color: #F0DF24 !important;*/
            background-color: #F59727 !important;
            border-color: #F59727 !important;
            cursor: not-allowed;
        }

        .fc-event-inhabil {
            color: #ffff !important;
            background-color: #3B78DB !important;
            border-color: #3B78DB !important;
            cursor: not-allowed;
        }

        .fc-event-ocupado {
            color: #ffff !important;
            background-color: #DA0909 !important;
            border-color: #DA0909 !important;
            cursor: not-allowed;
        }

        .fc-event-selected {
            border: 2px solid #FFD700 !important;
            box-shadow: 0 0 8px #FFD700;
        }
        
        #resumenCita .alert-info {
            background-color: #e0e7ff;
            color: #1e293b;              
            border: 1px solid #6366f1;   
            border-radius: 8px;
            font-size: 10px;
            padding: 8px 16px;
            margin-bottom: 0;
            box-shadow: 0 2px 8px rgba(99,102,241,0.08);
        }

        .btn-custom-morado {
            height: 55px;
            font-size: 10px;
            padding: 5px 10px;
            margin-bottom: 5px;
            background-color: #6A0F49 !important;
            color: #fff !important;
            border: none;
        }
        
        .btn-custom-morado:hover, .btn-custom-morado:focus {
            background-color: #530c3a !important;
            color: #fff !important;
        }
</style>

@section('scripts')
    <script src="../../public/assets/js/turnos/turnos.js"></script>
    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.css">
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
    <script>
       document.getElementById("no_conciliacion").style.display = "none";
       document.getElementById("archivada").style.display = "none";
       document.getElementById("dias").style.display = "none";
       document.getElementById("pagos").style.display = "none";
       
        $( document ).ready(function() {
            // Agregar registro
            $("#addRow").click(function () {
                var html = '';
                html += '<div id="inputFormRow1" class="row mb-2 align-items-end">';

                // Tipo de pago
                html +='<div class="col-xs-12 col-sm-12 col-md-6">';
                    html +='<div class="form-group">';
                    html +='<label for="confirm-password"><br>Prestación</label>';
                    html +='<select class="form-control" name="tipo_pago[]" >';
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
                html += '<div class="col-xs-12 col-sm-12 col-md-6">';
                html += '<div class="form-group">';
                html += '<label for="password">Monto a pagar</label>';
                html +='<input type="text" class="form-control" name="monto_pago[]"  oninput="validarNumero(this)" placeholder="$">';
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
            let numeroPago = $('.numero_pago').length + 1;
            var html = '';
            html += '<div class="inputFormRow2 row mb-2 align-items-end">';
            html += '<div class="col-xs-12 col-sm-12 col-md-12">';
            html += '<div class="form-group">';
            html += '<label for="confirm-password"><br>Fecha y hora de pago</label>';
            html += '<div class="row">';
            html += '<div class="row">';

            if (numeroPago === 1) {
                html += '<label for="tipoPago">Seleccione una opción:</label>';
                html += '<select name="tipoPago" id="tipoPago" class="form-control">';
                html += '<option value="">-- Por favor, seleccione --</option>';
                html += '<option value="pagarAudiencia">Pagar en Audiencia</option>';
                html += '<option value="agendar">Agendar Pago</option>';
                html += '</select>';
            } else {
                //Botón de selección de horario
                html += '<div class="col-12">';
                html += '<button type="button" class="btn btn-custom-morado w-75" data-bs-toggle="modal" data-bs-target="#calendarModal"> Seleccionar Horario</button>';
                html += '</div>';
                html += '</div>';
                html += '<div class="row">';
            }
            //Alerta de seleción de horario
            html += '<div class="col-12 mt-2">';
            html += '<div id="resumenCita" style="display:none;width:100%;">';
            html += '<div class="alert alert-info w-75">';
            html += '<strong>Cita seleccionada:</strong> <span id="fechaResumen"></span> a las <span id="horaResumen"></span>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            //botón dinámico
            html += '<div class="contenedor-boton-pago"></div>';
            html += '<div class="col-xs-12 col-sm-12 col-md-12">';
            html += '<div class="form-group">';
            //Monto a pagar
            html += '<label for="password">Monto a pagar</label>';
            html += '<input type="text" class="form-control" name="monto_pagos[]"   oninput="validarNumero(this)" >';
            html += '<div class="invalid-feedback">La Dirección es obligatoria.</div>';
            html += '</div></div>';
            // Tipo de Agenda
            /*html += '<div class="col-xs-12 col-sm-12 col-md-12">';
            html += '<div class="form-group">';
            html += '<label for="password">Tipo De Agenda</label>';
            html += '<select class="form-control" name="tipo_pago[]" >';
            html += '<option value="">Seleccione</option>';
            html += '<option value="Por el Conciliador">Por el Conciliador</option>';
            html += '<option value="Agendar en calendario">Agendar en calendario de Cumpliemientos</option>';
            html += '</select>';
            html += '<div class="invalid-feedback">La Dirección es obligatoria.</div>';
            html += '</div></div>';*/
            // Descripción de pago
            html += '<div class="col-xs-12 col-sm-12 col-md-12">';
            html += '<div class="form-group">';
            html += '<label for="password">Descripción</label>';
            html += '<input type="text" class="form-control numero_pago" name="descripcion_pagos[]" readonly >';
            html += '<div class="invalid-feedback">La Dirección es obligatoria.</div>';
            html += '</div></div>';
            html += '<div class="input-group-append">';
            html += '<button class="removeRow2 btn btn-danger" type="button">Borrar</button>';
            html += '</div>';
            html += '</div>';
            $('#newRowaPago').append(html);
            actualizaNumeroPago();
            
            //Esto reemplaza el container por los botones de opciones, para que aparezca debajo del selector de opciones
            $('#newRowaPago').find('#tipoPago').last().on('change', function() {
                var opcionPago = $(this).val();
                var parent = $(this).closest('.inputFormRow2');
                var contenedor = parent.find('.contenedor-boton-pago');
                contenedor.empty()
                parent.find('input[name="tipo_pagoAgenda[]"]').remove();
                if (opcionPago === "pagarAudiencia") {
                    parent.append('<input type="hidden" name="tipo_pagoAgenda[]" value="Conciliador">');
                    contenedor.replaceWith('<div class="contenedor-boton-pago col-12 mb-2 mt-2"><button type="button" class="btn btn-success h-100 w-75" id="btnPagarAudiencia">Pagar en la audiencia</button></div>');
                    $(document).on('click', '#btnPagarAudiencia', function() {
                        mostrarSelectHorasAudiencia();
                    });
                } else if (opcionPago === "agendar") {
                    parent.append('<input type="hidden" name="tipo_pagoAgenda[]" value="Audiencia">');
                    contenedor.replaceWith('<div class="contenedor-boton-pago col-12 mb-2 mt-2"><button type="button" class="btn btn-custom-morado w-75" data-bs-toggle="modal" data-bs-target="#calendarModal"> Seleccionar Horario</button></div>');
                    mostrarSelectHorasAudiencia();
                } else {
                    contenedor.replaceWith('<div class="contenedor-boton-pago"></div>');
                }
            });
        });

        window.mostrarSelectHorasAudiencia = function() {
            var hoy = new Date();
            var fechaHoy = hoy.toISOString().split('T')[0];

            var selectHtml = '<div class="form-group mt-2" id="selectHoraAudienciaDiv">';
            selectHtml += '<label>Selecciona la hora para pagar en la audiencia:</label>';
            selectHtml += '<select class="form-control" id="selectHoraAudiencia">';
            selectHtml += '<option value="">Seleccione una hora</option>';
            selectHtml += '<option value="09:00:00">9:00 AM</option>';
            selectHtml += '<option value="09:30:00">9:30 AM</option>';
            selectHtml += '<option value="10:00:00">10:00 AM</option>';
            selectHtml += '<option value="10:30:00">10:30 AM</option>';
            selectHtml += '<option value="11:00:00">11:00 AM</option>';
            selectHtml += '<option value="11:30:00">11:30 AM</option>';
            selectHtml += '<option value="12:00:00">12:00 PM</option>';
            selectHtml += '<option value="12:30:00">12:30 PM</option>';
            selectHtml += '<option value="13:00:00">1:00 PM</option>';
            selectHtml += '<option value="13:30:00">1:30 PM</option>';
            selectHtml += '<option value="14:00:00">2:00 PM</option>';
            selectHtml += '<option value="14:30:00">2:30 PM</option>';
            selectHtml += '<option value="15:00:00">3:00 PM</option>';
            selectHtml += '<option value="15:30:00">3:30 PM</option>';
            selectHtml += '<option value="16:00:00">4:00 PM</option>';
            selectHtml += '<option value="16:30:00">4:30 PM</option>';
            selectHtml += '</select>';
            selectHtml += '<button type="button" class="btn btn-primary mt-2" id="confirmarHoraAudiencia">Confirmar hora</button>';
            selectHtml += '</div>';
            $('#selectHoraAudienciaDiv').remove();
            $('#btnPagarAudiencia').parent().after(selectHtml);

            $('#confirmarHoraAudiencia').off('click').on('click', function() {
                var horaSeleccionada = $('#selectHoraAudiencia').val();
                if (!horaSeleccionada) {
                    alert('Selecciona una hora válida');
                    return;
                }

                var pagoBlock = $(this).closest('.inputFormRow2');
                pagoBlock.find('input[name="dias_pagos[]"], input[name="hora_pagos[]"]').remove();
                pagoBlock.append('<input type="hidden" name="dias_pagos[]" value="'+fechaHoy+'">');
                pagoBlock.append('<input type="hidden" name="hora_pagos[]" value="'+horaSeleccionada+'">');

                pagoBlock.find('#fechaResumen').text(fechaHoy);
                pagoBlock.find('#horaResumen').text(horaSeleccionada.substring(0,5));
                pagoBlock.find('#resumenCita').show();
                $('#selectHoraAudienciaDiv').remove();
            });
        };
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
        /*function actualizaNumeroPago() {
            let pagos = $('.numero_pago');
            if (pagos.length === 1) {
                pagos.eq(0).val("Pago único");
            } else {
                pagos.each(function(index) {
                   $(this).val("Parcialidad " + (index + 1));
                });
            }
        }

        // Borrar pago 
        $(document).on('click', '.removeRow2', function () {
            $(this).closest('.inputFormRow2').remove();
        });*/

        // Agregar deducción
        $("#addRetencion").click(function () {
                var html = '';
                html += '<div id="inputFormRow3" class="row">';
                
                //TIPO DE PAGO
                html +='<div class="col-xs-12 col-sm-12 col-md-12"><br>';
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
        
        function mostrar_resolicion() {
            document.getElementById("justificacion").style.display = "block";
        }
        function mostrar_segunda() {
            document.getElementById("segunda").style.display = "block";
        }

        const tipo_iden = document.getElementById('tipo_de_conclucion');
        tipo_iden.addEventListener('change', function() {
            const valorSeleccionado = this.value;
            // Realiza la validación o acciones necesarias
            if (valorSeleccionado === 'Conciliacion') {
                document.getElementById('no_conciliacion').style.display = "none";
                document.getElementById('archivada').style.display = "none";
                document.getElementById("pagos").style.display = "block";
                document.getElementById('dias').style.display = "block";
            }
            else if (valorSeleccionado === 'No conciliacion'){
                document.getElementById('no_conciliacion').style.display = "block";
                document.getElementById('archivada').style.display = "none"
                document.getElementById("pagos").style.display = "none";
                document.getElementById('dias').style.display = "none";
            } 
            else if (valorSeleccionado === 'Archivada por incomparecencia') {
                const confirmar = confirm("¿Estás seguro de que deseas archivar esta audiencia?");
                if (confirmar) {
                    $('#ModalArchivar').modal('show');
                    document.getElementById('no_conciliacion').style.display = "none";
                    document.getElementById('archivada').style.display = "block";
                    document.getElementById("pagos").style.display = "none";
                    document.getElementById('dias').style.display = "none";
                } else {
                    this.value = "Seleccione"; // Regresa al estado inicial
                }
            }
        });

         $('.open-modal').click(function() {
            const id = $(this).data('id'); // Obtiene el valor de data-id
            document.getElementById('modal-id').value = id;
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('tipo_de_conclucion');
            const dias = document.getElementById('dias');
        
            // Escuchar cuando se cambie la opción del select
            select.addEventListener('change', function () {
                if (select.value === 'Conciliacion') {
                    dias.style.display = 'flex'; // o 'block' si quieres que sea vertical
                } else {
                    dias.style.display = 'none';
                }
            });
        });
    </script>

    <script>
        let calendar;
        $('#calendarModal').on('shown.bs.modal', function () {
            if (calendar) {
                calendar.destroy();
            }
            var calendarEl = document.getElementById('calendar');
            
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridWeek',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                },
                /*windowResize: function(view) {
                    if (window.innerWidth < 768) {
                        calendar.changeView('listWeek');
                    } else{
                        calendar.changeView('dayGridWeek');
                    }
                },*/
                validRange: {
                    start: (() => {
                        const now = new Date();
                        return new Date(now.getFullYear(), now.getMonth() - 1, 1).toISOString().split('T')[0];
                    })(),
                    end: (() => {
                        const now = new Date();
                        return new Date(now.getFullYear(), now.getMonth() + 3, 0).toISOString().split('T')[0];
                    })()
                },
                events: function(fetchInfo, successCallback, failureCallback) {
                    // Obtener sede seleccionada
                    var sede = document.getElementById('sede').value;
                    // Hacer petición AJAX con parámetro sede
                    $.ajax({
                        url: '../../api/obtenerCumplimientos',
                        method: 'GET',
                        data: {
                            sede: sede,
                            start: fetchInfo.startStr,
                            end: fetchInfo.endStr
                        },
                        success: function(data) {
                            successCallback(data);
                        },
                        error: function() {
                            failureCallback('Error al cargar eventos');
                        }
                    });
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    //second: '2-digit',
                    //hour12: false
                },
                eventClick: function(info) {
                    // Solo permitir selección de horarios disponibles
                    let ahora = new Date();
                    let slotDate = new Date(info.event.start);
                    if (info.event.extendedProps.estado === 'disponible' && slotDate > ahora) {
                        // Deseleccionar evento anterior
                        document.querySelectorAll('.fc-event-selected').forEach(el => {
                            el.classList.remove('fc-event-selected');
                        });
                        // Seleccionar este evento
                        info.el.classList.add('fc-event-selected');
                        window.selectedEvent = info.event;
                    } else {
                        alert('Este horario no está disponible. Por favor seleccione otro.');
                    }
                },
                eventDidMount: function(info) {
                    // Añade clases CSS según el tipo de evento
                    if (info.event.extendedProps.estado === 'disponible') {
                        info.el.classList.add('fc-event-disponible');
                    } else if (info.event.extendedProps.estado === 'expirado') {
                        info.el.classList.add('fc-event-expirado');
                    } else if (info.event.extendedProps.estado === 'inhabil') {
                        info.el.classList.add('fc-event-inhabil');
                    } else {
                        info.el.classList.add('fc-event-ocupado');
                    }
                },
            });
            calendar.render();

            function updateCalendarView() {
                if (window.innerWidth < 768) {
                    calendar.changeView('listWeek');
                } else {
                    calendar.changeView('dayGridWeek');
                }
            }

            window.addEventListener('resize', updateCalendarView);
        });

        // Confirmar selección
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('confirmarSeleccion').addEventListener('click', function() {
                if (window.selectedEvent) {
                    const fechaHora = new Date(window.selectedEvent.start);
                    const fecha = fechaHora.toISOString().split('T')[0];
                    const hora = fechaHora.toTimeString().substring(0, 8);

                    var pagoBlock = $('.inputFormRow2').last();
                    pagoBlock.find('input[name="dias_pagos[]"], input[name="hora_pagos[]"]').remove();
                    
                    pagoBlock.append('<input type="hidden" name="dias_pagos[]" value="'+fecha+'">');
                    pagoBlock.append('<input type="hidden" name="hora_pagos[]" value="'+hora+'">');

                    pagoBlock.find('#fechaResumen').text(fecha);
                    pagoBlock.find('#horaResumen').text(hora.substring(0,5));
                    pagoBlock.find('#resumenCita').show();

                    // Cerrar modal
                    document.activeElement.blur();
                    $('#calendarModal').modal('hide');
                } else {
                    alert('Por favor selecciona un horario disponible');
                }
            });
        });
    </script>
    <script>
        const TIEMPO_FINAL_KEY = 'tiempoFinalTemporizador';

        // 1. Recuperar el Tiempo Final Guardado
        let tiempoFinalGuardado = localStorage.getItem(TIEMPO_FINAL_KEY);
        console.log(tiempoFinalGuardado);
        /*
        if (!tiempoFinalGuardado) {
            // Si no hay tiempo guardado (ej. la sesión expiró o se acabó el tiempo)
            document.getElementById('temporizador').innerHTML = "No hay temporizador activo.";
            return; 
        }
        */
        const tiempoFinal = parseInt(tiempoFinalGuardado);

        // 2. Iniciar el Intervalo de Actualización (¡Es la misma función!)
        function actualizarTemporizador() {
            const tiempoRestante = tiempoFinal - Date.now();
            const segundosRestantes = Math.max(0, Math.floor(tiempoRestante / 1000));
            
            // ... (resto del cálculo y display es exactamente igual a la Vista A) ...

            const minutos = Math.floor(segundosRestantes / 60);
            const segundos = segundosRestantes % 60;
            
            const display = `${String(minutos).padStart(2, '0')}:${String(segundos).padStart(2, '0')}`;
            document.getElementById('temporizador').innerHTML = display;

            if (segundosRestantes <= 0) {
                clearInterval(intervalo);
                document.getElementById('temporizador').innerHTML = "¡Tiempo terminado!";
                localStorage.removeItem(TIEMPO_FINAL_KEY);
            }
        }

        const intervalo = setInterval(actualizarTemporizador, 1000);
        actualizarTemporizador();
    </script>
    
@endsection

<!-- Modal para seleccionar fecha y horario -->
<input type="hidden" id="sede" value="{{ $sede }}">

<div class="modal fade" id="calendarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seleccionar Fecha y Horario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="calendar"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmarSeleccion">Confirmar</button>
            </div>
        </div>
    </div>
</div>