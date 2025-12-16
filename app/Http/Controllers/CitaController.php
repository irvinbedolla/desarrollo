<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Pagos;
use App\Models\Recepcion;
use App\Models\Turnos;
use App\Models\User;
use App\Models\PermisosConciliador;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CitasExport;
use App\Models\SeerPerGeneral;

class CitaController extends Controller
{
    public function create()
    {
        return view('/calendar.crear_cita', [
            //'usuario' => User::all(),
            'estados' => Cita::ESTADOS,
            'tipos' => Cita::TIPOS
        ]);
    }

    /*public function eventos() {
        $citas = Cita::all();

        $eventos = [];
        foreach ($citas as $cita) {

            if ($cita->estatus === 'cancelada') {
                $color = '#DA0909';
            } elseif ($cita->estatus === 'pendiente') {
                $color = '#EAE300';
            } elseif ($cita->estatus === 'confirmada') {
                $color = '#00CE1C';
            } else {
                $color = '#CCCCCC';
            }

            $eventos[] = [
                'id' => $cita->id,
                'title' => $cita->motivo,
                'start' => $cita->fecha->format('Y-m-d') . 'T' . $cita->hora->format('H:i:s'),
                'extendedProps' => [
                    'hora' => $cita->hora->format('h:i A'),
                    'color' => $color,
                    'fecha' => $cita->fecha->format('d/m/Y'),
                    'estatus' => $cita->estatus,
                    'tipo' => $cita->tipo,
                    'usuario' => $cita->usuario,
                ]
            ];
        }

        return response()->json($eventos);
    }*/

    public function citas() {
        //$recepciones = Recepcion::all();
        $id_usuario = auth()->user()->id;
        $sede = Auth::user()->delegacion;
        $user = User::find($id_usuario);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();

        if ($userRole[0] == "Super Usuario" || $userRole[0] == "Administrador") {
            $recepciones = Pagos::join('turnos','turnos.id','pago_solicitud.id_solicitud')
            ->where('pago_solicitud.tipo_pago','Ratificacion')
            ->select('turnos.NUE','pago_solicitud.descripcion','pago_solicitud.hora','pago_solicitud.fecha','turnos.empresa'
            ,'pago_solicitud.nombre_trabajador','pago_solicitud.estatus','pago_solicitud.monto','pago_solicitud.observaciones',
            'pago_solicitud.id','pago_solicitud.id_solicitud','turnos.id_conciliador')
            ->selectRaw("CONCAT(turnos.trabajador, ' ', turnos.primero_trabajador, ' ', turnos.segundo_trabajador) as nombre_completo")
            ->get();
        }
        else if($userRole[0] == "Conciliador" || $userRole[0] == "Delegado" || $userRole[0] == "Enlace"){
            $tipo_conciliador = PermisosConciliador::where('id_conciliador',$id_usuario)->first();
            if(!empty($tipo_conciliador)){
                if($tipo_conciliador["tipo"] == "Ambos"){
                    //Validar la sede y agregar la oficina de apoyo
                    if($sede == "Morelia"){
                        $delegaciones = ['Morelia', 'Zitácuaro'];
                        $recepciones = Pagos::join('turnos','turnos.id','pago_solicitud.id_solicitud')
                        ->where('pago_solicitud.tipo_pago','Ratificacion')
                        ->whereIn('delegacion', $delegaciones)
                        ->select('turnos.NUE','pago_solicitud.descripcion','pago_solicitud.hora','pago_solicitud.fecha','turnos.empresa'
                        ,'pago_solicitud.nombre_trabajador','pago_solicitud.estatus','pago_solicitud.monto','pago_solicitud.observaciones',
                        'pago_solicitud.id','pago_solicitud.id_solicitud','turnos.id_conciliador')
                        ->selectRaw("CONCAT(turnos.trabajador, ' ', turnos.primero_trabajador, ' ', turnos.segundo_trabajador) as nombre_completo")
                        ->get();
                    }
                    else if($sede == "Uruapan"){
                        $delegaciones = ['Uruapan', 'Lázaro Cárdenas'];
                        $recepciones = Pagos::join('turnos','turnos.id','pago_solicitud.id_solicitud')
                        ->where('pago_solicitud.tipo_pago','Ratificacion')
                        ->whereIn('delegacion', $delegaciones)
                        ->select('turnos.NUE','pago_solicitud.descripcion','pago_solicitud.hora','pago_solicitud.fecha','turnos.empresa'
                        ,'pago_solicitud.nombre_trabajador','pago_solicitud.estatus','pago_solicitud.monto','pago_solicitud.observaciones',
                        'pago_solicitud.id','pago_solicitud.id_solicitud','turnos.id_conciliador')
                        ->selectRaw("CONCAT(turnos.trabajador, ' ', turnos.primero_trabajador, ' ', turnos.segundo_trabajador) as nombre_completo")
                        ->get();
                    }
                    else if($sede == "Zamora"){
                        $delegaciones = ['Zamora', 'Sahuayo'];
                        $recepciones = Pagos::join('turnos','turnos.id','pago_solicitud.id_solicitud')
                        ->where('pago_solicitud.tipo_pago','Ratificacion')
                        ->whereIn('delegacion', $delegaciones)
                        ->select('turnos.NUE','pago_solicitud.descripcion','pago_solicitud.hora','pago_solicitud.fecha','turnos.empresa'
                        ,'pago_solicitud.nombre_trabajador','pago_solicitud.estatus','pago_solicitud.monto','pago_solicitud.observaciones',
                        'pago_solicitud.id','pago_solicitud.id_solicitud','turnos.id_conciliador')
                        ->selectRaw("CONCAT(turnos.trabajador, ' ', turnos.primero_trabajador, ' ', turnos.segundo_trabajador) as nombre_completo")
                        ->get();
                    }
                }
            }
            else{
                $recepciones = Pagos::join('turnos','turnos.id','pago_solicitud.id_solicitud')
                ->where('pago_solicitud.tipo_pago','Ratificacion')
                ->where('pago_solicitud.delegacion', $user["delegacion"])
                ->select('turnos.NUE','pago_solicitud.descripcion','pago_solicitud.hora','pago_solicitud.fecha','turnos.empresa'
                ,'pago_solicitud.nombre_trabajador','pago_solicitud.estatus','pago_solicitud.monto','pago_solicitud.observaciones',
                'pago_solicitud.id','pago_solicitud.id_solicitud','turnos.id_conciliador')
                ->selectRaw("CONCAT(turnos.trabajador, ' ', turnos.primero_trabajador, ' ', turnos.segundo_trabajador) as nombre_completo")
                ->get();
            }
        }
        else{
            $recepciones = Pagos::where('tipo_pago','Ratificacion')
            ->where('delegacion', $user["delegacion"])
            ->get();
        }
        $tipo = 8;

        $eventos = [];
        foreach ($recepciones as $pago) {
            $turno = $pago->turno;
   
            $empresa_turno = $pago ? $pago->empresa : "S/E";
            $nombre_trabajador = $pago ? $pago->nombre_completo : "S/N";
            $tipo = 6;
            $conciliadorName = User::where('id', $pago->id_conciliador)->value('name') ?: '';

            if ($pago->estatus === 'Pendiente') {
                $color = '#EAE300';
            } elseif ($pago->estatus === 'Pagado') {
                $color = '#00CE1C';
            } elseif ($pago->estatus === 'Incomparecencia trabajador') {
                $color = '#FF2C2C';
            } else {
                $color = '#CCCCCC';
            }

            $eventos[] = [
                'id' => $pago->id,
                'title' => $pago->NUE,
                'start' => $pago->fecha->format('Y-m-d') . 'T' . $pago->hora->format('H:i:s'),
                'extendedProps' => [
                    'nue' => $pago->NUE,
                    'descripcion' => $pago->descripcion,
                    'hora' => $pago->hora->format('h:i A'),
                    'color' => $color,
                    'fecha' => $pago->fecha->format('d/m/Y'),
                    'empresa' => $empresa_turno,
                    'trabajador' => $nombre_trabajador,
                    'conciliador' => $conciliadorName,
                    'estatus' => $pago->estatus,
                    'monto' => $pago->monto,
                    'observaciones' => $pago->observaciones,
                    'tipo' => $tipo
                ]
            ];
        }

        return response()->json($eventos);

    }

