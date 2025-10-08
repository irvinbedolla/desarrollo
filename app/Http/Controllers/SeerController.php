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
use App\Models\Poder;
use App\Models\Audiencias;
use App\Models\Pagos; 
use App\Models\Concepto; 
use App\Models\PersonaFisica;
use App\Models\Turnos;
use App\Models\DiasInhabiles;
use NumberToWords\NumberToWords; // para convertir números(cantidades) a letras
use App\Models\DocumentosSolicitud;
use App\Models\SeerPerGeneral_old;
use App\Models\SeerCitados_old;
use App\Models\SeerPerConciliador_old;

//Para sacar el Id del usuario
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; //Se utiliza en la imágenes que se suben en los citados
use App\Models\Sedes;
use App\Models\Usuarios;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;
use App\Exports\ProductsFromViewExport;
use App\Exports\RatificacionesFromViewExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NotificacionesExport;
use App\Models\Deducciones;

class SeerController extends Controller
{   
    public function index()
    {
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $fecha_actual = date('y-m-d');
        $estadisticas = "";
        $personas = "";
        $sede = $user->delegacion;
        
        //Si es delegado le va salir todo lo de su delegacion de todos los roles
       if($userRole[0] == "Notificador"){
            $personas = null;
            $estadisticas = SeerPerGeneral::where('seer_citados.id_notificador', $id)
            ->join('seer_citados','seer_citados.id_solicitud','=','seer_general.id')
            ->join('seer_solicitante','seer_solicitante.id_solicitud','=','seer_general.id')
            ->join('municipios', 'seer_citados.municipio_citado', '=', 'municipios.id')
            ->where('seer_citados.estatus', 'Pendiente')
            ->select('seer_citados.id','seer_general.NUE','seer_solicitante.nombre as nombre_solicitado','seer_citados.nombre','seer_citados.primer_apellido','seer_citados.segundo_apellido',
            'municipios.nombre as municipio_citado','seer_citados.colonia','seer_citados.calle',
            'seer_citados.n_ext','seer_citados.estatus')
            ->get();
        }
        //Si es otro usuario le va mostrar unicamente las del ese usuario
        else if($userRole[0] == "Auxiliar" || $userRole[0] == "Excepcion"){
            $personas     = SeerPerGeneral_old::where('fecha', $fecha_actual)->where('user_id', $id)
            ->join('seer_auxiliares','seer_auxiliares.id_solicitud',"=",'seer_general_old.id')
            ->select("seer_general_old.id","seer_general_old.fecha","seer_general_old.NUE","seer_general_old.solicitante","seer_auxiliares.tipo_solicitud","seer_general_old.validado_conciliador")
            ->get();
            $estadisticas = null;
            $asesorias    = SeerAsesoria::where('fecha', $fecha_actual)->where('id_usuario', $id)
            ->selectRaw('count(seer_asesorias.id) as total')
            ->first();
            return view('estadisticas.index',compact('estadisticas','userRole','personas','asesorias'));
        }
        else if($userRole[0] == "Conciliador"){
            //solo le van aparecer solicitudes
            $personas = SeerPerGeneral_old::where('conciliador_id', $id)
            ->join('seer_auxiliares','seer_auxiliares.id_solicitud',"=",'seer_general_old.id')
            ->where('seer_auxiliares.tipo_solicitud','Solicitud')
            ->where('seer_general_old.validado_conciliador','Pendiente')
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

            $estadisticas = SeerPerGeneral_old::join('seer_citados_old','seer_citados_old.id_solicitud','=','seer_general_old.id')
            ->join('seer_auxiliares','seer_auxiliares.id_solicitud','=','seer_general_old.id')
            ->select('seer_citados_old.id','seer_general_old.NUE','seer_general_old.solicitante','seer_citados_old.nombre',
                'seer_citados_old.direccion','seer_citados_old.estatus')
            ->where('seer_general_old.delegacion', $user["delegacion"])
            ->where('seer_citados_old.id_notificador', 0)
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
        $municipios = Municipios::where('estado',16)->get();

        return view('estadisticas.estadistica', compact('user','userRole','estadisticas','usuariosconciliador','usuariosauxiliares','usuariosnotificadores','estados','municipios'));
    }

    public function mostrar_reporte(Request $request){
        $data = $request->all();
        //Primero vamos a validar si el reporte sera cuanticativo o detallado
        //Validar documentacion
        request()->validate([
            //General
            'tipo_reporte'  => 'required|in:Cumplimientos,CumplimientosResumen,Ratificaciones,RatificacionesResumen,Detallado,Concentrado,RatificacionesUsuario,Notificaciones',
        ], $data);
        if(isset($data["sede"]))
            $sede = $data["sede"];
        else
            $sede = "";
        if(isset($data["auxiliar"]))
            $auxiliar = $data["auxiliar"];
        else
            $auxiliar = "";
        if(isset($data["notificador"]))
            $notificador = $data["notificador"];
        else
            $notificador = "";

        $fecha_inicial = $data["fecha_inicial"];
        $fecha_final   = $data["fecha_final"];
        $id = auth()->user()->id;
        $user = User::find($id);
        $relacionEloquent = "roles";

        //Primeramente reporte detallado
        if($data["tipo_reporte"] == "Cumplimientos"){
            //Para los excel
            if($data["tipo"] == "2"){
                return Excel::download(new ProductsFromViewExport($fecha_inicial, $fecha_final,$sede), 'productos.xlsx');
            }
            //Para el PDF
            else{
                //Pagos de ratificacion
                if($sede === "Todos"){
                    $pagosRatificacion = Pagos::whereBetween('pago_solicitud.fecha',[$fecha_inicial,$fecha_final])
                    ->join('turnos','turnos.id','pago_solicitud.id_solicitud')
                    ->join('users','users.id','turnos.id_conciliador')
                    ->where('pago_solicitud.tipo_pago',"Ratificacion")
                    ->select('pago_solicitud.id_solicitud','pago_solicitud.fecha','pago_solicitud.hora','pago_solicitud.monto','pago_solicitud.descripcion'
                    ,'pago_solicitud.estatus','pago_solicitud.tipo_pago','turnos.delegacion','turnos.NUE',
                    'turnos.empresa','turnos.primero_empresa','turnos.segundo_empresa','turnos.trabajador','turnos.primero_trabajador','turnos.segundo_trabajador'
                    ,'users.name')
                    ->orderby('users.name')
                    ->get();
                }else{
                    $pagosRatificacion = Pagos::whereBetween('pago_solicitud.fecha',[$fecha_inicial,$fecha_final])
                    ->where('pago_solicitud.delegacion',$sede)
                    ->join('turnos','turnos.id','pago_solicitud.id_solicitud')
                    ->join('users','users.id','turnos.id_conciliador')
                    ->where('pago_solicitud.tipo_pago',"Ratificacion")
                    ->select('pago_solicitud.id_solicitud','pago_solicitud.fecha','pago_solicitud.hora','pago_solicitud.monto','pago_solicitud.descripcion'
                    ,'pago_solicitud.estatus','pago_solicitud.tipo_pago','pago_solicitud.delegacion','turnos.NUE',
                    'turnos.empresa','turnos.primero_empresa','turnos.segundo_empresa','turnos.trabajador','turnos.primero_trabajador','turnos.segundo_trabajador'
                    ,'users.name')
                    ->orderby('users.name')
                    ->get(); 
                }
                //Pagos de audiencias
                if($sede === "Todos"){
                    $pagosAudiencias = Pagos::whereBetween('fecha',[$fecha_inicial,$fecha_final])
                    ->join('users','users.id','pago_solicitud.id_conciliador')
                    ->where('pago_solicitud.tipo_pago',"Audiencia")
                    ->get();
                }else{
                    $pagosAudiencias = Pagos::whereBetween('fecha',[$fecha_inicial,$fecha_final])
                    ->where('pago_solicitud.delegacion',$sede)
                    ->join('users','users.id','pago_solicitud.id_conciliador')
                    ->where('pago_solicitud.tipo_pago',"Audiencia")
                    ->get(); 
                }

                $pdf = \PDF::loadView('PDF/Estadisticas/reporte-Cumplimientos', compact('fecha_inicial','fecha_final','pagosRatificacion','pagosAudiencias'));
                $pdf->setPaper('a4', 'landscape');
                return $pdf->stream('archivo.pdf');
            }
        }
        else if($data["tipo_reporte"] == "CumplimientosResumen"){
            //Pagos de ratificacion
            if($sede === "Todos"){
                $pagosRatificacion = Pagos::whereBetween('pago_solicitud.fecha',[$fecha_inicial,$fecha_final])
                ->join('turnos','turnos.id','pago_solicitud.id_solicitud')
                ->join('users','users.id','turnos.id_conciliador')
                ->where('pago_solicitud.tipo_pago',"Ratificacion")
                ->selectRaw('count(pago_solicitud.id) as ratificaciones')
                ->first();
                $pagosRatificacionMonto = Pagos::whereBetween('pago_solicitud.fecha',[$fecha_inicial,$fecha_final])
                ->join('turnos','turnos.id','pago_solicitud.id_solicitud')
                ->join('users','users.id','turnos.id_conciliador')
                ->where('pago_solicitud.tipo_pago',"Ratificacion")
                ->selectRaw('sum(pago_solicitud.monto) as ratificacionesMonto')
                ->first();

                $pagosRatificacionPagado = Pagos::whereBetween('pago_solicitud.fecha',[$fecha_inicial,$fecha_final])
                ->join('turnos','turnos.id','pago_solicitud.id_solicitud')
                ->join('users','users.id','turnos.id_conciliador')
                ->where('pago_solicitud.tipo_pago',"Ratificacion")
                ->where('pago_solicitud.estatus',"Pagado")
                ->selectRaw('count(pago_solicitud.id) as ratificaciones')
                ->first();
                $pagosRatificacionMontoPagado = Pagos::whereBetween('pago_solicitud.fecha',[$fecha_inicial,$fecha_final])
                ->join('turnos','turnos.id','pago_solicitud.id_solicitud')
                ->join('users','users.id','turnos.id_conciliador')
                ->where('pago_solicitud.tipo_pago',"Ratificacion")
                ->where('pago_solicitud.estatus',"Pagado")
                ->selectRaw('sum(pago_solicitud.monto) as ratificacionesMonto')
                ->first();

                $pagosRatificacionPendiente = Pagos::whereBetween('pago_solicitud.fecha',[$fecha_inicial,$fecha_final])
                ->join('turnos','turnos.id','pago_solicitud.id_solicitud')
                ->join('users','users.id','turnos.id_conciliador')
                ->where('pago_solicitud.tipo_pago',"Ratificacion")
                ->where('pago_solicitud.estatus',"Pendiente")
                ->selectRaw('count(pago_solicitud.id) as ratificaciones')
                ->first();
                $pagosRatificacionMontoPendiente = Pagos::whereBetween('pago_solicitud.fecha',[$fecha_inicial,$fecha_final])
                ->join('turnos','turnos.id','pago_solicitud.id_solicitud')
                ->join('users','users.id','turnos.id_conciliador')
                ->where('pago_solicitud.tipo_pago',"Ratificacion")
                ->where('pago_solicitud.estatus',"Pendiente")
                ->selectRaw('sum(pago_solicitud.monto) as ratificacionesMonto')
                ->first();
            }else{
                $pagosRatificacion = Pagos::whereBetween('pago_solicitud.fecha',[$fecha_inicial,$fecha_final])
                ->where('pago_solicitud.delegacion',$sede)
                ->join('turnos','turnos.id','pago_solicitud.id_solicitud')
                ->join('users','users.id','turnos.id_conciliador')
                ->where('pago_solicitud.tipo_pago',"Ratificacion")
                ->selectRaw('count(pago_solicitud.id) as ratificaciones')
                ->first();
                $pagosRatificacionMonto = Pagos::whereBetween('pago_solicitud.fecha',[$fecha_inicial,$fecha_final])
                ->where('pago_solicitud.delegacion',$sede)
                ->join('turnos','turnos.id','pago_solicitud.id_solicitud')
                ->join('users','users.id','turnos.id_conciliador')
                ->where('pago_solicitud.tipo_pago',"Ratificacion")
                ->selectRaw('sum(pago_solicitud.monto) as ratificacionesMonto')
                ->first();

                $pagosRatificacionPagado = Pagos::whereBetween('pago_solicitud.fecha',[$fecha_inicial,$fecha_final])
                ->join('turnos','turnos.id','pago_solicitud.id_solicitud')
                ->join('users','users.id','turnos.id_conciliador')
                ->where('pago_solicitud.tipo_pago',"Ratificacion")
                ->where('pago_solicitud.estatus',"Pagado")
                ->selectRaw('count(pago_solicitud.id) as ratificaciones')
                ->first();
                $pagosRatificacionMontoPagado = Pagos::whereBetween('pago_solicitud.fecha',[$fecha_inicial,$fecha_final])
                ->join('turnos','turnos.id','pago_solicitud.id_solicitud')
                ->join('users','users.id','turnos.id_conciliador')
                ->where('pago_solicitud.tipo_pago',"Ratificacion")
                ->where('pago_solicitud.estatus',"Pagado")
                ->selectRaw('sum(pago_solicitud.monto) as ratificacionesMonto')
                ->first();

                $pagosRatificacionPendiente = Pagos::whereBetween('pago_solicitud.fecha',[$fecha_inicial,$fecha_final])
                ->join('turnos','turnos.id','pago_solicitud.id_solicitud')
                ->join('users','users.id','turnos.id_conciliador')
                ->where('pago_solicitud.tipo_pago',"Ratificacion")
                ->where('pago_solicitud.estatus',"Pendiente")
                ->selectRaw('count(pago_solicitud.id) as ratificaciones')
                ->first();
                $pagosRatificacionMontoPendiente = Pagos::whereBetween('pago_solicitud.fecha',[$fecha_inicial,$fecha_final])
                ->join('turnos','turnos.id','pago_solicitud.id_solicitud')
                ->join('users','users.id','turnos.id_conciliador')
                ->where('pago_solicitud.tipo_pago',"Ratificacion")
                ->where('pago_solicitud.estatus',"Pendiente")
                ->selectRaw('sum(pago_solicitud.monto) as ratificacionesMonto')
                ->first();
            }

            //Pagos de audiencias
            if($sede === "Todos"){
                $pagosAudiencias = Pagos::whereBetween('pago_solicitud.fecha',[$fecha_inicial,$fecha_final])
                ->join('users','users.id','pago_solicitud.id_conciliador')
                ->where('pago_solicitud.tipo_pago',"Audiencia")
                ->selectRaw('count(pago_solicitud.id) as audiencias')
                ->first();
                $pagosAudienciasMonto = Pagos::whereBetween('pago_solicitud.fecha',[$fecha_inicial,$fecha_final])
                ->join('users','users.id','pago_solicitud.id_conciliador')
                ->where('pago_solicitud.tipo_pago',"Audiencia")
                ->selectRaw('sum(pago_solicitud.monto) as audienciasMonto')
                ->first();
            }else{
                $pagosAudiencias = Pagos::whereBetween('pago_solicitud.fecha',[$fecha_inicial,$fecha_final])
                ->where('pago_solicitud.delegacion',$sede)
                ->join('users','users.id','pago_solicitud.id_conciliador')
                ->where('pago_solicitud.tipo_pago',"Audiencia")
                ->selectRaw('count(pago_solicitud.id) as audiencias')
                ->first();
                $pagosAudienciasMonto = Pagos::whereBetween('pago_solicitud.fecha',[$fecha_inicial,$fecha_final])
                ->join('users','users.id','pago_solicitud.id_conciliador')
                ->where('pago_solicitud.tipo_pago',"Audiencia")
                ->selectRaw('sum(pago_solicitud.monto) as audienciasMonto')
                ->first();
            }

            $pdf = \PDF::loadView('PDF/Estadisticas/reporte-CumplimientosMonto', 
            compact('fecha_inicial','fecha_final','pagosRatificacion','pagosRatificacionMonto',
            'pagosAudiencias','pagosAudienciasMonto','pagosRatificacionPagado','pagosRatificacionMontoPagado',
            'pagosRatificacionPendiente','pagosRatificacionMontoPendiente'));
            return $pdf->stream('archivo.pdf');
        }
        if($data["tipo_reporte"] == "Cumplimientos"){
        }
        else if($data["tipo_reporte"] == "Ratificaciones"){
            if($data["tipo"] == "2"){
                return Excel::download(new RatificacionesFromViewExport($fecha_inicial, $fecha_final,$sede), 'productos.xlsx');
            }
            //Para el PDF
            else{
                //Pagos de ratificacion(Turnos)
                if($sede === "Todos"){
                    $Ratificacion = Turnos::whereBetween('turnos.fecha',[$fecha_inicial,$fecha_final])
                    ->join('users','users.id','turnos.id_conciliador')
                    ->join('users as user_usuario','user_usuario.id','turnos.user_id')
                    ->select('turnos.*','users.name','user_usuario.name as auxiliar')
                    ->orderby('user_usuario.name')
                    ->get();
                }else{
                    $Ratificacion = Turnos::whereBetween('fecha',[$fecha_inicial,$fecha_final])
                    ->where('turnos.delegacion',$sede)
                    ->join('users','users.id','turnos.id_conciliador')
                    ->join('users as user_usuario','user_usuario.id','turnos.user_id')
                    ->select('turnos.*','users.name','user_usuario.name as auxiliar')
                    ->orderby('user_usuario.name')
                    ->get();
                }

                $pdf = \PDF::loadView('PDF/Estadisticas/Ratificaciones',compact('fecha_inicial','fecha_final','Ratificacion'));
                $pdf->setPaper('a4', 'landscape');
                return $pdf->stream('archivo.pdf');
            }
        }
        else if($data["tipo_reporte"] == "RatificacionesUsuario"){
            //Pagos de ratificacion(Turnos)
            if($sede === "Todos"){
                $usuarios = Turnos::whereBetween('turnos.fecha',[$fecha_inicial,$fecha_final])
                ->join('users','users.id','turnos.user_id')
                ->select('users.name', DB::raw('count(turnos.id) as ratificacion'), DB::raw('SUM(turnos.monto) as ratificacionesMonto') )
                ->groupBy('users.id', 'users.name')
                ->get();

            } else {
                $usuarios = Turnos::whereBetween('turnos.fecha',[$fecha_inicial,$fecha_final])
                ->where('turnos.delegacion',$sede)
                ->join('users','users.id','turnos.user_id')
                ->select('users.name', DB::raw('count(turnos.id) as ratificacion'), DB::raw('SUM(turnos.monto) as ratificacionesMonto') )
                ->groupBy('users.id', 'users.name')
                ->get();
            }
            
            $pdf = \PDF::loadView('PDF/Estadisticas/RatificacionUsuario',compact('fecha_inicial','fecha_final','usuarios'));
            //$pdf->setPaper('a4', 'landscape');
            return $pdf->stream('archivo.pdf');
        
            
        }
        else if($data["tipo_reporte"] == "Notificaciones"){
            //Notificaciones
            return Excel::download(new NotificacionesExport($fecha_inicial, $fecha_final, $sede, $auxiliar , $notificador), 'notificaciones.xlsx');
        }
        else if($data["tipo_reporte"] == "Graficas"){
            return view('PDF/Estadisticas/Graficas');
        }
        else if($data["tipo_reporte"] == "Concentrado"){
            /*
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
            */
            $pdf = \PDF::loadView('PDF/estadisticas/Reporte_cuantitativo');
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
        $municipios = Municipios::where('estado',16)->get();
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
        $municipios = Municipios::where('estado',16)->get();
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
        $nue = SeerPerGeneral_old::where("NUE",$data["NUE"])->first();
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

        SeerPerGeneral_old::create($data_general);  
        $id_general  = SeerPerGeneral_old::latest('id')->first();

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
            SeerCitados_old::create($data_citado);
        }

        return redirect()->route('seer');
    }

    public function auxiliar_personar(Request $request){
        $data = $request->all();
        $id = auth()->user()->id;
        $user = User::find($id);
        $fecha_actual = date('y-m-d');
        
        //Validar el Numero de expediente
        $nue = SeerPerGeneral_old::where("NUE",$data["NUE"])->first();
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

        SeerPerGeneral_old::create($data_general);  
        $id_general  = SeerPerGeneral_old::latest('id')->first();

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
                SeerCitados_old::create($data_citado);
            }
        }

