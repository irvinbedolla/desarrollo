<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <title>Sí Concilio</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <!-- Bootstrap 5.3.3 -->
        <link href="../public/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
        <style>
           @page {
                margin: 0px 0px;
            }
            body{
                padding-top: 85px;
            }
            main{
                margin: 50px 50px 50px 40px; /*Para colocar el texto*/
            }
            header {
                position: fixed;
                top: -100px;
                left: 0;
                right: 0;
                height: 100px;
                text-align: center;
                font-size: 14px;
            }

            footer {
                position: fixed;
                bottom: -60px;
                left: 0;
                right: 0;
                height: 50px;
                text-align: center;
                font-size: 12px;
            }
            .content {
                font-family: sans-serif;
                font-size: 12px;
                text-align: justify;
                margin-top: 50px;
            }
            .fondo-membrete {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
            } 
            .page-break {
                page-break-after: always;
            }
        </style>
            
    </head>
    <body>
        <img src="{{ public_path('assets/images/pdf_Siconcilio.jpg') }}" class="fondo-membrete">
        <footer>
            
        </footer>
        <main>
            <div class="content">
                <div class="table-responsive">
                    <table id="tabla_solicitud" class="table-striped" style="width:60%; float: right;">
                            <tr>   
                                <td><b>Centro de Conciliación Laboral </b></td>
                                <td>{{ $fecha_inicial}} a {{ $fecha_final }} </td>
                            </tr>
                    </table>
                </div><br><br><br>

                    <div class="table-responsive">
                        <spam>Reporte por sede</spam>
                            <table class="table table-striped mt-2">
                                <thead style="background-color: #869b9c;">
                                    <th style="color: #fff;  text-align: center;">Sede</th>
                                    <th style="color: #fff;  text-align: center;">Solicitudes</th>
                                    <th style="color: #fff;  text-align: center;">Solicitudes Confirmadas</th>

                                    <th style="color: #fff;  text-align: center;">Ratificaciones</th>
                                    <th style="color: #fff;  text-align: center;">Incompetencias</th>
                                    <th style="color: #fff;  text-align: center;">Cumplimientos</th>

                                    <th style="color: #fff;  text-align: center;">Monto en Audiencia</th>
                                    <th style="color: #fff;  text-align: center;">Monto en Ratificaciones</th>
                                </thead>
                                <tbody>
                                    @foreach($solicitudes as $ciudad => $solicitud)
                                        <tr>
                                            <td style=" text-align: center;">{{ $solicitud->sede_nombre}}</td>
                                            <td style=" text-align: center;">{{ $solicitud->numeroSolicitudes ?? 0 }}</td>
                                            <td style=" text-align: center;">{{ $solicitud->confirmadas}}</td>
                                            <td style=" text-align: center;">{{ $solicitud->ratificaciones ?? 0}}</td>
                                            <td style=" text-align: center;">{{ $solicitud->incompetencia}}</td>
                                            <th style=" text-align: center;">{{ $solicitud->cumplimientoRatificacion + $solicitud->cumplimientoAudiencia }}</th>
                                            <td style=" text-align: center;">${{ number_format($solicitud->cumplimientoAudienciaMonto, 2) }}</td>
                                            <td style=" text-align: center;">${{ number_format($solicitud->cumplimientoRatificacionMonto, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>

                    <div class="table-responsive">
                            <table class="table table-striped mt-2">
                                <thead style="background-color: #869b9c;">
                                    <th style="color: #fff;  text-align: center;">Sede</th>
                                    <th style="color: #fff;  text-align: center;">Audiencias</th>
                                    <th style="color: #fff;  text-align: center;">Cumplimientos Audiencia</th>
                                    <th style="color: #fff;  text-align: center;">Monto</th>

                                    <th style="color: #fff;  text-align: center;">Multas</th>
                                    <th style="color: #fff;  text-align: center;">Audiencia Virtuales</th>
                                    <th style="color: #fff;  text-align: center;">Una Audiencia</th>
                                    <th style="color: #fff;  text-align: center;">Dos Audiencias</th>
                                    <th style="color: #fff;  text-align: center;">Tres Audiecias</th>
                                </thead>
                                <tbody>
                                    @foreach($audiencias as $ciudad => $solicitud)
                                        <tr>
                                            <td style=" text-align: center;">{{ $solicitud->sede_nombre}}</td>
                                            <td style=" text-align: center;">{{ $solicitud->total_audiencias ?? 0 }}</td>
                                            <td style=" text-align: center;">{{ $solicitud->cumplimientoAudiencia}}</td>
                                            <td style=" text-align: center;">${{ number_format($solicitud->cumplimientoAudienciaMonto, 2) }}</td>

                                            <td style=" text-align: center;">{{ $solicitud->multas ?? 0}}</td>
                                            <td style=" text-align: center;">{{ $solicitud->audiencias_virtuales ?? 0}}</td>
                                            <th style=" text-align: center;">{{ $solicitud->una_audiencia }}</th>
                                            <td style=" text-align: center;">{{ $solicitud->dos_audiencias }}</td>
                                            <td style=" text-align: center;">{{ $solicitud->tres_audiencias }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    
                                </tfoot>
                            </table>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped mt-2">
                                <thead style="background-color: #869b9c;">
                                    <th style="color: #fff;  text-align: center;">Sede</th>
                                    <th style="color: #fff;  text-align: center;">Total Notificaciones</th>
                                    <th style="color: #fff;  text-align: center;">Notificación Exitosa</th>
                                    <th style="color: #fff;  text-align: center;">No Notificada</th>

                                    <th style="color: #fff;  text-align: center;">Pendientes</th>
                                    <th style="color: #fff;  text-align: center;">Exhortos</th>
                                    <th style="color: #fff;  text-align: center;">Existosa se Constituye</th>
                                    <th style="color: #fff;  text-align: center;">No exitosa se Constituye</th>
                                </thead>
                                <tbody>
                                    @foreach($notificaciones as $ciudad => $solicitud)
                                        <tr>
                                            <td style=" text-align: center;">{{ $solicitud->sede_nombre}}</td>
                                            <td style=" text-align: center;">{{ $solicitud->Todas_notificaciones ?? 0 }}</td>
                                            <td style=" text-align: center;">{{ $solicitud->exitosamente}}</td>
                                            <td style=" text-align: center;">{{ $solicitud->notificacion_Nonotificada }}</td>

                                            <td style=" text-align: center;">{{ $solicitud->notificacion_pendientes }}</td>
                                            <td style=" text-align: center;">{{ $solicitud->notificacion_exhortos }}</td>
                                            <th style=" text-align: center;">{{ $solicitud->notificacion_NESC }}</th>
                                            <td style=" text-align: center;">{{ $solicitud->notificacion_NENSC }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    
                                </tfoot>
                            </table>
                        </div>

            <script type="text/php">
                if (isset($pdf)) {
                    $font = $fontMetrics->get_font("Arial", "normal");
                    $size = 10;
                    $y = $pdf->get_height() - 30;
                    $x = ($pdf->get_width() / 2) - 50;
                    $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
                    $pdf->page_text($x, $y, $text, $font, $size, array(0, 0, 0));
                }
            </script>
        </main>
    </body>