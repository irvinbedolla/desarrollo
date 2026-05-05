<!DOCTYPE html>
<html>
<head>
    <title>Registro de Solicitud</title>
</head>
<body>
    <h1>Hola, {{ $variables['Nombre'] }}</h1>
    Gracias por registrar tu solicitud en SÍCONCILIO, tu número de folio para seguimiento es: "{{ $variables['NumFolio'] }}", 
    para continuar tu proceso, en breve el Centro de Conciliación revisará los datos de tu solicitud y en un término no mayor a 3 días,
    recibirás la confirmación de tu solicitud o requerimiento para subsanar la información o documento faltante.<br>
    <h3>Usuario:</h3> {{ $variables['email'] }}<br>
    <h3>Contraseña:</h3> {{ $variables['Contraseña'] }}<br>
</body>
</html>