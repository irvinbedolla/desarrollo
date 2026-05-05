<!DOCTYPE html>
<html>
<head>
    <title>Seguimiento a la solicitud {{ $user['id'] }}</title>
</head>
<body>
    <h1>Hola, {{ $user['nombre'] }}.</h1> 
    <br>Tu solicitud ha sido revisada por personal del Centro de Conciliación Laboral del Estado de Michoacán de Ocampo:
    <b>{{ $user['mensaje'] }}</b><br>
</body>
</html>