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
            WHEN $columna IN ('Excepcion', 'Excepción') THEN 'f. Supuestos de Excepción 685-Ter LFT'
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

        // 1. OBTENER EL MOTIVO PRINCIPAL (UNICO) POR SOLICITUD
        $motivoPrincipalSub = DB::table('seer_motivos')
            ->select('id_solicitud', DB::raw('MIN(id_motivo) as id_motivo_principal'))
            ->groupBy('id_solicitud');

        // 2. OBTENER EL SOLICITANTE PRINCIPAL (UNICO) POR SOLICITUD
        // Esto evita que si hay 2 solicitantes en una solicitud, se cuente doble.
        $solicitanteUnicoSub = DB::table('seer_solicitante')
            ->select('id_solicitud', DB::raw('MIN(sexo) as sexo_principal')) // MIN('H','M') tomará uno consistentemente
            ->groupBy('id_solicitud');

        // 3. CONSULTA BASE (Para reutilizar filtros)
        $queryBase = DB::table('seer_general')
            ->joinSub($motivoPrincipalSub, 'principal', function ($join) {
                $join->on('seer_general.id', '=', 'principal.id_solicitud');
            })
            ->joinSub($solicitanteUnicoSub, 'solicitante', function ($join) {
                $join->on('seer_general.id', '=', 'solicitante.id_solicitud');
            })
            ->join('catalogo_motivos', 'catalogo_motivos.id', '=', 'principal.id_motivo_principal')
            ->where(function($query) {
                $query->where('seer_general.incidencia', 0)
                      ->orWhereNull('seer_general.incidencia');
            })
            ->whereBetween('seer_general.fecha', [$this->fecha_inicial, $this->fecha_final])
            ->when($this->sede !== "Todos", function ($q) use ($sedeUsuario, $grupos) {
                if ($this->sede === "TodosDelegado") {
                    $delegaciones = $grupos[$sedeUsuario] ?? [$sedeUsuario];
                    return $q->whereIn('seer_general.delegacion', $delegaciones);
                }
                return $q->where("seer_general.delegacion", $this->sede);
            });

        // 4. EJECUTAR CONTEOS DE SOLICITUDES
        $solicitudes = (clone $queryBase)
            ->select(
                DB::raw($this->getSqlCase('catalogo_motivos.motivo') . " as categoria"),
                DB::raw("COUNT(seer_general.id) as total_general"),
                DB::raw("SUM(CASE WHEN solicitante.sexo_principal = 'H' THEN 1 ELSE 0 END) as total_hombres"),
                DB::raw("SUM(CASE WHEN solicitante.sexo_principal = 'M' THEN 1 ELSE 0 END) as total_mujeres")
            )
            ->groupBy(DB::raw($this->getSqlCase('catalogo_motivos.motivo')))
            ->get();


        return view('excel.motivos', [
            'solicitudes'               => $this->formatearResultados($solicitudes),
        ]);
    }
}