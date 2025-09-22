<?php

namespace App\Exports;

use App\Models\Pagos;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsFromViewExport implements FromView
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
        if($this->sede === "Todos"){
            $pagosRatificacion = Pagos::whereBetween('pago_solicitud.fecha',[$this->fecha_inicial,$this->fecha_final])
            ->join('turnos','turnos.id','pago_solicitud.id_solicitud')
            ->join('users','users.id','turnos.id_conciliador')
            ->join('abogados','abogados.idAbogado','turnos.idAbogado')
            ->where('pago_solicitud.tipo_pago',"Ratificacion")
            ->select('pago_solicitud.id_solicitud','pago_solicitud.fecha','pago_solicitud.hora','pago_solicitud.monto','pago_solicitud.descripcion'
             ,'pago_solicitud.estatus','pago_solicitud.tipo_pago','turnos.delegacion','turnos.NUE',
            'turnos.empresa','turnos.primero_empresa','turnos.segundo_empresa','turnos.trabajador','turnos.primero_trabajador','turnos.segundo_trabajador'
            ,'users.name','abogados.giroComercial')
            ->orderby('users.name')
            ->get();
        }else{
            $pagosRatificacion = Pagos::whereBetween('pago_solicitud.fecha',[$this->fecha_inicial,$this->fecha_final])
            ->where('pago_solicitud.delegacion',$this->sede)
            ->join('turnos','turnos.id','pago_solicitud.id_solicitud')
            ->join('users','users.id','turnos.id_conciliador')
            ->where('pago_solicitud.tipo_pago',"Ratificacion")
            ->select('pago_solicitud.id_solicitud','pago_solicitud.fecha','pago_solicitud.hora','pago_solicitud.monto','pago_solicitud.descripcion'
            ,'pago_solicitud.estatus','pago_solicitud.tipo_pago','pago_solicitud.delegacion','turnos.NUE',
            'turnos.empresa','turnos.primero_empresa','turnos.segundo_empresa','turnos.trabajador','turnos.primero_trabajador','turnos.segundo_trabajador'
            ,'users.name')
            ->orderby('users.name')
            ->get(); 
        }
        //Pagos de audiencias
        if($this->sede === "Todos"){
            $pagosAudiencias = Pagos::whereBetween('fecha',[$this->fecha_inicial,$this->fecha_final])
            ->join('users','users.id','pago_solicitud.id_conciliador')
            ->where('pago_solicitud.tipo_pago',"Audiencia")
            ->get();
        }else{
            $pagosAudiencias = Pagos::whereBetween('fecha',[$this->fecha_inicial,$this->fecha_final])
            ->where('pago_solicitud.delegacion',$this->sede)
            ->join('users','users.id','pago_solicitud.id_conciliador')
            ->where('pago_solicitud.tipo_pago',"Audiencia")
            ->get(); 
        }
        return view('excel.cumplimientos', ['pagosRatificacion' => $pagosRatificacion,'pagosAudiencias' => $pagosAudiencias]);
    }
}