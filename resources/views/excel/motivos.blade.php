<table>
    <tbody>
        <!-- Solicitudes -->
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #002366; color: #ffffff; text-align: center; font-weight: bold;">
                        1. SOLICITUDES ADMITIDAS
                    </th>
                </tr>
                <tr style="background-color: #eeeeee; text-align: center;">
                    <th width="50">Categoría</th>
                    <th width="15">Hombres</th>
                    <th width="15">Mujeres</th>
                    <th width="15">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($solicitudes as $nombreCategoria => $valores)
                    <tr>
                        <!-- La variable $nombreCategoria contiene el texto (a. Despido...) -->
                        <td style="text-align: left;">{{ $nombreCategoria }}</td>
                        <td style="text-align: center;">{{ $valores['h'] }}</td>
                        <td style="text-align: center;">{{ $valores['m'] }}</td>
                        <td style="text-align: center; font-weight: bold;">{{ $valores['total'] }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #f2f2f2; font-weight: bold;">
                    <td style="text-align: right;">TOTAL GENERAL:</td>
                    <td style="text-align: center;">{{ $solicitudes->sum('h') }}</td>
                    <td style="text-align: center;">{{ $solicitudes->sum('m') }}</td>
                    <td style="text-align: center;">{{ $solicitudes->sum('total') }}</td>
                </tr>
            </tfoot>
        </table>
    </tbody>
