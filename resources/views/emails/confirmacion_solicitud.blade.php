<!DOCTYPE html>
<html>
<head>
    <title>Registro de Solicitud</title>
</head>
<body>
    <h1>Hola, {{ $variables['Nombre'] }}</h1>
    Gracias por registrar tu solicitud en Si Concilio, tu número de folio es: "{{ $variables['NumFolio'] }}", revisa el proceso de tu solicitud en https://siconcilio.cclmichoacan.gob.mx/ en el apartado de Buzón Electrónico para continuar tu proceso.<br>
    <h3>Usuario:</h3> {{ $variables['email'] }}<br>
    <h3>Contraseña:</h3> {{ $variables['Contraseña'] }}<br>
</body>
</html>