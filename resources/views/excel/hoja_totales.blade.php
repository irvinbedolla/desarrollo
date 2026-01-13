<table>
    <thead>
        <tr>
            <th style="background-color: #4CAF50; color: #ffffff; font-weight: bold; text-align: center;" colspan="4">
                RESUMEN DE NOTIFICACIONES POR NOTIFICADOR
            </th>
        </tr>
        <tr>
            <th style="background-color: #D3D3D3; font-weight: bold; width: 300px;">Notificador</th>
            <th style="background-color: #D3D3D3; font-weight: bold; width: 150px;">Total Citatorios</th>
            <th style="background-color: #D3D3D3; font-weight: bold; width: 150px;">Notificadas</th>
            <th style="background-color: #D3D3D3; font-weight: bold; width: 150px;">No Notificadas</th>
        </tr>
    </thead>
    <tbody>
        @foreach($totales as $t)
        <tr>
            <td>{{ $t['nombre'] }}</td>
            <td style="text-align: center;">{{ $t['total'] }}</td>
            <td style="text-align: center; color: #008000;">{{ $t['notificadas'] }}</td>
            <td style="text-align: center; color: #FF0000;">{{ $t['no_notificadas'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>