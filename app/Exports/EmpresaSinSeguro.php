<?php

namespace App\Exports;

use App\Models\SeerPerGeneral;
use App\Models\User; // Importante: No olvides importar el modelo User
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class EmpresaSinSeguro implements FromView
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
        $queryBase = SeerPerGeneral::whereBetween('seer_general.fecha', [$this->fecha_inicial, $this->fecha_final])
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
                        return $q->whereIn('seer_general.delegacion', $grupos[$sedeUsuario]);
                    }
                }
                
                // Si no es TodosDelegado o no coincide el grupo, filtra por la sede seleccionada
                return $q->where('seer_general.delegacion', $this->sede);
            });
        
        // Obtencion de empresas
        $empresas = (clone $queryBase)
            ->join('seer_solicitante','seer_solicitante.id_solicitud','seer_general.id')
            ->join('seer_citados','seer_citados.id_solicitud','seer_citados.id')
            ->join('abogados','abogados.idAbogado','seer_citados.id_abogado')


            ->where('seer_solicitante.nss','')

            //->leftJoin('users', 'users.id', '=', 'turnos.id_conciliador')
            ->select(
                'seer_general.NUE',
                'seer_general.delegacion',
                DB::raw("CONCAT(' ', abogados.nombres_patronal, abogados.primer_apellido_patronal, abogados.segundo_apellido_patronal) as nombre_abogado"),
                DB::raw("CONCAT(' ', abogados.nombre_representante, abogados.primer_apellido_representante, abogados.segundo_apellido_representante) as nombre_representante"),
            )
            ->orderBy('nombre_abogado')
            ->get();
            
dd($empresas);

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