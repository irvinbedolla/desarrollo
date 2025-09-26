<?php

namespace App\Exports;

use App\Models\Pagos;
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
        if($this->sede === "Todos"){
            $notificaciones = SeerPerGeneral::whereBetween('seer_general.fecha',[$this->fecha_inicial,$this->fecha_final])
            ->join('catalogo_rama','catalogo_rama.id','seer_general.id_rama')
            ->join('seer_citados','seer_general.id','seer_citados.id_solicitud')
            ->join('seer_solicitante','seer_general.id','seer_solicitante.id_solicitud');
            if($this->auxiliar != "Todos"){
                $notificaciones = $notificaciones->where('seer_general.user_id',$this->auxiliar);
            }
            if($this->notificador != "Todos"){
                $notificaciones = $notificaciones->where('seer_citados.id_notificador',$this->notificador);
            }
                $notificaciones = $notificaciones->join('users as auxiliar','auxiliar.id','seer_general.user_id')
                ->leftjoin('users as notificador','notificador.id','seer_citados.id_notificador')
                ->select('seer_general.id','seer_general.NUE','seer_solicitante.nombre as nombre_solicitante','seer_general.fecha','seer_citados.nombre'
                ,'seer_citados.primer_apellido','seer_citados.segundo_apellido','seer_citados.colonia','seer_citados.calle',
                'seer_citados.n_ext','seer_citados.n_int','seer_citados.estatus','seer_general.actividad','catalogo_rama.rama_industrial',
                'seer_general.delegacion','notificador.name as notificador','auxiliar.name as auxiliar')
                ->get();
                
            }else{
                $notificaciones = SeerPerGeneral::whereBetween('seer_general.fecha',[$this->fecha_inicial,$this->fecha_final])
                ->join('catalogo_rama','catalogo_rama.id','seer_general.id_rama')
                ->join('seer_citados','seer_general.id','seer_citados.id_solicitud')
                ->join('seer_solicitante','seer_general.id','seer_solicitante.id_solicitud');
                if($this->auxiliar != "Todos"){
                    $notificaciones = $notificaciones->where('seer_general.user_id',$this->auxiliar);
                }
                if($this->notificador != "Todos"){
                    $notificaciones = $notificaciones->where('seer_citados.id_notificador',$this->notificador);
                }
                $notificaciones = $notificaciones>join('users as auxiliar','auxiliar.id','seer_general.user_id')
                ->leftjoin('users as notificador','notificador.id','seer_citados.id_notificador')
                ->where('seer_general.delegacion', $this->sede)
                ->select('seer_general.id','seer_general.NUE','seer_solicitante.nombre','seer_general.fecha','seer_citados.nombre'
                ,'seer_citados.primer_apellido','seer_citados.segundo_apellido','seer_citados.colonia','seer_citados.calle',
                'seer_citados.n_ext','seer_citados.n_int','seer_citados.estatus','seer_general.actividad','catalogo_rama.rama_industrial',
                'seer_general.delegacion','notificador.name as notificador','auxiliar.name as auxiliar')
                ->get();
            }

        return view('excel.notificaciones', ['notificaciones' => $notificaciones]);
    }
}