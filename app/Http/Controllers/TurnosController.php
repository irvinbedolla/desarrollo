<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
//use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
//use App\Http\Controllers\PDFController; 
use App\Models\User;
use App\Models\Turnos;
use App\Models\TurnoDisponible;
use App\Models\Poder; 
use App\Models\Pagos; 
use App\Models\Concepto; 

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use NumberToWords\NumberToWords; // para convertir números(cantidades) a letras
use DateTime;

class TurnosController extends Controller 
{
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
        //dd($data);
        if(isset($data["folio"])){
            request()->validate([
                'folio'             => 'required',
                'primero_trabajador'=> 'required',
                'segundo_trabajador'=> 'required',
                'trabajador'        => 'required',
                'trabajador_edad'   => 'required',
                'trabajador_sexo'   => 'required',
                'trabajador_curp'   => 'required',
                'documentoCurp'     => 'required',
                'tipo_identificacion'=> 'required',
                'documentoidentificacion'=> 'required',
                'fecha_inicio'      => 'required',
                'fecha_termino'     => 'required',
                'categoria'         => 'required',
                'monto'             => 'required',
                'frecuencia'        => 'required',
                'tipo_pago'         => 'required',
                'sede'              => 'required',
                'dias'              => 'required',
                'fecha'             => 'required',
                'hora'              => 'required',
                'JLCA'              => 'required',
                'motivo'            => 'required',
                'salario'           => 'required'
            ], $data);
        }
        else{
            request()->validate([
                'empresa'           => 'required',
                'primero_empresa'   => 'required',
                'segundo_empresa'   => 'required',
                'nombre_empresa'    => 'required',
                'curp'              => 'required',
                'email'             => 'required',
                'telefono'          => 'required',
                'documentoIne'      => 'required',
                'documentoPoder'    => 'required',
                'primero_trabajador'=> 'required',
                'segundo_trabajador'=> 'required',
                'trabajador'        => 'required',
                'trabajador_edad'   => 'required',
                'trabajador_sexo'   => 'required',
                'trabajador_curp'   => 'required',
                'documentoCurp'     => 'required',
                'tipo_identificacion'=> 'required',
                'documentoidentificacion'=> 'required',
                'fecha_inicio'      => 'required',
                'fecha_termino'     => 'required',
                'categoria'         => 'required',
                'monto'             => 'required',
                'frecuencia'        => 'required',
                'tipo_pago'         => 'required',
                'sede'              => 'required',
                'dias'              => 'required',
                'hora'              => 'required',
                'JLCA'              => 'required',
                'motivo'            => 'required',
                'salario'           => 'required'
            ], $data);
        }


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

        if(isset($data["folio"])){
            $representante  = Poder::find($data["folio"]);
            if(!isset($representante)){
                return back()->with('error', 'El representante legal no existe');
            }
           
            $data_insertar= array(
                'consecutivo'       => $numero_consecutivo,    
                'empresa'           => $representante["empresa"],
                'primero_empresa'   => $representante["primer_apellido"],
                'segundo_empresa'   => $representante["segundo_apellido"],
                'nombre_empresa'    => $representante["nombres"],
                'primero_trabajador'=> $data["primero_trabajador"],
                'segundo_trabajador'=> $data["segundo_trabajador"],
                'trabajador'        => $data["trabajador"],
                'edad'              => $data["trabajador_edad"],
                'sexo'              => $data["trabajador_sexo"],
                'trabajador_curp'   => $data["trabajador_curp"],
                'documentoCurp'     => $data["documentoCurp"],
                'tipo_identificacion'=> $data["tipo_identificacion"],
                'documentoidentificacion'=> $data["documentoidentificacion"],
                'fecha_inicio'      => $data["fecha_inicio"],
                'fecha_termino'     => $data["fecha_termino"],
                'categoria'         => $data["categoria"],
                'tipo_pago'         => $data["tipo_pago"],
                'monto'             => $data["monto"],
                'frecuencia'        => $data["frecuencia"],
                'dias'              => $data["dias"],
                'fecha'             => $data["fecha"],
                'hora'              => $data["hora"],
                'hora_fin'          => $data["hora"],
                'auxiliar'          => 0,
                'lugar_auxiliar'    => "Recepción",
                'delegacion'        => $data["sede"],
                'estatus'           => 'Pendiente',
                'exepcion'          => 'No',
                'ine'               => $representante["ine"],
                'representacion'    => $representante["representacion"],
                'email'             => $representante["email"],
                'telefono'          => $representante["telefono"],
                'JLCA'              => $data["JLCA"],
                'motivo'            => $data["motivo"],
                'curp_solicitante'  => $representante["curp"],
                'salario'           => $data["salario"]
            ); 
            $nombre = $data["trabajador"];
            $email  = $representante["email"];
            $curp   = $representante["curp"];
        }
        else{
            $data_insertar= array(
                'consecutivo'               => $numero_consecutivo,    
                'empresa'                   => $data["empresa"],
                'primero_empresa'           => $data["primero_empresa"],
                'segundo_empresa'           => $data["segundo_empresa"],
                'nombre_empresa'            => $data["nombre_empresa"],
                'email'                     => $data["email"],
                'telefono'                  => $data["telefono"],
                'documentoIne'              => $data["documentoIne"],
                'documentoPoder'            => $data["documentoPoder"],
                'primero_trabajador'        => $data["primero_trabajador"],
                'segundo_trabajador'        => $data["segundo_trabajador"],
                'trabajador'                => $data["trabajador"],
                'edad'                      => $data["trabajador_edad"],
                'sexo'                      => $data["trabajador_sexo"],
                'trabajador_curp'           => $data["trabajador_curp"],
                'documentoCurp'             => $data["documentoCurp"],
                'tipo_identificacion'       => $data["tipo_identificacion"],
                'documentoidentificacion'   => $data["documentoidentificacion"],
                'fecha_inicio'              => $data["fecha_inicio"],
                'fecha_termino'             => $data["fecha_termino"],
                'categoria'                 => $data["categoria"],
                'tipo_pago'                 => $data["tipo_pago"],
                'monto'                     => $data["monto"],
                'frecuencia'                => $data["frecuencia"],
                'dias'                      => $data["dias"],
                'fecha'                     => $data["fecha"],
                'hora'                      => $data["hora"],
                'hora_fin'                  => $data["hora"],
                'auxiliar'                  => 0,
                'lugar_auxiliar'            => "Recepción",
                'delegacion'                => $data["sede"],
                'estatus'                   => 'Pendiente',
                'exepcion'                  => 'No',
                'ine'                       => $data["documentoIne"],
                'representacion'            => $data["documentoPoder"],
                'email'                     => $data["email"],
                'telefono'                  => $data["telefono"],
                'JLCA'                      => $data["JLCA"],
                'motivo'                    => $data["motivo"],
                'curp_solicitante'          => $data["curp"],
                'salario'                   => $data["salario"]
            ); 
            $nombre = $data["trabajador"];
            $email  = $data["email"];
            $curp   = $data["curp"];
        }

