<?php

namespace App\Imports;

use App\Models\PagoSolicitud;
use Maatwebsite\Excel\Concerns\ToModel;

class ConceptoPagoImport implements ToModel, WithHeadingRow{

    public function model(array $row)
    {
        return new Pagos([
            'id_solicitud' => $row['id_solicitud'],
            'monto'        => $row['monto'],
            'fecha'        => $row['fecha'], 
            'hora'         => $row['hora'], 
            'descripcion'  => $row['descripcion'],
            'estatus'      => 'Pendiente',
            'tipo_pago'    => $row['tipo_pago'] ?? 'Ratificacion',
            'delegacion'   => $row['delegacion'] ?? 'Morelia',
        ]);
    }
}
