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
//use App\Http\Controllers\PDFController;
use Spatie\Permission\Models\Role; 
use App\Models\User;
use App\Models\Turnos;
use App\Models\TurnoDisponible;
use App\Models\DiasInhabiles;
use App\Models\Sedes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use NumberToWords\NumberToWords; // para convertir números(cantidades) a letras
use DateTime;


class AdministracionController extends Controller
{
    public function configuracion()
    {   
        $id = auth()->user()->id;
        $user = User::find($id);
       
        return view('administracion.index_admin');
    }

    public function configuracion_sedes()
    {
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();

        if (!empty($userRole) && $userRole[0] === "Super Usuario") {
            $sedes = Sedes::all();
        } else {
            $sedes = collect([$user->delegacion]);
        }

        return view('administracion.index_sedes', compact('sedes'));
    } 

    public function genera_retroceso()
    {
        return view('administracion.index_retroceso');
    }

    public function consultar_retroceso_ratifficacion(Request $request){
        // 1. Validar la solicitud si es necesario
        $request->validate([
            'id_a_consultar' => 'required|integer',
        ]);

        // 2. Realizar la consulta
        $id = $request->input('id_a_consultar');
        $registro = TuModelo::find($id); // o TuModelo::where('campo', $id)->first();

        // 3. Retornar la respuesta JSON
        if ($registro) {
            return response()->json([
                'success' => true,
                'data' => $registro // Laravel lo convierte automáticamente a JSON
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Registro no encontrado.'
        ], 404); // Se puede usar un código de estado 404 si no se encuentra
    }
}