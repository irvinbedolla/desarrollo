<?php

namespace App\Exports;

use App\Models\Turnos;
use App\Models\Pagos;
use App\Models\SeerPerGeneral;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class ReporteMexicoRati implements FromView
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
        $user = auth()->user();
        $sedeUsuario = $user->delegacion ?? '';

        $subconsultaMotivos = DB::table('seer_motivos')
        ->join('catalogo_motivos', 'catalogo_motivos.id', '=', 'seer_motivos.id_motivo')
        ->whereColumn('seer_motivos.id_solicitud', 'seer_general.id')
        ->select(DB::raw('COALESCE(GROUP_CONCAT(catalogo_motivos.motivo SEPARATOR ", "), "N/A")'));

        $subconsultaPagosTurnos = Pagos::select(DB::raw('SUM(monto)'))
            ->whereColumn('pago_solicitud.id_solicitud', 'turnos.id')
            ->where('pago_solicitud.tipo_pago', 'Ratificacion');

        $subconsultaPagosSeer = Pagos::select(DB::raw('SUM(monto)'))
            ->whereColumn('pago_solicitud.id_solicitud', 'seer_general.id')
            ->whereIn('pago_solicitud.tipo_pago', ['Audiencia','Conciliador']); 

        // --- CONSULTA 1: TURNOS ---
        $reportes = Turnos::whereBetween('turnos.fecha', [$this->fecha_inicial, $this->fecha_final])
            ->leftJoin('users', 'users.id', '=', 'turnos.user_id')
            ->leftJoin('estados', 'estados.id', '=', 'turnos.estado_rat')
            ->leftJoin('municipios', 'municipios.id', '=', 'turnos.municipio_rat')
            ->leftJoin('abogados', 'abogados.idAbogado', '=', 'turnos.idAbogado')
            ->leftJoin('municipios as mun_abogado', 'mun_abogado.id', '=', 'abogados.municipio_patronal')
            ->when($this->sede !== "Todos", function ($q) use ($sedeUsuario) {
                return $this->aplicarFiltroSede($q, 'turnos', $sedeUsuario);
            })
            ->select(
                'turnos.NUE',
                DB::raw('MONTH(turnos.fecha) as mes'),
                DB::raw('YEAR(turnos.fecha) as año'),
                'estados.nombre as estado',
                'municipios.nombre as municipio',
                'mun_abogado.nombre as municipio_abogado',
                'abogados.giroComercial',
                'abogados.nombres_patronal',
                'abogados.primer_apellido_patronal',
                'abogados.segundo_apellido_patronal',
                'turnos.motivo',
                'turnos.user_id',
                'turnos.estatus',
                'turnos.id',
                'users.sexo'
            )
            ->selectSub($subconsultaPagosTurnos, 'total')
            ->get();

        // --- CONSULTA 2: SEER GENERAL ---
        // Corregimos los joins para que apunten a seer_general, no a turnos
        $reportesSolicitudes = SeerPerGeneral::whereBetween('seer_general.fecha', [$this->fecha_inicial, $this->fecha_final])
            ->join('seer_citados','seer_citados.id_solicitud','seer_general.id')
            ->join('seer_solicitante','seer_solicitante.id_solicitud','seer_general.id')
            ->leftJoin('users', 'users.id', '=', 'seer_general.user_id')
            ->leftJoin('estados', 'estados.id', '=', 'seer_solicitante.estado')
            ->leftJoin('municipios', 'municipios.id', '=', 'seer_solicitante.municipio_domicilio')
            ->leftJoin('abogados', 'abogados.idAbogado', '=', 'seer_citados.id_abogado') 
            ->leftJoin('municipios as mun_abogado', 'mun_abogado.id', '=', 'abogados.municipio_patronal')
            ->when($this->sede !== "Todos", function ($q) use ($sedeUsuario) {
                return $this->aplicarFiltroSede($q, 'seer_general', $sedeUsuario);
            })
            ->select(
                'seer_general.NUE',
                DB::raw('MONTH(seer_general.fecha) as mes'),
                DB::raw('YEAR(seer_general.fecha) as año'),
                'estados.nombre as estado',
                'municipios.nombre as municipio',
                'mun_abogado.nombre as municipio_abogado',
                'abogados.giroComercial',
                'abogados.nombres_patronal',
                'abogados.primer_apellido_patronal',
                'abogados.segundo_apellido_patronal',
                'seer_general.user_id',
                'seer_general.estatus',
                'seer_general.id',
                'users.sexo'
            )
            // Agregamos la cadena de motivos y el total de pagos como subconsultas
            ->selectSub($subconsultaMotivos, 'motivo') 
            ->selectSub($subconsultaPagosSeer, 'total') 
            ->get();

        // Combinar ambas colecciones
        $todoJunto = $reportes->concat($reportesSolicitudes)->map(function($item) {
            $item->total = $item->total ?? 0;
            return $item;
        });

        return view('excel.reporte-mexico', ['reportes' => $todoJunto]);
    }

    /**
     * Función auxiliar para no repetir la lógica de la sede
     */
    private function aplicarFiltroSede($query, $tabla, $sedeUsuario) {
        if ($this->sede === "TodosDelegado") {
            $grupos = [
                'Morelia' => ['Morelia', 'Zitácuaro'],
                'Uruapan' => ['Uruapan', 'Lázaro Cárdenas'],
                'Zamora'  => ['Zamora', 'Sahuayo']
            ];
            if (array_key_exists($sedeUsuario, $grupos)) {
                return $query->whereIn("$tabla.delegacion", $grupos[$sedeUsuario]);
            }
        }
        return $query->where("$tabla.delegacion", $this->sede);
    }
}