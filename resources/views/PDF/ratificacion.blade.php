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
       
        <!-- Template CSS -->
        <link rel="icon"       href="../public/assets/images/ccl-r.png" type="image/x-icon">
        <link rel="stylesheet" href="../public/assets/css/style.css">
        <link rel="stylesheet" href="../public/assets/css/components.css">

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
                <div class="row">
                    <div class="col-lg-12">
                        <p><center><b>ACUSE DE RATIFICACIÓN DE CONVENIO<br>
                            CENTRO DE CONCILIACIÓN LABORAL DEL ESTADO DE MICHOACÁN DE OCAMPO
                        </b></center></p><br>
                        <p><b>FECHA DE LA SOLICITUD: {{ \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e Y') }}</b></p>
                        <p><b> 
                            EMPRESA/PATRÓN: {{ $solicitud->empresa }}<br>
                            PERSONA QUE ACUDE EN REPRESENTACIÓN PATRONAL: {{ $solicitud->empresa }}<br>
                            NOMBRE DEL TRABAJADOR/A: {{ $solicitud->trabajador }} <br>
                            OBJETO DE LA SOLICITUD:  {{ $solicitud->motivo }} <br>
                            DELEGACIÓN REGIONAL/OFICINA DE APOYO: {{ $solicitud->delegacion }}<br><br>
                        </b></p> <br>
                                
                        <p> Por este conducto se notifica a la parte solicitante que se ha generado exitosamente su cita para la <b>Ratificación de Convenio</b>, misma que tendrá lugar 
                            el día <b>{{ \Carbon\Carbon::parse($solicitud->fecha)->translatedFormat('d \d\e F \d\e\l Y') }}</b>  a las <b>{{ $solicitud->hora }}</b> horas, en la Delegación Regional/Oficina de Apoyo de 
                            <b>{{ $solicitud->delegacion }}</b> del Centro de Conciliación Laboral del Estado de Michoacán de Ocampo, con domicilio en <b>{{$direccion_sede}}</b>, para la entrega de la cantidad convenida a pagar 
                            <b>{{ $solicitud->monto }} {{ ucfirst($solicitud->montoTexto) }}</b> pesos M.N en <b> {{ $solicitud->tipo_pago }}</b>, 
                            apercibiéndolo  que de no presentarse cualquiera de las partes en la fecha y hora señalada, su solicitud quedará <b>archivada</b>, dejando a salvo el derecho de cualquiera de las partes para iniciar su solicitud. 
                        </p><br>
                        <p>
                            Agradecemos presentarse a la dirección proporcionada con diez minutos de anticipación de la hora citada, acompañado de sus documentos originales para cotejo (Identificaciones, Poder Notarial/Carta 
                            Poder, en caso de no contar con Folio Interno de Registro de Representación Patronal, y cheque en caso de que sea la opción de pago). <br><br>

                        <span style="color: red;"><b>NOTA</b></span>: La cantidad total a pagar estará sujeta a la revisión del Personal del Centro de Conciliación, para verificar que no exista Renuncia de Derechos, así como a la aceptación voluntaria de la 
                            persona trabajadora para proceder en la fecha y hora señalada a la firma de la Ratificación de su Convenio.<br><br>

                            Lo anterior, con fundamento en los artículos 123 fracción XX de la Constitución Política de los Estados Unidos Mexicanos, artículos 33, 590-E, 684-C, 684-E , 684-F de la Ley Federal del Trabajo, 
                            articulo 17 y 20 del Reglamento Interior del Centro de Conciliación Laboral del Estado de Michoacán de Ocampo, función 1.3.1.1 De los Auxiliares de Conciliadores del Manual de Organización del 
                            Centro de Conciliación Laboral del Estado de Michoacán de Ocampo y demás normativa aplicable.
                        </p>
                    </div>
                </div>
            </div>
        </main>    
    </body>
</html>    