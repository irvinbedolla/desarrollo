<?php

namespace App\Exports;

use App\Models\SeerPerGeneral;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NotificacionesExport implements FromView
{
    protected $fecha_inicial;
    protected $fecha_final;
    protected $sede;
    protected $auxiliar;
    protected $notificador;

    public function __construct(string $fecha_inicial, string $fecha_final, string $sede, string $auxiliar, string $notificador)
    {
        $this->fecha_inicial = $fecha_inicial;
        $this->fecha_final = $fecha_final;
        $this->sede = $sede;
        $this->auxiliar = $auxiliar;
        $this->notificador = $notificador;
    }

    public function view(): View
    {
        // Optimizamos la obtención del usuario
        $user = auth()->user();
        $sedeUsuario = $user->delegacion;

        $notificaciones = SeerPerGeneral::whereBetween('seer_general.fecha', [$this->fecha_inicial, $this->fecha_final])
            ->join('catalogo_rama', 'catalogo_rama.id', '=', 'seer_general.id_rama')
            ->join('seer_citados', 'seer_general.id', '=', 'seer_citados.id_solicitud')
            ->join('seer_solicitante', 'seer_general.id', '=', 'seer_solicitante.id_solicitud')
            ->join('users as auxiliar', 'auxiliar.id', '=', 'seer_general.user_id')
            ->leftJoin('users as notificador', 'notificador.id', '=', 'seer_citados.id_notificador')
            
            // --- Filtro de Sede (Incluyendo TodosDelegado) ---
            ->when($this->sede !== "Todos", function ($q) use ($sedeUsuario) {
                if ($this->sede === "TodosDelegado") {
                    
                    // Definimos los grupos de delegaciones
                    $grupos = [
                        'Morelia' => ['Morelia', 'Zitácuaro'],
                        'Uruapan' => ['Uruapan', 'Lázaro Cárdenas'],
                        'Zamora'  => ['Zamora', 'Sahuayo']
                    ];

                    // Si la sede del usuario existe en nuestros grupos, filtramos por ese array
                    if (array_key_exists($sedeUsuario, $grupos)) {
                        return $q->whereIn('seer_general.delegacion', $grupos[$sedeUsuario]);
                    }
                }
                return $q->where('seer_general.delegacion', $this->sede);
            })

            // --- Filtro de Auxiliar ---
            ->when($this->auxiliar !== "Todos", function ($q) {
                return $q->where('seer_general.user_id', $this->auxiliar);
            })

            // --- Filtro de Notificador ---
            ->when($this->notificador !== "Todos", function ($q) {
                return $q->where('seer_citados.id_notificador', $this->notificador);
            })

            ->select(
                'seer_general.id',
                'seer_general.NUE',
                'seer_solicitante.nombre as nombre_solicitante',
                'seer_general.fecha',
                'seer_citados.nombre',
                'seer_citados.primer_apellido',
                'seer_citados.segundo_apellido',
                'seer_citados.colonia',
                'seer_citados.calle',
                'seer_citados.n_ext',
                'seer_citados.n_int',
                'seer_citados.estatus',
                'seer_general.actividad',
                'catalogo_rama.rama_industrial',
                'seer_general.delegacion',
                'notificador.name as notificador',
                'auxiliar.name as auxiliar'
            )
            ->get();

        return view('excel.notificaciones', ['notificaciones' => $notificaciones]);
    }
}