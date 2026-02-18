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
           @page { margin: 0px 0px; }
            body {
                margin: 0; padding-top: 85px;
                font-family: 'Helvetica', 'Arial', sans-serif;
                color: #333; line-height: 1.2;
            }
            /* Margen superior exacto para tu membrete */
            main { margin: 40px 30px 50px 30px; }
            
            .fondo-membrete {
                position: fixed;
                top: 0; left: 0; width: 100%; height: 100%;
                z-index: -1000;
            } 

            /* Cabecera */
            .header-info-table {
                width: 100%;
                border-bottom: 2px solid #869b9c;
                margin-bottom: 15px;
                padding-bottom: 8px;
            }
            .report-title {
                color: #5a6a6b;
                font-size: 18px;
                font-weight: bold;
                text-transform: uppercase;
            }
            .report-date {
                text-align: right;
                font-size: 11px;
                color: #666;
            }

            /* Secciones de Título */
            .section-label {
                background-color: #f1f3f3;
                color: #445455;
                padding: 6px 12px;
                border-left: 4px solid #869b9c;
                font-weight: bold;
                font-size: 12px;
                margin: 15px 0 10px 0;
                text-transform: uppercase;
            }

            /* Tabla Principal */
            .table-custom {
                width: 100%;
                border-collapse: collapse;
                font-size: 8.5px;
            }
            .table-custom thead th {
                background-color: #869b9c;
                color: #ffffff;
                text-align: center;
                padding: 6px 3px;
                border: 1px solid #758a8b;
            }
            .table-custom tbody td {
                padding: 5px 3px;
                border: 1px solid #dee2e6;
                text-align: center;
                vertical-align: middle;
            }
            .table-custom tbody tr:nth-child(even) { background-color: #f9f9f9; }

            /* Indicadores Visuales */
            .badge-trabajador { color: #0d6efd; font-weight: bold; }
            .badge-patronal { color: #dc3545; font-weight: bold; }
            .folio-text { font-weight: bold; color: #333; }
            
            /* Cuadro Resumen */
            .resumen-compacto {
                width: 100%;
                margin-bottom: 20px;
                border-collapse: collapse;
            }
            .resumen-compacto td {
                padding: 10px;
                background: #f8f9fa;
                border: 1px solid #dee2e6;
                text-align: center;
            }
            .resumen-val {
                display: block;
                font-size: 16px;
                font-weight: bold;
                color: #869b9c;
            }
            
            .clearfix { clear: both; }
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
                        
                                <td>{{ \Carbon\Carbon::parse($fecha_inicial)->format('d/m/y') }} a {{ \Carbon\Carbon::parse($fecha_final)->format('d/m/y') }}</td>
                            </tr>
                    </table>
                </div><br><br><br>
                <div class="table-responsive">
                    <spam>Solicitudes</spam>
                    <table class="table table-striped mt-2">
                        <thead style="background-color: #869b9c;">
                            <th style="color: #fff;  text-align: center;">Usuario</th>
                            <th style="color: #fff;  text-align: center;">Solicitudes</th>
                            <th style="color: #fff;  text-align: center;">Confirmadas</th>
                        </thead>
                        <tbody> 
                            @foreach($solicitudes as $usuario)
                                <tr>
                                    <td style=" text-align: center;">{{ $usuario->name }}</td>
                                    <td style=" text-align: center;">{{ $usuario->solicitudes }}</td>
                                    <td style=" text-align: center;">{{ $usuario->confirmadas }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

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