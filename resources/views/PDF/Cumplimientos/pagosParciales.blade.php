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
        </style>
        
    </head>
    <body>
        <img src="{{ public_path('assets/images/pdf_Siconcilio.jpg') }}" class="fondo-membrete">
        <footer>
            
        </footer>
        <main>
            <div class="content">
                <div class="table-responsive">
                    <table id="tabla_pago" class="table-striped" style="width:60%; float: right;">
                            <tr>    
                                <td><b>Número de identificación único: </b></td>
                                <td>{{ $solicitud->NUE }} </td>
                            </tr> 
                            <tr>   
                                <td><b>Centro de conciliación: </b></td>
                                <td>{{ $solicitud->delegacion }} </td>
                            </tr>
                    </table>
                </div><br><br><br><br><br>
                <p><b>
                    Trabajador(a): {{ $solicitud->nombre_trabajador }} <br> 
                    Empresa/Patrón: {{ $solicitud->empresa_representante }}<br>
                    Funcionario/a Conciliador/a Responsable: {{$conciliador->name}}<br>
                    Fecha y hora de cumplimiento: {{ \Carbon\Carbon::parse($solicitud->hora)->translatedFormat('d \d\e F \d\e\l Y \a \l\a\s h:i:s') }} horas.<br
                    Asistencia de los interesados: Si<br>
                    Convenio conciliatorio: Si
                </b></p>  
                <p><center><b>CONSTANCIA DE PAGO DE CUMPLIMIENTO</b></center></p><br>
                <p>
                    <b>Fundamentación:</b> Artículos 33 párrafo segundo, 590-E, 590-F, 684-C y 684-E fracciones XIII y XIV, 684-F fracción VII de la Ley Federal del Trabajo, artículo 8 fracción I, II y III 
                    de la Ley Orgánica del Centro de Conciliación Laboral del Estado de Michoacán de Ocampo y artículo 20 del Reglamento Interior del Centro de Conciliación Laboral del Estado de 
                    Michoacán de Ocampo.<br><br>

                    <b>Motivación:</b> Conforme a la determinación de dar por terminado el conflicto laboral, la parte <b>TRABAJADORA</b> y la parte <b>EMPLEADORA</b>, celebraron el Convenio de Conciliación 
                    de fecha <b>{{ \Carbon\Carbon::parse($solicitud->fecha)->translatedFormat('d \d\e F \d\e\l Y') }}</b> ante esta Autoridad Conciliadora como resultado de la audiencia de conciliación 
                    celebrada el día <b>{{ \Carbon\Carbon::parse($solicitud->fecha)->translatedFormat('d \d\e F \d\e\l Y') }}</b><!-- de 
                    <b>{{$solicitud->hora}}</b> a <b>{{$solicitud->hora_fin}} hrs--></b>.<br><br>

                    Las <b>PARTES</b> acordaron <b>PAGO</b> en el convenio referido, en este sentido, el <b>EMPLEADOR</b> da cumplimiento ante esta Autoridad Conciliadora al siguiente concepto:<br>

                    <p><b>{{ $pagos->observaciones}}</b></p>

                    Quien suscribe da fe del cumplimiento del concepto anteriormente descrito por parte del <b>EMPLEADOR. Doy fe.</b><br><br>

                    <b>Con fecha {{ \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e\l Y') }} se emite la presente Constancia de Pago Parcial del Convenio de Conciliación, con 
                    fundamento en la fracción XIV del artículo 684-E y fracción VIII del artículo 684-F de la Ley Federal del Trabajo.</b>
                </p>

                <br><br><br><br>       
                <center><br><br> <p><b>___________________________________<br>{{$conciliador->name}} <br>FUNCIONARIO/A CONCILIADOR/A</b></p></center>           
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