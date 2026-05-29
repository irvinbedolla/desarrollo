<?php

namespace App\Imports;

use App\Models\Turnos;
use Maatwebsite\Excel\Concerns\ToModel;

class TurnosImport implements ToModel
{
    public function model(array $row)
    {
        return new Turnos([
            'consecutivo'           => $row[0],
            'año'                   => $row[1],
            'fecha'                 => $row[2],
            'hora'                  => $row[3], 
            'hora_fin'              => $row[4], 
            'auxiliar'              => $row[5], // Contiene el valor numérico (ej. 6)
            'tipo'                  => 'Ratificación',
            'lugar_auxiliar'        => $row[7], // Contiene el texto (ej. 'Auxiliar 5')
            'exepcion'              => $row[8],
            'edad'                  => $row[9],
            'sexo'                  => $row[10],
            'salario'               => $row[11],
            'monto'                 => $row[12],
            'empresa'               => $row[13],
            'primero_empresa'       => $row[14],
            'segundo_empresa'       => $row[15],
            'nombre_empresa'        => $row[16],
            'trabajador'            => $row[17],
            'primero_trabajador'    => $row[18],
            'segundo_trabajador'    => $row[19],
            'frecuencia'            => "Diario",    
            'dias'                  => $row[21],
            'estatus'               => "Concluida",
            'delegacion'            => "Morelia",
            'email'                 => $row[22],
            'telefono'              => $row[23],
            'JLCA'                  => "No",
            'motivo'                => "Terminacion de la relacion laboral",
            'tipo_identificacion'   => $row[25],
            'num_identificacion'    => $row[26],
            'PrimaVacacional'       => '',
            'fecha_inicio'          => $row[29],
            'fecha_termino'         => $row[30],
            'categoria'             => $row[31],
            'tipo_pago'             => $row[32],
            'Aguinaldo'             => $row[33],
            'Vacaciones'            => 'Si',
            'Otras'                 => 1,
            'Especifique'           => 'Especifique',    
            'resolucion_primera'    => $row[35],
            'resolucion_justificacion' => $row[36],
            'resolucion_segunda'    => $row[37],
            'vacaciones_dias'       => $row[38],
            'aguinaldo_dias'        => $row[39],
            'horario'               => $row[40],
            'comida'                => $row[41],
            'estado_rat'            => $row[42],
            'municipio_rat'         => $row[43],
            'NUE'                   => $row[44],
            'id_conciliador'        => $row[45],
            'idAbogado'             => $row[46],
            'user_id'               => $row[47],
            'nacionalidad'          => $row[48],
            'id_historial'          => $row[49],
            'ine'                   => "",
            'representacion'        => "",
            'trabajador_curp'       => "",
            'curp_solicitante'      => "",
            'tipo_vialidad'         => "",
            'calle'                 => "",
            'num_ext'               => "",
            'colonia'               => "",
            'codigo_postal'         => "",
        ]);
    }
}