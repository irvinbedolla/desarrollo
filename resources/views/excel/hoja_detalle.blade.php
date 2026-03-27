<table>
    <thead>
        <tr>
            <th style="background-color: #2196F3; color: #ffffff; font-weight: bold; text-align: center;" colspan="12">
                LISTADO DETALLADO DE CITATORIOS
            </th>
        </tr>
        <tr>
            <th width="30" style="font-weight: bold; background-color: #EFEFEF;">NUE</th>
            <th width="15" style="font-weight: bold; background-color: #EFEFEF;">Fecha Notificación</th>
            <th width="15" style="font-weight: bold; background-color: #EFEFEF;">Hora Notificación</th>
            <th width="40" style="font-weight: bold; background-color: #EFEFEF;">Solicitante</th>
            <th width="40" style="font-weight: bold; background-color: #EFEFEF;">Citado</th>
            <th width="60" style="font-weight: bold; background-color: #EFEFEF;">Domicilio</th>
            <th width="50" style="font-weight: bold; background-color: #EFEFEF;">Actividad Economica</th>
            <th width="35" style="font-weight: bold; background-color: #EFEFEF;">Auxiliar</th>
            <th width="30" style="font-weight: bold; background-color: #EFEFEF;">Notificador</th>
            <th width="30" style="font-weight: bold; background-color: #EFEFEF;">Municipio</th>
            <th width="30" style="font-weight: bold; background-color: #EFEFEF;">Delegación</th>
            <th width="30" style="font-weight: bold; background-color: #EFEFEF;">Estatus</th>
        </tr>
    </thead>
    <tbody>
        @foreach($notificaciones as $n)
        <tr>
            <td>{{ $n->NUE }}</td>
            <td>{{ $n->fecha ? \Carbon\Carbon::parse($n->fecha)->format('d/m/Y') : '' }}</td>
            <td>{{ $n->fecha ? \Carbon\Carbon::parse($n->fecha)->format('H:i:s') : '' }}</td>
            <td>{{ $n->nombre_solicitante }}</td>
            <td>{{ $n->nombre }} {{ $n->primer_apellido }} {{ $n->segundo_apellido }}</td>
            <td>{{ $n->calle }} #{{ $n->n_ext }}, Col. {{ $n->colonia }}</td>
            <td>{{ $n->actividad }} </td>
            <td>{{ $n->auxiliar }}</td>
            <td>{{ $n->nombre_notificador }}</td>
            <td>{{ $n->municipio }}</td>
            <td>{{ $n->delegacion }}</td>
            <td>{{ $n->estatus }}</td>
        </tr>
        @endforeach
    </tbody>
</table>