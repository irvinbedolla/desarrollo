<?php

namespace App\Exports;

use App\Models\Pagos;
use App\Models\User; // Importante: No olvides importar el modelo User
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
        // Optimizamos la obtención del usuario
        $user = auth()->user();
        $sedeUsuario = $user->delegacion;

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
        
        // --- Pagos de Ratificación ---
        $pagosRatificacion = (clone $queryBase)
            ->where('pago_solicitud.tipo_pago', "Ratificacion")
            ->join('turnos', 'turnos.id', '=', 'pago_solicitud.id_solicitud') // Agregué el '=' por buena práctica
            ->leftJoin('users', 'users.id', '=', 'turnos.id_conciliador')
            ->select(
                'pago_solicitud.*',
                'turnos.NUE', 'turnos.empresa', 'turnos.primero_empresa', 'turnos.segundo_empresa',
                'turnos.trabajador', 'turnos.primero_trabajador', 'turnos.segundo_trabajador', 
                'turnos.delegacion as turno_delegacion',
                'users.name as conciliador_name'
            )
            ->orderBy('users.name')
            ->get();
            
        // --- Pagos de Audiencias ---
        $pagosAudiencias = (clone $queryBase)
            ->where('pago_solicitud.tipo_pago', "Audiencia")
            ->join('users', 'users.id', '=', 'pago_solicitud.id_conciliador')
            ->select('pago_solicitud.*', 'users.name as conciliador_name')
            ->get();

        return view('excel.cumplimientos', [
            'pagosRatificacion' => $pagosRatificacion,
            'pagosAudiencias'   => $pagosAudiencias
        ]);
    }
}