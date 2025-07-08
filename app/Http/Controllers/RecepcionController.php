<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth, Hash;
use App\Models\Recepcion;
use App\Models\TurnoDisponible;

class RecepcionController extends Controller
{   
    public function citas(){
        return view('turnos');
    }

    public function turnos_publico(Request $request){
        $data = $request->all();
        $fecha_actual = date('Y-m-d');
        $hora_actual  = date("H:i:s");
        $numero_consecutivo = 0;
        $consecutivo  = Recepcion::latest('id')->where('fecha', $fecha_actual)->first();

        if(empty($consecutivo)){
            $numero_consecutivo = 1;
        }
        else{
            $numero_consecutivo = $consecutivo["consecutivo"];
            $numero_consecutivo++;
        }

        if($data["orientacion"] == "Si" && $data["excepcion"] == "Si"){
            if($data["delegacion"] == "Morelia" || $data["delegacion"] == "Zitácuaro"){
                $data_insertar= array(
                    'consecutivo'   => $numero_consecutivo,
                    'fecha'         => $fecha_actual,
                    'hora'          => $hora_actual,
                    'hora_fin'      => $hora_actual,
                    'auxiliar'      => 13,
                    'tipo'          => $data["tipo"],
                    'lugar_auxiliar'=> "Departamento de Igualdad de Género",
                    'exepcion'      => $data["excepcion"],
                    'edad'          => $data["edad"],
                    'sexo'          => $data["sexo"],
                    'tipo_caso'     => $data["tipo_caso"],
                    'vulnerables'   => $data["vulnerables"],
                    'orientacion'   => $data["orientacion"],
                    'conflicto'     => $data["conflicto"],
                    'solicitante'   => $data["nombre"],
                    'estatus'       => "no atendido",
                    'delegacion'    => $data["delegacion"],
                );   
            }
            if($data["delegacion"] == "Uruapan" || $data["delegacion"] == "Lázaro Cárdenas"){
                $data_insertar= array(
                    'consecutivo'   => $numero_consecutivo,
                    'fecha'         => $fecha_actual,
                    'hora'          => $hora_actual,
                    'hora_fin'      => $hora_actual,
                    'auxiliar'      => 43,
                    'tipo'          => $data["tipo"],
                    'lugar_auxiliar'=> "Delegada Regional",
                    'exepcion'      => $data["excepcion"],
                    'edad'          => $data["edad"],
                    'sexo'          => $data["sexo"],
                    'tipo_caso'     => $data["tipo_caso"],
                    'vulnerables'   => $data["vulnerables"],
                    'orientacion'   => $data["orientacion"],
                    'conflicto'     => $data["conflicto"],
                    'solicitante'   => $data["nombre"],
                    'estatus'       => "no atendido",
                    'delegacion'    => $data["delegacion"],
                );
            }
            if($data["delegacion"] == "Zamora" || $data["delegacion"] == "Sahuayo"){
                $data_insertar= array(
                    'consecutivo'   => $numero_consecutivo,
                    'fecha'         => $fecha_actual,
                    'hora'          => $hora_actual,
                    'hora_fin'      => $hora_actual,
                    'auxiliar'      => 26,
                    'tipo'          => $data["tipo"],
                    'lugar_auxiliar'=> "Delegada Regional",
                    'exepcion'      => $data["excepcion"],
                    'edad'          => $data["edad"],
                    'sexo'          => $data["sexo"],
                    'tipo_caso'     => $data["tipo_caso"],
                    'vulnerables'   => $data["vulnerables"],
                    'orientacion'   => $data["orientacion"],
                    'conflicto'     => $data["conflicto"],
                    'solicitante'   => $data["nombre"],
                    'estatus'       => "no atendido",
                    'delegacion'    => $data["delegacion"],
                );
            }
        }
        else{
            $data_insertar= array(
                'consecutivo'   => $numero_consecutivo,
                'fecha'         => $fecha_actual,
                'hora'          => $hora_actual,
                'hora_fin'      => $hora_actual,
                'auxiliar'      => 0,
                'tipo'          => $data["tipo"],
                'lugar_auxiliar'=> "Recepción",
                'exepcion'      => $data["excepcion"],
                'edad'          => $data["edad"],
                'sexo'          => $data["sexo"],
                'tipo_caso'     => $data["tipo_caso"],
                'vulnerables'   => $data["vulnerables"],
                'orientacion'   => $data["orientacion"],
                'conflicto'     => $data["conflicto"],
                'solicitante'   => $data["nombre"],
                'estatus'       => "no atendido",
                'delegacion'    => $data["delegacion"],
            );    
        }
        
        Recepcion::create($data_insertar);
        
        return back()->with('success', 'Turno registrado correctamente favor de pasar al Módulo de Recepción.'); 
    }

