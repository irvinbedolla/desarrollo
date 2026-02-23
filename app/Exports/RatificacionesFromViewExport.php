<?php

namespace App\Exports;

use App\Models\Turnos;
use App\Models\Pagos;
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
        // Optimizamos la obtención del usuario
        $user = auth()->user();
        $sedeUsuario = $user->delegacion;
        
        $ratificaciones = Turnos::whereBetween('turnos.fecha', [$this->fecha_inicial, $this->fecha_final])
            ->join('users', 'users.id', '=', 'turnos.id_conciliador')
            ->join('users as user_usuario', 'user_usuario.id', '=', 'turnos.user_id')
            ->select('turnos.*', 'users.name as conciliador_name', 'user_usuario.name as auxiliar')
            
            // Condición dinámica para la sede
            ->when($this->sede !== "Todos", function ($query) use ($sedeUsuario) {
                if ($this->sede === "TodosDelegado") {
                    
                    // Definimos los grupos de delegaciones
                    $grupos = [
                        'Morelia' => ['Morelia', 'Zitácuaro'],
                        'Uruapan' => ['Uruapan', 'Lázaro Cárdenas'],
                        'Zamora'  => ['Zamora', 'Sahuayo']
                    ];

                    // Si la sede del usuario existe en nuestros grupos, filtramos por ese array
                    if (array_key_exists($sedeUsuario, $grupos)) {
                        return $q->whereIn('turnos.delegacion', $grupos[$sedeUsuario]);
                    }
                }
                
                // Si es cualquier otra sede individual
                return $query->where('turnos.delegacion', $this->sede);
            })
            
            ->orderBy('user_usuario.name')
            ->get();

            // Consulta Base para Pagos
        $queryBase = Pagos::whereBetween('pago_solicitud.fecha', [$this->fecha_inicial, $this->fecha_final])
            ->when($this->sede !== "Todos", function ($q) use ($sedeUsuario) {
                // Usamos $this->sede porque está dentro de la clase
                if ($this->sede === "TodosDelegado") {
                    
                    // Definimos los grupos de delegaciones
                    $grupos = [
                        'Morelia' => ['Morelia', 'Zitácuaro'],
                        'Uruapan' => ['Uruapan', 'Lázaro Cárdenas'],
                        'Zamora'  => ['Zamora', 'Sahuayo']
                    ];

                    // Si la sede del usuario existe en nuestros grupos, filtramos por ese array
                    if (array_key_exists($sedeUsuario, $grupos)) {
                        return $q->whereIn('pago_solicitud.delegacion', $grupos[$sedeUsuario]);
                    }
                }
                
                // Si no es TodosDelegado o no coincide el grupo, filtra por la sede seleccionada
                return $q->where('pago_solicitud.delegacion', $this->sede);
            });
        
         // 1. Consulta Unificada para Ratificaciones
        $ratificacionePagadas = Pagos::whereBetween('pago_solicitud.fecha', [$this->fecha_inicial, $this->fecha_final])
            ->join('turnos', 'turnos.id', 'pago_solicitud.id_solicitud')
            ->where('pago_solicitud.tipo_pago', 'Ratificacion')
            ->when($this->sede !== "Todos", function ($q) use ($this) {
                // Si es el caso especial de Delegado, filtramos por el array de sedes
                if ($this->sede === "TodosDelegado") {
                    $id = auth()->user()->id;
                    $user = User::find($id);
                    $sedeUsuario = $user->delegacion;
    
                    if($sedeUsuario == "Morelia"){
                        $this->delegaciones = ['Morelia', 'Zitácuaro'];
                        return $q->whereIn('pago_solicitud.delegacion', $this->delegaciones);
                    }
                    else if($sedeUsuario == "Uruapan"){
                        $this->delegaciones = ['Uruapan', 'Lázaro Cárdenas'];
                        return $q->whereIn('pago_solicitud.delegacion', $this->delegaciones);
                    }
                    else if($sedeUsuario == "Zamora"){
                        $this->delegaciones = ['Zamora', 'Sahuayo'];
                        return $q->whereIn('pago_solicitud.delegacion', $this->delegaciones);
                    }
                }
                return $q->where('pago_solicitud.delegacion', $this->sede);
            })
            ->selectRaw("
                SUM(CASE WHEN pago_solicitud.estatus = 'Pagado' THEN pago_solicitud.monto ELSE 0 END) as pagado_monto
            ")
            ->first();

        return view('excel.ratificaciones', [
            'Ratificacion' => $ratificaciones,
            'RatificacionPagadas' => $ratificacionePagadas
        ]);
    }
}