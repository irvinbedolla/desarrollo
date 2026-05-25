<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use App\Models\Municipios;
use App\Models\Estados;
use App\Models\User;
use App\Models\HistorialAbogado;
use Spatie\Permission\Models\Role;

//Para sacar el Id del usuario
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PoderController extends Controller
{

    public function index()
    {
        $id = auth()->user()->id;
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name')->all();
        $poderes = Poder::all();
        return view('poderes.index', compact('poderes','userRole'));
    }

    public function create()
    {
        $id_usuario = Auth::id();
        $estados = Estados::all();
        $municipios = Municipios::all();
        return view('poderes.crear', compact('id_usuario','municipios','estados'));
    }

    public function registro()
    {
        $estados = Estados::all();
        $municipios = Municipios::all();
        return view('poder', compact('municipios','estados'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
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
            'tipo'                      => 'required',
            'documentoPoder'            => 'nullable',
            'documentoAnexo'            => 'nullable',
        ], $data);


        if($data["tipo"] != "FisicaD"){
            //Validar las regiones
            if($regionmorelia == "No" && $regionuruapan == "No" && $regionzamora == "No"){
                return back()->withErrors('Debes seleccionar al menos una Región.');
            }
        }

        //Validar que no exista el abogado
        $abogado = Poder::where(['nombres' => $data["nombresAbogadoAlta"], 'primer_apellido' => $data["primer_apellido"], 
        'segundo_apellido' => $data["segundo_apellido"], 'empresa' => $data["empresaAbogadoAlta"]])->first();
        if(!$abogado){
            //Vamos insetar los datos para la persona fisica con representante legal
            if($data["tipo"] == "FisicaR"){
                $data_insertar = array(
                    'nombres'               => $data["nombresAbogadoAlta"],
                    'primer_apellido'       => $data["primer_apellido"],
                    'segundo_apellido'      => $data["segundo_apellido"],
                    'telefono'              => $data["telefonoAbogadoAlta"], 
                    'email'                 => $data["correoAbogadoAlta"],
                    'fechaRegistro'         => date('y-m-d'),
                    'fechaVigencia'         => $data["fechaVigenciaAlta"],
                    'empresa'               => $data["empresaAbogadoAlta"],
                    'eliminado'             => 0,
                    'curp'                  => $data["curpAbogadoAlta"],
                    'estado_poder'          => $data["estado_poder"],
                    'municipio_poder'       => $data["municipio_poder"],
                    'vialidadPoder'         => $data["vialidadPoder"],
                    'vialidad_callePoder'   => $data["vialidad_callePoder"],
                    'coloniaAbogadoAlta'    => $data["coloniaAbogadoAlta"],
                    'NExtAbogadoAlta'       => $data["NExtAbogadoAlta"],
                    'NIntAbogadoAlta'       => $data["NIntAbogadoAlta"],
                    'cpAbogadoAlta'         => $data["cpAbogadoAlta"],
                    'rfc'                   => $data["RFCAbogadoAlta"],
                    'industria'             => $data["industriaAlta"],
                    'poder'                 => $data["descripcionpoderAlta"],
                    'regionMorelia'         => $regionmorelia,
                    'regionUruapan'         => $regionuruapan,
                    'regionZamora'          => $regionuruapan,
                    'estatus'               => "Pendiente",
                    'tipo'                  => "FisicaR"
                );
            }
            else if($data["tipo"] == "Moral"){
                $data_insertar = array(
                    'nombres'               => $data["razon"],
                    'primer_apellido'       => "",
                    'segundo_apellido'      => "",
                    'telefono'              => $data["telefono_moral"], 
                    'email'                 => $data["correo_moral"],
                    'fechaRegistro'         => date('y-m-d'),
                    'fechaVigencia'         => $data["fechaVigenciaAlta"],
                    'empresa'               => $data["empresaAbogadoAlta"],
                    'eliminado'             => 0,
                    'curp'                  => $data["curp_moral"],
                    'estado_poder'          => $data["estado_poder"],
                    'municipio_poder'       => $data["municipio_poder"],
                    'vialidadPoder'         => $data["vialidadPoder"],
                    'vialidad_callePoder'   => $data["vialidad_callePoder"],
                    'coloniaAbogadoAlta'    => $data["coloniaAbogadoAlta"],
                    'NExtAbogadoAlta'       => $data["NExtAbogadoAlta"],
                    'NIntAbogadoAlta'       => $data["NIntAbogadoAlta"],
                    'cpAbogadoAlta'         => $data["cpAbogadoAlta"],
                    'rfc'                   => $data["RFCAbogadoAlta"],
                    'industria'             => $data["industriaAlta"],
                    'poder'                 => $data["descripcionpoderAlta"],
                    'regionMorelia'         => $regionmorelia,
                    'regionUruapan'         => $regionuruapan,
                    'regionZamora'          => $regionuruapan,
                    'estatus'               => "Pendiente",
                    'tipo'                  => "Moral"
                );
            }
            else if($data["tipo"] == "FisicaD"){
                $data_insertar = array(
                    'nombres'               => $data["nombre_derecho"],
                    'primer_apellido'       => $data["primero_derecho"],
                    'segundo_apellido'      => $data["segundo_derecho"],
                    'telefono'              => $data["telefono_derecho"], 
                    'email'                 => $data["correo_derecho"],
                    'fechaRegistro'         => date('y-m-d'),
                    'fechaVigencia'         => date('y-m-d'),
                    'empresa'               => $data["nombre_derecho"],
                    'eliminado'             => 0,
                    'curp'                  => $data["curp_derecha"],
                    'estado_poder'          => 16,
                    'municipio_poder'       => 16,
                    'vialidadPoder'         => "Calle",
                    'vialidad_callePoder'   => $data["vialidad_derecho"],
                    'coloniaAbogadoAlta'    => $data["colonia_derecho"],
                    'NExtAbogadoAlta'       => $data["num_ext_derecho"],
                    'NIntAbogadoAlta'       => $data["num_int_derecho"],
                    'cpAbogadoAlta'         => $data["cp_derecho"],
                    'rfc'                   => $data["RFC_derecho"],
                    'industria'             => $data["giro_derecho"],
                    'poder'                 => "",
                    'regionMorelia'         => "Si",
                    'regionUruapan'         => "Si",
                    'regionZamora'          => "Si",
                    'estatus'               => "Pendiente",
                    'tipo'                  => "FisicaD"
                );
            }

            

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

            Poder::create($data_insertar);  
            //$data = Poder::latest('idAbogado')->first();

            return redirect()->route('poderes');         
        }
        else{
            return back()->withErrors('El poder ya tiene asignado ese abogado.');
        }
    }

    public function show(Request $request)
    {
        $data = $request->all();
        
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
            'apellidosAbogadoAlta'      => 'required',
            'telefonoAbogadoAlta'       => 'required|digits:10',
            'correoAbogadoAlta'         => 'required',
            'empresaAbogadoAlta'        => 'required',
            'curpAbogadoAlta'           => 'required',
            'estado_poder'              => 'required',
            'municipio_poder'           => 'required',
            'vialidadPoder'             => 'required',
            'vialidad_callePoder'       => 'required',
            'coloniaAbogadoAlta'        => 'required',
            'NExtAbogadoAlta'           => 'required',
            'cpAbogadoAlta'             => 'required',
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
        $abogado = Poder::where(['nombres' => $data["nombresAbogadoAlta"], 'apellidos' => $data["apellidosAbogadoAlta"], 'empresa' => $data["empresaAbogadoAlta"]])->first();
        //User::where('username','like','%John%') -> first();
        if(!$abogado){
            if(!$request->file('documentoAnexo')){
                $Anexo = "Sin anexo";
            }
            else{
                $Anexo = $request->file('documentoAnexo')->getClientOriginalName();
            }
            if(!$request->file('documentoPoder')){
                $Poder = "Sin carta poder";
            }
            else{
                $Poder = $request->file('documentoPoder')->getClientOriginalName();
            }
            

            $nombre_ine = $data["nombresAbogadoAlta"]."".$data["apellidosAbogadoAlta"]."-".$data["empresaAbogadoAlta"]."_IDENTIFICACION.pdf";
            //Validar si existe el documento registrado
            $existe_ine = Storage::exists($nombre_ine);
            if (file_exists($existe_ine)){
                unlink(storage_path('app/documentos_abogados/'.$nombre_ine));
            }
            $path = Storage::putFileAs(
                'documentos_abogados', $request->file('documentoIne'), $nombre_ine
            );

            $nombre_representación = $data["nombresAbogadoAlta"]."".$data["apellidosAbogadoAlta"]."-".$data["empresaAbogadoAlta"]."_REPRESENTACION.pdf";
            //Validar si existe el documento registrado
            $existe_reprecentacion = Storage::exists($nombre_representación);
            if (file_exists($existe_reprecentacion)){
                unlink(storage_path('app/documentos_abogados/'.$nombre_representación));
            }
            $path = Storage::putFileAs(
                'documentos_abogados', $request->file('documentoRepresentacion'), $nombre_representación
            );
            

            //Si no existe
            if(!isset($data["documentoAnexo"])){
                $nombre_anexo = "Sin anexo";
            }
            else{
                $nombre_anexo = $data["nombresAbogadoAlta"]."".$data["apellidosAbogadoAlta"]."-".$data["empresaAbogadoAlta"]."_ANEXO.pdf";
                $existe_anexo = Storage::exists($nombre_anexo);
                if (file_exists($existe_anexo)){
                    unlink(storage_path('app/documentos_abogados/'.$nombre_anexo));
                }
                $path = Storage::putFileAs(
                    'documentos_abogados', $request->file('documentoAnexo'), $nombre_anexo
                );
            }

            if(!isset($data["documentoPoder"])){
                $nombre_anexo = "Sin anexo";
            }
            else{
                $nombre_poder = $data["nombresAbogadoAlta"]."".$data["apellidosAbogadoAlta"]."-".$data["empresaAbogadoAlta"]."_PODER.pdf";
                $existe_poder = Storage::exists($nombre_poder);
                if (file_exists($existe_poder)){
                    unlink(storage_path('app/documentos_abogados/'.$nombre_poder));
                }
                $path = Storage::putFileAs(
                    'documentos_abogados', $request->file('documentoPoder'), $nombre_poder
                );
            }

            $data_insertar= array(
                'nombres'       => $data["nombresAbogadoAlta"],
                'apellidos'     => $data["apellidosAbogadoAlta"], 
                'telefono'      => $data["telefonoAbogadoAlta"], 
                'email'         => $data["correoAbogadoAlta"],
                'ine'           => $nombre_ine,
                'cedula'        => $nombre_poder,
                'anexo'         => $nombre_anexo,
                'representacion'=> $nombre_representación,
                'fechaRegistro' => date('y-m-d'),
                'fechaVigencia' => $data["fechaVigenciaAlta"],
                'empresa'       => $data["empresaAbogadoAlta"],
                'eliminado'     => 0,
                'curp'          => $data["curpAbogadoAlta"],
                'estado_poder'          => $data["estado_poder"],
                'municipio_poder'       => $data["municipio_poder"],
                'vialidadPoder'         => $data["vialidadPoder"],
                'vialidad_callePoder'   => $data["vialidad_callePoder"],
                'coloniaAbogadoAlta'    => $data["coloniaAbogadoAlta"],
                'NExtAbogadoAlta'       => $data["NExtAbogadoAlta"],
                'NIntAbogadoAlta'       => $data["NIntAbogadoAlta"],
                'cpAbogadoAlta'         => $data["cpAbogadoAlta"],
                'rfc'           => $data["RFCAbogadoAlta"],
                'industria'     => $data["industriaAlta"],
                'poder'         => $data["descripcionpoderAlta"],
                'regionMorelia' => $regionmorelia,
                'regionUruapan' => $regionuruapan,
                'regionZamora'  => $regionuruapan,
                'estatus'       => "Pendiente"
            );


            Poder::create($data_insertar);  

            return back()->with('success', 'Poder registrado correctamente, tienes 10 dias habiles para pasar al CCL a confirmar tu documentacion.'); 
        }
        else{
            return back()->withErrors('El poder ya tiene asignado ese abogado.');
        }
    }

    public function edit($id)
    {
        $estados = Estados::all();
        $municipios = Municipios::all();
        $poder = Poder::find($id);
        return view('poderes.editar', compact('poder','estados','municipios'));
    }

    public function history($id){
        $historiales = HistorialAbogado::where('id_abogado', $id)->get();
        $oldest = HistorialAbogado::where('id_abogado', $id)->oldest()->first();
        foreach ($historiales as $historial){
            if($historial->created_at == $oldest->created_at){
                $historial->tipo_cambio = "Creación";
            }
            else{
                $historial->tipo_cambio = "Modificación";
            }
        }
        return view('poderes.historial', compact('historiales'));
    }

    public function historyDetail($id)
    {
        $historial = HistorialAbogado::with(['usuario', 'estadoPatronal', 'municipioPatronal'])->find($id);

        if (!$historial) {
            return response()->json(['message' => 'Historial no encontrado'], 404);
        }
        $historial->makeHidden([
            'updated_at',
            'created_at',
        ]);

        if ($historial->usuario) {
            $historial->usuario->makeHidden([
                'email',
                'email_verified_at',
                'password',
                'remember_token',
                'created_at',
                'updated_at',
            ]);
        }

        return response()->json($historial);
    }

    public function update(Request $request, $id)
    {
        // 1. Unificar y limpiar la validación en un solo bloque rápido usando reglas condicionales
        $request->validate([
            'tipoPersona' => 'required|in:Fisica,Moral',
            'representate' => 'required_if:tipoPersona,Fisica|in:Si,No',
            'validacion' => 'required',
            
            // Campos comunes para Persona Física
            'nombre_pF' => 'required_if:tipoPersona,Fisica',
            'primero_PF' => 'required_if:tipoPersona,Fisica',
            'segundo_Pf' => 'required_if:tipoPersona,Fisica',
            'curp_PF' => 'required_if:tipoPersona,Fisica',
            'RFC_pF' => 'required_if:tipoPersona,Fisica',
            'sexo_pf' => 'required_if:tipoPersona,Fisica',
            'giro_pF' => 'required_if:tipoPersona,Fisica',
            'correo_pF' => 'required_if:tipoPersona,Fisica',
            'telefono_PF' => 'required_if:tipoPersona,Fisica',
            'estado_pF' => 'required_if:tipoPersona,Fisica',
            'municipio_pF' => 'required_if:tipoPersona,Fisica',
            'vialidad_pF' => 'required_if:tipoPersona,Fisica',
            'vialidad_calle_pF' => 'required_if:tipoPersona,Fisica',
            'colonia_pF' => 'required_if:tipoPersona,Fisica',
            'num_ext_pF' => 'required_if:tipoPersona,Fisica',
            'cp_pF' => 'required_if:tipoPersona,Fisica',
            
            // Representación específica Física
            'nombre_representante_pF' => 'required_if:representate,Si',
            'primer_representante_pF' => 'required_if:representate,Si',
            'segundo_representante_pF' => 'required_if:representate,Si',
            'curp_representante_pF' => 'required_if:representate,Si',
            'sexo_representante_pF' => 'required_if:representate,Si',
            'correo_representante_pF' => 'required_if:representate,Si',
            'telefono_representante_pF' => 'required_if:representate,Si',
            'tipo_documento_pF' => 'required_if:representate,Si',
            'fecha_expedicion_pF' => 'required_if:representate,Si',
            'descripcion_pF' => 'required_if:representate,Si',
            'tipo_identificacion_pFCR' => 'required_if:representate,Si',
            'num_identificacion_pFCR' => 'required_if:representate,Si',
            'tipo_identificacion_pF' => 'required_if:representate,No',
            'num_identificacion_pF' => 'required_if:representate,No',

            // Campos Persona Moral
            'razon' => 'required_if:tipoPersona,Moral',
            'rfc_moral' => 'required_if:tipoPersona,Moral',
            'giro_moral' => 'required_if:tipoPersona,Moral',
            'estado_moral' => 'required_if:tipoPersona,Moral',
            'municipio_moral' => 'required_if:tipoPersona,Moral',
            'vialidad_Moral' => 'required_if:tipoPersona,Moral',
            'vialidad_calleMoral' => 'required_if:tipoPersona,Moral',
            'colonia_moral' => 'required_if:tipoPersona,Moral',
            'num_ext_moral' => 'required_if:tipoPersona,Moral',
            'cp_moral' => 'required_if:tipoPersona,Moral',
            'nombre_representante_Moral' => 'required_if:tipoPersona,Moral',
            'primer_Moral' => 'required_if:tipoPersona,Moral',
            'segundo_Moral' => 'required_if:tipoPersona,Moral',
            'curp_moral' => 'required_if:tipoPersona,Moral',
            'sexo_Moral' => 'required_if:tipoPersona,Moral',
            'correo_Moral' => 'required_if:tipoPersona,Moral',
            'telefono_Moral' => 'required_if:tipoPersona,Moral',
            'tipo_Moral' => 'required_if:tipoPersona,Moral',
            'fecha_expedicicion_Moral' => 'required_if:tipoPersona,Moral',
            'descripcion_Moral' => 'required_if:tipoPersona,Moral',
            'tipo_identificacion_Moral' => 'required_if:tipoPersona,Moral',
            'num_identificacion_Moral' => 'required_if:tipoPersona,Moral',
        ]);

        $data = $request->all();
        $id_usuario = auth()->user()->id;
        $poder = Poder::findOrFail($id); // Uso de findOrFail para mayor seguridad

        $data_insertar = [];
        $archivos_a_guardar = [];

        // 2. Mapeo veloz de la información estructurada en memoria RAM
        if ($data["tipoPersona"] == "Fisica") {
            $base_name = trim($data["nombre_pF"]." ".$data["primero_PF"]." ".$data["segundo_Pf"])."-FISICA";

            $data_insertar = [
                'tipo'                      => "Fisica",
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
                'estatus'                   => $data["validacion"],
                'reprecentante'             => $data["representate"],
                'mun_int_patronal'          => $data["num_int_pF"] ?? null
            ];

            // Mapeo condicional por rol de representación
            if ($data["representate"] == "No") {
                $data_insertar['tipo_identificacion'] = $data["tipo_identificacion_pF"];
                $data_insertar['num_identificacion']  = $data["num_identificacion_pF"];

                if ($request->hasFile('documentoIne_pF')) {
                    $archivos_a_guardar[] = ['input' => 'documentoIne_pF', 'name' => $base_name."_IDENTIFICACION.pdf", 'field' => 'ineDocumento'];
                }
                if ($request->hasFile('documentoRepresentacion_pF')) {
                    $archivos_a_guardar[] = ['input' => 'documentoRepresentacion_pF', 'name' => $base_name."_REPRESENTACION.pdf", 'field' => 'representacionDocumento'];
                }
                if ($request->hasFile('documentoPoder_pF')) {
                    $archivos_a_guardar[] = ['input' => 'documentoPoder_pF', 'name' => $base_name."_PODER.pdf", 'field' => 'cedulaDocumento'];
                }
                if ($request->hasFile('documentoAnexo_pF')) {
                    $archivos_a_guardar[] = ['input' => 'documentoAnexo_pF', 'name' => $base_name."_ANEXO.pdf", 'field' => 'anexo_documeto'];
                }
            } else {
                $data_insertar += [
                    'nombre_representante'           => $data["nombre_representante_pF"],
                    'primer_apellido_representante'  => $data["primer_representante_pF"],
                    'segundo_apellido_representante' => $data["segundo_representante_pF"],
                    'curp_representante'             => $data["curp_representante_pF"],
                    'sexo_representante'             => $data["sexo_representante_pF"],
                    'correo_representante'           => $data["correo_representante_pF"],
                    'numero_representante'           => $data["telefono_representante_pF"],
                    'tipo_documento_representante'  => $data["tipo_documento_pF"],
                    'fechaRegistro'                  => $data["fecha_expedicion_pF"],
                    'fechaVigencia'                  => $data["fecha_vigencia_pF"] ?? null,
                    'descipcion_poder'               => $data["descripcion_pF"],
                    'tipo_identificacion'            => $data["tipo_identificacion_pFCR"],
                    'num_identificacion'             => $data["num_identificacion_pFCR"],
                ];

                if ($request->hasFile('documentoIne_pF')) {
                    $archivos_a_guardar[] = ['input' => 'documentoIne_pF', 'name' => $base_name."_IDENTIFICACION.pdf", 'field' => 'ineDocumento'];
                }
                if ($request->hasFile('documentoRepresentacion_pF')) {
                    $archivos_a_guardar[] = ['input' => 'documentoRepresentacion_pF', 'name' => $base_name."_REPRESENTACION.pdf", 'field' => 'representacionDocumento'];
                }
                if ($request->hasFile('documentoPoder_pF')) {
                    $archivos_a_guardar[] = ['input' => 'documentoPoder_pF', 'name' => $base_name."_PODER.pdf", 'field' => 'cedulaDocumento'];
                }
                if ($request->hasFile('documentoAnexo_pF')) {
                    $archivos_a_guardar[] = ['input' => 'documentoAnexo_pF', 'name' => $base_name."_ANEXO.pdf", 'field' => 'anexo_documeto'];
                }
            }
        } 
        else if ($data["tipoPersona"] == "Moral") {
            $base_name = trim($data["razon"])."-MORAL";

            $data_insertar = [
                'tipo'                           => "Moral",
                'nombres_patronal'               => $data["razon"],
                'primer_apellido_patronal'       => "",
                'segundo_apellido_patronal'      => "",
                'rfc_patronal'                   => $data["rfc_moral"],
                'giroComercial'                  => $data["giro_moral"],
                'estado_patronal'                => $data["estado_moral"],
                'municipio_patronal'             => $data["municipio_moral"],
                'tipo_vialidad_patronal'         => $data["vialidad_Moral"],
                'vialidad_patronal'              => $data["vialidad_calleMoral"],
                'colonia_patronal'               => $data["colonia_moral"],
                'num_ext_patronal'               => $data["num_ext_moral"],
                'cp_patronal'                    => $data["cp_moral"],
                'nombre_representante'           => $data["nombre_representante_Moral"],
                'primer_apellido_representante'  => $data["primer_Moral"],
                'segundo_apellido_representante' => $data["segundo_Moral"],
                'curp_representante'             => $data["curp_moral"],
                'sexo_representante'             => $data["sexo_Moral"],
                'correo_representante'           => $data["correo_Moral"],
                'numero_representante'           => $data["telefono_Moral"],
                'tipo_documento_representante'  => $data["tipo_Moral"],
                'fechaRegistro'                  => $data["fecha_expedicicion_Moral"],
                'fechaVigencia'                  => $data["fecha_vigencia_Moral"] ?? null,
                'descipcion_poder'               => $data["descripcion_Moral"],
                'estatus'                        => $data["validacion"],
                'reprecentante'                  => "Si",
                'tipo_identificacion'            => $data["tipo_identificacion_Moral"],
                'num_identificacion'             => $data["num_identificacion_Moral"],
                'mun_int_patronal'               => $data["num_int"] ?? null
            ];

            if ($request->hasFile('documentoIne_Moral')) {
                $archivos_a_guardar[] = ['input' => 'documentoIne_Moral', 'name' => $base_name."_IDENTIFICACION.pdf", 'field' => 'ineDocumento'];
            }
            if ($request->hasFile('documentoRepresentacion_Moral')) {
                $archivos_a_guardar[] = ['input' => 'documentoRepresentacion_Moral', 'name' => $base_name."_REPRESENTACION.pdf", 'field' => 'representacionDocumento'];
            }
            if ($request->hasFile('documentoPoder')) {
                $archivos_a_guardar[] = ['input' => 'documentoPoder', 'name' => $base_name."_PODER.pdf", 'field' => 'cedulaDocumento'];
            }
            if ($request->hasFile('documentoAnexo')) {
                $archivos_a_guardar[] = ['input' => 'documentoAnexo', 'name' => $base_name."_ANEXO.pdf", 'field' => 'anexo_documeto'];
            }
        }

        // 3. Reemplazo/almacenamiento de archivos dentro de la carpeta del abogado: documentos_abogados/{idAbogado}/
        //    y con prefijo {idAbogado}_ para mantener consistencia con los registros nuevos.
        $carpetaAbogado = 'documentos_abogados/' . $poder->idAbogado;
        foreach ($archivos_a_guardar as $archivo) {
            if (!$request->hasFile($archivo['input'])) {
                continue;
            }

            // Si ya existe un archivo previo registrado, intentamos eliminarlo (en la NUEVA ruta).
            $archivoAnterior = $poder->{$archivo['field']} ?? null;
            if (!empty($archivoAnterior) && $archivoAnterior !== 'Sin anexo' && $archivoAnterior !== 'Sin carta poder') {
                $previousPath = $carpetaAbogado . '/' . $archivoAnterior;
                if (Storage::exists($previousPath)) {
                    Storage::delete($previousPath);
                }
            }

            // Guardar el archivo nuevo con prefijo idAbogado_
            $nombreFinal = $poder->idAbogado . '_' . $archivo['name'];
            Storage::putFileAs($carpetaAbogado, $request->file($archivo['input']), $nombreFinal);
            $data_insertar[$archivo['field']] = $nombreFinal;
        }

        // 4. Bloque transaccional seguro
        DB::beginTransaction();
        try {
            // Ejecutar actualización
            $poder->update($data_insertar);

            // Combinar datos anteriores con los modificados de manera limpia en RAM
            $historialPayload = array_merge($poder->toArray(), $data_insertar);
            unset($historialPayload['idAbogado'], $historialPayload['created_at'], $historialPayload['updated_at']);
            
            $historialPayload['id_abogado'] = $poder->idAbogado; // Ajusta si la PK tiene otro nombre
            $historialPayload['id_user']    = $id_usuario;
            
            HistorialAbogado::create($historialPayload);

            DB::commit();

            // Lógica de Redirección Condicional Optimizada
            if ($request->has('from_audiencia_patronal') && $request->has('solicitud_id')) {
                $params = ['id_solicitud' => $request->input('solicitud_id')];
                if ($request->filled('audiencia_id')) {
                    $params['audiencia_id'] = $request->input('audiencia_id');
                }
                return redirect()->route('vista_previa_patronal', $params);
            }

            return redirect()->route('poderes')->with('success', 'Registro actualizado con éxito.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error al actualizar el registro: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        //Borrar la documentacion
        $poder = Poder::find($id);
        /*unlink(storage_path('app/documentos_abogados/'.$poder->ine));
        unlink(storage_path('app/documentos_abogados/'.$poder->representacion));
        if($poder->anexo !== "Sin anexo"){
            unlink(storage_path('app/documentos_abogados/'.$poder->anexo));
        }
        if($poder->cedula !== "Sin anexo"){
            unlink(storage_path('app/documentos_abogados/'.$poder->cedula));
        }
        */
        $poder = Poder::find($id)->delete();
        return redirect()->route('poderes');
    }

    public function publico(Request $request)
    {
        $data = $request->all();
        $id_user_historial = Auth::id() ?? 0;

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
                        'reprecentante'             => "No",
                        'tipo_identificacion'       => $data["tipo_identificacion_pF"],
                        'num_identificacion'        => $data["num_identificacion_pF"]
                );

                // Creamos primero el registro para conocer idAbogado y poder crear la carpeta con ese nombre.
                $nuevoAbogado = Poder::create($data_insertar);
                $idAbogado = $nuevoAbogado->idAbogado;
                $carpetaAbogado = 'documentos_abogados/' . $idAbogado;

                $nombre_ine_original = $data["nombre_pF"]." ".$data["primero_PF"]." ".$data["segundo_Pf"]."-FISICA"."_IDENTIFICACION.pdf";
                $nombre_ine = $idAbogado . '_' . $nombre_ine_original;
                Storage::putFileAs(
                    $carpetaAbogado, $request->file('documentoIne_pFSR'), $nombre_ine
                );
                if(!isset($data["documentoAnexo_pFSR"])){
                    $nombre_anexo = "Sin anexo";
                }
                else{
                    $nombre_anexo_original = $data["nombre_pF"]." ".$data["primero_PF"]." ".$data["segundo_Pf"]."-FISICA"."_ANEXO.pdf";
                    $nombre_anexo = $idAbogado . '_' . $nombre_anexo_original;
                    Storage::putFileAs(
                        $carpetaAbogado, $request->file('documentoAnexo_pFSR'), $nombre_anexo
                    );
                }

                // Guardamos los nombres ya con prefijo y carpeta.
                $nuevoAbogado->ineDocumento = $nombre_ine;
                $nuevoAbogado->anexo_documeto = $nombre_anexo;
                $nuevoAbogado->save();
                
                if(isset($data["num_int_pF"])){
                    $data_insertar["mun_int_patronal"] = $data["num_int_pF"];
                }
                
                $historialPayload = $nuevoAbogado->toArray();
                unset($historialPayload['idAbogado'], $historialPayload['created_at'], $historialPayload['updated_at']);
                $historialPayload['id_abogado'] = $nuevoAbogado->idAbogado;
                $historialPayload['id_user'] = $id_user_historial;
                HistorialAbogado::create($historialPayload);

                $mensaje = "Su registro fue guardado con éxito, tu número de folio es: ".$nuevoAbogado->idAbogado. " 
                *La validación del registro patronal quedará sujeta a la certificación de la documentación que realice la persona conciliadora, lo anterior de conformidad con lo 
                establecido en el artículo 684-I, fracción I y II, de la Ley Federal del Trabajo; por lo que se le solicita acudir a su siguiente audiencia de conciliación con la 
                Documentación original en formato físico, a fin de realizar el cotejo correspondiente.";
                    
                    
                return redirect()->route('poder-crear')->with('success', $mensaje);
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
                        'reprecentante'                 => "Si",
                        'tipo_identificacion'           => $data["tipo_identificacion_pFCR"],
                        'num_identificacion'            => $data["num_identificacion_pFCR"]
                );

                // Creamos primero el registro para conocer idAbogado y poder crear carpeta.
                $nuevoAbogado = Poder::create($data_insertar);
                $idAbogado = $nuevoAbogado->idAbogado;
                $carpetaAbogado = 'documentos_abogados/' . $idAbogado;

                $nombre_ine_original = $data["nombre_pF"]." ".$data["primero_PF"]." ".$data["segundo_Pf"]."-FISICA"."_IDENTIFICACION.pdf";
                $nombre_ine = $idAbogado . '_' . $nombre_ine_original;
                Storage::putFileAs(
                    $carpetaAbogado, $request->file('documentoIne_pF'), $nombre_ine
                );

                $nombre_reprecentacion_original = $data["nombre_representante_pF"]." ".$data["primer_representante_pF"]." ".$data["segundo_representante_pF"]."-FISICA"."_REPRESENTACION.pdf";
                $nombre_reprecentacion = $idAbogado . '_' . $nombre_reprecentacion_original;
                Storage::putFileAs(
                    $carpetaAbogado, $request->file('documentoRepresentacion_pF'), $nombre_reprecentacion
                );

                $nombre_poder_original = $data["nombre_pF"]." ".$data["primero_PF"]." ".$data["segundo_Pf"]."-FISICA"."_PODER.pdf";
                $nombre_poder = $idAbogado . '_' . $nombre_poder_original;
                Storage::putFileAs(
                    $carpetaAbogado, $request->file('documentoPoder_pF'), $nombre_poder
                );

                if(!isset($data["documentoAnexo_pF"])){
                    $nombre_anexo = "Sin anexo";
                }
                else{
                    $nombre_anexo_original = $data["nombre_pF"]." ".$data["primero_PF"]." ".$data["segundo_Pf"]."-FISICA"."_ANEXO.pdf";
                    $nombre_anexo = $idAbogado . '_' . $nombre_anexo_original;
                    Storage::putFileAs(
                        $carpetaAbogado, $request->file('documentoAnexo_pF'), $nombre_anexo
                    );
                }

                $nuevoAbogado->ineDocumento = $nombre_ine;
                $nuevoAbogado->representacionDocumento = $nombre_reprecentacion;
                $nuevoAbogado->cedulaDocumento = $nombre_poder;
                $nuevoAbogado->anexo_documeto = $nombre_anexo;
                $nuevoAbogado->save();
                if(isset($data["num_int_pF"])){
                   $data_insertar["mun_int_patronal"] = $data["num_int_pF"];
                }
                if(isset($data["fecha_vigencia_pF"])){
                    $data_insertar["fechaVigencia"] = $data["fecha_vigencia_pF"];
                }
                
                $historialPayload = $nuevoAbogado->toArray();
                unset($historialPayload['idAbogado'], $historialPayload['created_at'], $historialPayload['updated_at']);
                $historialPayload['id_abogado'] = $nuevoAbogado->idAbogado;
                $historialPayload['id_user'] = $id_user_historial;
                HistorialAbogado::create($historialPayload);

                $mensaje = "Su registro fue guardado con éxito, tu número de folio es: ".$nuevoAbogado->idAbogado. " 
                *La validación del registro patronal quedará sujeta a la certificación de la documentación que realice la persona conciliadora, lo anterior de conformidad con lo 
                establecido en el artículo 684-I, fracción I y II, de la Ley Federal del Trabajo; por lo que se le solicita acudir a su siguiente audiencia de conciliación con la 
                Documentación original en formato físico, a fin de realizar el cotejo correspondiente.";
                        
                return redirect()->route('poder-crear')->with('success', $mensaje);
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
                    'reprecentante'                 => "Si",
                    'tipo_identificacion'           => $data["tipo_identificacion_Moral"],
                    'num_identificacion'            => $data["num_identificacion_Moral"]
            );       

            // Crear primero el registro para obtener idAbogado y guardar documentos en su carpeta.
            $nuevoAbogado = Poder::create($data_insertar);
            $idAbogado = $nuevoAbogado->idAbogado;
            $carpetaAbogado = 'documentos_abogados/' . $idAbogado;

            $nombre_ine_original = $data["razon"]."-MORAL"."_IDENTIFICACION.pdf";
            $nombre_ine = $idAbogado . '_' . $nombre_ine_original;
            Storage::putFileAs(
                $carpetaAbogado, $request->file('documentoIne_Moral'), $nombre_ine
            );

            $nombre_reprecentacion_original = $data["razon"]."-MORAL"."_REPRESENTACION.pdf";
            $nombre_reprecentacion = $idAbogado . '_' . $nombre_reprecentacion_original;
            Storage::putFileAs(
                $carpetaAbogado, $request->file('documentoRepresentacion_Moral'), $nombre_reprecentacion
            );

            $nombre_poder_original = $data["razon"]."-MORAL"."_PODER.pdf";
            $nombre_poder = $idAbogado . '_' . $nombre_poder_original;
            Storage::putFileAs(
                $carpetaAbogado, $request->file('documentoPoder'), $nombre_poder
            );

            if(!isset($data["documentoAnexo"])){
                $nombre_anexo = "Sin anexo";
            }
            else{
                $nombre_anexo_original = $data["razon"]."-MORAL"."_ANEXO.pdf";
                $nombre_anexo = $idAbogado . '_' . $nombre_anexo_original;
                Storage::putFileAs(
                    $carpetaAbogado, $request->file('documentoAnexo'), $nombre_anexo
                );
            }

            $nuevoAbogado->ineDocumento = $nombre_ine;
            $nuevoAbogado->representacionDocumento = $nombre_reprecentacion;
            $nuevoAbogado->cedulaDocumento = $nombre_poder;
            $nuevoAbogado->anexo_documeto = $nombre_anexo;
            $nuevoAbogado->save();
            if(isset($data["num_int"])){
                $data_insertar["mun_int_patronal"] = $data["num_int"];
            }
            if(isset($data["fecha_vigencia_Moral"])){
                $data_insertar["fechaVigencia"] = $data["fecha_vigencia_Moral"];
            }

            $historialPayload = $nuevoAbogado->toArray();
            unset($historialPayload['idAbogado'], $historialPayload['created_at'], $historialPayload['updated_at']);
            $historialPayload['id_abogado'] = $nuevoAbogado->idAbogado;
            $historialPayload['id_user'] = $id_user_historial;
            HistorialAbogado::create($historialPayload);

            $mensaje = "Su registro fue guardado con éxito, tu número de folio es: ".$nuevoAbogado->idAbogado. " 
            *La validación del registro patronal quedará sujeta a la certificación de la documentación que realice la persona conciliadora, lo anterior de conformidad con lo 
            establecido en el artículo 684-I, fracción I y II, de la Ley Federal del Trabajo; por lo que se le solicita acudir a su siguiente audiencia de conciliación con la 
            Documentación original en formato físico, a fin de realizar el cotejo correspondiente.";
                    
            return redirect()->route('poder-crear')->with('success', $mensaje);
        }
    }
    
     //PDF Acuse de confirmación de registro de abogados
     public function VerPDFregistroAbogado($idAbogado){
        $abogado = Poder::find($idAbogado);
        //dd($abogado);
        /*$solicitud = SeerPerGeneral::find($id);
        $solicitante  = SeerPerGeneral::join("seer_solicitante","seer_solicitante.id_solicitud","=","seer_general.id");
        $solicitante = $solicitante->where("seer_solicitante.id_solicitud", "=", $solicitud["id"])
        ->first();

        $citados = SeerCitados::where('id_solicitud', $id)->get();*/
       
        $pdf = \PDF::loadView('PDF/Abogados/acuseAbogado', compact('idAbogado','abogado'))
        ->setPaper('a4', 'portrait')
        ->setOption('isHtml5ParserEnabled', true)
        ->setOption('isPhpEnabled', true);

        $nombreArchivo = 'acuse_abogado_' . $abogado->idAbogado .'.pdf';
        return $pdf->download($idAbogado.'_'.$abogado->ineDocumento.'.pdf');

     }

     public function agregarRepresentante(Request $request)
     {
         $data = $request->all();
         $id = $data['idAbogado'];
         $poder = Poder::findOrFail($id);
 
         $id_user_historial = Auth::id() ?? 0;
 
         $data_insertar = array(
                 'nombres_patronal'          => $poder->nombres_patronal,
                 'primer_apellido_patronal'  => $poder->primer_apellido_patronal,
                 'segundo_apellido_patronal' => $poder->segundo_apellido_patronal,
                 'curp_patronal'             => $poder->curp_patronal,
                 'rfc_patronal'              => $poder->rfc_patronal,
                 'sexo_patronal'             => $poder->sexo_patronal,
                 'giroComercial'             => $poder->giroComercial,
                 'email_patronal'            => $poder->email_patronal,
                 'telefono_patronal'         => $poder->telefono_patronal,
                 'estado_patronal'           => $poder->estado_patronal,
                 'municipio_patronal'        => $poder->municipio_patronal,
                 'tipo_vialidad_patronal'    => $poder->tipo_vialidad_patronal,
                 'vialidad_patronal'         => $poder->vialidad_patronal,
                 'colonia_patronal'          => $poder->colonia_patronal,
                 'num_ext_patronal'          => $poder->num_ext_patronal,
                 'cp_patronal'               => $poder->cp_patronal,
                 'nombre_representante'          => $data["nombre_representante_pF"],
                 'primer_apellido_representante' => $data["primer_representante_pF"],
                 'segundo_apellido_representante'=> $data["segundo_representante_pF"],
                 'curp_representante'            => $data["curp_representante_pF"],
                 'sexo_representante'            => $data["sexo_representante_pF"],
                 'correo_representante'          => $data["correo_representante_pF"],
                 'numero_representante'          => $data["telefono_representante_pF"],
                 'tipo_documento_representante'  => $data["tipo_documento_pF"],
                 'fechaRegistro'                 => $data["fecha_expedicion_pF"],
                 'descipcion_poder'              => $data["descripcion_pF"],
                 'tipo'                          => $poder->tipo,
                 'estatus'                       => "Pendiente",
                 'reprecentante'                 => "Si",
                 'tipo_identificacion'           => $data["tipo_identificacion_pFCR"],
                 'num_identificacion'            => $data["num_identificacion_pFCR"]
         );
 
         //Acta Constitutiva
         if ($poder->tipo == "Moral" && $request->hasFile('documentoActa_Moral')) {
             $nombre_ine = $poder->nombres_patronal."-AGREGADO_ACTACONSTITUTIVA.pdf";
             $path = Storage::putFileAs(
                 'documentos_abogados', $request->file('documentoActa_Moral'), $nombre_ine
             );
             $data_insertar['ineDocumento'] = $nombre_ine;
         } else {
             //Si es Física (o Moral sin archivo nuevo), hereda el documento original 
             $data_insertar['ineDocumento'] = $poder->ineDocumento;
         }
 
         if ($request->hasFile('documentoRepresentacion_pF')) {
             $nombre_reprecentacion = $data["nombre_representante_pF"]." ".$data["primer_representante_pF"]." ".$data["segundo_representante_pF"]."-AGREGADO_REPRESENTACION.pdf";
             $path = Storage::putFileAs(
                 'documentos_abogados', $request->file('documentoRepresentacion_pF'), $nombre_reprecentacion
             );
             $data_insertar['representacionDocumento'] = $nombre_reprecentacion;
         }
 
         if ($request->hasFile('documentoPoder_pF')) {
             $nombre_poder = $poder->nombres_patronal." ".$poder->primer_apellido_patronal." ".$poder->segundo_apellido_patronal."-AGREGADO_PODER.pdf";
             $path = Storage::putFileAs(
                 'documentos_abogados', $request->file('documentoPoder_pF'), $nombre_poder
             );
             $data_insertar['cedulaDocumento'] = $nombre_poder;
         }
 
         if ($request->hasFile('documentoAnexo_pF')) {
             $nombre_anexo = $poder->nombres_patronal." ".$poder->primer_apellido_patronal." ".$poder->segundo_apellido_patronal."-AGREGADO_ANEXO.pdf";
             $path = Storage::putFileAs(
                 'documentos_abogados', $request->file('documentoAnexo_pF'), $nombre_anexo
             );
             $data_insertar['anexo_documeto'] = $nombre_anexo;
         } else {
             $data_insertar['anexo_documeto'] = "Sin anexo";
         }
 
         if(isset($data["fecha_vigencia_pF"])){
             $data_insertar["fechaVigencia"] = $data["fecha_vigencia_pF"];
         }
 
         $nuevoAbogado = Poder::create($data_insertar);
         
         $historialPayload = $nuevoAbogado->toArray();
         unset($historialPayload['idAbogado'], $historialPayload['created_at'], $historialPayload['updated_at']);
         $historialPayload['id_abogado'] = $nuevoAbogado->idAbogado;
         $historialPayload['id_user'] = $id_user_historial;
         HistorialAbogado::create($historialPayload);
 
         $mensaje = "El representante ha sido agregado exitosamente y se generó el nuevo registro patronal con el folio: " . $nuevoAbogado->idAbogado;
         return redirect()->back()->with('success', $mensaje);
     }
 
}
