<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Pagos;
use App\Models\Turnos;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CitasExport;

class CitaController extends Controller
{
    public function create()
    {
        return view('/calendar.crear_cita', [
            //'usuario' => User::all(),
            'estados' => Cita::ESTADOS,
            'tipos' => Cita::TIPOS
        ]);
    }

    public function eventos() {
        $citas = Cita::all();

        $eventos = [];
        foreach ($citas as $cita) {

            if ($cita->estatus === 'cancelada') {
                $color = '#DA0909';
            } elseif ($cita->estatus === 'pendiente') {
                $color = '#EAE300';
            } elseif ($cita->estatus === 'confirmada') {
                $color = '#00CE1C';
            } else {
                $color = '#CCCCCC';
            }

            $eventos[] = [
                'id' => $cita->id,
                'title' => $cita->motivo,
                'start' => $cita->fecha->format('Y-m-d') . 'T' . $cita->hora->format('H:i:s'),
                'extendedProps' => [
                    'hora' => $cita->hora->format('h:i A'),
                    'color' => $color,
                    'fecha' => $cita->fecha->format('d/m/Y'),
                    'estatus' => $cita->estatus,
                    'tipo' => $cita->tipo,
                    'usuario' => $cita->usuario,
                ]
            ];
        }

        return response()->json($eventos);
    }

    public function pagos() {
        $pagos = Pagos::all();
        $turnos = Turnos::all();

        $eventos = [];
        foreach ($pagos as $pago) {

            if ($pago->estatus === 'Pendiente') {
                $color = '#EAE300';
            } elseif ($pago->estatus === 'Pagado') {
                $color = '#00CE1C';
            } else {
                $color = '#CCCCCC';
            }

            $eventos[] = [
                'id' => $pago->id_solicitud,
                'title' => $pago->descripcion,
                'start' => $pago->fecha->format('Y-m-d') . 'T' . $pago->hora->format('H:i:s'),
                'extendedProps' => [
                    'hora' => $pago->hora->format('h:i A'),
                    'color' => $color,
                    'fecha' => $pago->fecha->format('d/m/Y'),
                    'estatus' => $pago->estatus,
                    'monto' => $pago->monto,
                    'observaciones' => $pago->observaciones
                ]
            ];
        }

        return response()->json($eventos);
    }

    public function exportarExcel()
    {
        //return Excel::download(new CitasExport, 'citas.xlsx');
        return Excel::download(new CitasExport, 'pagos.xlsx');
    }

}
