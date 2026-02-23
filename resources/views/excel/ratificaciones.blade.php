<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div>Ratificación</div>
        <table>
            <thead style="background-color: #869b9c;">
                <tr>
                    <th width="15" style="background-color: #869b9c; color: #ffffff;">Fecha</th>
                    <th width="10" style="background-color: #869b9c; color: #ffffff;">Hora</th>
                    <th width="25" style="background-color: #869b9c; color: #ffffff;">NUE</th>
                    <th width="40" style="background-color: #869b9c; color: #ffffff;">Empleador</th>
                    <th width="40" style="background-color: #869b9c; color: #ffffff;">Trabajador</th>
                    <th width="30" style="background-color: #869b9c; color: #ffffff;">Descripción</th>
                    <th width="15" style="background-color: #869b9c; color: #ffffff;">Monto</th>
                    <th width="20" style="background-color: #869b9c; color: #ffffff;">Delegacion</th>
                    <th width="15" style="background-color: #869b9c; color: #ffffff;">Conciliador</th>
                    <th width="15" style="background-color: #869b9c; color: #ffffff;">Estatus</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalPrice = 0;
                @endphp
                @foreach($Ratificacion as $estadistica)
                    <tr>
                        <td style=" text-align: center;">{{ $estadistica->fecha }}</td>
                        <td style=" text-align: center;">{{ $estadistica->hora}}</td>
                        <td style=" text-align: center;">{{ $estadistica->NUE }}</td>
                        <td style=" text-align: center;">{{ $estadistica->empresa }} {{ $estadistica->primero_empresa }} {{ $estadistica->segundo_empresa }}</td>
                        <td style=" text-align: center;">{{ $estadistica->trabajador }} {{ $estadistica->primero_trabajador }} {{ $estadistica->segundo_trabajador }}</td>
                        <td style=" text-align: center;">${{ number_format($estadistica->monto, 2) }}</td>
                        <td style=" text-align: center;">{{ $estadistica->delegacion }}</td>
                        <td style=" text-align: center;">{{ $estadistica->name }}</td>
                        <td style=" text-align: center;">{{ $estadistica->auxiliar }}</td>
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
                    <td style="font-weight: bold;">Total :</td>
                    <td style="font-weight: bold;">{{ number_format($totalPrice, 2) }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="font-weight: bold;">Pagado :</td>
                    <td style="font-weight: bold;">{{ number_format($ratificacionePagadas->pagado_monto, 2) }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="font-weight: bold;">Total :</td>
                    <td style="font-weight: bold;">{{ number_format($totalPrice-$ratificacionePagadas->pagado_monto, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>