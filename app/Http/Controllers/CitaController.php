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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'motive' => 'required|string|max:500',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'usuario' => 'required|exists:users,id',
            'estatus' => 'required|in:' . implode(',', Cita::ESTADOS),
            'tipo' => 'required|in:' . implode(',', Cita::TIPOS)
        ]);

        Cita::create($validated);

        return redirect()->route('citas.create')
            ->with('success', 'Cita creada exitosamente!');
    }
}
