<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Models\Municipios;
use App\Models\Estados;
use App\Models\SeerPerGeneral;
use App\Models\SeerPerAuxiliar;
use App\Models\SeerPerConciliador;
use App\Models\SeerColectivas;
use App\Models\SeerConvenios;
use App\Models\SeerCitados;
use App\Models\SeerAsesoria;
use App\Models\SeerMotivo;
use App\Models\SolicitudMotivo;
use App\Models\SolicitudRama;
use App\Models\SolicitudEconomica;
use App\Models\SeerMotivoSolicitud;
use App\Models\SeerSolicitante;
use App\Models\PreRegistro;


//Para sacar el Id del usuario
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Sedes;
use App\Models\Usuarios;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;


class SeerController extends Controller
{   
    public function index()
    {
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $fecha_actual = date('y-m-d');
        
        //Si es delegado le va salir todo lo de su delegacion de todos los roles
        if($userRole[0] == "Notificador"){
            $personas = null;
            $estadisticas = SeerPerGeneral::where('seer_citados.id_notificador', $id)
            ->join('seer_citados','seer_citados.id_solicitud','=','seer_general.id')
            ->where('seer_citados.estatus', 'Pendiente')
            ->select('seer_citados.id','seer_general.NUE','seer_citados.nombre','seer_citados.colonia','seer_citados.estatus')
            ->get();
        }
        //Si es otro usuario le va mostrar unicamente las del ese usuario
        else if($userRole[0] == "Auxiliar"){
            $personas     = SeerPerGeneral::where('fecha', $fecha_actual)->where('user_id', $id)
            ->join('seer_auxiliares','seer_auxiliares.id_solicitud',"=",'seer_general.id')
            ->select("seer_general.id","seer_general.fecha","seer_general.NUE","seer_general.solicitante","seer_auxiliares.tipo_solicitud","seer_general.validado_conciliador")
            ->get();
            $estadisticas = null;
            $asesorias    = SeerAsesoria::where('fecha', $fecha_actual)->where('id_usuario', $id)
            ->selectRaw('count(seer_asesorias.id) as total')
            ->first();
            return view('estadisticas.index',compact('estadisticas','userRole','personas','asesorias'));
        }
        else if($userRole[0] == "Conciliador"){
            //solo le van aparecer solicitudes
            $personas     = SeerPerGeneral::where('conciliador_id', $id)
            ->join('seer_auxiliares','seer_auxiliares.id_solicitud',"=",'seer_general.id')
            ->where('seer_auxiliares.tipo_solicitud','Solicitud')
            ->where('seer_general.validado_conciliador','Pendiente')
            ->get();
            $estadisticas = null;
        }
        else if($userRole[0] == "Delegado"){
            $estadisticas = null;
        }
        if($userRole[0] == "Enlace"){
            $personas = User::whereHas('roles', function ($query) {
                return $query->where('name', '=', 'Notificador');
            })
            ->where('delegacion', $user["delegacion"])
            ->get();

            $estadisticas = SeerPerGeneral::join('seer_citados','seer_citados.id_solicitud','=','seer_general.id')
            ->join('seer_auxiliares','seer_auxiliares.id_solicitud','=','seer_general.id')
            ->select('seer_citados.id','seer_general.NUE','seer_general.solicitante','seer_citados.nombre','seer_citados.direccion','seer_citados.estatus')
            ->where('seer_general.delegacion', $user["delegacion"])
            ->where('seer_citados.id_notificador', 0)
            ->where('seer_auxiliares.notificacion',"!=", "Trabajador")
            ->get();
        }

        return view('estadisticas.index',compact('estadisticas','userRole','personas'));
    }

    public function create()
    {
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $fecha_actual = date('y-m-d');

        $suma_solicitudes = SeerPerGeneral::
        join("seer_auxiliares","seer_auxiliares.id_solicitud", "=" , "seer_general.id")
        ->where("seer_auxiliares.tipo_solicitud","Solicitud")
        ->where('fecha',"=", $fecha_actual)
        ->where('user_id',"=", $id)
        ->selectRaw('count(seer_general.id) as total')
        ->first();

        $suma_ratificaciones = SeerPerGeneral::
        join("seer_auxiliares","seer_auxiliares.id_solicitud", "=" , "seer_general.id")
        ->where("seer_auxiliares.tipo_solicitud","Ratificación")
        ->where('fecha',"=", $fecha_actual)
        ->where('user_id',"=", $id)
        ->selectRaw('count(seer_general.id) as total')
        ->first();

        $total = SeerPerGeneral::
            join("seer_auxiliares","seer_auxiliares.id_solicitud", "=" , "seer_general.id")
            ->where("seer_auxiliares.tipo_solicitud","Ratificación")
            ->where('fecha',"=", $fecha_actual)
            ->where('user_id',"=", $id)
            ->selectRaw('SUM(seer_auxiliares.monto) as monto')
            ->first();

        return view('estadisticas.crearConsentradoAux', compact('user','userRole','suma_solicitudes','suma_ratificaciones','total'));
    }
    
    public function ver_consentrado_aux(){
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $fecha_actual = date('y-m-d');

        $estadisticas  = null;

        return view('estadisticas.crearConsentradoVer', compact('estadisticas','userRole'));
    }

    public function create_notificadores()
    {
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();

        return view('estadisticas.crearNotificador', compact('user','userRole'));
    }

    public function store_notificador(Request $request){
        $data = $request->all();
        $id = auth()->user()->id;
        $user = User::find($id);

        //Validar documentacion
        request()->validate([
            'citatorios'                    => 'required|numeric',
            'asesorias_notificador'         => 'required|numeric',
            'solicitudes_levantadas'        => 'required|numeric',
            'ratificaciones_notificador'    => 'required|numeric',
            'multas_notificador'            => 'required|numeric',
            'informe_diario'                => 'required|numeric',
            'informe_foraneo'               => 'required|numeric',
            'integrar_expediente'           => 'required|numeric',
            'escaneo_documentos'            => 'required|numeric',
        ], $data);

        $data['user_id'] = $user["id"];
        $data['fecha'] = date('Y-m-d');
        $data['delegacion'] = $user["delegacion"];

        SeerNotificadores::create($data);  
        return redirect()->route('seer'); 
    }

    public function store_auxiliares(Request $request){
        $data = $request->all();
        $id = auth()->user()->id;
        $user = User::find($id);

        //Validar documentacion
        request()->validate([
            'solicitudes'           => 'required|numeric',
            'ratificaciones'        => 'required|numeric',
            'asesorias'             => 'required|numeric',
            'expediente_consulta'   => 'required|numeric',
            'expediente_escaneo'    => 'required|numeric',
            'expediente_foliar'     => 'required|numeric',
            'cuantificacion'        => 'required|numeric',
            'exhortos'              => 'required|numeric',
            'audiencias_celebradas' => 'required|numeric',
            'cumplimientos'         => 'required|numeric',
        ], $data);

        $data['user_id'] = $user["id"];
        $data['fecha'] = date('Y-m-d');
        $data['delegacion'] = $user["delegacion"];

        SeerAuxiliares::create($data);  
        return redirect()->route('seer'); 
    
    }

    public function store_conciliadores(Request $request){
        $data = $request->all();
        $id = auth()->user()->id;
        $user = User::find($id);

        //Validar documentacion
        request()->validate([
            'citatorios'                    => 'required|numeric',
            'asesorias_notificador'         => 'required|numeric',
            'solicitudes_levantadas'        => 'required|numeric',
            'ratificaciones_notificador'    => 'required|numeric',
            'razon_registrada'              => 'required|numeric',
            'multas_notificador'            => 'required|numeric',
            'informe_diario'                => 'required|numeric',
            'informe_foraneo'               => 'required|numeric',
            'integrar_expediente'           => 'required|numeric',
            'escaneo_documentos'            => 'required|numeric',
        ], $data);

        $data['user_id'] = $user["id"];
        $data['fecha'] = date('Y-m-d');
        $data['delegacion'] = $user["delegacion"];

        //SeerConciliadores::create($data);  
        return redirect()->route('seer'); 
    
    }

    public function store_delegado(Request $request){
        $data = $request->all();
        $id = auth()->user()->id;
        $user = User::find($id);

        //Validar documentacion
        request()->validate([
            'personas_atendidas'                    => 'required|numeric',
            'asesorias'                             => 'required|numeric',
            'solicitudes_inicio'                    => 'required|numeric',
            'audiencias_programadas'                => 'required|numeric',
            'audiencias_celebradas'                 => 'required|numeric',
            'solicitudes_incopetencia'              => 'required|numeric',
            'convenio_audiencia'                    => 'required|numeric',
            'ratificacion_convenios'                => 'required|numeric',
            'monto_convenios'                       => 'required|numeric',
            'notificaciones'                        => 'required|numeric',
            'contancia_no_conciliacion'             => 'required|numeric',
            'contancia_no_conciliacion_patron'      => 'required|numeric',
            'contancia_no_conciliacion_notificacion'=> 'required|numeric',
            'solicitudes_archivadas'                => 'required|numeric',
            'colectivas'                            => 'required|numeric',
            'mujeres'                               => 'required|numeric',
            'hombres'                               => 'required|numeric',
            'despido_injitificado'                  => 'required|numeric',
            'finiquito'                             => 'required|numeric',
            'derecho_preferencia'                   => 'required|numeric',
            'pago_prestaciones'                     => 'required|numeric',
            'terminacion_volintaria'                => 'required|numeric',
            'supuesto_excepciones'                  => 'required|numeric',
            'otros'                                 => 'required|numeric',
            'multas'                                => 'required|numeric',
            'cincuenta_umas'                        => 'required|numeric',
            'cien_umas'                             => 'required|numeric',
            'otro_monto'                            => 'required|numeric',
        ], $data);

        $data['user_id'] = $user["id"];
        $data['fecha'] = date('Y-m-d');
        $data['delegacion'] = $user["delegacion"];

        SeerDelegados::create($data);  
        return redirect()->route('seer'); 
    
    }

    public function estadistica(){
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $relacionEloquent = 'roles';

        if($userRole[0] == "Super Usuario" || $userRole[0] == "Administrador" || $userRole[0] == "Estadisticas"){
            $usuariosconciliador = User::whereHas($relacionEloquent, function ($query) {
                return $query->where('name', '=', 'Conciliador');
            })
            ->get();
            $usuariosauxiliares = User::whereHas($relacionEloquent, function ($query) {
                return $query->where('name', '=', 'Auxiliar');
            })
            ->get();
            $usuariosnotificadores = User::whereHas($relacionEloquent, function ($query) {
                return $query->where('name', '=', 'Notificador');
            })
            ->get();
            $estadisticas = Sedes::all();
        }
        else if($userRole[0] == "Enlace"){
            $usuariosconciliador = User::whereHas($relacionEloquent, function ($query) {
                return $query->where('name', '=', 'Conciliador');
            })
            ->where('delegacion', $user["delegacion"])
            ->get();
            $usuariosauxiliares = User::whereHas($relacionEloquent, function ($query) {
                return $query->where('name', '=', 'Auxiliar');
            })
            ->where('delegacion', $user["delegacion"])
            ->get();
            $usuariosnotificadores = User::whereHas($relacionEloquent, function ($query) {
                return $query->where('name', '=', 'Notificador');
            })
            ->where('delegacion', $user["delegacion"])
            ->get();
            $esta = Sedes::where('nombre', $user["delegacion"])->first();
            $estadisticas = Sedes::where('nombre', $user["delegacion"])->ORwhere('oficina_apoyo', $esta["id"])->get();
        }
        $estados = Estados::all();
        $municipios = Municipios::all();

        return view('estadisticas.estadistica', compact('user','userRole','estadisticas','usuariosconciliador','usuariosauxiliares','usuariosnotificadores','estados','municipios'));
    }

