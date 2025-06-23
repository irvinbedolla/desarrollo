<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <title>Sí Concilio</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <!-- Bootstrap 5.3.3 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        
        <style>
            @page {
                margin: 0px 0px;
            }
            body {
                counter-reset: page;
                font-family: sans-serif;
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

            .footer-content::after {
                content: "Página " counter(page) " de " counter(pages);
            }
            body {
                margin: 0cm;
                padding: 0cm;
                background-color: transparent !important;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
                color: black;
            }
            .fondo-membrete {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
            }
            .content {
                padding: 3cm 2cm 3cm 2cm;
                position: relative;
                /*padding: 4cm 2cm 3cm 2cm; /* Deja espacio para encabezado y pie  padding: 100px 50px;*/
                z-index: 1;
            }
            p {
                line-height: 1.5;
                text-align: justify;
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
                                <td><b>Número de identificación único: </b></td>
                                <td>[ EXPEDIENTE] </td>
                            </tr> 
                            <tr>   
                                <td><b>Centro de conciliación: </b></td>
                                <td>[DIRECCIÓN DE SEDE] </td>
                            </tr>
                    </table>
                </div><br><br><br>
                <!-- DELIGENCIA NO EXITOSA, NO SE LOCALIZA INTERIOR -->
                <p><center><b>RAZÓN DE NOTIFICACIÓN</b></center></p><br>
                <p><b>EXPEDIENTE: <br>
                      SOLICITANTE: <br>
                      CITADO: 
                </b></p>  
                           
                <p>Siendo las <b>[14 HORAS CON 56 MINUTOS DEL DÍA [FECHA DE NOTIFICACIÓN], LIC. [NOMBRE NOTIFICADOR]</b> en mi
                    calidad de notificador adscrito al Centro de Conciliación Laboral, oficina estatal [SEDE], a efecto de dar cumplimiento al CITATORIO DE CONCILIACIÓN
                    de fecha <b>[FECHA CITATORIO]</b> en el expediente citado, en el que se ordena NOTIFICAR <b>AL CITADO: [NOMBRE CITADO]</b>, en el domicilio señalado
                    en <b>[AVENIDA FRANCISCO I MADERO ORIENTE 313, COLONIA CENTRO, MORELIA, CP 58000, MUNICIPIO
                    MORELIA, ESTADO MICHOACÁN DE OCAMPO]</b>. Cerciorándome de ser el domicilio correcto por <b>a) LA(S) PLACAS DE SEÑALIZACIÓN OFICIAL MÁS PRÓXIMA(S) 
                    AL DOMICILIO EN QUE SE ACTÚA, CON EL RESPECTIVO NOMBRE DE LA ALCALDÍA, COLONIA Y [TIPO_VILAIDAD], b) EL MÚMERO VISIBLE DEL INMUEBLE</b>.<br><br>

                    Hago constar a la autoridad conciliadora competente que al recorrer la parte señalada del inmueble, no logro localizar el número interior proporcionado 
                    por la parte solicitante; adicionalmente hago constar que <b>[RECORRIENDO LA PLANTA BAJA DEL INMUEBLE SEÑALADO SE PUEDE APRECIAR QUE NO TIENEN SEÑALADOS LOS 
                    INTERIORES, Y SE PUEDE APRECIAR UNA TINTORERIA, BANCOS SCOTIANBANK, BANAMEX, CAFÉ STARBUCKS, SALÓN & SPA, RELOJERÍA Y JOYERÍA, SIN EMBARGO NO ME ES POSIBLE 
                    LOCALIZAR EL INMUEBLE SEÑALADO POR LA PARTE ACTORA]</b>.<br><br>
                    
                    En esa razón, me encuentro imposibilitado para dar cumplimiento a lo ordenado en el citatorio de conciliación; toda vez que no cuento 
                    con los elementos de cercioramiento requeridos por el Artículo 743 Fracción I de la Ley Federal del Trabajo, por lo que me es imposible 
                    dar cumplimiento al citatorio antes citado.<br><br>

                    <b>Doy cuenta a la autoridad conciliadora competente y lo hago constar para todos los efectos legales a que haya lugar. DOY FE.</b> 
                </p>
                <br>
                <p><center><b>___________________________________<br> <br> FUNCIONARIO/A NOTIFICADOR/A</b></center> </p>
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
</html>