<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Cita;
use App\Models\Pagos;
use App\Models\Turnos;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CitasExport;
use App\Models\Audiencias;

class AudienciasController extends Controller
{

    public function audiencias() {

        $userID = Auth::user()->id;
        $userRole = Auth::user()->roles->pluck('name')->all();

        //dd($userID, $userRole);
        //echo "id: " . $userID;
        //echo "rol: " . implode(', ', $userRole);

        if ($userRole[0] == "Super Usuario") {
            $audiencias = Audiencias::all();

            $eventos = [];
            foreach ($audiencias as $audiencia) {

                if ($audiencia->estatus === 'Incompetencia') {
                    $color = '#DA0909';
                } elseif ($audiencia->estatus === 'Archivada') {
                    $color = '#EAE300';
                } elseif ($audiencia->estatus === 'Conciliación') {
                    $color = '#00CE1C';
                } elseif ($audiencia->estatus === 'No Conciliación') {
                    $color = '#00CE1C';
                }
                 else {
                    $color = '#CCCCCC';
                }

                $eventos[] = [
                    'id' => $audiencia->id,
                    'id_solicitud' => $audiencia->id_solicitud,
                    'title' => $audiencia->tipo,
                    'start' => $audiencia->fecha->format('Y-m-d') . 'T' . $audiencia->hora->format('H:i:s'),
                    'extendedProps' => [
                        'hora' => $audiencia->hora->format('h:i A'),
                        'color' => $color,
                        'numero_audiencia' => $audiencia->numero_audiencia,
                        'folio_audiencia' => $audiencia->folio_audiencia,
                        'fecha' => $audiencia->fecha->format('d/m/Y'),
                        'estatus' => $audiencia->estatus,
                        'tipo' => $audiencia->tipo,
                        'conciliador' => $audiencia->id_conciliador,
                        'delegacion' => $audiencia->delegacion,
                        'sala' => $audiencia->sala,
                        'usuario' => $userID,
                    ]
                ];
            }

            return response()->json($eventos);
        }

    }

    public function exportarExcel()
    {
        //return Excel::download(new CitasExport, 'citas.xlsx');
        return Excel::download(new CitasExport, 'pagos.xlsx');
    }

}