        //Variables opcionales
        if(isset($data["Aguinaldo"])){
            $data_insertar["Aguinaldo"] =  1;
        }
        if(isset($data["Vacaciones"])){
            $data_insertar["Vacaciones"] =  1;
        }
        if(isset($data["PrimaVacacional"])){
            $data_insertar["PrimaVacacional"] = 1;
        }
        if(isset($data["PagoPTU"])){
            $data_insertar["PagoPTU"] =  1;
        }
        if(isset($data["Gratificación"])){
            $data_insertar["Gratificación"] =  1;
        }
        if(isset($data["PrimaAntigüedad"])){
            $data_insertar["PrimaAntigüedad"] =  1;
        }
        if(isset($data["Otras"])){
            $data_insertar["Otras"] =  1;
        }
        if(isset($data["Especifique"])){
            $data_insertar["Especifique"] =  $data["Especifique"];
        }
        if(isset($data["cuantificacion"])){
            $data_insertar["cuantificacion"] =  $data["cuantificacion"];
        }
        if(isset($data["tipo_otros"])){
            $data_insertar["tipo_otros"] =  $data["tipo_otros"];
        }
        //dd($data_insertar);

        //Documentos si cargaron el folio
        if(isset($data["folio"])){
            $nombre_ine             = $representante["nombres"]."".$representante["primer_apellido"]."".$representante["segundo_apellido"]."-".$representante["empresa"]."_IDENTIFICACION.pdf";
            $nombre_representación  = $representante["nombres"]."".$representante["primer_apellido"]."".$representante["segundo_apellido"]."-".$representante["empresa"]."_REPRESENTACION.pdf";
        }
        else{
            //Se carga el INE del abogado
            $nombre_ine = $data["nombre_empresa"]."".$data["primero_empresa"]."".$data["segundo_empresa"]."-".$data["empresa"]."_IDENTIFICACION.pdf";
            $path = Storage::putFileAs(
                'documentos_ratificacion', $request->file('documentoIne'), $nombre_ine
            );
            
            //Se carga el Poder del abogado
            $nombre_representación = $data["nombre_empresa"]."".$data["primero_empresa"]."".$data["segundo_empresa"]."-".$data["empresa"]."_PODER.pdf";
            $path = Storage::putFileAs(
                'documentos_ratificacion', $request->file('documentoPoder'), $nombre_representación
            );
        }
        
        $trabajador_curp = $data["trabajador_curp"].".pdf";
        $path = Storage::putFileAs(
            'documentos_ratificacion', $request->file('documentoCurp'), $trabajador_curp
        );

        $trabajador_identificacion  = $data["trabajador_curp"]."_IDENTIFICACION.pdf";
        $path = Storage::putFileAs(
            'documentos_ratificacion', $request->file('documentoidentificacion'), $trabajador_identificacion
        );

        $data_insertar["ine"]                       = $nombre_ine;
        $data_insertar["representacion"]            = $nombre_representación;   
        $data_insertar["documentoCurp"]             = $trabajador_curp;
        $data_insertar["documentoidentificacion"]   = $trabajador_identificacion;  


