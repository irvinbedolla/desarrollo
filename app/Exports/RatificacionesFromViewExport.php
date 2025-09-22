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
        //Pagos de ratificacion(Turnos)
        if($this->sede === "Todos"){
            $Ratificacion = Turnos::whereBetween('turnos.fecha',[$this->fecha_inicial,$this->fecha_final])
            ->join('users','users.id','turnos.id_conciliador')
            ->join('users as user_usuario','user_usuario.id','turnos.user_id')
            ->select('turnos.*','users.name','user_usuario.name as auxiliar')
            ->orderby('user_usuario.name')
            ->get();
        }else{
            $Ratificacion = Turnos::whereBetween('fecha',[$this->fecha_inicial,$this->fecha_final])
            ->where('turnos.delegacion',$this->sede)
            ->join('users','users.id','turnos.id_conciliador')
            ->join('users as user_usuario','user_usuario.id','turnos.user_id')
            ->select('turnos.*','users.name','user_usuario.name as auxiliar')
            ->orderby('user_usuario.name')
            ->get();
        }
        return view('excel.ratificaciones', ['Ratificacion' => $Ratificacion]);
    }
}