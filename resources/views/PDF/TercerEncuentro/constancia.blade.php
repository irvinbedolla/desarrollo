<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Constancia de participación</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @page {
            margin: 0px 0px;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: "DejaVu Sans", sans-serif;
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
            position: absolute;
            top: 520px; /*Posición del nombre del participante*/   
            left: 0;
            width: 100%;
            text-align: center; 
        }

        /* Estilo del nombre */
        .nombre-participante {
            font-family: "Gibson";
            font-size: 38px;      
            font-weight: bold;     
            color: #1a1a1a;        
        }

        .texto-secundario {
            margin: 0 auto 0 auto;
            width: 82%;
            font-size: 19px;
            font-family: "Poppins", sans-serif;
            text-align: justify;
        }
    </style>
</head>
<body>
    <img src="{{ public_path('assets/images/constancia_3erEncuentro.jpg') }}" class="fondo-membrete">
    @php
        $conversatorios_31 = [
            'Conversatorio 4: “Criterios Relevantes en la Ejecución de las Sentencias en Materia Laboral”',
            'Conversatorio 5: ILTRAS “Modelo de la Conciliación Laboral Comparada Internacionalmente”',
            'Presentación del Libro ILTRAS “El Despido en Latinoamérica: Una Visión de Derecho Comparado”',
            'Conferencia Magistral de Clausura',
        ];

        $fecha = in_array($constancia, $conversatorios_31)
            ? '31 de octubre de 2025'
            : '30 de octubre de 2025';
    @endphp
    <div class="content">
        <div class="nombre-participante">
            {{ $nombre }}
        </div>
        <div class="texto-secundario">
            <p>Por su asistencia a la Conferencia Inagural titulada <b><i>{{ $constancia }}</i></b>, celebrada el {{ $fecha }} 
            en el marco del <b>Tercer Encuentro Nacional de la Conciliación y la Justicia Laboral: <i>Una Mirada Internacional con Perspectiva en los Derechos 
            Humanos y Acceso a la Justicia Laboral,</i></b> cuya participación contribuyó al intercambio de ideas y al fortalecimiento del diálogo en materia laboral.</p>
        </div>
    </div>
</body>
</html>
