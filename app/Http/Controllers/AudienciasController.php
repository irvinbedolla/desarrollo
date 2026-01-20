<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Pagos;
use App\Models\Turnos;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CitasExport;
use App\Http\Controllers\SeerController;
use App\Models\Audiencias;
use Illuminate\Support\Facades\Auth;

class AudienciasController extends Controller
{

    public function audiencias() {
        $userID = Auth::user()->id;
        $userRole = Auth::user()->roles->pluck('name')->all();
        $sede = Auth::user()->delegacion;

        if ($userRole[0] == "Super Usuario" || $userRole[0] == "Administrador") {
            $audiencias = Audiencias::join('seer_general','seer_general.id','audiencias.id_solicitud')
            ->join('users','users.id','audiencias.id_conciliador')
            ->select('audiencias.*','seer_general.NUE','seer_general.estatus','users.name')->get();

            $eventos = [];
            foreach ($audiencias as $audiencia) {

                $tipo = 5;

                if ($audiencia->estatus === 'Incompetencia') {
                    $color = '#DA0909';
                } elseif ($audiencia->estatus === 'Archivada') {
                    $color = '#EAE300';
                } elseif ($audiencia->estatus === 'Conciliación') {
                    $color = '#00CE1C';
                } elseif ($audiencia->estatus === 'No Conciliación') {
                    $color = '#00CE1C';
                }
                 else {
                    $color = '#CCCCCC';
                }

                $eventos[] = [
                    'id' => $audiencia->id,
                    'id_solicitud' => $audiencia->id_solicitud,
                    'title' => $audiencia->NUE,
                    'start' => $audiencia->fecha->format('Y-m-d') . 'T' . $audiencia->hora->format('H:i:s'),
                    'extendedProps' => [
                        'hora' => $audiencia->hora->format('h:i A'),
                        'color' => $color,
                        'numero_audiencia' => $audiencia->numero_audiencia,
                        'folio_audiencia' => $audiencia->folio_audiencia,
                        'fecha' => $audiencia->fecha->format('d/m/Y'),
                        'estatus' => $audiencia->estatus,
                        'tipo' => $audiencia->tipo,
                        'conciliador' => $audiencia->id_conciliador,
                        'delegacion' => $audiencia->delegacion,
                        'sala' => $audiencia->sala,
                        'usuario' => $userID,
                        'tipo' => $tipo,
                        'conciliador' => $audiencia->name,
                    ]
                ];
            }

            return response()->json($eventos);
        }
        else if ($userRole[0] == "Delegado" || $userRole[0] == "Enlace" || $userRole[0] == "Auxiliar") {
           
            if($sede == "Morelia"){
                $delegaciones = ['Morelia', 'Zitácuaro'];
                $audiencias = Audiencias::join('seer_general','seer_general.id','audiencias.id_solicitud')
                ->join('users','users.id','audiencias.id_conciliador')
                ->select('audiencias.*','seer_general.NUE','seer_general.estatus')
                ->whereIn('audiencias.delegacion', $delegaciones)->get();
            }
            else if($sede == "Uruapan"){
                $delegaciones = ['Uruapan', 'Lázaro Cárdenas'];
                $audiencias = Audiencias::join('seer_general','seer_general.id','audiencias.id_solicitud')
                ->join('users','users.id','audiencias.id_conciliador')
                ->select('audiencias.*','seer_general.NUE','seer_general.estatus')
                ->whereIn('audiencias.delegacion', $delegaciones)->get();
            }
            else if($sede == "Zamora"){
                $delegaciones = ['Zamora', 'Sahuayo'];
                $audiencias = Audiencias::join('seer_general','seer_general.id','audiencias.id_solicitud')
                ->join('users','users.id','audiencias.id_conciliador')
                ->select('audiencias.*','seer_general.NUE','seer_general.estatus','users.name')
                ->whereIn('audiencias.delegacion', $delegaciones)->get();
            }

            $eventos = [];
            foreach ($audiencias as $audiencia) {

                $tipo = 5;

                if ($audiencia->estatus === 'Incompetencia') {
                    $color = '#DA0909';
                } elseif ($audiencia->estatus === 'Archivada') {
                    $color = '#EAE300';
                } elseif ($audiencia->estatus === 'Conciliación') {
                    $color = '#00CE1C';
                } elseif ($audiencia->estatus === 'No Conciliación') {
                    $color = '#00CE1C';
                }
                 else {
                    $color = '#CCCCCC';
                }

                $eventos[] = [
                    'id' => $audiencia->id,
                    'id_solicitud' => $audiencia->id_solicitud,
                    'title' => $audiencia->NUE,
                    'start' => $audiencia->fecha->format('Y-m-d') . 'T' . $audiencia->hora->format('H:i:s'),
                    'extendedProps' => [
                        'hora' => $audiencia->hora->format('h:i A'),
                        'color' => $color,
                        'numero_audiencia' => $audiencia->numero_audiencia,
                        'folio_audiencia' => $audiencia->folio_audiencia,
                        'fecha' => $audiencia->fecha->format('d/m/Y'),
                        'estatus' => $audiencia->estatus,
                        'tipo' => $audiencia->tipo,
                        'conciliador' => $audiencia->id_conciliador,
                        'delegacion' => $audiencia->delegacion,
                        'sala' => $audiencia->sala,
                        'usuario' => $userID,
                        'tipo' => $tipo,
                        'conciliador' => $audiencia->name,
                    ]
                ];
            }

            return response()->json($eventos);
        }
        else if ($userRole[0] == "Conciliador") {
            $audiencias = Audiencias::join('seer_general','seer_general.id','audiencias.id_solicitud')
            ->select('audiencias.*','seer_general.NUE','seer_general.estatus')
            ->where('audiencias.id_conciliador',$userID)
            ->get();

            $eventos = [];
            foreach ($audiencias as $audiencia) {

                $tipo = 5;

                if ($audiencia->estatus === 'Incompetencia') {
                    $color = '#DA0909';
                } elseif ($audiencia->estatus === 'Archivada') {
                    $color = '#EAE300';
                } elseif ($audiencia->estatus === 'Conciliación') {
                    $color = '#00CE1C';
                } elseif ($audiencia->estatus === 'No Conciliación') {
                    $color = '#00CE1C';
                }
                 else {
                    $color = '#CCCCCC';
                }

                $eventos[] = [
                    'id' => $audiencia->id,
                    'id_solicitud' => $audiencia->id_solicitud,
                    'title' => $audiencia->NUE,
                    'start' => $audiencia->fecha->format('Y-m-d') . 'T' . $audiencia->hora->format('H:i:s'),
                    'extendedProps' => [
                        'hora' => $audiencia->hora->format('h:i A'),
                        'color' => $color,
                        'numero_audiencia' => $audiencia->numero_audiencia,
                        'folio_audiencia' => $audiencia->folio_audiencia,
                        'fecha' => $audiencia->fecha->format('d/m/Y'),
                        'estatus' => $audiencia->estatus,
                        'tipo' => $audiencia->tipo,
                        'conciliador' => $audiencia->id_conciliador,
                        'delegacion' => $audiencia->delegacion,
                        'sala' => $audiencia->sala,
                        'usuario' => $userID,
                        'tipo' => $tipo
                    ]
                ];
            }

            return response()->json($eventos);
        }
    }