        if(isset($data["cuantificacion"])){
            $cuantificacion  = $data["trabajador_curp"]."_CUANTIFICACION.pdf";
            $path = Storage::putFileAs(
                'documentos_ratificacion', $request->file('cuantificacion'), $cuantificacion
            );
            $data_insertar["documentoCuanti"] = $cuantificacion;
        }

        //Se van insetar todos los datos
        Turnos::create($data_insertar);

       
        //Revisar si ya existe el correo
        $usuario = User::where('email',$email)->first();
        if(!isset($usuario)){
            $data_insertar_user= array(
                'name'              => $nombre,
                'email'             => $email,
                'delegacion'        => $data["sede"],
                'type'              => "Seer",
                'remember_token'    => $curp,
                'profile_photo_path'=> $curp
            ); 
            //Genrar un random del uno al 100 y agregarlo a la contraseña
            $numero_aleatorio = mt_rand(1, 1000);

            //Hacemos un hash del campo que tiene el password
            $data_insertar_user['password'] = Hash::make("CCLMICHOACAN".$numero_aleatorio);
            $usuario = User::create($data_insertar_user);
            $usuario->assignRole(('Solicitante'));
            $mensaje = " el correo:".$usuario["email"]." y la contraseña:CCLMICHOACAN".$numero_aleatorio." para continuar tú trámite.";
        }
        else{
            $mensaje = " el correo:".$usuario["email"]." para continuar tú trámite.";
        }
        
        

        return back()->with('success', 'Debes ingresar a '. 
        ' http://siconcilio.cclmichoacan.gob.mx/ en el apartado de buzón electrónico con'.$mensaje  ); 
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

    public function obtenerEventos(Request $request)
    {
        $fecha_inicio = now()->subDays(20)->format('Y-m-d');
        $fecha_fin = now()->addDays(20)->format('Y-m-d');
        $sede = $request->input('sede'); // Obtener sede de la solicitud

        // 1. Obtener turnos ocupados filtrando por sede
        $ocupados = Turnos::whereBetween('fecha', [$fecha_inicio, $fecha_fin])
            ->where('delegacion', $sede) // FILTRO POR SEDE
            ->get()
            ->map(function ($turno) {
                return [
                    'title' => 'Ocupado',
                    'start' => $turno->fecha . 'T' . $turno->hora,
                    'color' => '#DA0909',
                    'extendedProps' => ['estado' => 'ocupado']
                ];
            });

        // 2. Crear slots disponibles
        $todosLosEventos = [];
        $fecha = new \DateTime($fecha_inicio);
        $fin = new \DateTime($fecha_fin);

        while ($fecha <= $fin) {
            if ($fecha->format('N') < 6) { // Saltar fines de semana
                for ($hora = 9; $hora <= 15; $hora++) {
                    $slotStart = $fecha->format('Y-m-d') . 'T' . str_pad($hora, 2, '0', STR_PAD_LEFT) . ':00:00';
                    
                    // Verificar si el slot está ocupado
                    $ocupado = collect($ocupados)->contains('start', $slotStart);
                    
                    if ($ocupado) {
                        $todosLosEventos[] = [
                            'title' => 'Ocupado',
                            'start' => $slotStart,
                            'color' => '#DA0909',
                            'extendedProps' => ['estado' => 'ocupado']
                        ];
                    } else {
                        $todosLosEventos[] = [
                            'title' => 'Disponible',
                            'start' => $slotStart,
                            'color' => '#00CE1C',
                            'extendedProps' => ['estado' => 'disponible']
                        ];
                    }
                }
            }
            $fecha->modify('+1 day');
        }

        return response()->json($todosLosEventos);
    }

    //PDF Acuse de Ratificación
    public function VerPDF($id){
        $solicitud = Turnos::find($id);
        $montoTexto = $this->convertirNumerosALetras($solicitud->monto);
        $pdf = \PDF::loadView('PDF/ratificacion', compact('id','solicitud','montoTexto'))
        ->setPaper('a4', 'portrait')
        ->setOption('isHtml5ParserEnabled', true)
        ->setOption('isPhpEnabled', true);

        $nombreArchivo = 'ratificaion_' . $solicitud->empresa .'.pdf';

        return $pdf->stream($nombreArchivo);               
    }

