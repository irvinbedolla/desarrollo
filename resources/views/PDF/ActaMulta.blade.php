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
                            NÚMERO DE IDENTIFICACIÓN ÚNICO: [  ]<br><br></b></p>  
                            <center><p><b>ACTA DE MULTA</b></p></center>
                            <p>En <b>[CENTRO_DOMICILIO_ESTADO]</b> a <b>[AUDIENCIA_FECHA_AUDIENCIA]</b>, el funcionario conciliador <b>[CONCILIADOR_NOMBRE_COMPLETO]</b>, adscrito al Centro 
                                de Conciliación Laboral del Estado de Michoacán de Ocampo, <b>hace constar y certifica</b> que la parte citada <b>[SOLICITADO_NOMBRE_COMPLETO] [NO COMPARECIÓ/ 
                                NO COMPARECIÓ CON DOCUMENTO QUE ACREDITARÁ LA REPRESENTACIÓN LEGAL]</b> a la Audiencia de Conciliación prevista para las <b>[AUDIENCIA_HORA_INICIO]</b> horas 
                                de esta misma fecha, a pesar de encontrarse debidamente notificado(a) para tal efecto, circunstancia que se corrobora 
                                con <b>[SI_SOLICITADO_NOTIFICACION_BUZON_COMPARECENCIA]</b> la notificación de fecha <b>[SOLICITADO_FECHA_CONFIRMACION_AUDIENCIA]
                                [SI_SOLICITADO_NOTIFICACION_NO_BUZON_COMPARECENCIA] </b> 
                                la razón de notificación de fecha <b>[SOLICITADO_FECHA_NOTIFICACION][FIN_SI_SOLICITADO_NOTIFICACION]. Doy fe</b>.
                            </p>
                            <p>
                                <b>[CENTRO_DOMICILIO_ESTADO]</b>, a <b>[AUDIENCIA_FECHA_AUDIENCIA]</b>.
                            </p>
                            <p>
                                Vista la certificación mencionada, se advierte que la parte citada <b>[SOLICITADO_NOMBRE_COMPLETO]</b>, no compareció a la audiencia de conciliación prevista 
                                para las <b>[AUDIENCIA_HORA_INICIO]</b> horas de esta misma fecha, a pesar de encontrarse debidamente notificado(a) para tal efecto, circunstancia que se 
                                corrobora con la notificación de fecha <b>[SOLICITADO_FECHA_CONFIRMACION_AUDIENCIA][SI_SOLICITADO_NOTIFICACION_NO_BUZON_COMPARECENCIA]</b> la razón de 
                                notificación de fecha <b>[SOLICITADO_FECHA_NOTIFICACION][FIN_SI_SOLICITADO_NOTIFICACION]</b>, por lo que con fundamento en los artículos 16, primer párrafo, 
                                de la Constitución Política de los Estados Unidos Mexicanos; 590-E, 590-f, 684-E, fracciones IV, X, 684-I, fracción II de la Ley Federal del Trabajo; y 27 de 
                                la Ley Orgánica del Centro de Conciliación Laboral del Estado de Michoacán de Ocampo; Artículo 20 Fracción XVI y XVII del Reglamento Interior del Centro de 
                                Conciliación del Estado de Michoacán de Ocampo, <b>SE ACUERDA</b>:
                            </p>

                            <p>
                                En atención a lo anterior, se tiene a la parte citada <b>[SOLICITADO_NOMBRE_COMPLETO]</b> por <b>inconforme con todo arreglo conciliatorio</b>.
                            </p>

                            <p>
                                En este acto, se hace efectivo el apercibimiento decretado en el citatorio notificado el <b>
                                    [SI_SOLICITADO_NOTIFICACION_BUZON_COMPARECENCIA][SOLICITADO_FECHA_CONFIRMACION_AUDIENCIA][SI_SOLICITADO_NOTIFICACION_NO_BUZON_COMPARECENCIA]
                                    [SOLICITADO_FECHA_NOTIFICACION][FIN_SI_SOLICITADO_NOTIFICACION]</b> y se impone a la parte citada <b>[SOLICITADO_NOMBRE_COMPLETO] una 
                                    multa mínima por el monto de $5,657.00 (equivalente a Cincuenta veces la Unidad de Medida y Actualización)</b>.
                            </p>
                            
                            <p>
                                Gírese atento oficio electrónico al Servicio de Administración Tributaria, para que haga efectivo el cobro de la multa impuesta a la parte 
                                citada <b>[SOLICITADO_NOMBRE_COMPLETO]</b> con los datos de identificación con los que se cuenta:
                            </p>

                            <p>Nombre o razón social [SOLICITADO_NOMBRE_COMPLETO]  <br> 
                                2. CURP: [SOLICITADO_CURP]  <br>
                                3. RFC: [SOLICITADO_RFC]  <br>
                                4. Domicilio: [SOLICITADO_DOMICILIOS_COMPLETO]  
                            </p>
                            <p><b>
                                Notifíquese personalmente a la parte citada dentro de los próximos 15 días hábiles y por buzón electrónico a la parte solicitante.
                            </b></p>

                            <p>
                                Así lo proveyó <b>[CONCILIADOR_NOMBRE_COMPLETO]</b>, funcionario conciliador adscrito al Centro de Conciliación Laboral del Estado de Michoacán de Ocampo. <b>Doy fe.</b>
                            </p>

                            <br><br><br><br>
                                    
                            <center><br><br> <p><b>___________________________________<br>[CONCILIADOR_NOMBRE_COMPLETO] <br> FUNCIONARIA CONCILIADORA/<br>FUNCIONARIO CONCILIADOR</b></p></center>     
                       
            </div>
        </main>
    </body>
</html>    