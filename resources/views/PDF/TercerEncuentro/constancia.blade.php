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
        'Conversatorio titulado “Criterios Relevantes en la Ejecución de las Sentencias en Materia Laboral”',
        'Conversatorio titulado “Modelo de la Conciliación Laboral Comparada Internacionalmente”',
        'Presentación del Libro “El Despido en Latinoamérica: Una Visión de Derecho Comparado”',
        'Conferencia Magistral de Clausura',
    ];

    $fecha = in_array($conferencia, $conversatorios_31)
        ? '31 de octubre de 2025'
        : '30 de octubre de 2025';

    $conversatorios_conferencias = [
        'Conversatorio titulado “Criterios Relevantes en la Ejecución de las Sentencias en Materia Laboral”',
        'Conversatorio titulado “Modelo de la Conciliación Laboral Comparada Internacionalmente”',
        'Conversatorio titulado “La Conciliación Laboral como Mecanismo de la Solución Pacífica de los Conflictos Laborales”',
        'Conversatorio titulado “Implicación y Aplicación de la Ley Silla, Regulación del Trabajo en Plataformas Digitales y Reducción de las Jornadas Laborales”',
        'Conversatorio titulado “La Seguridad Social como Derecho Humano y su Impacto en las Resoluciones Judiciales”',
    ];
    $complemento = in_array($conferencia, $conversatorios_conferencias)
        ? 'al'
        : 'a la';
    $complemento2 = in_array($conferencia, $conversatorios_conferencias)
        ? 'celebrado'
        : 'celebrada';
@endphp

    <div class="content">
        <div class="nombre-participante">
            {{ $participante->nombre }} {{ $participante->primer_apellido }} {{ $participante->segundo_apellido }}
        </div>
        <div class="texto-secundario">
            <p>Por su asistencia {{ $complemento }} <b><i>{{ $conferencia }}</i></b>, {{$complemento2}} el {{ $fecha }}, 
            en el marco del <b>Tercer Encuentro Nacional de la Conciliación y la Justicia Laboral: <i>Una Mirada Internacional con Perspectiva en los Derechos 
            Humanos y Acceso a la Justicia Laboral,</i></b> cuya participación contribuyó al intercambio de ideas y al fortalecimiento del diálogo en materia laboral.</p>
        </div>
    </div>
</body>
</html>