    public function ratificaciones() {
        $userID = Auth::user()->id;
        $userRole = Auth::user()->roles->pluck('name')->all();
        $sede = Auth::user()->delegacion;
        
        if ($userRole[0] == "Super Usuario" || $userRole[0] == "Administardor") {
            $ratificaciones = Turnos::all();
        }
        else if ($userRole[0] == "Delegado" || $userRole[0] == "Enlace") {
            $sede = Auth::user()->delegacion;
            if($sede == "Morelia"){
                $delegaciones = ['Morelia', 'Zitácuaro'];
                $ratificaciones = Turnos::where('delegacion', $delegaciones)->get();
            }
            else if($sede == "Uruapan"){
                $delegaciones = ['Uruapan', 'Lázaro Cárdenas'];
                $ratificaciones = Turnos::where('delegacion', $delegaciones)->get();
            }
            else if($sede == "Zamora"){
                $delegaciones = ['Zamora', 'Sahuayo'];
                $ratificaciones = Turnos::where('delegacion', $delegaciones)->get();
            }
        }
        else{
            $ratificaciones = Turnos::where('delegacion', $sede)->get();
        }

        $eventos = [];
        foreach ($ratificaciones as $rati) {

                $tipo = 7;

                if ($rati->estatus === 'Incumplimiento') {
                    $color = '#DA0909';
                } elseif ($rati->estatus === 'Archivada') {
                    $color = '#EAE300';
                } elseif ($rati->estatus === 'Concluida') {
                    $color = '#00CE1C';
                } elseif ($rati->estatus === 'Concluida Pagos') {
                    $color = '#00CE1C';
                } elseif ($rati->estatus === 'Confirmado') {
                    $color = '#0EB6F0';
                } else {
                    $color = '#CCCCCC';
                }

                $eventos[] = [
                    'id' => $rati->id,
                    'title' => $rati->empresa,
                    'start' => $rati->fecha . 'T' . $rati->hora,
                    'extendedProps' => [
                        'hora' => $rati->hora,
                        'color' => $color,
                        'folio_audiencia' => $rati->id,
                        'fecha' => $rati->fecha,
                        'estatus' => $rati->estatus,
                        'delegacion' => $rati->delegacion,
                        'usuario' => $userID,
                        'tipo' => $tipo,
                    ]
                ];
        }

        return response()->json($eventos);
    }

    public function exportarExcel()
    {
        //return Excel::download(new CitasExport, 'citas.xlsx');
        return Excel::download(new CitasExport, 'pagos.xlsx');
    }

}