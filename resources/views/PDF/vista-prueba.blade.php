    Reporte de Estadisticas
        <h3 class="text-center">Reporte Cuantitativo</h3>
        <table  class="table table-striped mt-1">
            <thead style="background-color: #4A001F;">
                <th style="color: #fff;">Usuario</th>
                <th style="color: #fff;">Solicitudes</th>
            </thead>
            <tbody>
                @foreach($solicitudes as $solicitud)
                <tr>
                    <td>{{$solicitud->name}}</td>
                    <td>{{$solicitud->solicitudes}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h3 class="text-center">Reporte Cuantitativo</h3>
        <table  class="table table-striped mt-1">
            <thead style="background-color: #4A001F;">
                <th style="color: #fff;">Usuario</th>
                <th style="color: #fff;">Ratificaciones</th>
            </thead>
            <tbody>
                @foreach($ratificaciones as $solicitud)
                <tr>
                    <td>{{$solicitud->name}}</td>
                    <td>{{$solicitud->ratificaciones}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
                                