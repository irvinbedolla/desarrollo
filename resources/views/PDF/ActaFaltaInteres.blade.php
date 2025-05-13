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
                <p><b>CENTRO DE CONCILIACIÓN LABORAL DEL ESTADO DE MICHOACÁN DE OCAMPO<br>
                        sunto: Archivo de asunto por falta de interés<br>
                        Solicitante: [SOLICITANTE_NOMBRE_COMPLETO] <br> 
                        Número de identificación único: [EXPEDIENTE FOLIO] <br>
                </b></p>  
                <p>En <b>[CENTRO_DOMICILIO_ESTADO] a [FECHA_ACTUAL],</b></p>
                <p>
                    <b>VISTO</b> el estado que guarda el expediente identificado con el número <b>[EXPEDIENTE_FOLIO]</b> relativo a la solicitud de conciliación realizada por
                    <b>[SOLICITANTE_NOMBRE_COMPLETO]</b>, por falta de interés se formula resolución en atención a los siguientes:
                </p>
                <p>
                    <center><b>RESULTANDOS</b></center>
                </p><br>
                <p>
                    <b>Primero.</b> El <b>[SOLICITUD_FECHA_RECEPCION]</b>, <b>[SOLICITANTE_NOMBRE_COMPLETO]</b> solicitó ante este Centro, iniciar con el Procedimiento 
                    de Conciliación Prejudicial con el(los) citados <b>[SOLICITUD_NOMBRES_CITADOS]</b> por objeto de <b>[SOLICITUD_OBJETO_SOLICITUDES]</b>.<br><br>

                    <b>Segundo.</b> El <b>[SOLICITUD_FECHA_RATIFICACION]</b>, el Centro de Conciliación <b>[CENTRO_NOMBRE]</b> admitió la solicitud de Conciliación,
                    señalando que la celebración de la Audiencia de Conciliación se realizaría el <b>[AUDIENCIA_FECHA_AUDIENCIA]</b> a las <b>[AUDIENCIA_HORA_INICIO]</b> 
                    horas en la sala de audiencia <b>[SALA_NOMBRE]</b>, en las instalaciones de este Centro.<br><br>

                    <b>Tercero.</b> El <b>[SOLICITUD_FECHA_RATIFICACION]</b>, se concluyó la notificación personal de él(los) citado(s).<br><br>

                    <b>Cuarto.</b> El día de la audiencia, <b>[SOLICITANTE_NOMBRE_COMPLETO]</b> no se presentó en ningún momento durante el tiempo que se tenía programado para la audiencia.<br>
                                
                    <br>En esas condiciones, este Centro expone los siguientes: 
                </p>
                <p>
                    <center><b>CONSIDERANDOS</b></center>
                </p><br>

                <p>
                    <b>I.</b> Esta Autoridad es competente para conocer del presente asunto en términos de lo dispuesto por los artículos 123, apartado A, fracción XX, 
                    párrafos tercero y cuarto de la Constitución Política de los Estados Unidos Mexicanos; artículos 590-E, 590-F, 684-B y 684-D, y 684-E de la Ley Federal 
                    de Trabajo; artículos 5 y 27 de la Ley Orgánica del Centro de Conciliación Laboral del Estado de Michoacán de Ocampo; y artículos 17 y 20 del Reglamento 
                    Interior del Centro de Conciliación Laboral del Estado de Michoacán de Ocampo.<br>

                    Y toda vez que la solicitud de Ratificación de Convenio presentada y admitida de conformidad con lo establecido por los artículos 33 párrafo segundo, 
                    684-C y 684-E de la Ley Federal del Trabajo. Señalándose <b>[FECHA Y HORA]</b> para la Audiencia de Ratificación de Convenio, se notificó a la parte 
                    solicitante <b>[SOLICITANTE_NOMBRE_COMPLETO]</b>, sin embargo, no acudió, no obrando una causa justificada de la incomparecencia. <br><br> 
                    Por lo anteriormente expuesto, se:
                </p>       
                <p>
                    <center><b>RESUELVE</b></center>
                </p><br>
                <p>
                    <b>Primero.</b> Se archiva el expediente <b>[EXPEDIENTE_FOLIO]</b> que consta desde el <b>[SOLICITUD_FECHA_RATIFICACION]</b>, en este Centro, por falta de interés 
                    del Solicitante.<br><br>

                    <b>Segundo.</b> Se le informa que el plazo de prescripción se reanuda a partir del día siguiente en que fue programada la audiencia, de conformidad con el artículo 684-E, 
                    fracción X de la Ley Federal del Trabajo.<br><br>

                    <b>Tercero.</b> Conforme al artículo 521 fracción III, de la Ley Federal del Trabajo, se dejan a salvo los derechos del trabajador para solicitar nuevamente la conciliación 
                    y con ello interrumpir nuevamente la prescripción.<br><br>

                    <b>Cuarto.</b> La interrupción de la prescripción cesa al día siguiente en que se emite esta Resolución, de conformidad con el artículo 521, fracción III de la Ley Federal 
                    del Trabajo.
                </p>

                <br><br><br><br>  
                <center><br><br> <p><b>___________________________________<br>[CONCILIADOR_NOMBRE_COMPLETO]</b></p></center>     
            </div>
        </main>
    </body>
</html>    