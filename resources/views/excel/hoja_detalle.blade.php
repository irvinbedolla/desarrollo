<table>
    <thead>
        <tr>
            <th style="background-color: #2196F3; color: #ffffff; font-weight: bold; text-align: center;" colspan="10">
                LISTADO DETALLADO DE CITATORIOS
            </th>
        </tr>
        <tr>
            <th style="font-weight: bold; background-color: #EFEFEF;">NUE</th>
            <th style="font-weight: bold; background-color: #EFEFEF;">Fecha</th>
            <th style="font-weight: bold; background-color: #EFEFEF;">Solicitante</th>
            <th style="font-weight: bold; background-color: #EFEFEF;">Citado</th>
            <th style="font-weight: bold; background-color: #EFEFEF;">Domicilio</th>
            <th style="font-weight: bold; background-color: #EFEFEF;">Actividad Economica</th>
            <th style="font-weight: bold; background-color: #EFEFEF;">Auxiliar</th>
            <th style="font-weight: bold; background-color: #EFEFEF;">Notificador</th>
            <th style="font-weight: bold; background-color: #EFEFEF;">Delegación</th>
            <th style="font-weight: bold; background-color: #EFEFEF;">Estatus</th>
        </tr>
    </thead>
    <tbody>
        @foreach($notificaciones as $n)
        <tr>
            <td>{{ $n->NUE }}</td>
            <td>{{ \Carbon\Carbon::parse($n->fecha)->format('d/m/Y') }}</td>
            <td>{{ $n->nombre_solicitante }}</td>
            <td>{{ $n->nombre }} {{ $n->primer_apellido }} {{ $n->segundo_apellido }}</td>
            <td>{{ $n->calle }} #{{ $n->n_ext }}, Col. {{ $n->colonia }}</td>
            <td>{{ $n->actividad }} </td>
            <td>{{ $n->delegacion }}</td>
            <td>{{ $n->auxiliar }}</td>
            <td>{{ $n->nombre_notificador }}</td>
            <td>{{ $n->estatus }}</td>
        </tr>
        @endforeach
    </tbody>
</table>