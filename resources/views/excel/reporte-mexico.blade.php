<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>NUE</th>
                    <th>Mes</th>
                    <th>Año</th>
                    <th>Entidad de Registro</th>
                    <th>Municipio de Registro</th>
                    <th>Municipio de ubicación del establecimiento</th>
                    <th>Sexo de trabajador</th>
                    <th>Actividad Economica/th>
                    <th>Razón social</th>
                    <th>Motivo del Convenio</th>
                    <th>Monto del pago</th>
                    <th>Estatus Expediente</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach($reportes as $solicitud)
                    <tr>
                        <td style=" text-align: center;">{{ $solicitud->NUE}}</td>
                        <td style=" text-align: center;">{{ $solicitud->mes}}</td>
                        <td style=" text-align: center;">{{ $solicitud->año}}</td>
                        <td style=" text-align: center;">{{ $solicitud->estado}}</td>
                        <td style=" text-align: center;">{{ $solicitud->municipio}}</td>
                        <th style=" text-align: center;">{{ $solicitud->municipio_abogado }}</th>
                        <th style=" text-align: center;">{{ $solicitud->sexo }}</th>
                        <th style=" text-align: center;">{{ $solicitud->giroComercial }}</th>
                        <th style=" text-align: center;">{{ $solicitud->nombres_patronal }}{{ $solicitud->primer_apellido_patronal }}{{ $solicitud->segundo_apellido_patronal  }}</th>
                        <th style=" text-align: center;">{{ $solicitud->motivo }}</th>
                        <th style=" text-align: center;">${{ number_format($solicitud->total, 2) }}</th>
                        <th style=" text-align: center;">{{ $solicitud->estatus }}</th>
                        @php
                            $total = $total + $solicitud->total;
                        @endphp
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td></td><td></td>
                    <td></td><td></td>
                    <td></td><td></td>
                    <td></td><td></td>
                    <td></td>
                    <td style="font-weight: bold;">Total :</td>
                    <td style="font-weight: bold;">{{ number_format($total, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>