<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Pagos;
use App\Models\Recepcion;
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

    /*public function eventos() {
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
    }*/

    public function citas() {
        $recepciones = Recepcion::all();

        $tipo = 8;

        $eventos = [];
        foreach ($recepciones as $cita  ) {

            if ($cita->estatus === 'no atendida') {
                $color = '#DA0909';
            } elseif ($cita->estatus === 'pendiente') {
                $color = '#EAE300';
            } elseif ($cita->estatus === 'atendida') {
                $color = '#00CE1C';
            } else {
                $color = '#CCCCCC';
            }

            $eventos[] = [
                'id' => $cita->id,
                'title' => $cita->solicitante,
                'start' => $cita->fecha->format('Y-m-d') . 'T' . $cita->hora->format('H:i:s'),
                'extendedProps' => [
                    'hora' => $cita->hora->format('h:i A'),
                    'color' => $color,
                    'fecha' => $cita->fecha->format('d/m/Y'),
                    'estatus' => $cita->estatus,
                    'tipo' => $tipo,
                ]
            ];
        }

        return response()->json($eventos);

    }

    public function pagos() {
        $pagos = Pagos::with('turno')->get();

        $eventos = [];
        foreach ($pagos as $pago) {
            $turno = $pago->turno;
            $empresa_turno = $turno ? $turno->empresa : null;
            $nombre_turno = $turno ? $turno->trabajador : null;
            $primer_apellido_turno = $turno ? $turno->primero_trabajador : null;
            $segundo_apellido_turno = $turno ? $turno->segundo_trabajador : null;

            $tipo = 6;


            if ($pago->estatus === 'Pendiente') {
                $color = '#EAE300';
            } elseif ($pago->estatus === 'Pagado') {
                $color = '#00CE1C';
            } elseif ($pago->estatus === 'Incomparecencia trabajador') {
                $color = '#FF2C2C';
            } else {
                $color = '#CCCCCC';
            }

            $eventos[] = [
                'id' => $pago->id,
                'title' => $pago->descripcion,
                'start' => $pago->fecha->format('Y-m-d') . 'T' . $pago->hora->format('H:i:s'),
                'extendedProps' => [
                    'descripcion' => $pago->descripcion,
                    'hora' => $pago->hora->format('h:i A'),
                    'color' => $color,
                    'fecha' => $pago->fecha->format('d/m/Y'),
                    'empresa' => $pago->empresa_representante,
                    'trabajador' => $pago->nombre_trabajador,
                    'estatus' => $pago->estatus,
                    'monto' => $pago->monto,
                    'observaciones' => $pago->observaciones,
                    'tipo' => $tipo
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