    //PDF Convenio Ratificación 
    public function VerPDFConvenio($id){
        $solicitud = Turnos::find($id);
        $pagos = Pagos::where('id_solicitud', $id)->get();
        //$prestacionesLab = Concepto::where('id_solicitud', $id)->first();
        //dd($prestaciones);
        $prestaciones = Concepto::where('id_solicitud', $id)->get(); // Devuelve una colección de conceptos de pago
        // Inicializa las variables de texto
        $vacacionesTexto = '';
        $primaTexto = '';
        $aguinaldoTexto = '';
        $DSueldoTexto = '';
        $antiguedadTexto = '';
        $gratificacionATexto = ''; $gratificacionBTexto = ''; $gratificacionCTexto = ''; $gratificacionDTexto = ''; $gratificacionETexto = ''; $gratificacionFTexto = '';
        $otrasTexto = '';
        foreach ($prestaciones as $concepto) {
            switch ($concepto->descripcion) {
                case 'Vacaciones':
                    $vacacionesTexto = $this->convertirNumerosALetras($concepto->monto);
                    break;
                case 'PrimaVacacional':
                    $primaTexto = $this->convertirNumerosALetras($concepto->monto);
                    break;
                case 'Aguinaldo':
                    $aguinaldoTexto = $this->convertirNumerosALetras($concepto->monto);
                    break;
                case 'DSueldo':
                    $DSueldoTexto = $this->convertirNumerosALetras($concepto->monto);
                    break;
                case 'GratificaciónA':
                    $gratificacionATexto = $this->convertirNumerosALetras($concepto->monto);
                    break;
                case 'GratificaciónB':
                    $gratificacionBTexto = $this->convertirNumerosALetras($concepto->monto);
                    break;
                case 'GratificaciónC':
                    $gratificacionCTexto = $this->convertirNumerosALetras($concepto->monto);
                    break;
                case 'GratificaciónD':
                    $gratificacionDTexto = $this->convertirNumerosALetras($concepto->monto);
                    break;
                case 'GratificaciónE':
                    $gratificacionETexto = $this->convertirNumerosALetras($concepto->monto);
                    break;
                case 'GratificaciónF':
                    $gratificacionFTexto = $this->convertirNumerosALetras($concepto->monto);
                    break;
                case 'Otras':
                    $otrasTexto = $this->convertirNumerosALetras($concepto->monto);
                    break;
                default:
                    break;
            }
        }
        //
        $dias_descanso = $solicitud->dias !== null ? 7 - $solicitud->dias : null;

        $salario_diario = $this->calcularSalarioDiario($solicitud->salario, $solicitud->frecuencia);
        $salario_mensual = $salario_diario * 30;
        $diarioTexto = $this->convertirNumerosALetras($salario_diario);
        $mensualTexto = $this->convertirNumerosALetras($salario_mensual);
        $montoTexto = $this->convertirNumerosALetras($solicitud->monto);
        
        $pagosDif  = Pagos::join("turnos","turnos.id","=","pago_solicitud.id_solicitud");
        $pagosDif = $pagosDif->where("pago_solicitud.id_solicitud", "=", $id)
        ->select(DB::raw('count(pago_solicitud.id_solicitud) as C_pagos'))
        ->first();

        $conciliador  = User::join("turnos","turnos.id_conciliador","=","users.id");
        $conciliador = $conciliador->where("turnos.id", "=", $id)
        ->select('users.name')
        ->first();

        //dd($conciliador);
        $html = view('PDF/convenioRatificacion', 
            compact('id', 'solicitud', 'dias_descanso', 'salario_diario','salario_mensual','pagos','diarioTexto','mensualTexto','montoTexto','vacacionesTexto',
            'primaTexto','aguinaldoTexto','DSueldoTexto','antiguedadTexto','gratificacionATexto','gratificacionBTexto','gratificacionCTexto','gratificacionDTexto',
            'gratificacionETexto','gratificacionFTexto','otrasTexto','pagosDif','conciliador','prestaciones'))
            ->render();
        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('Convenio_terminacion.pdf');                   
    }

    public function calcularSalarioDiario($salario, $frecuencia) {
        switch ($frecuencia) {
            case 'Diario':
                return $salario;
            case 'Semanal':
                return $salario / 7; 
            case 'Quincenal':
                return $salario / 15; 
            case 'Mensual':
                return $salario / 30;
            default:
                return 0;
        }
    }

    private function convertirNumerosALetras($valor) {
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('es'); 

        $parteEntera = floor($valor);
        $letras = strtoupper($numberTransformer->toWords($parteEntera)); 

        $parteDecimal = round(($valor - $parteEntera) * 100);
        $centavos = str_pad($parteDecimal, 2, '0', STR_PAD_LEFT); 
        return "{$letras} PESOS {$centavos}/100";
    }

    //PDF Acta de multa
    public function VerPDFMulta($id){
        $solicitud = Turnos::find($id);

        $html = view('PDF/ActaMulta', compact('id', 'solicitud'))->render();

        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true); 

