<?php

namespace App\Exports;

use App\Models\SeerPerGeneral;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class NotificacionesExport implements WithMultipleSheets
{
    protected $fecha_inicial, $fecha_final, $sede, $auxiliar, $notificador;

    public function __construct($fecha_inicial, $fecha_final, $sede, $auxiliar, $notificador)
    {
        $this->fecha_inicial = $fecha_inicial;
        $this->fecha_final = $fecha_final;
        $this->sede = $sede;
        $this->auxiliar = $auxiliar;
        $this->notificador = $notificador;
    }

    public function sheets(): array
    {
        // 1. Ejecutamos tu lógica de consulta una sola vez
        $user = auth()->user();
        $sedeUsuario = $user->delegacion;

        $notificaciones = SeerPerGeneral::whereBetween('seer_general.fecha', [$this->fecha_inicial, $this->fecha_final])
            ->join('catalogo_rama', 'catalogo_rama.id', '=', 'seer_general.id_rama')
            ->join('seer_citados', 'seer_general.id', '=', 'seer_citados.id_solicitud')
            ->join('seer_solicitante', 'seer_general.id', '=', 'seer_solicitante.id_solicitud')
            ->join('users as auxiliar', 'auxiliar.id', '=', 'seer_general.user_id')
            ->leftJoin('users as notificador', 'notificador.id', '=', 'seer_citados.id_notificador')
            ->when($this->sede !== "Todos", function ($q) use ($sedeUsuario) {
                if ($this->sede === "TodosDelegado") {
                    $grupos = ['Morelia' => ['Morelia', 'Zitácuaro'], 'Uruapan' => ['Uruapan', 'Lázaro Cárdenas'], 'Zamora' => ['Zamora', 'Sahuayo']];
                    if (array_key_exists($sedeUsuario, $grupos)) return $q->whereIn('seer_general.delegacion', $grupos[$sedeUsuario]);
                }
                return $q->where('seer_general.delegacion', $this->sede);
            })
            ->when($this->auxiliar !== "Todos", function ($q) { return $q->where('seer_general.user_id', $this->auxiliar); })
            ->when($this->notificador !== "Todos", function ($q) { return $q->where('seer_citados.id_notificador', $this->notificador); })
            ->select('seer_general.*', 'seer_citados.*', 'seer_solicitante.nombre as nombre_solicitante', 'notificador.name as nombre_notificador', 'auxiliar.name as auxiliar')
            ->get();

        // 2. Calculamos los totales
        $totalesPorNotificador = $notificaciones->groupBy('nombre_notificador')->map(function ($row) {
            return [
                'nombre' => $row->first()->nombre_notificador ?? 'Sin asignar',
                'total' => $row->count(),
                'notificadas' => $row->whereIn('estatus', ['Notificada','Finalizado exitosamente','Recibe pero no firma'])->count(),
                'no_notificadas' => $row->whereIn('estatus', ['No notificada','No exitosa se constituye','No exitosa no se constituye'])->count(),
                'pendientes' => $row->whereIn('estatus', ['Pendiente'])->count(),
                'exhorto' => $row->whereIn('estatus', ['Exhorto'])->count(),
            ];
        });

        // 3. Retornamos las hojas pasando los datos específicos a cada una
        return [
            new NotificacionesTotalesSheet($totalesPorNotificador), // Hoja 1
            new NotificacionesDetalleSheet($notificaciones),       // Hoja 2
        ];
    }
}