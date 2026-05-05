<style>
    @page {
        /* Definimos márgenes globales para que el texto nunca toque los bordes */
        /* 3cm arriba para dejar espacio al logo/membrete en cada página */
        margin: 3cm 2cm 3cm 2cm; 
    }
    
    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        color: black;
        margin: 0;
        padding: 0;
    }

    .fondo-membrete {
        position: fixed;
        top: -3cm; /* Compensa el margen del @page */
        left: -2cm;
        width: 21cm; /* Ancho estándar A4 */
        height: 29.7cm; /* Alto estándar A4 */
        z-index: -1;
    }

    .content {
        /* Eliminamos el padding excesivo aquí ya lo controla @page */
        position: relative;
        z-index: 1;
    }

    /* Clase para forzar salto si los citados son muchos */
    .page-break {
        page-break-after: always;
    }
</style>