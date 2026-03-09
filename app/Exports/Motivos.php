<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // IMPORTANTE: Agregar esto

class Motivos implements FromView
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
        $user = Auth::user();
        $sedeUsuario = $user->delegacion ?? '';

        $grupos = [
            'Morelia' => ['Morelia', 'Zitácuaro'],
            'Uruapan' => ['Uruapan', 'Lázaro Cárdenas'],
            'Zamora'  => ['Zamora', 'Sahuayo']
        ];

        $totalesSolicitudes = DB::table('catalogo_motivos')
            ->join('seer_motivos', 'catalogo_motivos.id', '=', 'seer_motivos.id_motivo')
            ->join('seer_general', 'seer_general.id', '=', 'seer_motivos.id_solicitud')
            ->join('seer_solicitante', 'seer_solicitante.id_solicitud', '=', 'seer_general.id')
            ->whereBetween('seer_general.fecha', [$this->fecha_inicial, $this->fecha_final])
            ->when($this->sede !== "Todos", function ($q) use ($sedeUsuario, $grupos) {
                if ($this->sede === "TodosDelegado") {
                    $delegaciones = $grupos[$sedeUsuario] ?? [$sedeUsuario];
                    return $q->whereIn('seer_general.delegacion', $delegaciones);
                }
                return $q->where("seer_general.delegacion", $this->sede);
            })
            ->select(
                // Definimos las categorías mediante un CASE
                DB::raw("CASE 
                    WHEN catalogo_motivos.motivo IN ('Despido') THEN 'Grupo Despido'
                    WHEN catalogo_motivos.motivo IN ('Pago de prestaciones') THEN 'Grupo Prestaciones'
                    WHEN catalogo_motivos.motivo IN ('Rescisión de la relación de trabajo') THEN 'Grupo Rescisión de la relación de trabajo'
                    WHEN catalogo_motivos.motivo IN ('Derecho de preferencia', 'Derecho de antigüedad', 'Derecho de ascenso') THEN 'Grupo Derechos'
                    WHEN catalogo_motivos.motivo = 'Terminación voluntaria de la relación de trabajo' THEN 'Terminación Voluntaria'
                    ELSE 'Otros Motivos'
                END as categoria"),

                // Sumatorias para Hombres por categoría
                DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'H' THEN 1 ELSE 0 END) as total_hombres"),
                
                // Sumatorias para Mujeres por categoría
                DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'M' THEN 1 ELSE 0 END) as total_mujeres"),
                
                // Total general de la categoría
                DB::raw("COUNT(*) as total_general")
            )
            ->groupBy('categoria') // Agrupamos por el alias creado en el CASE
        ->get();

        $totalesSolicitudesC = DB::table('catalogo_motivos')
            ->join('seer_motivos', 'catalogo_motivos.id', '=', 'seer_motivos.id_motivo')
            ->join('seer_general', 'seer_general.id', '=', 'seer_motivos.id_solicitud')
            ->join('seer_solicitante', 'seer_solicitante.id_solicitud', '=', 'seer_general.id')
            ->whereBetween('seer_general.fecha', [$this->fecha_inicial, $this->fecha_final])
            ->whereNotIn('seer_general.estatus',['Pendiente','Prevencion'])
            ->when($this->sede !== "Todos", function ($q) use ($sedeUsuario, $grupos) {
                if ($this->sede === "TodosDelegado") {
                    $delegaciones = $grupos[$sedeUsuario] ?? [$sedeUsuario];
                    return $q->whereIn('seer_general.delegacion', $delegaciones);
                }
                return $q->where("seer_general.delegacion", $this->sede);
            })
            ->select(
                // Definimos las categorías mediante un CASE
                DB::raw("CASE 
                    WHEN catalogo_motivos.motivo IN ('Despido') THEN 'Grupo Despido'
                    WHEN catalogo_motivos.motivo IN ('Pago de prestaciones') THEN 'Grupo Prestaciones'
                    WHEN catalogo_motivos.motivo IN ('Rescisión de la relación de trabajo') THEN 'Grupo Rescisión de la relación de trabajo'
                    WHEN catalogo_motivos.motivo IN ('Derecho de preferencia', 'Derecho de antigüedad', 'Derecho de ascenso') THEN 'Grupo Derechos'
                    WHEN catalogo_motivos.motivo = 'Terminación voluntaria de la relación de trabajo' THEN 'Terminación Voluntaria'
                    ELSE 'Otros Motivos'
                END as categoria"),

                // Sumatorias para Hombres por categoría
                DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'H' THEN 1 ELSE 0 END) as total_hombres"),
                
                // Sumatorias para Mujeres por categoría
                DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'M' THEN 1 ELSE 0 END) as total_mujeres"),
                
                // Total general de la categoría
                DB::raw("COUNT(*) as total_general")
            )
            ->groupBy('categoria') // Agrupamos por el alias creado en el CASE
        ->get();

        $totalesFaltaInteres = DB::table('catalogo_motivos')
            ->join('seer_motivos', 'catalogo_motivos.id', '=', 'seer_motivos.id_motivo')
            ->join('seer_general', 'seer_general.id', '=', 'seer_motivos.id_solicitud')
            ->join('seer_solicitante', 'seer_solicitante.id_solicitud', '=', 'seer_general.id')
            ->join('audiencias', 'audiencias.id_solicitud', '=', 'seer_general.id')
            ->whereBetween('seer_general.fecha', [$this->fecha_inicial, $this->fecha_final])
            ->where('audiencias.estatus', 'Archivada')
            ->when($this->sede !== "Todos", function ($q) use ($sedeUsuario, $grupos) {
                if ($this->sede === "TodosDelegado") {
                    $delegaciones = $grupos[$sedeUsuario] ?? [$sedeUsuario];
                    return $q->whereIn('seer_general.delegacion', $delegaciones);
                }
                return $q->where("seer_general.delegacion", $this->sede);
            })
            ->select(
                // Definimos las categorías mediante un CASE
                DB::raw("CASE 
                    WHEN catalogo_motivos.motivo IN ('Despido') THEN 'Grupo Despido'
                    WHEN catalogo_motivos.motivo IN ('Pago de prestaciones') THEN 'Grupo Prestaciones'
                    WHEN catalogo_motivos.motivo IN ('Rescisión de la relación de trabajo') THEN 'Grupo Rescisión de la relación de trabajo'
                    WHEN catalogo_motivos.motivo IN ('Derecho de preferencia', 'Derecho de antigüedad', 'Derecho de ascenso') THEN 'Grupo Derechos'
                    WHEN catalogo_motivos.motivo = 'Terminación voluntaria de la relación de trabajo' THEN 'Terminación Voluntaria'
                    ELSE 'Otros Motivos'
                END as categoria"),

                // Sumatorias para Hombres por categoría
                DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'H' THEN 1 ELSE 0 END) as total_hombres"),
                
                // Sumatorias para Mujeres por categoría
                DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'M' THEN 1 ELSE 0 END) as total_mujeres"),
                
                // Total general de la categoría
                DB::raw("COUNT(*) as total_general")
            )
            ->groupBy('categoria') // Agrupamos por el alias creado en el CASE
        ->get();

        $totalesAudienciasP = DB::table('catalogo_motivos')
            ->join('seer_motivos', 'catalogo_motivos.id', '=', 'seer_motivos.id_motivo')
            ->join('seer_general', 'seer_general.id', '=', 'seer_motivos.id_solicitud')
            ->join('seer_solicitante', 'seer_solicitante.id_solicitud', '=', 'seer_general.id')
            ->join('audiencias', 'audiencias.id_solicitud', '=', 'seer_general.id')
            ->whereBetween('seer_general.fecha', [$this->fecha_inicial, $this->fecha_final])
            ->where('audiencias.estatus', 'Archivada')
            ->when($this->sede !== "Todos", function ($q) use ($sedeUsuario, $grupos) {
                if ($this->sede === "TodosDelegado") {
                    $delegaciones = $grupos[$sedeUsuario] ?? [$sedeUsuario];
                    return $q->whereIn('seer_general.delegacion', $delegaciones);
                }
                return $q->where("seer_general.delegacion", $this->sede);
            })
            ->select(
                // Definimos las categorías mediante un CASE
                DB::raw("CASE 
                    WHEN catalogo_motivos.motivo IN ('Despido') THEN 'Grupo Despido'
                    WHEN catalogo_motivos.motivo IN ('Pago de prestaciones') THEN 'Grupo Prestaciones'
                    WHEN catalogo_motivos.motivo IN ('Rescisión de la relación de trabajo') THEN 'Grupo Rescisión de la relación de trabajo'
                    WHEN catalogo_motivos.motivo IN ('Derecho de preferencia', 'Derecho de antigüedad', 'Derecho de ascenso') THEN 'Grupo Derechos'
                    WHEN catalogo_motivos.motivo = 'Terminación voluntaria de la relación de trabajo' THEN 'Terminación Voluntaria'
                    ELSE 'Otros Motivos'
                END as categoria"),

                // Sumatorias para Hombres por categoría
                DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'H' THEN 1 ELSE 0 END) as total_hombres"),
                
                // Sumatorias para Mujeres por categoría
                DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'M' THEN 1 ELSE 0 END) as total_mujeres"),
                
                // Total general de la categoría
                DB::raw("COUNT(*) as total_general")
            )
            ->groupBy('categoria') // Agrupamos por el alias creado en el CASE
        ->get();

        $totalesAudienciasC = DB::table('catalogo_motivos')
            ->join('seer_motivos', 'catalogo_motivos.id', '=', 'seer_motivos.id_motivo')
            ->join('seer_general', 'seer_general.id', '=', 'seer_motivos.id_solicitud')
            ->join('seer_solicitante', 'seer_solicitante.id_solicitud', '=', 'seer_general.id')
            ->join('audiencias', 'audiencias.id_solicitud', '=', 'seer_general.id')
            ->whereBetween('seer_general.fecha', [$this->fecha_inicial, $this->fecha_final])
            ->whereIn('audiencias.estatus', ['Conciliacion','No conciliacion reagendada','No conciliacion'])
            ->when($this->sede !== "Todos", function ($q) use ($sedeUsuario, $grupos) {
                if ($this->sede === "TodosDelegado") {
                    $delegaciones = $grupos[$sedeUsuario] ?? [$sedeUsuario];
                    return $q->whereIn('seer_general.delegacion', $delegaciones);
                }
                return $q->where("seer_general.delegacion", $this->sede);
            })
            ->select(
                // Definimos las categorías mediante un CASE
                DB::raw("CASE 
                    WHEN catalogo_motivos.motivo IN ('Despido') THEN 'Grupo Despido'
                    WHEN catalogo_motivos.motivo IN ('Pago de prestaciones') THEN 'Grupo Prestaciones'
                    WHEN catalogo_motivos.motivo IN ('Rescisión de la relación de trabajo') THEN 'Grupo Rescisión de la relación de trabajo'
                    WHEN catalogo_motivos.motivo IN ('Derecho de preferencia', 'Derecho de antigüedad', 'Derecho de ascenso') THEN 'Grupo Derechos'
                    WHEN catalogo_motivos.motivo = 'Terminación voluntaria de la relación de trabajo' THEN 'Terminación Voluntaria'
                    ELSE 'Otros Motivos'
                END as categoria"),

                // Sumatorias para Hombres por categoría
                DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'H' THEN 1 ELSE 0 END) as total_hombres"),
                
                // Sumatorias para Mujeres por categoría
                DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'M' THEN 1 ELSE 0 END) as total_mujeres"),
                
                // Total general de la categoría
                DB::raw("COUNT(*) as total_general")
            )
            ->groupBy('categoria') // Agrupamos por el alias creado en el CASE
        ->get();
        
        $totalesAudienciasConvenios = DB::table('catalogo_motivos')
            ->join('seer_motivos', 'catalogo_motivos.id', '=', 'seer_motivos.id_motivo')
            ->join('seer_general', 'seer_general.id', '=', 'seer_motivos.id_solicitud')
            ->join('seer_solicitante', 'seer_solicitante.id_solicitud', '=', 'seer_general.id')
            ->join('audiencias', 'audiencias.id_solicitud', '=', 'seer_general.id')
            ->whereBetween('seer_general.fecha', [$this->fecha_inicial, $this->fecha_final])
            ->whereIn('audiencias.estatus', ['Conciliacion'])
            ->when($this->sede !== "Todos", function ($q) use ($sedeUsuario, $grupos) {
                if ($this->sede === "TodosDelegado") {
                    $delegaciones = $grupos[$sedeUsuario] ?? [$sedeUsuario];
                    return $q->whereIn('seer_general.delegacion', $delegaciones);
                }
                return $q->where("seer_general.delegacion", $this->sede);
            })
            ->select(
                // Definimos las categorías mediante un CASE
                DB::raw("CASE 
                    WHEN catalogo_motivos.motivo IN ('Despido') THEN 'Grupo Despido'
                    WHEN catalogo_motivos.motivo IN ('Pago de prestaciones') THEN 'Grupo Prestaciones'
                    WHEN catalogo_motivos.motivo IN ('Rescisión de la relación de trabajo') THEN 'Grupo Rescisión de la relación de trabajo'
                    WHEN catalogo_motivos.motivo IN ('Derecho de preferencia', 'Derecho de antigüedad', 'Derecho de ascenso') THEN 'Grupo Derechos'
                    WHEN catalogo_motivos.motivo = 'Terminación voluntaria de la relación de trabajo' THEN 'Terminación Voluntaria'
                    ELSE 'Otros Motivos'
                END as categoria"),

                // Sumatorias para Hombres por categoría
                DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'H' THEN 1 ELSE 0 END) as total_hombres"),
                
                // Sumatorias para Mujeres por categoría
                DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'M' THEN 1 ELSE 0 END) as total_mujeres"),
                
                // Total general de la categoría
                DB::raw("COUNT(*) as total_general")
            )
            ->groupBy('categoria') // Agrupamos por el alias creado en el CASE
        ->get();

        $totalesAudienciasNO = DB::table('catalogo_motivos')
            ->join('seer_motivos', 'catalogo_motivos.id', '=', 'seer_motivos.id_motivo')
            ->join('seer_general', 'seer_general.id', '=', 'seer_motivos.id_solicitud')
            ->join('seer_solicitante', 'seer_solicitante.id_solicitud', '=', 'seer_general.id')
            ->join('audiencias', 'audiencias.id_solicitud', '=', 'seer_general.id')
            ->whereBetween('seer_general.fecha', [$this->fecha_inicial, $this->fecha_final])
            ->whereIn('audiencias.estatus', ['No conciliacion'])
            ->when($this->sede !== "Todos", function ($q) use ($sedeUsuario, $grupos) {
                if ($this->sede === "TodosDelegado") {
                    $delegaciones = $grupos[$sedeUsuario] ?? [$sedeUsuario];
                    return $q->whereIn('seer_general.delegacion', $delegaciones);
                }
                return $q->where("seer_general.delegacion", $this->sede);
            })
            ->select(
                // Definimos las categorías mediante un CASE
                DB::raw("CASE 
                    WHEN catalogo_motivos.motivo IN ('Despido') THEN 'Grupo Despido'
                    WHEN catalogo_motivos.motivo IN ('Pago de prestaciones') THEN 'Grupo Prestaciones'
                    WHEN catalogo_motivos.motivo IN ('Rescisión de la relación de trabajo') THEN 'Grupo Rescisión de la relación de trabajo'
                    WHEN catalogo_motivos.motivo IN ('Derecho de preferencia', 'Derecho de antigüedad', 'Derecho de ascenso') THEN 'Grupo Derechos'
                    WHEN catalogo_motivos.motivo = 'Terminación voluntaria de la relación de trabajo' THEN 'Terminación Voluntaria'
                    ELSE 'Otros Motivos'
                END as categoria"),

                // Sumatorias para Hombres por categoría
                DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'H' THEN 1 ELSE 0 END) as total_hombres"),
                
                // Sumatorias para Mujeres por categoría
                DB::raw("SUM(CASE WHEN seer_solicitante.sexo = 'M' THEN 1 ELSE 0 END) as total_mujeres"),
                
                // Total general de la categoría
                DB::raw("COUNT(*) as total_general")
            )
            ->groupBy('categoria') // Agrupamos por el alias creado en el CASE
        ->get();

        // 1. Definimos el "esqueleto" con todos los grupos en 0
        $resumenFinal = collect([
            'Grupo Despido' => ['h' => 0, 'm' => 0, 'total' => 0],
            'Grupo Prestaciones' => ['h' => 0, 'm' => 0, 'total' => 0],
            'Grupo Rescisión de la relación de trabajo' => ['h' => 0, 'm' => 0, 'total' => 0],
            'Grupo Derechos' => ['h' => 0, 'm' => 0, 'total' => 0],
            'Terminación Voluntaria' => ['h' => 0, 'm' => 0, 'total' => 0],
            'Otros estatus' => ['h' => 0, 'm' => 0, 'total' => 0],
        ]);

        // 2. Ejecutamos tu consulta (la que corregimos con el GROUP BY)
        $ratificaciones = DB::table('turnos')
            ->whereBetween('turnos.fecha', [$this->fecha_inicial, $this->fecha_final])
            ->select(
                DB::raw("CASE 
                    WHEN turnos.motivo IN ('Despido') THEN 'Grupo Despido'
                    WHEN turnos.motivo IN ('Pago de prestaciones') THEN 'Grupo Prestaciones'
                    WHEN turnos.motivo IN ('Rescisión de la relación de trabajo') THEN 'Grupo Rescisión de la relación de trabajo'
                    WHEN turnos.motivo IN ('Derecho de preferencia', 'Derecho de antigüedad', 'Derecho de ascenso') THEN 'Grupo Derechos'
                    WHEN turnos.motivo IN ('Terminación voluntaria de la relación de trabajo') THEN 'Terminación Voluntaria'
                    ELSE 'Otros motivo'
                END as categoria"),
                DB::raw("SUM(CASE WHEN turnos.sexo = 'H' THEN 1 ELSE 0 END) as total_hombres"),
                DB::raw("SUM(CASE WHEN turnos.sexo = 'M' THEN 1 ELSE 0 END) as total_mujeres"),
                DB::raw("COUNT(*) as total_general")
            )
            ->groupBy(DB::raw("CASE 
                    WHEN turnos.motivo IN ('Despido') THEN 'Grupo Despido'
                    WHEN turnos.motivo IN ('Pago de prestaciones') THEN 'Grupo Prestaciones'
                    WHEN turnos.motivo IN ('Rescisión de la relación de trabajo') THEN 'Grupo Rescisión de la relación de trabajo'
                    WHEN turnos.motivo IN ('Derecho de preferencia', 'Derecho de antigüedad', 'Derecho de ascenso') THEN 'Grupo Derechos'
                    WHEN turnos.motivo IN ('Terminación voluntaria de la relación de trabajo') THEN 'Terminación Voluntaria'
                    ELSE 'Otros motivo'
                END"))
            ->get();

        // 3. Llenamos el esqueleto con los datos reales
        foreach ($ratificaciones as $registro) {
            if ($resumenFinal->has($registro->categoria)) {
                $resumenFinal->put($registro->categoria, [
                    'h' => $registro->total_hombres,
                    'm' => $registro->total_mujeres,
                    'total' => $registro->total_general,
                ]);
            }
        }


        // 1. Definimos el "esqueleto" con todos los grupos en 0
        $resumenFinalC = collect([
            'Grupo Despido' => ['h' => 0, 'm' => 0, 'total' => 0],
            'Grupo Prestaciones' => ['h' => 0, 'm' => 0, 'total' => 0],
            'Grupo Rescisión de la relación de trabajo' => ['h' => 0, 'm' => 0, 'total' => 0],
            'Grupo Derechos' => ['h' => 0, 'm' => 0, 'total' => 0],
            'Terminación Voluntaria' => ['h' => 0, 'm' => 0, 'total' => 0],
            'Otros estatus' => ['h' => 0, 'm' => 0, 'total' => 0],
        ]);

        // 2. Ejecutamos tu consulta (la que corregimos con el GROUP BY)
        $ratificacionesC = DB::table('turnos')
            ->whereBetween('turnos.fecha', [$this->fecha_inicial, $this->fecha_final])
            ->whereIn('turnos.estatus',['Concluida','Concluida Pagos'])
            ->select(
                DB::raw("CASE 
                    WHEN turnos.motivo IN ('Despido') THEN 'Grupo Despido'
                    WHEN turnos.motivo IN ('Pago de prestaciones') THEN 'Grupo Prestaciones'
                    WHEN turnos.motivo IN ('Rescisión de la relación de trabajo') THEN 'Grupo Rescisión de la relación de trabajo'
                    WHEN turnos.motivo IN ('Derecho de preferencia', 'Derecho de antigüedad', 'Derecho de ascenso') THEN 'Grupo Derechos'
                    WHEN turnos.motivo IN ('Terminación voluntaria de la relación de trabajo') THEN 'Terminación Voluntaria'
                    ELSE 'Otros motivo'
                END as categoria"),
                DB::raw("SUM(CASE WHEN turnos.sexo = 'H' THEN 1 ELSE 0 END) as total_hombres"),
                DB::raw("SUM(CASE WHEN turnos.sexo = 'M' THEN 1 ELSE 0 END) as total_mujeres"),
                DB::raw("COUNT(*) as total_general")
            )
            ->groupBy(DB::raw("CASE 
                    WHEN turnos.motivo IN ('Despido') THEN 'Grupo Despido'
                    WHEN turnos.motivo IN ('Pago de prestaciones') THEN 'Grupo Prestaciones'
                    WHEN turnos.motivo IN ('Rescisión de la relación de trabajo') THEN 'Grupo Rescisión de la relación de trabajo'
                    WHEN turnos.motivo IN ('Derecho de preferencia', 'Derecho de antigüedad', 'Derecho de ascenso') THEN 'Grupo Derechos'
                    WHEN turnos.motivo IN ('Terminación voluntaria de la relación de trabajo') THEN 'Terminación Voluntaria'
                    ELSE 'Otros motivo'
                END"))
            ->get();

        // 3. Llenamos el esqueleto con los datos reales
        foreach ($ratificacionesC as $registro) {
            if ($resumenFinalC->has($registro->categoria)) {
                $resumenFinalC->put($registro->categoria, [
                    'h' => $registro->total_hombres,
                    'm' => $registro->total_mujeres,
                    'total' => $registro->total_general,
                ]);
            }
        }

        return view('excel.motivos', [
            'solicitudes'               => $totalesSolicitudes,
            'solicitudesConfirmadas'    => $totalesSolicitudesC,
            'faltaInteres'              => $totalesFaltaInteres,
            'audienciasProgramadas'     => $totalesAudienciasP,
            'audienciasCelebradas'      => $totalesAudienciasC,
            'convenios'                 => $totalesAudienciasConvenios,
            'noConciliacion'            => $totalesAudienciasNO,
            'ratificaciones'            => $resumenFinal, 
            'ratificacionesConcluidas'  => $resumenFinalC,
        ]);
    }
}