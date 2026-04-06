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
            $direccion_sede='BLVD. GARCÍA DE LEÓN NO. 1575, COL. CHAPULTEPEC ORIENTE, C.P. 58260 MORELIA, MICHOACÁN DE OCAMPO';
        }    
        if($solicitud->delegacion === 'Uruapan'){
            $direccion_sede='NUEVO PARICUTÍN NO. 308, COL. JARDINES DE SAN RAFAEL, C.P. 60136 URUAPAN, MICHOACÁN DE OCAMPO. SE ENCUENTRA DENTRO DEL RECINTÓ DONDE ESTA RENTAS DEL
                ESTADO, POR LA CLÍNICA DEL IMSS NO.76.';
        }
        if($solicitud->delegacion === 'Zamora') {
            $direccion_sede='JUSTO SIERRA ORIENTE NO. 290, COL. JARDINES DE CATEDRAL, C.P. 59670 ZAMORA, MICHOACÁN DE OCAMPO';
        }  
        if($solicitud->delegacion === 'Zitácuaro') {
            $direccion_sede='5 DE MAYO NORTE NO. 03, PISO 3 COL. CENTRO, C.P. 61500 ZITÁCUARO, MICHOACÁN DE OCAMPO';
        } 
        if($solicitud->delegacion === 'Lázaro Cárdenas') {
            $direccion_sede='PARACHO NO. 26, COL. 600 CASAS, C.P. 60950 LÁZARO CÁRDENAS, MICHOACÁN DE OCAMPO';
        }  
        if($solicitud->delegacion === 'Sahuayo') {
            $direccion_sede='AV. UNIVERSIDAD SUR NO. 300, COL. LOMAS DE UNIVERSIDAD, C.P. 59103 SAHUAYO DE MORELOS, MICHOACÁN DE OCAMPO';
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
                            <td><b>Oficina: </b></td>
                            <td>{{ $solicitud->delegacion }} </td>
                        </tr>
                        <tr>    
                            <td><b>Número de identificación único: </b></td>
                            <td>{{ $solicitud->NUE }} </td>
                        </tr> 
                    </table>
                </div><br><br><br>
                <p><center><b>CENTRO DE CONCILIACIÓN LABORAL DEL ESTADO DE MICHOACÁN DE OCAMPO</b></center></p><br>
                <p><b>FECHA DE EMISIÓN DEL CITATORIO: </b>{{ \Carbon\Carbon::parse($fechaEmision)->translatedFormat('d \d\e F \d\e\l Y') }}<br>
                <b>ASUNTO:</b> CITATORIO DE AUDIENCIA DE CONCILIACIÓN<br>
                <b> SOLICITANTE:</b> {{ $solicitante->nombre }}<br>
                <b>CITADO:</b> {{ $citado->nombre}} {{ $citado->primer_apellido}} {{ $citado->segundo_apellido}}<br>
                <b>DOMICILIO:</b>{{ $citado->tipo_vialidad}} {{ $citado->calle }}, <br>NUMERO {{ $citado->n_ext }} @if(!empty($citado->n_int))
                                    INT. {{ $citado->n_int }}
                                @endif COLONIA {{ $citado->colonia}}, {{ mb_strtoupper($municipioNombre, 'UTF-8')}}, {{ mb_strtoupper($estadoNombre, 'UTF-8')}} C.P. {{ $citado->cp }}.</b><br><br>
                </b></p>  
                           
                <p><b>P R E S E N T E</b></p>
                <p>En cumplimiento y observancia a la fracción XX, del artículo 123 Constitucional, apartado A; así como los de los
                    Principios Procesales contenidos en los artículos 684-E, 684-F fracción I y 685 de la Ley Federal del Trabajo, que
                    regulan el procedimiento obligatorio prejudicial conciliatorio; se notifica al Representante legal de <b>C. {{ $citado->nombre }} {{ $citado->primer_apellido}} {{ $citado->segundo_apellido}}</b> para 
                    que asista a la <b>Audiencia de Conciliación</b> 
                    de fecha <b>{{ \Carbon\Carbon::parse($audiencia->fecha)->translatedFormat('d \d\e F \d\e\l Y') }}</b> a las
                    <b>{{ \Carbon\Carbon::parse($audiencia->hora)->format('H:i') }}</b> horas, en la <b>{{ $audiencia->sala }}</b> de la Delegación Regional de <b>{{ $solicitud->delegacion}}</b> del Centro de Conciliación Laboral del
                    Estado de Michoacán de Ocampo, con domicilio en <b>{{$direccion_sede}}.</b>
                </p>

                <p>La audiencia será presidida por una Conciliadora o Conciliador del Centro de Conciliación Laboral del Estado de
                    Michoacán de Ocampo, en cumplimiento al artículo 684-H, manteniendo en todo momento los principios de
                    conciliación, imparcialidad, neutralidad, flexibilidad, legalidad, equidad, buena fe, información, honestidad, y
                    confidencialidad.
                </p>
                @if($citado->notificacion=="Centro")
                <!--@(notificacion==centro)-->
                    <p>Este citatorio se notifica de manera personal conforme al artículo 739, 739 Ter fracción I, 742 fracción XIII, 743, 
                        744 y 745 Ter de la Ley Federal del Trabajo.
                    </p>
                <!--@(notificacion==centro)-->
                    
                        @if($solicitud->tipo_solicitud == 1)
                            <p>Con fundamento en el artículo 684-E. fracción IV, así como el artículo 692 de la Ley Federal del Trabajo, se apercibe al citado que de no comparecer por sí, 
                            o por conducto de su representante legal, o bien por medio de apoderado con facultades suficientes 
                            se le impondrá una multa entre 50 y 100 veces la Unidad de Medida y Actualización, y se le tendrá por inconforme con todo arreglo conciliatorio.</p>
                        @endif
                @endif
                <!--@(notificacion==solicitante)-->
                @if($citado->notificacion=="Trabajador")
                    <p>
                        Con fundamento en los artículos 684-C último párrafo, 684-E antepenúltimo párrafo y 742 fracción XIII, el presente citatorio es entregado por el solicitante.
                    </p>
                @endif

                @php
                    $longitud = mb_strlen($citado->nombre);
                    $forzarSalto = $longitud > 245;
                @endphp

                @if($forzarSalto)
                    <div style="page-break-before: always;"><br><br><br><br><br><br></div>
                @else
                    <br><br><br><br>
                @endif

                <br><br><br>
                <p><center><b>___________________________________<br> {{ mb_strtoupper($conciliador->name, 'UTF-8') }} <br> FUNCIONARIO/A CONCILIADOR/A<br>
                        DEL CENTRO DE CONCILIACIÓN LABORAL<br>DEL ESTADO DE MICHOACÁN DE OCAMPO</b></center> </p>
            </div>
            <script type="text/php">
                if (isset($pdf)) {
                    $font = $fontMetrics->get_font("Arial", "normal");
                    $size = 10;
                    $y = $pdf->get_height() - 44;
                    $x = ($pdf->get_width() / 2) - 50;
                    $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
                    $pdf->page_text($x, $y, $text, $font, $size, array(0, 0, 0));
                }
            </script>
        </main>    
    </body>
</html>    

