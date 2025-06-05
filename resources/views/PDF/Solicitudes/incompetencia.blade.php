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
            <script type="text/php">
                if (isset($pdf)) {
                    $font = $fontMetrics->get_font("Arial", "normal");
                    $size = 10;
                    $text = "Página " . $PAGE_NUM . " de " . $PAGE_COUNT;
                    $pdf->text(500, 820, $text, $font, $size);
                }
            </script>
        </footer>
        <main>
            <div class="content">
                <div class="table-responsive">
                    <table id="tabla_solicitud" class="table-striped" style="width:60%; float: right;">
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
                <p><center><b>CONSTANCIA DE INCOMPETENCIA</b></center></p><br>
                <p><b>
                    Solicitante: {{ $solicitante->nombre }} <br> 
                    Citado(s): 
                    @foreach($citados as $citado)    
                        {{$citado->nombre}} {{$citado->primer_apellido}} {{$citado->segundo_apellido}},&nbsp;
                    @endforeach<br><br>

                    Fecha de conflicto: {{ \Carbon\Carbon::parse($solicitud->fecha)->translatedFormat('d \d\e F \d\e\l Y') }} <br>
                    Posible prescripción de derechos: No <br>
                </b></p>  
                <p>
                    <b>Fundamentación: </b>Artículos 123 fracción XXXI de la Constitución Política de los Estados Unidos mexicanos, 527, 684-E, fracción V de la Ley Federal del Trabajo 5 y 8, 
                    fracción I de la Ley Orgánica del centro de Conciliación Laboral del Estado de Michoacán de Ocampo.<br><br>

                    <b>Motivación: </b>Con fecha <b>{{ \Carbon\Carbon::parse($solicitud->fecha)->translatedFormat('d \d\e F \d\e\l Y') }}</b>, <b>{{ $solicitante->nombre }}</b> presentó ante la Oficina Regional del Centro de Conciliación Laboral del Estado de Michoacán Delegación <b>{{ $solicitud->delegacion }}</b> la solicitud <b>{{ $solicitante->NUE }}</b>.<br><br>

                    La Oficina Regional del Centro de Conciliación Laboral del Estado de Michoacán de Ocampo, de conformidad con la información aportada y derivado del análisis de la solicitud mencionada, esta Autoridad 
                    Conciliadora se declara incompetente por declinatoria, toda vez que la rama industrial o de servicio materia de la soliciotud presentada es de cáracter federal local de conformidad con la fraccipon XXXI 
                    del apartado A del artículo 123 Constitucional, así como del artículo 527 de la Ley Federal del Trabajo.<br><br>

                    <!-- LLenado de los conciliadores -->
                    [ CAMPO A LLENAR POR LOS CONCILIADORES]

                    En este sentido y de conformidad con los principios constitucionales de legalidad, imparcialidad, confiabilidad, eficacia, confidencialidad, objetividad, profesionalismo, transparencia y publicidad, se notifica al Solicitante 
                    de la imcompetencia por declinatoria y se remite copia certificada de la presente constancia al Centro de Conciliación Laboral competente.<br><br>

                    Se emite la presente constancia con fecha <b>{{ \Carbon\Carbon::parse($solicitud->fecha)->translatedFormat('d \d\e F \d\e\l Y') }}</b> dejando a salvo los derechos del solicitante para continuar con el procedimiento de conciliación ante la Autoridad Conciliadora competente.<br><br>

                    Finalmemnte, se dejan a salvo los derechos de los interesados para continuar con el procedimiento de conciliación ante el Centro de Conciliación Laboral competente, en términos de los artículos 527 y 684-E fracción 
                    V párrafosegundo de la Ley Federal del Trabajo. <b>Doy Fe.</b>
                </p>

                <br><br><br><br>       
                <center><br><br> <p><b>___________________________________<br>[ MTRO. ADOLFO CECILIO CAMPOS MARCIAL] <br>NOMBRE Y FIRMA DEL DIRECTOR/A DEL CENTRO</b></p></center>           
            </div>
        </main>
    </body>