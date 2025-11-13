<?php

namespace App\Exports;

use App\Models\Turnos;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use App\Models\Pagos; 

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
        //Pagos de ratificacion(Turnos)
        if($this->sede === "Todos"){
            $reportes = Turnos::whereBetween('turnos.fecha',[$this->fecha_inicial,$this->fecha_final])
                ->join('users','users.id','turnos.user_id')
                ->leftjoin('estados','estados.id','turnos.estado_rat')
                ->leftjoin('municipios','municipios.id','turnos.municipio_rat')
                ->join('abogados','abogados.idAbogado','turnos.idAbogado')
                ->leftjoin('municipios as mun_abogado','mun_abogado.id','abogados.municipio_patronal')
                ->select('turnos.NUE',DB::raw('MONTH(turnos.fecha) as mes'),DB::raw('YEAR(turnos.fecha) as año'),'estados.nombre as estado','municipios.nombre as municipio','mun_abogado.nombre as municipio_abogado',
                'abogados.giroComercial','abogados.nombres_patronal','abogados.primer_apellido_patronal','abogados.segundo_apellido_patronal','turnos.motivo','turnos.user_id','turnos.estatus','turnos.id','users.sexo')
                ->get();
                foreach ($reportes as $solicitud) {
                    $totalSuma = Pagos::where('pago_solicitud.tipo_pago',"Ratificacion")
                    ->where('pago_solicitud.id_solicitud',$solicitud["id"])
                    ->select(DB::raw('sum(pago_solicitud.monto) as monto'))
                    ->get(); 
                    $solicitud->total = count($totalSuma) != 0 ? $totalSuma[0]->monto : '0';
            }
        }else{
           $reportes = Turnos::whereBetween('turnos.fecha',[$this->fecha_inicial,$this->fecha_final])
                ->where('turnos.delegacion',$this->sede)
                ->join('users','users.id','turnos.user_id')
                ->leftjoin('estados','estados.id','turnos.estado_rat')
                ->leftjoin('municipios','municipios.id','turnos.municipio_rat')
                ->join('abogados','abogados.idAbogado','turnos.idAbogado')
                ->leftjoin('municipios as mun_abogado','mun_abogado.id','abogados.municipio_patronal')
                ->select('turnos.NUE',DB::raw('MONTH(turnos.fecha) as mes'),DB::raw('YEAR(turnos.fecha) as año'),'estados.nombre as estado','municipios.nombre as municipio','mun_abogado.nombre as municipio_abogado',
                'abogados.giroComercial','abogados.nombres_patronal','abogados.primer_apellido_patronal','abogados.segundo_apellido_patronal','turnos.motivo','turnos.user_id','turnos.estatus','turnos.id','users.sexo')
                ->get();
                foreach ($reportes as $solicitud) {
                    $totalSuma = Pagos::where('pago_solicitud.tipo_pago',"Ratificacion")
                    ->where('pago_solicitud.id_solicitud',$solicitud["id"])
                    ->select(DB::raw('sum(pago_solicitud.monto) as monto'))
                    ->get(); 
                    $solicitud->total = count($totalSuma) != 0 ? $totalSuma[0]->monto : '0';
                }
        }
        return view('excel.reporte-mexico', ['reportes' => $reportes]);
    }
}