    //Esta funcion se carga por defecto en el calendario
    public function pagos() {
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $sede = Auth::user()->delegacion;
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();

        if ($userRole[0] == "Super Usuario" || $userRole[0] == "Administrador") {
            $pagos = Pagos::where('tipo_pago','Audiencia')->get();
        }
        else if($userRole[0] == "Conciliador" || $userRole[0] == "Delegado" || $userRole[0] == "Enlace"){
            $tipo_conciliador = PermisosConciliador::where('id_conciliador',$id_usuario)->first();
            if(!empty($tipo_conciliador)){
                if($tipo_conciliador["tipo"] == "Ambos"){
                    //Validar la sede y agregar la oficina de apoyo
                    if($sede == "Morelia"){
                        $delegaciones = ['Morelia', 'Zitácuaro'];
                        $pagos = Pagos::where('tipo_pago','Audiencia')
                        ->whereIn('delegacion', $delegaciones)
                        ->get();
                    }
                    else if($sede == "Uruapan"){
                        $delegaciones = ['Uruapan', 'Lázaro Cárdenas'];
                        $pagos = Pagos::where('tipo_pago','Audiencia')
                        ->whereIn('delegacion', $delegaciones)
                        ->get();
                    }
                    else if($sede == "Zamora"){
                        $delegaciones = ['Zamora', 'Sahuayo'];
                        $pagos = Pagos::where('tipo_pago','Audiencia')
                        ->whereIn('delegacion', $delegaciones)
                        ->get();
                    }
                }
            }
            else{
                $pagos = Pagos::where('tipo_pago','Audiencia')
                ->where('delegacion', $user["delegacion"])
                ->get();
            }
        }
        else{
            $pagos = Pagos::where('tipo_pago','Audiencia')
            ->where('delegacion', $user["delegacion"])
            ->get();
        }

        $eventos = [];
        foreach ($pagos as $pago) {
            $turno = $pago->turno;
            $empresa_turno = $turno ? $turno->empresa : null;
            $nombre_turno = $turno ? $turno->trabajador : null;
            $primer_apellido_turno = $turno ? $turno->primero_trabajador : null;
            $segundo_apellido_turno = $turno ? $turno->segundo_trabajador : null;

            $tipo = 6;
            
            $conciliadorName = User::where('id', $pago->id_conciliador)->value('name') ?: '';

            if ($pago->estatus === 'Pendiente') {
                $color = '#EAE300';
            } elseif ($pago->estatus === 'Pagado') {
                $color = '#00CE1C';
            } elseif ($pago->estatus === 'Incomparecencia trabajador') {
                $color = '#FF2C2C';
            } else {
                $color = '#CCCCCC';
            }

            $eventos[] = [
                'id' => $pago->id,
                'title' => $pago->nombre_trabajador,
                'start' => $pago->fecha->format('Y-m-d') . 'T' . $pago->hora->format('H:i:s'),
                'extendedProps' => [
                    'nue' => $pago->NUE,
                    'descripcion' => $pago->descripcion,
                    'hora' => $pago->hora->format('h:i A'),
                    'color' => $color,
                    'fecha' => $pago->fecha->format('d/m/Y'),
                    'empresa' => $pago->empresa_representante,
                    'trabajador' => $pago->nombre_trabajador,
                    'conciliador' => $conciliadorName,
                    'estatus' => $pago->estatus,
                    'monto' => $pago->monto,
                    'observaciones' => $pago->observaciones,
                    'tipo' => $tipo
                ]
            ];
        }

        return response()->json($eventos);
    }

