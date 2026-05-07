<?php

namespace App\Imports;

use App\Models\Concepto;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ConceptoPagoImport implements ToModel, WithHeadingRow{

    public function model(array $row)
    {
        return new Concepto([
            'id_solicitud' => $row['id_solicitud'],
            'monto'        => $row['monto'],
            'descripcion'  => $row['descripcion'],
            'estatus'      => 'Pendiente',
            'tipo_pago'    => $row['tipo_pago'] ?? 'Ratificacion',
            'delegacion'   => $row['delegacion'] ?? 'Morelia',
        ]);
    }
}
