<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        

    <table>
        <thead style="background-color: #869b9c;">
            <th style="color: #fff;  text-align: center;">Fecha</th>
            <th style="color: #fff;  text-align: center;">Hora</th>
            <th style="color: #fff;  text-align: center;">NUE</th>
            <th style="color: #fff;  text-align: center;">Empleador</th>
            <th style="color: #fff;  text-align: center;">Trabajador</th>
            <th style="color: #fff;  text-align: center;">Descripción</th>
            <th style="color: #fff;  text-align: center;">Monto</th>
            <th style="color: #fff;  text-align: center;">Delegacion</th>
            <th style="color: #fff;  text-align: center;">Conciliador</th>
            <th style="color: #fff;  text-align: center;">Estatus</th>
        </thead>
        <tbody>
             @foreach($pagosRatificacion as $estadistica)
                <tr>
                    <td style=" text-align: center;">{{ date_format($estadistica->fecha,'d-m-Y') }}</td>
                    <td style=" text-align: center;">{{ date_format($estadistica->hora, 'H:i:s') }}</td>
                    <td style=" text-align: center;">{{ $estadistica->NUE }}</td>
                    <td style=" text-align: center;">{{ $estadistica->empresa }} {{ $estadistica->primero_empresa }} {{ $estadistica->segundo_empresa }}</td>
                    <td style=" text-align: center;">{{ $estadistica->trabajador }} {{ $estadistica->primero_trabajador }} {{ $estadistica->segundo_trabajador }}</td>
                    <td style=" text-align: center;">{{ $estadistica->descripcion }}</td>
                    <td style=" text-align: center;">${{ number_format($estadistica->monto, 2) }}</td>
                    <td style=" text-align: center;">{{ $estadistica->delegacion }}</td>
                    <td style=" text-align: center;">{{ $estadistica->name }}</td>
                    <td style=" text-align: center;">{{ $estadistica->estatus }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table>
        <thead style="background-color: #869b9c;">
            <th style="color: #fff;  text-align: center;">Fecha</th>
            <th style="color: #fff;  text-align: center;">Hora</th>
            <th style="color: #fff;  text-align: center;">NUE</th>
            <th style="color: #fff;  text-align: center;">Empleador</th>
            <th style="color: #fff;  text-align: center;">Trabajador</th>
            <th style="color: #fff;  text-align: center;">Descripción</th>
            <th style="color: #fff;  text-align: center;">Monto</th>
            <th style="color: #fff;  text-align: center;">Delegacion</th>
            <th style="color: #fff;  text-align: center;">Conciliador</th>
            <th style="color: #fff;  text-align: center;">Estatus</th>
        </thead>
        <tbody>
            @foreach($pagosAudiencias as $estadistica)
                <tr>
                    <td style=" text-align: center;">{{ date_format($estadistica->fecha, 'd-m-Y') }}</td>
                    <td style=" text-align: center;">{{ date_format($estadistica->hora, 'H:i:s') }}</td>
                    <td style=" text-align: center;">{{ $estadistica->NUE }}</td>
                    <td style=" text-align: center;">{{ $estadistica->empresa_representante }}</td>
                    <td style=" text-align: center;">{{ $estadistica->nombre_trabajador }}</td>
                    <td style=" text-align: center;">{{ $estadistica->descripcion }}</td>
                    <td style=" text-align: center;">${{ number_format($estadistica->monto, 2) }}</td>
                    <td style=" text-align: center;">{{ $estadistica->delegacion }}</td>
                    <td style=" text-align: center;">{{ $estadistica->name }}</td>
                    <td style=" text-align: center;">{{ $estadistica->estatus }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>