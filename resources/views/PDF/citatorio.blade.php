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
            .header img { 
                width: 180px; height: 45px; 
            }
            body {
                font-family: sans-serif;
                font-size: 12px;
                text-align: justify;
                color: black;
            }
            p {
                line-height: 1.5;
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
        <div class="header">
            <img src="{{ public_path('assets/images/Logos 2.png') }}" alt="Encabezado">
        </div>
        <div class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                           <p><b>ASUNTO: AUDIENCIA DE CONCILIACIÓN PREJUDICIAL<br>
                              FECHA DE EMISIÓN DEL CITATORIO:  {{ \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e Y') }}<br>
                              SOLICITANTE:{{ $solicitante->nombre }}<br>
                              NÚMERO DE SEGURIDAD SOCIAL DEL SOLICITANTE(S): {{ $solicitante->nss ?? 'N/A'}}<br>
                              CURP DEL SOLICITANTE(S): {{ $solicitante->curp }}<br>
                              CITADO: {{ $citado->nombre}} {{ $citado->primer_apellido}} {{ $citado->segundo_apellido}}<br>
                              OBJETO DE LA SOLICITUD: {{ $motivos->pluck('motivo')->implode(', ') }}<br>
                            </b></p>  

                           <p><b>NÚMERO DE IDENTIFICACIÓN ÚNICO: {{ $solicitud->NUE }}</b></p>
                           <p><b>C. REPRESENTANTE LEGAL DE: {{ $citado->primer_apellido}} <br> {{ $citado->segundo_apellido}}</b></p>
                           <p><b>P R E S E N T E</b></p>
                           <p>En cumplimiento y observancia a la fracción XX, del artículo 123 Constitucional, apartado A; así como los de los
                            Principios Procesales contenidos en los artículos 684-E, 684-F fracción I y 685 de la Ley Federal del Trabajo, que
                            regulan el procedimiento obligatorio prejudicial conciliatorio; se notifica al <b>C. REPRESENTANTE LEGAL
                            DE: {{ $citado->nombre}}</b> para que asista a la <b>Audiencia de Conciliación</b> de fecha <b>30 de Enero de 2025</b> a las
                            <b>12:45:00 horas</b>, en la sala <b>URU-1</b> de la Delegación Regional de <b>{{ $solicitud->delegacion}}</b> del Centro de Conciliación Laboral del
                            Estado de Michoacán de Ocampo, <b>{{$direccion_sede}}.</b></p>
                            <p>La audiencia será presidida por una conciliadora o conciliador del Centro de Conciliación Laboral del Estado de
                            Michoacán de Ocampo, en cumplimiento al artículo 684-H, manteniendo en todo momento los principios de
                            conciliación, imparcialidad, neutralidad, flexibilidad, legalidad, equidad, buena fe, información, honestidad, y
                            confidencialidad.
                            </p>
                            <p>Este citatorio se notifica de manera personal conforme al artículo 739, 739 Ter fracción I y IV, 742 fracción XIII, 743,
                                744 y 745 Ter de la Ley Federal del Trabajo.
                            </p>
                            <p>Con fundamento en el artículo 684-E. fracción IV, se apercibe al citado que de no comparecer por sí o por conducto de
                                su representante legal, o bien por medio de apoderado con facultades suficientes, se le impondrá una multa entre 50 y
                                100 veces la Unidad de Medida y Actualización, y se le tendrá por inconforme con todo arreglo conciliatorio.
                            </p>
                            
                            <center><p><b>ATENTAMENTE</b></p><br><br>
                            <p><b>___________________________________<br>
                                Diana Guadalupe Negrete Ramírez<br>
                                FUNCIONARIA CONCILIADORA/<br>
                                FUNCIONARIO CONCILIADOR</b></p></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

