<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // IMPORTANTE: Agregar esto

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

    public function view(): View
    {
        $user = Auth::user();
        $sedeUsuario = $user->delegacion ?? '';

        $grupos = [
            'Morelia' => ['Morelia', 'Zitácuaro'],
            'Uruapan' => ['Uruapan', 'Lázaro Cárdenas'],
            'Zamora'  => ['Zamora', 'Sahuayo']
        ];

        $totalesPorMotivoYSexo = DB::table('catalogo_motivos')
        // Partimos de motivos para asegurar que aparezcan incluso los que tengan 0 si es necesario, 
        // o simplemente desde seer_motivos para los existentes.
        ->join('seer_motivos', 'catalogo_motivos.id', '=', 'seer_motivos.id_motivo')
        ->join('seer_general', 'seer_general.id', '=', 'seer_motivos.id_solicitud')
        ->join('seer_solicitante', 'seer_solicitante.id_solicitud', '=', 'seer_general.id')
        
        // Filtros de fecha y sede (mantenemos tu lógica original)
        ->whereBetween('seer_general.fecha', [$this->fecha_inicial, $this->fecha_final])
        //->whereIn('catalogo_motivos.motivo',['Despido','Pago de prestaciones','Rescisión de la relación de trabajo','Derecho de preferencia','Derecho de antigüedad','Derecho de ascenso','Terminación voluntaria de la relación de trabajo'])
        ->when($this->sede !== "Todos", function ($q) use ($sedeUsuario, $grupos) {
            if ($this->sede === "TodosDelegado") {
                $delegaciones = $grupos[$sedeUsuario] ?? [$sedeUsuario];
                return $q->whereIn('seer_general.delegacion', $delegaciones);
            }
            return $q->where("seer_general.delegacion", $this->sede);
        })
        
        ->select(
            'catalogo_motivos.motivo',
            // Conteo para Hombres
            DB::raw("COUNT(CASE WHEN seer_solicitante.sexo = 'H' THEN 1 END) as total_hombres"),
            // Conteo para Mujeres
            DB::raw("COUNT(CASE WHEN seer_solicitante.sexo = 'M' THEN 1 END) as total_mujeres"),
            // Total general por ese motivo
            DB::raw("COUNT(*) as total_general")
        )
        ->groupBy('catalogo_motivos.motivo')
        ->orderBy('total_general', 'desc')
        ->get();

        dd($totalesPorMotivoYSexo);

        return view('excel.solicitudes', [
            'Solicitudes' => $detalleSolicitantes, // Corregido el nombre de la variable
        ]);
    }
}