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
                line-height: 1.3;
                text-align: justify;
            }
            .page-break {
                page-break-after: always;
            }
            table, th, td {
                border: 1px solid #869b9c;
                border-collapse: collapse;
            }
        </style>
        @php
            $descripcionesMedio = [
                'PLACAS OFICIALES' => 'LA(S) PLACAS DE SEÑALIZACIÓN OFICIAL MÁS PRÓXIMA(S) AL DOMICILIO EN QUE SE ACTÚA, CON EL RESPECTIVO NOMBRE DE LA ALCALDÍA, COLONIA Y CALLE,',
                'NÚMERO VISIBLE' => 'EL MÚMERO VISIBLE DEL INMUEBLE,',
                'NUMERACIÓN CONSISTENTE' => 'EL NÚMERO DEL INMUEBLE ES CONSISTENTE CON LA NUMERACIÓN DE LA CALLE,',
                'INFORMES DE VECINOS' => 'LOS INFORMES DE VECINOS DEL LUGAR, QUIENES CONFIRMAN QUE SE TRATA DEL DOMICILIO CORRECTO,',
                'RÓTULOS VISIBLES' => 'LOS RÓTULOS VISIBLES EN EL INMUEBLE'
            ];
        @endphp
    </head>
    
    <body>
        <img src="{{ public_path('assets/images/pdf_Siconcilio.jpg') }}" class="fondo-membrete">
        <footer></footer>
        <main>
            <div class="content">
                <div class="table-responsive">
                    <table id="tabla_solicitud" class="table-striped" style="width:60%; float: right;">
                        <tr>    
                            <td><b>Número de identificación único: </b></td>
                            <td>{{ $solicitud->NUE }}</td>
                        </tr> 
                        <tr>   
                            <td><b>Centro de conciliación: </b></td>
                            <td>{{ $solicitud->delegacion }}</td>
                        </tr>
                        <tr>   
                            <td><b>Solicitante: </b></td>
                            <td>{{$solicitante->nombre}}</td>
                        </tr>
                        <tr>   
                            <td><b>Citado: </b></td>
                            <td>{{$citado->nombre}} {{$citado->primer_apellido}} {{$citado->segundo_apellido}}</td>
                        </tr>
                    </table>
                </div><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <!-- DELIGENCIA EXITOSA, ATIENDE OTRA PERSONA -->
                <p><center><b>RAZÓN DE NOTIFICACIÓN</b></center></p>
                           
                <p>Siendo las <b>{{ $citado->updated_at->format('H') }} HORAS CON {{ $citado->updated_at->format('i') }} MINUTOS
                    DEL DÍA {{ $citado->updated_at->translatedFormat('d \d\e F \d\e\l Y') }}, LIC. {{$notificador->name}}</b> en mi
                    calidad de notificador(a) adscrito al Centro de Conciliación Laboral, oficina estatal {{ $solicitud->delegacion }}, en 
                    ejercicio de las facultades conferidas en los artículos de la Ley Orgánica del Centro de Conciliación Laboral del 
                    Estado de Michoacán de Ocampo y 21 del reglamento interior del Centro de Conciliación Laboral del Estado de Michoacán 
                    de Ocampo, a efecto de dar cumplimiento al CITATORIO DE CONCILIACIÓN, me constituyo física y legalmente en el
                    domicilio ubicado en <b>{{strtoupper($citado->tipo_vialidad)}} {{$citado->calle}} {{$citado->n_ext}}@if($citado->n_int!=null) INT. {{$citado->n_int}}@endif, COLONIA {{$citado->colonia}}, 
                    {{mb_strtoupper($municipioCitado, 'UTF-8')}}, CP {{$citado->cp}}, {{mb_strtoupper($estadoCitado,'UTF-8')}}</b>, siendo este el domicilio señalado en la solicitud de Conciliación como el del <b>CITADO:
                    {{$citado->nombre}} @if($citado->primer_apellido!=null){{$citado->primer_apellido}}@endif @if($citado->segundo_apellido!=null){{$citado->segundo_apellido}}@endif.</b> Todo ello a efecto 
                    de dar cumplimiento al CITATORIO DE CONCILIACIÓN de fecha <b>{{ \Carbon\Carbon::parse($solicitud->fecha)->translatedFormat('d \d\e F \d\e\l Y') }}</b> en el expediente citado.<br><br>

                    Y cerciorándo de ser este el domicilio correcto y completo, apegándome en los siguientes elementos de convicción:
                    <b>
                        @php
                            $letras = range('A', 'Z');
                            $index = 0;

                            if (is_array($citado->medio)) {
                                $medios = $citado->medio;
                            } elseif (is_string($citado->medio)) {
                                $decoded = json_decode($citado->medio, true);
                                $medios = is_array($decoded)
                                    ? $decoded
                                    : array_map('trim', explode(',', $citado->medio));
                            } else {
                                $medios = [];
                            }
                        @endphp

                        @foreach($medios as $medioSeleccionado)
                            @if(isset($descripcionesMedio[$medioSeleccionado]))
                                <strong>{{ $letras[$index] }})</strong>
                                {{ $descripcionesMedio[$medioSeleccionado] }}
                                @php $index++; @endphp
                            @endif
                        @endforeach
                    </b>
                    A mayor abundamiento, verifico que cerca del domicilio se encuentran los siguientes puntos de referencia:
                    <b>{{$citado->abundar_area}}.</b> De igual forma, he constatado que se trata de un inmueble con las siguientes características: <b>{{$citado->abundar_inmueble}}.</b><br><br>

                    Asimismo, por los informes que me proporciona la persona con quien se entiende la presente diligencia, quien dijo llamarse <b>{{$citado->nombre_notificacion}},
                    QUIEN NO SE IDENTIFICA, {{$citado->motivo_identificacion}}.</b> Procedo a especificar su media filiación, que incluye los siguientes rasgos: <b>SEXO {{$citado->genero}}, 
                    TEZ {{$citado->tez}}, EDAD {{$citado->edad_filiacion}} AÑOS, ALTURA {{$citado->altura}} M., COMPLEXIÓN {{$citado->complexion}}, CABELLO {{$citado->cabello}}, OJOS {{$citado->ojos}} 
                    Y SEÑAS PARTICULARES: {{$citado->particulares}}. LO ANTERIOR SE HACE DE MANERA APROXIMADA, YA QUE EL SUSCRITO NO ES PERITO EN LA MATERIA</b>. Quien manifiesta que <b>OCUPA EL PUESTO DE 
                    {{$citado->puesto}}</b> en el domicilio en que se actúa. Enseguida me identifico con credencial vigente expedida por el Centro
                    Conciliación Laboral, oficina estatal <b>{{$solicitud->delegacion}}</b> que me acredita como Notificador y le informo el motivo de mi visita, mediante lectura del
                    CITATORIO DE CONCILIACIÓN antes mencionado, requiriendo así la presencia <b>DEL REPRESENTANTE LEGAL DEL CITADO: {{$citado->nombre}}@if($citado->primer_apellido!=null) {{$citado->primer_apellido}}@endif @if($citado->segundo_apellido!=null) {{$citado->segundo_apellido}}@endif</b>
                    a fin de NOTIFICARLO; <b>{{$citado->observaciones}} la persona que me atiende manifiesta que el citado no se encuentra por el momento, pero que efectivamente tiene su asiento de negocios 
                    en este domicilio.</b> Por todo lo anterior, y de conformidad con lo dispuesto en los artículos 741. 742 fracción XIII, 743 y 751 de la Ley Federal del Trabajo procedo a dejar CITATORIO DE LEY para
                    <b>EL REPRESENTANTE LEGAL DEL CITADO</b>.<br><br>
                    
                    <!--<div class="page-break"></div>--> <!-- Genera un salto de línea-->
                    <!--<br><br><br><br><br><br><br>-->
                    <b>FIRMA PARA CONSTANCIA LEGAL.</b><br>
                    Anexando impresión fotográfica para constancia legal.<br>
                    <b>Doy cuenta a la autoridad conciliadora competente y lo hago constar para todos los efectos legales a que haya lugar. Doy fe.</b> 
                </p>
                <p><center><b>___________________________________<br> LIC. {{mb_strtoupper($notificador->name,'UTF-8')}}<br> FUNCIONARIO/A NOTIFICADOR/A</b></center> </p>
                <div class="page-break"></div> <!-- Genera un salto de línea-->
                @foreach($imagenes as $index => $imagen) <!--Muestra una fotografía por hoja, númerando por anexos-->
                    @if($imagen)
                        <div class="content">
                            <div class="table-responsive">
                                <table id="tabla_solicitud" class="table-striped" style="width:65%; float: right;">
                                    <tr>   
                                        <td><b>ANEXO FOTOGRAFÍAS</b></td>
                                        <td><b>{{ $index + 1 }}</b></td>
                                    </tr>
                                    <tr>    
                                        <td><b>Número de identificación único: </b></td>
                                        <td>{{ $solicitud->NUE }}</td>
                                    </tr> 
                                    <tr>   
                                        <td><b>Centro de conciliación: </b></td>
                                        <td>{{ $solicitud->delegacion }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div style="text-align: center;">
                            <img src="{{ $imagen }}" style="width: 100%; height: 90%;">
                        </div>
                    @endif
                @endforeach
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