<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
//use Illuminate\Routing\Controller as BaseController;
/*
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SeerChatP; 
use App\Models\SeerChatR; 
use App\Models\SeerChatRP;
*/

//use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Turnos;
use App\Models\TurnoDisponible;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;


class TurnosController extends Controller
{
    
    public function index()
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
        return view('turnos.crear', compact('id_usuario'));
    }

    public function store_turnos(Request $request)
    {
        $data = $request->all();
        $id = auth()->user()->id;
        $user = User::find($id);
        $relacionEloquent = 'roles';
        request()->validate([
            'nombre' => 'required',
            'tipo' => 'required',
        ], $data);

        $fecha_actual = date('Y-m-d');
        $hora_actual  = date("H:i:s");
        $numero_consecutivo = 0;
        $data["sede"] = $user["delegacion"];
        $consecutivo  = Turnos::latest('id')
        ->where('fecha', $fecha_actual)
        ->first();


        if(empty($consecutivo)){
            $numero_consecutivo = 1;
        }
        else{
            $numero_consecutivo = $consecutivo["consecutivo"];
            $numero_consecutivo++;
        }

        //Validar la hora
        switch($hora_actual){
            case $hora_actual < "09:00:00" :
                $hora_solicitud = "09:00:00";
                break;
            case ($hora_actual < "10:00:00" && $hora_actual > "09:00:00"):
                $hora_solicitud = "10:00:00";
                break;
            case ($hora_actual < "11:00:00" && $hora_actual > "10:00:00"):
                $hora_solicitud = "11:00:00";
                break;
            case ($hora_actual < "12:00:00" && $hora_actual > "11:00:00"):
                $hora_solicitud = "12:00:00";
                break;
            case ($hora_actual < "13:00:00" && $hora_actual > "12:00:00"):
                $hora_solicitud = "13:00:00";
                break;
            case ($hora_actual < "14:00:00" && $hora_actual > "13:00:00"):
                $hora_solicitud = "14:00:00";
                break;
            default:
                $hora_solicitud = "15:00:00";
                break;
        }

        //Vamos a contar cuandos auxiliares existen en el CCL
        $usuariosauxiliares = User::whereHas($relacionEloquent, function ($query) {
            return $query->where('name', '=', 'Auxiliar');
        })
        ->where('delegacion', $data["sede"])
        ->get();

        $numero_citas_sede = count($usuariosauxiliares);
        $bandera_cerrar = 0;
        //Vamos a ver cuantos citas hay en ese horario por sede
        $fecha_revisar = $fecha_actual;
        for($i=0;$i < 5;$i++){
            if($bandera_cerrar == 1){
                echo "cerrar";
                break; 
            }
            //echo $hora_solicitud."- "; 
            //dd($hora_solicitud."- ".$fecha_revisar);
            //Validar si existe un horario mas
            switch($hora_solicitud){
                //Si los turnos de las 9 ya estan ocupados vamos a revisar a las 10
                case ($hora_solicitud == "09:00:00") :
                    $numero_citas = Turnos::where('fecha', $fecha_revisar)
                    ->where('hora', $hora_solicitud)
                    ->where('delegacion', $data["sede"])->get();

                    if($numero_citas_sede > count($numero_citas)){
                        $data_insertar= array(
                            'consecutivo'   => $numero_consecutivo,
                            'solicitante'   => $data["nombre"],
                            'auxiliar'      => 0,
                            'lugar_auxiliar'=> "Recepción",
                            'tipo'          => $data["tipo"],
                            'fecha'         => $fecha_revisar,
                            'hora'          => $hora_solicitud,
                            'hora_fin'      => $hora_actual,
                            'delegacion'    => $data["sede"],
                            'estatus'       => "no atendido",
                            'exepcion'      => "No",
                            'edad'          => $data["edad"],
                            'sexo'          => $data["sexo"],
                        );    
                        Turnos::create($data_insertar);
                        $bandera_cerrar = 1;
                        break;
                    }
                    else{
                        $hora_solicitud = "10:00:00";
                    }
                case ($hora_solicitud == "10:00:00"):
                    $numero_citas = Turnos::where('fecha', $fecha_revisar)
                    ->where('hora', $hora_solicitud)
                    ->where('delegacion', $data["sede"])->get();
                    if($numero_citas_sede > count($numero_citas)){
                        $data_insertar= array(
                            'consecutivo'   => $numero_consecutivo,
                            'solicitante'   => $data["nombre"],
                            'auxiliar'      => 0,
                            'lugar_auxiliar'=> "Recepción",
                            'tipo'          => $data["tipo"],
                            'fecha'         => $fecha_revisar,
                            'hora'          => $hora_solicitud,
                            'hora_fin'      => $hora_actual,
                            'delegacion'    => $data["sede"],
                            'estatus'       => "no atendido",
                            'exepcion'      => "No",
                            'edad'          => $data["edad"],
                            'sexo'          => $data["sexo"],
                        );    
                        $bandera_cerrar = 1;
                        Turnos::create($data_insertar);
                        break;
                    }
                    else{
                        $hora_solicitud = "11:00:00";
                    }
                case ($hora_solicitud == "11:00:00"):
                    $numero_citas = Turnos::where('fecha', $fecha_revisar)
                    ->where('hora', $hora_solicitud)
                    ->where('delegacion', $data["sede"])->get();
                    if($numero_citas_sede > count($numero_citas)){
                        $data_insertar= array(
                            'consecutivo'   => $numero_consecutivo,
                            'solicitante'   => $data["nombre"],
                            'auxiliar'      => 0,
                            'lugar_auxiliar'=> "Recepción",
                            'tipo'          => $data["tipo"],
                            'fecha'         => $fecha_revisar,
                            'hora'          => $hora_solicitud,
                            'hora_fin'      => $hora_actual,
                            'delegacion'    => $data["sede"],
                            'estatus'       => "no atendido",
                            'exepcion'      => "No",
                            'edad'          => $data["edad"],
                            'sexo'          => $data["sexo"],
                        );    
                        $bandera_cerrar = 1;
                        Turnos::create($data_insertar);
                        break;
                    }
                    else{
                        $hora_solicitud = "12:00:00";
                    }
                case ($hora_solicitud == "12:00:00"):
                    $numero_citas = Turnos::where('fecha', $fecha_revisar)
                    ->where('hora', $hora_solicitud)
                    ->where('delegacion', $data["sede"])->get();
                    if($numero_citas_sede > count($numero_citas)){
                        $data_insertar= array(
                            'consecutivo'   => $numero_consecutivo,
                            'solicitante'   => $data["nombre"],
                            'auxiliar'      => 0,
                            'lugar_auxiliar'=> "Recepción",
                            'tipo'          => $data["tipo"],
                            'fecha'         => $fecha_revisar,
                            'hora'          => $hora_solicitud,
                            'hora_fin'      => $hora_actual,
                            'delegacion'    => $data["sede"],
                            'estatus'       => "no atendido",
                            'exepcion'      => "No",
                            'edad'          => $data["edad"],
                            'sexo'          => $data["sexo"],
                        );    
                        $bandera_cerrar = 1;
                        Turnos::create($data_insertar);
                        break;
                    }
                    else{
                        $hora_solicitud = "13:00:00";
                    }
                case ($hora_solicitud == "13:00:00"):
                    $numero_citas = Turnos::where('fecha', $fecha_revisar)
                    ->where('hora', $hora_solicitud)
                    ->where('delegacion', $data["sede"])->get();
                    if($numero_citas_sede > count($numero_citas)){
                        $data_insertar = array(
                            'consecutivo'   => $numero_consecutivo,
                            'solicitante'   => $data["nombre"],
                            'auxiliar'      => 0,
                            'lugar_auxiliar'=> "Recepción",
                            'tipo'          => $data["tipo"],
                            'fecha'         => $fecha_revisar,
                            'hora'          => $hora_solicitud,
                            'hora_fin'      => $hora_actual,
                            'delegacion'    => $data["sede"],
                            'estatus'       => "no atendido",
                            'exepcion'      => "No",
                            'edad'          => $data["edad"],
                            'sexo'          => $data["sexo"],
                        );    
                        $bandera_cerrar = 1;
                        Turnos::create($data_insertar);
                        break;
                    }
                    else{
                        $hora_solicitud = "14:00:00";
                    }
                case ($hora_solicitud == "14:00:00"):
                    $numero_citas = Turnos::where('fecha', $fecha_revisar)
                    ->where('hora', $hora_solicitud)
                    ->where('delegacion', $data["sede"])->get();
                    //dd(count($numero_citas));
                    if($numero_citas_sede > count($numero_citas)){
                        $data_insertar = array(
                            'consecutivo'   => $numero_consecutivo,
                            'solicitante'   => $data["nombre"],
                            'auxiliar'      => 0,
                            'lugar_auxiliar'=> "Recepción",
                            'tipo'          => $data["tipo"],
                            'fecha'         => $fecha_revisar,
                            'hora'          => $hora_solicitud,
                            'hora_fin'      => $hora_actual,
                            'delegacion'    => $data["sede"],
                            'estatus'       => "no atendido",
                            'exepcion'      => "No",
                            'edad'          => $data["edad"],
                            'sexo'          => $data["sexo"],
                        );  
                        Turnos::create($data_insertar);
                        $bandera_cerrar = 1;
                        break;
                    }
                    else{
                        $hora_solicitud = "15:00:00";
                    }
                    //Si ya es el ultimo horario tengo que mandar al otro dia
                default:
                    //Ya son las 3 de la tarde o mas
                    //Actualizo la fecha
                    $fechasuma = strtotime('+1 day', strtotime($fecha_revisar)); 
                    $fecha = date('l', strtotime($fechasuma));

                    if ($fecha == 'Saturday') {
                        $fechasuma = strtotime('+2 day', strtotime($fecha_revisar)); 
                        $fecha_revisar = date('Y-m-d', $fechasuma);
                        $hora_solicitud = "09:00:00";
                    }
                    else{
                        $fecha_revisar = date('Y-m-d', $fechasuma);
                        $hora_solicitud = "09:00:00";
                    }
            }
        }

        return redirect()->route('turnos');
    }

    public function activo($id)
    {
        $fecha_actual = date('Y-m-d');

        $ocupados = TurnoDisponible::where('fecha', $fecha_actual)
        ->where('id_auxiliar', $id)
        ->get();

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
        
        return redirect()->route('turnos');
    }

    public function noactivo($id)
    {
        $fecha_actual = date('Y-m-d');
        $hora_actual  = date("H:i:s");

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

        return redirect()->route('turnos');
    }

    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return redirect()->route('usuarios');
    }

    public function misturnos(){
        $id = auth()->user()->id;
        //$fecha_actual = date('Y-m-d');

        /////Validar si es auxiliar o exepcion /////
        $misturnos = Turnos::where('auxiliar', $id)
        ->where('estatus', 'no atendido')
        ->get();

        return view('turnos.misturnos',compact('misturnos'));
    }

    public function terminado($id)
    {
        // $id es la variable de la tabla de turnos
        //Obtenemos el id de del auxiliar que esta terminado el turno 
        $turnos = Turnos::where('id', $id)->first();
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
        $turno = Turnos::find($id);
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

            $turno = Turnos::find($id);
            $turno->update($turno_update);

            $persona = DB::table('turno_disponible')
            ->where('id_auxiliar', $usuariosauxiliares[0]["id"])
            ->where('fecha', $fecha_actual)
            ->update(['estatus' => 'Ocupado']);
        }
        else if($id == 3 || $id == 5 || $id ==7 ){
            $ocupados = Turnos::where('fecha', $fecha_actual)
            ->where('auxiliar', 0)
            ->where('tipo', 'Solicitud')
            ->orderBy('id', 'asc')->first();
            //Si hay fila se va asiganar el primero de la fila al axulilar libre
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
        else{
            $ocupados = Turnos::where('fecha', $fecha_actual)
            ->where('auxiliar', 0)
            ->orderBy('id', 'asc')->first();
            //Si hay fila se va asiganar el primero de la fila al axulilar libre
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

        return redirect()->route('misturnos');
    }

    public function turnos(){
        $id = auth()->user()->id;
        $user = User::find($id);
        $fecha_actual = date('Y-m-d');

        $turnos = DB::table('turnos')
        ->where('turnos.fecha', $fecha_actual)
        ->where('turnos.delegacion', $user["delegacion"])
        ->where('turnos.estatus','no atendido')
        ->leftjoin('users', 'users.id', '=', 'turnos.auxiliar')
        ->select('users.name','turnos.id','turnos.solicitante','turnos.fecha','turnos.hora','turnos.estatus','turnos.tipo','turnos.exepcion')
        ->get();

        
        return view('turnos.turnos',compact('turnos'));
    }

    public function estadistica(){
        $id = auth()->user()->id;
        $user = User::find($id);

        $auxiliares = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Auxiliar');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();

        return view('turnos.estadistica',compact('auxiliares'));
    }

    public function mostrar(Request $request){
        //Voy a recibir todos los parametros en voy a realizar la consulta y mostrar los datos
        $data = $request->all();

        request()->validate([
            'fecha_inicial' => 'required|date',
            'fecha_final'   => 'required|date',
        ], $data);

        $id = auth()->user()->id;
        $user = User::find($id);


        if($data["auxiliares"] == "" && $data["tipo"] == ""){
            $suma_turnos = DB::table('turnos')
            ->where("turnos.fecha",">=",$data["fecha_inicial"])
            ->where('turnos.fecha',"<=", $data["fecha_final"])
            ->where('turnos.delegacion', $user["delegacion"])
            ->selectRaw('count(id) as total')
            ->first();

            $turnos = Turnos::where("turnos.fecha",">=",$data["fecha_inicial"])
            ->where('turnos.fecha',"<=", $data["fecha_final"])
            ->where('turnos.delegacion', $user["delegacion"])
            ->leftjoin('users', 'users.id', '=', 'turnos.auxiliar')
            ->select('users.name','turnos.id','turnos.solicitante','turnos.fecha','turnos.hora','turnos.estatus','turnos.tipo','turnos.hora_fin','turnos.updated_at')
            ->get();

            
        }
        //Solo se agrego el auxiliar
        else if($data["auxiliares"] != "" && $data["tipo"] == ""){
            $suma_turnos = DB::table('turnos')
            ->where("turnos.fecha",">=",$data["fecha_inicial"])
            ->where('turnos.fecha',"<=", $data["fecha_final"])
            ->where('turnos.auxiliar',$data["auxiliares"])
            ->where('turnos.delegacion', $user["delegacion"])
            ->selectRaw('count(id) as total')
            ->first();


            $turnos = Turnos::
            where("turnos.fecha",">=",$data["fecha_inicial"])
            ->where('turnos.fecha',"<=", $data["fecha_final"])
            ->where('turnos.auxiliar',$data["auxiliares"])
            ->where('turnos.delegacion', $user["delegacion"])
            ->leftjoin('users', 'users.id', '=', 'turnos.auxiliar')
            ->select('users.name','turnos.id','turnos.solicitante','turnos.fecha','turnos.hora','turnos.estatus','turnos.tipo','turnos.hora_fin','turnos.updated_at')
            ->get();
        }
        else if($data["auxiliares"] == "" && $data["tipo"] != ""){
            if($data["tipo"] == "exepcion"){
                $suma_turnos = DB::table('turnos')
                ->where("turnos.fecha",">=",$data["fecha_inicial"])
                ->where('turnos.fecha',"<=", $data["fecha_final"])
                ->where('turnos.exepcion',"Si")
                ->where('turnos.delegacion', $user["delegacion"])
                ->selectRaw('count(id) as total')
                ->first();

                $turnos = Turnos::
                where("turnos.fecha",">=",$data["fecha_inicial"])
                ->where('turnos.fecha',"<=", $data["fecha_final"])
                ->where('turnos.exepcion',"Si")
                ->where('turnos.delegacion', $user["delegacion"])
                ->leftjoin('users', 'users.id', '=', 'turnos.auxiliar')
                ->select('users.name','turnos.id','turnos.solicitante','turnos.fecha','turnos.hora','turnos.estatus','turnos.tipo','turnos.hora_fin','turnos.updated_at')
                ->get();
            }
            else{
                $suma_turnos = DB::table('turnos')
                ->where("turnos.fecha",">=",$data["fecha_inicial"])
                ->where('turnos.fecha',"<=", $data["fecha_final"])
                ->where('turnos.tipo',$data["tipo"])
                ->where('turnos.delegacion', $user["delegacion"])
                ->selectRaw('count(id) as total')
                ->first();


                $turnos = Turnos::
                where("turnos.fecha",">=",$data["fecha_inicial"])
                ->where('turnos.fecha',"<=", $data["fecha_final"])
                ->where('turnos.tipo',$data["tipo"])
                ->where('turnos.delegacion', $user["delegacion"])
                ->leftjoin('users', 'users.id', '=', 'turnos.auxiliar')
                ->select('users.name','turnos.id','turnos.solicitante','turnos.fecha','turnos.hora','turnos.estatus','turnos.tipo','turnos.hora_fin','turnos.updated_at')
                ->get();
            }
        }
        else{
            $suma_turnos = DB::table('turnos')
            ->where("turnos.fecha",">=",$data["fecha_inicial"])
            ->where('turnos.fecha',"<=", $data["fecha_final"])
            ->where('turnos.tipo',$data["tipo"])
            ->where('turnos.auxiliar',$data["auxiliares"])
            ->where('turnos.delegacion', $user["delegacion"])
            ->selectRaw('count(id) as total')
            ->first();


            $turnos = Turnos::
            where("turnos.fecha",">=",$data["fecha_inicial"])
            ->where('turnos.fecha',"<=", $data["fecha_final"])
            ->where('turnos.tipo',$data["tipo"])
            ->where('turnos.auxiliar',$data["auxiliares"])
            ->where('turnos.delegacion', $user["delegacion"])
            ->leftjoin('users', 'users.id', '=', 'turnos.auxiliar')
            ->select('users.name','turnos.id','turnos.solicitante','turnos.fecha','turnos.hora','turnos.estatus','turnos.tipo','turnos.hora_fin','turnos.updated_at')
            ->get();
        }

        return view('turnos.mostrar',compact('turnos','suma_turnos'));        
    }

    public function cambiar($id)
    {
        $fecha_actual = date('Y-m-d');
        $hora_actual  = date("H:i:s");
        $id_user = auth()->user()->id;
        $user = User::find($id_user);

        //Se actualizan los estatus
        $turno              = Turnos::find($id);
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

    public function terminado_confirmar($id){
        $turno = Turnos::find($id);
        return view('turnos.confirmar', compact('turno'));
    }

    public function edit(Request $request)
    {
        $data = $request->all();
        $id_user = auth()->user()->id;
        $user = User::find($id_user);
        $fecha_actual = date('Y-m-d');

        $relacionEloquent = 'roles';
        $usuariosauxiliares = User::whereHas($relacionEloquent, function ($query) {
            return $query->where('name', '=', 'Excepcion');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();

        $turno_update= array(
            'solicitante'   => $data["nombre"],
            'tipo'          => $data["tipo"],
            'edad'          => $data["edad"],
            'sexo'          => $data["sexo"],
            'conflicto'     => $data["conflicto"],
            'vulnerables'   => $data["vulnerables"],
            'estatus'       => "atendido"
        );

        $turno = Turnos::find($data["id"]);
        $turno->update($turno_update);

        
        $persona = DB::table('turno_disponible')
        ->where('id_auxiliar', $usuariosauxiliares[0]["id"])
        ->where('fecha', $fecha_actual)
        ->update(['estatus' => 'Ocupado']);



        return redirect()->route('misturnos');
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

        $turno = Turnos::find($id);
        $turno->update($turno_update);

        return redirect()->route('misturnos');
    }

    public function create_publico(){
        return view('citas');
    }

    public function store_publico(Request $request)
    {
        $data = $request->all();

        request()->validate([
            'nombre'    => 'required',
            'edad'      => 'required|numeric',
            'sexo'      => 'required|in:H,M,NB,LGBTTTIQ',
            'conflicto' => 'required',
            'sede'      => 'required',
            'tipo'      => 'required',
            'fecha'     => 'required',
            'hora'      => 'required',
        ], $data);

        //Vamos a buscar la proxima fecha disponible de la sede
        $numero_consecutivo = 0;
        $consecutivo  = Turnos::latest('id')
        ->where('fecha', $data["fecha"])
        ->first();
        
        if(empty($consecutivo)){
            $numero_consecutivo = 1;
        }
        else{
            $numero_consecutivo = $consecutivo["consecutivo"];
            $numero_consecutivo++;
        }

        $data_insertar= array(
            'consecutivo'   => $numero_consecutivo,
            'solicitante'   => $data["nombre"],
            'auxiliar'      => 0,
            'lugar_auxiliar'=> "Recepción",
            'tipo'          => $data["tipo"],
            'fecha'         => $data["fecha"],
            'hora'          => $data["hora"],
            'hora_fin'      => $data["hora"],
            'delegacion'    => $data["sede"],
            'estatus'       => 'no atendido',
            'exepcion'      => 'No',
            'edad'          => $data["edad"],
            'sexo'          => $data["sexo"],
        );    
        $turnos = Turnos::create([
            'consecutivo'   => $numero_consecutivo,
            'solicitante'   => $data["nombre"],
            'auxiliar'      => 0,
            'lugar_auxiliar'=> "Recepción",
            'tipo'          => $data["tipo"],
            'fecha'         => $data["fecha"],
            'hora'          => $data["hora"],
            'hora_fin'      => $data["hora"],
            'delegacion'    => $data["sede"],
            'estatus'       => 'no atendido',
            'exepcion'      => 'No',
            'edad'          => $data["edad"],
            'sexo'          => $data["sexo"],
        ]);

        //dd($data_insertar);
        Turnos::create($data_insertar);
        return back()->with('success', 'Debes acudir al centro de conciliacion el dia:'.$data["fecha"].' a la hora:'.$data["hora"]); 
    }

    public function obtenerHorario($fecha_revisar,$sede){
        $array_final = array();
        $array_horarios = array();
        $array_horarios[] = array('hora' => "09:00:00");
        $array_horarios[] = array('hora' => "10:00:00");
        $array_horarios[] = array('hora' => "11:00:00");
        $array_horarios[] = array('hora' => "12:00:00");
        $array_horarios[] = array('hora' => "13:00:00");
        $array_horarios[] = array('hora' => "14:00:00");
        $array_horarios[] = array('hora' => "15:00:00");

        //Turnos no disponibles
        $turnos = Turnos::where('fecha', $fecha_revisar)
        ->where('delegacion',$sede)
        ->select('hora')
        ->get();
        
        $contador=0;
        foreach($array_horarios as $horario){
            

            foreach($turnos as $turno){
                

                if($turno["hora"] != $horario["hora"]){
                    $contador ++;
                    array_push($array_final, $turno);
                    break;
                }


            }

        }

        return $array_horarios;
        //->where('hora', $hora_solicitud)
        //->where('delegacion', $data["sede"])->get();
        //return Municipios::where('estado', $id)->get();
    }
}
