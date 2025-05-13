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
                                <td>[EXPEDIENTE_FOLIO] </td>
                            </tr> 
                            <tr>   
                                <td><b>Centro de conciliación: </b></td>
                                <td>[CENTRO_NOMBRE] </td>
                            </tr>
                            <tr>
                                <td><b>Sala de conciliación: </b></td>
                                <td>[SALA_SALA] </td>
                            </tr>
                    </table>
                </div><br><br><br><br><br>
                <p><b>
                    Solicitante: [SOLICITANTE_NOMBRE_COMPLETO] <br> 
                    Citado(a): [RESOLUCION_CITADOS_CONVENIO] <br>
                    Fecha y hora de audiencia: [AUDIENCIA_FECHA_AUDIENCIA]  [AUDIENCIA_HORA_INICIO] <br> 
                    Fecha que se emite la constancia de incumplimiento: <br>
                    Pena Convencional: Si <br>
                    Días de pena convencional [ 3 tres días hábiles]
                </b></p>  

                <p><center><b>CONSTANCIA DE INCUMPLIMIENTO DE CONVENIO</b></center></p><br>

                <p>
                    De conformidad con el artículo 123 fracción XX de la Constitución Política de los Estados Unidos Mexicanos y artículos 33, 590-E, 590-F, 684-C y 684-E, 
                    987 y 990 de la Ley Federal del Trabajo; así como los artículos 17 y 20 del Reglamento Interior del Centro de Conciliación Laboral del Estado de Michoacán de Ocampo.<br><br>

                    Ante la falta de pago pactado en las cláusulas <b>QUINTA</b> y <b>SEXTA</b> del <b>CONVENIO DE CONCILIACIÓN</b> relacionada con el expediente <b>[NÚMERO DE IDENTIFICACIÓN ÚNICO]</b> 
                    y el Convenio ratificado ante esta autoridad conciliadora en fecha <b>[FECHA DEL CONVENIO Y DE LA AUDIENCIA O CITA]</b>, por tanto,  se emite el siguiente:<br><br>
                                
                    <p><center><b>ACUERDO:</b></center></p><br>
                                
                    En atención a los principios de legalidad, imparcialidad, confiabilidad, eficacia, objetividad, profesionalismo, transparencia y se emite <b>CONSTANCIA DE INCUMPLIMIENTO DE CONVENIO</b> 
                    a favor de la parte <b>[TRABAJADORA/EMPLEADORA]</b>; dejando a salvo sus derechos para ejercer las acciones pertinentes ante el Tribunal Laboral que corresponda. Se ordena el archivo 
                    del presente <b>asunto como concluido. Doy Fe.</b>
                </p>

                <br><br><br><br>       
                <center><br><br> <p><b>___________________________________<br>[CONCILIADOR_NOMBRE_COMPLETO]</b></p></center>           
            </div>
        </main>
    </body>