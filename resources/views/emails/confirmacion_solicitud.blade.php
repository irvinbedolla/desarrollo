<!DOCTYPE html>
<html>
<head>
    <title>Registro de Solicituid</title>
</head>
<body>
    <h1>Hola, {{ $userData['Nombre'] }}</h1>
    Gracias por registrar tu solicitud en Si Concilio, revisa el proceso de tu solicitud en https://siconcilio.cclmichoacan.gob.mx/ en el apartado de Buzón Electrónico para continuar tu proceso.<br>
    <h3>Usuario:</h3> {{ $userData['email'] }}<br>
    <h3>Contraseña:</h3> {{ $userData['Contraseña'] }}<br>
</body>
</html>