    public function mostrar_reporte(Request $request){
        $data = $request->all();
        //Primero vamos a validar si el reporte sera cuanticativo o detallado
        //Validar documentacion
        request()->validate([
            //General
            'tipo_reporte'  => 'required|in:UERSJL,Detallado,Concentrado',
        ], $data);

        if(isset($data["sede"]))
            $sede = $data["sede"];
        else
            $sede = "";
        $fecha_inicial = $data["fecha_inicial"];
        $fecha_final   = $data["fecha_final"];
        $id = auth()->user()->id;
        $user = User::find($id);
        $relacionEloquent = "roles";

        //Primeramente reporte detallado
        if($data["tipo_reporte"] == "UERSJL"){
            //Tabla 1
                $conciliadores = User::whereHas($relacionEloquent, function ($query) {
                    return $query->where('name', '=', 'Conciliador');
                })
                ->where('delegacion', $user["delegacion"])
                ->where('remember_token', "Hombres")
                ->select(DB::raw('count(users.id) as hombres'))
                ->first();

                $conciliadoras = User::whereHas($relacionEloquent, function ($query) {
                    return $query->where('name', '=', 'Conciliador');
                })
                ->where('delegacion', $user["delegacion"])
                ->where('remember_token', "Mujer")
                ->select(DB::raw('count(users.id) as mujeres'))
                ->first();
            //Tabla 2
                $notificador = User::whereHas($relacionEloquent, function ($query) {
                    return $query->where('name', '=', 'Notificador');
                })
                ->where('delegacion', $user["delegacion"])
                ->where('remember_token', "Hombres")
                ->select(DB::raw('count(users.id) as hombres'))
                ->first();

                $notificadora = User::whereHas($relacionEloquent, function ($query) {
                    return $query->where('name', '=', 'Notificador');
                })
                ->where('delegacion', $user["delegacion"])
                ->where('remember_token', "Mujer")
                ->select(DB::raw('count(users.id) as mujeres'))
                ->first();
            //ASESORIAS
                $asesorias = SeerAsesoria::join("users","users.id","=","seer_asesorias.id_usuario");
                if($fecha_inicial != ""){
                    $asesorias = $asesorias->where("fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $asesorias = $asesorias->where("fecha","<=",$data["fecha_final"]);
                }
                if($sede != ""){
                    $asesorias = $asesorias->where("seer_asesorias.delegacion","=",$sede);
                }
                $asesorias = $asesorias->select(DB::raw('count(seer_asesorias.id) as asesorias'))
                ->first();
            //Tabla 4
                //Despido
                    $despido_h  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                    $despido_h = $despido_h->join("users","users.id","=","seer_general.user_id");
                    if($fecha_inicial != ""){
                        $despido_h = $despido_h->where("fecha",">=",$fecha_inicial);
                    }   
                    if($fecha_final != ""){
                        $despido_h = $despido_h->where("fecha","<=",$fecha_final);
                    }
                    if($sede != ""){
                        $despido_h = $despido_h->where("seer_general.delegacion", $sede);
                    }
                    $despido_h = $despido_h->where("seer_auxiliares.motivo", "Despido");
                    $despido_h = $despido_h->where("seer_auxiliares.tipo_solicitud", "Solicitud");
                    $despido_h = $despido_h->where("seer_auxiliares.sexo", "H")
                    ->select(DB::raw('count(seer_general.id) as solicitudes'))
                    ->first();

                    $despido_m  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                    $despido_m = $despido_m->join("users","users.id","=","seer_general.user_id");
                    if($fecha_inicial != ""){
                        $despido_m = $despido_m->where("fecha",">=",$fecha_inicial);
                    }   
                    if($fecha_final != ""){
                        $despido_m = $despido_m->where("fecha","<=",$fecha_final);
                    }
                    if($sede != ""){
                        $despido_m = $despido_m->where("seer_general.delegacion", $sede);
                    }
                    $despido_m = $despido_m->where("seer_auxiliares.motivo", "Despido");
                    $despido_m = $despido_m->where("seer_auxiliares.tipo_solicitud", "Solicitud");
                    $despido_m = $despido_m->where("seer_auxiliares.sexo", "M")
                    ->select(DB::raw('count(seer_general.id) as solicitudes'))
                    ->first();

                //Recision de la relación laboral
                    $prestaciones_h  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                    $prestaciones_h = $prestaciones_h->join("users","users.id","=","seer_general.user_id");
                    if($fecha_inicial != ""){
                        $prestaciones_h = $prestaciones_h->where("fecha",">=",$fecha_inicial);
                    }   
                    if($fecha_final != ""){
                        $prestaciones_h = $prestaciones_h->where("fecha","<=",$fecha_final);
                    }
                    if($sede != ""){
                        $prestaciones_h = $prestaciones_h->where("seer_general.delegacion", $sede);
                    }
                    $prestaciones_h = $prestaciones_h->where("seer_auxiliares.motivo", "Recision de la relación laboral");
                    $prestaciones_h = $prestaciones_h->where("seer_auxiliares.tipo_solicitud", "Solicitud");
                    $prestaciones_h = $prestaciones_h->where("seer_auxiliares.sexo", "H")
                    ->select(DB::raw('count(seer_general.id) as solicitudes'))
                    ->first();

                    $prestaciones_m  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                    $prestaciones_m = $prestaciones_m->join("users","users.id","=","seer_general.user_id");
                    if($fecha_inicial != ""){
                        $prestaciones_m = $prestaciones_m->where("fecha",">=",$fecha_inicial);
                    }   
                    if($fecha_final != ""){
                        $prestaciones_m = $prestaciones_m->where("fecha","<=",$fecha_final);
                    }
                    if($sede != ""){
                        $prestaciones_m = $prestaciones_m->where("seer_general.delegacion", $sede);
                    }
                    $prestaciones_m = $prestaciones_m->where("seer_auxiliares.motivo", "Recision de la relación laboral");
                    $prestaciones_m = $prestaciones_m->where("seer_auxiliares.tipo_solicitud", "Solicitud");
                    $prestaciones_m = $prestaciones_m->where("seer_auxiliares.sexo", "M")
                    ->select(DB::raw('count(seer_general.id) as solicitudes'))
                    ->first();

                //Derecho de preferencia
                    $preferencia_h  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                    $preferencia_h = $preferencia_h->join("users","users.id","=","seer_general.user_id");
                    if($fecha_inicial != ""){
                        $preferencia_h = $preferencia_h->where("fecha",">=",$fecha_inicial);
                    }   
                    if($fecha_final != ""){
                        $preferencia_h = $preferencia_h->where("fecha","<=",$fecha_final);
                    }
                    if($sede != ""){
                        $preferencia_h = $preferencia_h->where("seer_general.delegacion", $sede);
                    }
                    $preferencia_h = $preferencia_h->where("seer_auxiliares.motivo", "Recision de la relación laboral");
                    $preferencia_h = $preferencia_h->orWhere("seer_auxiliares.motivo", "Derecho de antiguedad");
                    $preferencia_h = $preferencia_h->where("seer_auxiliares.tipo_solicitud", "Solicitud");
                    $preferencia_h = $preferencia_h->where("seer_auxiliares.sexo", "H")
                    ->select(DB::raw('count(seer_general.id) as solicitudes'))
                    ->first();

                    $preferencia_m  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                    $preferencia_m = $preferencia_m->join("users","users.id","=","seer_general.user_id");
                    if($fecha_inicial != ""){
                        $preferencia_m = $preferencia_m->where("fecha",">=",$fecha_inicial);
                    }   
                    if($fecha_final != ""){
                        $preferencia_m = $preferencia_m->where("fecha","<=",$fecha_final);
                    }
                    if($sede != ""){
                        $preferencia_m = $preferencia_m->where("seer_general.delegacion", $sede);
                    }
                    $preferencia_m = $preferencia_m->where("seer_auxiliares.motivo", "Recision de la relación laboral");
                    $preferencia_m = $preferencia_m->orWhere("seer_auxiliares.motivo", "Derecho de antiguedad");
                    $preferencia_m = $preferencia_m->where("seer_auxiliares.tipo_solicitud", "Solicitud");
                    $preferencia_m = $preferencia_m->where("seer_auxiliares.sexo", "M")
                    ->select(DB::raw('count(seer_general.id) as solicitudes'))
                    ->first();

                //Pago de prestaciones
                    $recision_h  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                    $recision_h = $recision_h->join("users","users.id","=","seer_general.user_id");
                    if($fecha_inicial != ""){
                        $recision_h = $recision_h->where("fecha",">=",$fecha_inicial);
                    }   
                    if($fecha_final != ""){
                        $recision_h = $recision_h->where("fecha","<=",$fecha_final);
                    }
                    if($sede != ""){
                        $recision_h = $recision_h->where("seer_general.delegacion", $sede);
                    }
                    $recision_h = $recision_h->where("seer_auxiliares.motivo", "Pago de prestaciones");
                    $recision_h = $recision_h->where("seer_auxiliares.tipo_solicitud", "Solicitud");
                    $recision_h = $recision_h->where("seer_auxiliares.sexo", "H")
                    ->select(DB::raw('count(seer_general.id) as solicitudes'))
                    ->first();

                    $recision_m  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                    $recision_m = $recision_m->join("users","users.id","=","seer_general.user_id");
                    if($fecha_inicial != ""){
                        $recision_m = $recision_m->where("fecha",">=",$fecha_inicial);
                    }   
                    if($fecha_final != ""){
                        $recision_m = $recision_m->where("fecha","<=",$fecha_final);
                    }
                    if($sede != ""){
                        $recision_m = $recision_m->where("seer_general.delegacion", $sede);
                    }
                    $recision_m = $recision_m->where("seer_auxiliares.motivo", "Pago de prestaciones");
                    $recision_m = $recision_m->where("seer_auxiliares.tipo_solicitud", "Solicitud");
                    $recision_m = $recision_m->where("seer_auxiliares.sexo", "M")
                    ->select(DB::raw('count(seer_general.id) as solicitudes'))
                    ->first();
                //Terminacion voluntaria
                    $terminacion_h  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                    $terminacion_h = $terminacion_h->join("users","users.id","=","seer_general.user_id");
                    if($fecha_inicial != ""){
                        $terminacion_h = $terminacion_h->where("fecha",">=",$fecha_inicial);
                    }   
                    if($fecha_final != ""){
                        $terminacion_h = $terminacion_h->where("fecha","<=",$fecha_final);
                    }
                    if($sede != ""){
                        $terminacion_h = $terminacion_h->where("seer_general.delegacion", $sede);
                    }
                    $terminacion_h = $terminacion_h->where("seer_auxiliares.motivo", "Terminación voluntaria de relación laboral");
                    $terminacion_h = $terminacion_h->where("seer_auxiliares.tipo_solicitud", "Solicitud");
                    $terminacion_h = $terminacion_h->where("seer_auxiliares.sexo", "H")
                    ->select(DB::raw('count(seer_general.id) as solicitudes'))
                    ->first();

                    $terminacion_m  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                    $terminacion_m = $terminacion_m->join("users","users.id","=","seer_general.user_id");
                    if($fecha_inicial != ""){
                        $terminacion_m = $terminacion_m->where("fecha",">=",$fecha_inicial);
                    }   
                    if($fecha_final != ""){
                        $terminacion_m = $terminacion_m->where("fecha","<=",$fecha_final);
                    }
                    if($sede != ""){
                        $terminacion_m = $terminacion_m->where("seer_general.delegacion", $sede);
                    }
                    $terminacion_m = $terminacion_m->where("seer_auxiliares.motivo", "Terminación voluntaria de relación laboral");
                    $terminacion_m = $terminacion_m->where("seer_auxiliares.tipo_solicitud", "Solicitud");
                    $terminacion_m = $terminacion_m->where("seer_auxiliares.sexo", "M")
                    ->select(DB::raw('count(seer_general.id) as solicitudes'))
                    ->first();
                //Supuestos
                    $supuestos_h  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                    $supuestos_h = $supuestos_h->join("users","users.id","=","seer_general.user_id");
                    if($fecha_inicial != ""){
                        $supuestos_h = $supuestos_h->where("fecha",">=",$fecha_inicial);
                    }   
                    if($fecha_final != ""){
                        $supuestos_h = $supuestos_h->where("fecha","<=",$fecha_final);
                    }
                    if($sede != ""){
                        $supuestos_h = $supuestos_h->where("seer_general.delegacion", $sede);
                    }
                    $supuestos_h = $supuestos_h->where("seer_auxiliares.motivo", "Supuestos de Excepción 685-Ter LFT");
                    $supuestos_h = $supuestos_h->where("seer_auxiliares.tipo_solicitud", "Solicitud");
                    $supuestos_h = $supuestos_h->where("seer_auxiliares.sexo", "H")
                    ->select(DB::raw('count(seer_general.id) as solicitudes'))
                    ->first();


                    $supuestos_m  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                    $supuestos_m = $supuestos_m->join("users","users.id","=","seer_general.user_id");
                    if($fecha_inicial != ""){
                        $supuestos_m = $supuestos_m->where("fecha",">=",$fecha_inicial);
                    }   
                    if($fecha_final != ""){
                        $supuestos_m = $supuestos_m->where("fecha","<=",$fecha_final);
                    }
                    if($sede != ""){
                        $supuestos_m = $supuestos_m->where("seer_general.delegacion", $sede);
                    }
                    $supuestos_m = $supuestos_m->where("seer_auxiliares.motivo", "Supuestos de Excepción 685-Ter LFT");
                    $supuestos_m = $supuestos_m->where("seer_auxiliares.tipo_solicitud", "Solicitud");
                    $supuestos_m = $supuestos_m->where("seer_auxiliares.sexo", "M")
                    ->select(DB::raw('count(seer_general.id) as solicitudes'))
                    ->first();
                //Otros
                    $otros_h  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                    $otros_h = $otros_h->join("users","users.id","=","seer_general.user_id");
                    if($fecha_inicial != ""){
                        $otros_h = $otros_h->where("fecha",">=",$fecha_inicial);
                    }   
                    if($fecha_final != ""){
                        $otros_h = $otros_h->where("fecha","<=",$fecha_final);
                    }
                    if($sede != ""){
                        $otros_h = $otros_h->where("seer_general.delegacion", $sede);
                    }
                    $otros_h = $otros_h->where("seer_auxiliares.motivo", "Otros");
                    $otros_h = $otros_h->where("seer_auxiliares.tipo_solicitud", "Solicitud");
                    $otros_h = $otros_h->where("seer_auxiliares.sexo", "H")
                    ->select(DB::raw('count(seer_general.id) as solicitudes'))
                    ->first();


                    $otros_m  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                    $otros_m = $otros_m->join("users","users.id","=","seer_general.user_id");
                    if($fecha_inicial != ""){
                        $otros_m = $otros_m->where("fecha",">=",$fecha_inicial);
                    }   
                    if($fecha_final != ""){
                        $otros_m = $otros_m->where("fecha","<=",$fecha_final);
                    }
                    if($sede != ""){
                        $otros_m = $otros_m->where("seer_general.delegacion", $sede);
                    }
                    $otros_m = $otros_m->where("seer_auxiliares.motivo", "Otros");
                    $otros_m = $otros_m->where("seer_auxiliares.tipo_solicitud", "Solicitud");
                    $otros_m = $otros_m->where("seer_auxiliares.sexo", "M")
                    ->select(DB::raw('count(seer_general.id) as solicitudes'))
                    ->first();
            //Tabala 5
                $incopetencia  = SeerPerGeneral::join("seer_conciliadores","seer_conciliadores.id_solicitud","=","seer_general.id");
                $incopetencia = $incopetencia->join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                if($fecha_inicial != ""){
                    $incopetencia = $incopetencia->where("seer_general.fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $incopetencia = $incopetencia->where("seer_general.fecha","<=",$fecha_final);
                }
                if($sede != ""){
                    $incopetencia = $incopetencia->where("seer_general.delegacion", $sede);
                }
                $incopetencia = $incopetencia->where("seer_conciliadores.estatus_conciliacion", "Archivado por incomparecencia")
                ->select(DB::raw('count(seer_general.id) as solicitudes'))
                ->first();
            //Tabala 6
                $citatorios_C  = SeerPerGeneral::join("seer_citados","seer_citados.id_solicitud","=","seer_general.id");
                $citatorios_C = $citatorios_C->join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                if($fecha_inicial != ""){
                    $citatorios_C = $citatorios_C->where("seer_general.fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $citatorios_C = $citatorios_C->where("seer_general.fecha","<=",$fecha_final);
                }
                if($sede != ""){
                    $citatorios_C = $citatorios_C->where("seer_general.delegacion", $sede);
                }
                $citatorios_C = $citatorios_C->where("seer_auxiliares.notificacion", "Centro");
                $citatorios_C = $citatorios_C->select(DB::raw('count(seer_citados.id) as centro'))
                ->first();

                $citatorios_N  = SeerPerGeneral::join("seer_citados","seer_citados.id_solicitud","=","seer_general.id");
                $citatorios_N = $citatorios_N->join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                if($fecha_inicial != ""){
                    $citatorios_N = $citatorios_N->where("seer_general.fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $citatorios_N = $citatorios_N->where("seer_general.fecha","<=",$fecha_final);
                }
                if($sede != ""){
                    $citatorios_N = $citatorios_N->where("seer_general.delegacion", $sede);
                }
                $citatorios_N = $citatorios_N->where("seer_auxiliares.notificacion", "Trabajador");
                $citatorios_N = $citatorios_N->select(DB::raw('count(seer_citados.id) as centro'))
                ->first();

                $citatorios_A  = SeerPerGeneral::join("seer_citados","seer_citados.id_solicitud","=","seer_general.id");
                $citatorios_A = $citatorios_A->join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                if($fecha_inicial != ""){
                    $citatorios_A = $citatorios_A->where("seer_general.fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $citatorios_A = $citatorios_A->where("seer_general.fecha","<=",$fecha_final);
                }
                if($sede != ""){
                    $citatorios_A = $citatorios_A->where("seer_general.delegacion", $sede);
                }
                $citatorios_A = $citatorios_A->where("seer_auxiliares.notificacion", "Ambos");
                $citatorios_A = $citatorios_A->select(DB::raw('count(seer_citados.id) as centro'))
                ->first();
            //Tabala 6
                $falta_interes  = SeerPerGeneral::join("seer_conciliadores","seer_conciliadores.id_solicitud","=","seer_general.id");
                if($fecha_inicial != ""){
                    $falta_interes = $falta_interes->where("seer_general.fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $falta_interes = $falta_interes->where("seer_general.fecha","<=",$fecha_final);
                }
                if($sede != ""){
                    $falta_interes = $falta_interes->where("seer_general.delegacion", $sede);
                }
                $falta_interes = $falta_interes->where("seer_conciliadores.motivo_archivo", "Falta de interes");
                $falta_interes = $falta_interes->select(DB::raw('count(seer_general.id) as falta_interes'))
                ->first();

                $tramite  = SeerPerGeneral::join("seer_conciliadores","seer_conciliadores.id_solicitud","=","seer_general.id");
                if($fecha_inicial != ""){
                    $tramite = $tramite->where("seer_general.fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $tramite = $tramite->where("seer_general.fecha","<=",$fecha_final);
                }
                if($sede != ""){
                    $tramite = $tramite->where("seer_general.delegacion", $sede);
                }
                $tramite = $tramite->where("seer_general.validado_conciliador", "Pendiente");
                $tramite = $tramite->select(DB::raw('count(seer_general.id) as tramite'))
                ->first();

                $audiencias  = SeerPerGeneral::join("seer_conciliadores","seer_conciliadores.id_solicitud","=","seer_general.id");
                if($fecha_inicial != ""){
                    $audiencias = $audiencias->where("seer_general.fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $audiencias = $audiencias->where("seer_general.fecha","<=",$fecha_final);
                }
                if($sede != ""){
                    $audiencias = $audiencias->where("seer_general.delegacion", $sede);
                }
                $audiencias = $audiencias->where("seer_general.validado_conciliador", "Guardado");
                $audiencias = $audiencias->select(DB::raw('count(seer_general.id) as audiencias'))
                ->first();

                $audiencias  = SeerPerGeneral::join("seer_conciliadores","seer_conciliadores.id_solicitud","=","seer_general.id");
                if($fecha_inicial != ""){
                    $audiencias = $audiencias->where("seer_general.fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $audiencias = $audiencias->where("seer_general.fecha","<=",$fecha_final);
                }
                if($sede != ""){
                    $audiencias = $audiencias->where("seer_general.delegacion", $sede);
                }
                $audiencias = $audiencias->where("seer_general.validado_conciliador", "Guardado");
                $audiencias = $audiencias->select(DB::raw('count(seer_general.id) as audiencias'))
                ->first();

            $pdf = \PDF::loadView('PDF/reporte-UERSJL', compact('conciliadores','conciliadoras','notificador','notificadora','asesorias','despido_h','despido_m','prestaciones_h','prestaciones_m','recision_h',
            'recision_m','preferencia_h','preferencia_m','terminacion_h','terminacion_m','supuestos_h','supuestos_m','otros_h','otros_m','incopetencia','citatorios_C','citatorios_N','citatorios_A',
            'falta_interes','tramite','audiencias'));
            
            return $pdf->stream('archivo.pdf');

        }
        else if($data["tipo_reporte"] == "Cuantificaciones"){
            //SOLICITUDES
                $solicitudes  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                if($fecha_inicial != ""){
                    $solicitudes = $solicitudes->where("fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $solicitudes = $solicitudes->where("fecha","<=",$fecha_final);
                }
                if($sede != ""){
                    $solicitudes = $solicitudes->where("seer_general.delegacion", $sede);
                }
                if($tipo_persona != ""){
                    $solicitudes = $solicitudes->where("seer_auxiliares.tipo_persona", $tipo_persona);
                }
                if($motivo != ""){
                    $solicitudes = $solicitudes->where("seer_auxiliares.motivo", $motivo);
                }
                if($estatus != ""){
                    $solicitudes = $solicitudes->where("seer_auxiliares.estatus", $estatus);
                }
                if($centro != ""){
                    $solicitudes = $solicitudes->where("seer_auxiliares.notificacion", $centro);
                }
                if($auxiliar != ""){
                    $solicitudes = $solicitudes->where("seer_general.user_id", $auxiliar);
                }
                if($notificador != ""){
                    $solicitudes = $solicitudes->where("seer_general.user_id", $notificador);
                }
                if($sexo != ""){
                    $solicitudes = $solicitudes->where("seer_auxiliares.sexo", $sexo);
                }
                if($tipo_solicitud != ""){
                $solicitudes = $solicitudes->where("seer_auxiliares.tipo_solicitud", $tipo_solicitud);
                }
                if($estado_solicitante != ""){
                    $solicitudes = $solicitudes->where("seer_general.estado_solicitante", $estado_solicitante);
                }
                if($mun_solicitante != ""){
                    $solicitudes = $solicitudes->where("seer_general.mun_solicitante", $mun_solicitante);
                }
                if($nue != ""){
                    $solicitudes = $solicitudes->where("seer_general.NUE", $nue);
                }
                $solicitudes = $solicitudes->where("seer_auxiliares.tipo_solicitud", "Solicitud")
                ->selectRaw('count(seer_general.id) as solicitudes')
                ->first();
            //RATIFICACIONES
                $ratificaciones  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                if($fecha_inicial != ""){
                    $ratificaciones = $ratificaciones->where("fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $ratificaciones = $ratificaciones->where("fecha","<=",$fecha_final);
                }
                if($sede != ""){
                    $ratificaciones = $ratificaciones->where("seer_general.delegacion", $sede);
                }
                if($auxiliar != ""){
                    $ratificaciones = $ratificaciones->where("seer_general.user_id", $auxiliar);
                }
                if($sexo != ""){
                    $ratificaciones = $ratificaciones->where("seer_auxiliares.sexo", $sexo);
                }
                if($estado_solicitante != ""){
                    $ratificaciones = $ratificaciones->where("seer_general.estado_solicitante", $estado_solicitante);
                }
                if($mun_solicitante != ""){
                    $ratificaciones = $ratificaciones->where("seer_general.mun_solicitante", $mun_solicitante);
                }
                if($nue != ""){
                    $ratificaciones = $ratificaciones->where("seer_general.NUE", $nue);
                }
                $ratificaciones  = $ratificaciones->where("seer_auxiliares.tipo_solicitud", "Ratificación");
                $ratificaciones  = $ratificaciones->selectRaw('count(seer_general.id) as ratificaciones')
                ->first();
            //MONTO DE AUDIENCIA
                $montoratificaciones  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                if($fecha_inicial != ""){
                    $montoratificaciones = $montoratificaciones->where("fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $montoratificaciones = $montoratificaciones->where("fecha","<=",$fecha_final);
                }
                if($sede != ""){
                    $montoratificaciones = $montoratificaciones->where("seer_general.delegacion", $sede);
                }
                if($auxiliar != ""){
                    $montoratificaciones = $montoratificaciones->where("seer_general.user_id", $auxiliar);
                }
                if($sexo != ""){
                    $montoratificaciones = $montoratificaciones->where("seer_auxiliares.sexo", $sexo);
                }
                if($estado_solicitante != ""){
                    $montoratificaciones = $montoratificaciones->where("seer_general.estado_solicitante", $estado_solicitante);
                }
                if($mun_solicitante != ""){
                    $montoratificaciones = $montoratificaciones->where("seer_general.mun_solicitante", $mun_solicitante);
                }
                if($nue != ""){
                    $montoratificaciones = $montoratificaciones->where("seer_general.NUE", $nue);
                }
                $montoratificaciones = $montoratificaciones->where("seer_auxiliares.tipo_solicitud", "Ratificación");
                $montoratificaciones = $montoratificaciones->selectRaw('sum(seer_auxiliares.monto) as ratificaciones')
                ->first();
            //AUDIENCIA 
                $audiencia  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                $audiencia  = $audiencia->join("seer_conciliadores","seer_conciliadores.id_solicitud","=","seer_general.id");
                if($fecha_inicial != ""){
                    $audiencia = $audiencia->where("fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $audiencia = $audiencia->where("fecha","<=",$fecha_final);
                }
                if($sede != ""){
                    $audiencia = $audiencia->where("seer_general.delegacion", $sede);
                }
                if($conciliador != ""){
                    $audiencia = $audiencia->where("seer_general.conciliador_id", $conciliador);
                }
                if($tipo_audiencia != ""){
                    $audiencia = $audiencia->where("seer_conciliadores.estatus_conciliacion", $tipo_audiencia);
                }
                if($sexo != ""){
                    $audiencia = $audiencia->where("seer_auxiliares.sexo", $sexo);
                }
                if($estado_solicitante != ""){
                    $audiencia = $audiencia->where("seer_general.estado_solicitante", $estado_solicitante);
                }
                if($mun_solicitante != ""){
                    $audiencia = $audiencia->where("seer_general.mun_solicitante", $mun_solicitante);
                }
                if($nue != ""){
                    $audiencia = $audiencia->where("seer_general.NUE", $nue);
                }
                $audiencia  = $audiencia->where("seer_auxiliares.tipo_solicitud", "Solicitud");
                $audiencia  = $audiencia->selectRaw('count(seer_general.id) as audiencia')
                ->first();
            //MONTO DE AUDIENCIA
                $montoaudiencia  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                $montoaudiencia  = $montoaudiencia->join("seer_conciliadores","seer_conciliadores.id_solicitud","=","seer_general.id");
                if($fecha_inicial != ""){
                    $montoaudiencia = $montoaudiencia->where("fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $montoaudiencia = $montoaudiencia->where("fecha","<=",$fecha_final);
                }
                if($sede != ""){
                    $montoaudiencia = $montoaudiencia->where("seer_general.delegacion", $sede);
                }
                if($conciliador != ""){
                    $montoaudiencia = $montoaudiencia->where("seer_general.conciliador_id", $conciliador);
                }
                if($tipo_audiencia != ""){
                    $montoaudiencia = $montoaudiencia->where("seer_conciliadores.estatus_conciliacion", $tipo_audiencia);
                }
                if($sexo != ""){
                    $montoaudiencia = $montoaudiencia->where("seer_auxiliares.sexo", $sexo);
                }
                if($estado_solicitante != ""){
                    $montoaudiencia = $montoaudiencia->where("seer_general.estado_solicitante", $estado_solicitante);
                }
                if($mun_solicitante != ""){
                    $montoaudiencia = $montoaudiencia->where("seer_general.mun_solicitante", $mun_solicitante);
                }
                if($nue != ""){
                    $montoaudiencia = $montoaudiencia->where("seer_general.NUE", $nue);
                }
                $montoaudiencia = $montoaudiencia->where("seer_auxiliares.tipo_solicitud", "Solicitud");
                $montoaudiencia = $montoaudiencia->selectRaw('sum(seer_conciliadores.monto) as audiencia')
                ->first();
            //COLECTIVAS
                $colectivas = SeerColectivas::join("users","users.id","=","seer_colectivas.conciliador");
                if($fecha_inicial != ""){
                    $colectivas = $colectivas->where("fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $colectivas = $colectivas->where("fecha","<=",$data["fecha_final"]);
                }
                if($conciliador != ""){
                    $colectivas = $colectivas->where("seer_colectivas.conciliador", $conciliador);
                }
                if($estado_solicitante != ""){
                    $colectivas = $colectivas->where("seer_colectivas.estado_solicitante", $estado_solicitante);
                }
                if($nue != ""){
                    $colectivas = $colectivas->where("seer_colectivas.NUE", $nue);
                }
                $colectivas = $colectivas->selectRaw('count(seer_colectivas.id) as colectivas')
                ->first();
            //CONVENIOS
                $convenios = SeerConvenios::join("users","users.id","=","seer_convenios.user_id");
                if($fecha_inicial != ""){
                    $convenios = $convenios->where("fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $convenios = $convenios->where("fecha","<=",$data["fecha_final"]);
                }
                $convenios = $convenios->selectRaw('count(seer_convenios.id) as convenios')
                ->first();

                $total_pagos = SeerConvenios::join("users","users.id","=","seer_convenios.user_id");
                if($fecha_inicial != ""){
                    $total_pagos = $total_pagos->where("fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $total_pagos = $total_pagos->where("fecha","<=",$data["fecha_final"]);
                }
                $total_pagos = $total_pagos->selectRaw('SUM(seer_convenios.monto) as monto_pagos')
                ->first();
            //ASESORIAS
                $asesorias = SeerAsesoria::join("users","users.id","=","seer_asesorias.id_usuario");
                if($fecha_inicial != ""){
                    $asesorias = $asesorias->where("fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $asesorias = $asesorias->where("fecha","<=",$data["fecha_final"]);
                }
                /*
                if($delegacion != ""){
                    $asesorias = $asesorias->where("delegacion",$data["delegacion"]);
                }
                */
                $asesorias = $asesorias->selectRaw('count(seer_asesorias.id) as asesorias')
                ->first();
            //El numero de convenios con contancias de no conciliacion
                $no_conciliacion  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                $no_conciliacion  = $audiencia->join("seer_conciliadores","seer_conciliadores.id_solicitud","=","seer_general.id");
                if($fecha_inicial != ""){
                    $no_conciliacion = $no_conciliacion->where("fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $no_conciliacion = $no_conciliacion->where("fecha","<=",$fecha_final);
                }
                if($sede != ""){
                    $no_conciliacion = $no_conciliacion->where("seer_general.delegacion", $sede);
                }
                if($conciliador != ""){
                    $no_conciliacion = $no_conciliacion->where("seer_general.conciliador_id", $conciliador);
                }
                if($tipo_audiencia != ""){
                    $no_conciliacion = $no_conciliacion->where("seer_conciliadores.estatus_conciliacion", $tipo_audiencia);
                }
                if($sexo != ""){
                    $no_conciliacion = $no_conciliacion->where("seer_auxiliares.sexo", $sexo);
                }
                if($estado_solicitante != ""){
                    $no_conciliacion = $no_conciliacion->where("seer_general.estado_solicitante", $estado_solicitante);
                }
                if($mun_solicitante != ""){
                    $no_conciliacion = $no_conciliacion->where("seer_general.mun_solicitante", $mun_solicitante);
                }
                if($nue != ""){
                    $no_conciliacion = $no_conciliacion->where("seer_general.NUE", $nue);
                }
                $no_conciliacion  = $no_conciliacion->where("seer_conciliadores.estatus_conciliacion", "No conciliacion");
                $no_conciliacion  = $no_conciliacion->selectRaw('count(seer_general.id) as audiencia')
                ->first();

            $convenios_total = $solicitudes["solicitudes"] + $ratificaciones["ratificaciones"];
            $porcenaje = ($convenios_total) / ($convenios_total + $no_conciliacion["audiencia"]);
             
            return view('estadisticas.ver_reporte_cuantitativo', compact('solicitudes','ratificaciones','montoratificaciones','audiencia','montoaudiencia','colectivas','convenios','porcenaje','total_pagos','asesorias'));
        }
        else if($data["tipo_reporte"] == "Concentrado"){
            //SOLICITUDES
                $solicitudes  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                $solicitudes = $solicitudes->join("users","users.id","=","seer_general.user_id");
                if($fecha_inicial != ""){
                    $solicitudes = $solicitudes->where("fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $solicitudes = $solicitudes->where("fecha","<=",$fecha_final);
                }
                if($sede != ""){
                    $solicitudes = $solicitudes->where("seer_general.delegacion", $sede);
                }
                $solicitudes = $solicitudes->where("seer_auxiliares.tipo_solicitud", "Solicitud")
                ->select('users.id', 'users.name', DB::raw('count(seer_general.id) as solicitudes'))
                ->groupBy('users.id', 'users.name')
                ->get();
            //RATIFICACIONES
                $ratificaciones  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                $ratificaciones = $ratificaciones->join("users","users.id","=","seer_general.user_id");
                if($fecha_inicial != ""){
                    $ratificaciones = $ratificaciones->where("fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $ratificaciones = $ratificaciones->where("fecha","<=",$fecha_final);
                }
                if($sede != ""){
                    $ratificaciones = $ratificaciones->where("seer_general.delegacion", $sede);
                }            
                $ratificaciones  = $ratificaciones->where("seer_auxiliares.tipo_solicitud", "Ratificación");
                $ratificaciones  = $ratificaciones->select('users.id', 'users.name', DB::raw('count(seer_general.id) as ratificaciones'), DB::raw('sum(seer_auxiliares.monto) as monto'))
                ->groupBy('users.id', 'users.name')
                ->get();
            //AUDIENCIA 
                $audiencia  = SeerPerGeneral::join("seer_conciliadores","seer_conciliadores.id_solicitud","=","seer_general.id");
                $audiencia  = $audiencia->join("users","users.id","=","seer_general.conciliador_id");
                if($fecha_inicial != ""){
                    $audiencia = $audiencia->where("fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $audiencia = $audiencia->where("fecha","<=",$fecha_final);
                }
                if($sede != ""){
                    $audiencia = $audiencia->where("seer_general.delegacion", $sede);
                }
                
                $audiencia  = $audiencia->select('users.id', 'users.name', DB::raw('count(seer_general.id) as audiencia'),  DB::raw('sum(seer_conciliadores.monto) as suma_audiencia'))
                ->groupBy('users.id', 'users.name')
                ->get();
            //MONTO DE AUDIENCIA
                $montoaudiencia  = SeerPerGeneral::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general.id");
                $montoaudiencia  = $montoaudiencia->join("seer_conciliadores","seer_conciliadores.id_solicitud","=","seer_general.id");
                $montoaudiencia  = $montoaudiencia->join("users","users.id","=","seer_general.user_id");
                if($fecha_inicial != ""){
                    $montoaudiencia = $montoaudiencia->where("fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $montoaudiencia = $montoaudiencia->where("fecha","<=",$fecha_final);
                }
                if($sede != ""){
                    $montoaudiencia = $montoaudiencia->where("seer_general.delegacion", $sede);
                }
                $montoaudiencia = $montoaudiencia->where("seer_auxiliares.tipo_solicitud", "Solicitud");
                $montoaudiencia = $montoaudiencia->select('users.id', 'users.name', DB::raw('sum(seer_conciliadores.monto) as audiencia'))
                ->groupBy('users.id', 'users.name')
                ->get();
            //COLECTIVAS
                $colectivas = SeerColectivas::join("users","users.id","=","seer_colectivas.conciliador");
                if($fecha_inicial != ""){
                    $colectivas = $colectivas->where("seer_colectivas.fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $colectivas = $colectivas->where("seer_colectivas.fecha","<=",$data["fecha_final"]);
                }
                $colectivas = $colectivas->where("seer_colectivas.delegacion", $sede);
                $colectivas = $colectivas->select('users.id', 'users.name', DB::raw('count(seer_colectivas.id) as colectivas'))
                ->groupBy('users.id', 'users.name')
                ->get();
            //CONVENIOS
                $convenios = SeerConvenios::join("users","users.id","=","seer_convenios.user_id");
                $convenios  = $convenios->join("seer_general","seer_convenios.NUE","=","seer_general.NUE");
                if($fecha_inicial != ""){
                    $convenios = $convenios->where("seer_convenios.fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $convenios = $convenios->where("seer_convenios.fecha","<=",$data["fecha_final"]);
                }
                $convenios = $convenios->where("seer_general.delegacion", $sede);
                $convenios = $convenios->select('users.id', 'users.name', DB::raw('count(seer_convenios.id) as convenios'), DB::raw('SUM(seer_convenios.monto) as monto_pagos'))
                ->groupBy('users.id', 'users.name')
                ->get();
            //ASESORIAS
                $asesorias = SeerAsesoria::join("users","users.id","=","seer_asesorias.id_usuario");
                if($fecha_inicial != ""){
                    $asesorias = $asesorias->where("fecha",">=",$fecha_inicial);
                }   
                if($fecha_final != ""){
                    $asesorias = $asesorias->where("fecha","<=",$data["fecha_final"]);
                }
                $asesorias = $asesorias->where("seer_asesorias.delegacion", $sede);
                $asesorias = $asesorias->select('users.id', 'users.name', DB::raw('count(seer_asesorias.id) as asesorias'))
                ->groupBy('users.id', 'users.name')
                ->get();
            
                $porcenaje=0;
                $pdf = \PDF::loadView('PDF/vista-prueba', compact('solicitudes','ratificaciones','audiencia','montoaudiencia','colectivas','convenios','porcenaje','asesorias'));
    
            return $pdf->stream('archivo.pdf');
            //return $pdf->download('archivo.pdf');

            //return view('estadisticas.ver_reporte_cuantitativo', compact('solicitudes','ratificaciones','montoratificaciones','audiencia','montoaudiencia','colectivas','convenios','porcenaje'));
        }


    }

    public function create_persona_s(){
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $estados = Estados::all();
        $municipios = Municipios::all();
        $relacionEloquent = 'roles';

        $conciliadores = User::whereHas($relacionEloquent, function ($query) {
            return $query->where('name', '=', 'Conciliador');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();

        return view('estadisticas.crearPersonaAux', compact('user','userRole','municipios','estados','conciliadores'));
    }

    public function create_persona_r(){
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $estados = Estados::all();
        $municipios = Municipios::all();
        $relacionEloquent = 'roles';

        $conciliadores = User::whereHas($relacionEloquent, function ($query) {
            return $query->where('name', '=', 'Conciliador');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();

        return view('estadisticas.crearPersonaAuxR', compact('user','userRole','municipios','estados','conciliadores'));
    }

    public function obtenerMunicipio($id){
        return Municipios::where('estado', $id)->get();
    }

    public function auxiliar_persona(Request $request){
        $data = $request->all();
        $id = auth()->user()->id;
        $user = User::find($id);
        $fecha_actual = date('y-m-d');
        $cont = count($data["citado"]);

        //Validar el Numero de expediente
        $nue = SeerPerGeneral::where("NUE",$data["NUE"])->first();
        if($nue){
            return back()->withErrors('El Numero de expediente '.$nue->NUE.' ya existe.');
        }

        //Validar documentacion
        request()->validate([
            //General
            'NUE'                   => 'required|min:18|max:18',
            'solicitante'           => 'required',
            'estado_solicitante'    => 'required|numeric',
            'mun_solicitante'       => 'required|numeric',
            'actividad_economica'   => 'required',
            'conciliador_id'        => 'required|numeric',

            //Auxiliares
            'sexo'                  => 'required|in:H,M',
            'motivo'                => 'required|in:Despido,Pago de prestaciones,Recision de la relación laboral,Derecho de preferencia,Derecho de antiguedad,Derecho de ascesnso,Terminación voluntaria de relación laboral,Supuestos de Excepción 685-Ter LFT,Otros',
            'notificacion'          => 'required|in:Trabajador,Centro,Ambos',

        ], $data);

        $data_general = [
            'fecha'                 => $fecha_actual,
            'fecha_confimacion'     => $data["fecha_confirmacion"],
            'NUE'                   => $data["NUE"],
            'solicitante'           => $data["solicitante"],
            'estado_solicitante'    => $data["estado_solicitante"],
            'mun_solicitante'       => $data["mun_solicitante"],
            'user_id'               => $id,
            'conciliador_id'        => $data["conciliador_id"],
            'delegacion'            => $user["delegacion"],
        ];

        SeerPerGeneral::create($data_general);  
        $id_general  = SeerPerGeneral::latest('id')->first();

        $data_auxiliar = [
            'id_solicitud'              => $id_general["id"],
            'sexo'                      => $data["sexo"],
            'actividad_economica'       => $data["actividad_economica"],
            'motivo'                    => $data["motivo"],
            'notificacion'              => $data["notificacion"],
            'tipo_solicitud'            => "Solicitud",
            'monto'                     => "0"
        ];
        
        SeerPerAuxiliar::create($data_auxiliar);  

        for($i = 0; $i < $cont; $i++) {
            $data_citado = [
                'id_solicitud'  => $id_general["id"],
                'fecha'         => $fecha_actual,
                'nombre'        => $data["citado"][$i],
                'direccion'     => $data["direccion"][$i], 
                'id_municipio'  => 0, 
                'id_estado'     => 0,
                'observaciones' => ''
            ];
            SeerCitados::create($data_citado);
        }

        return redirect()->route('seer');
    }

    public function auxiliar_personar(Request $request){
        $data = $request->all();
        $id = auth()->user()->id;
        $user = User::find($id);
        $fecha_actual = date('y-m-d');
        
        //Validar el Numero de expediente
        $nue = SeerPerGeneral::where("NUE",$data["NUE"])->first();
        if($nue){
            return back()->withErrors('El Numero de expediente '.$nue->NUE.' ya existe.');
        }
        //Validar documentacion
        request()->validate([
            //General
            'NUE'                   => 'required|min:18|max:18',
            'solicitante'           => 'required',
            'estado_solicitante'    => 'required|numeric',
            'mun_solicitante'       => 'required|numeric',
            'actividad_economica'   => 'required',

            //Auxiliares
            'sexo'                  => 'required|in:H,M',
            'motivo'                => 'required|in:Despido,Pago de prestaciones,Recision de la relación laboral,Derecho de preferencia,Derecho de antiguedad,Derecho de ascesnso,Terminación voluntaria de relación laboral',
            'monto'                 => 'required|numeric',
            'estatus'               => 'required|in:Pendiente,Parcial,Cumplido',
        ], $data);

        $data_general = [
            'fecha'                 => $fecha_actual,
            'NUE'                   => $data["NUE"],
            'solicitante'           => $data["solicitante"],
            'estado_solicitante'    => $data["estado_solicitante"],
            'mun_solicitante'       => $data["mun_solicitante"],
            'user_id'               => $id,
            'delegacion'            => $user["delegacion"],
        ];

        SeerPerGeneral::create($data_general);  
        $id_general  = SeerPerGeneral::latest('id')->first();

        $data_auxiliar = [
            'id_solicitud'              => $id_general["id"],
            'sexo'                      => $data["sexo"],
            'actividad_economica'       => $data["actividad_economica"],
            'motivo'                    => $data["motivo"],
            'monto'                     => $data["monto"],
            'estatus'                   => $data["estatus"],
            'tipo_solicitud'            => "Ratificación",
        ];
        SeerPerAuxiliar::create($data_auxiliar);  

        if(isset($data["citado"])) {
            $cont = count($data["citado"]);
            for($i = 0; $i < $cont; $i++) {
                $data_citado = [
                    'id_solicitud'  => $id_general["id"],
                    'fecha'         => $fecha_actual,
                    'nombre'        => $data["citado"][$i], 
                    'direccion'     => $data["direccion"][$i], 
                    //'id_municipio'  => $data["estado_citado"][$i], 
                    //'id_estado'     => $data["municipio_citado"][$i]
                ];
                SeerCitados::create($data_citado);
            }
        }

        return redirect()->route('seer');
    }

    public function ver_auxiliar($id){
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $userRole = $user->roles->pluck('name')->all();

        $general  = SeerPerGeneral::find($id);
        $auxiliar = SeerPerAuxiliar::where("id_solicitud",$id)->first();
        
        $estado_citado = Estados::find($general["estado_solicitante"]);
        $mun_citado    = Municipios::find($general["mun_solicitante"]);

        $estado_solicitante = Estados::find($general["estado_citado"]);
        $mun_solicitante    = Municipios::find($general["mun_citado"]);
        $conciliador        = User::find($general["conciliador_id"]);

        $citados           = SeerCitados::where("id_solicitud",$id)->get();
        $notificadores     = SeerCitados::where("id_solicitud",$id)
        ->join("users","users.id","=","seer_citados.id_notificador")
        ->select("users.name as notificador", "seer_citados.created_at", "seer_citados.nombre as citado","seer_citados.direccion","seer_citados.estatus")
        ->get();
        $audiencia          = SeerPerConciliador::where("id_solicitud",$id)->get();
        $registro  = User::find($general["user_id"]);

        return view('estadisticas.verPersonaAux', compact('userRole','general','auxiliar','estado_citado','mun_citado','estado_solicitante','mun_solicitante','conciliador','citados','audiencia','notificadores','registro'));
    }

    public function conciliador_persona(Request $request){
        $data = $request->all();
        
        $id = auth()->user()->id;
        $user = User::find($id);
        $fecha_actual = date('y-m-d');
        $cont = count($data["citado"]);

        //Validar documentacion
        request()->validate([
            'id'                    => 'required|numeric',
            'citado'                => 'required',
            'actividad_economica'   => 'required',
            'numero_audiencias'     => 'required',
            'estatus'               => 'required|in:Conciliacion,No conciliacion,Regenerada,Archivada',
            'monto'                 => 'required|numeric',
            'multa'                 => 'required|in:Si,No',
            'solicitud'             => 'required|in:Presencial,Linea',
        ], $data);


        if($data["estatus"] == "Conciliacion" || $data["estatus"] == "No conciliacion" || $data["estatus"] == "Archivada"){
            SeerPerGeneral::where('id', $data["id"])
            ->update(['NUE' => $data["NUE"], 'solicitante' => $data["solicitante"], 'estado_solicitante'  => $data["estado_solicitante"],
            'mun_solicitante' => $data["mun_solicitante"], 'validado_conciliador' => "Guardado"]);
        }

        SeerPerAuxiliar::where('id_solicitud', $data["id"])
        ->update(['actividad_economica' => $data["actividad_economica"], 'motivo' => $data["motivo"], 'notificacion' => $data["notificacion"]]);
        
        $data_conciliador = [
            'id_solicitud'          => $data["id"],
            'numero_audiencia'      => $data["numero_audiencia"],
            'numero_audiencias'     => $data["numero_audiencias"],
            'estatus_conciliacion'  => $data["estatus"],
            'monto'                 => $data["monto"],
            'rfc'                   => $data["rfc"],
            'NSS'                   => $data["NSS"],
            'multa'                 => $data["multa"],
            'tipo'                  => $data["solicitud"],
            'validado'              => 'Validado',
        ];
        if($data["multa"] != "Si"){
            $data_conciliador["monto_multa"] = $data["monto_multa"];
        }
        if($data["motivo_archivo"] != null || $data["motivo_archivo"] != ''){
            $data_conciliador["motivo_archivo"] = $data["motivo_archivo"];
        }
        if($data["fecha_reprogracion"] != null || $data["fecha_reprogracion"] != ''){
            $data_conciliador["fecha_reprogracion"] = $data["fecha_reprogracion"];
        }
        if($data["estatus"] == "Conciliacion" || $data["estatus"] == "No conciliacion"){
            $data_conciliador["fecha_conclucion"] = $fecha_actual;
        }
        
        SeerCitados::where('id_solicitud',$data["id"])->delete();

        for($i = 0; $i < $cont; $i++) {
            $data_citado = [
                'id_solicitud'  => $data["id"],
                'fecha'         => $fecha_actual,
                'nombre'        => $data["citado"][$i],
                'direccion'     => $data["direccion"][$i], 
                'id_municipio'  => 0, 
                'id_estado'     => 0,
                'observaciones' => ''
            ];
            SeerCitados::create($data_citado);
        }

        SeerPerConciliador::create($data_conciliador);  

        return redirect()->route('seer');
    }
  
    public function crear_audiencia($id){
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $userRole = $user->roles->pluck('name')->all();

        $general  = SeerPerGeneral::find($id);
        $auxiliar = SeerPerAuxiliar::where("id_solicitud",$id)->first();
        $audiencia = SeerPerConciliador::where("id_solicitud",$id)->get();

        $citados = SeerCitados::
        where("seer_citados.id_solicitud",$id)
        //->join("seer_general","seer_citados.id_solicitud", "=" , "seer_general.id")
        ->select('seer_citados.nombre as citado', 'seer_citados.direccion')
        //->groupBy("seer_citados.id")
        ->get();

        //Voy a mandar todos las variables
        $estados            = Estados::all();
        $municipios         = Municipios::all();
        $estado_solicitante = Estados::find($general["estado_solicitante"]);
        $mun_solicitante    = Municipios::find($general["mun_solicitante"]);
        $conciliador        = User::find($general["conciliador_id"]);
        

        return view('estadisticas.crearPersonaCon', compact('userRole','general','auxiliar','citados','mun_solicitante','estado_solicitante','conciliador','audiencia','estados','municipios'));
    }

    public function ver_conciliador($id){
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $userRole = $user->roles->pluck('name')->all();

        $general  = SeerPerGeneral::find($id);
        $auxiliar = SeerPerAuxiliar::where("id_solicitud",$id)->first();
        $audiencia = SeerPerConciliador::where("id_solicitud",$id)->get();

        $estado_citado = Estados::find($general["estado_solicitante"]);
        $mun_citado    = Municipios::find($general["mun_solicitante"]);

        $estado_solicitante = Estados::find($general["estado_citado"]);
        $mun_solicitante    = Municipios::find($general["mun_citado"]);

        $conciliador = SeerPerConciliador::where("id_solicitud",$id)->first();

        return view('estadisticas.verPersonaCon', compact('userRole','general','auxiliar','estado_citado','mun_citado','estado_solicitante','mun_solicitante','conciliador','audiencia'));
    }

    public function index_convenios(){
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $fecha_actual = date('y-m-d');

        //solo le van aparecer solicitudes
        $convenios = SeerConvenios::where('fecha', $fecha_actual)->where('user_id', $id)->get();

        return view('estadisticas.index_convenios',compact('convenios','userRole'));
    }
    
    public function crear_convenio(){
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $fecha_actual = date('y-m-d');
        
       
        //solo le van aparecer solicitudes
        $convenios = SeerConvenios::where('fecha', $fecha_actual)->where('user_id', $id)->get();

        return view('estadisticas.crear_convenio',compact('convenios','userRole'));
    }

    public function store_convenio(Request $request){
        $data = $request->all();
        $id = auth()->user()->id;
        $user = User::find($id);
        $fecha_actual = date('y-m-d');

        //Validar documentacion
        request()->validate([
            'fecha'         => 'required|date',
            'NUE'           => 'required|min:18|max:18',
            'monto'         => 'required|numeric',
            'tipo_pago'     => 'required',
        ], $data);
        $data['user_id'] = $id;

        SeerConvenios::create($data);  

        return redirect()->route('index_convenios');
    }

    public function index_colectivas(){
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $fecha_actual = date('y-m-d');
        
       
        //solo le van aparecer solicitudes
        $convenios = SeerColectivas::where('fecha', $fecha_actual)->where('conciliador', $id)->get();

        return view('estadisticas.index_colectivas',compact('convenios','userRole'));
    }

    public function crear_colectiva(){
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $fecha_actual = date('y-m-d');
        
       
        //solo le van aparecer solicitudes
        //$convenios = SeerConvenios::where('fecha', $fecha_actual)->where('conciliador', $id)->get();

        return view('estadisticas.crear_colectiva',compact('userRole'));
    }

    public function store_colectiva(Request $request){
        $data = $request->all();
        $id = auth()->user()->id;
        $user = User::find($id);
        $fecha_actual = date('y-m-d');

        //Validar documentacion
        request()->validate([
            'fecha'         => 'required|date',
            'NUE'           => 'required|min:18|max:18',
            'solicitante'   => 'required',
            'citado'        => 'required',
            'juzgado'       => 'required',
            'estado'        => 'required',
        ], $data);
        $data['conciliador'] = $id;

        SeerColectivas::create($data);  

        return redirect()->route('index_colectivas');
    }

    public function create_conciliador(){
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $fecha_actual = date('y-m-d');

        $suma_solicitudes = SeerPerGeneral::
        join("seer_auxiliares","seer_auxiliares.id_solicitud", "=" , "seer_general.id")
        ->where("seer_auxiliares.tipo_solicitud","Solicitud")
        ->where('fecha',"=", $fecha_actual)
        ->where('user_id',"=", $id)
        ->selectRaw('count(seer_general.id) as total')
        ->first();

        $suma_ratificaciones = SeerPerGeneral::
        join("seer_auxiliares","seer_auxiliares.id_solicitud", "=" , "seer_general.id")
        ->where("seer_auxiliares.tipo_solicitud","Ratificación")
        ->where('fecha',"=", $fecha_actual)
        ->where('user_id',"=", $id)
        ->selectRaw('count(seer_general.id) as total')
        ->first();

        $total = SeerPerGeneral::
            join("seer_auxiliares","seer_auxiliares.id_solicitud", "=" , "seer_general.id")
            ->where("seer_auxiliares.tipo_solicitud","Ratificación")
            ->where('fecha',"=", $fecha_actual)
            ->where('user_id',"=", $id)
            ->selectRaw('SUM(seer_auxiliares.monto) as monto')
            ->first();

        $suma_solicitudes_conciliador = SeerPerGeneral::
            join("seer_auxiliares","seer_auxiliares.id_solicitud", "=" , "seer_general.id")
            ->where('fecha',"=", $fecha_actual)
            ->where('conciliador_id',"=", $id)
            ->selectRaw('count(seer_general.id) as total')
            ->first();

        $total_audiencia = SeerPerGeneral::
            join("seer_conciliadores","seer_conciliadores.id_solicitud", "=" , "seer_general.id")
            ->where('fecha',"=", $fecha_actual)
            ->where('conciliador_id',"=", $id)
            ->selectRaw('SUM(seer_conciliadores.monto) as monto')
            ->first();

        return view('estadisticas.crearConsentradoCon', compact('user','userRole','suma_solicitudes','suma_ratificaciones','total','suma_solicitudes_conciliador','total_audiencia'));
    }

    public function ver_consentrado_con(){
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $fecha_actual = date('y-m-d');

        $estadisticas  = null;

        return view('estadisticas.crearConcentradoConVer', compact('estadisticas','userRole'));
    }

    public function obtenerCitados($id){
        return SeerCitados::where('id_solicitud', $id)->get();
    }


    public function seer_estatus($id){
        $citados  = SeerCitados::find($id);
        $id = $citados->id;

        return view('estadisticas.actualizarCitado', compact('id'));
    }

    public function update_notificador(Request $request){
        $data = $request->all();

        SeerCitados::where('id', $data["id"])
        ->update(['estatus' => $data["estatus"]],['obervaciones' => $data["observaciones"]]);

        return redirect()->route('seer'); 
    }

    public function store_enlace(Request $request){
        $data = $request->all();
        SeerCitados::where('id', $data["id"])
        ->update(['id_notificador' => $data["notificador"]]);

        return redirect()->route('notificaciones');
    }

    public function create_asesoria(){
        return view('estadisticas.crearAsesorias');
    }

    public function store_asesorias(Request $request){
        $data = $request->all();
        $id = auth()->user()->id;
        $user = User::find($id);

        //Validar documentacion
        request()->validate([
            'nombre' => 'required',
            'sexo'   => 'required',
        ], $data);

        $data['id_usuario'] = $user["id"];
        $data['fecha'] = date('Y-m-d');
        $data['delegacion'] = $user["delegacion"];

        SeerAsesoria::create($data);  
        return redirect()->route('seer');
    }
    
    public function destroy($id)
    {
        //Borrar de la tabla Seer Auxiliares
        SeerPerAuxiliar::where('id_solicitud',$id)->delete();
        //Borrar de la tabla Seer Auxiliares
        SeerCitados::where('id_solicitud',$id)->delete();
        //Borrar de la tabla Seer General
        SeerPerGeneral::find($id)->delete();
       
        return redirect()->route('seer');
    }

    public function editar_persona($id){
        $id_usurario = auth()->user()->id;
        $user = User::find($id_usurario);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $relacionEloquent = "roles";
        
        $general    = SeerPerGeneral::find($id);
        //dd($general);
        $auxiliar   = SeerPerAuxiliar::where("id_solicitud",$id)->first();
        //dd($auxiliar);
        $estados    = Estados::all();
        $municipios = Municipios::all();
        $citados    = SeerCitados::where("id_solicitud",$id)->get();
        //dd($citados);
        $conciliador= User::find($general["conciliador_id"]);
        $conciliadores = User::whereHas($relacionEloquent, function ($query) {
            return $query->where('name', '=', 'Conciliador');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();
        
        return view('estadisticas.editar_auxiliar', compact('userRole','general','auxiliar','municipios','conciliador','estados','conciliadores','citados'));  
    }

    public function update_auxiliar(Request $request){
        $data = $request->all();
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $fecha_actual = date('y-m-d');
        $cont = count($data["citado"]);

        //Validar documentacion
        request()->validate([
            //General
            'NUE'                   => 'required|min:18|max:18',
            'solicitante'           => 'required',
            'estado_solicitante'    => 'required|numeric',
            'mun_solicitante'       => 'required|numeric',
            'actividad_economica'   => 'required',
            'conciliador_id'        => 'required|numeric',

            //Auxiliares
            'sexo'                  => 'required|in:H,M',
            'motivo'                => 'required|in:Despido,Pago de prestaciones,Recision de la relación laboral,Derecho de preferencia,Derecho de antiguedad,Derecho de ascesnso,Terminación voluntaria de relación laboral',
            'notificacion'          => 'required|in:Trabajador,Centro,Ambos',

        ], $data);

        

        SeerPerGeneral::where('id', $data["id"])
        ->update(['fecha_confirmacion'   => $data["fecha_confirmacion"], 'NUE' => $data["NUE"], 'solicitante' => $data["solicitante"], 'estado_solicitante'  => $data["estado_solicitante"],
        'mun_solicitante' => $data["mun_solicitante"], 'user_id' => $id_usuario, 'conciliador_id' => $data["conciliador_id"]]);
        
        SeerPerAuxiliar::where('id_solicitud', $data["id"])
        ->update(['sexo' => $data["sexo"], 'actividad_economica' => $data["actividad_economica"], 'motivo' => $data["motivo"], 'notificacion' => $data["notificacion"]]);

        SeerCitados::where('id_solicitud',$data["id"])->delete();

        for($i = 0; $i < $cont; $i++) {
            $data_citado = [
                'id_solicitud'  => $data["id"],
                'fecha'         => $fecha_actual,
                'nombre'        => $data["citado"][$i],
                'direccion'     => $data["direccion"][$i], 
                'id_municipio'  => 0, 
                'id_estado'     => 0,
                'observaciones' => ''
            ];
            SeerCitados::create($data_citado);
        }
        return redirect()->route('seer'); 
    }

    public function ver_historial(){
        return view('estadisticas.generaHistorial');
    }

    public function historial(Request $request){
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_final');
        $personas = SeerPerGeneral::join('seer_auxiliares', 'seer_auxiliares.id_solicitud', '=', 'seer_general.id')
            ->join('seer_citados', 'seer_citados.id_solicitud', '=', 'seer_general.id')
            
            ->leftjoin('seer_conciliadores', 'seer_conciliadores.id_solicitud', '=', 'seer_general.id')
                
            ->select(
                'seer_auxiliares.motivo',
                'seer_auxiliares.estatus',
                'seer_auxiliares.actividad_economica',
                'seer_general.fecha',
                'seer_general.NUE',
                'seer_general.solicitante',
                'seer_citados.nombre as citado',
                'seer_citados.id_solicitud',
                'seer_citados.direccion',
                'seer_conciliadores.id',
            )
            ->whereBetween('seer_general.created_at', [$fechaInicio, $fechaFin])
            ->get();
        
        return view('estadisticas.verHistorial', compact('personas'));    

    } 

    public function solicitudesLinea(){
        return view('solicitud');
    }

    public function Industrias($tipo_solicitud){
       // dd($tipo_solicitud);
        return view('solicitudes.tipoIndustria', compact('tipo_solicitud'));
    } 
    
    //Pre registro para solicitudes
    public function RTemportal(){
        // dd($tipo_solicitud);
        return view('solicitudes.solicitud_trabajador');
    }

    public function GuardarRTemportal(Request $request){
        $data = $request->all();
        $request->validate([
            'nombre'      => 'required',
            'rfc'         => 'required', 
            'telefono'    => 'required'
        ]);
        
        $data_insert=array(
            'nombre'         =>  $data["nombre"],
            'rfc'            =>  $data["rfc"],
            'telefono'       =>  $data["telefono"]
        );
       
        PreRegistro::create($data_insert); 
        
        //return redirect()->away('https://michoacan.cencolab.mx/solicitudes/create?solicitud=2');
    }
    //Fin registro para solicitudes
    
    //Solicitud en línea trabajador
    public function trabajador($tipo_solicitud){  
        //dd($tipo_solicitud);
        if ($tipo_solicitud == "1") {
            $mostrarMotivos = SolicitudMotivo::where('catalogo_motivos.tipo_solicitud', '1') ->get();
        }
        elseif ($tipo_solicitud == "2") {
            $mostrarMotivos = SolicitudMotivo::where('catalogo_motivos.tipo_solicitud', '2') ->get();
        }
        elseif ($tipo_solicitud == "3") {
            $mostrarMotivos = SolicitudMotivo::where('catalogo_motivos.tipo_solicitud', '3') ->get();
        }
        elseif ($tipo_solicitud == "4") {
            $mostrarMotivos = SolicitudMotivo::where('catalogo_motivos.tipo_solicitud', '4') ->get();
        }
        $ramas = SolicitudRama::all();
       // $actividad=SolicitudEconomica::all();
        $del=Sedes::all();
        $municipios=Municipios::where('estado',16)->get();
       /* if($tipo_solicitud[0] == "1"){
            //$personas = null;
            $motivos = SolicitudMotivo::where('catalogo_motivos.tipo_solicitud', '1')
            ->select('catalogo_motivos.motivo','seer_general.NUE','seer_general.solicitante','seer_citados.nombre','seer_citados.direccion','seer_citados.estatus')
            ->get();
        }*/
        return view('solicitudes.solicitud_trabajador', compact('ramas','del','municipios','tipo_solicitud','mostrarMotivos'));
    }
   
    /* public function obtenerActEconomica($id){
        return SolicitudEconomica::where('id_rama', $id)->get();
    }*/

    public function solicitud_parte1(Request $request){
        $data = $request->all();

        if($data["delegacion"] == "Lázaro Cárdenas"){
            $data["delegacion"] = "Uruapan";
        }
        if($data["delegacion"] == "Zitácuaro"){
            $data["delegacion"] = "Morelia";
        }
        if($data["delegacion"] == "Sahuayo"){
            $data["delegacion"] = "Zamora";
        }
        //validando información
        $request->validate([
            'ramaIndustrial'      => 'required',
            'actividad_economica' => 'required',
            'motivo_solicitud'    => 'required',           
        ]);
        
        $data_insert=array(
            'id_rama'         =>  $data["ramaIndustrial"],
            'actividad'       =>  $data["actividad_economica"],
            'delegacion'      =>  $data["delegacion"],
            'tipo_solicitud'  =>  $data["tipo_solicitud"],
        );
       
        SeerPerGeneral::create($data_insert); 
        $id_general  = SeerPerGeneral::latest('id')->first();
        $id=$id_general["id"];
        if (!empty($data["motivo_solicitud"])) {
            foreach ($data["motivo_solicitud"] as $motivoId) {
                SeerMotivo::create([
                    'id_solicitud'    => $id_general["id"],
                    'id_motivo'       => $motivoId,
                    
                ]);
            }
        }
        $estados = Estados::all();
        $municipios = Municipios::all();
        return view('solicitudes.solicitante', compact('estados','municipios','id'));
    }
    
    public function solicitud_parte2(Request $request){
        $data = $request->all();
        //dd($data);
        $id = $data['id'];

        //validando información
       $request->validate([
            'tipo'                      => 'required|in:Fisica,Moral',
            'curp'                      => 'required|min:18|max:18',
            'nombre'                    => 'required',
            'fecha_nacimiento'          => 'required|date',
            'edad'                      => 'required|numeric',
            'genero'                    => 'required|in:H,M,NC',
            'nacionalidad'              => 'required|in:Mexicana,Otra',
            'estado_nacimiento'         => 'required',
            'telefono1'                 => 'required|min:10|max:10',
            'correo'                    => 'required',
            'estado_solicitante'        => 'required',
            'vialidad'                  => 'required',
            'vialidad_calle'            => 'required',
            'numExt'                    => 'required',
            'colonia_solicitante'       => 'required',
            'municipio_solicitante'     => 'required',
            'cp'                        => 'required|numeric',
            'referencias'               => 'required|string|max:300',
            'calle1'                    => 'required',
            'calle2'                    => 'required',
            'puesto'                    => 'required', 
            'periodo_pago'              => 'required',
            'pago'                      => 'required',
            'horas'                     => 'required',
            'fecha_ingreso'             => 'required',
            'jornada'                   => 'required',
            'identificacion'            => 'required',
            'documentoCurp'             => 'required',
            'documentoIdentificacion'   => 'required',
        ]);
        
        $data_insert=array(
            'id_solicitud'         => $data["id"],
            'tipo_persona'         => $data["tipo"],
            'curp'                 => $data["curp"],
            'nombre'               => $data["nombre"],
            'fecha_nacimiento'     => $data["fecha_nacimiento"],
            'sexo'                 => $data["genero"],
            'nacionalidad'         => $data["nacionalidad"],
            'estado'               => $data["estado_nacimiento"],
            'edad'                 => $data["edad"],
            'telefono1'            => $data["telefono1"],
            'email'                => $data["correo"],
            'estado_domicilio'     => $data["estado_solicitante"],
            'tipo_vialidad'        => $data["vialidad"],
            'calle'                => $data["vialidad_calle"],
            'num_ext'              => $data["numExt"],
            'colonia'              => $data["colonia_solicitante"],
            'municipio_domicilio'  => $data["municipio_solicitante"],
            'codigo_postal'        => $data["cp"],
            'referencia'           => $data["referencias"],
            'calle2'               => $data["calle1"],
            'calle3'               => $data["calle2"],
            'puesto'               => $data["puesto"],
            'pago'                 => $data["pago"],
            'periodo_pago'         => $data["periodo_pago"],
            'horas_semana'         => $data["horas"],
            'fecha_ingreso'        => $data["fecha_ingreso"],
            'jornada'              => $data["jornada"],
            'identificacion'       => $data["identificacion"],
        ); 

        if(isset($data["rfc"])){
            $data_insert["rfc"] =  $data["rfc"];
        }
        
        if(isset($data["traductor"])){
            $data_insert["traductor"] =  "Si";
            $data_insert["lenguaje"]  =  $data["lenguaje"];
        }
        
        if(isset($data["numInt"])){
            $data_insert["num_int"] =  $data["numInt"];
        }
        
        if(isset($data["discapacidad"])){
            $data_insert["discapacidad"] =  "Si";
            $data_insert["tipo_discapacidad"] =  $data["tipo_discapacidad"];
        }
        
        if(isset($data["labora"])){
            $data_insert["labora"] =  "Si";
            $data_insert["fecha_salida"]  =  $data["fecha_salida"];
        }
        if(isset($data["telefono2"])){
            $data_insert["telefono2"] =  $data["telefono2"];
        }
        
        if(isset($data["seguro"])){
            $data_insert["nss"] =  $data["seguro"];
        }
        

        //Voy a insertar en la tabla de solicitante
       
        
        // Voy a realizar una busqueda de la tabla general
       // $solicitud = SeerPerGeneral::find($data["id"]);
       

        //CURP
        $documento = $data["curp"]."_CURP.pdf";
        //dd($documento);
        $path = Storage::putFileAs(
            'documentosSolicitud', $request->file('documentoCurp'), $documento
        );
        
        //Acta de nacimiento
        if(isset($data["documentoIdentificacion"])){
            $documentoidentificacion = $data["curp"]."_Identificacion.pdf";
            $path = Storage::putFileAs(
                'documentosSolicitud', $request->file('documentoIdentificacion'), $documentoidentificacion
        );
        }
        else{
            $documentoidentificacion = $data["curp"]."_Acta.pdf";
            $path = Storage::putFileAs(
                'documentosSolicitud', $request->file('documentoActa'), $documentoidentificacion
            );
        }

        $data_insert["documentoCurp"] = $documento;
        $data_insert["documentoIdentificacion"] = $documentoidentificacion;
       
        SeerSolicitante::create($data_insert);
        //return view('solicitudes.aviso',compact('folio'));
    
        //$estados=Estados::all();
        return redirect()->route('agregar_citado', ['id' => $id] ); 
    }

    public function guardar_citado(Request $request){
        $data = $request->all();

        //validando información
        $request->validate([
            'id'                => 'required',
            'colonia'           => 'required',
            'vialidad'          => 'required',
            'cp'                => 'required|numeric',
            'calle'             => 'required',
            'exterior'          => 'required',
            'referencia'        => 'required',
            'calle'
        ]);
        
        $data_insert=array(
            'id_solicitud'      => $data["id"],
            'colonia'           => $data["colonia"],
            'cp'                => $data["cp"],
            'n_ext'             => $data["exterior"],
            'calle'             => $data["calle"],
            'tipo_vialidad'     => $data["vialidad"],
            'referencia'        => $data["referencia"],
        );

        if(isset($data["rfc"])){
            $data_insert["rfc"] =  $data["rfc"];
        }
        if(isset($data["curp"])){
            $data_insert["curp"] =  $data["curp"];
        }
        if(isset($data["traductor"])){
            $data_insert["traductor"] =  1;
            $data_insert["lenguaje"]  =  $data["lenguaje"];
        }
        if(isset($data["interior"])){
            $data_insert["n_int"] =  $data["interior"];
        }
        if(isset($data["calle1"])){
            $data_insert["calle1"] =  $data["calle1"];
        }
        if(isset($data["calle2"])){
            $data_insert["calle2"] =  $data["calle2"];
        }
        if(isset($data["nombre"])){
            $data_insert["nombre"] =  $data["nombre"];
        }
        if(isset($data["tipo"])){
            $data_insert["tipo_persona"] =  $data["tipo"];
        }
        if(isset($data["curp"])){
            $data_insert["curp"] =  $data["curp"];
        }
        if(isset($data["nombre"])){
            $data_insert["nombre"] =  $data["nombre"];
        }
        if(isset($data["primer_apellido"])){
            $data_insert["primer_apellido"] =  $data["primer_apellido"];
        }
        if(isset($data["segundo_apellido"])){
            $data_insert["segundo_apellido"] =  $data["segundo_apellido"];
        }
        if(isset($data["rfc"])){
            $data_insert["rfc"] =  $data["rfc"];
        }
        if(isset($data["estado_solicitante"])){
            $data_insert["estado_solicitante"] =  $data["estado_solicitante"];
        }
        
        //Se van a generar el citatorio
        SeerCitados::create($data_insert); 
        //Se van a generar quien resulte responsable
        $data_insert["nombre"] =  "REPRESENTANTE LEGAL  DE: QUIEN O QUIENES RESULTEN RESPONSABLES Y/O BENEFICIARIOS Y/O
        USUFRUCTUARIOS Y/O PROPIETARIOS DE LA FUENTE DE EMPLEO UBICADA EN ".$data["calle1"].", NÚMERO ".$data["exterior"]." COLONIA ".$data["colonia"].", MORELIA, MICHOACÁN.";
        SeerCitados::create($data_insert); 

        return back()->with('success', 'Citado agregado correctamente, puedes agregar otro o continuar.');
    }

    public function vista_citado($id){
        $estados = Estados::all();
        $municipios = Municipios::all();

        return view('solicitudes.citados',compact('estados','id'));
    }

    /*public function vista_solicitante($id){
        $estados = Estados::all();
        $municipios = Municipios::all();

        return view('solicitudes.solicitante_nuevo', compact('estados','municipios','id'))->with('success', 'Solicitante agregado correctamente, puedes agregar otro o continuar.');
    }*/

    /*public function vista_documentos($id){
        return view('solicitudes.documentos',compact('id'));
    }*/

    public function guardar_solicitud($id){
        //Revisar si ya existe el correo
        $solicitante = SeerSolicitante::where('id_solicitud',$id)->first();
        $nombre = $solicitante["nombre"]." ".$solicitante["primer_apellido"]." ".$solicitante["segundo_apellido"];
        $delegacion = SeerPerGeneral::find($id);
        $usuario = User::where('email',$solicitante["email"])->first();

        if(!isset($usuario)){
            $data_insertar_user= array(
                'name'              => $nombre,
                'email'             => $solicitante["email"],
                'delegacion'        => $delegacion["delegacion"],
                'type'              => "Seer",
                'remember_token'    => $solicitante["curp"],
                'profile_photo_path'=> $solicitante["curp"]
            ); 
            
            //Hacemos un hash del campo que tiene el password
            $data_insertar_user['password'] = Hash::make("CCLMICHOACAN");
            $usuario = User::create($data_insertar_user);
            $usuario->assignRole(('Solicitante'));
            $mensaje = " el correo:".$usuario["email"]." y la contraseña:CCLMICHOACAN para continuar tú trámite.";
        }
        else{
            $mensaje = " el correo:".$usuario["email"]." para continuar tú trámite.";
        }

        return view('solicitudes.aviso',compact('id','mensaje'));
    }

    public function solicitudes_pendientes(){
        $solicitudes = SeerPerGeneral::where('validado_conciliador','Pendiente')
        ->join('catalogo_rama','catalogo_rama.id','seer_general.id_rama')
        ->join('seer_solicitante','seer_solicitante.id_solicitud','seer_general.id')
        ->select('seer_general.id','seer_general.fecha','seer_solicitante.nombre','seer_general.delegacion','seer_general.actividad',
        'catalogo_rama.rama_industrial','seer_general.tipo_solicitud')
        ->where('seer_general.estatus','Pendiente')
        ->orderBy('seer_general.fecha')
        ->get();

        return view('solicitudes.solicitudes_pendientes', compact('solicitudes'));
    }

    public function solicitudes_pendientes_revisar($id){
        $id             = $id;
        $general        = SeerPerGeneral::find($id);
        $ramas          = SolicitudRama::all();
        $solicitantes   = SeerSolicitante::where("id_solicitud",$id)->get();
        $citados        = SeerCitados::where("id_solicitud",$id)->get();
        $estados        = Estados::all();
        $municipios     = Municipios::all();
        //Catalogo de motivos
        $mostrarMotivos = SolicitudMotivo::all();
        //Motivos capturados
        $motivos        = SeerMotivo::join('catalogo_motivos','catalogo_motivos.id','seer_motivos.id_motivo')
        ->where('id_solicitud',$id)
        ->select('catalogo_motivos.motivo','seer_motivos.id')->get();

        return view('solicitudes.revisar_solicitud', compact('id','general','solicitantes','citados','ramas','estados','municipios','mostrarMotivos','motivos'));
    }
    
    public function eliminar_motivo($id,$id_motivo){
        
        SeerMotivo::find($id_motivo)->delete();
        return redirect()->route('regresa_eliminar', ['id' => $id] ); 
    }

    public function regresa_eliminar($id){
        $general        = SeerPerGeneral::find($id);
        $ramas          = SolicitudRama::all();
        $solicitantes   = SeerSolicitante::where("id_solicitud",$id)->get();
        $citados        = SeerCitados::where("id_solicitud",$id)->get();
        $estados        = Estados::all();
        $municipios     = Municipios::all();
        //Catalogo de motivos
        $mostrarMotivos = SolicitudMotivo::all();
        //Motivos capturados
        $motivos        = SeerMotivo::join('catalogo_motivos','catalogo_motivos.id','seer_motivos.id_motivo')
        ->where('id_solicitud',$id)
        ->select('catalogo_motivos.motivo','seer_motivos.id')->get();

        return view('solicitudes.revisar_solicitud', compact('id','general','solicitantes','citados','ramas','estados','municipios','mostrarMotivos','motivos'));
    }

    public function solicitud_confirmar(Request $request){
        $data = $request->all();
        //dd($data);
        //Actualizar SEER GENERAL
        $delegacion = SeerPerGeneral::find($data["id"]);
        $NUE = $this->GeneraExpediente($data["id"],$delegacion["delegacion"]);

        SeerPerGeneral::where('id', $data["id"])
        ->update(['NUE' => $NUE, 'actividad' => $data["actividad_economica"],'id_rama' => $data["ramaIndustrial"] ]);

        if (!empty($data["motivo_solicitud"])) {
            foreach ($data["motivo_solicitud"] as $motivoId) {
                SeerMotivo::create([
                    'id_solicitud'    => $data["id"],
                    'id_motivo'       => $motivoId,
                    
                ]);
            }
        }

        //Actualizar SEER SOLICTUD
        SeerSolicitante::where('id_solicitud', $data["id"])
        ->update(['tipo_persona' => $data["tipo_persona_solicitante"], 
            'curp'                  => $data["curp_solicitante"],
            'rfc'                   => $data["rfc_solicitante"],
            'nombre'                => $data["nombre_solicitante"],
            'sexo'                  => $data["sexo_solicitante"],
            'nacionalidad'          => $data["nacionalidad_solicitante"],
            //'estado'                => $data["estado_solicitante"],
            'email'                 => $data["email_solicitante"],
            'fecha_nacimiento'      => $data["fecha_nacimiento_solicitante"],
            'edad'                  => $data["edad_solicitante"],
            'telefono1'             => $data["telefono1_solicitante"],
            'traductor'             => $data["traductor_solicitante"],
            'lenguaje'              => $data["lenguaje_solicitante"],
            'discapacidad'          => $data["discapacidad_solicitante"],
            'tipo_discapacidad'     => $data["disc_solicitante"],
            'tipo_vialidad'         => $data["tipo_vialidad"],
            'calle'                 => $data["calle_solicitante"],
            'num_ext'               => $data["num_ext_solicitante"],
            'codigo_postal'         => $data["codigo_postal_solicitante"],
            'referencia'            => $data["referencia_solicitante"],
            'colonia'               => $data["colonia_solicitante"],
            'calle2'                => $data["calle2_solicitante"],
            'calle3'                => $data["calle3_solicitante"],
            'municipio_domicilio'   => $data["municipio_solicitante"],
            'puesto'                => $data["puesto"],
            'pago'                  => $data["pago"],
            'periodo_pago'          => $data["periodo_pago"],
            'fecha_ingreso'         => $data["fecha_ingreso"],
            'fecha_salida'          => $data["fecha_salida"],
            'jornada'               => $data["jornada"],
            'estado_domicilio'      => $data["estado_solicitante"],
            'horas_semana'          => $data["horas_semana"],
        ]);

        //Opcionales
        if(isset($data["telefono2"])){
            SeerSolicitante::where('id_solicitud', $data["id"])->update(['telefono2' => $data["telefono2_solicitante"] ]);
        }
        if(isset($data["num_int"])){
            SeerSolicitante::where('id_solicitud', $data["id"])->update(['num_int' => $data["num_int_solicitante"] ]);
        }
        if(isset($data["nss"])){
            SeerSolicitante::where('id_solicitud', $data["id"])->update(['nss' => $data["nss"] ]);
        }


        //Citados
        SeerCitados::where('id_solicitud',$data["id"])->delete();
        $cont = count($data["colonia_citado"]);
        for($i = 0; $i < $cont; $i++) {
            $data_insert=array(
                'id_solicitud'      => $data["id"],
                'colonia'           => $data["colonia_citado"][$i],
                'cp'                => $data["cp_citado"][$i],
                'n_ext'             => $data["n_ext_citado"][$i],
                'calle'             => $data["calle_citado"][$i],
                'tipo_vialidad'     => $data["vialidad_citado"][$i],
                'referencia'        => $data["referencia_citado"][$i],
            );
            
            

            if(isset($data["rfc"])){
                $data_insert["rfc"] =  $data["rfc_citado"][$i];
            }
                if(isset($data["curp"])){
                    $data_insert["curp"] =  $data["curp_citado"][$i];
                }
                if(isset($data["interior"])){
                    $data_insert["n_int"] =  $data["n_int_citado"][$i];
                }
                if(isset($data["calle1"])){
                    $data_insert["calle1"] =  $data["calle1_citado"][$i];
                }
                if(isset($data["calle2"])){
                    $data_insert["calle2"] =  $data["calle2_citado"][$i];
                }
                if(isset($data["tipo"])){
                    $data_insert["tipo_persona"] =  $data["tipo_persona_citado"][$i];
                }
                if(isset($data["curp"])){
                    $data_insert["curp"] =  $data["curp_citado"][$i];
                }
                if(isset($data["nombre"])){
                    $data_insert["nombre"] =  $data["nombre_citado"][$i];
                }
                if(isset($data["primer_apellido"])){
                    $data_insert["primer_apellido"] =  $data["primer_apellido"][$i];
                }
                if(isset($data["segundo_apellido"])){
                    $data_insert["segundo_apellido"] =  $data["segundo_apellido"][$i];
                }
                if(isset($data["rfc"])){
                    $data_insert["rfc"] =  $data["rfc"][$i];
                }/*
                if(isset($data["estado_solicitante"])){
                    $data_insert["estado_solicitante"] =  $data["estado_solicitante"][$i];
                }*/
            //dd($data_insert);
            SeerCitados::create($data_insert);
        }
        
        //Documentos
        if(isset($data["curp"])){
            $documento = $data["curp"]."_CURP.pdf";
            $path = Storage::putFileAs('documentosSolicitud', $request->file('documentoCurp'), $documento);
            SeerSolicitante::where('id_solicitud', $data["id"])->update(['documentoCurp' => $documento ]);
        }
        
        //Acta de nacimiento
        if(isset($data["indetificacion"])){
            $documentoidentificacion = $data["curp"]."_Identificacion.pdf";
            $path = Storage::putFileAs('documentosSolicitud', $request->file('indetificacion'), $documentoidentificacion);
            SeerSolicitante::where('id_solicitud', $data["id"])->update(['documentoIdentificacion' => $documentoidentificacion ]);
        }

        //Actualizar el estatus
        SeerPerGeneral::find($data["id"])->update(['estatus' => "Confirmado" ]);

        //Se va asignar el conciliador y la sala
        $id_user = auth()->user()->id;
        $user = User::find($id_user);
        $listado_auxiliares = array();
        $relacionEloquent = 'roles';

        $usuariosauxiliares = User::whereHas($relacionEloquent, function ($query) {
            return $query->where('name', '=', 'Conciliador');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();

        foreach($usuariosauxiliares as $token ){
            array_push($listado_auxiliares, $token["id"]);
        }

        //Se asigna a un conciliador
        $random = array_rand($listado_auxiliares);
        SeerPerGeneral::find($data["id"])->update(['conciliador_id' => $listado_auxiliares[$random] ]);
        //Generar las notificaciones Pendiente
        SeerCitados::where('id_solicitud',$data["id"])->update(['estatus' => 'Pendiente' ]);

        return redirect()->route('solicitudes_pendientes'); 
    }

    public function GeneraExpediente($id,$delegacion){
        $año_actual = date('Y');
        //$id = SeerPerGeneral::select('id')->orderBy('id', 'desc')->first();
    
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
        $folio = $del."/SOL"."/".$año_actual."/".$numeroConCeros;
    
        return $folio;
    }

    public function agregar_citado_edicion(Request $request){
        $data = $request->all();

        $data_insert=array(
            'id_solicitud'      => $data["id"],
            'colonia'           => $data["colonia"],
            'cp'                => $data["cp"],
            'n_ext'             => $data["exterior"],
            'calle'             => $data["calle"],
            'tipo_vialidad'     => $data["vialidad"],
            'referencia'        => $data["referencia"],
        );

        if(isset($data["rfc"])){
            $data_insert["rfc"] =  $data["rfc"];
        }
        if(isset($data["curp"])){
            $data_insert["curp"] =  $data["curp"];
        }
        if(isset($data["traductor"])){
            $data_insert["traductor"] =  1;
            $data_insert["lenguaje"]  =  $data["lenguaje"];
        }
        if(isset($data["interior"])){
            $data_insert["n_int"] =  $data["interior"];
        }
        if(isset($data["calle1"])){
            $data_insert["calle1"] =  $data["calle1"];
        }
        if(isset($data["calle2"])){
            $data_insert["calle2"] =  $data["calle2"];
        }
        if(isset($data["nombre"])){
            $data_insert["nombre"] =  $data["nombre"];
        }
        if(isset($data["tipo"])){
            $data_insert["tipo_persona"] =  $data["tipo"];
        }
        if(isset($data["curp"])){
            $data_insert["curp"] =  $data["curp"];
        }
        if(isset($data["nombre"])){
            $data_insert["nombre"] =  $data["nombre"];
        }
        if(isset($data["primer_apellido"])){
            $data_insert["primer_apellido"] =  $data["primer_apellido"];
        }
        if(isset($data["segundo_apellido"])){
            $data_insert["segundo_apellido"] =  $data["segundo_apellido"];
        }
        if(isset($data["rfc"])){
            $data_insert["rfc"] =  $data["rfc"];
        }
        if(isset($data["estado_solicitante"])){
            $data_insert["estado_solicitante"] =  $data["estado_solicitante"];
        }
        
        //Se van a generar el citatorio
        SeerCitados::create($data_insert); 
        if($data["lenguaje"] == "Si"){
            $data_insert["nombre"] =  "REPRESENTANTE LEGAL  DE: QUIEN O QUIENES RESULTEN RESPONSABLES Y/O BENEFICIARIOS Y/O
            USUFRUCTUARIOS Y/O PROPIETARIOS DE LA FUENTE DE EMPLEO UBICADA EN ".$data["calle1"].", NÚMERO ".$data["exterior"].
            " COLONIA ".$data["colonia"].", MORELIA, MICHOACÁN.";
            SeerCitados::create($data_insert);
        }
 

        return back()->with('success', 'Citado agregado correctamente.');
    }

    public function borrar_citado_edicion(Request $request){
        $data = $request->all();
        SeerCitados::find($data["borrar"])->delete();

        return back()->with('success', 'Citado borrado correctamente.');
    }

    public function notificaciones(){
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        //$fecha_actual = date('y-m-d');
        $personas = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Notificador');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();

        $notificaciones = SeerPerGeneral::join('seer_citados','seer_citados.id_solicitud','=','seer_general.id')
        ->select('seer_general.id as id_solicitud','seer_citados.id as id_citado','seer_general.NUE',
            'seer_citados.nombre','seer_citados.primer_apellido','seer_citados.segundo_apellido',
            'seer_citados.colonia','seer_citados.calle','seer_citados.n_ext','seer_citados.n_int','seer_citados.estatus')
        ->where('seer_general.delegacion', $user["delegacion"])
        ->where('seer_citados.id_notificador', 0)
        ->where('seer_citados.notificacion',"!=", "Trabajador")
        ->get();


        return view('notificaciones.index',compact('personas','notificaciones','userRole'));
    }

    //Conciliadores en solicitudes audiencias
    public function indexA(){
        $id = auth()->user()->id;
        $user = User::find($id);

        $audiencias = SeerPerGeneral::where('conciliador_id', $user->id)
            ->where(function ($query) {
                $query->where('estatus', 'Confirmado')
                    ->orWhere('estatus', 'Archivada')
                    ->orWhere('estatus', 'Reagendada')
                    ->orWhere('estatus', 'Incompetencia')
                    ->orWhere('estatus', 'Incomparecencia');
            })
            ->get();

        foreach ($audiencias as $audiencia) {
            $solicitante = SeerSolicitante::where('id_solicitud', $audiencia->id)->first();
            $audiencia->nombre = $solicitante ? $solicitante->nombre : 'Sin solicitante';
        }

        return view('/solicitudes/indexConciliador',compact('audiencias'));
    }

    public function iniciar_audiencia($id){
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);

        $solicitudes = SeerPerGeneral::where('conciliador_id', $user->id)
            ->where(function ($query) {
                $query->where('estatus', 'Conciliacion')
                    ->orWhere('estatus', 'No conciliacion')
                    ->orWhere('estatus', 'Archivado por incomparecencia')
                    ->orWhere('estatus', 'Reagendada')
                    ->orWhere('estatus', 'Incompetencia')
                    ->orWhere('estatus', 'Confirmado');
            })
            ->get();
        
        $solicitud = SeerPerGeneral::find($id);
        $conciliador = User::select('name')->where('id', $solicitud->conciliador_id)->first();
        $citados = SeerCitados::where('id_solicitud', $id)->get();
        $solicitante = SeerSolicitante::where('id_solicitud', $id)->first();

        SeerPerGeneral::find($id)
            ->update(['conciliador' => $user->id, 'estatus' => 'Confirmado']);

        return view('/solicitudes/audiencias',compact('id','solicitudes','citados','solicitante','conciliador','solicitud'));
    }

    public function guardar_audiencia_archivo(Request $request){
        $data = $request->all();
        $user = auth()->user();
    
        $solicitud = SeerPerGeneral::find($data["id"]);
    
        $solicitud->update([
            'estatus' => 'Archivada', 'estatus' => 'Incompetencia', 'estatus' => 'Incomparecencia',
            'observaciones' => $data["observaciones"],
            'conciliador_id' => $user->id,
        ]);
    
        return redirect()->route('audiencias.conciliador');
    }

    public function editar_solicitud_con(Request $request){
        $data = $request->all();
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        
    }  

}