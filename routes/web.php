<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PDFController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PoderController;
use App\Http\Controllers\CapacitacionController;
use App\Http\Controllers\MiscapacitacionController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\SeerController;
use App\Http\Controllers\TurnosController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\RecepcionController;
use App\Http\Controllers\CitaDireccionController;
use App\Http\Controllers\CorreosController;
use App\Http\Controllers\ConciliadoresController;
use App\Http\Controllers\AdministracionController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SeerPerGeneral;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    //Ruta Raiz
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/logon', function () {
        return view('../public/welcome');
    });

    Route::get('solicitudes',                           [SeerController::class, 'solicitudesLinea'])->name('solicitud');
    Route::get('tipoIndustria/{tipo_solicitud}',        [SeerController::class, 'Industrias'])->name('solicitud.industria');
    Route::get('/registro_tercer_encuentro',            [SeerController::class, 'registro_tercer_encuentro'])->name('registro_tercer_encuentro');
    Route::post('/registro_tercer_encuentro/guardar',   [SeerController::class, 'tercer_encuentro_registro'])->name('tercer_encuentro_registro');
    Route::get('GeneraConstancia',                      [SeerController::class, 'genera_constancia']);
    
    //Rutas para el chat
        Route::post('/chat/crear',      [Controller::class, 'store_chat'])->name('RespuestasChat.store');
        Route::get('chat',              [Controller::class, 'chats'])->name('chat');
        Route::post('/chat/crearUno/',  [Controller::class, 'storeUno'])->name('RespuestasChat.storeUno');

    //Ruta calendario
        Route::get('/calendario', [App\Http\Controllers\CalendarController::class, 'index'])->name('calendario.index');
        Route::get('/citas/eventos', [App\Http\Controllers\CitaController::class, 'citas'])->name('citas.eventos');
        Route::get('/pagos/eventos', [App\Http\Controllers\CitaController::class, 'pagos'])->name('pagos.eventos');
        Route::get('/pagos/conciliadores', [App\Http\Controllers\CitaController::class, 'conciliadores'])->name('conciliador.eventos');
        Route::get('/audiencias/eventos', [App\Http\Controllers\AudienciasController::class, 'audiencias'])->name('audiencias.eventos');
        Route::get('/ratificaciones/eventos', [App\Http\Controllers\AudienciasController::class, 'ratificaciones'])->name('ratificaciones.eventos');
        Route::get('citas/exportar-excel', [CitaController::class, 'exportarExcel']);

    //Rutas fuera del login
    Route::get('/pantalla', function () {
        $fecha_actual = date('Y-m-d');
        $turnos = DB::table('turnos')
        ->leftjoin('users', 'users.id', '=', 'turnos.auxiliar')
        ->select('users.id', 'turnos.id', 'turnos.tipo', 'turnos.auxiliar', 'turnos.lugar_auxiliar')
        ->where('turnos.fecha', $fecha_actual)
        ->where('turnos.estatus', 'no atendido')
        ->limit(10)
        ->paginate(10);

        return view('pantalla', compact('turnos'));
    });

    Route::get('publico',               [HomeController::class, 'publico'])->name('publico');
    Route::get('home',                  [HomeController::class, 'home'])->name('home');
    Route::get('/poder-crear',          [PoderController::class, 'registro'])->name('poder-crear');
    Route::get('/poder',                [App\Http\Controllers\PoderController::class, 'show'])->name('poder');
    Route::post('/poderes/publico',     [PoderController::class, 'publico'])->name('poderes.publico');
    Route::get('/cita_turno',           [HomeController::class, 'citas'])->name('citas');
    Route::post('/turnos_guardar',      [HomeController::class, 'turnos_publico'])->name('turnos_publico'); 
    
    //Rutas de citas
    Route::get('citas',                         [TurnosController::class, 'create_publico'])->name('create_cita');
    Route::post('/citas/store_publico',         [TurnosController::class, 'store_publico'])->name('turnos.publico');
    Route::get('/validar_folio_abogado/{folio}',[TurnosController::class, 'validarFolio'])->name('validar_folio_abogado'); //valida si existe ya un abogado
    Route::get('/Confirmacion/{id}',            [CitaDireccionController::class, 'codigoQR'])->name('revisarCitaQR');

    //Pre registro de solicitudes
    Route::get('registro', [SeerController::class, 'RTemportal'])->name('PreRegistro');
    Route::post('registro_solicitud', [SeerController::class, 'GuardarRTemportal'])->name('guardar_registro_solicitud');
    
    //Solicitudes en línea trabajador
    Route::get('Trabajador/{tipo_solicitud}',   [SeerController::class, 'trabajador'])->name('solicitud_trabajador');
    Route::post('guardar_trabajador',           [SeerController::class, 'solicitud_parte1'])->name('parte1');
    Route::post('solicitud_solicitante',        [SeerController::class, 'solicitud_parte2'])->name('parte2');
    Route::get('vista_solicitante/{id}' ,       [SeerController::class, 'vista_solicitante'])->name('solicitante');
    Route::post('/delegacion/{municipioId}',    [SeerController::class, 'DelegacionPorMunicipio']); //Muestra la delegación que le corresponde según el municipio seleccionado
    //Ruta de agregar citados
    Route::get('/agrega_citado/{id}',           [SeerController::class, 'vista_citado'])->name('agregar_citado');
    Route::post('/agrega_citado',               [SeerController::class, 'guardar_citado'])->name('seer.citados');
    Route::get('/agrega_documento/{id}',        [SeerController::class, 'vista_documentos'])->name('agregar_documentos');
    Route::get('/finaliza/{id}',                [SeerController::class, 'guardar_solicitud'])->name('seer.finaliza');
    
    //Constancias
    Route::post('GeneraConstancia',         [SeerController::class, 'genera_constancia'])->name('generaConstancia');
    Route::post('crear_constancia/',        [SeerController::class, 'crear_constancia'])->name('ValidarConstancia');
    Route::get('Asistencia',                [SeerController::class, 'RegistroPrimeraConferencia']);    
    Route::post('guardar_asitencia',        [SeerController::class, 'guardar_asistencia_post'])->name('guardar_asistencia');
    Route::get('constancia/final',          [SeerController::class, 'enviarConstanciaFinal']); //Genera el envio de la constancia final
    Route::get('generaPDFmasivo',           [SeerController::class, 'generaPDFS']);
    Route::get('constancia_individual',     [SeerController::class, 'constancia_individual']);

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/agenda', [DashboardController::class, 'index'])->name('agenda');
    //Rutas de los menus
        Route::get('/usuarios/index',           [UsuarioController::class, 'index'])->name('usuarios');
        Route::get('/roles/index',              [RolController::class, 'index'])->name('roles');
        Route::get('/capacitaciones/index',     [CapacitacionController::class, 'index'])->name('capacitaciones');
        Route::get('/miscapacitaciones/index',  [MiscapacitacionController::class, 'index'])->name('miscapacitaciones');
        Route::get('/expedientes/index',        [ExpedienteController::class, 'index'])->name('expedientes');
        Route::get('/seer/index',               [SeerController::class, 'index'])->name('seer');
        Route::get('/poderes/index',            [PoderController::class, 'index'])->name('poderes');
        Route::get('/seer/estadistica',         [SeerController::class, 'estadistica'])->name('seer.estadistica');
        Route::get('/turnos/index',             [RecepcionController::class, 'index_turnos'])->name('turnos');
        Route::get('/turnos/misturnos',         [RecepcionController::class, 'misturnos'])->name('misturnos');
        Route::get('/turnos/estadistica',       [TurnosController::class, 'estadistica'])->name('turno_estadistica');
        Route::get('/notificaciones/index',     [SeerController::class, 'notificaciones'])->name('notificaciones');
        Route::get('/solicitudes/home',         [SeerController::class, 'solicitudes'])->name('solicitudes_index');
        Route::get('/ratificaciones/index',     [TurnosController::class, 'index_ratificacion'])->name('index_ratificacion');
    //Fin de ruta de los menus
    //Usuarios
        Route::get('/usuarios/index',           [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/index',           [UsuarioController::class, 'index'])->name('usuarios');
        Route::get('/usuarios/create',          [UsuarioController::class, 'create'])->name('usuarios.create');
        Route::get('/usuarios/edit/{id}',       [UsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::post('/usuarios/store',          [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::patch('/usuarios/update/{post}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/destroy/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    //Fin de usuarios
    //Roles
        Route::get('/roles/index',           [RolController::class, 'index'])->name('roles.index');
        Route::get('/roles/index',           [RolController::class, 'index'])->name('roles');
        Route::get('/roles/create',          [RolController::class, 'create'])->name('roles.create');
        Route::get('/roles/edit/{id}',       [RolController::class, 'edit'])->name('roles.edit');
        Route::post('/roles/guardar',        [RolController::class, 'store_rol'])->name('roles.store');
        Route::patch('/roles/update/{post}', [RolController::class, 'update'])->name('roles.update');
        Route::delete('/roles/destroy/{id}', [RolController::class, 'destroy'])->name('roles.destroy');
    //Fin roles
    //Poder
        Route::get('/poderes/index',           [PoderController::class, 'index'])->name('poderes.index');
        Route::get('/poderes/index',           [PoderController::class, 'index'])->name('poderes');
        Route::get('/poderes/create',          [PoderController::class, 'create'])->name('poderes.create');
        Route::get('/poderes/edit/{id}',       [PoderController::class, 'edit'])->name('poderes.edit');
        Route::post('/poderes/store',          [PoderController::class, 'store'])->name('poderes.store');
        Route::patch('/poderes/update/{post}', [PoderController::class, 'update'])->name('poderes.update');
        Route::delete('/poderes/destroy/{id}', [PoderController::class, 'destroy'])->name('poderes.destroy');
    //Fin Poder
    //Capacitaciones
        Route::get('/capacitaciones/index',                         [CapacitacionController::class, 'index'])->name('capacitaciones.index');
        Route::get('/capacitaciones/index',                         [CapacitacionController::class, 'index'])->name('capacitaciones');
        Route::get('/capacitaciones/create',                        [CapacitacionController::class, 'create'])->name('capacitaciones.create');
        Route::get('/capacitaciones/edit/{id}',                     [CapacitacionController::class, 'edit'])->name('capacitaciones.edit');
        Route::post('/capacitaciones/guardar_capacitacion',         [CapacitacionController::class, 'crear_capacitacion'])->name('crear_capacitacion');
        Route::patch('/capacitaciones/update/{post}',               [CapacitacionController::class, 'update'])->name('capacitaciones.update');
        Route::delete('/capacitaciones/destroy/{id}',               [CapacitacionController::class, 'destroy'])->name('capacitaciones.destroy');

        Route::get('/capacitaciones/personas',                      [CapacitacionController::class, 'personas'])->name('capacitaciones.personas');
        Route::get('/capacitaciones/personas_documentos/{id}',      [CapacitacionController::class, 'personas_documentos'])->name('personas.documentos');
        Route::get('/capacitaciones/modulos/{id}',                  [CapacitacionController::class, 'modulos'])->name('capacitaciones.modulos');
        Route::get('/capacitaciones/crear_modulo/{id}',             [CapacitacionController::class, 'crear_modulo'])->name('capacitaciones.nuevo_modulo');
        Route::get('/capacitaciones/borrar_modulo//{id}/{mod}',     [CapacitacionController::class, 'borrar_modulo'])->name('capacitaciones.borrar');
        Route::get('/capacitaciones/editar_modulo/{id}',            [CapacitacionController::class, 'editar_modulo'])->name('capacitaciones.editar_modulo');
        Route::get('/capacitaciones/editar_encuesta/{id}/{mod}',    [CapacitacionController::class, 'editar_encuesta'])->name('capacitaciones.editar_encuesta');
        Route::get('/capacitaciones/agregar_personas/{id}',         [CapacitacionController::class, 'agregar_personas'])->name('capacitaciones.addpersonas');
        Route::get('/capacitaciones/persona_incluir/{cap}/{per}',   [CapacitacionController::class, 'persona_incluir'])->name('capacitaciones.agregar_persona');
        Route::get('/capacitaciones/persona_quitar/{cap}/{per}',    [CapacitacionController::class, 'persona_quitar'])->name('capacitaciones.quitar_persona');
        Route::get('/capacitaciones/personas_calificacion/{cap}',   [CapacitacionController::class, 'personas_calificacion'])->name('capacitaciones.calificaciones');    
        Route::post('/capacitaciones/guardar_encuesta_editar',      [CapacitacionController::class, 'guardar_encuesta_editar'])->name('capacitaciones.guardar_encuesta_editar');
        Route::post('/capacitaciones/guardar_modulo',               [CapacitacionController::class, 'guardar_modulo'])->name('capacitaciones.crear_modulo');
        Route::post('/capacitaciones/guardar_modulo_editar',        [CapacitacionController::class, 'guardar_modulo_editar'])->name('capacitaciones.editar_modulo_guardar');
        Route::get('/capacitaciones/terminar/{id}',                 [CapacitacionController::class, 'terminar'])->name('capacitaciones.terminado');
        Route::get('/capacitaciones/terminar/{id}',                 [CapacitacionController::class, 'terminar'])->name('capacitaciones.terminado');
    //Fin capacitaciones    
    //Seer
        Route::get('/seer/index',                       [SeerController::class, 'index'])->name('seer.index');
        Route::get('/seer/index',                       [SeerController::class, 'index'])->name('seer');
        Route::get('seer/historial',                    [SeerController::class, 'ver_historial'])->name('persona.historial');
        Route::post('seer/historial',                   [SeerController::class, 'historial'])->name('historial');
        //Rutas de auxiliares
        Route::get('/seer/create',                      [SeerController::class, 'create'])->name('create_consentrado_aux');
        Route::get('/seer/ver',                         [SeerController::class, 'ver_consentrado_aux'])->name('create_consentrado_ver');
        Route::get('/seer/persona_s',                   [SeerController::class, 'create_persona_s'])->name('create_persona_solicitud');
        Route::get('/seer/persona_r',                   [SeerController::class, 'create_persona_r'])->name('create_persona_ratificacion');
        Route::post('/seer/personar',                   [SeerController::class, 'auxiliar_personar'])->name('seer.auxiliar_personar');
        Route::get('/seer/asseria',                     [SeerController::class, 'create_asesoria'])->name('create_asesoria');
        Route::post('/seer/aserorias',                  [SeerController::class, 'store_asesorias'])->name('seer.store_asesoria');
        Route::delete('/seer/destroy/{id}',             [seerController::class, 'destroy'])->name('seer.delete');
        Route::get('/seer/editar/{id}',                 [SeerController::class, 'editar_persona'])->name('edit_persona');
        Route::post('/seer/update_auxiliar',            [SeerController::class, 'update_auxiliar'])->name('update_auxiliar');
        //Rutas de conciliadores
        Route::get('/seer/createCon',                   [SeerController::class, 'create_conciliador'])->name('create_consentrado_con');
        Route::get('/seer/ver',                         [SeerController::class, 'ver_consentrado_con'])->name('ver_consentrado_con');
        Route::get('/seer/personac/{id}',               [SeerController::class, 'crear_audiencia'])->name('create_persona_con');
        Route::post('/seer/personac',                   [SeerController::class, 'conciliador_persona'])->name('seer.conciliador_persona');
        Route::get('/seer/personacon/{id}',             [SeerController::class, 'ver_conciliador'])->name('persona_ver');
        Route::get('/seer/convenios',                   [SeerController::class, 'index_convenios'])->name('index_convenios');
        Route::get('/seer/colectivas',                  [SeerController::class, 'index_colectivas'])->name('index_colectivas');
        Route::get('/seer/convenio',                    [SeerController::class, 'crear_convenio'])->name('convenios_agregar');
        Route::post('/seer/convenioa',                  [SeerController::class, 'store_convenio'])->name('seer.crear_convenio');
        Route::get('/seer/colectiva',                   [SeerController::class, 'crear_colectiva'])->name('colectivas_agregar');
        Route::post('/seer/colectivaa',                 [SeerController::class, 'store_colectiva'])->name('seer.crear_colectivas');
        //Rutas de notificadores
        Route::get('/seer/create',                      [SeerController::class, 'create_notificadores'])->name('create_notificador');
        Route::post('/seer/store_notificador',          [SeerController::class, 'store_notificador'])->name('seer.store_notificador');
        Route::get('/seer/estatus/{id}',                [SeerController::class, 'seer_estatus'])->name('seer.notificador');
        Route::post('/seer/updateNotificador',          [SeerController::class, 'update_notificador'])->name('seer.cambioEstatus');
        Route::get('/notificador/mihistorial',          [SeerController::class, 'hitorialnotificacador'])->name('Historial_Notificacador');
        Route::get('/notificador/historial',            [SeerController::class, 'todas_notificaciones'])->name('todas_notificaciones');
        //Ruta de enlace
        Route::post('/seer/store_enlace',               [SeerController::class, 'store_enlace'])->name('seer.store_enlace');
        Route::get('/notificaciones/consultar/{id}',    [SeerController::class, 'mostrar_citados'])->name('editar_citado');
        Route::get('notificaciones/editar',             [SeerController::class, 'editar_citados'])->name('editar_citado_enlace');  
        Route::post('notificaciones/actualizar',        [SeerController::class, 'editar_citados'])->name('actualizar_enlace');  
        Route::post('/seer/store_auxiliar',             [SeerController::class, 'store_auxiliares'])->name('seer.store_auxiliar');
        Route::post('/seer/store_conciliador',          [SeerController::class, 'store_conciliadores'])->name('seer.store_conciliador');
        Route::post('/seer/store_delegado',             [SeerController::class, 'store_delegado'])->name('seer.store_delegado');
        Route::get('/seer/estadistica',                 [SeerController::class, 'estadistica'])->name('seer.estadistica');
        Route::post('/seer/mostrar',                    [SeerController::class, 'mostrar_reporte'])->name('seer.mostar');
        Route::post('/seer/persona',                    [SeerController::class, 'auxiliar_persona'])->name('seer.auxiliar_persona');
        Route::get('/seer/persona/{id}',                [SeerController::class, 'ver_auxiliar'])->name('seer.estadistica_consultar');
        Route::get('reporte',                           [SeerController::class, 'reporte_diario'])->name('reporte_diario');
        Route::post('/notificacion/editar',             [SeerController::class, 'mostrar_citado'])->name('editar_citado_historial');
        Route::post('notificaciones/actualizarH',       [SeerController::class, 'editar_citados_historial'])->name('actualizar_enlace_hitorial');  
    //Fin Seer
    //Expedientes
        Route::get('/expedientes/index',                        [ExpedienteController::class, 'index'])->name('expedientes.index');
        Route::get('/expedientes/index',                        [ExpedienteController::class, 'index'])->name('expedientes');
        Route::get('/expedientes/edit/{id}',                    [ExpedienteController::class, 'edit'])->name('expedientes.edit');
        Route::get('/expedientes/doc/{id}',                     [ExpedienteController::class, 'documento'])->name('expedientes.documento');
        Route::get('/expedientes/create',                       [ExpedienteController::class, 'create'])->name('expedientes.create');
        Route::post('/expedientes/store',                       [ExpedienteController::class, 'store'])->name('expedientes.store');
        Route::get('/expedientes/documentos/{id}',              [ExpedienteController::class, 'personas_documentos'])->name('expedientes.documentos');
        Route::post('/expedientes/doc',                         [ExpedienteController::class, 'store_documento'])->name('subir_doc');
        Route::delete('/expedientes/destroy/{id}',              [ExpedienteController::class, 'destroy'])->name('expedientes.delete');
    //Fin de Expedientes
    //Turnos
        Route::get('/turnos/index1',             [TurnosController::class, 'index'])->name('turnos.index');
        //Route::get('/turnos/misturnos',          [TurnosController::class, 'misturnos'])->name('misturnos');
        Route::get('/turnos/estadistica',        [TurnosController::class, 'estadistica'])->name('turno_estadistica');
        Route::post('/turnos/mostrar',           [TurnosController::class, 'mostrar'])->name('turnos_mostrar');
        Route::get('/Verpdf/{id}',               [TurnosController::class, 'VerPDF'])->name('PDFratifi');
        Route::get('/Verpdfc/{id}',              [TurnosController::class, 'VerPDFConvenio'])->name('PDFconvenioratificacion');
        Route::get('/Verpdfmulta/{id}',          [TurnosController::class, 'VerPDFMulta'])->name('PDFmultas');
        Route::get('/Verpdfinteres/{id}',        [TurnosController::class, 'VerPDFInteres'])->name('PDFinteres');
        Route::get('/Verpdfcump/{id}',           [TurnosController::class, 'VerPDFCumplimiento'])->name('PDFcumplimientoR');
        Route::get('/VerpdfIncump/{id}',         [TurnosController::class, 'VerPDFIncumplimiento'])->name('PDFincumplimiento');
        Route::get('/VerpdfInParcial/{id}',      [TurnosController::class, 'VerPDFInParcial'])->name('PDFincumplimientoParcial');
        Route::get('/VerpdfPago/{id}',           [TurnosController::class, 'VerPDFPagos'])->name('PDFpagos');
        Route::get('/Verpdfaudiencia/{id}',      [TurnosController::class, 'VerPDFAudiencia'])->name('PDFaudiencia');
        //Route::get('/Verpdfincomparecencia/{id}',[TurnosController::class, 'VerPDFIncomparecencia'])->name('PDFincomparecencia'); //Revisa ANA no existe la función
        Route::get('/pdfincomTrabajador/{id}',   [TurnosController::class, 'VerPDFIncomTrabajador'])->name('PDFincomparecenciaT');  //Incomparecencia por parte del trabajador
        Route::get('turnos/index2',              [TurnosController::class, 'index_empresa'])->name('ratificacion');
        Route::get('turnos/indexr',              [TurnosController::class, 'indexr'])->name('Ratificacion');
        Route::get('turnos/aceptar/{id}',        [TurnosController::class, 'aceptacion'])->name('turno.aceptar');
        Route::post('/turnos/guardar',           [TurnosController::class, 'guardar_rechazo'])->name('rechazar_turnos');
        Route::post('/turnos/archivar',          [TurnosController::class, 'archivar_ratificacion'])->name('archivar_ratificacion');
    //Fin de  turnos
    //Solicitudes
        Route::get('/solicitudes/pedientes',                [SeerController::class, 'solicitudes_pendientes'])->name('solicitudes_pendientes');
        Route::get('/solicitud/index',                      [SeerController::class, 'mis_solicitudes'])->name('mis_solicitudes');
        Route::get('/solicitudes_revisar/{id}',             [SeerController::class, 'solicitudes_pendientes_revisar'])->name('solicitud_revisar');
        Route::get('/solicitudes_editar/{id}',              [SeerController::class, 'solicitudes_pendientes_editar'])->name('solicitud_editar'); 
        Route::post('/confirmar_solicitudes',               [SeerController::class, 'solicitud_confirmar'])->name('confirmar_solicitud');
        Route::get('/eliminar_motivo/{id}/{id_motivo}',     [SeerController::class, 'eliminar_motivo'])->name('eliminar_motivo');
        Route::get('/eliminar_motivo_solicitud/{id}/{id_motivo}',     [SeerController::class, 'eliminar_motivo_solicitud'])->name('eliminar_motivo_solicitud');
        Route::get('/eliminar_motivo_buzon/{id}/{id_motivo}',     [SeerController::class, 'eliminar_motivo_buzon'])->name('eliminar_motivo_buzon');
        Route::get('/solicitude/{id}',                      [SeerController::class, 'regresa_eliminar'])->name('regresa_eliminar');
        Route::post('/solicitud/archivar_audiencia',        [SeerController::class, 'guardar_audiencia_archivo'])->name('archivar_audiencia');
        Route::post('/solicitud/editar',                    [SeerController::class, 'editar_solicitud_con'])->name('editar_solicitud');
        Route::post('/historial/auxiliar',                  [SeerController::class, 'historial_auxiliar'])->name('historial_auxiliar');
        Route::get('/solicitudes/solicitudes',              [SeerController::class, 'solicitudes_todas'])->name('solicitudes_todas');
        Route::post('/audiencia/guardar',                   [SeerController::class, 'concluir_audiencia_conciliador'])->name('concluir_audiencia_conciliador');
        Route::post('/solicitudes/crear/PF',                [SeerController::class, 'citado_personaF'])->name('insertar_citado_PF');
        Route::post('/solicitudes/guardar',                 [SeerController::class, 'guardar_rechazo'])->name('rechazar_solicitud');
        Route::get('/correcion_solicitudes/{id}',           [SeerController::class, 'solicitud_consultarSolicitante'])->name('consulta_solicitante');
        Route::post('/correcion_solicitudes',               [SeerController::class, 'solicitante_edicion'])->name('solicitante_edicion');
        Route::post('/solicitudes/actualiza',               [SeerController::class, 'actualiza_citados'])->name('actualiza_citados');
        Route::get('/solicitudes/historialSolicitante',     [SeerController::class, 'Historial_Solicitante'])->name('historial_solicitante');
        Route::post('/solicitud/guardarCitatoriosT',        [SeerController::class, 'guardar_citatoriosT'])->name('subir_citatoriosT'); //Subir los citatorios entregados por el trabajador ya firmados
    //Fin de Solicitudes
    //PDF Solicitudes    
        Route::get('/Verpdfincompetencias/{id}',                        [SeerController::class, 'VerPDFIncompetencia'])->name('PDFincompetencia');
        Route::get('/Verpdfcs/{id}',                                    [SeerController::class, 'VerPDFConvenioSol'])->name('PDFconveniosolicitud');
        Route::get('/Verpdfacuse/{id}',                                 [SeerController::class, 'PDFacuseSolicitud'])->name('PDFacuse_solicitud');
        Route::get('/Verpdfnotificacion/{id}',                          [SeerController::class, 'PDFnotificacionSolicitante'])->name('PDFnotificacion_solicitante'); 
        Route::get('/Verpdfmulta/{id}/{id_solicitud}',                  [SeerController::class, 'VerPDFMulta'])->name('PDFmulta');       
        Route::get('/solicitud/pdfs/{id}',                              [SeerController::class, 'pdfCitatorio'])->name('PDFSolicitud');
        Route::get('solicitud/consultar/{id}',                          [SeerController::class, 'consultar_solicitudes'])->name('consultar_solicitud');
        Route::get('/audiencias/busqueda/buscar',                       [SeerController::class, 'audiencia_fecha'])->name('audiencia_fecha');
        Route::post('/historial/conciliador/busqueda',                  [SeerController::class, 'historial_conciliador'])->name('historial_conciliador');
        Route::get('/PDF/faltaInteres/{id}',                            [SeerController::class, 'VerPDFInteres'])->name('PDFfalltaInteres');
        Route::get('/Verpdfnoconciliacion/{id}',                        [SeerController::class, 'VerPDFNoConciliacion'])->name('PDFno_conciliacion');
        Route::get('/pdf/estadistica',                                  [PDFController::class, 'pdfEstadistica'])->name('PDFestaditica');
        Route::get('/VerpdfRnotificacion/{id}/{id_solicitud}',          [SeerController::class, 'VerPDFRNotificacion'])->name('PDFRazonNoticacion'); // Notificación exitosa, ATIENDE OTRA PERSONA
        Route::get('/VerpdfNotificacion/{id}/{id_solicitud}',           [SeerController::class, 'PDFnotificadoInstructivo'])->name('PDFInstructivo'); //Notificación por instructivo
        Route::get('/VerpdfNotificacionNoExitosa/{id}/{id_solicitud}',  [SeerController::class, 'PDFnotificadoNoexitosa'])->name('PDFNoExitosa'); //Notificación No exitosa SE CONSTITUYE, CERRADO
        Route::get('/VerpdfNotificacionNoInt/{id}/{id_solicitud}',      [SeerController::class, 'PDFnotificadoNoexitosaInt'])->name('PDFNoExitosaInt'); //Notificación No exitosa NO SE LOCALIZA INTERIOR
        Route::get('/VerpdfcPTU/{id}',                                  [SeerController::class, 'VerPDFConvenioPTU'])->name('PDFconvenioPTU'); //Conevnio por PTU
        Route::get('/pdfsinPoder/{id}',                                 [SeerController::class, 'VerPDFCompareceSinPoder'])->name('PDFcompareceSP'); //Comparece representante legal sin poder
        Route::get('/Verpdfcumpumplimiento/{id}',                       [SeerController::class, 'VerPDFCumplimiento'])->name('PDFcumplimiento');
        Route::get('/VerpdfcumpumplimientoP/{id}',                      [SeerController::class, 'PDFcumplimientoParcial'])->name('PDFcumplimientoParcial');
        Route::get('/solicitudes/descargarCitatorios/{id}',             [SeerController::class, 'descargarCitatorios'])->name('descargarCitatorios'); //Vista para descargar y subircitatorios entregados por el trabajador
        Route::get('/VerpdfacuseConfirmacion/{id}',                     [SeerController::class, 'PDFacuseConfirmada'])->name('PDFacuseConfirmada'); //Acuse de solicitud confirmada
        Route::get('/VerpdfactaAudiencia/{id}',                         [SeerController::class, 'VerPDFAudiencia'])->name('VerPDFAudiencia');
    //Fin de PDF
    //Ratificaciones
        Route::get('/ratificaciones/atender',               [TurnosController::class, 'revisar_ratificaciones_hoy'])->name('ratificacion_atender');
        Route::post('/ratificaciones/buscar',               [TurnosController::class, 'busqueda_ratificaciones'])->name('ratificacion_buscar');
        Route::get('/ratificaciones/concluir/{id}',         [TurnosController::class, 'concluir_ratificaciones'])->name('ratificacion_concluir');
        Route::post('/ratificacion/busqueda',               [TurnosController::class, 'busqueda_ratificaciones'])->name('ratificaciones_busqueda');
        Route::post('/guardar_manifestaciones',             [TurnosController::class, 'guardar_manifestacion'])->name('solicitudes.manidestaciones');
        Route::get('/ratificaciones/pagos/{id}',            [TurnosController::class, 'pagar_ratificacion'])->name('ratificacion_pagar');
        Route::get('/ratificaciones/cumplimietos/{id}',     [TurnosController::class, 'ver_pagos_rati'])->name('ratificacion_cumplimientos');
        Route::post('/ratificaciones/pagoA',                [TurnosController::class, 'pagoA_ratificacion'])->name('ratificacion_pagoA');
        Route::get('/ratificaciones/pagoR/{id}',            [TurnosController::class, 'pagoR_ratificacion'])->name('ratificacion_pagoR');
        Route::get('ratificaciones/consultar/{id}',         [TurnosController::class, 'consultar_ratificaciones'])->name('consultar_ratificacion');
        Route::post('ratificaciones/editar',                [TurnosController::class, 'editar_ratificaciones'])->name('editar_ratificacion');
        Route::get('/PDF/falta_interes/{id}',               [TurnosController::class, 'VerPDFInteres'])->name('PDFfallta_interes');
        Route::get('/ratificaciones/pendientes',            [TurnosController::class, 'ratificacion_confirmadas'])->name('ratificacion_confirmadas'); 
        Route::get('/ratificaciones/pagoIncom/{id}',        [TurnosController::class, 'incomparecencia_rati'])->name('ratificacion_pagoIncom'); //No comparece el trabajador al pago
        Route::get('/ratificaciones/vista_previa/{id_solicitud}',  [TurnosController::class, 'vista_previa_ratificacion'])->name('vista_previa_ratificacion');
        Route::post('/ratificaciones/editarR',               [TurnosController::class, 'editar_ratificacion_revisar'])->name('editar_ratificacion_revisar');
        Route::post('/seleccionar_abogado_ratificacion',    [TurnosController::class, 'seleccionar_abogado_ratificacion'])->name('seleccionar_abogado_ratificacion');
        Route::delete('/ratificaciones/concepto_eliminar_pago/{id_solicitud}',      [TurnosController::class, 'concepto_eliminar_pago_ratificacion'])->name('concepto_eliminar_pago_ratificacion');
        Route::delete('/ratificaciones/deduccion_eliminar_pago/{id_solicitud}',     [TurnosController::class, 'concepto_eliminar_deduccion_ratificacion'])->name('concepto_eliminar_deduccion_ratificacion');
        Route::delete('/ratificaciones/pago_eliminar_pago/{id_solicitud}',          [TurnosController::class, 'pago_eliminar_pago_ratificacion'])->name('pago_eliminar_pago_ratificacion');
        Route::post('/ratificaciones/terminar_ratificacion',   [TurnosController::class, 'terminar_ratificacion'])->name('terminar_ratificacion');
        Route::get('/cumplimiento/PDFIncumplimientoR/{id}',    [TurnosController::class, 'PDFincumplimientoRatificacion'])->name('PDFincumplimientoRatificacion');
    //Fin de Ratificaciones
    //PDF ABOGADOS
        Route::get('/PDF/acuseRegistro/{idAbogado}',        [PoderController::class, 'VerPDFregistroAbogado'])->name('PDFregistroAbogado'); //Acuse de registro exitoso para abogados
    //Fin de PDF
    //Enlace
        Route::get('/notificaciones/consultar/{id}',        [SeerController::class, 'mostrar_citados'])->name('editar_citado');
        Route::post('/notificaciones/editar',               [SeerController::class, 'editar_citados'])->name('editar_citado_enlace');   
        Route::get('/notificaciones/consultar_citado/{id}', [SeerController::class, 'mostrar_citadoC'])->name('consultar_citado');
        Route::get('/notificaciones/historial',             [SeerController::class, 'notificaciones_consultar'])->name('notificaciones_consultar');
        //Route::get('/notificaciones/consulta',              [SeerController::class, 'notificaciones_consultar'])->name('notificaciones_consultar'); 
    //Fin de enlace
    //Notificador
        Route::get('/notificaciones/busqueda',              [SeerController::class, 'notificaciones_consultar'])->name('notificaciones_consultar'); 
        Route::post('/notificaciones/resultado',            [SeerController::class, 'notificaciones_busqueda'])->name('notificaciones_busqueda');
        Route::get('/notificaciones/detalles/{id}',         [SeerController::class, 'seer_detalles'])->name('seer_detalles'); 
    //Fin de Notificador
    //Cambiar las contraseña
        Route::get('/cambio_contraseña/index',  [HomeController::class, 'password_cambiar'])->name('password_cambiar');
        Route::post('/notificaciones/editar',   [HomeController::class, 'contraseña_update'])->name('contraseña_update'); 
    //Administración
        Route::get('administracion/configuracion',          [AdministracionController::class, 'configuracion'])->name('configuracion');
        Route::get('administracion/sedes',                  [AdministracionController::class, 'configuracion_sedes'])->name('configuracion_sedes');
        Route::get('administracion/retrocesos',             [AdministracionController::class, 'genera_retroceso'])->name('genera_retroceso');       
        Route::post('/generar-ratroceso',                   [AdministracionController::class, 'consultar_retroceso'])->name('generar_retroceso'); 
        Route::get('administracion/RC/{id}',                [AdministracionController::class, 'hacer_retroceso_cumplimiento'])->name('accion_retrocesoC');    
        Route::get('administracion/RR/{id}',                [AdministracionController::class, 'hacer_retroceso_ratificacion'])->name('accion_retrocesoR'); 
        Route::post('/bloquear_sede',                       [AdministracionController::class, 'bloqueoSede'])->name('bloqueoSede');  //Bloquear días inhabiles para toda la sede
        Route::post('/bloquear_conciliador',                [AdministracionController::class, 'bloqueoConciliador'])->name('bloqueoConciliador'); //bloquear por días u horas a conciliadores
        Route::delete('/bloqueo/{id}',                      [AdministracionController::class, 'eliminarBloqueo'])->name('eliminarBloqueo'); //eliminar fechas bloqueadas(inhabiles)

    //Fin de Administración  
    //Audiencias
        Route::get('/audiencias/index',                     [SeerController::class, 'audiencia_index'])->name('audiencia_index');
        Route::get('/audiencias_Revisar/{id}',              [SeerController::class, 'solicitud_audiencia_revisar'])->name('solicitud_audiencia');
        Route::get('/citatorio/{id}',                       [SeerController::class, 'pdfCitatorioAudiencia'])->name('pdfCitatorioAudiencia');
        Route::get('/solicitud/indexA',                     [SeerController::class, 'indexA'])->name('audiencias.conciliador'); 
        Route::get('/solicitud/iniciar/{id}',               [SeerController::class, 'iniciar_audiencia'])->name('inicioAudiencia');
        Route::post('/reagendar_audiencia',                 [SeerController::class, 'reagendar_audiencia'])->name('reagendar_audiencia');
        Route::post('/auciencia/concluir/',                 [SeerController::class, 'audiencia_parte2'])->name('audiencia_parte2');
        Route::get('/solicitud/indexB/{id}',                [SeerController::class, 'audienciaParte3'])->name('audiencias.parte3'); 
        Route::post('/solicitud/guardar',                   [SeerController::class, 'concluir_audiencia'])->name('concluir_audiencia');
        Route::post('/seleccionar_abogado',                 [SeerController::class, 'seleccionar_abogado'])->name('seleccionar_abogado');
        Route::post('/incompentencia_audiencia',            [SeerController::class, 'incopentencia_audiencia'])->name('incopentencia_audiencia');
        Route::get('/audieniecias/complimientos',           [SeerController::class, 'audiencias_cumplimiento'])->name('audiencias.cumplimiento');
        Route::post('/audiencia/consulta/solictud',         [SeerController::class, 'solicitudes_busqueda'])->name('solicitudes_busqueda');
        Route::post('/solicitud/guardarExpediente',         [SeerController::class, 'guardar_expediente'])->name('subir_expediente'); //Subir expediente 
        Route::post('/solicitud/guardarExpedienteR',        [TurnosController::class, 'guardar_expediente'])->name('subir_expediente_ratificacion'); //Subir expediente ratificacion
        Route::get('/audieniecias/vista_previa/{id_solicitud}',             [SeerController::class, 'vista_previa'])->name('vista_previa');
        Route::post('/solicitud/editar_audiencia',          [SeerController::class, 'editar_solicitud_audiencia'])->name('editar_solicitud_audiencia');
        Route::post('/seleccionar_abogado_audiencia',       [SeerController::class, 'seleccionar_abogado_audiencia'])->name('seleccionar_abogado_audiencia');
        Route::post('/audieencia/guardar_citadoC',          [SeerController::class, 'insertar_citados_audiencia'])->name('insertar_citados_audiencia');
        Route::post('/audieencia/crear/PF',                 [SeerController::class, 'insertar_citado_audiencia'])->name('insertar_citado_audiencia');
        Route::post('/solicitudes/actualiza_audiencia',     [SeerController::class, 'actualiza_citados_audiencia'])->name('actualiza_citados_audiencia');
        Route::delete('/audieniecias/concepto_eliminar_pago/{id_solicitud}',  [SeerController::class, 'concepto_eliminar_pago'])->name('concepto_eliminar_pago');
        Route::delete('/audieniecias/pago_eliminar_pago/{id_solicitud}',      [SeerController::class, 'pago_eliminar_pago'])->name('pago_eliminar_pago');
        Route::post('/solicitudes/terminar_audiencia',      [SeerController::class, 'terminar_audiencia'])->name('terminar_audiencia');
        Route::get('/audienicas/cumplimietos/{id}',         [SeerController::class, 'ver_pagos_audiencia'])->name('audiencia_cumplimientos');
        Route::post('/guardar_edicion_audiencia',               [SeerController::class, 'audiencia_confirmar'])->name('audiencia_confirmar');
        
    //Fin de Audiencias
    //Citados
        Route::post('/solicitud/guardar_citadoC',           [SeerController::class, 'insertar_citados_con'])->name('insertar_citado');
        Route::get('/solicitud/consultarC',                 [SeerController::class, 'consultar_citados_con'])->name('consultar_citados');
        Route::post('/agregar_citado_edicion',              [SeerController::class, 'agregar_citado_edicion'])->name('agregar_citado_edicion');
        Route::delete('/borrar_citado_edicion',             [SeerController::class, 'borrar_citado_edicion'])->name('borrar_citado_edicion');
        Route::post('/historial/notificador',               [SeerController::class, 'historial_notificador'])->name('historial_notificador');
    //Fin de Citados
    //Cumplimientos
        //Ligas de busqueda
        Route::post('/cumplimiento/busqueda',               [SeerController::class, 'cumplimientos_busqueda'])->name('cumplimientos_busqueda');
        Route::get('/cumplimietos/actual',                  [SeerController::class, 'cumplimiento_actual'])->name('cumplimiento_actual');
        Route::get('/cumplimiento/consulta/{id}/{tipo}',    [SeerController::class, 'consulta_cumplimiento'])->name('consulta_cumplimiento');
        Route::get('/cumplimiento/consultar/{id}/{tipo}',   [SeerController::class, 'consulta_cumplimiento_ratificacion'])->name('consulta_cumplimiento_ratificacion');
        Route::get('/cumplimiento/crear',                   [SeerController::class, 'crear_cumplimiento'])->name('crear_cumplimiento'); //Se crear un cumplimiento desde el menú de cumplimientos
        //Ratificaciones diarias
        Route::post('/cumplimiento/pagar/rati',             [SeerController::class, 'cumplimiento_pagar_rati'])->name('cumplimiento_pagar');
        Route::get('/cumplimiento/rechazar/rati/{id}',      [SeerController::class, 'cumplimiento_rechazar_rati'])->name('cumplimiento_rechazar');
        //Audiencias diarias
        Route::post('/cumplimiento/pagar/audienia',         [SeerController::class, 'cumplimiento_pagar_audiencia'])->name('cumplimiento_pagar_audiencia');
        Route::get('/cumplimiento/rechazara/{id}',          [SeerController::class, 'cumplimiento_rechazar_audiencia'])->name('cumplimiento_rechazar_audiencia');
        //Ratificaciones busqueda
        Route::post('/cumplimientos/consulta',              [SeerController::class, 'cumplimiento_pagar_busqueda_rati'])->name('cumplimiento_pagar_busqueda');
        Route::post('/cumplimiento/rechazar/{id}',          [SeerController::class, 'cumplimiento_rechazar_busqueda_rati'])->name('cumplimiento_rechazar_busqueda');
        Route::get('/cumplimientos/index',                  [SeerController::class, 'audiencias_cumplimiento'])->name('audiencias.cumplimiento');
        //Route::get('/cumplimiento/PDFpago/{id}',            [SeerController::class, 'VerPDFAudiencia'])->name('VerPDFAudiencia');
        Route::get('/cumplimiento/PDFIncumplimiento/{id}',  [SeerController::class, 'PDFincumplimientoAudiencia'])->name('PDFincumplimientoAudiencia');
        Route::post('/cumplimiento/guardar',                [SeerController::class, 'guardar_cumplimiento'])->name('guardar_cumplimiento');
        Route::get('/cumplimiento/incomparecencia/{id}',    [SeerController::class, 'PDFIncomparecenciaCumplimiento'])->name('PDFIncomparecenciaCumplimiento');
        Route::post('/cumplimiento/no_comparece/{id}',      [SeerController::class, 'cumplimiento_incomparecencia'])->name('cumplimiento_incomparecencia');
        Route::get('/cumplimiento/generar',                 [SeerController::class, 'genera_cumplimiento'])->name('genera_cumplimiento');
        Route::post('/cumplimiento/guardar_cumplimiento',   [SeerController::class, 'guardar_cumplimiento_cumplimientos'])->name('guardar_cumplimiento_cumplimientos');
        Route::get('/cumplimiento/guardarC',                [SeerController::class, 'cumplimientos_conciliadores'])->name('cumplimientos_conciliadores');        
        Route::post('/cumplimiento/guardar_CC',             [SeerController::class, 'guardar_cumplimiento_conciliadores'])->name('guardar_cumplimiento_conciliadores');
    //Fin de cumplimientos
    //Recepcion
        Route::get('/turnos/create',             [RecepcionController::class, 'create'])->name('turnos.create');
        Route::post('/turnos/store',             [RecepcionController::class, 'store_turnos'])->name('turnos.store');
        Route::get('/turnos/turnos',             [RecepcionController::class, 'turnos'])->name('turnos.listado');
        Route::get('/turnos/activo/{id}',        [RecepcionController::class, 'activo'])->name('turnos.activo');
        Route::get('/turnos/noactivo/{id}',      [RecepcionController::class, 'noactivo'])->name('turnos.noactivo');
        Route::get('/turnos/cambiar/{id}',       [RecepcionController::class, 'cambiar'])->name('cambiar');
        Route::get('/turnos/terminadoR/{id}',    [RecepcionController::class, 'terminado_confirmar'])->name('turnos.terminado_revisar');
        Route::get('/turnos/cambio/{id}',        [RecepcionController::class, 'cambio'])->name('turnos.cambioexcepcion');
        Route::get('/turnos/terminado/{id}',     [RecepcionController::class, 'terminado'])->name('turnos.terminado');
        Route::post('/turnos/edit',              [RecepcionController::class, 'edit'])->name('turnos.edit');
        Route::get('/turnos/tarjeta',            [RecepcionController::class, 'index_tarjeta'])->name('tarjeta_informativa');
        Route::get('/tarjeta/llenar/{id}',       [RecepcionController::class, 'tarjeta_crear'])->name('llenar_tarjeta');
        Route::post('/tarjeta/guardar',          [RecepcionController::class, 'guardar'])->name('agregar_tarjeta');
        Route::get('/tarjetas/index',            [RecepcionController::class, 'reporte_excepcion'])->name('reporte_excepcion');
        Route::post('reportes/excepcion',        [RecepcionController::class, 'reportePDF'])->name('turnos_excepcion');
        Route::get('/turnos/nuevo',              [RecepcionController::class, 'nueva_cita'])->name('nueva_cita');
        Route::post('/tuenos/guardar',           [RecepcionController::class, 'turnos_guardar'])->name('turnos_guardar_nuevo'); 
    //Fin recepcion
    //Documentos
        Route::get('/INE_Solicitante/{id}',             [SeerController::class, 'Ver_INE_Solicitante'])->name('PDF_INE_solicitante');
        Route::get('/VerDcocumentosRatificacion/{id}',  [TurnosController::class, 'VerDocumentosRatificacion'])->name('VerDocumentosRatificacion');
        Route::get('/VerDcocumentos/{id}',              [SeerController::class, 'VerDocumentosAudiencia'])->name('VerDocumentosAudiencia');
    //Fin de Documentos
    //Estadisticas
        Route::get('/misestadisticas/index',    [SeerController::class, 'misestadisticas'])->name('misestadisticas');
        Route::post('/misestadisticas/reporte', [SeerController::class, 'estadisticasPDF'])->name('mis_reportes');
    //Fin estadisticas
    //Rutas Generales
        Route::get('/revisar/indexAudiencia',           [SeerController::class, 'todas_audiencias'])->name('todas_audiencias');
        Route::get('/revisar/indexSolictudes',          [SeerController::class, 'todas_solicitudes'])->name('todas_solicitudes');
        Route::get('/revisar/indexRatificaciones',      [SeerController::class, 'todas_ratificaciones'])->name('todas_ratificaciones');
        Route::get('/revisar/indexCumplimientos',       [SeerController::class, 'todos_complimientos'])->name('todos_complimientos');
    //Fin de rutas Generales
    //Direccion General
        Route::get('/DireccionGeneral/index',           [CitaDireccionController::class, 'index'])->name('indexDireccionGeneral');
        Route::get('/DireccionGeneral/create',          [CitaDireccionController::class, 'create'])->name('cita_direccion_crear');
        Route::post('/DireccionGeneral/guardar',        [CitaDireccionController::class, 'cita_direccion_guardar'])->name('cita_direccion_guardar');
        Route::get('/DireccionGeneral/crearQR/{id}',    [CitaDireccionController::class, 'generarQr'])->name('generarQR_cita');
    //Fin de rutas Generales
    //Correos
        Route::get('/Prueba_correo/mandar',                 [CorreosController::class, 'correo_prueba'])->name('correo_prueba');
    //Fin Correos
    //Tercer Encuentro
        Route::get('/tercer_encuentro/index',           [SeerController::class, 'index_tercer_encuentro'])->name('index_tercer_encuentro');
        Route::get('/registro_asistencia/{id}',         [SeerController::class, 'registro_asistencia_te'])->name('registro_asistencia_te');
        Route::post('/registro_asistencia/{id}',        [SeerController::class, 'guardar_asistencia_te'])->name('registro_asistencia_te.guardar');
        Route::get('/editar_datos_te/{id}',             [SeerController::class, 'editar_datos_te'])->name('editar_datos_te');
        Route::post('/editar_datos_te/{id}',            [SeerController::class, 'guardar_datos_te'])->name('editar_datos_te.guardar');
        Route::get('/tercer_encuentro/reporte',         [SeerController::class, 'pdf_tercer_encuentro'])->name('pdf_tercer_encuentro');
        Route::get('constancias',                       [SeerController::class, 'enviarAcuse']);
        Route::get('/tercer_encuentro/constancia/{id}', [SeerController::class, 'VerPDFConstancia'])->name('PDFConstancia');
    //Fin de tercer encuentro
    //Conciliadores
        Route::get('/conciliador/index',                [ConciliadoresController::class, 'index'])->name('index_conciliadores');
        Route::post('/conciliador/update_perimsos/',    [ConciliadoresController::class, 'update'])->name('conciliadores_permisos');
        Route::get('/conciliador/firmaCitatorios',      [SeerController::class, 'firmaCitatorios_index'])->name('firma_citatorio'); //Citatorios a firmar por los conciliadores


        Route::get('/conciliador/prueba',                [TurnosController::class, 'actualizar_folio']);
    //Fin Conciliadores
    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });

});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';

//Devuelve el conteo de registros pendientes de firma para el usuario logueado
Route::middleware(['auth', 'throttle:120,1'])->get('/poll/pendiente-firma', function () {
    $userId = Auth::id();
    $count = 0;
    if ($userId) {
        $count = SeerPerGeneral::query()
            ->where('pendiente_firma', 'Si')
            ->where('conciliador_id', $userId)
            ->count();
    }
    return response()->json(['count' => (int) $count]);
})->name('poll.pendiente_firma');
