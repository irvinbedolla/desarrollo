<table>
    <tbody>
        <!-- Solicitudes -->
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #002366; color: #ffffff; text-align: center; font-weight: bold;">
                        1. SOLICITUDES
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
        <!-- Solicitudes confirmadas -->
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #002366; color: #ffffff; text-align: center; font-weight: bold;">
                        2. SOLICITUDES CONFIRMADAS
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
                @foreach($solicitudesConfirmadas as $nombreCategoria => $valores)
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
        <!-- Ratidicaciones -->
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #002366; color: #ffffff; text-align: center; font-weight: bold;">
                        3. RATIFICACIONES
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
                @foreach($ratificaciones as $nombreCategoria => $valores)
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
        <!-- Ratidicaciones confirmadas -->
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #002366; color: #ffffff; text-align: center; font-weight: bold;">
                        4. RATIFICACIONES CONFIRMADAS
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
                @foreach($ratificacionesConcluidas as $nombreCategoria => $valores)
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
        <!-- Convenios -->
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #002366; color: #ffffff; text-align: center; font-weight: bold;">
                        5. PROGRAMADAS
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
                @foreach($programadas as $nombreCategoria => $valores)
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
        <!-- Convenios -->
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #002366; color: #ffffff; text-align: center; font-weight: bold;">
                        6. CONVENIOS
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
                @foreach($convenios as $nombreCategoria => $valores)
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
        <!-- Celebradas -->
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #002366; color: #ffffff; text-align: center; font-weight: bold;">
                        7. CELEBRADAS
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
                @foreach($celebradas as $nombreCategoria => $valores)
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
        <!-- archivadas -->
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #002366; color: #ffffff; text-align: center; font-weight: bold;">
                        8. ARCHIVADAS
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
                @foreach($archivadas as $nombreCategoria => $valores)
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
        <!-- archivadas -->
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #002366; color: #ffffff; text-align: center; font-weight: bold;">
                        9. NO CONCILIACION
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
                @foreach($noconciliacion as $nombreCategoria => $valores)
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
