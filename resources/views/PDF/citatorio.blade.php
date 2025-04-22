<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
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
                width: 330px; height: 80px; 
            }
            .p { 
                color:black;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <img src="{{ public_path('assets/images/Logos 2.png') }}" alt="Encabezado">
        </div>
        <div class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                           <p> AUDIENCIA DE CONCILIACIÓN PREJUDICIAL</p>
                           <p>FECHA DE EMISIÓN DEL CITATORIO:  {{ \Carbon\Carbon::now()->translatedFormat('d \d\e F \d\e Y') }}</p>
                           <p>SOLICITANTE:{{ $solicitante->nombre }}</p>
                           <p>NÚMERO DE SEGURIDAD SOCIAL DEL SOLICITANTE(S): {{ $solicitante->nss ?? 'N/A'}}</p>
                           <p>CURP DEL SOLICITANTE(S): {{ $solicitante->curp }}</p>
                           <p>CITADO: {{ $citado->nombre}} {{ $citado->primer_apellido}} {{ $citado->segundo_apellido}}</p>
                           <p>OBJETO DE LA SOLICITUD: {{ $motivos->pluck('motivo')->implode(', ') }}</p>

                           <p>NÚMERO DE IDENTIFICACIÓN ÚNICO: {{ $solicitud->NUE }}</p>
                           <p>{{ $citado->primer_apellido}} <br> {{ $citado->segundo_apellido}}</p>
                           <p>P R E S E N T E</p>
                           <p>En cumplimiento y observancia a la fracción XX, del artículo 123 Constitucional, apartado A; así como los de los
                            Principios Procesales contenidos en los artículos 684-E, 684-F fracción I y 685 de la Ley Federal del Trabajo, que
                            regulan el procedimiento obligatorio prejudicial conciliatorio; se notifica al C. REPRESENTANTE LEGAL
                            DE: {{ $citado->nombre}} para que asista a la Audiencia de Conciliación de fecha 30 de Enero de 2025 a las
                            12:45:00 horas, en la sala URU-1 de la Delegación Regional de {{ $solicitud->delegacion}} del Centro de Conciliación Laboral del
                            Estado de Michoacán de Ocampo, CALLE NUEVO PARICUTIN NO. 308, JARDINES DE SAN RAFAEL , URUAPAN,
                            MICHOACÁN DE OCAMPO, C.P. 60136, SE ENCUENTRA DENTRO DEL RECINTÓ DONDE ESTA RENTAS DEL
                            ESTADO, POR LA CLÍNICA DEL IMSS NO.76.</p>
                            <p>La audiencia será presidida por una conciliadora o conciliador del Centro de Conciliación Laboral del Estado de
                            Michoacán de Ocampo, en cumplimiento al artículo 684-H, manteniendo en todo momento los principios de
                            conciliación, imparcialidad, neutralidad, flexibilidad, legalidad, equidad, buena fe, información, honestidad, y
                            confidencialidad.
                            </p>
                            <p><<strong>>Con fundamento en los artículos 742, fracción XIII y 684-E, antepenúltimo párrafo, el presente citatorio es
                                entregado por el solicitante.</<strong>></p>
                            
                            <center><p><b>ATENTAMENTE</b></p>
                               
                            <p><b>Diana Guadalupe Negrete Ramírez<br>
                                ___________________________________<br>
                                FUNCIONARIA CONCILIADORA<br>
                                FUNCIONARIO CONCILIADOR</b></p></center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body> 
    