    public function conciliadores() {
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $sede = Auth::user()->delegacion;
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();

       if ($userRole[0] == "Super Usuario" || $userRole[0] == "Administrador") {
            $pagos = Pagos::where('tipo_pago','Conciliador')->get();
        }
        else if($userRole[0] == "Conciliador" || $userRole[0] == "Delegado"){
            $tipo_conciliador = PermisosConciliador::where('id_conciliador',$id_usuario)->first();
            if(!empty($tipo_conciliador)){
                if($tipo_conciliador["tipo"] == "Ambos"){
                    //Validar la sede y agregar la oficina de apoyo
                    if($sede == "Morelia"){
                        $delegaciones = ['Morelia', 'Zitácuaro'];
                        $pagos = Pagos::where('tipo_pago','Conciliador')
                        ->whereIn('delegacion', $delegaciones)
                        ->get();
                    }
                    else if($sede == "Uruapan"){
                        $delegaciones = ['Uruapan', 'Lázaro Cárdenas'];
                        $pagos = Pagos::where('tipo_pago','Conciliador')
                        ->whereIn('delegacion', $delegaciones)
                        ->get();
                    }
                    else if($sede == "Zamora"){
                        $delegaciones = ['Zamora', 'Sahuayo'];
                        $pagos = Pagos::where('tipo_pago','Conciliador')
                        ->whereIn('delegacion', $delegaciones)
                        ->get();
                    }
                }
            }else{
                $pagos = Pagos::where('tipo_pago','Conciliador')
                ->where('delegacion', $user["delegacion"])
                ->get();
            }
        }
        else{
            $pagos = Pagos::where('tipo_pago','Conciliador')
            ->where('delegacion', $user["delegacion"])
            ->get();
        }

        $eventos = [];
        foreach ($pagos as $pago) {
            $turno = $pago->turno;
            $empresa_turno = $turno ? $turno->empresa : null;
            $nombre_turno = $turno ? $turno->trabajador : null;
            $primer_apellido_turno = $turno ? $turno->primero_trabajador : null;
            $segundo_apellido_turno = $turno ? $turno->segundo_trabajador : null;

            $tipo = 6;

            $conciliadorName = User::where('id', $pago->id_conciliador)->value('name') ?: '';

            if ($pago->estatus === 'Pendiente') {
                $color = '#EAE300';
            } elseif ($pago->estatus === 'Pagado') {
                $color = '#00CE1C';
            } elseif ($pago->estatus === 'Incomparecencia trabajador') {
                $color = '#FF2C2C';
            } else {
                $color = '#CCCCCC';
            }

            $eventos[] = [
                'id' => $pago->id,
                'title' => $pago->nombre_trabajador,
                'start' => $pago->fecha->format('Y-m-d') . 'T' . $pago->hora->format('H:i:s'),
                'extendedProps' => [
                    'nue' => $pago->NUE,
                    'descripcion' => $pago->descripcion,
                    'hora' => $pago->hora->format('h:i A'),
                    'color' => $color,
                    'fecha' => $pago->fecha->format('d/m/Y'),
                    'empresa' => $pago->empresa_representante,
                    'trabajador' => $pago->nombre_trabajador,
                    'conciliador' => $conciliadorName,
                    'estatus' => $pago->estatus,
                    'monto' => $pago->monto,
                    'observaciones' => $pago->observaciones,
                    'tipo' => $tipo
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