        $nombreArchivo = 'multa_' . $solicitud->empresa .'.pdf';
        return $pdf->stream($nombreArchivo);                  
    }

    //PDF Acta por falta de interés
    public function VerPDFInteres($id){
        $solicitud = Turnos::find($id);
        $conciliador  = User::join("turnos","turnos.id_conciliador","=","users.id");
        $conciliador = $conciliador->where("turnos.id", "=", $id)
        ->select('users.name')
        ->first();

        $html = view('PDF/ActaFaltaInteres', compact('id', 'solicitud','conciliador'))->render();

        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true); 

        $nombreArchivo = 'falta_de_interes_' . $solicitud->trabajador .'.pdf';
        return $pdf->stream($nombreArchivo);                  
    }

    //PDF Constancia de cumplimiento
    public function VerPDFCumplimiento($id){
        $solicitud = Turnos::find($id);
        $pagos = Pagos::where('id_solicitud', $id)->get();
        $conciliador  = User::join("turnos","turnos.id_conciliador","=","users.id");
        $conciliador = $conciliador->where("turnos.id", "=", $id)
        ->select('users.name')
        ->first();

        $html = view('PDF/ConstanciaCumplimiento', compact('id', 'solicitud','conciliador','pagos'))->render();

        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true); 

        $nombreArchivo = 'constancia_de_cumplimiento_' . $solicitud->trabajador .'.pdf';
        return $pdf->stream($nombreArchivo);                  
    }

    //PDF Acta de Audiencia
    public function VerPDFAudiencia($id){
        $solicitud = Turnos::find($id);

        $conciliador  = User::join("turnos","turnos.id_conciliador","=","users.id");
        $conciliador = $conciliador->where("turnos.id", "=", $id)
        ->select('users.name')
        ->first();

        $html = view('PDF/ActaAudiencia', compact('id', 'solicitud','conciliador'))->render();

        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true); 

        $nombreArchivo = 'acta_de_audiencia_' . $solicitud->trabajador .'.pdf';
        return $pdf->stream($nombreArchivo);                  
    }

    //PDF Constancia de Incumplimiento
    public function VerPDFIncumplimiento($id){
        $solicitud = Turnos::find($id);
        $pagos = Pagos::find($id);
       
        $conciliador  = User::join("turnos","turnos.id_conciliador","=","users.id");
        $conciliador = $conciliador->where("turnos.id", "=", $id)
        ->select('users.name')
        ->first();
        $salario_diario = $this->calcularSalarioDiario($solicitud->salario, $solicitud->frecuencia);

        $html = view('PDF/Incumplimiento', compact('id', 'solicitud','conciliador','salario_diario','pagos'))->render();

        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true); 

        $nombreArchivo = 'constancia_de_incumplimiento_'  .'.pdf';
        return $pdf->stream($nombreArchivo);                  
    }

    //PDF Constancia de Incumplimiento Parcial
    public function VerPDFInParcial($id){
        $pagos = Pagos::find($id);
        $solicitud = Turnos::find($pagos["id_solicitud"]);
        $salario_diario = $this->calcularSalarioDiario($solicitud->salario, $solicitud->frecuencia);

        $conciliador  = User::join("turnos","turnos.id_conciliador","=","users.id");
        $conciliador = $conciliador->where("turnos.id_conciliador", "=", $solicitud["id_conciliador"])
        ->select('users.name')
        ->first();
        
        $html = view('PDF/incumplimientoParcial', compact('id', 'solicitud','conciliador','pagos','salario_diario'))->render();

        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true); 

        $nombreArchivo = 'constancia_de_incumplimiento_parcial'  .'.pdf';
        return $pdf->stream($nombreArchivo);                  
    }

    //PDF Constancia de Pago Parcial
    public function VerPDFPagos($id){
        $pagos = Pagos::find($id);
        $solicitud = Turnos::find($pagos["id_solicitud"]);
    
        $conciliador  = User::join("turnos","turnos.id_conciliador","=","users.id");
        $conciliador = $conciliador->where("turnos.id_conciliador", "=", $solicitud["id_conciliador"])
        ->select('users.name')
        ->first();
        $html = view('PDF/pagosParciales', compact('id','solicitud','conciliador','pagos'))->render();

        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true); 

        $nombreArchivo = 'constancia_de_pago_'  .'.pdf';
        return $pdf->stream($nombreArchivo);                  
    }
    
    public function index_empresa(){
        $id = auth()->user()->id;
        $user = User::find($id);

        $solicitudes = Turnos::where('tipo','Ratificación')
        ->join('users','turnos.curp_solicitante','=','users.profile_photo_path')
        ->where('curp_solicitante',$user["profile_photo_path"])
        ->select('turnos.id','turnos.fecha','turnos.empresa','turnos.trabajador','turnos.telefono','turnos.email','turnos.estatus')
        ->get();
        return view('/solicitudes/misratificaciones',compact('solicitudes'));
    }

    public function indexr(){
        $solicitudes = Turnos::where('tipo','Ratificación')
        ->where('estatus','Pendiente')
        ->get();
        return view('/solicitudes/indexr',compact('solicitudes'));
    }

    public function aceptacion($id){
        $turno = Turnos::find($id);

        $listado_auxiliares = array();
        $relacionEloquent = 'roles';
        $usuariosauxiliares = User::whereHas($relacionEloquent, function ($query) {
            return $query->where('name', '=', 'Auxiliar');
        })
        ->where('delegacion', $turno["delegacion"])
        ->get();
        
        foreach($usuariosauxiliares as $token ){
            //Validar que solo sea morelia
            array_push($listado_auxiliares, $token["id"]);
        }
        //validar si hay disponibles
        $random = array_rand($listado_auxiliares);
        $conciliador = $listado_auxiliares[$random];        
        $user = User::find($conciliador);
        $expediente = $this->GeneraExpediente($turno["id"],$turno["delegacion"]);

        Turnos::find($id)->update(['auxiliar' => $user["id"],'lugar_auxiliar' => $user["name"],'estatus' => 'Confirmado','NUE' => $expediente, 'id_conciliador' => $user["id"]]);
        return redirect()->route('Ratificacion');
    }

    public function guardar_rechazo(Request $request){
        $data = $request->all();
        Turnos::find($data["id"])->update(['estatus' => 'Prevencion','observaciones' => $data["observaciones"]]);

        return redirect()->route('Ratificacion');
    }

    public function revisar_ratificaciones_hoy(){
        $id = auth()->user()->id;
        $user = User::find($id);
        $fecha_actual = date('Y-m-d');

        $solicitudes = Turnos::where('tipo','Ratificación')
        ->where('auxiliar',$user["id"])
        /*->where('estatus','Confirmado')
        ->orwhere('estatus','Conluida')
        ->orwhere('estatus','Concluida Pagos')
        ->orwhere('estatus','Incumplimiento')
        ->orwhere('estatus','Archivada')*/
        ->where('fecha',$fecha_actual)
        ->get();
        return view('/solicitudes/indexauxiliar',compact('solicitudes'));
    }

    public function concluir_ratificaciones($id){
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $relacionEloquent = 'roles';

        $conciliadores = User::whereHas($relacionEloquent, function ($query) {
            return $query->where('name', '=', 'Conciliador');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();

        return view('/solicitudes/concluir',compact('id','conciliadores'));
    }

    public function consultar_ratificaciones($id){
        $folio = Turnos::find($id);
        //Validar si existe el abogado
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();

        $valida = Poder::where('curp',$folio["curp_solicitante"])->get();
        //dd($valida);
        if(count($valida) != 0){
            $ruta_abogado = 'documentos_abogados';
        }
        else{
            $ruta_abogado = 'documentos_ratificacion';
        }
        //dd($ruta_abogado);
        return view('/solicitudes/verratificacion',compact('folio','ruta_abogado','userRole'));
    }

    public function editar_ratificaciones(Request $request){
        $data = $request->all();
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        
        //Validar si existe el documnento nuevo
        if(isset($data["documentoIne"])){
            $nombre_ine = $data["nombres"]."".$data["primer_apellido"]."".$data["segundo_apellido"]."-".$data["empresa"]."_IDENTIFICACION.pdf";
            $path = Storage::putFileAs(
                'documentos_ratificacion', $request->file('documentoIne'), $nombre_ine
            );
        }
        if(isset($data["documentoRepresentacion"])){
            $nombre_representación = $data["nombre_empresa"]."".$data["primero_empresa"]."".$data["segundo_empresa"]."-".$data["empresa"]."_PODER.pdf";
            $path = Storage::putFileAs(
                'documentos_ratificacion', $request->file('documentoRepresentacion'), $nombre_representación
            );
        }
        if(isset($data["documentoCurp"])){
            $trabajador_curp = $data["trabajador_curp"].".pdf";
            $path = Storage::putFileAs(
                'documentos_ratificacion', $request->file('documentoCurp'), $trabajador_curp
            );
        }
        if(isset($data["documentoidentificacion"])){
            $trabajador_identificacion = $data["trabajador_curp"]."_IDENTIFICACION.pdf";
            $path = Storage::putFileAs(
                'documentos_ratificacion', $request->file('documentoidentificacion'), $trabajador_identificacion
            );
        }
        //Variables opcionales
        if(isset($data["Aguinaldo"]) && $data["motivo"] == "Pago de prestaciones"){
            $Aguinaldo =  1;
        }
        else{
            $Aguinaldo =  0;
        }
        if(isset($data["Vacaciones"]) && $data["motivo"] == "Pago de prestaciones"){
            $Vacaciones =  1;
        }
        else{
            $Vacaciones =  0;
        }
        if(isset($data["PrimaVacacional"]) && $data["motivo"] == "Pago de prestaciones"){
            $PrimaVacacional = 1;
        }
        else{
            $PrimaVacacional = 0;
        }
        if(isset($data["PagoPTU"]) && $data["motivo"] == "Pago de prestaciones"){
            $PagoPTU =  1;
        }
        else{
            $PagoPTU = 0;
        }
        if(isset($data["Gratificación"]) && $data["motivo"] == "Pago de prestaciones"){
            $Gratificación =  1;
        }
        else{
            $Gratificación = 0;
        }
        if(isset($data["PrimaAntigüedad"]) && $data["motivo"] == "Pago de prestaciones"){
            $PrimaAntigüedad =  1;
        }
        else{
            $PrimaAntigüedad = 0;
        }
        if(isset($data["Otras"]) && $data["motivo"] == "Pago de prestaciones"){
            $Otras =  1;
        }
        else{
            $Otras =  0;
        }
        if(isset($data["Especifique"]) && $data["motivo"] == "Pago de prestaciones"){
            $Especifique =  $data["Especifique"];
        }
        else{
            $Especifique = 0;
        }
        //Agregar todos los campos de la tabla turnos
        if($userRole[0] == "Solicitante"){
            $data_update = Turnos::find($data["id"])
            ->update([
                'empresa'                       => $data["empresa"],
                'primero_empresa'               => $data["primero_empresa"],
                'segundo_empresa'               => $data["segundo_empresa"],
                'nombre_empresa'                => $data["nombre_empresa"],
                'curp_solicitante'              => $data["curp_solicitante"],
                'telefono'                      => $data["telefono"],
                'trabajador'                    => $data["nombre_trabajador"],
                'primero_trabajador'            => $data["primer_apellidot"],
                'segundo_trabajador'            => $data["segundo_apellidot"],
                'edad'                          => $data["edad"],
                'sexo'                          => $data["sexo"],
                'trabajador_curp'               => $data["trabajador_curp"],
                'email'                         => $data["email"],
                'telefono'                      => $data["telefono"],
                'tipo_identificacion'           => $data["tipo_identificacion"],
                'fecha_inicio'                  => $data["fecha_inicio"],
                'fecha_termino'                 => $data["fecha_termino"],
                'categoria'                     => $data["categoria"],
                'frecuencia'                    => $data["frecuencia"],
                'salario'                       => $data["salario"],
                'dias'                          => $data["dias"],
                'motivo'                        => $data["motivo"],
                'Aguinaldo'                     => $Aguinaldo,
                'Vacaciones'                    => $Vacaciones,
                'PrimaVacacional'               => $PrimaVacacional,
                'PagoPTU'                       => $PagoPTU,
                'Gratificación'                 => $Gratificación,
                'PrimaAntigüedad'               => $PrimaAntigüedad,
                'Otras'                         => $Otras,
                'Especifique'                   => $Especifique,
                'monto'                         => $data["monto"],
                'tipo_pago'                     => $data["tipo_pago"],
                'estatus'                       => 'Pendiente',
            ]);
        }
        else{
            $data_update = Turnos::find($data["id"])
            ->update([
                'empresa'                       => $data["empresa"],
                'primero_empresa'               => $data["primero_empresa"],
                'segundo_empresa'               => $data["segundo_empresa"],
                'nombre_empresa'                => $data["nombre_empresa"],
                'curp_solicitante'              => $data["curp_solicitante"],
                'telefono'                      => $data["telefono"],
                'trabajador'                    => $data["nombre_trabajador"],
                'primero_trabajador'            => $data["primer_apellidot"],
                'segundo_trabajador'            => $data["segundo_apellidot"],
                'edad'                          => $data["edad"],
                'sexo'                          => $data["sexo"],
                'trabajador_curp'               => $data["trabajador_curp"],
                'email'                         => $data["email"],
                'telefono'                      => $data["telefono"],
                'tipo_identificacion'           => $data["tipo_identificacion"],
                'fecha_inicio'                  => $data["fecha_inicio"],
                'fecha_termino'                 => $data["fecha_termino"],
                'categoria'                     => $data["categoria"],
                'frecuencia'                    => $data["frecuencia"],
                'salario'                       => $data["salario"],
                'dias'                          => $data["dias"],
                'motivo'                        => $data["motivo"],
                'Aguinaldo'                     => $Aguinaldo,
                'Vacaciones'                    => $Vacaciones,
                'PrimaVacacional'               => $PrimaVacacional,
                'PagoPTU'                       => $PagoPTU,
                'Gratificación'                 => $Gratificación,
                'PrimaAntigüedad'               => $PrimaAntigüedad,
                'Otras'                         => $Otras,
                'Especifique'                   => $Especifique,
                'monto'                         => $data["monto"],
                'tipo_pago'                     => $data["tipo_pago"],
                'delegacion'                    => $data["delegacion"],
                'fecha'                         => $data["fecha_pago"],
                'hora'                          => $data["hora_pago"],
                'observaciones'                 => $data["observaciones"],
                'estatus'                       => 'Pendiente',
            ]);
        }


        if($userRole[0] == "Auxiliar")
            return redirect()->route('ratificacion_atender');
        else if($userRole[0] == "Solicitante")
            return redirect()->route('ratificacion');
        else if($userRole[0] == "Administrador Solicitante")
            return redirect()->route('Ratificacion');
    }
    
    public function guardar_manifestacion(Request $request){
        $data = $request->all();
        //Revisar si existe
        if(isset($data["dias_pagos"])){
            $conteo = count($data["dias_pagos"]);
            for($i = 0; $i < $conteo; $i++) {
                $data_citado = [
                    'id_solicitud'  => $data["id"],
                    'fecha'         => $data["dias_pagos"][$i],
                    'hora'          => $data["hora_pagos"][$i], 
                    'monto'         => $data["monto_pagos"][$i], 
                    'descripcion'   => $data["descripcion_pagos"][$i],
                    'estatus'       => "Pendiente", 
                    'tipo_pago'     => "Ratificacion"
                ];
                Pagos::create($data_citado);
            }
        }
        //Regresar error
        else{
            return back()->withErrors('Debes agregar por lo menos una fecha de pago.');
        }
        if(isset($data["tipo_pago"])){
            $cont = count($data["monto_pago"]);
            for($i = 0; $i < $cont; $i++) {
                $data_citado = [
                    'id_solicitud'  => $data["id"], 
                    'monto'         => $data["monto_pago"][$i], 
                    'descripcion'   => $data["tipo_pago"][$i],
                    'tipo_pago'     => "Ratificacion"
                ];
                Concepto::create($data_citado);
            }
        }
        //Regresar error
        else{
            return back()->withErrors('Debes agregar por lo menos un concepto de pago.');
        }

        if($conteo >= 2){
            $estatus = "Concluida Pagos";
        }
        else{
            $estatus = "Conluida";
        }

        //Generar numero de expediente
        $delegacion = Turnos::find($data["id"]);
        $expediente = $this->GeneraExpediente($data["id"],$delegacion["delegacion"]);

        $rechazar = Turnos::find($data["id"])
        ->update(['resolucion_primera'  => $data["primera"],
        //'resolucion_trabajadores'       => $data["trabajadores"],
        'resolucion_justificacion'      => $data["justificacion"],
        'resolucion_segunda'            => $data["segunda"],
        'vacaciones_dias'               => $data["vacaciones"],
        'aguinaldo_dias'                => $data["aguinaldo"],
        'otros_dias'                    => $data["otros"],
        'horario'                       => $data["horario"],
        'comida'                        => $data["comida"],
        'domicilio'                     => $data["domicilio"],
        'NUE'                           => $expediente,
        'id_conciliador'                => $data["conciliador_id"],

        'estatus'                       => $estatus]);
        
        return redirect()->route('ratificacion_atender');
    }

    public function pagar_ratificacion($id){
        //Revisar todos los pagos
        $pagos = Pagos::where('id_solicitud',$id)->get();

        return view('/solicitudes/pagos',compact('id','pagos'));
    }

    public function pagoA_ratificacion(Request $request){
        $data = $request->all();

        Pagos::find($data["id"])
        ->update(['estatus'  => "Pagado", 'observaciones' => $data["observaciones"]]);

        $pagos = Pagos::find($data["id"]);
        $id_solicitud = $pagos["id_solicitud"];
        $faltantes =  Pagos::where('id_solicitud',$id_solicitud)->where('estatus',"Pendiente")->get();

        if(count($faltantes) == 0){
            Turnos::find($id_solicitud)
            ->update(['estatus' => "Conluida"]);
        }

        return redirect()->route('ratificacion_atender');
    }

    public function pagoR_ratificacion($id){
        $pagos = Pagos::find($id);
        
        $id_solicitud = $pagos["id_solicitud"];
        Pagos::find($id)
        ->update(['estatus'  => "No pagado"]);

        Turnos::find($id_solicitud)
        ->update(['estatus' => "Incumplimiento"]);

        return redirect()->route('ratificacion_atender');
    }

    public function GeneraExpediente($id,$delegacion){
        $año_actual = date('Y');
    
        if($delegacion == "Morelia"){
            $del = "MOR";
        }
        else if($delegacion == "Uruapan"){
            $del = "URU";
        }
        else if($delegacion == "Zamora"){
            $del = "ZAM";
        }
        //contar el numero de ceros
        $numeroConCeros = str_pad($id, 5, "0", STR_PAD_LEFT);
        $folio = $del."/RAT"."/".$año_actual."/".$numeroConCeros;
    
        return $folio;
    }

    public function archivar_ratificacion(Request $request){
        $data = $request->all();
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);

        $turno = Turnos::find($data["id"]);
        $expediente = $this->GeneraExpediente($turno["id"],$turno["delegacion"]);
        Turnos::find($turno["id"])->update(['auxiliar' => $user["id"],'lugar_auxiliar' => $user["name"],'estatus' => 'Archivada','NUE' => $expediente, 'id_conciliador' => $user["id"], 'observaciones' => $data["observaciones"]]);

        return redirect()->route('ratificacion_atender');
    
    }

    public function index_ratificacion(){
        return view('/ratificaciones/index');
    }

    public function buscar_ratificacion(){
        return view('/ratificaciones/buscar');
    }

    public function busqueda_ratificaciones(Request $request){
        $data = $request->all();
        $id = auth()->user()->id;
        //$user = User::find($id);

        $solicitudes = Turnos::where('tipo','Ratificación')
        //->where('auxiliar',$user["id"])
        ->whereBetween('turnos.fecha', [$data["fecha_inicio"], $data["fecha_final"]])
        ->get();
        dd($solicitudes);
        return view('/ratificaciones/busqueda',compact('solicitudes'));
    }

    //PDF INCOMPARECENCIA POR PARTE DEL TRABAJADOR
    public function VerPDFIncomTrabajador($id){
        $solicitud = Turnos::find($id);

        $conciliador  = User::join("turnos","turnos.id_conciliador","=","users.id");
        $conciliador = $conciliador->where("turnos.id", "=", $id)
        ->select('users.name')
        ->first();

        //dd($conciliador);
        $html = view('PDF/incomparecenciaTrabajador', 
            compact('id', 'solicitud', 'conciliador'))
            ->render();
        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('incomparecencia_Trabajador.pdf');                   
    }

    //INCOMPARECENCIA TRABAJADOR
    public function pagoIncomparecencia_ratificacion($id){
        $pagos = Pagos::find($id);
        
        $id_solicitud = $pagos["id_solicitud"];
        Pagos::find($id)
        ->update(['estatus'  => "Incomparecencia trabajador"]);

        Turnos::find($id_solicitud)
        ->update(['estatus' => "Archivada"]); //Revisar Ana, a que estatus cambiaria (aún está pendiente)

        return redirect()->route('ratificacion_atender');
    }

}
