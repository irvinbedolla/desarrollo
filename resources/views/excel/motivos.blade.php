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
                    <td style="text-align: center;">{{ $solicitudesConfirmadas->sum('h') }}</td>
                    <td style="text-align: center;">{{ $solicitudesConfirmadas->sum('m') }}</td>
                    <td style="text-align: center;">{{ $solicitudesConfirmadas->sum('total') }}</td>
                </tr>
            </tfoot>
        </table>
        <!-- Ratidicaciones -->
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #002366; color: #ffffff; text-align: center; font-weight: bold;">
                        3. RATIFICACIONES AGENDADAS
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
                    <td style="text-align: center;">{{ $ratificaciones->sum('h') }}</td>
                    <td style="text-align: center;">{{ $ratificaciones->sum('m') }}</td>
                    <td style="text-align: center;">{{ $ratificaciones->sum('total') }}</td>
                </tr>
            </tfoot>
        </table>
        <!-- Ratidicaciones confirmadas -->
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #002366; color: #ffffff; text-align: center; font-weight: bold;">
                        4. RATIFICACIONES CONCLUIDAS
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
                    <td style="text-align: center;">{{ $ratificacionesConcluidas->sum('h') }}</td>
                    <td style="text-align: center;">{{ $ratificacionesConcluidas->sum('m') }}</td>
                    <td style="text-align: center;">{{ $ratificacionesConcluidas->sum('total') }}</td>
                </tr>
            </tfoot>
        </table>
        <!-- archivadas -->
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #002366; color: #ffffff; text-align: center; font-weight: bold;">
                        5. ARCHIVADAS POR FALTA DE INTERES
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
                    <td style="text-align: center;">{{ $archivadas->sum('h') }}</td>
                    <td style="text-align: center;">{{ $archivadas->sum('m') }}</td>
                    <td style="text-align: center;">{{ $archivadas->sum('total') }}</td>
                </tr>
            </tfoot>
        </table>
        <!-- Convenios -->
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #002366; color: #ffffff; text-align: center; font-weight: bold;">
                        6. AUDIENCIAS PROGRAMADAS
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
                    <td style="text-align: center;">{{ $programadas->sum('h') }}</td>
                    <td style="text-align: center;">{{ $programadas->sum('m') }}</td>
                    <td style="text-align: center;">{{ $programadas->sum('total') }}</td>
                </tr>
            </tfoot>
        </table>
        <!-- Celebradas -->
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #002366; color: #ffffff; text-align: center; font-weight: bold;">
                        7. AUDIENCIAS CELEBRADAS
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
                    <td style="text-align: center;">{{ $celebradas->sum('h') }}</td>
                    <td style="text-align: center;">{{ $celebradas->sum('m') }}</td>
                    <td style="text-align: center;">{{ $celebradas->sum('total') }}</td>
                </tr>
            </tfoot>
        </table>
        <!-- Convenios -->
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #002366; color: #ffffff; text-align: center; font-weight: bold;">
                        8. CONVENIOS
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
                    <td style="text-align: center;">{{ $convenios->sum('h') }}</td>
                    <td style="text-align: center;">{{ $convenios->sum('m') }}</td>
                    <td style="text-align: center;">{{ $convenios->sum('total') }}</td>
                </tr>
            </tfoot>
        </table>
        <!-- Convenios -->
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #002366; color: #ffffff; text-align: center; font-weight: bold;">
                        10. NO CONCILIACION (AUDIENCIA)
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
                    <td style="text-align: center;">{{ $noconciliacion->sum('h') }}</td>
                    <td style="text-align: center;">{{ $noconciliacion->sum('m') }}</td>
                    <td style="text-align: center;">{{ $noconciliacion->sum('total') }}</td>
                </tr>
            </tfoot>
        </table>
        <table>
            <thead>
                <tr>
                    <th colspan="4" style="background-color: #002366; color: #ffffff; text-align: center; font-weight: bold;">
                        9. INCOMPARECENCIA
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
                @foreach($incomparecencias as $nombreCategoria => $valores)
                    <tr>
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
                    <td style="text-align: center;">{{ $incomparecencias->sum('h') }}</td>
                    <td style="text-align: center;">{{ $incomparecencias->sum('m') }}</td>
                    <td style="text-align: center;">{{ $incomparecencias->sum('total') }}</td>
                </tr>
            </tfoot>
        </table>
    </tbody>