    public function index_turnos()
    {
        $fecha_actual = date('Y-m-d');
        $relacionEloquent = 'roles';
        $id = auth()->user()->id;
        $user = User::find($id);

        $auxiliares = User::whereHas($relacionEloquent, function ($query) {
            return $query->where('name', '=', 'Auxiliar');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();

        $auxiliares_morelia = array();
        foreach($auxiliares as $auxiliar){
            $estatus = "Disponible";
            $ocupados = TurnoDisponible::where('fecha', $fecha_actual)
            ->where('id_auxiliar', $auxiliar["id"])
            ->select('turno_disponible.estatus')
            ->orderBy('id', 'DESC')
            ->get();

            if(!count($ocupados) == 0){
                $estatus = $ocupados[0]["estatus"];
            }
            $data_insertar = [
                'id'        => $auxiliar["id"],
                'name'      => $auxiliar["name"],
                'delegacion'=> $auxiliar["delegacion"],
                'estatus'   => $estatus,
            ];
            array_push($auxiliares_morelia, $data_insertar);
        }
        $total = count($auxiliares_morelia);

        return view('turnos.index',compact('auxiliares_morelia','total'));
    }

    public function create()
    {
        //Vamos a traer un usuario para asignarle los roles
        $id_usuario = Auth::id();
        return view('recepcion.crear', compact('id_usuario'));
    }

    public function store_turnos(Request $request)
    {
        $data = $request->all();
        $fecha_actual = date('Y-m-d');
        $hora_actual  = date("H:i:s");
        $numero_consecutivo = 0;
        $consecutivo  = Recepcion::latest('id')->where('fecha', $fecha_actual)->first();

        if(empty($consecutivo)){
            $numero_consecutivo = 1;
        }
        else{
            $numero_consecutivo = $consecutivo["consecutivo"];
            $numero_consecutivo++;
        }

        if($data["orientacion"] == "Si" && $data["excepcion"] == "Si"){
            if($data["delegacion"] == "Morelia" || $data["delegacion"] == "Zitácuaro"){
                $data_insertar= array(
                    'consecutivo'   => $numero_consecutivo,
                    'fecha'         => $fecha_actual,
                    'hora'          => $hora_actual,
                    'hora_fin'      => $hora_actual,
                    'auxiliar'      => 13,
                    'tipo'          => $data["tipo"],
                    'lugar_auxiliar'=> "Departamento de Igualdad de Género",
                    'exepcion'      => $data["excepcion"],
                    'edad'          => $data["edad"],
                    'sexo'          => $data["sexo"],
                    'tipo_caso'     => $data["tipo_caso"],
                    'vulnerables'   => $data["vulnerables"],
                    'orientacion'   => $data["orientacion"],
                    'conflicto'     => $data["conflicto"],
                    'solicitante'   => $data["nombre"],
                    'estatus'       => "no atendido",
                    'delegacion'    => $data["delegacion"],
                );   
            }
            if($data["delegacion"] == "Uruapan" || $data["delegacion"] == "Lázaro Cárdenas"){
                $data_insertar= array(
                    'consecutivo'   => $numero_consecutivo,
                    'fecha'         => $fecha_actual,
                    'hora'          => $hora_actual,
                    'hora_fin'      => $hora_actual,
                    'auxiliar'      => 43,
                    'tipo'          => $data["tipo"],
                    'lugar_auxiliar'=> "Delegada Regional",
                    'exepcion'      => $data["excepcion"],
                    'edad'          => $data["edad"],
                    'sexo'          => $data["sexo"],
                    'tipo_caso'     => $data["tipo_caso"],
                    'vulnerables'   => $data["vulnerables"],
                    'orientacion'   => $data["orientacion"],
                    'conflicto'     => $data["conflicto"],
                    'solicitante'   => $data["nombre"],
                    'estatus'       => "no atendido",
                    'delegacion'    => $data["delegacion"],
                );
            }
            if($data["delegacion"] == "Zamora" || $data["delegacion"] == "Sahuayo"){
                $data_insertar= array(
                    'consecutivo'   => $numero_consecutivo,
                    'fecha'         => $fecha_actual,
                    'hora'          => $hora_actual,
                    'hora_fin'      => $hora_actual,
                    'auxiliar'      => 26,
                    'tipo'          => $data["tipo"],
                    'lugar_auxiliar'=> "Delegada Regional",
                    'exepcion'      => $data["excepcion"],
                    'edad'          => $data["edad"],
                    'sexo'          => $data["sexo"],
                    'tipo_caso'     => $data["tipo_caso"],
                    'vulnerables'   => $data["vulnerables"],
                    'orientacion'   => $data["orientacion"],
                    'conflicto'     => $data["conflicto"],
                    'solicitante'   => $data["nombre"],
                    'estatus'       => "no atendido",
                    'delegacion'    => $data["delegacion"],
                );
            }
        }
        else{
            $data_insertar= array(
                'consecutivo'   => $numero_consecutivo,
                'fecha'         => $fecha_actual,
                'hora'          => $hora_actual,
                'hora_fin'      => $hora_actual,
                'auxiliar'      => 0,
                'tipo'          => $data["tipo"],
                'lugar_auxiliar'=> "Recepción",
                'exepcion'      => $data["excepcion"],
                'edad'          => $data["edad"],
                'sexo'          => $data["sexo"],
                'tipo_caso'     => $data["tipo_caso"],
                'vulnerables'   => $data["vulnerables"],
                'orientacion'   => $data["orientacion"],
                'conflicto'     => $data["conflicto"],
                'solicitante'   => $data["nombre"],
                'estatus'       => "no atendido",
                'delegacion'    => $data["delegacion"],
            );    
        }

        Recepcion::create($data_insertar);
        
        return redirect()->route('turnos');
    }

    public function turnos(){
        $id = auth()->user()->id;
        $user = User::find($id);
        $fecha_actual = date('Y-m-d');

        $turnos = DB::table('recepcion')
        ->where('recepcion.fecha', $fecha_actual)
        ->where('recepcion.delegacion', $user["delegacion"])
        ->where('recepcion.estatus','no atendido')
        ->leftjoin('users', 'users.id', '=', 'recepcion.auxiliar')
        ->select('users.name','recepcion.id','recepcion.solicitante','recepcion.fecha','recepcion.hora','recepcion.estatus','recepcion.tipo','recepcion.exepcion')
        ->get();

        return view('turnos.turnos',compact('turnos'));
    }

    public function activo($id)
    {
        $fecha_actual = date('Y-m-d');

        $ocupados = TurnoDisponible::where('fecha', $fecha_actual)
        ->where('id_auxiliar', $id)
        ->get();
        /*
        //Si existe voy actualizar
        if(!count($ocupados) == 0){
            $data_update = DB::table('turno_disponible')
            ->where('id_auxiliar', $id)
            ->update(['estatus' => 'Disponible']);
            if($id == 3 || $id == 5 || $id ==7 ){
                $ocupados = Turnos::where('fecha', $fecha_actual)
                ->where('auxiliar', 0)
                ->where('tipo', 'Solicitud')
                ->orderBy('id', 'asc')
                ->first();
                //Si hay fila se va asiganar el primero de la fila al axulilar librre
                if(!empty($ocupados)){
                    $id_turno = $ocupados["id"];

                    //Relacion auxiliar con usuario
                    switch($IDauxiliar){
                        case 6: 
                            //Erandi
                            $lugar_auxiliar = "Auxiliar 1";
                            break;
                        case 10: 
                            //Rosario
                            $lugar_auxiliar = "Auxiliar 2";
                            break;
                        case 8: 
                            //Mayra
                            $lugar_auxiliar = "Auxiliar 3";
                            break;
                        case 9: 
                            //Luis
                            $lugar_auxiliar = "Auxiliar 4";
                            break;
                        case 3: 
                            //Yessiu
                            $lugar_auxiliar = "Auxiliar 5";
                            break;
                        case 7: 
                            //Clever
                            $lugar_auxiliar = "Auxiliar 6";
                            break;
                        case 5: 
                            //Sandra
                            $lugar_auxiliar = "Auxiliar 7";
                            break;
                        default:
                            $lugar_auxiliar = "Pendiente";
                            break;
                    }
                    
                    $turno_update= array(
                        'auxiliar'       => $IDauxiliar,
                        'lugar_auxiliar' => $lugar_auxiliar
                    );
                    $disponible_update= array(
                        'estatus'       => 'Ocupado'
                    );

                    $turno = Turnos::find($id_turno);
                    $turno->update($turno_update);

                    $persona = DB::table('turno_disponible')
                    ->where('id_auxiliar', $IDauxiliar)
                    ->where('fecha', $fecha_actual)
                    ->update(['estatus' => 'Ocupado']);
                }
            }
            else{
                $ocupados = Turnos::where('fecha', $fecha_actual)
                ->where('auxiliar', 0)
                ->orderBy('id', 'asc')
                ->first();
                //Si hay fila se va asiganar el primero de la fila al axulilar librre
                if(!empty($ocupados)){
                    $id_turno = $ocupados["id"];

                    //Relacion auxiliar con usuario
                    switch($IDauxiliar){
                        case 6: 
                            //Erandi
                            $lugar_auxiliar = "Auxiliar 5";
                            break;
                        case 10: 
                            //Rosario
                            $lugar_auxiliar = "Auxiliar 2";
                            break;
                        case 8: 
                            //Mayra
                            $lugar_auxiliar = "Auxiliar 3";
                            break;
                        case 9: 
                            //Luis
                            $lugar_auxiliar = "Auxiliar 4";
                            break;
                        case 3: 
                            //Yessiu
                            $lugar_auxiliar = "Auxiliar 5";
                            break;
                        case 7: 
                            //Clever
                            $lugar_auxiliar = "Auxiliar 6";
                            break;
                        case 5: 
                            //Sandra
                            $lugar_auxiliar = "Auxiliar 7";
                            break;
                        default:
                            $lugar_auxiliar = "Pendiente";
                            break;
                    }
                    
                    $turno_update= array(
                        'auxiliar'       => $IDauxiliar,
                        'lugar_auxiliar' => $lugar_auxiliar
                    );
                    $disponible_update= array(
                        'estatus'       => 'Ocupado'
                    );

                    $turno = Turnos::find($id_turno);
                    $turno->update($turno_update);

                    $persona = DB::table('turno_disponible')
                    ->where('id_auxiliar', $IDauxiliar)
                    ->where('fecha', $fecha_actual)
                    ->update(['estatus' => 'Ocupado']);
                }
            }
        }
        */       
        $data_update = DB::table('turno_disponible')
        ->where('id_auxiliar', $id)
        ->update(['estatus' => 'Disponible']);
        return redirect()->route('turnos');
    }

    public function noactivo($id)
    {
        $fecha_actual = date('Y-m-d');
        $hora_actual  = date("H:i:s");
        /*
        $ocupados = TurnoDisponible::where('fecha', $fecha_actual)
        ->where('id_auxiliar', $id)
        ->get();

        if(count($ocupados) == 0){
            $data_insertar_disponible= array(
                'id_auxiliar'   => $id,
                'fecha'         => $fecha_actual,
                'hora'          => $hora_actual,
                'estatus'       => 'Ocupado'
            );
            TurnoDisponible::create($data_insertar_disponible);
        }else{
            $data_update = DB::table('turno_disponible')
            ->where('id_auxiliar', $id)
            ->update(['estatus' => 'Ocupado']);
        }
        */
        $data_update = DB::table('turno_disponible')
        ->where('id_auxiliar', $id)
        ->update(['estatus' => 'Ocupado']);

        return redirect()->route('turnos');
    }

        public function cambiar($id)
    {
        $fecha_actual = date('Y-m-d');
        $hora_actual  = date("H:i:s");
        $id_user = auth()->user()->id;
        $user = User::find($id_user);

        //Se actualizan los estatus
        $turno              = Recepcion::find($id);
        $IDauxiliar         = $turno["auxiliar"];
        
        $disponibles     = TurnoDisponible::where('fecha', $fecha_actual)->where('estatus', 'Disponible')->get();
        $listado_ocupados   = array();
        $listado_auxiliares = array();
        $relacionEloquent = 'roles';
        $usuariosauxiliares = User::whereHas($relacionEloquent, function ($query) {
            return $query->where('name', '=', 'Auxiliar');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();
        
        foreach($usuariosauxiliares as $token ){
            //Validar que solo sea morelia
            array_push($listado_auxiliares, $token["id"]);
        }
        //validar si hay disponibles
        $random = array_rand($listado_auxiliares);
        $nombre_usuario = User::find($listado_auxiliares[$random]);
        $lugar_auxiliar = $nombre_usuario["name"];

        $turno_update= array(
            'hora_fin'      =>  $hora_actual,
            'auxiliar'      =>  $listado_auxiliares[$random],
            'lugar_auxiliar'=>  $lugar_auxiliar
        );
        $disponible_update= array(
            'estatus'       => 'Disponible'
        );

        $turno->update($turno_update);
        $turno_disponible   = TurnoDisponible::where('id_auxiliar', $IDauxiliar)->where('fecha', $fecha_actual)->first();
        if($turno_disponible != null){
            $turno_disponible->update($disponible_update);
        }
        
        return redirect()->route('turnos.listado');
    }

    public function misturnos(){
        $id = auth()->user()->id;

        /////Validar si es auxiliar o exepcion /////
        $misturnos = Recepcion::where('auxiliar', $id)
        ->where('estatus', 'no atendido')
        ->get();

        return view('turnos.misturnos',compact('misturnos'));
    }

    public function terminado_confirmar($id){
        $turno = Recepcion::find($id);
        return view('turnos.confirmar', compact('turno'));
    }

    public function cambio($id){
        $id_user = auth()->user()->id;
        $user = User::find($id_user);

        $relacionEloquent = 'roles';
        $usuariosauxiliares = User::whereHas($relacionEloquent, function ($query) {
            return $query->where('name', '=', 'Excepcion');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();

        $turno_update= array(
            'auxiliar'      =>  $usuariosauxiliares[0]["id"],
            'lugar_auxiliar'=> "Departamento de Igualdad de Género"
        );

        $turno = Recepcion::find($id);
        $turno->update($turno_update);

        return redirect()->route('misturnos');
    }

    public function terminado($id)
    {
        // $id es la variable de la tabla de turnos
        //Obtenemos el id de del auxiliar que esta terminado el turno 
        $turnos = Recepcion::where('id', $id)->first();
        $IDauxiliar = $turnos["auxiliar"];
       
        $fecha_actual = date('Y-m-d');
        $hora_actual  = date("H:i:s");

        $turno_update= array(
            'hora_fin'      =>  $hora_actual,
            'estatus'       => 'atendido'
        );
        $disponible_update= array(
            'estatus'       => 'Disponible'
        );

        //Se actualizan los estatus
        $turno = Recepcion::find($id);
        $turno->update($turno_update);

        $persona = DB::table('turno_disponible')
        ->where('id_auxiliar', $IDauxiliar)
        ->where('fecha', $fecha_actual)
        ->update(['estatus' => 'Disponible']);

        //Se va buscar en fila si existe algun otro y se va asiganar
        if($turnos["exepcion"] == "Si"){
            $user = User::find($IDauxiliar);

            $relacionEloquent = 'roles';
            $usuariosauxiliares = User::whereHas($relacionEloquent, function ($query) {
                return $query->where('name', '=', 'Excepcion');
            })
            ->where('delegacion', $user["delegacion"])
            ->get();
            
            $turno_update= array(
                'auxiliar'       => $usuariosauxiliares[0]["id"],
                'lugar_auxiliar' => "Departamento de casos de Excepción"
            );
            $disponible_update= array(
                'estatus'       => 'Ocupado'
            );

            $turno = Recepcion::find($id);
            $turno->update($turno_update);

            $persona = DB::table('turno_disponible')
            ->where('id_auxiliar', $usuariosauxiliares[0]["id"])
            ->where('fecha', $fecha_actual)
            ->update(['estatus' => 'Ocupado']);
        }
        else{
            $ocupados = Recepcion::where('fecha', $fecha_actual)
            ->where('auxiliar', 0)
            ->orderBy('id', 'asc')->first();
            //Si hay fila se va asiganar el primero de la fila al axulilar libre
            if(!empty($ocupados)){
                $id_turno = $ocupados["id"];

                $lugar_auxiliar = "Pendiente";
                
                $turno_update= array(
                    'auxiliar'       => 0,
                    'lugar_auxiliar' => $lugar_auxiliar
                );
                $disponible_update= array(
                    'estatus'       => 'Ocupado'
                );

                $turno = Recepcion::find($id_turno);
                $turno->update($turno_update);
            }
        }

        return redirect()->route('misturnos');
    }

    public function edit(Request $request){
        $data = $request->all();
        $id_user = auth()->user()->id;
        $user = User::find($id_user);
        $fecha_actual = date('Y-m-d');

        

        if($data["resultado"] == "Solicitud"){
            $turno_update= array(
                'solicitante'   => $data["nombre"],
                'motivo'        => $data["motivo"],
                'excepcion'     => $data["excepcion"],
                'tipo_caso'     => $data["tipo_caso"],
                'vulnerables'   => $data["vulnerables"],
                'folio'         => $data["folio"],
                //'tarjeta'       => $data["tarjeta"],
                'auxiliar'      => 0,
                'resultado'     => $data["resultado"]
            );
        }else if($data["resultado"] == "Canaliza"){
            $turno_update= array(
                'solicitante'   => $data["nombre"],
                'motivo'        => $data["motivo"],
                'excepcion'     => $data["excepcion"],
                'tipo_caso'     => $data["tipo_caso"],
                'vulnerables'   => $data["vulnerables"],
                'INS'           => $data["INS"],
                'estatus'       => "atendido",
                'resultado'     => $data["resultado"]
            );
        }else{
            $turno_update= array(
                'solicitante'   => $data["nombre"],
                //'tarjeta'       => $data["tarjeta"],
                'estatus'       => "atendido",
                'resultado'     => $data["resultado"]
            );
        }

        $turno = Recepcion::find($data["id"])->update($turno_update);

        return redirect()->route('misturnos');
    }

    public function index_tarjeta(){
        $id = auth()->user()->id;

        $misturnos = Recepcion::where('auxiliar', $id)
        ->where('estatus', 'atendido')
        ->where('exepcion','Si')
        ->where('tarjeta',NULL)
        ->get();

        return view('recepcion/index',compact('misturnos'));
    }

    public function tarjeta_crear($id){
        $tarjeta = Recepcion::find($id);

        return view('recepcion/tarjeta',compact('tarjeta'));
    }
}