<?php

namespace App\Imports;

use App\Models\Turnos;
use Maatwebsite\Excel\Concerns\ToModel;

class TurnosImport implements ToModel, WithHeadingRow{

    public function model(array $row)
    {
        return new Turnos([
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
