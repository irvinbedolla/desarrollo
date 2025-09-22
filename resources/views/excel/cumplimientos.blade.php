<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        
    <div>Cumplimiento en Ratificación</div>
    <table>
        <thead style="background-color: #869b9c;">
            <th style="color: #fff;  text-align: center;">Fecha</th>
            <th style="color: #fff;  text-align: center;">Hora</th>
            <th style="color: #fff;  text-align: center;">NUE</th>
            <th style="color: #fff;  text-align: center;">Empleador</th>
            <th style="color: #fff;  text-align: center;">Trabajador</th>
            <th style="color: #fff;  text-align: center;">Descripción</th>
            <th style="color: #fff;  text-align: center;">Monto</th>
            <th style="color: #fff;  text-align: center;">Giro Comercial</th>
            <th style="color: #fff;  text-align: center;">Delegacion</th>
            <th style="color: #fff;  text-align: center;">Conciliador</th>
            <th style="color: #fff;  text-align: center;">Estatus</th>
        </thead>
        <tbody>
            @php
                $totalPrice = 0;
            @endphp
             @foreach($pagosRatificacion as $estadistica)
                <tr>
                    <td style=" text-align: center;">{{ date_format($estadistica->fecha,'d-m-Y') }}</td>
                    <td style=" text-align: center;">{{ date_format($estadistica->hora, 'H:i:s') }}</td>
                    <td style=" text-align: center;">{{ $estadistica->NUE }}</td>
                    <td style=" text-align: center;">{{ $estadistica->empresa }} {{ $estadistica->primero_empresa }} {{ $estadistica->segundo_empresa }}</td>
                    <td style=" text-align: center;">{{ $estadistica->trabajador }} {{ $estadistica->primero_trabajador }} {{ $estadistica->segundo_trabajador }}</td>
                    <td style=" text-align: center;">{{ $estadistica->descripcion }}</td>
                    <td style=" text-align: center;">${{ number_format($estadistica->monto, 2) }}</td>
                    <td style=" text-align: center;">{{ $estadistica->name }}</td>
                    <td style=" text-align: center;">{{ $estadistica->giroComercial }}</td>
                    <td style=" text-align: center;">{{ $estadistica->delegacion }}</td>
                    <td style=" text-align: center;">{{ $estadistica->estatus }}</td>
                </tr>
                @php
                    // Suma los valores para el total
                    $totalPrice += $estadistica->monto;
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="font-weight: bold;">Total :</td>
                <td style="font-weight: bold;">${{ number_format($totalPrice, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div>Cumplimiento en Audiencia</div>
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
            @php
                $totalPrice = 0;
            @endphp
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
                @php
                    // Suma los valores para el total
                    $totalPrice += $estadistica->monto;
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="font-weight: bold;">Total :</td>
                <td style="font-weight: bold;">${{ number_format($totalPrice, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>