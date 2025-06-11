<?php

namespace App\Http\Controllers;

use App\Models\Turnos;
use App\Models\Municipio;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function publico(){
        return view('welcome');
    }

    public function home()
    {
        //return redirect('home');
        return view('home');
    }

    public function pantalla()
    {
        $fecha_actual = date('Y-m-d');

        $turnos = DB::table('turnos')
        ->join('users', 'users.id', '=', 'turnos.auxiliar')
        ->select('users.id', 'users.name', 'turnos.solicitante')
        ->where('turnos.fecha', $fecha_actual)
        ->paginate(10);

        return view('pantalla', compact('turnos'));
    }

    public function citas(){
        return view('turnos');
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
}