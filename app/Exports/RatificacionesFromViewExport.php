<?php

namespace App\Exports;

use App\Models\Turnos;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RatificacionesFromViewExport implements FromView
{
    protected $fecha_inicial;
    protected $fecha_final;
    protected $sede;

    public function __construct(string $fecha_inicial, string $fecha_final, string $sede)
    {
        $this->fecha_inicial = $fecha_inicial;
        $this->fecha_final = $fecha_final;
        $this->sede = $sede;
    }

    public function view(): View
    {
        // Optimizamos la obtención del usuario
        $user = auth()->user();
        $sedeUsuario = $user->delegacion;
        
        $ratificaciones = Turnos::whereBetween('turnos.fecha', [$this->fecha_inicial, $this->fecha_final])
            ->join('users', 'users.id', '=', 'turnos.id_conciliador')
            ->join('users as user_usuario', 'user_usuario.id', '=', 'turnos.user_id')
            ->select('turnos.*', 'users.name as conciliador_name', 'user_usuario.name as auxiliar')
            
            // Condición dinámica para la sede
            ->when($this->sede !== "Todos", function ($query) use ($sedeUsuario) {
                if ($this->sede === "TodosDelegado") {
                    
                    // Definimos los grupos de delegaciones
                    $grupos = [
                        'Morelia' => ['Morelia', 'Zitácuaro'],
                        'Uruapan' => ['Uruapan', 'Lázaro Cárdenas'],
                        'Zamora'  => ['Zamora', 'Sahuayo']
                    ];

                    // Si la sede del usuario existe en nuestros grupos, filtramos por ese array
                    if (array_key_exists($sedeUsuario, $grupos)) {
                        return $q->whereIn('turnos.delegacion', $grupos[$sedeUsuario]);
                    }
                }
                
                // Si es cualquier otra sede individual
                return $query->where('turnos.delegacion', $this->sede);
            })
            
            ->orderBy('user_usuario.name')
            ->get();

        return view('excel.ratificaciones', [
            'Ratificacion' => $ratificaciones
        ]);
    }
}