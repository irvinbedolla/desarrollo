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
    @php     
       $direccion_sede='';
        if($solicitud->delegacion === 'Morelia'){
            $direccion_sede='BLVD. GARCÍA DE LEÓN NO. 1575, COL. CHAPULTEPEC ORIENTE, C.P.58260 MORELIA, MICHOACÁN DE OCAMPO';
        }    
        if($solicitud->delegacion === 'Uruapan'){
            $direccion_sede='NUEVO PARICUTÍN NO. 308, COL. JARDINES DE SAN RAFAEL, C.P.30136 URUAPAN, MICHOACÁN DE OCAMPO. SE ENCUENTRA DENTRO DEL RECINTÓ DONDE ESTA RENTAS DEL
                ESTADO, POR LA CLÍNICA DEL IMSS NO.76.';
        }
        if($solicitud->delegacion === 'Zamora') {
            $direccion_sede='JUSTO SIERRA PONIENTE NO. 290, COL. JARDINES DE CATEDRAL, C.P.59600 ZAMORA, MICHOACÁN DE OCAMPO';
        }  
        if($solicitud->delegacion === 'Zitácuaro') {
            $direccion_sede='CUAUHTEMOC ORIENTE NO. 15, COL. CUAUHTEMOC, C.P. 61506ZITÁCUARO, MICHOACÁN DE OCAMPO';
        } 
        if($solicitud->delegacion === 'Lázaro Cárdenas') {
            $direccion_sede='PARACHO NO. 26, COL. 600 CASAS, C.P.60950 LÁZARO CÁRDENAS, MICHOACÁN DE OCAMPO';
        }  
        if($solicitud->delegacion === 'Sahuayo') {
            $direccion_sede='AV. UNIVERSIDAD SUR NO. 300, COL. LOMAS DE UNIVERSIDAD, C.P.59103 SAHUAYO DE MORELOS, MICHOACÁN DE OCAMPO';
        } 
    @endphp

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
                                <td>{{ $solicitud->NUE }} </td>
                            </tr> 
                            <tr>   
                                <td><b>Centro de conciliación: </b></td>
                                <td>{{ $solicitud->delegacion }} </td>
                            </tr>
                    </table>
                </div><br><br><br><br>
                <p><center><b>RAZÓN DE NOTIFICACIÓN</b></center></p><br>
                <p><b>EXPEDIENTE: <br>
                      SOLICITANTE: <br>
                      CITADO: 
                </b></p>  
                           
                <p>Siendo las 14 HORAS CON 56 MINUTOS DEL DIA 29 DE MAYO DEL AÑO 2025, LICENCIADA MATILDE LIZET
                    calidad de notificador adscrito al Centro de Conciliación Laboral, oficina estatal MORELIA, me constituyo física y legalmente en el
                    domicilio ubicado en AVENIDA FRANCISCO I MADERO ORIENTE 313, COLONIA CENTRO, MORELIA, CP 58000, MUNICIPIO
                    MORELIA, ESTADO MICHOACÁN DE OCAMPO, siendo este el domicilio señalado en la solicitud de conciliación como el del CITADO:
                    RECORRIDOS TURISTICOS PIKIS. Todo ello a efecto de dar cumplimiento al CITATORIO DE CONCILIACIÓN de fecha 2025-05-21 en el
                    expediente citado. Y cerciorando de ser este el domicilio correcto y completo, apegándome en los siguientes elementos de convicción:
                    a) EL NÚMERO VISIBLE DEL INMUEBLE, Y b) LOS INFORMES DE VECINOS DEL LUGAR, QUIENES CONFIRMAN QUE SE TRAТА
                    DEL DOMICILIO CORRECTO. A mayor abundamiento, verifico quue cerca del domicilio se encuentran los siguientes puntos de referencia:
                    DOMICILIO UBICA ENTRE LAS CALLES GUILLERMO PRIETO Y NIGROMANTE, A MEDIA CUADRA DE LA CATEDRAL DE MORELIA.
                    De iqual forma, he constatado que se trata de un inmueble con las siguientes características: INMUEBLE TIPO EDIFICIO, DE FACHADA DE
                    CANTERA, CON VARIOS ACCESOS Y VENTANAS, ALBERGA AL HOTEL ALAMEDA, COMPARTEN EL DOMICILIO VARIOS
                    NEGOCIOS.<br><br>

                    Asimismo, por los informes que me proporciona la persona con quien se entiende la presente diligencia, quien dijo llamarse MARÍA SABINA,
                    QUIEN NO SE IDENTIFICA ALEGANDO QUE POE EL MOMENTO NO LO TIENE AL ALCANCE. Procedoa especificar su media filiación,
                    que incluye los siguientes rasgos: SEXO FEMENINO, TEZ TRIGUEÑA, EDAD ENTRE 50 Y 55 AÑOS, ALTURA ENTRE 1.65 Y 1.70 м,
                    COMPLEXIÓN DELGADA, CABELLO RUBIO, OJOS GRISES Y SEÑAS PARTICULARES: NINGUNA. LO ANTERIOR SE HACE DE
                    MANERA APROXIMADA, YA QUE EL SUSCRITO NO ES PERITO EN LA MATERIA. Quien manifiesta que OCUPA EL PUESTO DE
                    ATENCIÓN AL PÚBLICO en el domicilio en que se actúa. Enseguida me identifico con credencial vigente expedida por el Centro
                    Conciliación Laboral, oficina estatal MORELIA que me acredita como Notificador y le informo el motivo de mi visita, mediante lectura del
                    CITATORIO DE CONCILIACIÓN antes mencionado, requiriendo así la presencia DEL REPRESENTANTE LEGAL DEL CITADO:
                    RECORRIDOS TURISTICOS PIKIS a fin de NOTIFICARLO; la persona que me atiende manifiesta que el citado no se encuentra por el
                    momento, pero que efectivamente tiene su asiento de negocios en este domicilio. Por todo lo anterior, y de conformidad con lo dispuesto en
                    los artículos 741. 742 fracción XIII, 743 y 751 de la Ley Federal del Trabajo procedo a dejar CITATORIO DE LEY para
                    REPRESENTANTE LEGAL DEL CITADO.<br><br>

                    FIRMA PARA CONSTANCIA LEGAL.<br>
                    Anexando impresión fotográfica para constancia legal.<br>
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