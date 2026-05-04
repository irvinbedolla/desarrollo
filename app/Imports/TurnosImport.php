<?php

namespace App\Imports;

use App\Models\PagoSolicitud;
use Maatwebsite\Excel\Concerns\ToModel;

class TurnosImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PagoSolicitud([
            //
        ]);
    }
}
