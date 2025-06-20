<?php

namespace App\Http\Controllers;

use App\Models\Turnos;
use App\Models\Municipio;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth, Hash;


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

    public function turnos_publico(Request $request){
        $data = $request->all();
        $fecha_actual = date('Y-m-d');
        $hora_actual  = date("H:i:s");
        $numero_consecutivo = 0;
        $consecutivo  = Turnos::latest('id')->where('fecha', $fecha_actual)->first();

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
            'fecha'         => $fecha_actual,
            'hora'          => $hora_actual,
            'hora_fin'      => $hora_actual,
            'delegacion'    => "Morelia",
            'estatus'       => "no atendido",
            'exepcion'      => "No",
            'edad'          => $data["edad"],
            'sexo'          => $data["sexo"],
        );    
        Turnos::create($data_insertar);
        
        return back()->with('success', 'Turno registrado correctamente favor de pasar a ventanilla.'); 
    }

    public function password_cambiar(){
        return view('/cambio_contraseña/reset-password');
    }

    public function contraseña_update(Request $request){
        $request->validate([
            'password'  => 'required',
            'password1' => 'required'
        ]);
        $data = $request->all();
        //dd($data);
        
        if ($data["password"] !== $data["password1"]){
            return back()->withErrors('¡La contraseña no coincide!');
        }
        else{
            $id = auth()->user()->id;
            $user = User::find($id);
    
            $user->password = Hash::make($data["password"]);
            $user->save();

            return back()->with('success', 'Contraseña Actualizada correctamente.');
        }
    }
    
    public function calendario(){
        return view('/pages/dashboards/index');
    }

    public function calendario_ver($id){
        
    }
}