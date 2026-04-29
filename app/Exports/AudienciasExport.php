<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AudienciasExport implements WithMultipleSheets
{
    protected $fecha_inicial, $fecha_final, $sede, $conciliador;

    public function __construct($fecha_inicial, $fecha_final, $sede, $conciliador)
    {
        $this->fecha_inicial = $fecha_inicial;
        $this->fecha_final = $fecha_final;
        $this->sede = $sede;
        $this->conciliador = $conciliador;
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

        //Número de audiencias por expediente (seer_general.id), incluyendo cuántas de ellas siguen en estatus 'Pendiente'. Solo consideraremos "finalizados" aquellos expedientes cuyo conteo de pendientes sea 0.
        $audienciasPorExpediente = DB::table('audiencias')
            ->select(
                'id_solicitud',
                DB::raw('COUNT(*) as total_audiencias'),
                DB::raw("SUM(CASE WHEN estatus = 'Pendiente' THEN 1 ELSE 0 END) as pendientes")
            )
            ->where(function ($q) use ($aplicarFiltros) {
                $aplicarFiltros($q);
            })
            ->groupBy('id_solicitud');

        // 1. Lógica de Estadísticas por Conciliador
        $estadisticas = DB::table('users')
            ->join('seer_general', 'users.id', '=', 'seer_general.conciliador_id')
            ->join('audiencias', 'seer_general.id', '=', 'audiencias.id_solicitud')
            //Unimos el conteo de audiencias por expediente para poder clasificar en 1, 2 o 3 audiencias
            ->joinSub($audienciasPorExpediente, 'a_count', function ($join) {
                $join->on('a_count.id_solicitud', '=', 'seer_general.id');
            })
            //->join('seer_motivos', 'seer_general.id', '=', 'seer_motivos.id_solicitud')
            //->join('catalogo_motivos', 'catalogo_motivos.id', '=', 'seer_motivos.id_motivo')
            //->join('seer_solicitante', 'seer_general.id', '=', 'seer_solicitante.id_solicitud')
            
            ->where(fn($q) => $aplicarFiltros($q))
            ->when($this->conciliador !== "Todos", function ($q) {
                return $q->where('seer_general.conciliador_id', $this->conciliador);
            })
            ->select(
                'users.name as conciliador_nombre',
                // QUITAMOS EL DISTINCT para que cuente cada combinación de Motivo/Solicitante
                //DB::raw('COUNT(*) as total_conteo'),
                DB::raw("SUM(CASE WHEN audiencias.estatus IN ('Conciliacion','No conciliacion','No conciliacion reagendada','Reinstalacion', 'Pendiente') THEN 1 
                            WHEN audiencias.estatus NOT IN ('Pendiente','Conciliacion','No conciliacion reagendada','No conciliacion') THEN 1 ELSE 0 END) as total_conteo"),
                //DB::raw("SUM(CASE WHEN audiencias.estatus NOT IN ('Conciliacion','No conciliacion reagendada','No conciliacion') THEN 1 ELSE 0 END) as total_prog"),
                DB::raw("COUNT(DISTINCT CASE WHEN audiencias.estatus IN ('Pendiente','Conciliacion','No conciliacion','Reagendada','Archivada','No conciliacion reagendada','Incompetencia','Reinstalacion','Desistimiento','Archivada en Audiencia') THEN seer_general.id END) as total_prog"),
                //DB::raw("SUM(CASE WHEN audiencias.estatus IN ('Conciliacion','No conciliacion','No conciliacion reagendada','Reinstalacion') THEN 1 ELSE 0 END) as total_celeb"),
                //DB::raw("COUNT(DISTINCT CASE WHEN audiencias.estatus IN ('Conciliacion','Reinstalacion','No conciliacion reagendada') THEN seer_general.id END) as total_celeb"),
                DB::raw("COUNT(DISTINCT CASE WHEN audiencias.estatus IN ('Conciliacion','Reinstalacion','No conciliacion reagendada') OR (audiencias.estatus = 'No conciliacion' AND (SELECT resolicion_primera FROM seer_conciliadores WHERE id_solicitud = seer_general.id ORDER BY id DESC LIMIT 1) IS NOT NULL) THEN seer_general.id END) as total_celeb"),
                
                DB::raw("COUNT(DISTINCT CASE WHEN a_count.total_audiencias = 1 AND (
                    (SELECT a_last.estatus FROM audiencias a_last WHERE a_last.id_solicitud = seer_general.id ORDER BY a_last.id DESC LIMIT 1) IN ('Conciliacion','Reinstalacion','No conciliacion reagendada')
                    OR (
                        (SELECT a_last.estatus FROM audiencias a_last WHERE a_last.id_solicitud = seer_general.id ORDER BY a_last.id DESC LIMIT 1) = 'No conciliacion'
                        AND (SELECT sc.resolicion_primera FROM seer_conciliadores sc WHERE sc.id_solicitud = seer_general.id ORDER BY sc.id DESC LIMIT 1) IS NOT NULL
                    )
                ) THEN seer_general.id END) as final_1"),
                DB::raw("COUNT(DISTINCT CASE WHEN a_count.total_audiencias = 2 AND (
                    (SELECT a_last.estatus FROM audiencias a_last WHERE a_last.id_solicitud = seer_general.id ORDER BY a_last.id DESC LIMIT 1) IN ('Conciliacion','Reinstalacion','No conciliacion reagendada')
                    OR (
                        (SELECT a_last.estatus FROM audiencias a_last WHERE a_last.id_solicitud = seer_general.id ORDER BY a_last.id DESC LIMIT 1) = 'No conciliacion'
                        AND (SELECT sc.resolicion_primera FROM seer_conciliadores sc WHERE sc.id_solicitud = seer_general.id ORDER BY sc.id DESC LIMIT 1) IS NOT NULL
                    )
                ) THEN seer_general.id END) as final_2"),
                DB::raw("COUNT(DISTINCT CASE WHEN a_count.total_audiencias >= 3 AND (
                    (SELECT a_last.estatus FROM audiencias a_last WHERE a_last.id_solicitud = seer_general.id ORDER BY a_last.id DESC LIMIT 1) IN ('Conciliacion','Reinstalacion','No conciliacion reagendada')
                    OR (
                        (SELECT a_last.estatus FROM audiencias a_last WHERE a_last.id_solicitud = seer_general.id ORDER BY a_last.id DESC LIMIT 1) = 'No conciliacion'
                        AND (SELECT sc.resolicion_primera FROM seer_conciliadores sc WHERE sc.id_solicitud = seer_general.id ORDER BY sc.id DESC LIMIT 1) IS NOT NULL
                    )
                ) THEN seer_general.id END) as final_3")
            )
            ->groupBy('users.id', 'users.name')
            ->get();

            $resultados = $estadisticas->map(function ($item) {
            return [
                'nombre'      => $item->conciliador_nombre,
                'total'       => (int)$item->total_conteo,
                'programadas' => (int)$item->total_prog,
                'celebradas'  => (int)$item->total_celeb,
                'final_1'     => (int)$item->final_1,
                'final_2'     => (int)$item->final_2,
                'final_3'     => (int)$item->final_3,
            ];
        });

        // CALCULAMOS LOS TOTALES GENERALES
        $granTotalConteo = $resultados->sum('total');
        $granTotalProg   = $resultados->sum('programadas');
        $granTotalCeleb  = $resultados->sum('celebradas');
        $granTotalFinal1 = $resultados->sum('final_1');
        $granTotalFinal2 = $resultados->sum('final_2');
        $granTotalFinal3 = $resultados->sum('final_3');

        // Convertimos a array y añadimos la fila final de TOTALES
        $estadisticasFinal = $resultados->toArray();
        $estadisticasFinal[] = [
            'nombre'      => 'TOTAL GENERAL',
            'total'       => $granTotalConteo,
            'programadas' => $granTotalProg,
            'celebradas'  => $granTotalCeleb,
            'final_1'     => $granTotalFinal1,
            'final_2'     => $granTotalFinal2,
            'final_3'     => $granTotalFinal3,
        ];

        // 2. Lógica de Detalle
        $detalle = DB::table('audiencias')
            ->join('seer_general', 'seer_general.id', '=', 'audiencias.id_solicitud')
            ->join('seer_solicitante', 'seer_general.id', '=', 'seer_solicitante.id_solicitud')
            ->join('users as conciliador', 'conciliador.id', '=', 'seer_general.conciliador_id')
            ->where(fn($q) => $aplicarFiltros($q))
            ->when($this->conciliador !== "Todos", function ($q) {
                return $q->where('seer_general.conciliador_id', $this->conciliador);
            })
            ->select(
                'seer_general.NUE',
                'audiencias.fecha',
                'audiencias.hora',
                'seer_solicitante.nombre as nombre_solicitante',
                'conciliador.name as nombre_conciliador',
                'seer_general.delegacion',
                DB::raw("CASE 
                    WHEN audiencias.estatus = 'No conciliacion'
                         AND (SELECT sc.resolicion_primera
                              FROM seer_conciliadores sc
                              WHERE sc.id_solicitud = seer_general.id
                              ORDER BY sc.id DESC
                              LIMIT 1) IS NULL
                    THEN CONCAT(audiencias.estatus, ' (Incomparecencia)')
                    ELSE audiencias.estatus
                END as estatus")
            )
            //->distinct() 
            ->orderBy('seer_general.consecutivo', 'desc')
            ->get()
            ->map(fn($item) => (array) $item)
            ->toArray();

        return [
            new AudienciasTotalesSheet($estadisticasFinal),
            new AudienciasDetalleSheet($detalle),
        ];
    }
}