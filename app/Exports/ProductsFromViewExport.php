<?php

namespace App\Exports;

use App\Models\Pagos;
use App\Models\User; // Importante: No olvides importar el modelo User
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

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
        // 1. Subconsulta para obtener solo el primer citado y evitar duplicados
        $subqueryCitados = DB::table('seer_citados')
            ->select('id_solicitud', DB::raw('MIN(id) as first_id'))
            ->groupBy('id_solicitud');

        $pagosAudiencias = (clone $queryBase)
            // Usamos LEFT JOIN para que no se borren los registros con id_solicitud = 0
            ->leftJoin('seer_general', 'seer_general.id', '=', 'pago_solicitud.id_solicitud') 
            ->leftJoin('seer_solicitante', 'seer_solicitante.id_solicitud', '=', 'seer_general.id') 
            ->leftJoinSub($subqueryCitados, 'primera_cita', function ($join) {
                $join->on('seer_general.id', '=', 'primera_cita.id_solicitud');
            })
            ->leftJoin('seer_citados', 'seer_citados.id', '=', 'primera_cita.first_id') 
            ->leftJoin('users', 'users.id', '=', 'pago_solicitud.id_conciliador')
            
            ->whereIn('pago_solicitud.tipo_pago', ["Audiencia", "Conciliador"])
            
            ->select(
                'pago_solicitud.*',
                // Lógica condicional para cada campo
                DB::raw("CASE WHEN pago_solicitud.id_solicitud != 0 THEN seer_general.NUE ELSE pago_solicitud.NUE END as NUE"),
                
                // Para el Empleador/Citado (concatenamos nombres y apellidos si vienen de la tabla)
                DB::raw("CASE WHEN pago_solicitud.id_solicitud != 0 
                            THEN CONCAT_WS(' ', seer_citados.nombre, seer_citados.primer_apellido, seer_citados.segundo_apellido) 
                            ELSE pago_solicitud.empresa_representante 
                        END as nombre_empleador"),
                
                // Para el Trabajador/Solicitante
                DB::raw("CASE WHEN pago_solicitud.id_solicitud != 0 THEN seer_solicitante.nombre ELSE pago_solicitud.nombre_trabajador END as nombre_trabajador"),
                
                // Para la Delegación
                DB::raw("CASE WHEN pago_solicitud.id_solicitud != 0 THEN seer_general.delegacion ELSE pago_solicitud.delegacion END as turno_delegacion"),
                
                'users.name as conciliador_name'
            )
            ->get();
            
        return view('excel.cumplimientos', [
            'pagosRatificacion' => $pagosRatificacion,
            'pagosAudiencias'   => $pagosAudiencias
        ]);
    }
}