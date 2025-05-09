<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\User;
use Illuminate\Http\Request;

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
            $eventos[] = [
                'id' => $cita->id,
                'title' => $cita->motivo . ' - ' . $cita->hora->format('H:i'), // Formato 24h
                'start' => $cita->fecha->format('Y-m-d') . 'T' . $cita->hora->format('H:i:s'), // ISO8601
                'color' => '#6A0F49', // Color personalizado
            ];
    }

    return response()->json($eventos);
}
}