        return redirect()->route('seer');
    }

    public function ver_auxiliar($id){
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $userRole = $user->roles->pluck('name')->all();

        $general  = SeerPerGeneral_old::find($id);
        $auxiliar = SeerPerAuxiliar::where("id_solicitud",$id)->first();
        
        $estado_citado = Estados::find($general["estado_solicitante"]);
        $mun_citado    = Municipios::find($general["mun_solicitante"]);

        $estado_solicitante = Estados::find($general["estado_citado"]);
        $mun_solicitante    = Municipios::find($general["mun_citado"]);
        $conciliador        = User::find($general["conciliador_id"]);

        $citados           = SeerCitados_old::where("id_solicitud",$id)->get();
        $notificadores     = SeerCitados_old::where("id_solicitud",$id)
        ->join("users","users.id","=","seer_citados_old.id_notificador")
        ->select("users.name as notificador", "seer_citados_old.created_at", "seer_citados_old.nombre as citado","seer_citados_old.direccion","seer_citados_old.estatus")
        ->get();
        $audiencia          = SeerPerConciliador_old::where("id_solicitud",$id)->get();
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
            SeerPerGeneral_old::where('id', $data["id"])
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
        
        SeerCitados_old::where('id_solicitud',$data["id"])->delete();

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
            SeerCitados_old::create($data_citado);
        }

        SeerPerConciliador_old::create($data_conciliador);  

        return redirect()->route('seer');
    }
  
    public function crear_audiencia($id){
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $userRole = $user->roles->pluck('name')->all();

        $general  = SeerPerGeneral_old::find($id);
        $auxiliar = SeerPerAuxiliar::where("id_solicitud",$id)->first();
        $audiencia = SeerPerConciliador_old::where("id_solicitud",$id)->get();

        $citados = SeerCitados_old::
        where("seer_citados_old.id_solicitud",$id)
        //->join("seer_general","seer_citados.id_solicitud", "=" , "seer_general.id")
        ->select('seer_citados_old.nombre as citado', 'seer_citados_old.direccion')
        //->groupBy("seer_citados.id")
        ->get();

        //Voy a mandar todos las variables
        $estados            = Estados::all();
        $municipios         = Municipios::where('estado',16)->get();
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
        $municipios = Municipios::all();

        return view('notificaciones.actualizarCitado', compact('id','municipios'));
    }

    public function update_notificador(Request $request){
        $data = $request->all();
        $documento = "Sin documento";
        $documento1 = "Sin documento";
        $documento2 = "Sin documento";
        //$foto = "Sin documento";
       /* $foto1 = "Sin documento";
        $foto2 = "Sin documento";*/
        $fecha_actual = date('y-m-d');

        if ($request->hasFile('foto')) {
            $documento = $data["id"] . "-foto1.jpg";
            Storage::putFileAs('documentos_notificacion', $request->file('foto'), $documento);
        }
        
        if ($request->hasFile('foto1')) {
            $documento1 = $data["id"] . "-foto2.jpg";
            Storage::putFileAs('documentos_notificacion', $request->file('foto1'), $documento1);
        }
        
        if ($request->hasFile('foto2')) {
            $documento2 = $data["id"] . "-foto3.jpg";
            Storage::putFileAs('documentos_notificacion', $request->file('foto2'), $documento2);
        }
        /*if(!isset($foto)){
            $documento = $data["id"]."-foto1.jpg";
            $path = Storage::putFileAs(
                'documentos_notificacion', $request->file('foto'), $documento
            );
        }
        
        if($request->hasFile($foto1)){
            $documento1 = $data["id"]."-foto2.jpg";
            $path = Storage::putFileAs(
                'documentos_notificacion', $request->file('foto1'), $documento1
            );
        }
        if($request->hasFile($foto2)){
            $documento2 = $data["id"]."-foto3.jpg";
            $path = Storage::putFileAs(
                'documentos_notificacion', $request->file('foto2'), $documento2
            );
        }*/
        
        $request->validate([
            'quien_atiende'               => 'nullable',
            'medio'                       => 'nullable',
            'vialidad_notificacion'       => 'nullable',
            'abundar_area'                => 'nullable',
            'abundar_inmueble'            => 'nullable',
            'nombre_notificacion'         => 'nullable',
            'relacion_notificacion'       => 'nullable',
            'puesto'                      => 'nullable',
            'identificacion_notificacion' => 'nullable',
            'motivo_identificacion'       => 'nullable',
            'firma'                       => 'nullable',
            'problema_diligencia'         => 'nullable',
            'genero'                      => 'nullable',
            'tez'                         => 'nullable',
            'edad_filiacion'              => 'nullable',
            'altura'                      => 'nullable',
            'complexion'                  => 'nullable',
            'cabello'                     => 'nullable',
            'ojos'                        => 'nullable',
            'particulares'                => 'nullable',
            'especificar'                 => 'nullable',
            'municipio_citado'            => 'nullable',
        ]);


        if($data["tipo_llenado"] == 1){
            SeerCitados::find($data["id"])
                ->update([
                    'estatus'                    => $data["estatus"],
                    'observaciones'              => $data["observaciones"],
                    'documento'                  => $documento,
                    'documento1'                 => $documento1,
                    'documento2'                 => $documento2,
                    'fecha'                      => $fecha_actual,
                    'quien_atiende'              => $data["quien_atiende"],
                    'medio'                      => $data["medio"],
                    'vialidad_notificacion'      => $data["vialidad_notificacion"],
                    'abundar_area'               => $data["abundar_area"],
                    'abundar_inmueble'           => $data["abundar_inmueble"],
                    'nombre_notificacion'        => $data["nombre_notificacion"],
                    'relacion_notificacion'      => $data["relacion_notificacion"],
                    'puesto'                     => $data["puesto"],
                    'identificacion_notificacion'=> $data["identificacion_notificacion"],
                    'motivo_identificacion'      => $data["motivo_identificacion"],
                    'firma'                      => $data["firma"],
                    'problema_diligencia'        => $data["problema_diligencia"],
                    'genero'                     => $data["genero"],
                    'tez'                        => $data["tez"],
                    'edad_filiacion'             => $data["edad_filiacion"],
                    'altura'                     => $data["altura"],
                    'complexion'                 => $data["complexion"],
                    'cabello'                    => $data["cabello"],
                    'ojos'                       => $data["ojos"],
                    'particulares'               => $data["particulares"],
                    'especificar'                => $data["especificar"],
                    'municipio_citado'           => $data["municipio_citado"],
                ]);
        }
        else{
            $solicitud = SeerCitados::find($data["id"]);
            $citados = SeerCitados::where('id_solicitud',$solicitud["id_solicitud"])->get();
            foreach($citados as $citado){
                SeerCitados::find($citado["id"])
                ->update([
                    'estatus'                    => $data["estatus"],
                    'observaciones'              => $data["observaciones"],
                    'documento'                  => $documento,
                    'documento1'                 => $documento1,
                    'documento2'                 => $documento2,
                    'fecha'                      => $fecha_actual,
                    'quien_atiende'              => $data["quien_atiende"],
                    'medio'                      => $data["medio"],
                    'vialidad_notificacion'      => $data["vialidad_notificacion"],
                    'abundar_area'               => $data["abundar_area"],
                    'abundar_inmueble'           => $data["abundar_inmueble"],
                    'nombre_notificacion'        => $data["nombre_notificacion"],
                    'relacion_notificacion'      => $data["relacion_notificacion"],
                    'puesto'                     => $data["puesto"],
                    'identificacion_notificacion'=> $data["identificacion_notificacion"],
                    'motivo_identificacion'      => $data["motivo_identificacion"],
                    'firma'                      => $data["firma"],
                    'problema_diligencia'        => $data["problema_diligencia"],
                    'genero'                     => $data["genero"],
                    'tez'                        => $data["tez"],
                    'edad_filiacion'             => $data["edad_filiacion"],
                    'altura'                     => $data["altura"],
                    'complexion'                 => $data["complexion"],
                    'cabello'                    => $data["cabello"],
                    'ojos'                       => $data["ojos"],
                    'particulares'               => $data["particulares"],
                    'especificar'                => $data["especificar"],
                    'municipio_citado'           => $data["municipio_citado"],
                ]);
            }
        }

        return redirect()->route('seer');  
    }

    public function store_enlace(Request $request){
        $data = $request->all();
        SeerCitados::where('id', $data["id"])
        ->update(['id_notificador' => $data["notificador"], 'estatus' => "Pendiente"]);
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
        SeerCitados_old::where('id_solicitud',$id)->delete();
        //Borrar de la tabla Seer General
        SeerPerGeneral_old::find($id)->delete();
       
        return redirect()->route('seer');
    }

    public function editar_persona($id){
        $id_usurario = auth()->user()->id;
        $user = User::find($id_usurario);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $relacionEloquent = "roles";
        
        $general    = SeerPerGeneral_old::find($id);
        $auxiliar   = SeerPerAuxiliar::where("id_solicitud",$id)->first();
        $estados    = Estados::all();
        $municipios = Municipios::where('estado',16)->get();
        $citados    = SeerCitados_old::where("id_solicitud",$id)->get();
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
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();

        return view('estadisticas.generaHistorial',compact('userRole'));
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
            ->whereBetween('seer_general.fecha', [$fechaInicio, $fechaFin])
            ->get();
        return view('estadisticas.verHistorial', compact('personas'));    

    } 

    public function solicitudesLinea(){
        return view('solicitud');
    }

    public function Industrias($tipo_solicitud){
        return view('solicitudes.tipoIndustria', compact('tipo_solicitud'));
    } 
    
    //Pre registro para solicitudes
    public function RTemportal(){
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
        $municipios = Municipios::where('estado',16)->get();
        return view('solicitudes.solicitante', compact('estados','municipios','id'));
    }
    
    public function solicitud_parte2(Request $request){
        $data = $request->all();
        $id = $data['id'];

        //validando información
       $request->validate([
            /*'tipo'                      => 'required|in:Fisica,Moral',*/
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
            /*'referencias'               => 'required|string|max:300',
            'calle1'                    => 'required',
            'calle2'                    => 'required',*/
            'puesto'                    => 'required', 
            'periodo_pago'              => 'required',
            'pago'                      => 'required',
            'horas'                     => 'required',
            'fecha_ingreso'             => 'required',
            'jornada'                   => 'required',
            'identificacion'            => 'required',
            //'documentoCurp'             => 'required',
            'documentoIdentificacion'   => 'required',
            'num_identificacion'        => 'required',
        ]);
        
        $data_insert=array(
            'id_solicitud'         => $data["id"],
            /*'tipo_persona'         => $data["tipo"],*/
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
            /*'referencia'           => $data["referencias"],
            'calle2'               => $data["calle1"],
            'calle3'               => $data["calle2"],*/
            'puesto'               => $data["puesto"],
            'pago'                 => $data["pago"],
            'periodo_pago'         => $data["periodo_pago"],
            'horas_semana'         => $data["horas"],
            'fecha_ingreso'        => $data["fecha_ingreso"],
            'jornada'              => $data["jornada"],
            'identificacion'       => $data["identificacion"],
            'num_identificacion'   => $data["num_identificacion"],
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
            //$data_insert["fecha_salida"]  =  $data["fecha_salida"];
        }
        if(isset($data["telefono2"])){
            $data_insert["telefono2"] =  $data["telefono2"];
        }
        if(isset($data["seguro"])){
            $data_insert["nss"] =  $data["seguro"];
        }
        if(isset($data["fecha_salida"])){
            $data_insert["fecha_salida"] =  $data["fecha_salida"];
        }
        if(isset($data["referencias"])){
            $data_insert["referencia"] =  $data["referencias"];
        }
        if(isset($data["calle1"])){
            $data_insert["calle2"] =  $data["calle1"];
        }
        if(isset($data["calle2"])){
            $data_insert["calle3"] =  $data["calle2"];
        } 
        //CURP
        $documento = $data["curp"]."_CURP.pdf";
        /*$path = Storage::putFileAs(
            'documentosSolicitud', $request->file('documentoCurp'), $documento
        );*/
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

        //$data_insert["documentoCurp"] = $documento;
        $data_insert["documentoIdentificacion"] = $documentoidentificacion;
       
        SeerSolicitante::create($data_insert);
        //return view('solicitudes.aviso',compact('folio'));
    
        //$estados=Estados::all();
        return redirect()->route('agregar_citado', ['id' => $id] ); 
    }

    public function guardar_citado(Request $request){
        $data = $request->all();
        $imagen_domicilio1 = "Sin documento";
        $imagen_domicilio2 = "Sin documento";

        if ($request->hasFile('foto1')) {
            $imagen_domicilio1 = $data["id"] . "-domicilio_Citado1.jpg" . Str::random(8) . ".jpg";
            Storage::putFileAs('documentosSolicitud', $request->file('foto1'), $imagen_domicilio1);
        }
        
        if ($request->hasFile('foto2')) {
            $imagen_domicilio2 = $data["id"] . "-domicilio_Citado2.jpg" . Str::random(8) . ".jpg";
            Storage::putFileAs('documentosSolicitud', $request->file('foto2'), $imagen_domicilio2);
        }
        $foto1 = $imagen_domicilio1;
        $foto2 = $imagen_domicilio2;
        //validando información
        $request->validate([
            'id'                => 'required',
            'colonia'           => 'required',
            'vialidad'          => 'required',
            'cp'                => 'required|numeric',
            'calle'             => 'required',
            'exterior'          => 'required',
            'referencia'        => 'required',
            'municipio_citado'  => 'required',
        ]);
        
        $data_insert=array(
            'id_solicitud'      => $data["id"],
            'colonia'           => $data["colonia"],
            'cp'                => $data["cp"],
            'n_ext'             => $data["exterior"],
            'calle'             => $data["calle"],
            'tipo_vialidad'     => $data["vialidad"],
            'referencia'        => $data["referencia"],
            'municipio_citado'  => $data["municipio_citado"],
            'imagen_domicilio1' => $foto1,
            'imagen_domicilio2' => $foto2, 
        );
        $data_insert["notificacion"] =  $data["notificacion"];

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
        if (isset($data["tipo"])) {
            $data_insert["tipo_persona"] = $data["tipo"];
        
            if ($data["tipo"] == "Moral" && isset($data["razon"])) {
                $data_insert["nombre"] = $data["razon"];
            }
        
            if ($data["tipo"] == "Fisica" && isset($data["nombre"])) {
                $data_insert["nombre"] = $data["nombre"];
            }
        }
        //Se van a generar el citatorio
        SeerCitados::create($data_insert); 
        // Si es persona física, elimina los apellidos para este citado
        if (isset($data["tipo"]) && $data["tipo"] === "Fisica") {
            unset($data_insert["primer_apellido"], $data_insert["segundo_apellido"]);
        }
        //Se van a generar quien resulte responsable
        $data_insert["nombre"] = "QUIEN O QUIENES RESULTEN RESPONSABLES Y/O BENEFICIARIOS Y/O
        USUFRUCTUARIOS Y/O PROPIETARIOS DE LA FUENTE DE EMPLEO UBICADA EN ".$data["calle1"].", NÚMERO ".$data["exterior"]." COLONIA ".$data["colonia"].", ".$data["municipio_citado"].", MICHOACÁN.";
        SeerCitados::create($data_insert); 

        return back()->with('success', 'Citado agregado correctamente, puedes agregar otro o continuar.');
    }

    public function vista_citado($id){
        $estados = Estados::all();
        $municipios = Municipios::where('estado',16)->get();
        $citados = SeerCitados::where('id_solicitud', $id)->count(); //LLeva el conteo de los citados agregados

        return view('solicitudes.citados',compact('estados','id','citados','municipios'));
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

        return view('solicitudes.aviso',compact('id','mensaje','delegacion'));
    }

    public function solicitudes_pendientes(){
        $solicitudes = SeerPerGeneral::where('validado_conciliador','Pendiente')
        ->join('catalogo_rama','catalogo_rama.id','seer_general.id_rama')
        ->join('seer_solicitante','seer_solicitante.id_solicitud','seer_general.id')
        ->select('seer_general.id','seer_general.fecha','seer_solicitante.nombre','seer_general.delegacion','seer_general.actividad',
        'catalogo_rama.rama_industrial','seer_general.tipo_solicitud','seer_general.estatus')
        ->whereIn('seer_general.estatus', ['Pendiente', 'Prevencion'])
        ->orderBy('seer_general.fecha')
        ->get();

        return view('solicitudes.solicitudes_pendientes', compact('solicitudes'));
    }

    public function solicitudes_pendientes_revisar($id){
        $id_user = auth()->user()->id;
        $user = User::find($id_user);
        $id             = $id;
        $general        = SeerPerGeneral::find($id);
        $ramas          = SolicitudRama::all();
        $solicitantes   = SeerSolicitante::where("id_solicitud",$id)->get();
        $citados        = SeerCitados::where("id_solicitud",$id)->get();
        $estados        = Estados::all();
        $municipios     = Municipios::where('estado',16)->get();
        $conciliadores  = User::find($general["conciliador_id"]);
        $audiencia      = SeerPerConciliador::where("id_solicitud",$id)->get();
        //Catalogo de motivos
        //$mostrarMotivos = SolicitudMotivo::all();
        $mostrarMotivos = SolicitudMotivo::where('tipo_solicitud', $general->tipo_solicitud)->get();
        //Motivos capturados
        $motivos        = SeerMotivo::join('catalogo_motivos','catalogo_motivos.id','seer_motivos.id_motivo')
        ->where('id_solicitud',$id)
        ->select('catalogo_motivos.motivo','seer_motivos.id')->get();

        return view('solicitudes.revisar_solicitud', compact('id','general','solicitantes','citados','ramas','estados','municipios','mostrarMotivos','motivos','conciliadores','audiencia'));
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
        $municipios     = Municipios::where('estado',16)->get();
        
        //Catalogo de motivos
        //$mostrarMotivos = SolicitudMotivo::all();
        $mostrarMotivos = SolicitudMotivo::where('tipo_solicitud', $general->tipo_solicitud)->get();
        //Motivos capturados
        $motivos        = SeerMotivo::join('catalogo_motivos','catalogo_motivos.id','seer_motivos.id_motivo')
        ->where('id_solicitud',$id)
        ->select('catalogo_motivos.motivo','seer_motivos.id')->get();

        return view('solicitudes.revisar_solicitud', compact('id','general','solicitantes','citados','ramas','estados','municipios','mostrarMotivos','motivos'));
    }

    public function solicitud_confirmar(Request $request){
        $data = $request->all();

        //Se va asignar el conciliador y la sala
        $id_user = auth()->user()->id;
        $user = User::find($id_user);
        $listado_auxiliares = array();
        $relacionEloquent = 'roles';
        $fecha_actual = date('y-m-d');
        
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
        ->update([/*'tipo_persona' => $data["tipo_persona_solicitante"],*/ 
            'curp'                  => $data["curp_solicitante"],
            //'rfc'                   => $data["rfc_solicitante"],
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
            //'referencia'            => $data["referencia_solicitante"],
            'colonia'               => $data["colonia_solicitante"],
            //'calle2'                => $data["calle2_solicitante"],
            //'calle3'                => $data["calle3_solicitante"],
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
        if(isset($data["rfc"])){
            SeerSolicitante::where('id_solicitud', $data["id"])->update(['rfc' => $data["rfc_solicitante"] ]);
        }
        if(isset($data["referencia"])){
            SeerSolicitante::where('id_solicitud', $data["id"])->update(['referencia' => $data["referencia_solicitante"] ]);
        }
        if(isset($data["calle2"])){
            SeerSolicitante::where('id_solicitud', $data["id"])->update(['calle2' => $data["calle2_solicitante"] ]);
        }
        if(isset($data["calle3"])){
            SeerSolicitante::where('id_solicitud', $data["id"])->update(['calle3' => $data["calle3_solicitante"] ]);
        }

        //Citados
        SeerCitados::where('id_solicitud',$data["id"])->delete();
        $cont = count($data["colonia_citado"]);
        for($i = 0; $i < $cont; $i++) {

            $foto1 = $data["imagen_domicilio1"][$i] ?? 'Sin documento';
            $foto2 = $data["imagen_domicilio2"][$i] ?? 'Sin documento';
        
            if ($request->hasFile("foto1.$i")) {
                $file = $request->file("foto1")[$i];
                $foto1 = $data["id"] . "-citado_foto1_" . Str::random(8) . "." . $file->getClientOriginalExtension();
                Storage::putFileAs('documentosSolicitud', $file, $foto1);
            }
        
            if ($request->hasFile("foto2.$i")) {
                $file = $request->file("foto2")[$i];
                $foto2 = $data["id"] . "-citado_foto2_" . Str::random(8) . "." . $file->getClientOriginalExtension();
                Storage::putFileAs('documentosSolicitud', $file, $foto2);
            }
            $data_insert=array(
                'id_solicitud'      => $data["id"],
                'colonia'           => $data["colonia_citado"][$i],
                'cp'                => $data["cp_citado"][$i],
                'n_ext'             => $data["n_ext_citado"][$i],
                'calle'             => $data["n_int_citado"][$i],
                'tipo_vialidad'     => $data["vialidad_citado"][$i],
                'referencia'        => $data["referencia_citado"][$i],
                'municipio_citado'  => $data["municipio_citado"][$i],
                'tipo_persona'      => $data["tipo_persona_citado"][$i],
                'nombre'            => $data["nombre_citado"][$i],
                'notificacion'      => $data["notificacion"][$i],
                'primer_apellido'   => $data["primer_apellido"][$i],
                'segundo_apellido'  => $data["segundo_apellido"][$i],
                'calle'             => $data["calle_citado"][$i],
                'calle1'            => $data["calle1_citado"][$i],
                'calle2'            => $data["calle2_citado"][$i],
                'curp'              => $data["curp_citado"][$i],
                'rfc'               => $data["rfc_citado"][$i],
                'imagen_domicilio1' => $foto1,
                'imagen_domicilio2' => $foto2,
            );
            
            if(isset($data["traductor"])){
                $data_insert["traductor"] =  1;
                $data_insert["lenguaje"]  =  $data["lenguaje"];
            }
            if(isset($data["calle1"])){
                SeerSolicitante::where('id_solicitud', $data["id"])->update(['calle1' => $data["calle1_citado"] ]);
            }
            if(isset($data["calle2"])){
                SeerSolicitante::where('id_solicitud', $data["id"])->update(['calle2' => $data["calle2_citado"] ]);
            }
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

        $numero_audiencia = $this->GeneraAudiencia($data["id"]);
        $numero_audiencias = SeerPerConciliador::find($data["id"]);
        if(!isset($numero_audiencias)){
            $num_audi = 0;
        }
        else{
            $num_audi = $numero_audiencias->numero_audiencias;
        }
        $num_audi = $num_audi+1;

        $Audiencia = $this->ObtenerAudiencia($delegacion["delegacion"]);

        $sala = 1;
        switch($Audiencia[3]){
           //Morelia
            case 16:
                $sala = "Sala 2";
            case 22:
                $sala = "Sala 11";
            case 25:
                $sala = "Sala 12";
            case 33:
                $sala = "Sala 8";
            case 35:
                $sala = "Sala 9";
            case 36:
                $sala = "Sala 7";
            case 38:
                $sala = "Sala 5";
            //Usuapan
            case 41:
                $sala = "Sala 10";
            case 42:
                $sala = "Sala 4";
            case 45:
                $sala = "Sala 1";
            //Zamora
            case 51:
                $sala = "Sala 3";
            case 54:
                $sala = "Sala 6";
            default:
                $sala = "Pendiente";
        }
        $audiencia_insert=array(
            'id_solicitud'      => $data["id"],
            'numero_audiencia'  => $num_audi,
            'folio_audiencia'   => $numero_audiencia[0],
            'fecha'             => $Audiencia[0],
            'hora'              => $Audiencia[1],
            'id_conciliador'    => $Audiencia[3],
            'sala'              => $sala,
            'delegacion'        => $delegacion["delegacion"]
        );
        Audiencias::create($audiencia_insert);
        //Actualizar genera
        SeerPerGeneral::find($data["id"])->update(['conciliador_id' => $Audiencia[3], 'estatus' => 'Confirmado' ]);
        
        return redirect()->route('solicitudes_pendientes'); 
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
        $folio = $del."/SOL"."/".$año_actual."/".$numeroConCeros;
    
        return $folio;
    }

    public function agregar_citado_edicion(Request $request){
        $data = $request->all();
        $imagen_domicilio1 = "Sin documento";
        $imagen_domicilio2 = "Sin documento";

        if ($request->hasFile('foto1')) {
            $imagen_domicilio1 = $data["id"] . "-domicilio_Citado1.jpg";
            Storage::putFileAs('documentosSolicitud', $request->file('foto1'), $imagen_domicilio1);
        }
        
        if ($request->hasFile('foto2')) {
            $imagen_domicilio2 = $data["id"] . "-domicilio_Citado2.jpg";
            Storage::putFileAs('documentosSolicitud', $request->file('foto2'), $imagen_domicilio2);
        }
        $foto1 = $imagen_domicilio1;
        $foto2 = $imagen_domicilio2;

        $data_insert=array(
            'id_solicitud'      => $data["id"],
            'colonia'           => $data["colonia"],
            'cp'                => $data["cp"],
            'n_ext'             => $data["exterior"],
            'calle'             => $data["calle"],
            'tipo_vialidad'     => $data["vialidad"],
            'referencia'        => $data["referencia"],
            'municipio_citado'  => $data["municipio_citado"],
            'imagen_domicilio1' => $foto1,
            'imagen_domicilio2' => $foto2,
        );
        $data_insert["notificacion"] =  $data["notificacion"];

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
        /*if(isset($data["nombre"])){
            $data_insert["nombre"] =  $data["nombre"];
        }*/
        /*if(isset($data["tipo"])){
            $data_insert["tipo_persona"] =  $data["tipo"];
        }*/
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
        /*if(isset($data["rfc"])){
            $data_insert["rfc"] =  $data["rfc"];
        }
        if(isset($data["estado_solicitante"])){
            $data_insert["estado_solicitante"] =  $data["estado_solicitante"];
        }*/
        if(isset($data["municipio_citado"])){
            $data_insert["municipio_citado"] =  $data["municipio_citado"];
        }
        if (isset($data["tipo"])) {
            $data_insert["tipo_persona"] = $data["tipo"];
        
            if ($data["tipo"] == "Moral" && isset($data["razon"])) {
                $data_insert["nombre"] = $data["razon"];
            }
        
            if ($data["tipo"] == "Fisica" && isset($data["nombre"])) {
                $data_insert["nombre"] = $data["nombre"];
            }
        }
        
        //Se van a generar el citatorio
        SeerCitados::create($data_insert); 
        if($data["lenguaje"] == "Si"){
            $data_insert["nombre"] =  "REPRESENTANTE LEGAL  DE: QUIEN O QUIENES RESULTEN RESPONSABLES Y/O BENEFICIARIOS Y/O
            USUFRUCTUARIOS Y/O PROPIETARIOS DE LA FUENTE DE EMPLEO UBICADA EN ".$data["calle1"].", NÚMERO ".$data["exterior"].
            " COLONIA ".$data["colonia"].", ".$data["municipio_citado"].", MICHOACÁN.";
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

        $mis_notificaciones = SeerPerGeneral::join('seer_citados','seer_citados.id_solicitud','=','seer_general.id')
        ->select('seer_general.id as id_solicitud','seer_citados.id as id_citado','seer_general.NUE',
            'seer_citados.nombre','seer_citados.primer_apellido','seer_citados.segundo_apellido',
            'seer_citados.colonia','seer_citados.calle','seer_citados.n_ext','seer_citados.n_int','seer_citados.estatus','seer_citados.tipo_notificacion')
        ->where('seer_general.delegacion', $user["delegacion"])
        ->where('seer_citados.id_notificador', 0)
        ->where('seer_citados.notificacion',"!=", "Trabajador")
        ->get();

        return view('notificaciones.index',compact('personas','mis_notificaciones','userRole'));
    }

    //Conciliadores en solicitudes audiencias
    public function indexA(){
        $id = auth()->user()->id;
        $user = User::find($id);
        $fecha_actual = date('y-m-d');

        $audiencias = Audiencias::where('id_conciliador', $user->id)->where('fecha', $fecha_actual)->get();
        foreach ($audiencias as $audiencia) {
            $solicitante = SeerSolicitante::where('id_solicitud', $audiencia->id_solicitud)->first();
            $audiencia->nombre = $solicitante ? $solicitante->nombre : 'Sin solicitante';
            $expediente = SeerPerGeneral::find($audiencia->id_solicitud);
            $audiencia["NUE"] = $expediente ? $expediente->NUE : 'Sin Expediente';
            $audiencia["estatus"] = $expediente ? $expediente->estatus : 'Algo';
            $audiencia["fecha"] = date('Y-m-d', strtotime($audiencia["fecha"]));
            $audiencia["hora"] = date('H:i:s', strtotime($audiencia["hora"]));
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

        $representantes = SeerCitados::
        leftjoin('abogados', 'abogados.idAbogado', '=', 'seer_citados.id_abogado')
        ->leftJoin('persona_fisica', 'persona_fisica.id', '=', 'seer_citados.id_fisica')
        ->where('seer_citados.id_solicitud', $id)
        ->select('seer_citados.nombre','seer_citados.primer_apellido','seer_citados.segundo_apellido','seer_citados.rfc',
        'abogados.nombres_patronal as nombre_abogado','abogados.primer_apellido_patronal as primero_abogado','abogados.segundo_apellido_patronal as segundo_abogado',
        'persona_fisica.nombre as nombre_fisica','persona_fisica.primer_apellido as primer_fisica','persona_fisica.segundo_apellido as segundo_fisica',
        'seer_citados.id_abogado','seer_citados.id_fisica','seer_citados.id','seer_citados.notificacion','seer_citados.estatus')
        ->get();
        $solicitante = SeerSolicitante::where('id_solicitud', $id)->first();
        $abogados = Poder::all();
        SeerPerGeneral::find($id)->update(['conciliador' => $user->id, 'estatus' => 'Confirmado']);
        $estados        = Estados::all();
        $municipios     = Municipios::where('estado',16)->get();
        return view('/audiencias/audiencias',compact('id','solicitudes','representantes','solicitante','conciliador','solicitud','abogados','estados','municipios'));
    }

    public function guardar_audiencia_archivo(Request $request){
        $data = $request->all();
        $user = auth()->user();
        $fecha_actual = date('y-m-d');

        //Guardar registro en SeerConciliador
        $numero_audiencias = SeerPerConciliador::find($data["id"]);
        if(!isset($numero_audiencias)){
            $num_audi = 0;
        }
        else{
            $num_audi = $numero_audiencias->numero_audiencias;
        }
        $num_audi = $num_audi+1;

        $numero_audiencia = $this->GeneraAudiencia($data["id"]);
        $data_conciliador = [
            'id_solicitud'          => $data["id"],
            'numero_audiencia'      => $numero_audiencia[0],
            'numero_audiencias'     => $num_audi,
            'validado'              => 'Validado',
            'fecha_conclucion'      =>  $fecha_actual,
            'consecutivo'           =>  $numero_audiencia[1],
            'conclucion'            => "Archivada"
        ];
        
        SeerPerConciliador::create($data_conciliador);  

        $solicitud = SeerPerGeneral::find($data["id"])
        ->update([
            'fecha_terminacion' => $fecha_actual, 
            'estatus'           => 'Archivada',
            'observaciones'     => $data["observaciones"], 
            'conciliador_id'    => $user->id
        ]);

        
        return redirect()->route('todas_audiencias');
    }

    public function editar_solicitud_con(Request $request) {
        $data = $request->all();
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name')->all();

        $solicitante = SeerSolicitante::where('id_solicitud', $data['id'])->first();
    
        //Actualizar Solicitante
        SeerSolicitante::where('id_solicitud', $data["id"])
        ->update([
            'curp'                  => $data["curp"],
            'rfc'                   => $data["rfc"],
            'nombre'                => $data["nombre"],
            'puesto'                => $data["puesto"],
            'pago'                  => $data["pago"],
            'periodo_pago'          => $data["periodo_pago"],
            'fecha_ingreso'         => $data["fecha_ingreso"],
            'fecha_salida'          => $data["fecha_salida"],
            'jornada'               => $data["jornada"],
            'horas_semana'          => $data["horas"],
        ]);

        if(isset($data["seguro"])){
            SeerSolicitante::where('id_solicitud', $data["id"])->update(['nss' => $data["seguro"] ]);
        }
            
        return redirect()->route('inicioAudiencia', ['id' => $data['id']]);
      
    }

    public function insertar_citados_con(Request $request) {
        $data = $request->all();
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name')->all();
        
                $data = $request->all();

        if($data["tipoPersona"] == "Fisica"){
            if($data["representate"] == "No"){
                request()->validate([
                    'nombre_pF'     => 'required',
                    'primero_PF'    => 'required',
                    'segundo_Pf'    => 'required',
                    'curp_PF'       => 'required',
                    'RFC_pF'        => 'required',
                    'sexo_pf'       => 'required',
                    'giro_pF'       => 'required',
                    'correo_pF'     => 'required',
                    'telefono_PF'   => 'required',
                    'estado_pF'     => 'required',
                    'municipio_pF'  => 'required',
                    'vialidad_pF'   => 'required',
                    'vialidad_calle_pF'   => 'required',
                    'colonia_pF'   => 'required',
                    'num_ext_pF'   => 'required',
                    'cp_pF'         => 'required',
                    'documentoIne_pFSR' => 'required'
                ], $data);
            }
            else if($data["representate"] == "Si"){
                request()->validate([
                    'nombre_pF'                 => 'required',
                    'primero_PF'                => 'required',
                    'segundo_Pf'                => 'required',
                    'curp_PF'                   => 'required',
                    'RFC_pF'                    => 'required',
                    'sexo_pf'                   => 'required',
                    'giro_pF'                   => 'required',
                    'correo_pF'                 => 'required',
                    'telefono_PF'               => 'required',
                    'estado_pF'                 => 'required',
                    'municipio_pF'              => 'required',
                    'vialidad_pF'               => 'required',
                    'vialidad_calle_pF'         => 'required',
                    'colonia_pF'                => 'required',
                    'num_ext_pF'                => 'required',
                    'cp_pF'                     => 'required',
                    "nombre_representante_pF"   => 'required',
                    "primer_representante_pF"   => 'required',
                    "segundo_representante_pF"  => 'required',
                    "curp_representante_pF"     => 'required',
                    "sexo_representante_pF"     => 'required',
                    "correo_representante_pF"   => 'required',
                    "telefono_representante_pF" => 'required',
                    "tipo_documento_pF"         => 'required',
                    "fecha_expedicion_pF"       => 'required',
                    //"fecha_vigencia_pF"         => 'required',
                    "descripcion_pF"            => 'required',
                    "documentoIne_pF"           => 'required',
                    'documentoRepresentacion_pF'=> 'required',
                    'documentoPoder_pF'         => 'required'
                ], $data);
            }
        }   
        else {
            request()->validate([
                "razon"                         => 'required',
                "rfc_moral"                     => 'required',
                "giro_moral"                    => 'required',
                "estado_moral"                  => 'required',
                "municipio_moral"               => 'required',
                "vialidad_Moral"                => 'required',
                "vialidad_calleMoral"           => 'required',
                "colonia_moral"                 => 'required',
                "num_ext_moral"                 => 'required',
                "cp_moral"                      => 'required',
                "nombre_representante_Moral"    => 'required',
                "primer_Moral"                  => 'required',
                "segundo_Moral"                 => 'required',
                "curp_moral"                    => 'required',
                "sexo_Moral"                    => 'required',
                "correo_Moral"                  => 'required',
                "telefono_Moral"                => 'required',
                "tipo_Moral"                    => 'required',
                "fecha_expedicicion_Moral"      => 'required',
                //"fecha_vigencia_Moral"          => 'required',
                "descripcion_Moral"             => 'required',
                "documentoIne_Moral"            => 'required',
                "documentoRepresentacion_Moral" => 'required',
                "documentoPoder"                => 'required'
            ], $data);
        }

        //Vamos insetar los datos para la persona fisica con representante legal
        if($data["tipoPersona"] == "Fisica"){
            if($data["representate"] == "No"){
                $data_insertar = array(
                        'tipo'                      => $data["tipoPersona"],
                        'nombres_patronal'          => $data["nombre_pF"],
                        'primer_apellido_patronal'  => $data["primero_PF"],
                        'segundo_apellido_patronal' => $data["segundo_Pf"],
                        'curp_patronal'             => $data["curp_PF"],
                        'rfc_patronal'              => $data["RFC_pF"],
                        'sexo_patronal'             => $data["sexo_pf"],
                        'giroComercial'             => $data["giro_pF"],
                        'email_patronal'            => $data["correo_pF"],
                        'telefono_patronal'         => $data["telefono_PF"],
                        'estado_patronal'           => $data["estado_pF"],
                        'municipio_patronal'        => $data["municipio_pF"],
                        'tipo_vialidad_patronal'    => $data["vialidad_pF"],
                        'vialidad_patronal'         => $data["vialidad_calle_pF"],
                        'colonia_patronal'          => $data["colonia_pF"],
                        'num_ext_patronal'          => $data["num_ext_pF"],
                        'cp_patronal'               => $data["cp_pF"],
                        'estatus'                   => "Pendiente",
                        'reprecentante'             => "No"
                );

                $nombre_ine = $data["nombre_pF"]." ".$data["primero_PF"]." ".$data["segundo_Pf"]."-FISICA"."_IDENTIFICACION.pdf";
                $path = Storage::putFileAs(
                    'documentos_abogados', $request->file('documentoIne_pFSR'), $nombre_ine
                );
                if(!isset($data["documentoAnexo_pFSR"])){
                    $nombre_anexo = "Sin anexo";
                }
                else{
                    $nombre_anexo = $data["nombre_pF"]." ".$data["primero_PF"]." ".$data["segundo_Pf"]."-FISICA"."_ANEXO.pdf";
                    $path = Storage::putFileAs(
                        'documentos_abogados', $request->file('documentoAnexo_pFSR'), $nombre_anexo
                    );
                }
                $data_insertar["ineDocumento"] = $nombre_ine;
                $data_insertar["anexo_documeto"] = $nombre_anexo;
                
                if(isset($data["num_int_pF"])){
                   $data_insertar["num_int_pF"] = $data["num_int_pF"];
                }
                Poder::create($data_insertar);  
                $data = Poder::latest('idAbogado')->first();

                $mensaje = "Su registro fue guardado con éxito, tu número de folio es: ".$data["idAbogado"]. " 
                *La validación del registro patronal quedará sujeta a la certificación de la documentación que realice la persona conciliadora, lo anterior de conformidad con lo 
                establecido en el artículo 684-I, fracción I y II, de la Ley Federal del Trabajo; por lo que se le solicita acudir a su siguiente audiencia de conciliación con la 
                Documentación original en formato físico, a fin de realizar el cotejo correspondiente.";
                    
                    
                return redirect()->back()->with('success', $mensaje);
            }
            else if($data["representate"] == "Si"){
                $data_insertar = array(
                        'nombres_patronal'          => $data["nombre_pF"],
                        'primer_apellido_patronal'  => $data["primero_PF"],
                        'segundo_apellido_patronal' => $data["segundo_Pf"],
                        'curp_patronal'             => $data["curp_PF"],
                        'rfc_patronal'              => $data["RFC_pF"],
                        'sexo_patronal'             => $data["sexo_pf"],
                        'giroComercial'             => $data["giro_pF"],
                        'email_patronal'            => $data["correo_pF"],
                        'telefono_patronal'         => $data["telefono_PF"],
                        'estado_patronal'           => $data["estado_pF"],
                        'municipio_patronal'        => $data["municipio_pF"],
                        'tipo_vialidad_patronal'    => $data["vialidad_pF"],
                        'vialidad_patronal'         => $data["vialidad_calle_pF"],
                        'colonia_patronal'          => $data["colonia_pF"],
                        'num_ext_patronal'          => $data["num_ext_pF"],
                        'cp_patronal'               => $data["cp_pF"],
                        'nombre_representante'          => $data["nombre_representante_pF"],
                        'primer_apellido_representante' => $data["primer_representante_pF"],
                        'segundo_apellido_representante'=> $data["segundo_representante_pF"],
                        'curp_representante'            => $data["curp_representante_pF"],
                        'sexo_representante'            => $data["sexo_representante_pF"],
                        'correo_representante'          => $data["correo_representante_pF"],
                        'numero_representante'          => $data["telefono_representante_pF"],
                        'tipo_documento_representante'  => $data["tipo_documento_pF"],
                        'fechaRegistro'                 => $data["fecha_expedicion_pF"],
                        //'fechaVigencia'                 => $data["fecha_vigencia_pF"],
                        'descipcion_poder'              => $data["descripcion_pF"],
                        'representacionDocumento'       => $data['documentoRepresentacion_pF'],
                        'ineDocumento'                  => $data['documentoIne_pF'],
                        'documentoPoder_pF'             => $data["documentoPoder_pF"],
                        'tipo'                          => $data["tipoPersona"],
                        'estatus'                       => "Pendiente",
                        'reprecentante'                 => "Si"
                );

                $nombre_ine = $data["nombre_pF"]." ".$data["primero_PF"]." ".$data["segundo_Pf"]."-FISICA"."_IDENTIFICACION.pdf";
                $path = Storage::putFileAs(
                    'documentos_abogados', $request->file('documentoIne_pF'), $nombre_ine
                );
                $nombre_reprecentacion = $data["nombre_representante_pF"]." ".$data["primer_representante_pF"]." ".$data["segundo_representante_pF"]."-FISICA"."_REPRESENTACION.pdf";
                $path = Storage::putFileAs(
                    'documentos_abogados', $request->file('documentoRepresentacion_pF'), $nombre_reprecentacion
                );
                $nombre_poder = $data["nombre_pF"]." ".$data["primero_PF"]." ".$data["segundo_Pf"]."-FISICA"."_PODER.pdf";
                $path = Storage::putFileAs(
                    'documentos_abogados', $request->file('documentoPoder_pF'), $nombre_poder
                );
                if(!isset($data["documentoAnexo_pF"])){
                    $nombre_anexo = "Sin anexo";
                }
                else{
                    $nombre_anexo = $data["nombre_pF"]." ".$data["primero_PF"]." ".$data["segundo_Pf"]."-FISICA"."_ANEXO.pdf";
                    $path = Storage::putFileAs(
                        'documentos_abogados', $request->file('documentoAnexo_pF'), $nombre_anexo
                    );
                }

                $data_insertar["ineDocumento"] = $nombre_ine;
                $data_insertar["representacionDocumento"] = $nombre_reprecentacion;
                $data_insertar["cedulaDocumento"] = $nombre_poder;
                $data_insertar["anexo_documeto"] = $nombre_anexo;
                if(isset($data["num_int_pF"])){
                   $data_insertar["mun_int_patronal"] = $data["num_int_pF"];
                }
                if(isset($data["fecha_vigencia_pF"])){
                    $data_insertar["fechaVigencia"] = $data["fecha_vigencia_pF"];
                }
                
                Poder::create($data_insertar);  
                $data = Poder::latest('idAbogado')->first();

                $mensaje = "Su registro fue guardado con éxito, tu número de folio es: ".$data["idAbogado"]. " 
                *La validación del registro patronal quedará sujeta a la certificación de la documentación que realice la persona conciliadora, lo anterior de conformidad con lo 
                establecido en el artículo 684-I, fracción I y II, de la Ley Federal del Trabajo; por lo que se le solicita acudir a su siguiente audiencia de conciliación con la 
                Documentación original en formato físico, a fin de realizar el cotejo correspondiente.";
                        
                return redirect()->back()->with('success', $mensaje);
            }   
        }
        else if($data["tipoPersona"] == "Moral"){
            $data_insertar = array(
                    'nombres_patronal'          => $data["razon"],
                    'primer_apellido_patronal'  => "",
                    'segundo_apellido_patronal' => "",
                    'rfc_patronal'              => $data["rfc_moral"],
                    'giroComercial'             => $data["giro_moral"],
                    'estado_patronal'           => $data["estado_moral"],
                    'municipio_patronal'        => $data["municipio_moral"],
                    'tipo_vialidad_patronal'    => $data["vialidad_Moral"],
                    'vialidad_patronal'         => $data["vialidad_calleMoral"],
                    'colonia_patronal'          => $data["colonia_moral"],
                    'num_ext_patronal'          => $data["num_ext_moral"],
                    'cp_patronal'               => $data["cp_moral"],
                    'nombre_representante'          => $data["nombre_representante_Moral"],
                    'primer_apellido_representante' => $data["primer_Moral"],
                    'segundo_apellido_representante'=> $data["segundo_Moral"],
                    'curp_representante'            => $data["curp_moral"],
                    'sexo_representante'            => $data["sexo_Moral"],
                    'correo_representante'          => $data["correo_Moral"],
                    'numero_representante'          => $data["telefono_Moral"],
                    'tipo_documento_representante'  => $data["tipo_Moral"],
                    'fechaRegistro'                 => $data["fecha_expedicicion_Moral"],
                    //'fechaVigencia'                 => $data["fecha_vigencia_Moral"],
                    'descipcion_poder'              => $data["descripcion_Moral"],
                    'representacionDocumento'       => $data['documentoRepresentacion_Moral'],
                    'ineDocumento'                  => $data['documentoIne_Moral'],
                    'cedulaDocumento'               => $data["documentoPoder"],
                    'tipo'                          => $data["tipoPersona"],
                    'estatus'                       => "Pendiente",
                    'reprecentante'                 => "Si"
            );

            $nombre_ine = $data["razon"]."-MORAL"."_IDENTIFICACION.pdf";
            $path = Storage::putFileAs(
                'documentos_abogados', $request->file('documentoIne_Moral'), $nombre_ine
            );
            $nombre_reprecentacion = $data["razon"]."-MORAL"."_REPRESENTACION.pdf";
            $path = Storage::putFileAs(
                'documentos_abogados', $request->file('documentoRepresentacion_Moral'), $nombre_reprecentacion
            );
            $nombre_poder = $data["razon"]."-MORAL"."_PODER.pdf";
            $path = Storage::putFileAs(
                'documentos_abogados', $request->file('documentoPoder'), $nombre_poder
            );
            if(!isset($data["documentoAnexo"])){
                $nombre_anexo = "Sin anexo";
            }
            else{
                $nombre_anexo = $data["razon"]."-MORAL"."_ANEXO.pdf";
                $path = Storage::putFileAs(
                    'documentos_abogados', $request->file('documentoAnexo'), $nombre_anexo
                );
            }

            $data_insertar["ineDocumento"] = $nombre_ine;
            $data_insertar["representacionDocumento"] = $nombre_reprecentacion;
            $data_insertar["cedulaDocumento"] = $nombre_poder;
            $data_insertar["anexo_documeto"] = $nombre_anexo;
            if(isset($data["num_int"])){
                $data_insertar["mun_int_patronal"] = $data["num_int"];
            }
            if(isset($data["fecha_vigencia_Moral"])){
                $data_insertar["fechaVigencia"] = $data["fecha_vigencia_Moral"];
            }

            Poder::create($data_insertar);  
            $data = Poder::latest('idAbogado')->first();

            $mensaje = "Su registro fue guardado con éxito, tu número de folio es: ".$data["idAbogado"]. " 
            *La validación del registro patronal quedará sujeta a la certificación de la documentación que realice la persona conciliadora, lo anterior de conformidad con lo 
            establecido en el artículo 684-I, fracción I y II, de la Ley Federal del Trabajo; por lo que se le solicita acudir a su siguiente audiencia de conciliación con la 
            Documentación original en formato físico, a fin de realizar el cotejo correspondiente.";
                    
                    
            return redirect()->back()->with('success', $mensaje);
        }

        $nuevoAbogado = Poder::create($data_insertar);
          
         
        $A_citado=SeerCitados::find($data['id_citado_2'])->update(['id_abogado' => $nuevoAbogado->idAbogado]);
        return back()->with('success', 'Representante legal registrado y asignado correctamente al citado.');
    }

    public function editar_citados(Request $request){
        $data = $request->all();
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $folio = SeerCitados::find($data["id"]);
        
        if ($request->hasFile('foto1')) {
            $imagen_domicilio1 = $data["id"] . "-domicilio_Citado1.jpg";
            Storage::putFileAs('documentosSolicitud', $request->file('foto1'), $imagen_domicilio1);
            $foto1 = $imagen_domicilio1;
        } else {
            $foto1 = $folio->imagen_domicilio1;
        }
        
        if ($request->hasFile('foto2')) {
            $imagen_domicilio2 = $data["id"] . "-domicilio_Citado2.jpg";
            Storage::putFileAs('documentosSolicitud', $request->file('foto2'), $imagen_domicilio2);
            $foto2 = $imagen_domicilio2;
        } else {
            $foto2 = $folio->imagen_domicilio2;
        }
        $data_update = SeerCitados::find($data["id"])
        ->update([
            'tipo_persona'             => $data["tipo"],
            'curp'                     => $data["curp"],
            'rfc'                      => $data["rfc"],
            'nombre'                   => $data["nombre"],
            'primer_apellido'          => $data["primer_apellido"],
            'segundo_apellido'         => $data["segundo_apellido"],
            'colonia'                  => $data["colonia"],
            'cp'                       => $data["cp"],
            'calle1'                   => $data["calle1"],
            'calle2'                   => $data["calle2"],
            'n_ext'                    => $data["exterior"],
            'n_int'                    => $data["interior"],
            'tipo_vialidad'            => $data["vialidad"],
            'calle'                    => $data["calle"],
            'municipio_citado'         => $data["municipio_citado"],
            'referencia'               => $data["referencia"],
            'imagen_domicilio1'        => $foto1,
            'imagen_domicilio2'        => $foto2,
        ]);

       
        return redirect()->route('notificaciones');
    }

    public function seleccionar_abogado(Request $request){
        $data = $request->all();
        $id = $data["solicitud"];

        SeerCitados::find($data["citado"])
        ->update([
            'id_abogado'  => $data["abogado"],
        ]);

        return redirect()->route('inicioAudiencia',compact('id'));
        
    }

    public function mostrar_citadoC($id){
        $folio = SeerCitados::find($id);
        
        return view('/notificaciones/mostrar_citado',compact('folio'));
    }

    //PDF Acta por falta de interés
    public function VerPDFInteres($id){
        $solicitud = SeerPerGeneral::find($id);
        $solicitante = SeerSolicitante::where('id_solicitud',$solicitud["id"])->first();
       
        $conciliador  = User::join("seer_general","seer_general.conciliador_id","=","users.id");
        $conciliador = $conciliador->where("seer_general.id", "=", $id)
        ->select('users.name')
        ->first();
        $citados = SeerCitados::where("id_solicitud",$id)
        ->select('nombre','primer_apellido','segundo_apellido')
        ->get();
        $motivos = SeerMotivo::join('catalogo_motivos','catalogo_motivos.id','seer_motivos.id_motivo')
        ->where('id_solicitud',$id)
        ->select('catalogo_motivos.motivo')->get();
        $audiencia = SeerPerConciliador::where("id_solicitud",$solicitud["id"])->first();

        $html = view('PDF/Solicitudes/ActaFaltaInteres', compact('id', 'solicitud','conciliador','solicitante','citados','motivos','audiencia'))->render();

        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true); 

        $nombreArchivo = 'falta_de_interes_' . $solicitante->nombre .'.pdf';
        return $pdf->stream($nombreArchivo);  
    }

    public function incopentencia_audiencia(Request $request){
        $data = $request->all();
        $user = auth()->user();
        $fecha_actual = date('y-m-d');

        //Guardar registro en SeerConciliador
        $numero_audiencias = SeerPerConciliador::find($data["id"]);
        if(!isset($numero_audiencias)){
            $num_audi = 0;
        }
        else{
            $num_audi = $numero_audiencias->numero_audiencias;
        }
        $num_audi = $num_audi+1;

        $numero_audiencia = $this->GeneraAudiencia($data["id"]);
        $data_conciliador = [
            'id_solicitud'          => $data["id"],
            'numero_audiencia'      => $numero_audiencia[0],
            'numero_audiencias'     => $num_audi,
            'validado'              => 'Validado',
            'fecha_conclucion'      =>  $fecha_actual,
            'consecutivo'           =>  $numero_audiencia[1],
            'estatus_conciliacion'  => 'Incompetencia'
        ];
        
        SeerPerConciliador::create($data_conciliador);  

        $solicitud = SeerPerGeneral::find($data["id"])
        ->update([
            'fecha_terminacion'     => $fecha_actual, 
            'observaciones'         => $data["observaciones"], 
            'conciliador_id'        => $user->id,
            'estatus'               => 'Incompetencia'
        ]);

        return redirect()->route('todas_audiencias');
    }
    
    public function GeneraAudiencia($id){
        $año_actual = date('Y');
        $id_adiencia = SeerPerConciliador::select('consecutivo')->orderBy('consecutivo', 'desc')->first();
        
        if(!isset($id_adiencia)){
            $num_adiencia = 0;
        }
        else{
            $num_adiencia = $id_adiencia["consecutivo"];
        }

        $num_adiencia = $num_adiencia + 1;
        $numeroConCeros = str_pad($num_adiencia, 4, "0", STR_PAD_LEFT);
        $folio = $numeroConCeros."/".$año_actual;
    
        return array($folio,$num_adiencia);
    }

    public function reagendar_audiencia(Request $request){
        $data = $request->all();
        $user = auth()->user();
        $fecha_actual = date('y-m-d');

        //Guardar registro en SeerConciliador
        $numero_audiencias = SeerPerConciliador::find($data["id"]);
        if(!isset($numero_audiencias)){
            $num_audi = 0;
        }
        else{
            $num_audi = $numero_audiencias->numero_audiencias;
        }
        $num_audi = $num_audi+1;

        $numero_audiencia = $this->GeneraAudiencia($data["id"]);
        //Se va insertar un registro en audiencias 
        $data_conciliador = [
            'id_solicitud'          => $data["id"],
            'numero_audiencia'      => $numero_audiencia[0],
            'numero_audiencias'     => $num_audi,
            'validado'              => 'Validado',
            'fecha_conclucion'      =>  $fecha_actual,
            'consecutivo'           =>  $numero_audiencia[1],
            'estatus_conciliacion'  => 'Regenerada'
        ];        
        //SeerPerConciliador::create($data_conciliador);  
        //Obtener la audiencia mas reciente
        $audiencia = Audiencias::where('id_solicitud',$data["id"])->select('id')->orderBy('id', 'desc')->first();
        //Actualizar tabla de audiencias        
        Audiencias::find($audiencia["id"])->update([
            'fecha' => $data["fecha"],
            'hora'  => $data["hora"],
        ]);
        //Actualizar tabla general
        $solicitud = SeerPerGeneral::find($data["id"])
        ->update([
            'estatus'           => 'Confirmado',
            'conciliador_id'    => $user->id
        ]);
    
        return redirect()->route('todas_audiencias');
    }

    //PDF Acta por falta de interés
    public function VerPDFIncompetencia($id){
        $solicitud = SeerPerGeneral::find($id);
        $solicitante = SeerSolicitante::where('id_solicitud',$solicitud["id"])->first();
        $conciliador  = User::join("seer_general","seer_general.conciliador_id","=","users.id");
        $conciliador = $conciliador->where("seer_general.id", "=", $id)
        ->select('users.name')
        ->first();
        $citados = SeerCitados::where("id_solicitud",$id)
        ->select('nombre','primer_apellido','segundo_apellido')
        ->get();
        $motivos = SeerMotivo::join('catalogo_motivos','catalogo_motivos.id','seer_motivos.id_motivo')
        ->where('id_solicitud',$id)
        ->select('catalogo_motivos.motivo')->get();
        $audiencia = SeerPerConciliador::where("id_solicitud",$solicitud["id"])->first();

        $html = view('PDF/Solicitudes/incompetencia', compact('id', 'solicitud','conciliador','solicitante','citados','motivos','audiencia'))->render();

        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true); 

        $nombreArchivo = 'falta_de_interes_' . $solicitud->trabajador .'.pdf';
        return $pdf->stream($nombreArchivo);  
    }


    public function audiencia_parte2(Request $request){
        $data = $request->all();
        $id = $data["id"];
        //Revisar si los citattorios son por el centro o por le trabajador
        $citados = SeerCitados::where('id_solicitud',$data["id"])->select('notificacion')->orderBy('id', 'desc')->first();
        $user = auth()->user();

        //Si la bandera es 0 selecciono a todos los representantes puede avanzar
        if($data["bandera"] == 0){
            return redirect()->route('audiencias.parte3',compact('id'));
        }
        //Si la bandera es 1 le fanto un representante por lo tanto va a generar nueva audiencia o va multar
        else{
            if($citados->notificacion == "Trabajador"){
                //Voy a insertar nuevos citadorios pero como multa
                $citado_notificacion = SeerCitados::where("id_solicitud",$data["id"])->get();
                $cont = count($citado_notificacion);
                for($i = 0; $i < $cont; $i++) {
                    $citado_copiar = SeerCitados::find($citado_notificacion[$i]["id"]);
                    $nuevo_citado = $citado_copiar->replicate();
                    $nuevo_citado->notificacion = 'Centro';
                    $nuevo_citado->save();
                }
                
            }
            else if($citados->notificacion == "Centro"){
                //Si va por el centro se van a generar las multas a los que no tiene reprecentante legal
                $total_citados = SeerCitados::where("id_solicitud",$data["id"])
                ->where('notificacion',"Centro")
                ->get();
                $citados = SeerCitados::where("id_solicitud",$data["id"])
                ->where('notificacion',"Centro")
                ->whereNull("id_abogado")
                ->get();
                $cont = count($citados);
                $cont_total = count($total_citados);
                
                for($i = 0; $i < $cont; $i++) {
                    $update = SeerCitados::find($citados[$i]["id"])->update([
                        'tipo_notificacion' => 'Multa',
                        'conciliador_id'    => $user->id
                    ]);
                }
                if($cont == $cont_total){
                    $update = SeerPerGeneral::find($id)->update(['estatus' => 'No conciliacion']);
                }
                else{
                    return redirect()->route('audiencias.parte3',compact('id'));
                }                
            }
            return redirect()->route('audiencias.conciliador');
        }
         
    }

    public function mis_solicitudes(){
        $id = auth()->user()->id;
        $user = User::find($id);

        $solicitudes = SeerPerGeneral::join('seer_solicitante','seer_solicitante.id_solicitud','=','seer_general.id')
        ->join('users','seer_solicitante.curp','=','users.profile_photo_path')
        ->where('seer_solicitante.curp',$user["profile_photo_path"])
        ->select('seer_general.id','seer_general.fecha','seer_solicitante.nombre','seer_general.estatus')
        ->get();
        
        return view('/solicitudes/missolicitudes',compact('solicitudes'));
    }

    public function mostrar_citados($id){
        $municipios = Municipios::all();
        $folio = SeerCitados::find($id);
        return view('/notificaciones/ver_citado',compact('folio','municipios'));
    }

    public function audienciaParte3($id){

        $sede = Auth::user()->delegacion;

        return view('/audiencias/parte3',compact('id', 'sede'));
    }

    public function historial_notificador(Request $request){
        $data = $request->all();
        $id = auth()->user()->id;
        $user = User::find($id);

        $notificaciones = SeerPerGeneral::join('seer_citados','seer_citados.id_solicitud','=','seer_general.id')
        ->join('seer_solicitante','seer_solicitante.id_solicitud','=','seer_general.id')
        ->select('seer_general.id as id_solicitud','seer_citados.id as id_citado','seer_general.NUE',
            'seer_citados.nombre','seer_citados.primer_apellido','seer_citados.segundo_apellido',
            'seer_citados.colonia','seer_citados.calle','seer_citados.n_ext','seer_citados.n_int','seer_citados.estatus'
            ,'seer_citados.fecha','seer_solicitante.nombre as nombre_solicitante')
        ->where('seer_citados.id_notificador', $id)
        ->where("seer_citados.fecha",">=",$data["fecha_inicio"])
        ->where("seer_citados.fecha",">=",$data["fecha_final"])
        ->get();
                
        return view('/historial/notificaciones',compact('notificaciones'));
    }

    public function historial_auxiliar(Request $request){
        $data = $request->all();
        $id = auth()->user()->id;
        $user = User::find($id);

        $notificaciones = SeerPerGeneral::join('seer_citados','seer_citados.id_solicitud','=','seer_general.id')
        ->join('seer_solicitante','seer_solicitante.id_solicitud','=','seer_general.id')
        ->select('seer_general.id as id_solicitud','seer_citados.id as id_citado','seer_general.NUE',
            'seer_citados.nombre','seer_citados.primer_apellido','seer_citados.segundo_apellido',
            'seer_citados.colonia','seer_citados.calle','seer_citados.n_ext','seer_citados.n_int','seer_citados.estatus'
            ,'seer_citados.fecha','seer_solicitante.nombre as nombre_solicitante')
        ->where('seer_citados.id_notificador', $id)
        ->where("seer_citados.fecha",">=",$data["fecha_inicio"])
        ->where("seer_citados.fecha",">=",$data["fecha_final"])
        ->get();
                
        return view('/historial/auxiliares',compact('notificaciones'));
    }
    
    public function solicitudes_todas(){
        $solicitudes = SeerPerGeneral::join('catalogo_rama','catalogo_rama.id','seer_general.id_rama')
        ->join('seer_solicitante','seer_solicitante.id_solicitud','seer_general.id')
        ->select('seer_general.id','seer_general.fecha','seer_solicitante.nombre','seer_general.delegacion','seer_general.actividad',
        'catalogo_rama.rama_industrial','seer_general.tipo_solicitud')
        //->where('seer_general.estatus','Pendiente')
        ->orderBy('seer_general.fecha')
        ->get();

        return view('solicitudes.solicitudes', compact('solicitudes'));
    }
    
    public function ObtenerAudiencia($delegacion){
        $fecha_actual = date('y-m-d');
        $hora_actual  = date("H:i:s");
        $array_final = array();
        $array_horarios = array();
        $relacionEloquent = 'roles';
        $listado_auxiliares = array();
        $id = auth()->user()->id;
        $user = User::find($id);
        $bandera = 0;


        //Vamos a contar cuandos auxiliares existen en el CCL
        $conciliadores = User::whereHas($relacionEloquent, function ($query) {
            return $query->where('name', '=', 'Conciliador');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();

        //Numero de conciliadores
        $contador_conciliadores = count($conciliadores);
        //Obtener la ultima fecha y hora
        $fecha_reciente = Audiencias::where('delegacion',$delegacion)->select('fecha','hora')->orderBy('fecha', 'desc')->first();
        $fecha_revisar = date('Y-m-d', strtotime($fecha_reciente["fecha"]));
        $fecha_revisar = strtotime($fecha_revisar." +7 day");
        $fecha_hora = date('H:i:s', strtotime($fecha_reciente["hora"]));
        //Validar cuantas audiencias hay en ese horario y eas hora
        $conteo = Audiencias::where('delegacion',$delegacion)
        ->where("fecha",$fecha_revisar)
        ->where("hora",$fecha_hora)
        ->selectRaw('count(id) as total')->first();
        //Validar si hay espacio a esa hora
        do {   
            $tomorrow = strtotime($fecha_revisar." +1 day");
            $fecha_dia = date('l', $tomorrow);
            $fecha_tomorrow = date('Y-m-d', $tomorrow);

            if ($fecha_dia == 'Saturday') {
                $fechasuma = strtotime($fecha_revisar." +3 day");
                $fecha_revisar = date('Y-m-d', $fechasuma);
                $fecha_hora = "09:00:00";
            }
            else{
                switch($fecha_hora){
                    case ($fecha_hora == "09:00:00") :
                        foreach($conciliadores as $token ){
                            $revisar = Audiencias::where('delegacion',$delegacion)
                            ->where('fecha',$fecha_revisar)
                            ->where('hora' ,$fecha_hora)
                            ->where('id_conciliador' ,$token["id"])
                            ->select('id_conciliador')->first();

                            $revisar_centro = DiasInhabiles::
                            where('fecha_inicio', $fecha_revisar)
                            ->where('centro',$user["delegacion"])
                            ->first();

                            $revisar_disponible = DiasInhabiles::
                            where('fecha_inicio', $fecha_revisar)
                            ->where('horario_inicio',"<=",$fecha_hora)
                            ->where('horario_final',">=",$fecha_hora)
                            ->where('user_id',$token["id"])
                            ->first();

                            //Si no tiene audiencia  ni dias inahibles o centro lo voy agregar
                            if(empty($revisar) && empty($revisar_disponible) && empty($revisar_centro)){
                                array_push($listado_auxiliares, $token["id"]);
                                $bandera = 1;
                            }
                        }
                        if($bandera == 1){
                            $random = array_rand($listado_auxiliares);
                            $array_horarios[0] = $fecha_revisar;
                            $array_horarios[1] = $fecha_hora;
                            $array_horarios[3] = $listado_auxiliares[$random];
                            return $array_horarios;
                        }
                        else{
                            $fecha_hora = "10:15:00";
                        }
                    case ($fecha_hora == "10:15:00"):
                        foreach($conciliadores as $token ){
                            $revisar = Audiencias::where('delegacion',$delegacion)
                            ->where('fecha',$fecha_revisar)
                            ->where('hora' ,$fecha_hora)
                            ->where('id_conciliador' ,$token["id"])
                            ->select('id_conciliador')->first();
                            
                            $revisar_centro = DiasInhabiles::
                            where('fecha_inicio', $fecha_revisar)
                            ->where('centro',$user["delegacion"])
                            ->first();

                            $revisar_disponible = DiasInhabiles::
                            where('fecha_inicio', $fecha_revisar)
                            ->where('horario_inicio',"<=",$fecha_hora)
                            ->where('horario_final',">=",$fecha_hora)
                            ->where('user_id',$token["id"])
                            ->first();
                                
                            //Si no tiene audiencia lo voy agregar
                            if(empty($revisar) && empty($revisar_disponible) && empty($revisar_centro)){
                                array_push($listado_auxiliares, $token["id"]);
                                $bandera = 1;
                            }
                        }
                        if($bandera == 1){
                            $random = array_rand($listado_auxiliares);
                            $array_horarios[0] = $fecha_revisar;
                            $array_horarios[1] = $fecha_hora;
                            $array_horarios[3] = $listado_auxiliares[$random];
                            return $array_horarios;
                        }
                        else{
                            $fecha_hora = "11:30:00";
                        }
                    case ($fecha_hora == "11:30:00"):
                        foreach($conciliadores as $token ){
                            $revisar = Audiencias::where('delegacion',$delegacion)
                            ->where('fecha',$fecha_revisar)
                            ->where('hora' ,$fecha_hora)
                            ->where('id_conciliador' ,$token["id"])
                            ->select('id_conciliador')->first();
                            
                            $revisar_centro = DiasInhabiles::
                            where('fecha_inicio', $fecha_revisar)
                            ->where('centro',$user["delegacion"])
                            ->first();

                            $revisar_disponible = DiasInhabiles::
                            where('fecha_inicio', $fecha_revisar)
                            ->where('horario_inicio',"<=",$fecha_hora)
                            ->where('horario_final',">=",$fecha_hora)
                            ->where('user_id',$token["id"])
                            ->first();
                                
                            //Si no tiene audiencia lo voy agregar
                            if(empty($revisar) && empty($revisar_disponible) && empty($revisar_centro)){
                                array_push($listado_auxiliares, $token["id"]);
                                $bandera = 1;
                            }
                        }
                        if($bandera == 1){
                            $random = array_rand($listado_auxiliares);
                            $array_horarios[0] = $fecha_revisar;
                            $array_horarios[1] = $fecha_hora;
                            $array_horarios[3] = $listado_auxiliares[$random];
                            return $array_horarios;
                        }
                        else{
                            $fecha_hora = "12:45:00";
                        }
                    case ($fecha_hora == "12:45:00"):
                        foreach($conciliadores as $token ){
                            $revisar = Audiencias::where('delegacion',$delegacion)
                            ->where('fecha',$fecha_revisar)
                            ->where('hora' ,$fecha_hora)
                            ->where('id_conciliador' ,$token["id"])
                            ->select('id_conciliador')->first();
                            
                            $revisar_centro = DiasInhabiles::
                            where('fecha_inicio', $fecha_revisar)
                            ->where('centro',$user["delegacion"])
                            ->first();

                            $revisar_disponible = DiasInhabiles::
                            where('fecha_inicio', $fecha_revisar)
                            ->where('horario_inicio',"<=",$fecha_hora)
                            ->where('horario_final',">=",$fecha_hora)
                            ->where('user_id',$token["id"])
                            ->first();
                                
                            //Si no tiene audiencia lo voy agregar
                            if(empty($revisar) && empty($revisar_disponible) && empty($revisar_centro)){
                                array_push($listado_auxiliares, $token["id"]);
                                $bandera = 1;
                            }
                        }
                        if($bandera == 1){
                            $random = array_rand($listado_auxiliares);
                            $array_horarios[0] = $fecha_revisar;
                            $array_horarios[1] = $fecha_hora;
                            $array_horarios[3] = $listado_auxiliares[$random];
                            return $array_horarios;
                        }
                        else{
                            $fecha_hora = "14:00:00";
                        }
                    case ($fecha_hora == "14:00:00"):
                        foreach($conciliadores as $token ){
                            $revisar = Audiencias::where('delegacion',$delegacion)
                            ->where('fecha',$fecha_revisar)
                            ->where('hora' ,$fecha_hora)
                            ->where('id_conciliador' ,$token["id"])
                            ->select('id_conciliador')->first();
                            
                            $revisar_centro = DiasInhabiles::
                            where('fecha_inicio', $fecha_revisar)
                            ->where('centro',$user["delegacion"])
                            ->first();

                            $revisar_disponible = DiasInhabiles::
                            where('fecha_inicio', $fecha_revisar)
                            ->where('horario_inicio',"<=",$fecha_hora)
                            ->where('horario_final',">=",$fecha_hora)
                            ->where('user_id',$token["id"])
                            ->first();
                                
                            //Si no tiene audiencia lo voy agregar
                            if(empty($revisar) && empty($revisar_disponible) && empty($revisar_centro)){
                                array_push($listado_auxiliares, $token["id"]);
                                $bandera = 1;
                            }
                        }
                        if($bandera == 1){
                            $random = array_rand($listado_auxiliares);
                            $array_horarios[0] = $fecha_revisar;
                            $array_horarios[1] = $fecha_hora;
                            $array_horarios[3] = $listado_auxiliares[$random];
                            return $array_horarios;
                        }
                        else{
                            $fecha_hora = "15:15:00";
                        }
                    case ($fecha_hora == "15:15:00"):
                        foreach($conciliadores as $token ){
                            $revisar = Audiencias::where('delegacion',$delegacion)
                            ->where('fecha',$fecha_revisar)
                            ->where('hora' ,$fecha_hora)
                            ->where('id_conciliador' ,$token["id"])
                            ->select('id_conciliador')->first();
                            
                            $revisar_centro = DiasInhabiles::
                            where('fecha_inicio', $fecha_revisar)
                            ->where('centro',$user["delegacion"])
                            ->first();

                            $revisar_disponible = DiasInhabiles::
                            where('fecha_inicio', $fecha_revisar)
                            ->where('horario_inicio',"<=",$fecha_hora)
                            ->where('horario_final',">=",$fecha_hora)
                            ->where('user_id',$token["id"])
                            ->first();
                            
                            //Si no tiene audiencia lo voy agregar
                            if(empty($revisar) && empty($revisar_disponible) && empty($revisar_centro)){
                                array_push($listado_auxiliares, $token["id"]);
                                $bandera = 1;
                            }
                        }
                        if($bandera == 1){
                            $random = array_rand($listado_auxiliares);
                            $array_horarios[0] = $fecha_revisar;
                            $array_horarios[1] = $fecha_hora;
                            $array_horarios[3] = $listado_auxiliares[$random];
                            return $array_horarios;
                        }
                        else{
                            $fecha_hora = "18:00:00";
                        }
                    case ($fecha_hora == "18:00:00"):
                        $fecha_revisar = $fecha_tomorrow;
                        $fecha_hora = "09:00:00";
                }
            }
        }while ($bandera != 1);
    }

    public function concluir_audiencia_conciliador(Request $request){
        $data = $request->all();
        $id_solicitud = $data["id"];
        $monto = 0;
        $fecha_actual = date('y-m-d');
        $id = auth()->user()->id;
        $user = User::find($id);

        if($data["conclucion"] == "Conciliacion"){
            //Revisar si existe
            if(isset($data["dias_pagos"])){
                $conteo = count($data["dias_pagos"]);
                for($i = 0; $i < $conteo; $i++) {
                    $data_pagos = [
                        'id_solicitud'  => $data["id"],
                        'fecha'         => $data["dias_pagos"][$i],
                        'hora'          => $data["hora_pagos"][$i], 
                        'monto'         => $data["monto_pagos"][$i], 
                        'descripcion'   => $data["descripcion_pagos"][$i],
                        'estatus'       => "Pendiente", 
                        'tipo_pago'     => "Audiencia"
                    ];
                    $monto = $monto + $data["monto_pagos"][$i];
                    Pagos::create($data_pagos);
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
                        'tipo_pago'     => "Audiencia"
                    ];
                    Concepto::create($data_citado);
                }
            }
            //Regresar error
            else{
                return back()->withErrors('Debes agregar por lo menos un concepto de pago.');
            }

            if(isset($data["descripcion_deduccion"])){
            $cont = count($data["descripcion_deduccion"]);
            for($i = 0; $i < $cont; $i++) {
                $data_deduccion = [
                    'id_solicitud'  => $data["id"], 
                    'monto'         => $data["monto_deduccion"][$i], 
                    'descripcion'   => $data["descripcion_deduccion"][$i],
                    'tipo_pago'     => "Audiencia"
                ];
                Deducciones::create($data_deduccion);
            }
        }
            if($conteo >= 2){
                $estatus = "Concluida Pagos";
            }
            else{
                $estatus = "Conluida";
            }
            
            $solicitante = SeerSolicitante::where('id_solicitud',$data["id"])->first();
            $numero_audiencia = $this->GeneraAudiencia($data["id"]);
            //Actualizar Audiecia
            $data_conciliador = [
                'id_solicitud'          => $data["id"],
                'numero_audiencia'      => $numero_audiencia["0"],
                'numero_audiencias'     => $numero_audiencia["1"],
                'estatus_conciliacion'  => $data["conclucion"],
                'monto'                 => $monto,
                'rfc'                   => $solicitante["rfc"],
                'NSS'                   => $solicitante["nss"],
                'multa'                 => 'No',
                'tipo'                  => $data["tipo_audiencia"],
                'validado'              => 'Validado',
                'consecutivo'           =>  $numero_audiencia[1],
                'resolicion_primera'    =>  $data["primera"],
                'resolicion_justificacion'=>  $data["justificacion"],
                'resolicion_segunda'    =>  $data["segunda"],
                'conclucion'            =>  $data["conclucion"],
                'vacaciones'            =>  $data["vacaciones"],
                'aguinaldo'             =>  $data["aguinaldo"],
                'otros'                 =>  $data["otros"],
                'horario'               =>  $data["horario"],
                'comida'                =>  $data["comida"],
                'tipo_audiencia'        =>  $data["tipo_audiencia"],
            ];
            SeerPerConciliador::create($data_conciliador);

            SeerPerGeneral::find($data["id"])
            ->update([
                'tipo'                  => $data["tipo_audiencia"],
                'fecha_terminacion'     => $fecha_actual, 
                'conciliador_id'        => $user->id,
                'estatus'               => $data["conclucion"]
            ]);
        }
        else{
            $solicitante = SeerSolicitante::where('id_solicitud',$data["id"])->first();
            $numero_audiencia = $this->GeneraAudiencia($data["id"]);
            //Actualizar Audiecia
            $data_conciliador = [
                'id_solicitud'          => $data["id"],
                'numero_audiencia'      => $numero_audiencia["0"],
                'numero_audiencias'     => $numero_audiencia["1"],
                'estatus_conciliacion'  => $data["conclucion"],
                'monto'                 => 0,
                'rfc'                   => $solicitante["rfc"],
                'NSS'                   => $solicitante["nss"],
                'multa'                 => 'No',
                'tipo'                  => "Presencial",
                'validado'              => 'Validado',
                'consecutivo'           =>  $numero_audiencia[1],
                'resolicion_primera'    => $data["primera"],
                'resolicion_justificacion'  => $data["justificacion"],
                'resolicion_segunda'    => $data["segunda"],
                'conclucion'            => $data["conclucion"],
                /*
                'vacaciones'            => $data[""],
                'aguinaldo'             => $data[""],
                'otros'                 => $data[""],
                'horario'               => $data[""],
                'comida'                => $data[""],
                'tipo_audiencia'        => $data[""]
                */
            ];
            SeerPerConciliador::create($data_conciliador);

            SeerPerGeneral::find($data["id"])
            ->update([
                'tipo'                  => "Presencial",
                'fecha_terminacion'     => $fecha_actual, 
                'conciliador_id'        => $user->id,
                'estatus'               => $data["conclucion"]
            ]);

            return redirect()->route('audiencia_index');
        }

        if($data["valor"] == 1){
            //session()->flash('show_modal', true);
            return redirect()->route('vista_previa',compact('id_solicitud'));
        }
        if($data["valor"] == 2){
            return redirect()->route('audiencias.conciliador');
        }
    }
    
    // PDF Convenio para solicitudes
    public function VerPDFConvenioSol($id){
        $solicitud = SeerPerGeneral::find($id); 
        $pagos = Pagos::where('id_solicitud', $id)->get();
        //$prestacionesLab = Concepto::where('id_solicitud', $id)->first();
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
        
       // $dias_descanso = $solicitud->dias !== null ? 7 - $solicitud->dias : null;
        $salario_diario = $this->calcularSalarioDiario($solicitud->salario, $solicitud->frecuencia);
        $salario_mensual = $salario_diario * 30;
        $diarioTexto = $this->convertirNumerosALetras($salario_diario);
        $mensualTexto = $this->convertirNumerosALetras($salario_mensual);
        $montoTexto = $this->convertirNumerosALetras($solicitud->monto);
        
        $pagosDif  = Pagos::join("turnos","turnos.id","=","pago_solicitud.id_solicitud");
        $pagosDif = $pagosDif->where("pago_solicitud.id_solicitud", "=", $id)
        ->select(DB::raw('count(pago_solicitud.id_solicitud) as C_pagos'))
        ->first();

        $conciliador = User::join("seer_general", "seer_general.conciliador_id", "=", "users.id")
        ->where("seer_general.id", "=", $id)
        ->select("users.name")
        ->first();

        $solicitante  = SeerPerGeneral::join("seer_solicitante","seer_solicitante.id_solicitud","=","seer_general.id");
        $solicitante = $solicitante->where("seer_solicitante.id_solicitud", "=", $solicitud["id"])
        ->first();

        $citados = SeerCitados::where('id_solicitud', $id)->get();

        $audiencia  = SeerPerGeneral::join("audiencias","audiencias.id_solicitud","=","seer_general.id");
        $audiencia = $audiencia->where("audiencias.id_solicitud", "=", $solicitud["id"])
        ->first();

        $html = view('PDF/Solicitudes/convenioSolicitud', 
        compact('id', 'solicitud', /*'dias_descanso',*/ 'salario_diario','salario_mensual','pagos','diarioTexto','mensualTexto','montoTexto','vacacionesTexto',
        'primaTexto','aguinaldoTexto','DSueldoTexto','antiguedadTexto','gratificacionATexto','gratificacionBTexto','gratificacionCTexto','gratificacionDTexto',
        'gratificacionETexto','gratificacionFTexto','otrasTexto','pagosDif','conciliador','prestaciones','solicitante','citados','audiencia'))
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

    //PDF Acuse de solicitud
    public function PDFacuseSolicitud($id){
        $solicitud = SeerPerGeneral::find($id);
        $solicitante  = SeerPerGeneral::join("seer_solicitante","seer_solicitante.id_solicitud","=","seer_general.id");
        $solicitante = $solicitante->where("seer_solicitante.id_solicitud", "=", $solicitud["id"])
        ->first();

        $citados = SeerCitados::where('id_solicitud', $id)->get();
       
        $pdf = \PDF::loadView('PDF/Solicitudes/acuseSolicitud', compact('id','solicitud','solicitante','citados'))
        ->setPaper('a4', 'portrait')
        ->setOption('isHtml5ParserEnabled', true)
        ->setOption('isPhpEnabled', true);

        $nombreArchivo = 'acuse_solicitud_' . $solicitud->empresa .'.pdf';
        return $pdf->stream($nombreArchivo);               
    }

    //PDF Notificación de solicitud
    public function PDFnotificacionSolicitante($id){
        $solicitud = SeerPerGeneral::find($id);
        $solicitante  = SeerPerGeneral::join("seer_solicitante","seer_solicitante.id_solicitud","=","seer_general.id");
        $solicitante = $solicitante->where("seer_solicitante.id_solicitud", "=", $solicitud["id"])
        ->first();

        $conciliador  = User::join("seer_general","seer_general.conciliador_id","=","users.id");
        $conciliador = $conciliador->where("seer_general.conciliador_id", "=", $solicitud["conciliador_id"])
        ->select('users.name')
        ->first();

        $citados = SeerCitados::where('id_solicitud', $id)->get();
       
        $audiencia  = SeerPerGeneral::join("audiencias","audiencias.id_solicitud","=","seer_general.id");
        $audiencia = $audiencia->where("audiencias.id_solicitud", "=", $solicitud["id"])
        ->first();
        $pdf = \PDF::loadView('PDF/Solicitudes/notificacionSolicitante', compact('id','solicitud','solicitante','citados','conciliador','audiencia'))
        ->setPaper('a4', 'portrait')
        ->setOption('isHtml5ParserEnabled', true)
        ->setOption('isPhpEnabled', true);

        $nombreArchivo = 'notificación_solicitante_' . $solicitud->empresa .'.pdf';
        return $pdf->stream($nombreArchivo);               
    }
    
    //PDF Multa de solicitud
    public function VerPDFMulta($id, $id_solicitud){
        $solicitud = SeerPerGeneral::find($id_solicitud);
        //$solicitud = SeerPerGeneral::find($id);
        $conciliador = User::join("seer_general", "seer_general.conciliador_id", "=", "users.id")
        ->where("seer_general.id", "=", $id_solicitud)
        ->select("users.name")
        ->first();
        $citado = SeerCitados::find($id);
        $audiencia = Audiencias::where('id_solicitud', $id_solicitud)
        ->orderBy('fecha', 'desc')
        ->first();
        $pdf = \PDF::loadView('PDF/Solicitudes/ActaMulta', compact('id','solicitud','citado','conciliador','audiencia'))
        ->setPaper('a4', 'portrait')
        ->setOption('isHtml5ParserEnabled', true)
        ->setOption('isPhpEnabled', true);

        $nombreArchivo = 'multa_' . $solicitud->empresa .'.pdf';
        return $pdf->stream($nombreArchivo);                  
    }

    //PDF Citatorio
    public function pdfCitatorio($id) {
        try {
            $solicitud      = SeerPerGeneral::findOrFail($id);
            $solicitantes   = SeerSolicitante::where('id_solicitud', $id)->get();
            $citados        = SeerCitados::where('id_solicitud', $id)->get();
            $motivoIds      = SeerMotivo::where('id_solicitud', $id)->pluck('id_motivo');
            $motivos        = SolicitudMotivo::whereIn('id', $motivoIds)->get();
            $audiencia      = SeerPerGeneral::join("audiencias","audiencias.id_solicitud","=","seer_general.id")
                ->where("audiencias.id_solicitud", "=", $id)
                ->first();

            $conciliador  = User::join("seer_general","seer_general.conciliador_id","=","users.id");
            $conciliador = $conciliador->where("seer_general.conciliador_id", "=", $solicitud["conciliador_id"])
                ->select('users.name')
                ->first();

            $pdfs = [];
    
            foreach ($solicitantes as $solicitante) {
                foreach ($citados as $citado) {
                    $nombreArchivo = 'citatorio_' . $citado->nombre . '_' . $citado->primer_apellido . '.pdf';
    
                    // Genera el PDF en memoria
                    $pdf = \PDF::loadView('PDF/Solicitudes/citatorio', compact('solicitud','solicitante','citado','motivos','audiencia','conciliador'))
                        ->setPaper('a4', 'portrait')
                        ->setOption('isHtml5ParserEnabled', true)
                        ->setOption('isPhpEnabled', true);
    
                    // Codifica el PDF en base64 para enviarlo
                    $pdfBase64 = base64_encode($pdf->output());
    
                    $pdfs[] = [
                        'nombre' => $nombreArchivo,
                        'base64' => $pdfBase64,
                    ];
                }
            }
    
            return response()->json($pdfs);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    //Consultar solicitudes(Solicitante) conciliadores
    public function consultar_solicitudes($id){
        $solicitudes = SeerPerGeneral::find($id);
        $solicitud  = SeerPerGeneral::join("seer_solicitante","seer_solicitante.id_solicitud","=","seer_general.id");
        $solicitud = $solicitud->where("seer_solicitante.id_solicitud", "=", $id) ->first();
        
        //Validar si existe el abogado
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        return view('/solicitudes/verSolicitud',compact('solicitud','userRole'));
    }

    public function audiencia_fecha(){
        $id = auth()->user()->id;
        $user = User::find($id);

        $auxiliares = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Auxiliar');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();
        $notificadores = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Notificador');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();
        $conciliadores = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Conciliador');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();

        return view('audiencias/busqueda',compact('auxiliares','conciliadores'));
    }

    //Conciliadores en solicitudes audiencias
    public function historial_conciliador(Request $request){
        $data = $request->all();
        $bandera_fechas         = 0;
        $bandera_nue            = 0;
        $bandera_curp           = 0;
        $bandera_solicitante    = 0;
        $bandera_citado         = 0;
        $bandera_folio          = 0;
        $bandera_año            = 0;
        $bandera_estatus        = 0;
        $bandera_tipo           = 0;
        $bandera_auxiliar       = 0;
        $bandera_conciliador    = 0;

        //Si existe la fecha de inicio
        if(isset($data["inicio"]) ){
            if(isset($data["final"]) ){
                if($data["inicio"] > $data["final"]){
                    return back()->withErrors('Si seleccionas una fecha de inicio, no debe ser mayor a la fecha final.');
                }
                //Agregar fecha inicio y final
                $bandera_fechas = 1;
            }
            else{
                return back()->withErrors('Si selecciones una fecha de inicio, debes seleccionar fecha final.');
            }
        }else if(isset($data["final"])){
            if(isset($data["inicio"]) ){
                if($data["inicio"] > $data["final"]){
                    return back()->withErrors('Si seleccionas una fecha de inicio, no debe ser mayor a la fecha final.');
                }
                //Agregar fecha inicio y final
                $bandera_fechas = 1;
            }
            else{
                return back()->withErrors('Si selecciones una fecha final, debes seleccionar fecha de inicio.');
            }
        }
        else if(isset($data["nue"])){
            //se va agregar el nue a la busqueda
            $bandera_nue = 1;
        }
        else if(isset($data["curp"])){
            //se va agregar el nue a la busqueda
            $bandera_curp = 1;
        }
        else if(isset($data["solicitante"])){
            //se va agregar el nue a la busqueda
            $bandera_solicitante = 1;
        }
        else if(isset($data["citado"])){
            //se va agregar el nue a la busqueda
            $bandera_citado = 1;
        }
        else if(isset($data["folio"])){
            //se va agregar el nue a la busqueda
            $bandera_folio = 1;
        }
        else if(isset($data["estatus"])){
            //se va agregar el nue a la busqueda
            $bandera_estatus = 1;
        }
        else if(isset($data["tipo"])){
            //se va agregar el nue a la busqueda
            $bandera_tipo = 1;
        }
        else if(isset($data["auxiliar"])){
            //se va agregar el nue a la busqueda
            $bandera_auxiliar = 1;
        }
        else if(isset($data["conciliador"])){
            //se va agregar el nue a la busqueda
            $bandera_conciliador = 1;
        }

        $solicitudes  = SeerPerGeneral::select("seer_general.id","seer_general.fecha","seer_general.fecha","seer_general.NUE","seer_general.tipo_solicitud","seer_general.estatus","seer_general.actividad","seer_solicitante.nombre");
        $solicitudes = $solicitudes->join("seer_solicitante","seer_solicitante.id_solicitud","seer_general.id");
        if($bandera_fechas == 1){
            $solicitudes = $solicitudes->where("seer_general.fecha",">=",$data["inicio"]);
            $solicitudes = $solicitudes->where("seer_general.fecha","<=",$data["final"]);
        }
        if($bandera_nue == 1){
            $solicitudes = $solicitudes->where("seer_general.NUE",$data["nue"]);
        }
        if($bandera_curp == 1){
            $solicitudes = $solicitudes->where("seer_solicitante.curp",$data["curp"]);
        }
        if($bandera_solicitante == 1){
            $solicitudes = $solicitudes->where("seer_solicitante.nombre",'like',$data["solicitante"]);
        }
        if($bandera_citado == 1){
            $solicitudes = $solicitudes->join("seer_citados","seer_citados.id_solicitud","seer_general.id");
            $solicitudes = $solicitudes->where("seer_citados.nombre",'like',$data["citado"]);
        }
        if($bandera_folio == 1){
            $solicitudes = $solicitudes->where("seer_general.id","=",$data["folio"]);
        }
        if($bandera_estatus == 1){
            $solicitudes = $solicitudes->where("seer_general.estatus","=",$data["estatus"]);
        }
        if($bandera_tipo == 1){
            $solicitudes = $solicitudes->where("seer_general.tipo_solicitud","=",$data["tipo"]);
        }
        if($bandera_auxiliar == 1){
            $solicitudes = $solicitudes->where("seer_general.user_id","=",$data["auxiliar"]);
        }
        if($bandera_conciliador == 1){
            $solicitudes = $solicitudes->where("seer_general.conciliador_id","=",$data["conciliador"]);
        }
        $solicitudes = $solicitudes->get();

        //return view('/solicitudes/busqueda',compact('solicitudes'));
        return view('/historial/conciliadores',compact('solicitudes'));
    }

    //Citado persona física
    public function citado_personaF(Request $request){
        $data = $request->all();
        //$citados = SeerCitados::find($data["id_citado_pf"]);
       
        $data_insertar= array(
            'id_solicitud'              => $data["id"],
            'id_citado'                 => $data["id_citado_pf"],
            'nombre'                    => $data["nombre"],
            'primer_apellido'           => $data["primer_apellido"], 
            'segundo_apellido'          => $data["segundo_apellido"],
            'identificacion'            => $data["identificacionAlta"],
        );
        
        $documento = $data["nombre"]."-".$data["primer_apellido"]."-".$data["segundo_apellido"]."_Identificacion.pdf";
        $path = Storage::putFileAs(
            'documentosSolicitud', $request->file('documentoIdentificacion'), $documento
        );
        $data_insertar["documentoIdentificacion"] = $documento;

        PersonaFisica::create($data_insertar);   
        $id_adiencia = PersonaFisica::select('id')->orderBy('id', 'desc')->first();
        SeerCitados::find($data['id_citado_pf'])->update([
            'id_fisica'         => $id_adiencia["id"],
            'nombre'            => $data["nombre"],
            'primer_apellido'   => $data["primer_apellido"], 
            'segundo_apellido'  => $data["segundo_apellido"]
        ]);

        return back()->with('success', 'Representante legal registrado y asignado correctamente al citado.');
    }

    //PDF Acta No conciliación
    public function VerPDFNoConciliacion($id){
        $solicitud = SeerPerGeneral::find($id);
        
        $solicitante  = SeerPerGeneral::join("seer_solicitante","seer_solicitante.id_solicitud","=","seer_general.id");
        $solicitante = $solicitante->where("seer_solicitante.id_solicitud", "=", $solicitud["id"])
        ->first();
        
        //$citado = SeerCitados::where('id_solicitud', $id)->get();
        $citado  = SeerPerGeneral::join("seer_citados","seer_citados.id_solicitud","=","seer_general.id");
        $citado = $citado->where("seer_citados.id_solicitud", "=", $solicitud["id"])
        ->first();

        $conciliador  = User::join("seer_general","seer_general.conciliador_id","=","users.id");
        $conciliador = $conciliador->where("seer_general.conciliador_id", "=", $solicitud["conciliador_id"])
        ->select('users.name')
        ->first();

        $audiencia  = SeerPerGeneral::join("audiencias","audiencias.id_solicitud","=","seer_general.id");
        $audiencia = $audiencia->where("audiencias.id_solicitud", "=", $solicitud["id"])
        ->first();

        $html = view('PDF/Solicitudes/NoConciliacion', compact('id', 'solicitud','conciliador','citado','audiencia','solicitante'))->render();

        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true); 

        $nombreArchivo = 'No_Conciliacion_' . $solicitud->empresa .'.pdf';
        return $pdf->stream($nombreArchivo);                 
    }

    public function audiencias_cumplimiento(){
        $id = auth()->user()->id;
        $user = User::find($id);

        $auxiliares = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Auxiliar');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();
        $notificadores = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Notificador');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();
        $conciliadores = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Conciliador');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();

        return view('/cumplimientos/index',compact('auxiliares','conciliadores'));
    }

    public function solicitud_audiencia_revisar($id){
        $id_user = auth()->user()->id;
        $user = User::find($id_user);
        $id             = $id;
        $general        = SeerPerGeneral::find($id);
        $ramas          = SolicitudRama::all();
        $solicitantes   = SeerSolicitante::where("id_solicitud",$id)->get();
        $citados        = SeerCitados::where("id_solicitud",$id)->get();
        $estados        = Estados::all();
        $municipios     = Municipios::where('estado',16)->get();
        $conciliadores = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Conciliador');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();
        //Catalogo de motivos
        //$mostrarMotivos = SolicitudMotivo::all();
        $mostrarMotivos = SolicitudMotivo::where('tipo_solicitud', $general->tipo_solicitud)->get();
        //Motivos capturados
        $motivos        = SeerMotivo::join('catalogo_motivos','catalogo_motivos.id','seer_motivos.id_motivo')
        ->where('id_solicitud',$id)
        ->select('catalogo_motivos.motivo','seer_motivos.id')->get();

        return view('audiencias.revisar_audiencia', compact('id','general','solicitantes','citados','ramas','estados','municipios','mostrarMotivos','motivos','conciliadores'));
    }

    public function pdfCitatorioAudiencia($id) {
        $citado = SeerCitados::find($id);
        $solicitud = SeerPerGeneral::where('id',$citado["id_solicitud"])->first();   
        $solicitante = SeerSolicitante::where('id_solicitud', $citado["id_solicitud"])->first();
        $motivoIds = SeerMotivo::where('id_solicitud', $citado["id_solicitud"])->pluck('id_motivo');
        $motivos = SolicitudMotivo::whereIn('id', $motivoIds)->get();
        $audiencia  = SeerPerGeneral::join("audiencias","audiencias.id_solicitud","=","seer_general.id")
        ->where("audiencias.id_solicitud", "=", $solicitud["id"])->first();
        $conciliador  = User::join("seer_general","seer_general.conciliador_id","=","users.id");
        $conciliador = $conciliador->where("seer_general.conciliador_id", "=", $solicitud["conciliador_id"])->select('users.name')->first();
     
        $html = view('PDF/Solicitudes/citatorio', compact('solicitud','solicitante','citado','motivos','audiencia','conciliador'))->render();
        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true); 
        $nombreArchivo = 'citatorio_' . $citado->nombre . '_' . $citado->primer_apellido . '.pdf';

        return $pdf->stream($nombreArchivo);
    }

    public function solicitudes(){
        $id = auth()->user()->id;
        $user = User::find($id);

        $auxiliares = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Auxiliar');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();
        $notificadores = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Notificador');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();
        $conciliadores = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Conciliador');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();

        return view('solicitudes/index',compact('auxiliares','conciliadores'));
    }

    public function solicitudes_busqueda(Request $request){
        $data = $request->all();
        $bandera_fechas         = 0;
        $bandera_nue            = 0;
        $bandera_curp           = 0;
        $bandera_solicitante    = 0;
        $bandera_citado         = 0;
        $bandera_folio          = 0;
        $bandera_año            = 0;
        $bandera_estatus        = 0;
        $bandera_tipo           = 0;
        $bandera_auxiliar       = 0;
        $bandera_conciliador    = 0;

        //Si existe la fecha de inicio
        if(isset($data["inicio"]) ){
            if(isset($data["final"]) ){
                if($data["inicio"] > $data["final"]){
                    return back()->withErrors('Si seleccionas una fecha de inicio, no debe ser mayor a la fecha final.');
                }
                //Agregar fecha inicio y final
                $bandera_fechas = 1;
            }
            else{
                return back()->withErrors('Si selecciones una fecha de inicio, debes seleccionar fecha final.');
            }
        }else if(isset($data["final"])){
            if(isset($data["inicio"]) ){
                if($data["inicio"] > $data["final"]){
                    return back()->withErrors('Si seleccionas una fecha de inicio, no debe ser mayor a la fecha final.');
                }
                //Agregar fecha inicio y final
                $bandera_fechas = 1;
            }
            else{
                return back()->withErrors('Si selecciones una fecha final, debes seleccionar fecha de inicio.');
            }
        }
        else if(isset($data["nue"])){
            //se va agregar el nue a la busqueda
            $bandera_nue = 1;
        }
        else if(isset($data["curp"])){
            //se va agregar el nue a la busqueda
            $bandera_curp = 1;
        }
        else if(isset($data["solicitante"])){
            //se va agregar el nue a la busqueda
            $bandera_solicitante = 1;
        }
        else if(isset($data["citado"])){
            //se va agregar el nue a la busqueda
            $bandera_citado = 1;
        }
        else if(isset($data["folio"])){
            //se va agregar el nue a la busqueda
            $bandera_folio = 1;
        }
        else if(isset($data["estatus"])){
            //se va agregar el nue a la busqueda
            $bandera_estatus = 1;
        }
        else if(isset($data["tipo"])){
            //se va agregar el nue a la busqueda
            $bandera_tipo = 1;
        }
        else if(isset($data["auxiliar"])){
            //se va agregar el nue a la busqueda
            $bandera_auxiliar = 1;
        }
        else if(isset($data["conciliador"])){
            //se va agregar el nue a la busqueda
            $bandera_conciliador = 1;
        }

        $solicitudes  = SeerPerGeneral::select("seer_general.id","seer_general.fecha","seer_general.fecha","seer_general.NUE","seer_general.tipo_solicitud","seer_general.estatus","seer_general.actividad","seer_solicitante.nombre");
        $solicitudes = $solicitudes->join("seer_solicitante","seer_solicitante.id_solicitud","seer_general.id");
        if($bandera_fechas == 1){
            $solicitudes = $solicitudes->where("seer_general.fecha",">=",$data["inicio"]);
            $solicitudes = $solicitudes->where("seer_general.fecha","<=",$data["final"]);
        }
        if($bandera_nue == 1){
            $solicitudes = $solicitudes->where("seer_general.NUE",$data["nue"]);
        }
        if($bandera_curp == 1){
            $solicitudes = $solicitudes->where("seer_solicitante.curp",$data["curp"]);
        }
        if($bandera_solicitante == 1){
            $solicitudes = $solicitudes->where("seer_solicitante.nombre",'like',$data["solicitante"]);
        }
        if($bandera_citado == 1){
            $solicitudes = $solicitudes->join("seer_citados","seer_citados.id_solicitud","seer_general.id");
            $solicitudes = $solicitudes->where("seer_citados.nombre",'like',$data["citado"]);
        }
        if($bandera_folio == 1){
            $solicitudes = $solicitudes->where("seer_general.id","=",$data["folio"]);
        }
        if($bandera_estatus == 1){
            $solicitudes = $solicitudes->where("seer_general.estatus","=",$data["estatus"]);
        }
        if($bandera_tipo == 1){
            $solicitudes = $solicitudes->where("seer_general.tipo_solicitud","=",$data["tipo"]);
        }
        if($bandera_auxiliar == 1){
            $solicitudes = $solicitudes->where("seer_general.user_id","=",$data["auxiliar"]);
        }
        if($bandera_conciliador == 1){
            $solicitudes = $solicitudes->where("seer_general.conciliador_id","=",$data["conciliador"]);
        }
        $solicitudes = $solicitudes->get();


        return view('solicitudes/busqueda',compact('solicitudes'));

    }

    public function solicitudes_pendientes_editar($id){
        $id_user = auth()->user()->id;
        $user = User::find($id_user);
        $id             = $id;
        $general        = SeerPerGeneral::find($id);
        $ramas          = SolicitudRama::all();
        $solicitantes   = SeerSolicitante::where("id_solicitud",$id)->get();
        $citados        = SeerCitados::where("id_solicitud",$id)->get();
        $estados        = Estados::all();
        $municipios     = Municipios::where('estado',16)->get();
        $conciliadores = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Conciliador');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();
        //Catalogo de motivos
        //$mostrarMotivos = SolicitudMotivo::all();
        $mostrarMotivos = SolicitudMotivo::where('tipo_solicitud', $general->tipo_solicitud)->get();
        //Motivos capturados
        $motivos        = SeerMotivo::join('catalogo_motivos','catalogo_motivos.id','seer_motivos.id_motivo')
        ->where('id_solicitud',$id)
        ->select('catalogo_motivos.motivo','seer_motivos.id')->get();

        return view('solicitudes.editar_solicitud', compact('id','general','solicitantes','citados','ramas','estados','municipios','mostrarMotivos','motivos','conciliadores'));
    }

    public function cumplimiento_actual(){
        $fecha_actual = date('y-m-d');

        $complimientos_ratificacion = Pagos::where("pago_solicitud.fecha",$fecha_actual)
        ->where("pago_solicitud.tipo_pago","Ratificacion")
        ->join("turnos","turnos.id","pago_solicitud.id_solicitud")
        ->select("pago_solicitud.id","pago_solicitud.fecha","pago_solicitud.hora","pago_solicitud.monto","pago_solicitud.descripcion",
        "pago_solicitud.observaciones","pago_solicitud.estatus","turnos.NUE","turnos.id as id_solicitud",
        DB::raw('CONCAT(turnos.nombre_empresa, " ", turnos.primero_empresa, " ", turnos.segundo_empresa) AS empresa'),
        DB::raw('CONCAT(turnos.trabajador, " ", turnos.primero_trabajador, " ", turnos.segundo_trabajador) AS trabajador'))
        ->get();

        $complimientos_audiencias = Pagos::where("pago_solicitud.fecha",$fecha_actual)
        ->where("pago_solicitud.tipo_pago","Audiencia")
        ->join("seer_general","seer_general.id","pago_solicitud.id_solicitud")
        ->join("seer_solicitante","seer_general.id","seer_solicitante.id_solicitud")
        ->select("pago_solicitud.id","pago_solicitud.fecha","pago_solicitud.hora","pago_solicitud.monto","pago_solicitud.descripcion",
        "pago_solicitud.observaciones","pago_solicitud.estatus","seer_general.NUE","seer_general.id as id_solicitud",
        DB::raw('seer_solicitante.nombre AS trabajador'))
        ->get();

        return view('cumplimientos/actuales',compact('complimientos_ratificacion','complimientos_audiencias'));
    }

    //PDF NOTIFICADORES Razón de notificación
    public function VerPDFRNotificacion($id, $id_solicitud){
        $solicitud = SeerPerGeneral::find($id_solicitud);
        $solicitante  = SeerPerGeneral::join("seer_solicitante","seer_solicitante.id_solicitud","=","seer_general.id");
        $solicitante = $solicitante->where("seer_solicitante.id_solicitud", "=", $solicitud["id"])
        ->first();

        $citado = SeerPerGeneral::join("seer_citados", "seer_citados.id_solicitud", "=", "seer_general.id")
        ->where("seer_citados.id", $id)
        ->first();

        $municipioCitado = null;
        if ($citado && $citado->municipio_citado) {
            $municipio = \App\Models\Municipios::find($citado->municipio_citado);
            $municipioCitado = $municipio ? $municipio->nombre : null;
        }
        $id_notificador = $citado->id_notificador;

        $notificador = User::where('id', $id_notificador)
            ->select('name')
            ->first();

        $imagenes = [];

        for ($i = 1; $i <= 3; $i++) {
            $path = storage_path("app/documentos_notificacion/{$citado->id}-foto{$i}.jpg");

            if (file_exists($path)) {
                $imagenes[] = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($path));
            } else {
                $imagenes[] = null;
            }
        }
        $html = view('PDF/Solicitudes/razonNotificacion', compact('id', 'solicitud','citado','solicitante','notificador','imagenes','municipioCitado'))->render();

        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true); 

        $nombreArchivo = 'Razón_Notificación' . $solicitud->empresa .'.pdf';
        return $pdf->stream($nombreArchivo);                
    }

    public function consulta_cumplimiento($id,$tipo){
        $pago = Pagos::find($id);
        if($tipo == 1){
            $solicitudes = Pagos::join('turnos','turnos.id',"=",'pago_solicitud.id_solicitud')
            ->where('pago_solicitud.id',$id)
            ->select('pago_solicitud.id','turnos.NUE','pago_solicitud.fecha','pago_solicitud.hora','pago_solicitud.monto','pago_solicitud.descripcion','pago_solicitud.estatus','pago_solicitud.forma_pago')
            ->get();
            return view('/cumplimientos/pagar_ratificacion',compact('solicitudes'));
        }
        else if($tipo == 2){
            $solicitudes = Pagos::join('seer_general','seer_general.id',"=",'pago_solicitud.id_solicitud')
            ->where('pago_solicitud.id',$id)
            ->select('pago_solicitud.id','seer_general.NUE','pago_solicitud.fecha','pago_solicitud.hora','pago_solicitud.monto','pago_solicitud.descripcion','pago_solicitud.estatus','pago_solicitud.forma_pago')
            ->get();
            return view('/cumplimientos/pagarAuciencia',compact('solicitudes'));
        }
        else if($tipo == 3){
            $solicitudes = Pagos::join('turnos','turnos.id',"=",'pago_solicitud.id_solicitud')
            ->where('pago_solicitud.id',$id)
            ->select('pago_solicitud.id','turnos.NUE','pago_solicitud.fecha','pago_solicitud.hora','pago_solicitud.monto','pago_solicitud.descripcion','pago_solicitud.estatus','pago_solicitud.forma_pago')
            ->get();
            return view('/cumplimientos/pagar_busqueda',compact('solicitudes'));
        }
        else if($tipo == 4){
            $solicitudes = Pagos::join('seer_general','seer_general.id',"=",'pago_solicitud.id_solicitud')
            ->where('pago_solicitud.id',$id)
            ->select('pago_solicitud.id','seer_general.NUE','pago_solicitud.fecha','pago_solicitud.hora','pago_solicitud.monto','pago_solicitud.descripcion','pago_solicitud.estatus','pago_solicitud.forma_pago')
            ->get();
            return view('/cumplimientos/pagar_busqueda',compact('solicitudes'));
        }
        else if($tipo == 6){
            $solicitudes = Pagos::where('id',$id)->get();
            return view('/cumplimientos/pagar_busqueda',compact('solicitudes'));
        }
    }

    public function consulta_cumplimiento_ratificacion($id){
        $solicitudes = Pagos::join('turnos','turnos.id',"=",'pago_solicitud.id_solicitud')
            ->where('pago_solicitud.id',$id)
            ->select('pago_solicitud.id','turnos.NUE','pago_solicitud.fecha','pago_solicitud.hora','pago_solicitud.monto','pago_solicitud.descripcion','pago_solicitud.estatus','pago_solicitud.forma_pago')
            ->get();
            return view('/cumplimientos/pagarratificacion',compact('solicitudes'));
    }
    public function cumplimiento_pagar_rati(Request $request){
        $request->validate([
            'id'              => 'required|exists:pago_solicitud,id',
            'observaciones'   => 'nullable|string',
            'forma_pago'      => 'required|string',
            'fecha_audiencia' => 'required|date',
            'hora_audiencia'  => 'required',
        ]);
        $data = $request->all();

        Pagos::find($data["id"])->update(['estatus'  => "Pagado", 'observaciones' => $data["observaciones"],
                                        'forma_pago'      => $data["forma_pago"],
                                        'fecha_audiencia' => $data["fecha_audiencia"],
                                        'hora_audiencia'  => $data["hora_audiencia"]]);

        $pagos = Pagos::find($data["id"]);
        $id_solicitud = $pagos["id_solicitud"];
        $faltantes =  Pagos::where('id_solicitud',$id_solicitud)->where('estatus',"Pendiente")->get();

        if(count($faltantes) == 0){
            Turnos::find($id_solicitud)->update(['estatus' => "Concluida"]);
        }

        return redirect()->route('cumplimiento_actual');
    }

    public function cumplimiento_rechazar_rati($id){
        $pagos = Pagos::find($id);
        
        $id_solicitud = $pagos["id_solicitud"];
        Pagos::find($id)->update(['estatus'  => "No pagado"]);
        Turnos::find($id_solicitud)->update(['estatus' => "Incumplimiento"]);

        return redirect()->route('cumplimiento_actual');
    }

    public function cumplimiento_pagar_audiencia(Request $request){
        $data = $request->all();

        Pagos::find($data["id"])->update(['estatus'  => "Pagado", 'observaciones' => $data["observaciones"]]);
        $pagos = Pagos::find($data["id"]);
        $id_solicitud = $pagos["id_solicitud"];
        $faltantes =  Pagos::where('id_solicitud',$id_solicitud)->where('estatus',"Pendiente")->get();

        if(count($faltantes) == 0){
            SeerPerGeneral::find($id_solicitud)->update(['estatus' => "Concluida"]);
        }

        return redirect()->route('cumplimiento_actual');
    }

    public function cumplimiento_rechazar_audiencia($id){
        $pagos = Pagos::find($id);
        $id_solicitud = $pagos["id_solicitud"];
        Pagos::find($id)->update(['estatus'  => "No pagado"]);

        SeerPerGeneral::find($id_solicitud)->update(['estatus' => "Incumplimiento"]);

        return redirect()->route('cumplimiento_actual');
    }

    public function cumplimientos_busqueda(Request $request){
        $data = $request->all();
        $bandera_fechas = 0;
        //Si existe la fecha de inicio
        if(isset($data["inicio"]) ){
            if(isset($data["final"]) ){
                if($data["inicio"] > $data["final"]){
                    return back()->withErrors('Si seleccionas una fecha de inicio, no debe ser mayor a la fecha final.');
                }
                //Agregar fecha inicio y final
                $bandera_fechas = 1;
            }
            else{
                return back()->withErrors('Si selecciones una fecha de inicio, debes seleccionar fecha final.');
            }
        }else if(isset($data["final"])){
            if(isset($data["inicio"]) ){
                if($data["inicio"] > $data["final"]){
                    return back()->withErrors('Si seleccionas una fecha de inicio, no debe ser mayor a la fecha final.');
                }
                //Agregar fecha inicio y final
                $bandera_fechas = 1;
            }
            else{
                return back()->withErrors('Si selecciones una fecha final, debes seleccionar fecha de inicio.');
            }
        }

        $solicitudes = Pagos::whereBetween("pago_solicitud.fecha",[$data["inicio"],$data["final"]])
        ->where("pago_solicitud.tipo_pago","Ratificacion")
        ->join("turnos","turnos.id","pago_solicitud.id_solicitud")
        ->select("pago_solicitud.id","pago_solicitud.fecha","pago_solicitud.hora","pago_solicitud.monto","pago_solicitud.descripcion",
        "pago_solicitud.observaciones","pago_solicitud.estatus","turnos.NUE","turnos.id as id_solicitud",
        DB::raw('CONCAT(turnos.nombre_empresa, " ", turnos.primero_empresa, " ", turnos.segundo_empresa) AS empresa'),
        DB::raw('CONCAT(turnos.trabajador, " ", turnos.primero_trabajador, " ", turnos.segundo_trabajador) AS trabajador'))
        ->get();

        return view('cumplimientos/busqueda_resultado',compact('solicitudes'));
    }

    public function PDFincumplimientoAudiencia($id){
        $pagos = Pagos::find($id);

        if($pagos["id_solicitud"] == 0){
            $solicitud = Pagos::find($id);
            $salario_diario = 0;
            $conciliador  = User::join("pago_solicitud","pago_solicitud.id_conciliador","=","users.id");
            $conciliador = $conciliador->where("pago_solicitud.id", "=", $id)
            ->select('users.name')
            ->first();
            $html = view('PDF/cumplimientos/Incumplimiento', compact('id', 'solicitud','conciliador','salario_diario','pagos'))->render();
        }
        else{
            $solicitud = SeerSolicitante::where('id_solicitud',$pagos["id_solicitud"])->first();
            $pagos      = Pagos::find($id);
            $general    = SeerPerGeneral::find($pagos["id_solicitud"]);
            $salario_diario = $this->calcularSalarioDiario($solicitud->pago, $solicitud->periodo_pago);

            $conciliador  = User::join("seer_general","seer_general.conciliador_id","=","users.id");
            $conciliador = $conciliador->where("seer_general.id", "=", $general["id"])
            ->select('users.name')
            ->first();
            $html = view('PDF/Incumplimiento', compact('id', 'solicitud','conciliador','salario_diario','pagos'))->render();
        }
       
        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true); 

        $nombreArchivo = 'constancia_de_incumplimiento_'  .'.pdf';
        return $pdf->stream($nombreArchivo);                  
    }
    
    public function cumplimiento_pagar_busqueda_rati(Request $request){
        $request->validate([
            'forma_pago'      => 'required',
            'fecha_audiencia' => 'required|date',
            'hora_audiencia'  => 'required',
        ]);
        $data = $request->all();

        Pagos::find($data["id"])->update(['estatus'  => "Pagado", 'observaciones' => $data["observaciones"], 
                                            'forma_pago'      => $data["forma_pago"],
                                            'fecha_audiencia' => $data["fecha_audiencia"],
                                            'hora_audiencia'  => $data["hora_audiencia"]]);

        $pagos = Pagos::find($data["id"]);
        $id_solicitud = $pagos["id_solicitud"];
        $faltantes =  Pagos::where('id_solicitud',$id_solicitud)->where('estatus',"Pendiente")->get();
        if($pagos["id_solicitud"] != 0){
            if(count($faltantes) == 0){
                Turnos::find($id_solicitud)->update(['estatus' => "Concluida"]);
            }
        }

        return redirect()->route('agenda')->with('pagos', $pagos);
    }

    public function cumplimiento_rechazar_busqueda_rati(Request $request, $id){
        $request->validate([
            'fecha_audiencia' => 'required|date',
            'hora_audiencia'  => 'required',
        ]);
        $pago = Pagos::find($id);
        $pago->update([
            'estatus'         => "No pagado",
            'fecha_audiencia' => $request->fecha_audiencia,
            'hora_audiencia'  => $request->hora_audiencia,
        ]);

        $id_solicitud = $pago->id_solicitud;
        Turnos::find($id_solicitud)?->update(['estatus' => "Incumplimiento"]);
    
        return redirect()->route('agenda');                         
      /*Así estab antes de los cambios en los cumplimientos*/ 
        /* 
       $pagos = Pagos::find($id);
        
        //$id_solicitud = $pagos["id_solicitud"];
        Pagos::find($id)->update(['estatus'  => "No pagado"]);
        //Turnos::find($id_solicitud)->update(['estatus' => "Incumplimiento"]);

        return redirect()->route('agenda');*/
    }

    public function cumplimiento_pagar_busqueda_audiencia(Request $request){
        $request->validate([
            'forma_pago'      => 'required',
            'fecha_audiencia' => 'required|date',
            'hora_audiencia'  => 'required',
        ]);
        $data = $request->all();

        Pagos::find($data["id"])->update(['estatus'  => "Pagado", 'observaciones' => $data["observaciones"], 
                                            'forma_pago'      => $data["forma_pago"],
                                            'fecha_audiencia' => $data["fecha_audiencia"],
                                            'hora_audiencia'  => $data["hora_audiencia"]]);

        $pagos = Pagos::find($data["id"]);
        $id_solicitud = $pagos["id_solicitud"];
        $faltantes =  Pagos::where('id_solicitud',$id_solicitud)->where('estatus',"Pendiente")->get();

        if(count($faltantes) == 0){
            SeerPerGeneral::find($id_solicitud)->update(['estatus' => "Concluida"]);
        }

        return redirect()->route('agenda');
    }

    public function VerPDFAudiencia($id){
        $solicitud = SeerPerGeneral::find($id);
        $pagos = Pagos::where('id_solicitud',$id)->get();

        $conciliador  = User::join("seer_general","seer_general.conciliador_id","=","users.id")
        ->select('users.name')
        ->first();
        $html = view('PDF/ActaAudiencia', compact('id','solicitud','conciliador','pagos'))->render();

        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true); 

        $nombreArchivo = 'constancia_de_pago_'  .'.pdf';
        return $pdf->stream($nombreArchivo);         
    }

    public function audiencia_index(){
        $id = auth()->user()->id;
        $user = User::find($id);
        //$roles = Role::pluck('name','name')->all();
        //$userRole = $user->roles->pluck('name')->all();

        $auxiliares = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Auxiliar');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();
        $notificadores = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Notificador');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();
        $conciliadores = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Conciliador');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();
        
        return view('/audiencias/index',compact('auxiliares','conciliadores'));
    }
//Rechazo de solicitud
    public function guardar_rechazo(Request $request){
        $data = $request->all();
        SeerPerGeneral::find($data["id"])->update(['estatus' => 'Prevencion','observaciones' => $data["observaciones"]]);
        
        return redirect()->route('solicitudes_pendientes');
    }
//Consultar solicitud por parte del solicitante
    public function solicitud_consultarSolicitante($id){
        $id_user = auth()->user()->id;
        $user = User::find($id_user);
        $id             = $id;
        $general        = SeerPerGeneral::find($id);
        $ramas          = SolicitudRama::all();
        $solicitantes   = SeerSolicitante::where("id_solicitud",$id)->get();
        $citados        = SeerCitados::where("id_solicitud",$id)->get();
        $estados        = Estados::all();
        $municipios     = Municipios::where('estado',16)->get();
        $conciliadores = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Conciliador');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();
        //Catalogo de motivos
        //$mostrarMotivos = SolicitudMotivo::all();
        $mostrarMotivos = SolicitudMotivo::where('tipo_solicitud', $general->tipo_solicitud)->get();
        //Motivos capturados
        $motivos        = SeerMotivo::join('catalogo_motivos','catalogo_motivos.id','seer_motivos.id_motivo')
        ->where('id_solicitud',$id)
        ->select('catalogo_motivos.motivo','seer_motivos.id')->get();

        return view('solicitudes.correccion_solicitantes', compact('id','general','solicitantes','citados','ramas','estados','municipios','mostrarMotivos','motivos','conciliadores'));
    }

    //Guardar cambios realizados por el solicitante en su solicitud una vez que fue rechazada
    public function correccion_solicitante(Request $request){
        $data = $request->all();

        //Se va asignar el conciliador y la sala
        $id_user = auth()->user()->id;
        $user = User::find($id_user);
        $listado_auxiliares = array();
        $relacionEloquent = 'roles';
        $fecha_actual = date('y-m-d');
        
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
            $foto1 = $data["imagen_domicilio1"][$i] ?? 'Sin documento';
            $foto2 = $data["imagen_domicilio2"][$i] ?? 'Sin documento';
        
            if ($request->hasFile("foto1.$i")) {
                $file = $request->file("foto1")[$i];
                $foto1 = $data["id"] . "-citado_foto1_" . Str::random(8) . "." . $file->getClientOriginalExtension();
                Storage::putFileAs('documentosSolicitud', $file, $foto1);
            }
        
            if ($request->hasFile("foto2.$i")) {
                $file = $request->file("foto2")[$i];
                $foto2 = $data["id"] . "-citado_foto2_" . Str::random(8) . "." . $file->getClientOriginalExtension();
                Storage::putFileAs('documentosSolicitud', $file, $foto2);
            }
            
            $data_insert=array(
                'id_solicitud'      => $data["id"],
                'colonia'           => $data["colonia_citado"][$i],
                'cp'                => $data["cp_citado"][$i],
                'n_ext'             => $data["n_ext_citado"][$i],
                'calle'             => $data["calle_citado"][$i],
                'tipo_vialidad'     => $data["vialidad_citado"][$i],
                'referencia'        => $data["referencia_citado"][$i],
                'municipio_citado'  => $data["municipio_citado"][$i],
                'tipo_persona'      => $data["tipo_persona_citado"][$i],
                'nombre'            => $data["nombre_citado"][$i],
                'primer_apellido'   => $data["primer_apellido"][$i],
                'segundo_apellido'  => $data["segundo_apellido"][$i],
                'curp'              => $data["curp_citado"][$i],
                'rfc'               => $data["rfc_citado"][$i],
                'imagen_domicilio1' => $foto1,
                'imagen_domicilio2' => $foto2,
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
                }
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
        SeerPerGeneral::find($data["id"])->update(['estatus' => "Pendiente" ]);

        return redirect()->route('todas_solicitudes'); 
    }

    //PDF NOTIFICADORES NOTIFICACION
    //PDF Notificación Por instructivo
    public function PDFnotificadoInstructivo($id, $id_solicitud){
        $solicitud = SeerPerGeneral::find($id_solicitud);
        $solicitante  = SeerPerGeneral::join("seer_solicitante","seer_solicitante.id_solicitud","=","seer_general.id");
        $solicitante = $solicitante->where("seer_solicitante.id_solicitud", "=", $solicitud["id"])
        ->first();
       
        $citado = SeerPerGeneral::join("seer_citados", "seer_citados.id_solicitud", "=", "seer_general.id")
        ->where("seer_citados.id", $id)
        ->first();
        if (!empty($citado->medio)) {
            $citado->medio = json_decode($citado->medio);
        }
        $municipioCitado = null;
        if ($citado && $citado->municipio_citado) {
            $municipio = \App\Models\Municipios::find($citado->municipio_citado);
            $municipioCitado = $municipio ? $municipio->nombre : null;
        }
        $id_notificador = $citado->id_notificador;

        $notificador = User::where('id', $id_notificador)
            ->select('name')
            ->first();

        $imagenes = [];

        for ($i = 1; $i <= 3; $i++) {
            $path = storage_path("app/documentos_notificacion/{$citado->id}-foto{$i}.jpg");

            if (file_exists($path)) {
                $imagenes[] = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($path));
            } else {
                $imagenes[] = null;
            }
        }
            
        $html = view('PDF/Solicitudes/razonPorInstructivo', compact('id', 'solicitud','citado','solicitante','notificador','imagenes','municipioCitado'))->render();

        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true); 

        $nombreArchivo = 'Razón_NotificaciónIns' . $solicitud->empresa .'.pdf';
        return $pdf->stream($nombreArchivo);                
    }

    //PDF Notificación No exitosa SE CONSTITUYE, CERRADO
    public function PDFnotificadoNoexitosa($id, $id_solicitud){
        $solicitud = SeerPerGeneral::find($id_solicitud);
        $solicitante  = SeerPerGeneral::join("seer_solicitante","seer_solicitante.id_solicitud","=","seer_general.id");
        $solicitante = $solicitante->where("seer_solicitante.id_solicitud", "=", $solicitud["id"])
        ->first();
       
        $citado = SeerPerGeneral::join("seer_citados", "seer_citados.id_solicitud", "=", "seer_general.id")
        ->where("seer_citados.id", $id)
        ->first();
        if (!empty($citado->medio)) {
            $citado->medio = json_decode($citado->medio);
        }
        $municipioCitado = null;
        if ($citado && $citado->municipio_citado) {
            $municipio = \App\Models\Municipios::find($citado->municipio_citado);
            $municipioCitado = $municipio ? $municipio->nombre : null;
        }
        $id_notificador = $citado->id_notificador;

        $notificador = User::where('id', $id_notificador)
            ->select('name')
            ->first();

        $imagenes = [];

        for ($i = 1; $i <= 3; $i++) {
            $path = storage_path("app/documentos_notificacion/{$citado->id}-foto{$i}.jpg");

            if (file_exists($path)) {
                $imagenes[] = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($path));
            } else {
                $imagenes[] = null;
            }
        }
            
        $html = view('PDF/Solicitudes/razonNoExitosa', compact('id', 'solicitud','citado','solicitante','notificador','imagenes','municipioCitado'))->render();

        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true); 

        $nombreArchivo = 'Razón_NotificaciónN' . $solicitud->empresa .'.pdf';
        return $pdf->stream($nombreArchivo);                 
    }

    //PDF Notificación No exitosa NO SE LOCALIZA INTERIOR
    public function PDFnotificadoNoexitosaInt($id, $id_solicitud){
        $solicitud = SeerPerGeneral::find($id_solicitud);
        $solicitante  = SeerPerGeneral::join("seer_solicitante","seer_solicitante.id_solicitud","=","seer_general.id");
        $solicitante = $solicitante->where("seer_solicitante.id_solicitud", "=", $solicitud["id"])
        ->first();
        
        $citado = SeerPerGeneral::join("seer_citados", "seer_citados.id_solicitud", "=", "seer_general.id")
        ->where("seer_citados.id", $id)
        ->first();
        if (!empty($citado->medio)) {
            $citado->medio = json_decode($citado->medio);
        }
        $municipioCitado = null;
        if ($citado && $citado->municipio_citado) {
            $municipio = \App\Models\Municipios::find($citado->municipio_citado);
            $municipioCitado = $municipio ? $municipio->nombre : null;
        }
         $id_notificador = $citado->id_notificador;
 
         $notificador = User::where('id', $id_notificador)
             ->select('name')
             ->first();
 
         $imagenes = [];
 
         for ($i = 1; $i <= 3; $i++) {
             $path = storage_path("app/documentos_notificacion/{$citado->id}-foto{$i}.jpg");
 
             if (file_exists($path)) {
                 $imagenes[] = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($path));
             } else {
                 $imagenes[] = null;
             }
         }
             
         $html = view('PDF/Solicitudes/razonNumInt', compact('id', 'solicitud','citado','solicitante','notificador','imagenes','municipioCitado'))->render();
 
         $pdf = \PDF::loadHTML($html)
             ->setPaper('a4', 'portrait')
             ->setOption('isHtml5ParserEnabled', true)
             ->setOption('isPhpEnabled', true); 
 
         $nombreArchivo = 'Razón_NotificaciónNInt' . $solicitud->empresa .'.pdf';
         return $pdf->stream($nombreArchivo);                      
    }

    //Guarda el expediente
    public function guardar_expediente(Request $request){
        $data = $request->all();
        $id = auth()->user()->id;
        $user = User::find($id);

        $audienciaId = $data['audiencia_id']; 
        $solicitud = SeerPerGeneral::find($audienciaId);

        if ($request->hasFile('documentoExpediente')) {
            $file = $request->file('documentoExpediente');
            if ($file->isValid()) {
                $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $documentoExpediente = $filename . "_Expediente." . $file->getClientOriginalExtension();
        
                $path = Storage::putFileAs(
                    'documentosSolicitud', $file, $documentoExpediente
                );

                $data_insertar= array(
                    'id_solicitud'      => $data["audiencia_id"],
                    'nombre_documento'  => $documentoExpediente,
                    'tipo_documentos'   => $file->getClientOriginalName(),
                    'tramite'           => "Audiencia", 
                );
                DocumentosSolicitud::create($data_insertar);

            } else {
                return back()->withErrors(['documentoExpediente' => 'Archivo no válido.']);
            }
        }
        return back()->with('success', 'Expediente cargado correctamente.');
    }
        
    public function actualiza_citados(Request $request){
        $data = $request->all();

        SeerCitados::find($data['id_citado_pf'])->update([
            'nombre'            => $data["nombre"],
            'primer_apellido'   => $data["primer_apellido"], 
            'segundo_apellido'  => $data["segundo_apellido"]
        ]);

        return back()->with('success', 'Nombre del Citado Actualizado Correctamente.');
    }

    public function Ver_INE_Solicitante(){

    }

    public function Ver_Documentos_Solicitante($id){

    }

    // PDF PTU
    public function VerPDFConvenioPTU($id){
        $solicitud = SeerPerGeneral::find($id); 
        $citado = SeerCitados::where('id_solicitud', $id)->get();
       // $citado = SeerCitados::where('id_solicitud', $id)->get();
        $pagos = Pagos::where('id_solicitud', $id)->get();
        
       // $dias_descanso = $solicitud->dias !== null ? 7 - $solicitud->dias : null;

        $salario_diario = $this->calcularSalarioDiario($solicitud->salario, $solicitud->frecuencia);
        $salario_mensual = $salario_diario * 30;
        $diarioTexto = $this->convertirNumerosALetras($salario_diario);
        $mensualTexto = $this->convertirNumerosALetras($salario_mensual);
        $montoTexto = $this->convertirNumerosALetras($solicitud->monto);
        
        $pagosDif  = Pagos::join("turnos","turnos.id","=","pago_solicitud.id_solicitud");
        $pagosDif = $pagosDif->where("pago_solicitud.id_solicitud", "=", $id)
        ->select(DB::raw('count(pago_solicitud.id_solicitud) as C_pagos'))
        ->first();

        $conciliador = User::join("seer_general", "seer_general.conciliador_id", "=", "users.id")
        ->where("seer_general.id", "=", $id)
        ->select("users.name")
        ->first();

        $solicitante  = SeerPerGeneral::join("seer_solicitante","seer_solicitante.id_solicitud","=","seer_general.id");
        $solicitante = $solicitante->where("seer_solicitante.id_solicitud", "=", $solicitud["id"])
        ->first();
        
        $html = view('PDF/Solicitudes/convenioPTU', 
        compact('id', 'solicitud', /*'dias_descanso',*/ 'salario_diario','salario_mensual','pagos','diarioTexto','mensualTexto','montoTexto','pagosDif','conciliador','solicitante','citado'))
        ->render();
        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('Convenio_PTU.pdf');            
    }

    public function Historial_Solicitante(){ //ANA
        return view('solicitudes.solicitud_revision');
    }

    public function VerDocumentosAudiencia($id){
        $documento_general = SeerPerGeneral::find($id); 
        $documento_solicitante = SeerSolicitante::where('id_solicitud',$id)
        ->select('documentoCurp','documentoIdentificacion')
        ->first(); 
        //Documentos del abogado y citados
        $documento_abogado = Poder::find($documento_general["idAbogado"]);
        //Documentos perdona fisica
        $documento_fisica = PersonaFisica::
        join('seer_citados','seer_citados.id_fisica','persona_fisica.id')
        ->where('seer_citados.id_solicitud',$id)
        ->select('persona_fisica.documentoIdentificacion')
        ->get();
        
         //Documentos subidos
        $documento_subidos = DocumentosSolicitud::where('id_solicitud',$id)->get();

 
        return view('solicitudes.verDocumentos',compact('documento_general','documento_solicitante','documento_abogado','documento_fisica','documento_subidos'));
     }

    //PDF Constancia de cumplimiento
    public function VerPDFCumplimiento($id){
        $pagos = Pagos::find($id);
        if($pagos["id_solicitud"] == 0){
            $solicitud = Pagos::find($id);
            $conciliador  = User::join("pago_solicitud","pago_solicitud.id_conciliador","=","users.id");
            $conciliador = $conciliador->where("pago_solicitud.id", "=", $pagos["id"])
            ->select('users.name')
            ->first();
            $html = view('PDF/Cumplimientos/pagosParciales', compact('id', 'solicitud','conciliador','pagos'))->render();
        }else{
            $solicitud = SeerPerGeneral::find($pagos["id_solicitud"]);
            $conciliador  = User::join("seer_general","seer_general.conciliador_id","=","users.id");
            $conciliador = $conciliador->where("seer_general.id", "=", $solicitud["id"])
            ->select('users.name')
            ->first();
            $html = view('PDF/Solicitudes/pagosParciales', compact('id', 'solicitud','conciliador','pagos'))->render();
        }

        

        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true); 

        $nombreArchivo = 'constancia_de_cumplimiento_' . $solicitud->trabajador .'.pdf';
        return $pdf->stream($nombreArchivo);                  
    }

    public function notificaciones_consultar(){
        //return view('/notificaciones/consultar');
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        
        $notificaciones = SeerCitados::join('seer_general','seer_general.id','seer_citados.id_solicitud')
        ->select('seer_citados.*','seer_general.NUE')
        ->orderBy('created_at', 'desc')->limit(500)->get();

       
        return view('/notificaciones.index_busqueda',compact('notificaciones'));
    }

    public function notificaciones_busqueda(Request $request){
        
        $request->validate([
            'fecha_inicio' => 'required',
            'fecha_final' => 'required',
        ]);

        $data = $request->all();
        $fecha_inicio = $data["fecha_inicio"];
        $fecha_fin = $data["fecha_final"];
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
        ->leftJoin('users', 'seer_citados.id_notificador', '=', 'users.id')
        ->select('seer_general.id as id_solicitud','seer_citados.id as id_citado','seer_general.NUE',
            'seer_citados.nombre','seer_citados.primer_apellido','seer_citados.segundo_apellido',
            'seer_citados.colonia','seer_citados.calle','seer_citados.n_ext','seer_citados.n_int','seer_citados.estatus','seer_citados.tipo_notificacion','users.name as notificador_nombre')
        ->where('seer_general.delegacion', $user["delegacion"])
        //->where('seer_citados.id_notificador', '!=', 0)
        ->where('seer_citados.notificacion',"!=", "Trabajador")
        ->whereBetween('seer_general.fecha', [$data["fecha_inicio"], $data["fecha_final"]])
        ->get();

        return view('notificaciones.index_busqueda',compact('notificaciones','personas','userRole','fecha_inicio','fecha_fin'));
    }
    
    //PDF COMPARECE REPRESENTANTE LEGAL SIN PODER
    public function VerPDFCompareceSinPoder($id){
        $solicitud = SeerPerGeneral::find($id);
        $conciliador  = User::join("seer_general","seer_general.conciliador_id","=","users.id");
        $conciliador = $conciliador->where("seer_general.id", "=", $id)
        ->select('users.name')
        ->first();
       
        $solicitante = SeerPerGeneral::join("seer_solicitante","seer_solicitante.id_solicitud","=","seer_general.id");
        $solicitante = $solicitante->where("seer_solicitante.id_solicitud", "=", $solicitud["id"])
        ->first();
        $citado = SeerCitados::where('id_solicitud', $id)->first();
        $abogado = Poder::join('seer_citados','seer_citados.id_abogado','abogados.idAbogado')
        ->where('id_solicitud',$id)
        ->select('abogados.nombres_patronal','abogados.primer_apellido_patronal','abogados.segundo_apellido_patronal','abogados.descipcion_poder')
        ->first();
        $html = view('PDF/Solicitudes/compareceSinPoder', 
            compact('id', 'solicitud', 'conciliador','solicitante','citado','abogado'))
            ->render();
        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true);

        return $pdf->stream('compareceSinPoder.pdf');                   
    }
    
    //Cumplimiento cuando no comparece el trabajador
    public function cumplimiento_incompa_rati($id){
        $pagos = Pagos::find($id);
        
        $id_solicitud = $pagos["id_solicitud"];
        Pagos::find($id)->update(['estatus'  => "Incomparecencia trabajador"]);
        Turnos::find($id_solicitud)->update(['estatus' => "Incumplimiento"]); //Revisar si se va a archivar, o q procede ANA

        return redirect()->route('cumplimiento_actual');
        //return redirect()->route('ratificacion_atender'); 
    }

    //Muestra la delegación que le corresponde según el municipío seleccionado
    public function DelegacionPorMunicipio($municipioId)
    {
        $municipio = Municipios::find($municipioId);

        if (!$municipio) {
            return response()->json([
                'success' => false,
                'message' => 'Municipio no encontrado',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'delegacion_id' => $municipio->delegacion_id,
        ]);
    }

    public function vista_previa($id){
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);           
        $conciliadores    = SeerPerConciliador::where('id_solicitud',$id)->first();
        $solicitud      = SeerPerGeneral::find($id);
        $conciliador    = User::select('name')->where('id', $solicitud->conciliador_id)->first();

        $representantes = SeerCitados::
        leftjoin('abogados', 'abogados.idAbogado', '=', 'seer_citados.id_abogado')
        ->leftJoin('persona_fisica', 'persona_fisica.id', '=', 'seer_citados.id_fisica')
        ->where('seer_citados.id_solicitud', $id)
        ->select('seer_citados.nombre','seer_citados.primer_apellido','seer_citados.segundo_apellido','seer_citados.rfc',
        'abogados.nombres_patronal as nombre_abogado','abogados.primer_apellido_patronal as primero_abogado','abogados.segundo_apellido_patronal as segundo_abogado',
        'persona_fisica.nombre as nombre_fisica','persona_fisica.primer_apellido as primer_fisica','persona_fisica.segundo_apellido as segundo_fisica',
        'seer_citados.id_abogado','seer_citados.id_fisica','seer_citados.id','seer_citados.notificacion','seer_citados.estatus')
        ->get();
        $solicitante = SeerSolicitante::where('id_solicitud', $id)->first();
        $abogados = Poder::all();
        SeerPerGeneral::find($id)->update(['conciliador' => $user->id, 'estatus' => 'Confirmado']);
        $estados        = Estados::all();
        $municipios     = Municipios::where('estado',16)->get();
        $conceptos      = Concepto::where('id_solicitud',$id)->where('tipo_pago','Audiencia')->get();
        $pagos          = Pagos::where('id_solicitud',$id)->where('tipo_pago','Audiencia')->get();
        $deducciones    = Deducciones::where('id_solicitud',$id)->where('tipo_pago','Audiencia')->get();

        return view('/audiencias/audiencia_revisar',compact('id','conciliadores','representantes','solicitante','conciliador','solicitud','abogados','estados','municipios','conceptos','pagos','deducciones'));
    }

    public function editar_solicitud_audiencia(Request $request) {
        $data = $request->all();
        $id_solicitud = $data["id"];
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name')->all();

        $solicitante = SeerSolicitante::where('id_solicitud', $data['id'])->first();
    
        //Actualizar Solicitante
        SeerSolicitante::where('id_solicitud', $data["id"])
        ->update([
            'curp'                  => $data["curp"],
            'rfc'                   => $data["rfc"],
            'nombre'                => $data["nombre"],
            'puesto'                => $data["puesto"],
            'pago'                  => $data["pago"],
            'periodo_pago'          => $data["periodo_pago"],
            'fecha_ingreso'         => $data["fecha_ingreso"],
            'fecha_salida'          => $data["fecha_salida"],
            'jornada'               => $data["jornada"],
            'horas_semana'          => $data["horas"],
        ]);

        if(isset($data["seguro"])){
            SeerSolicitante::where('id_solicitud', $data["id"])->update(['nss' => $data["seguro"] ]);
        }
            
        return redirect()->route('vista_previa', compact('id_solicitud'));
      
    }

    public function seleccionar_abogado_audiencia(Request $request){
        $data = $request->all();
        $id_solicitud = $data["solicitud"];

        SeerCitados::find($data["citado"])
        ->update([
            'id_abogado'  => $data["abogado"],
        ]);

        return redirect()->route('vista_previa',compact('id_solicitud'));
    }

    public function insertar_citados_audiencia(Request $request) {
        $data = $request->all();
        //$id_solicitud = $data["id"];
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name')->all();
        
        if(!isset($data['moreliaSucursal'])){
            $regionmorelia = "No";
        }
        else{
            $regionmorelia = $data['moreliaSucursal'];
        }
        if(!isset($data['uruapanSucursal'])){
            $regionuruapan = "No";
        }
        else{
            $regionuruapan = $data['uruapanSucursal'];
        }
        if(!isset($data['zamoraSucursal'])){
            $regionzamora = "No";
        }
        else{
            $regionzamora = $data['zamoraSucursal'];
        }

        //Validar documentacion
        request()->validate([
            'nombresAbogadoAlta'        => 'required',
            'primer_apellido'           => 'required',
            'segundo_apellido'          => 'required',
            'correoAbogadoAlta'         => 'required',
            'empresaAbogadoAlta'        => 'required',
            'curpAbogadoAlta'           => 'required',
            'domicilioAbogadoAlta'      => 'required',
            'fechaVigenciaAlta'         => 'required',
            'industriaAlta'             => 'required',
            'descripcionpoderAlta'      => 'required',
            'documentoIne'              => 'required',
            'documentoRepresentacion'   => 'required',
            'documentoPoder'            => 'nullable',
            'documentoAnexo'            => 'nullable',
        ], $data);

        //Validar las regiones
        if($regionmorelia == "No" && $regionuruapan == "No" && $regionzamora == "No"){
            return back()->withErrors('Debes seleccionar al menos una Región.');
        }

        //Validar que no exista el abogado
        $abogado = Poder::where(['nombres' => $data["nombresAbogadoAlta"], 'primer_apellido' => $data["primer_apellido"], 
        'segundo_apellido' => $data["segundo_apellido"], 'empresa' => $data["empresaAbogadoAlta"]])->first();
        if(!$abogado){
            $data_insertar= array(
                'nombres'           => $data["nombresAbogadoAlta"],
                'primer_apellido'   => $data["primer_apellido"], 
                'segundo_apellido'  => $data["segundo_apellido"], 
                'telefono'          => $data["telefonoAbogadoAlta"], 
                'email'             => $data["correoAbogadoAlta"],
                'fechaRegistro'     => date('y-m-d'),
                'fechaVigencia'     => $data["fechaVigenciaAlta"],
                'empresa'           => $data["empresaAbogadoAlta"],
                'eliminado'         => 0,
                'curp'              => $data["curpAbogadoAlta"],
                'domicilio'         => $data["domicilioAbogadoAlta"],
                'rfc'               => $data["RFCAbogadoAlta"],
                'industria'         => $data["industriaAlta"],
                'poder'             => $data["descripcionpoderAlta"],
                'regionMorelia'     => $regionmorelia,
                'regionUruapan'     => $regionuruapan,
                'regionZamora'      => $regionzamora,
            );
            $nombre_ine = $data["nombresAbogadoAlta"]."".$data["primer_apellido"]."".$data["segundo_apellido"]."-".$data["empresaAbogadoAlta"]."_IDENTIFICACION.pdf";
            $path = Storage::putFileAs(
                'documentos_abogados', $request->file('documentoIne'), $nombre_ine
            );
            $nombre_representación = $data["nombresAbogadoAlta"]."".$data["primer_apellido"]."".$data["segundo_apellido"]."-".$data["empresaAbogadoAlta"]."_REPRESENTACION.pdf";
            $path = Storage::putFileAs(
                'documentos_abogados', $request->file('documentoRepresentacion'), $nombre_representación
            );
            //Si no existe
            if(!isset($data["documentoAnexo"])){
                $nombre_anexo = "Sin anexo";
            }
            else{
                $nombre_anexo = $data["nombresAbogadoAlta"]."".$data["primer_apellido"]."".$data["segundo_apellido"]."-".$data["empresaAbogadoAlta"]."_ANEXO.pdf";
               $path = Storage::putFileAs(
                    'documentos_abogados', $request->file('documentoAnexo'), $nombre_anexo
                );
            }

            if(!isset($data["documentoPoder"])){
                $nombre_poder = "Sin carta poder";
            }
            else{
                $nombre_poder = $data["nombresAbogadoAlta"]."".$data["primer_apellido"]."".$data["segundo_apellido"]."-".$data["empresaAbogadoAlta"]."_PODER.pdf";
                $path = Storage::putFileAs(
                    'documentos_abogados', $request->file('documentoPoder'), $nombre_poder
                );
            }

            $data_insertar["ine"] = $nombre_ine;
            $data_insertar["cedula"] = $nombre_poder;
            $data_insertar["anexo"] = $nombre_anexo;
            $data_insertar["representacion"] = $nombre_representación;

            $nuevoAbogado = Poder::create($data_insertar);
        }    
         
        $A_citado=SeerCitados::find($data['id_citado_2'])->update(['id_abogado' => $nuevoAbogado->idAbogado]);
        return back()->with('success', 'Representante legal registrado y asignado correctamente al citado.');
    }

    public function insertar_citado_audiencia(Request $request){
        $data = $request->all();
        //$citados = SeerCitados::find($data["id_citado_pf"]);
       
        $data_insertar= array(
            'id_solicitud'              => $data["id"],
            'id_citado'                 => $data["id_citado_pf"],
            'nombre'                    => $data["nombre"],
            'primer_apellido'           => $data["primer_apellido"], 
            'segundo_apellido'          => $data["segundo_apellido"],
            'identificacion'            => $data["identificacionAlta"],
        );
        
        $documento = $data["nombre"]."-".$data["primer_apellido"]."-".$data["segundo_apellido"]."_Identificacion.pdf";
        $path = Storage::putFileAs(
            'documentosSolicitud', $request->file('documentoIdentificacion'), $documento
        );
        $data_insertar["documentoIdentificacion"] = $documento;

        PersonaFisica::create($data_insertar);   
        $id_adiencia = PersonaFisica::select('id')->orderBy('id', 'desc')->first();
        SeerCitados::find($data['id_citado_pf'])->update([
            'id_fisica'         => $id_adiencia["id"],
            'nombre'            => $data["nombre"],
            'primer_apellido'   => $data["primer_apellido"], 
            'segundo_apellido'  => $data["segundo_apellido"]
        ]);

        return back()->with('success', 'Representante legal registrado y asignado correctamente al citado.');
    }

    public function actualiza_citados_audiencia(Request $request){
        $data = $request->all();

        SeerCitados::find($data['id_citado_pf'])->update([
            'nombre'            => $data["nombre"],
            'primer_apellido'   => $data["primer_apellido"], 
            'segundo_apellido'  => $data["segundo_apellido"]
        ]);

        return back()->with('success', 'Nombre del Citado Actualizado Correctamente.');
    }

    public function concepto_eliminar_pago($id_solicitud){
        Concepto::find($id_solicitud)->delete();
        return back()->with('success', 'Pago Borrado Correctamente.');
    }

    public function pago_eliminar_pago($id_solicitud){
        Pagos::find($id_solicitud)->delete();
        return back()->with('success', 'Pago Borrado Correctamente.');
    }
    
    public function terminar_audiencia(Request $request){
        $data = $request->all();
        $id_solicitud = $data["id"];
        $monto = 0;
        $fecha_actual = date('y-m-d');
        $id = auth()->user()->id;
        $user = User::find($id);
        
        if($data["conclucion"] == "Conciliacion"){
            //Revisar si existe
            if(isset($data["dias_pagos"])){
                $conteo = count($data["dias_pagos"]);
                for($i = 0; $i < $conteo; $i++) {
                    $data_pagos = [
                        'id_solicitud'  => $data["id"],
                        'fecha'         => $data["dias_pagos"][$i],
                        'hora'          => $data["hora_pagos"][$i], 
                        'monto'         => $data["monto_pagos"][$i], 
                        'descripcion'   => $data["descripcion_pagos"][$i],
                        'estatus'       => "Pendiente", 
                        'tipo_pago'     => "Audiencia"
                    ];
                    $monto = $monto + $data["monto_pagos"][$i];
                    Pagos::create($data_pagos);
                }
            }
            //Validar si existe un pago extra
            if(isset($data["tipo_pago"])){
                $cont = count($data["monto_pago"]);
                for($i = 0; $i < $cont; $i++) {
                    $data_citado = [
                        'id_solicitud'  => $data["id"], 
                        'monto'         => $data["monto_pago"][$i], 
                        'descripcion'   => $data["tipo_pago"][$i],
                        'tipo_pago'     => "Audiencia"
                    ];
                    Concepto::create($data_citado);
                }
            }
            
            //Actualizar Audiecia
            SeerPerConciliador::where('id_solicitud',$data["id"])
            ->orderBy('id', 'desc')
            ->first()
            ->update([
                'tipo'                      =>  $data["tipo_audiencia"],
                'resolicion_primera'        =>  $data["primera"],
                'resolicion_justificacion'  =>  $data["justificacion"],
                'resolicion_segunda'        =>  $data["segunda"],
                'conclucion'                =>  $data["conclucion"],
                'vacaciones'                =>  $data["vacaciones"],
                'aguinaldo'                 =>  $data["aguinaldo"],
                'otros'                     =>  $data["otros"],
                'horario'                   =>  $data["horario"],
                'comida'                    =>  $data["comida"],
                'tipo_audiencia'            =>  $data["tipo_audiencia"],
            ]);

            SeerPerGeneral::find($data["id"])
            ->update([
                'tipo'                  => $data["tipo_audiencia"],
                'fecha_terminacion'     => $fecha_actual, 
                'conciliador_id'        => $user->id,
                'estatus'               => $data["conclucion"]
            ]);
        }
        else{
            //$solicitante = SeerSolicitante::where('id_solicitud',$data["id"])->first();
            //Actualizar Audiecia
            SeerPerConciliador::where('id_solicitud',$data["id"])
            ->orderBy('id', 'desc')
            ->first()
            ->update([
                'tipo'                      =>  $data["tipo_audiencia"],
                'resolicion_primera'        =>  $data["primera"],
                'resolicion_justificacion'  =>  $data["justificacion"],
                'resolicion_segunda'        =>  $data["segunda"],
                'conclucion'                =>  $data["conclucion"],
                'vacaciones'                =>  $data["vacaciones"],
                'aguinaldo'                 =>  $data["aguinaldo"],
                'otros'                     =>  $data["otros"],
                'horario'                   =>  $data["horario"],
                'comida'                    =>  $data["comida"],
                'tipo_audiencia'            =>  $data["tipo_audiencia"],
            ]);

            SeerPerGeneral::find($data["id"])
            ->update([
                'tipo'                  => "Presencial",
                'fecha_terminacion'     => $fecha_actual, 
                'conciliador_id'        => $user->id,
                'estatus'               => $data["conclucion"]
            ]);
        }

        return redirect()->route('todas_audiencias');
        
    }

    //Crear un cumplimiento desde la agenda
    public function crear_cumplimiento(){
        return view('cumplimientos/crearEnAgenda');
    }


    public function guardar_cumplimiento(Request $request){
        $data = $request->all();
        $id = auth()->user()->id;

        $request->validate([
            'NUE'           => 'required',
            'empresa'       => 'required',
            'trabajador'    => 'required',
            'monto'         => 'required|numeric',
            'forma_pago'    => 'required',
            'sede'          => 'required',
            'fecha'         => 'required',
            'hora'          => 'required',
            'descripcion'   => 'required'
        ]);
            
        $data_insert=array(
            'id_solicitud'          => 0,
            'fecha'                 => $data["fecha"],
            'hora'                  => $data["hora"],
            'monto'                 => $data["monto"],
            'descripcion'           => $data["descripcion"],
            'estatus'               => "Pendiente",
            'tipo_pago'             => "Audiencia",
            'delegacion'            => $data["sede"],
            'id_conciliador'        => $id,
            'NUE'                   => $data["NUE"],
            'empresa_representante' => $data["empresa"],
            'nombre_trabajador'     => $data["trabajador"],
            'forma_pago'            => $data["forma_pago"],
        );

        Pagos::create($data_insert);

        return back()->with('success', 'Poder registrado correctamente.'); 
        //return view('cumplimientos/index')->with('success', 'Poder registrado correctamente.'); 
    }


    public function obtenerCumplimientos(Request $request)
    {
        $fecha_inicio = now()->subDays(20)->format('Y-m-d');
        $fecha_fin = now()->addDays(700)->format('Y-m-d');
        $sede = $request->input('sede'); // Obtener sede de la solicitud

        $inhabiles = DiasInhabiles::where('centro', $sede)->get(); //Obtenemos días inhabiles

        // 1. Obtener turnos ocupados filtrando por sede

        $pagos = Pagos::where('tipo_pago','Audiencia')->get();
        $ocupados = Pagos::whereBetween('fecha', [$fecha_inicio, $fecha_fin])
            ->where('delegacion', $sede)
            ->get();
        $ocupadosMap = [];
        foreach ($ocupados as $cumplimiento) {
            $slotKey = date_format($cumplimiento->fecha, 'Y-m-d') . 'T' . date_format($cumplimiento->hora,'H:i:s');
            $ocupadosMap[$slotKey] = true;
        }

        // 2. Crear slots disponibles
        $todosLosEventos = [];
        $fecha = new \DateTime($fecha_inicio);
        $fin = new \DateTime($fecha_fin);

        while ($fecha <= $fin) {
            if ($fecha->format('N') < 6) { // Saltar fines de semana
                // Definir inicio y fin de la jornada
                $inicioJornada = (clone $fecha)->setTime(9, 0, 0);
                $finJornada    = (clone $fecha)->setTime(15, 0, 0);

                // Recorremos cada 30 minutos
                $slot = clone $inicioJornada;
                while ($slot < $finJornada) {
                    $slotStart = $slot->format('Y-m-d\TH:i:s');
                    $ahora = new \DateTime();
                    $currentCita = new \DateTime($slotStart);


                    // Verificar si está ocupado
                    $ocupado = isset($ocupadosMap[$slotStart]);

                    $esInhabil = false;
                    foreach($inhabiles as $dia){
                        $fechaInhabilInicio = $dia->fecha_inicio . 'T' . $dia->horario_inicio;
                        $fechaInhabilFinal = $dia->fecha_final . 'T' . $dia->horario_final;
                        if($slotStart >= $fechaInhabilInicio && $slotStart <= $fechaInhabilFinal){
                            $esInhabil = true;
                        }
                    }

                    // Determinar el estado
                    $estado = '';
                    if ($ocupado) {
                        $estado = 'ocupado';
                    } elseif ($esInhabil) {
                        $estado = 'inhabil';
                    } elseif ($ahora > $currentCita) {
                        $estado = 'expirado';
                    } else {
                        $estado = 'disponible';
                    }

                    switch ($estado) {
                        case 'ocupado':
                            $todosLosEventos[] = [
                                'title' => 'Ocupado',
                                'start' => $slotStart,
                                'color' => '#DA0909',
                                'extendedProps' => ['estado' => 'ocupado']
                            ];
                            break;
                        case 'inhabil':
                            $todosLosEventos[] = [
                                'title' => 'Inhábil',
                                'start' => $slotStart,
                                'color' => '#3B78DB',
                                'extendedProps' => ['estado' => 'inhabil']
                            ];
                            break;
                        case 'expirado':
                            $todosLosEventos[] = [
                                'title' => 'Expirado',
                                'start' => $slotStart,
                                'color' => '#F59727',
                                'extendedProps' => ['estado' => 'expirado']
                            ];
                            break;
                        case 'disponible':
                        default:
                            $todosLosEventos[] = [
                                'title' => 'Disponible',
                                'start' => $slotStart,
                                'color' => '#00CE1C',
                                'extendedProps' => ['estado' => 'disponible']
                            ];
                            break;
                    }

                    // Avanzar 30 minutos
                    $slot->modify('+30 minutes');
                }
            }

            // Avanzar al siguiente día
            $fecha->modify('+1 day');
        }

        return response()->json($todosLosEventos);
    }

    public function cumplimiento_incomparecencia(Request $request, $id){
        $request->validate([
            'fecha_audiencia' => 'required|date',
            'hora_audiencia'  => 'required',
        ]);
        $pago = Pagos::find($id);
        $pago->update([
            'estatus'         => "Incomparecencia trabajador",
            'fecha_audiencia' => $request->fecha_audiencia,
            'hora_audiencia'  => $request->hora_audiencia,
        ]);
    
        $id_solicitud = $pago->id_solicitud;
        Pagos::find($id_solicitud)?->update(['estatus' => "Incomparecencia trabajador"]);
        
        return redirect()->route('agenda');  
        /*Así estab antes de los cambios en los cumplimientos*/ 
        /*Pagos::find($id)->update(['estatus'  => "Incomparecencia trabajador"]);

        return redirect()->route('agenda');*/
    }

    public function PDFIncomparecenciaCumplimiento($id){
        $pagos = Pagos::find($id);

        if($pagos["id_solicitud"] == 0){
            $solicitud = Pagos::find($id);
            //$salario_diario = 0;
            $conciliador  = User::join("pago_solicitud","pago_solicitud.id_conciliador","=","users.id");
            $conciliador = $conciliador->where("pago_solicitud.id", "=", $id)
            ->select('users.name')
            ->first();
            $html = view('PDF/cumplimientos/incomparecenciaTrabajador', compact('id', 'solicitud','conciliador',/*'salario_diario',*/'pagos'))->render();
        }
        else{
            $solicitud = SeerSolicitante::where('id_solicitud',$id)->first();
            $pagos = Pagos::find($id);
            //$salario_diario = $this->calcularSalarioDiario($solicitud->pago, $solicitud->periodo_pago);

            $conciliador  = User::join("seer_general","seer_general.conciliador_id","=","users.id");
            $conciliador = $conciliador->where("seer_general.id", "=", $id)
            ->select('users.name')
            ->first();
            $html = view('PDF/cumplimientos/incomparecenciaTrabajador', compact('id','solicitud','conciliador',/*'salario_diario',*/'pagos'))->render();
        }
       
        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true); 

        $nombreArchivo = 'constancia_de_incomparecencia_'  .'.pdf';
        return $pdf->stream($nombreArchivo);      
    }

    public function reporte_diario(){
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $fecha_actual = date('y-m-d');

        $usuario = $user["name"];
        //SOLICITUDES
        $solicitudes  = SeerPerGeneral_old::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general_old.id");
        $solicitudes = $solicitudes->where("fecha","=",$fecha_actual);
        $solicitudes = $solicitudes->where("seer_general_old.user_id", $id);
        $solicitudes = $solicitudes->where("seer_auxiliares.tipo_solicitud", "Solicitud")
        ->select('seer_general_old.fecha','seer_general_old.solicitante','seer_auxiliares.motivo','seer_auxiliares.actividad_economica','seer_auxiliares.notificacion')
        ->get();

        //RATIFICACIONES
        $ratificaciones  = SeerPerGeneral_old::join("seer_auxiliares","seer_auxiliares.id_solicitud","=","seer_general_old.id");
        $ratificaciones  = $ratificaciones->where("fecha","=",$fecha_actual);
        $ratificaciones  = $ratificaciones->where("seer_general_old.user_id", $id);
        $ratificaciones  = $ratificaciones->where("seer_auxiliares.tipo_solicitud", "Ratificación");
        $ratificaciones   = $ratificaciones->select('seer_general_old.fecha','seer_general_old.solicitante','seer_auxiliares.motivo','seer_auxiliares.actividad_economica',
        'seer_auxiliares.monto','seer_auxiliares.notificacion')
        ->get();

        //CONVENIOS
        $convenios = SeerConvenios::join("seer_general_old","seer_convenios.NUE","=","seer_general_old.NUE");
        $convenios = $convenios->where("seer_convenios.fecha","=",$fecha_actual);
        $convenios = $convenios->where("seer_convenios.user_id", $id);
        $convenios = $convenios->select('seer_convenios.fecha','seer_convenios.NUE','seer_convenios.tipo_pago','seer_convenios.monto')
        ->get();

        //ASESORIAS
        $asesorias = SeerAsesoria::where("fecha","=",$fecha_actual);
        $asesorias = $asesorias->where("seer_asesorias.id_usuario", $id);
        $asesorias = $asesorias->select('seer_asesorias.nombre', 'seer_asesorias.sexo')
        ->get();

        $pdf = \PDF::loadView('PDF/reporte-diario', compact('solicitudes','ratificaciones','convenios','asesorias','usuario'));
            
        return $pdf->stream('archivo.pdf');
    }

    public function misestadisticas(){
        return view('estadisticas.mis_estadisticas');
    }

    public function estadisticasPDF(Request $request){
        $data = $request->all();
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $fecha_inicial = $data["fecha_inicial"];
        $fecha_final = $data["fecha_final"];

        if($userRole[0] == "Auxiliar"){
            $Ratificacion = Turnos::whereBetween('fecha',[$fecha_inicial,$fecha_final])
            ->join('users','users.id','turnos.id_conciliador')
            ->join('users as user_usuario','user_usuario.id','turnos.user_id')
            ->where('turnos.delegacion',$user["delegacion"])
            ->where('turnos.user_id',$user["id"])
            ->select('turnos.*','users.name','user_usuario.name as auxiliar')
            ->get();
            
            $pdf = \PDF::loadView('PDF/Estadisticas/Ratificaciones',compact('fecha_inicial','fecha_final','Ratificacion'));
            $pdf->setPaper('a4', 'landscape');
            return $pdf->stream('archivo.pdf');
        }
        else if($userRole[0] == "Cumplimientos"){+
            $pagosAudiencias = Pagos::whereBetween('fecha',[$fecha_inicial,$fecha_final])
            ->join('users','users.id','pago_solicitud.id_conciliador')
            ->where('pago_solicitud.tipo_pago',"Audiencia")
            ->selectRaw('count(pago_solicitud.id) as audiencias')
            ->first();
            $pagosAudienciasMonto = Pagos::whereBetween('fecha',[$fecha_inicial,$fecha_final])
            ->join('users','users.id','pago_solicitud.id_conciliador')
            ->where('pago_solicitud.tipo_pago',"Audiencia")
            ->selectRaw('sum(pago_solicitud.monto) as audienciasMonto')
            ->first();

            $Audiencias = Pagos::whereBetween('fecha',[$fecha_inicial,$fecha_final])
            ->where('sede',$sede)
            ->join('users','users.id','pago_solicitud.id_conciliador')
            ->where('pago_solicitud.tipo_pago',"Audiencia")
            ->get(); 
            

            $pdf = \PDF::loadView('PDF/Estadisticas/reporte-miscumplimientos', compact('fecha_inicial','fecha_final','pagosAudienciasMonto','pagosAudiencias','Audiencias'));
            $pdf->setPaper('a4', 'landscape');
            return $pdf->stream('archivo.pdf');
        }
    }

    public function exportarExcel(){
        return Excel::download(new CitasExport, 'pagos.xlsx');
    }
    
    public function todas_audiencias(){
        $audiencias = Audiencias::orderBy('created_at', 'desc')->limit(500)->get();
        foreach ($audiencias as $audiencia) {
            $solicitante = SeerSolicitante::where('id_solicitud', $audiencia->id_solicitud)->first();
            $audiencia->nombre = $solicitante ? $solicitante->nombre : 'Sin solicitante';
            $expediente = SeerPerGeneral::find($audiencia->id_solicitud);
            $audiencia["NUE"] = $expediente ? $expediente->NUE : 'Sin Expediente';
            $audiencia["estatus"] = $expediente ? $expediente->estatus : 'Algo';
            $audiencia["fecha"] = date('Y-m-d', strtotime($audiencia["fecha"]));
            $audiencia["hora"] = date('H:i:s', strtotime($audiencia["hora"]));
            $conciliador = User::where("id",$audiencia["id_conciliador"])->select("name")->first();
            $audiencia->conciliador = $conciliador ? $conciliador->name : 'Sin Conciliador';
        }

        return view('audiencias.todas_audiencias',compact('audiencias'));
    }

    public function todas_solicitudes(){
        $solicitudes = SeerPerGeneral::orderBy('created_at', 'desc')->limit(500)->get();
        foreach ($solicitudes as $solicitud) {
            $solicitante = SeerSolicitante::where('id_solicitud', $solicitud->id)->first();
            $solicitud->nombre = $solicitante ? $solicitante->nombre : 'Sin solicitante';
        }
        return view('solicitudes.solicitudes_todas',compact('solicitudes'));
    }

    public function todas_ratificaciones(){
        $solicitudes = Turnos::where('tipo','Ratificación')
        ->orderBy('created_at', 'desc')->limit(500)->get();
        foreach ($solicitudes as $audiencia) {
            $pendientes = Pagos::where('id_solicitud',$audiencia["id"])
            ->where('estatus',"Pendiente")
            ->where('tipo_pago',"Ratificacion")
            ->get();
            if(count($pendientes) == 0){
                //Si la contancia es 0 no tiene pagos pendientes
                $audiencia->constancia = 0;
            }
            else{
                $audiencia->constancia = 1;
            }
        }

        return view('ratificaciones.ratificaciones_todas',compact('solicitudes'));
    }

    public function mostrar_citado(Request $request){
        $data = $request->all();
        $id = $data["id"];

        $municipios = Municipios::all();
        $estados = Estados::all();
        $folio = SeerCitados::find($id);
        return view('/notificaciones/ver_citado_historial',compact('folio','estados','municipios'));
    }


    public function editar_citados_historial(Request $request){
        $data = $request->all();
        
        $id_usuario = auth()->user()->id;
        $user = User::find($id_usuario);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $folio = SeerCitados::find($data["id"]);
        
        if ($request->hasFile('foto1')) {
            $imagen_domicilio1 = $data["id"] . "-domicilio_Citado1.jpg";
            Storage::putFileAs('documentosSolicitud', $request->file('foto1'), $imagen_domicilio1);
            $foto1 = $imagen_domicilio1;
        } else {
            $foto1 = $folio->imagen_domicilio1;
        }
        
        if ($request->hasFile('foto2')) {
            $imagen_domicilio2 = $data["id"] . "-domicilio_Citado2.jpg";
            Storage::putFileAs('documentosSolicitud', $request->file('foto2'), $imagen_domicilio2);
            $foto2 = $imagen_domicilio2;
        } else {
            $foto2 = $folio->imagen_domicilio2;
        }
        $data_update = SeerCitados::find($data["id"])
        ->update([
            'tipo_persona'             => $data["tipo"],
            'curp'                     => $data["curp"],
            'rfc'                      => $data["rfc"],
            'nombre'                   => $data["nombre"],
            'primer_apellido'          => $data["primer_apellido"],
            'segundo_apellido'         => $data["segundo_apellido"],
            'colonia'                  => $data["colonia"],
            'cp'                       => $data["cp"],
            'calle1'                   => $data["calle1"],
            'calle2'                   => $data["calle2"],
            'n_ext'                    => $data["exterior"],
            'n_int'                    => $data["interior"],
            'tipo_vialidad'            => $data["vialidad"],
            'calle'                    => $data["calle"],
            'municipio_citado'         => $data["municipio_citado"],
            'referencia'               => $data["referencia"],
            'imagen_domicilio1'        => $foto1,
            'imagen_domicilio2'        => $foto2,
        ]);

        if($data["estatus"] == "Sin asignar"){
            $data_update = SeerCitados::find($data["id"])
            ->update(['estatus' => $data["estatus"], 'id_notificador' => 0]);
        }
        else{
            $data_update = SeerCitados::find($data["id"])
            ->update(['estatus' => $data["estatus"]]);
        }
        /*
        $fecha_inicio = $data["fecha_inicio"];
        $fecha_fin = $data["fecha_final"];
        $id = auth()->user()->id;
        //$user = User::find($id);
        //$roles = Role::pluck('name','name')->all();
        //$userRole = $user->roles->pluck('name')->all();
        //$fecha_actual = date('y-m-d');
        $personas = User::whereHas('roles', function ($query) {
            return $query->where('name', '=', 'Notificador');
        })
        ->where('delegacion', $user["delegacion"])
        ->get();

        $notificaciones = SeerPerGeneral::join('seer_citados','seer_citados.id_solicitud','=','seer_general.id')
        ->leftJoin('users', 'seer_citados.id_notificador', '=', 'users.id')
        ->select('seer_general.id as id_solicitud','seer_citados.id as id_citado','seer_general.NUE',
            'seer_citados.nombre','seer_citados.primer_apellido','seer_citados.segundo_apellido',
            'seer_citados.colonia','seer_citados.calle','seer_citados.n_ext','seer_citados.n_int','seer_citados.estatus','seer_citados.tipo_notificacion','users.name as notificador_nombre')
        ->where('seer_general.delegacion', $user["delegacion"])
        //->where('seer_citados.id_notificador', '!=', 0)
        ->where('seer_citados.notificacion',"!=", "Trabajador")
        ->whereBetween('seer_general.fecha', [$data["fecha_inicio"], $data["fecha_final"]])
        ->get();
        */
        return redirect()->route('notificaciones_consultar');   
        //return view('notificaciones.index_busqueda',compact('notificaciones','personas','userRole','fecha_inicio','fecha_fin'));
    }

    public function hitorialnotificacador(){
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();

        $mis_notificaciones  = SeerPerGeneral::where('seer_citados.id_notificador', $id)
        ->join('seer_citados','seer_citados.id_solicitud','=','seer_general.id')
        ->join('seer_solicitante','seer_solicitante.id_solicitud','=','seer_general.id')
        ->join('municipios', 'seer_citados.municipio_citado', '=', 'municipios.id')
        ->where('seer_citados.estatus', "!=", 'Pendiente')
        ->select('seer_citados.id as id_citado','seer_general.NUE','seer_solicitante.nombre as nombre_solicitado','seer_citados.nombre','seer_citados.primer_apellido',
        'seer_citados.segundo_apellido','municipios.nombre as municipio_citado','seer_citados.colonia','seer_citados.calle',
        'seer_citados.n_ext','seer_citados.estatus','seer_citados.tipo_notificacion','seer_citados.id_solicitud as id_solicitud')
        ->orderBy('seer_citados.created_at', 'desc')
        ->limit(500)
        ->get();

        return view('notificaciones.indexHitorial',compact('mis_notificaciones'));
    }

        public function todas_notificaciones(){
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();

        $mis_notificaciones  = SeerPerGeneral::join('seer_citados','seer_citados.id_solicitud','=','seer_general.id')
        ->leftJoin('users', 'seer_citados.id_notificador', '=', 'users.id')
        ->join('seer_solicitante','seer_solicitante.id_solicitud','=','seer_general.id')
        ->join('municipios', 'seer_citados.municipio_citado', '=', 'municipios.id')
        ->where('seer_citados.estatus', "!=", 'Pendiente')
        ->select('seer_citados.id as id_citado','seer_general.NUE','seer_solicitante.nombre as nombre_solicitado','seer_citados.nombre','seer_citados.primer_apellido',
        'seer_citados.segundo_apellido','municipios.nombre as municipio_citado','seer_citados.colonia','seer_citados.calle',
        'seer_citados.n_ext','seer_citados.estatus','seer_citados.tipo_notificacion','seer_citados.id_solicitud as id_solicitud','seer_general.id as id','users.name as notificador_nombre')
        ->orderBy('seer_citados.created_at', 'desc')
        ->limit(500)
        ->get();

        return view('notificaciones.indexHitorial',compact('mis_notificaciones'));
    }

    public function genera_cumplimiento(){
         return view('cumplimientos.crear');
    }

    public function guardar_cumplimiento_cumplimientos(Request $request){
        $data = $request->all();
        $id = auth()->user()->id;

        $request->validate([
            'NUE'           => 'required',
            'empresa'       => 'required',
            'trabajador'    => 'required',
            'monto'         => 'required|numeric',
            'forma_pago'    => 'required',
            'sede'          => 'required',
            'fecha'         => 'required',
            'hora'          => 'required',
            'descripcion'   => 'required'
        ]);
            
        $data_insert=array(
            'id_solicitud'          => 0,
            'fecha'                 => $data["fecha"],
            'hora'                  => $data["hora"],
            'monto'                 => $data["monto"],
            'descripcion'           => $data["descripcion"],
            'estatus'               => "Pendiente",
            'tipo_pago'             => "Audiencia",
            'delegacion'            => $data["sede"],
            'id_conciliador'        => $id,
            'NUE'                   => $data["NUE"],
            'empresa_representante' => $data["empresa"],
            'nombre_trabajador'     => $data["trabajador"],
            'forma_pago'            => $data["forma_pago"],
        );

        Pagos::create($data_insert);

        return back()->with('success', 'Poder registrado correctamente.'); 
        //return view('cumplimientos/index')->with('success', 'Poder registrado correctamente.'); 
    }

    public function cumplimientos_conciliadores(){
         return view('cumplimientos.crearConciliador');
    }

    public function guardar_cumplimiento_conciliadores(Request $request){
        $data = $request->all();
        $id = auth()->user()->id;

        $request->validate([
            'NUE'           => 'required',
            'empresa'       => 'required',
            'trabajador'    => 'required',
            'monto'         => 'required|numeric',
            'forma_pago'    => 'required',
            'sede'          => 'required',
            'fecha'         => 'required',
            'hora'          => 'required',
            'descripcion'   => 'required'
        ]);
            
        $data_insert=array(
            'id_solicitud'          => 0,
            'fecha'                 => $data["fecha"],
            'hora'                  => $data["hora"],
            'monto'                 => $data["monto"],
            'descripcion'           => $data["descripcion"],
            'estatus'               => "Pendiente",
            'tipo_pago'             => "Conciliador",
            'delegacion'            => $data["sede"],
            'id_conciliador'        => $id,
            'NUE'                   => $data["NUE"],
            'empresa_representante' => $data["empresa"],
            'nombre_trabajador'     => $data["trabajador"],
            'forma_pago'            => $data["forma_pago"],
        );

        Pagos::create($data_insert);

        return back()->with('success', 'Poder registrado correctamente.'); 
        //return view('cumplimientos/index')->with('success', 'Poder registrado correctamente.'); 
    }

    //PDF Constancia de cumplimiento
    public function PDFcumplimientoParcial($id){
        $pagos = Pagos::find($id);

        if($pagos["id_solicitud"] == 0){
            $solicitud = Pagos::find($id);
            $conciliador  = User::join("pago_solicitud","pago_solicitud.id_conciliador","=","users.id");
            $conciliador = $conciliador->where("pago_solicitud.id", "=", $pagos["id"])
            ->select('users.name')
            ->first();
            $html = view('PDF/Cumplimientos/pagosParciales', compact('id', 'solicitud','conciliador','pagos'))->render();
        }else{
            $solicitud = SeerPerGeneral::find($pagos["id_solicitud"]);
            $conciliador  = User::join("seer_general","seer_general.conciliador_id","=","users.id")
            ->where("seer_general.id", "=", $solicitud["id"])
            ->select('users.name')
            ->first();
            $html = view('PDF/Solicitudes/pagosParciales', compact('id', 'solicitud','conciliador','pagos'))->render();
        }

        $pdf = \PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isPhpEnabled', true); 

        $nombreArchivo = 'constancia_de_cumplimiento_' . $solicitud->trabajador .'.pdf';
        return $pdf->stream($nombreArchivo);                  
    }

    public function ver_pagos_audiencia($id){
        $cumplimientos = Pagos::join('seer_general','seer_general.id',"=",'pago_solicitud.id_solicitud')
        ->where('pago_solicitud.id_solicitud',$id)
        ->select('pago_solicitud.id','pago_solicitud.id_solicitud','seer_general.NUE','pago_solicitud.fecha','pago_solicitud.hora','pago_solicitud.monto','pago_solicitud.descripcion','pago_solicitud.estatus','pago_solicitud.forma_pago')
        ->get();

        return view('/cumplimientos/pagar_audiencia',compact('cumplimientos'));
    }
}