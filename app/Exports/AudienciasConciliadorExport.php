<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AudienciasConciliadorExport implements WithMultipleSheets
{
    protected $fecha_inicial, $fecha_final, $sede;

    public function __construct($fecha_inicial, $fecha_final, $sede)
    {
        $this->fecha_inicial = $fecha_inicial;
        $this->fecha_final = $fecha_final;
        $this->sede = $sede;    
    }

    public function sheets(): array
    {
        $user = Auth::user();
        $sedeUsuario = $user->delegacion ?? '';
        
        // Mantenemos la lógica de grupos de tu reporte de Motivos
        $grupos = [
            'Morelia' => ['Morelia', 'Zitácuaro'],
            'Uruapan' => ['Uruapan', 'Lázaro Cárdenas'],
            'Zamora'  => ['Zamora', 'Sahuayo']
        ];
        $aplicarFiltros = function ($q) use ($sedeUsuario, $grupos) {
            // Filtramos por la fecha de creación de la solicitud (igual que en Motivos)
            $q->whereBetween("audiencias.fecha", [$this->fecha_inicial, $this->fecha_final]);
            
            // Excluimos Pendientes y Prevenciones para que no inflen el número
            //$q->whereNotIn('audiencias.estatus', ['Pendiente', 'Prevencion']);

            if ($this->sede !== "Todos") {
                if ($this->sede === "TodosDelegado") {
                    $delegaciones = $grupos[$sedeUsuario] ?? [$sedeUsuario];
                    $q->whereIn("audiencias.delegacion", $delegaciones);
                } else {
                    $q->where("audiencias.delegacion", $this->sede);
                }
            }
        };

        $detalle = DB::table('audiencias')
            ->join('seer_general', 'seer_general.id', '=', 'audiencias.id_solicitud')
            ->join('seer_solicitante', 'seer_general.id', '=', 'seer_solicitante.id_solicitud')
            ->join('users as conciliador', 'conciliador.id', '=', 'seer_general.conciliador_id')
            ->where(fn($q) => $aplicarFiltros($q))
            /*
            ->when($this->conciliador !== "Todos", function ($q) {
                return $q->where('seer_general.conciliador_id', $this->conciliador);
            })*/
            ->select(
                'seer_general.NUE',
                'audiencias.fecha',
                'audiencias.hora',
                'seer_solicitante.nombre as nombre_solicitante',
                'conciliador.name as nombre_conciliador'
                ) 
            //->distinct() 
            ->orderBy('seer_general.consecutivo', 'desc')
            ->get()
            ->map(fn($item) => (array) $item)
            ->toArray();
dd("llego");
         return view('excel.audienciasConciliador', ['detalle' => $detalle]);
    }
}