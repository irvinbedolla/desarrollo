<!DOCTYPE html>
<html>
<head>
    <title>Seguimiento a la solicitud {{ $user['id'] }}</title>
</head>
<body>
    <h1>Hola, {{ $user['nombre'] }}.</h1> 
    <br>Tu solicitud ha sido revisada por personal del Centro de Conciliación Laboral del Estado de Michoacán de Ocampo, sin embargo, se remitió a periodo de <b>Prevención</b>, con la siguiente observación :
    <b>{{ $user['mensaje'] }}</b><br>Por lo que te recomendamos ingresar a tu buzón electrónico en https://siconcilio.cclmichoacan.gob.mx ,  a la brevedad posible, para corregir tu solicitud, de lo contrario, ésta será archivada como se señala en el acuse de solicitud.
</body>
</html>