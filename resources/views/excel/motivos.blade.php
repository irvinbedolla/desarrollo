<table>
    <!-- CABECERA PRINCIPAL -->
    <thead>
        <tr>
            <th colspan="4" style="background-color: #002366; color: #ffffff; text-align: center; font-weight: bold;">
                REPORTE ESTADÍSTICO DE CONTROL LABORAL
            </th>
        </tr>
    </thead>

    <tbody>
        <!-- SECCIÓN 1: SOLICITUDES GENERALES -->
        <tr><td colspan="4" style="background-color: #f2f2f2; font-weight: bold;">1. SOLICITUDES POR MOTIVO</td></tr>
        <tr style="background-color: #eeeeee;">
            <th>Categoría</th>
            <th>Hombres</th>
            <th>Mujeres</th>
            <th>Total</th>
        </tr>
        @foreach($solicitudes as $s)
        <tr>
            <td>{{ $s->categoria }}</td>
            <td>{{ $s->total_hombres }}</td>
            <td>{{ $s->total_mujeres }}</td>
            <td style="font-weight: bold;">{{ $s->total_general }}</td>
        </tr>
        @endforeach

        <tr><td></td></tr> <!-- Espaciador -->

        <!-- SECCIÓN 2: RATIFICACIONES (Con ceros incluidos) -->
        <tr><td colspan="4" style="background-color: #f2f2f2; font-weight: bold;">2. RATIFICACIONES TOTALES</td></tr>
        <tr style="background-color: #eeeeee;">
            <th>Categoría</th>
            <th>Hombres</th>
            <th>Mujeres</th>
            <th>Total</th>
        </tr>
        @foreach($ratificaciones as $nombre => $datos)
        <tr>
            <td>{{ $nombre }}</td>
            <td>{{ $datos['h'] }}</td>
            <td>{{ $datos['m'] }}</td>
            <td style="font-weight: bold;">{{ $datos['total'] }}</td>
        </tr>
        @endforeach

        <tr><td></td></tr> <!-- Espaciador -->

        <!-- SECCIÓN 3: CONVENIOS EN AUDIENCIA -->
        <tr><td colspan="4" style="background-color: #f2f2f2; font-weight: bold;">3. AUDIENCIAS CON CONVENIO</td></tr>
        <tr style="background-color: #eeeeee;">
            <th>Categoría</th>
            <th>Hombres</th>
            <th>Mujeres</th>
            <th>Total</th>
        </tr>
        @foreach($audienciasConvenios as $ac)
        <tr>
            <td>{{ $ac->categoria }}</td>
            <td>{{ $ac->total_hombres }}</td>
            <td>{{ $ac->total_mujeres }}</td>
            <td style="font-weight: bold;">{{ $ac->total_general }}</td>
        </tr>
        @endforeach
    </tbody>
</table>