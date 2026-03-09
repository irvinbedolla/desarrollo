<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Motivos implements FromView
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

    /**
     * Define las categorías y el CASE SQL en un solo lugar.
     * $columna debe ser el nombre de la columna con la tabla (ej: 'catalogo_motivos.motivo')
     */
    private function getSqlCase($columna)
    {
        return "CASE 
            WHEN $columna IN ('Despido') THEN 'a. Despido injustificado'                    
            WHEN $columna IN ('Rescisión de la relación de trabajo') THEN 'b. Finiquito por rescisión laboral'
            WHEN $columna IN ('Derecho de preferencia', 'Derecho de antigüedad', 'Derecho de ascenso') THEN 'c. Derecho de preferencia (antigüedad o ascenso)'
            WHEN $columna IN ('Pago de prestaciones') THEN 'd. Pago de prestaciones pendientes'
            WHEN $columna IN ('Terminación voluntaria de la relación de trabajo') THEN 'e. Terminación voluntaria de la relación laboral'
            WHEN $columna IN ('Excepcion') THEN 'f. Supuestos de Excepción 685-Ter LFT'
            ELSE 'g. Otros'
        END";
    }

    /**
     * Asegura que todas las categorías existan con valor 0.
     */
    private function formatearResultados($datosQuery)
    {
        $mapa = collect([
            'a. Despido injustificado' => ['h' => 0, 'm' => 0, 'total' => 0],
            'b. Finiquito por rescisión laboral' => ['h' => 0, 'm' => 0, 'total' => 0],
            'c. Derecho de preferencia (antigüedad o ascenso)' => ['h' => 0, 'm' => 0, 'total' => 0],
            'd. Pago de prestaciones pendientes' => ['h' => 0, 'm' => 0, 'total' => 0],
            'e. Terminación voluntaria de la relación laboral' => ['h' => 0, 'm' => 0, 'total' => 0],
            'f. Supuestos de Excepción 685-Ter LFT' => ['h' => 0, 'm' => 0, 'total' => 0],
            'g. Otros' => ['h' => 0, 'm' => 0, 'total' => 0],
        ]);

        foreach ($datosQuery as $registro) {
            if ($mapa->has($registro->categoria)) {
                $mapa->put($registro->categoria, [
                    'h' => (int)$registro->total_hombres,
                    'm' => (int)$registro->total_mujeres,
                    'total' => (int)$registro->total_general,
                ]);
            }
        }
        return $mapa;
    }

    public function view(): View
    {
        $user = Auth::user();
        $sedeUsuario = $user->delegacion ?? '';
        $grupos = [
            'Morelia' => ['Morelia', 'Zitácuaro'],
            'Uruapan' => ['Uruapan', 'Lázaro Cárdenas'],
            'Zamora'  => ['Zamora', 'Sahuayo']
        ];

        // Definimos la lógica de filtros una vez
        $aplicarFiltros = function ($q, $tabla) use ($sedeUsuario, $grupos) {
            $q->whereBetween("$tabla.fecha", [$this->fecha_inicial, $this->fecha_final]);
            if ($this->sede !== "Todos") {
                if ($this->sede === "TodosDelegado") {
                    $delegaciones = $grupos[$sedeUsuario] ?? [$sedeUsuario];
                    $q->whereIn("$tabla.delegacion", $delegaciones);
                } else {
                    $q->where("$tabla.delegacion", $this->sede);
                }
            }
        };

        $sqlCaseM = $this->getSqlCase('catalogo_motivos.motivo');
        $sqlCaseT = $this->getSqlCase('turnos.motivo');

        // --- CONSULTAS ---

        // 1. Solicitudes
        $solicitudes = DB::table('catalogo_motivos')
            ->join('seer_motivos', 'catalogo_motivos.id', '=', 'seer_motivos.id_motivo')
            ->join('seer_general', 'seer_general.id', '=', 'seer_motivos.id_solicitud')
            ->join('seer_solicitante', 'seer_solicitante.id_solicitud', '=', 'seer_general.id')
            ->where(fn($q) => $aplicarFiltros($q, 'seer_general'))
            ->select(DB::raw("$sqlCaseM as categoria"), 
                     DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'H' THEN 1 ELSE 0 END) as total_hombres"),
                     DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'M' THEN 1 ELSE 0 END) as total_mujeres"),
                     DB::raw("COUNT(*) as total_general"))
            ->groupBy(DB::raw($sqlCaseM))->get();

        // 2. Solicitudes Confirmadas
        $solicitudesConfirmadas = DB::table('catalogo_motivos')
            ->join('seer_motivos', 'catalogo_motivos.id', '=', 'seer_motivos.id_motivo')
            ->join('seer_general', 'seer_general.id', '=', 'seer_motivos.id_solicitud')
            ->join('seer_solicitante', 'seer_solicitante.id_solicitud', '=', 'seer_general.id')
            ->whereNotIn('seer_general.estatus',['Pendiente','Prevencion'])
            ->where(fn($q) => $aplicarFiltros($q, 'seer_general'))
            ->select(DB::raw("$sqlCaseM as categoria"), 
                     DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'H' THEN 1 ELSE 0 END) as total_hombres"),
                     DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'M' THEN 1 ELSE 0 END) as total_mujeres"),
                     DB::raw("COUNT(*) as total_general"))
            ->groupBy(DB::raw($sqlCaseM))->get();

        // 3. Ratificaciones (Turnos)
        $ratificaciones = DB::table('turnos')
            ->where(fn($q) => $aplicarFiltros($q, 'turnos'))
            ->select(DB::raw("$sqlCaseT as categoria"), 
                     DB::raw("SUM(CASE WHEN sexo = 'H' THEN 1 ELSE 0 END) as total_hombres"),
                     DB::raw("SUM(CASE WHEN sexo = 'M' THEN 1 ELSE 0 END) as total_mujeres"),
                     DB::raw("COUNT(*) as total_general"))
            ->groupBy(DB::raw($sqlCaseT))->get();
        // 4. Ratificaciones (Turnos)
        $ratificacionesConcluidas = DB::table('turnos')
            ->whereIn('turnos.estatus',['Concluida','Concluida Pagos'])
            ->where(fn($q) => $aplicarFiltros($q, 'turnos'))
            ->select(DB::raw("$sqlCaseT as categoria"), 
                DB::raw("SUM(CASE WHEN sexo = 'H' THEN 1 ELSE 0 END) as total_hombres"),
                DB::raw("SUM(CASE WHEN sexo = 'M' THEN 1 ELSE 0 END) as total_mujeres"),
                DB::raw("COUNT(*) as total_general"))
            ->groupBy(DB::raw($sqlCaseT))->get();
        // 5. Convenios (Audiencias)
        $convenios = DB::table('catalogo_motivos')
            ->join('seer_motivos', 'catalogo_motivos.id', '=', 'seer_motivos.id_motivo')
            ->join('seer_general', 'seer_general.id', '=', 'seer_motivos.id_solicitud')
            ->join('seer_solicitante', 'seer_solicitante.id_solicitud', '=', 'seer_general.id')
            ->join('audiencias', 'audiencias.id_solicitud', '=', 'seer_general.id')
            ->whereIn('audiencias.estatus', ['Conciliacion'])
            ->where(fn($q) => $aplicarFiltros($q, 'seer_general'))
            ->select(DB::raw("$sqlCaseM as categoria"), 
                     DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'H' THEN 1 ELSE 0 END) as total_hombres"),
                     DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'M' THEN 1 ELSE 0 END) as total_mujeres"),
                     DB::raw("COUNT(*) as total_general"))
            ->groupBy(DB::raw($sqlCaseM))->get();
        // 6. Convenios (Audiencias)
        $archivadas = DB::table('catalogo_motivos')
            ->join('seer_motivos', 'catalogo_motivos.id', '=', 'seer_motivos.id_motivo')
            ->join('seer_general', 'seer_general.id', '=', 'seer_motivos.id_solicitud')
            ->join('seer_solicitante', 'seer_solicitante.id_solicitud', '=', 'seer_general.id')
            ->join('audiencias', 'audiencias.id_solicitud', '=', 'seer_general.id')
            ->where('audiencias.estatus', 'Archivada')
            ->where(fn($q) => $aplicarFiltros($q, 'seer_general'))
            ->select(DB::raw("$sqlCaseM as categoria"), 
                     DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'H' THEN 1 ELSE 0 END) as total_hombres"),
                     DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'M' THEN 1 ELSE 0 END) as total_mujeres"),
                     DB::raw("COUNT(*) as total_general"))
            ->groupBy(DB::raw($sqlCaseM))->get();
        // 7. programadas (Audiencias)
        $programadas = DB::table('catalogo_motivos')
            ->join('seer_motivos', 'catalogo_motivos.id', '=', 'seer_motivos.id_motivo')
            ->join('seer_general', 'seer_general.id', '=', 'seer_motivos.id_solicitud')
            ->join('seer_solicitante', 'seer_solicitante.id_solicitud', '=', 'seer_general.id')
            ->join('audiencias', 'audiencias.id_solicitud', '=', 'seer_general.id')
            ->whereNotIn('audiencias.estatus', ['Pendiente','Conciliacion','No conciliacion reagendada','No conciliacion'])
            ->where(fn($q) => $aplicarFiltros($q, 'seer_general'))
            ->select(DB::raw("$sqlCaseM as categoria"), 
                     DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'H' THEN 1 ELSE 0 END) as total_hombres"),
                     DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'M' THEN 1 ELSE 0 END) as total_mujeres"),
                     DB::raw("COUNT(*) as total_general"))
            ->groupBy(DB::raw($sqlCaseM))->get();
        // 8. celebradas (Audiencias)
        $celebradas = DB::table('catalogo_motivos')
            ->join('seer_motivos', 'catalogo_motivos.id', '=', 'seer_motivos.id_motivo')
            ->join('seer_general', 'seer_general.id', '=', 'seer_motivos.id_solicitud')
            ->join('seer_solicitante', 'seer_solicitante.id_solicitud', '=', 'seer_general.id')
            ->join('audiencias', 'audiencias.id_solicitud', '=', 'seer_general.id')
            ->whereIn('audiencias.estatus', ['Conciliacion','No conciliacion','No conciliacion reagendada','Reinstalacion'])
            ->where(fn($q) => $aplicarFiltros($q, 'seer_general'))
            ->select(DB::raw("$sqlCaseM as categoria"), 
                     DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'H' THEN 1 ELSE 0 END) as total_hombres"),
                     DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'M' THEN 1 ELSE 0 END) as total_mujeres"),
                     DB::raw("COUNT(*) as total_general"))
            ->groupBy(DB::raw($sqlCaseM))->get();
        // 9. celebradas (Audiencias)
        $noconciliacion = DB::table('catalogo_motivos')
            ->join('seer_motivos', 'catalogo_motivos.id', '=', 'seer_motivos.id_motivo')
            ->join('seer_general', 'seer_general.id', '=', 'seer_motivos.id_solicitud')
            ->join('seer_solicitante', 'seer_solicitante.id_solicitud', '=', 'seer_general.id')
            ->join('audiencias', 'audiencias.id_solicitud', '=', 'seer_general.id')
            ->whereIn('audiencias.estatus', ['No conciliacion'])
            ->where(fn($q) => $aplicarFiltros($q, 'seer_general'))
            ->select(DB::raw("$sqlCaseM as categoria"), 
                     DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'H' THEN 1 ELSE 0 END) as total_hombres"),
                     DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'M' THEN 1 ELSE 0 END) as total_mujeres"),
                     DB::raw("COUNT(*) as total_general"))
            ->groupBy(DB::raw($sqlCaseM))->get();

        return view('excel.motivos', [
            'solicitudes'               => $this->formatearResultados($solicitudes),
            'solicitudesConfirmadas'    => $this->formatearResultados($solicitudesConfirmadas),
            'ratificaciones'            => $this->formatearResultados($ratificaciones),
            'ratificacionesConcluidas'  => $this->formatearResultados($ratificacionesConcluidas),
            'convenios'                 => $this->formatearResultados($convenios),
            'archivadas'                => $this->formatearResultados($archivadas),
            'programadas'               => $this->formatearResultados($programadas),
            'celebradas'                => $this->formatearResultados($celebradas),
            'noconciliacion'            => $this->formatearResultados($noconciliacion),
        ]);
    }
}