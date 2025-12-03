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
use App\Models\HorasInhabiles;
use App\Models\Sedes;
use App\Models\Pagos;
use App\Models\Concepto; 
use App\Models\Deducciones;

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
        $sede = $user->delegacion;

        if (!empty($userRole) && ($userRole[0] === "Super Usuario" || $userRole[0] === "Administrador")) {
            $sedes = Sedes::all();
            $conciliadores = User::role('Conciliador')
            ->orderBy('delegacion')
            ->get();
            $bloqueos = DiasInhabiles::orderBy('fecha_inicio','desc')->get();
        } 
        else {
            if($sede == "Morelia"){
                $sedes = Sedes::whereIn('nombre',['Morelia', 'Zitácuaro'])->get();
                $conciliadores = User::role('Conciliador')
                ->whereIn('delegacion', ['Morelia', 'Zitácuaro'])
                ->get();
                $bloqueos = DiasInhabiles::whereIn('centro', ['Morelia', 'Zitácuaro'])
                ->orWhere('user_id', $user->id)
                ->orderBy('fecha_inicio','desc')
                ->get();
            }
            else if($sede == "Uruapan"){
                $sedes = Sedes::whereIn('nombre',['Uruapan', 'Lázaro Cárdenas'])->get();
                $conciliadores = User::role('Conciliador')
                ->whereIn('delegacion', ['Uruapan', 'Lázaro Cárdenas'])
                ->get();
                $bloqueos = DiasInhabiles::whereIn('centro', ['Uruapan', 'Lázaro Cárdenas'])
                ->orWhere('user_id', $user->id)
                ->orderBy('fecha_inicio','desc')
                ->get();
            }
            else if($sede == "Zamora"){
                $sedes = Sedes::whereIn('nombre',['Zamora', 'Sahuayo'])->get();
                $conciliadores = User::role('Conciliador')
                ->whereIn('delegacion', ['Zamora', 'Sahuayo'])
                ->get();
                $bloqueos = DiasInhabiles::whereIn('centro', ['Zamora', 'Sahuayo'])
                ->orWhere('user_id', $user->id)
                ->orderBy('fecha_inicio','desc')
                ->get();
            }
        }

        return view('administracion.index_sedes', compact('sedes','conciliadores','bloqueos'));
    } 

    public function genera_retroceso()
    {
        return view('administracion.index_retroceso');
    }

    public function consultar_retroceso(Request $request){
        $data = $request->all();
        if($data["tipo"] == "Cumplimiento"){
            $folios = Pagos::where("id_solicitud",$data["folio"])
            ->whereYear("fecha",$data["año"])
            ->select('id','NUE','fecha','descripcion','estatus')
            ->get()
            ->map(function ($folio) {
                return [
                    'id' => $folio->id,
                    'NUE' => $folio->NUE,
                    'fecha' => $folio->fecha->format('Y-m-d H:i:s'),
                    'descripcion' => $folio->descripcion,
                    'estatus' => $folio->estatus,
                ];
            })
            ->toArray();

            if(count($folios) != 0){
                return redirect()->back()
                ->with('message', 'Cumplimientos Encontrados.') // Mensaje general
                ->with('folios_generados', $folios)
                ->with('tipo', $data["tipo"]); // La variable específica
            }
            else{
                return back()->withErrors('No existe el folio y/o año ingresado.');
            }
        }
        else if($data["tipo"] == "Ratificación"){
            $folios = Turnos::where('id',$data["folio"])
            ->whereYear("fecha",$data["año"])
            ->select('id','NUE','fecha','estatus')
            ->selectRaw("CONCAT(empresa,' ',primero_empresa,' ',segundo_empresa) as empresa")
            ->selectRaw("CONCAT(trabajador,' ',primero_trabajador,' ',segundo_trabajador) as trabajador")
            ->get()
            ->map(function ($folio) {
                return [
                    'id' => $folio->id,
                    'NUE' => $folio->NUE,
                    'fecha' => $folio->fecha,
                    'empresa' => $folio->empresa,
                    'trabajador' => $folio->trabajador,
                    'estatus' => $folio->estatus,
                ];
            })
            ->toArray();

            if(count($folios) != 0){
                return redirect()->back()
                ->with('message', 'Ratificación Encontrada. Al realizar el retroceso se borran las Prestaiones,deduciones y dias de cumplimientos.') // Mensaje general
                ->with('folios_generados', $folios)
                ->with('tipo', $data["tipo"]); // La variable específica
            }
            else{
                return back()->withErrors('Debes seleccionar al menos una Región.');
            }
        }
    }

    public function hacer_retroceso($id){
        Pagos::find($id)->update(['estatus'  => "Pendiente"]);
        return redirect()->back()->with('success', 'Puedes realizar tu cumplimiento nuevamente.');
    }

    public function hacer_retroceso_ratificacion($id){
        Turnos::find($id)->update(['estatus'  => "Pendiente"]);
        Pagos::      where("id_solicitud",$id)->delete();
        Concepto::   where('id_solicitud',$id)->delete();
        Deducciones::where('id_solicitud',$id)->where('tipo_pago','Ratificacion')->delete();

        return redirect()->back()->with('success', 'Puedes realizar tu ratificación nuevamente.');
    }
    
    public function bloqueoSede(Request $request)
    {
        $request->validate([
            'sede_id'        => 'required',
            'fecha_inicio'   => 'required|date',
            'fecha_final'    => 'required|date|after_or_equal:fecha_inicio',
        ]);
        
        $existe = DiasInhabiles::where('centro', $request->sede_id)
        ->whereDate('fecha_inicio', '<=', $request->fecha_final)
        ->whereDate('fecha_final', '>=', $request->fecha_inicio)
        ->exists();
        if ($existe) {
            return back()->withErrors('Ya existe un bloqueo para esta sede en ese rango de fechas.');
        }

        DiasInhabiles::create([
            'fecha_inicio'   => $request->fecha_inicio,
            'fecha_final'    => $request->fecha_final,
            'horario_inicio' => "00:00:00",
            'horario_final'  => "23:59:59",
            'centro'         => $request->sede_id,
            'user_id'        => null,
        ]);
        
        return back()->with('success', 'La sede quedó bloqueada correctamente.');
    }

    public function bloqueoConciliador(Request $request)
    {
        $request->validate([
            'conciliador_id' => 'required|integer',
            'fecha_inicio'   => 'required|date',
            'fecha_final'    => 'required|date|after_or_equal:fecha_inicio',
            'hora_inicio'    => 'required',
            'hora_final'     => 'required|after:hora_inicio',
        ]);
        $existe = DiasInhabiles::where('user_id', $request->conciliador_id)
        ->whereDate('fecha_inicio', '<=', $request->fecha_final)
        ->whereDate('fecha_final', '>=', $request->fecha_inicio)
        ->where('horario_inicio', '<=', $request->hora_final)
        ->where('horario_final', '>=', $request->hora_inicio)
        ->exists();
        if ($existe) {
            return back()->withErrors("El conciliador ya está bloqueado en ese horario.");
        }
        DiasInhabiles::create([
            'fecha_inicio'   => $request->fecha_inicio,
            'fecha_final'    => $request->fecha_final,
            'horario_inicio' => $request->hora_inicio,
            'horario_final'  => $request->hora_final,
            'centro'         => Auth::user()->delegacion,
            'user_id'        => $request->conciliador_id,
        ]);

        return back()->with('success', 'El conciliador fue bloqueado correctamente.');
    }

    public function eliminarBloqueo($id)
    {
        $bloqueo = DiasInhabiles::find($id);
        if(!$bloqueo){
            return back()->withErrors('El bloqueo no existe.');
        }

        $bloqueo->delete();
        return back()->with('success', 'Bloqueo eliminado correctamente.');
    }

    public function configuracion_usuarios(){
        $id = auth()->user()->id;
        $user = User::findOrFail($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $sede = $user->delegacion;

        if($sede == "Morelia"){
            $usuarios = User::role(['Notificador', 'Conciliador','Auxiliar','Excepcion','Delegado'])->whereIn('delegacion', ['Morelia', 'Zitácuaro'])->get();
        }
        else if($sede == "Uruapan"){
            $usuarios = User::role(['Notificador', 'Conciliador','Auxiliar','Excepcion','Delegado'])->whereIn('delegacion', ['Uruapan', 'Lázaro Cárdenas'])->get();
        }
        else if($sede == "Zamora"){
            $usuarios = User::role(['Notificador', 'Conciliador','Auxiliar','Excepcion','Delegado'])->whereIn('delegacion', ['Zamora', 'Sahuayo'])->get();
        }
            
        return view('administracion.index_usuario', compact('usuarios'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->first();
        
        return view('administracion.editar_usuario', compact('user','roles','userRole'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        }else {
            $input = Arr::except($input, array('password'));
        }
        
        $user = User::find($id);
        $user->update($input);

        return redirect()->route('configuracion_usuarios');
    }

    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return redirect()->route('configuracion_usuarios');
    }

    public function consular_cumplimientos(){
        return view('administracion.index_cumplimientos');
    }

    public function borrar_cumplimeinto(Request $request){
        $data = $request->all();
        if($data["tipo"] == "Audiencia"){
            $folios = Pagos::where("id_solicitud",$data["folio"])
            ->whereYear("fecha",$data["año"])
            ->where('tipo_pago','Audiencia')
            ->select('id','NUE','fecha','descripcion','estatus')
            ->get()
            ->map(function ($folio) {
                return [
                    'id' => $folio->id,
                    'NUE' => $folio->NUE,
                    'fecha' => $folio->fecha->format('Y-m-d H:i:s'),
                    'descripcion' => $folio->descripcion,
                    'estatus' => $folio->estatus,
                ];
            })
            ->toArray();

            if(count($folios) != 0){
                return redirect()->back()
                ->with('message', 'Cumplimientos Encontrados.') // Mensaje general
                ->with('folios_generados', $folios)
                ->with('tipo', $data["tipo"]); // La variable específica
            }
            else{
                return back()->withErrors('No existe el folio y/o año ingresado.');
            }
        }
        else if($data["tipo"] == "Ratificación"){
            $folios = Pagos::where("id_solicitud",$data["folio"])
            ->whereYear("fecha",$data["año"])
            ->where('tipo_pago','Ratificacion')
            ->select('id','NUE','fecha','descripcion','estatus')
            ->get()
            ->map(function ($folio) {
                return [
                    'id' => $folio->id,
                    'NUE' => $folio->NUE,
                    'fecha' => $folio->fecha->format('Y-m-d H:i:s'),
                    'descripcion' => $folio->descripcion,
                    'estatus' => $folio->estatus,
                ];
            })
            ->toArray();

            if(count($folios) != 0){
                return redirect()->back()
                ->with('message', 'Cumplimientos Encontrados.') // Mensaje general
                ->with('folios_generados', $folios)
                ->with('tipo', $data["tipo"]); // La variable específica
            }
            else{
                return back()->withErrors('No existe el folio y/o año ingresado.');
            }
        }
        else{
            return back()->withErrors('Debes seleccionar un tipo de cumplimiento.');
        }
    }

    public function destroy_cumplimientoA($id){
        Pagos::find($id)->update(['tipo_pago'  => "Borrado"]);
        return back()->with('success', 'Cumplimeinto borrado correctamente.');
    }
}