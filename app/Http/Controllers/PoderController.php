<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use App\Models\Municipios;
use App\Models\Estados;

//Para sacar el Id del usuario
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PoderController extends Controller
{

    public function index()
    {
        //Paginar las personas
        $poderes = Poder::all();
        return view('poderes.index', compact('poderes'));
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


    public function update(Request $request, $id)
    {
        $id_usuario = auth()->user()->id;
        $data = $request->all();
        $poder = Poder::find($id);

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
                    "fecha_vigencia_pF"         => 'required',
                    "descripcion_pF"            => 'required',
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
                "fecha_vigencia_Moral"          => 'required',
            ], $data);
        }
        
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
                        'estatus'                   => $data["validacion"],
                        'idUsuario'                 => $id_usuario,
                );

                if(isset($data["documentoIne_pF"])){
                    $nombre_ine = $data["nombre_pF"]." ".$data["primero_PF"]." ".$data["segundo_Pf"]."-FISICA"."_IDENTIFICACION.pdf";
                    $path = Storage::putFileAs(
                        'documentos_abogados', $request->file('documentoIne_pF'), $nombre_ine
                    );
                    $data_insertar["ineDocumento"] = $nombre_ine;
                }
                if(isset($data["documentoRepresentacion_pF"])){
                    $nombre_reprecentacion = $data["nombre_pF"]." ".$data["primero_PF"]." ".$data["segundo_Pf"]."-FISICA"."_REPRESENTACION.pdf";
                    $path = Storage::putFileAs(
                        'documentos_abogados', $request->file('documentoRepresentacion_pF'), $nombre_reprecentacion
                    );
                    $data_insertar["representacionDocumento"] = $nombre_reprecentacion;
                }
                if(isset($data["documentoPoder_pF"])){
                    $nombre_poder = $data["nombre_pF"]." ".$data["primero_PF"]." ".$data["segundo_Pf"]."-FISICA"."_PODER.pdf";
                    $path = Storage::putFileAs(
                        'documentos_abogados', $request->file('documentoPoder_pF'), $nombre_poder
                    );
                    $data_insertar["cedulaDocumento"] = $nombre_poder;
                }
                if(isset($data["documentoAnexo_pF"])){
                    $nombre_anexo = $data["nombre_pF"]." ".$data["primero_PF"]." ".$data["segundo_Pf"]."-FISICA"."_ANEXO.pdf";
                    $path = Storage::putFileAs(
                        'documentos_abogados', $request->file('documentoAnexo_pF'), $nombre_anexo
                    );
                    $data_insertar["anexo_documeto"] = $nombre_anexo;
                }                
                if(isset($data["num_int_pF"])){
                   $data_insertar["mun_int_patronal"] = $data["num_int_pF"];
                }

                $poder->update($data_insertar);
                return redirect()->route('poderes');
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
                        'fechaVigencia'                 => $data["fecha_vigencia_pF"],
                        'descipcion_poder'              => $data["descripcion_pF"],
                        'estatus'                       => $data["validacion"],
                        'idUsuario'                     => $id_usuario,
                );


                if(isset($data["documentoIne_pF"])){
                    $nombre_ine = $data["nombre_pF"]." ".$data["primero_PF"]." ".$data["segundo_Pf"]."-FISICA"."_IDENTIFICACION.pdf";
                    $path = Storage::putFileAs(
                        'documentos_abogados', $request->file('documentoIne_pF'), $nombre_ine
                    );
                    $data_insertar["ineDocumento"] = $nombre_ine;
                }
                if(isset($data["documentoRepresentacion_pF"])){
                    $nombre_reprecentacion = $data["nombre_pF"]." ".$data["primero_PF"]." ".$data["segundo_Pf"]."-FISICA"."_REPRESENTACION.pdf";
                    $path = Storage::putFileAs(
                        'documentos_abogados', $request->file('documentoRepresentacion_pF'), $nombre_reprecentacion
                    );
                    $data_insertar["representacionDocumento"] = $nombre_reprecentacion;
                }
                if(isset($data["documentoPoder_pF"])){
                    $nombre_poder = $data["nombre_pF"]." ".$data["primero_PF"]." ".$data["segundo_Pf"]."-FISICA"."_PODER.pdf";
                    $path = Storage::putFileAs(
                        'documentos_abogados', $request->file('documentoPoder_pF'), $nombre_poder
                    );
                    $data_insertar["cedulaDocumento"] = $nombre_poder;
                }
                if(isset($data["documentoAnexo_pF"])){
                    $nombre_anexo = $data["nombre_pF"]." ".$data["primero_PF"]." ".$data["segundo_Pf"]."-FISICA"."_ANEXO.pdf";
                    $path = Storage::putFileAs(
                        'documentos_abogados', $request->file('documentoAnexo_pF'), $nombre_anexo
                    );
                    $data_insertar["anexo_documeto"] = $nombre_anexo;
                }                
                if(isset($data["num_int_pF"])){
                   $data_insertar["mun_int_patronal"] = $data["num_int_pF"];
                }

                $poder->update($data_insertar);
                return redirect()->route('poderes');
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
                'fechaVigencia'                 => $data["fecha_vigencia_Moral"],
                'descipcion_poder'              => $data["descripcion_Moral"],
                'estatus'                       => $data["validacion"],
                'idUsuario'                     => $id_usuario,
                'reprecentante'                 => "Si",
            );

            if(isset($data["documentoIne_Moral"])){
                $nombre_ine = $data["razon"]."-MORAL"."_IDENTIFICACION.pdf";
                $path = Storage::putFileAs(
                    'documentos_abogados', $request->file('documentoIne_Moral'), $nombre_ine
                );
                $data_insertar["ineDocumento"] = $nombre_ine;
            }
            if(isset($data["documentoRepresentacion_Moral"])){
                $nombre_reprecentacion = $data["razon"]."-MORAL"."_REPRESENTACION.pdf";
                $path = Storage::putFileAs(
                    'documentos_abogados', $request->file('documentoRepresentacion_Moral'), $nombre_reprecentacion
                );
                $data_insertar["representacionDocumento"] = $nombre_reprecentacion;
            }
            if(isset($data["documentoPoder"])){
                $nombre_poder = $data["razon"]."-MORAL"."_PODER.pdf";
                $path = Storage::putFileAs(
                    'documentos_abogados', $request->file('documentoPoder'), $nombre_poder
                );
                $data_insertar["cedulaDocumento"] = $nombre_poder;
            }
             if(isset($data["documentoAnexo"])){
                $nombre_anexo = $data["razon"]."-MORAL"."_ANEXO.pdf";
                $path = Storage::putFileAs(
                    'documentos_abogados', $request->file('documentoAnexo'), $nombre_anexo
                );
                $data_insertar["anexo_documeto"] = $nombre_anexo;
            }

            
            if(isset($data["num_int"])){
                $data_insertar["mun_int_patronal"] = $data["num_int"];
            }
                
            $poder->update($data_insertar);
            return redirect()->route('poderes');
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
                    "fecha_vigencia_pF"         => 'required',
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
                "fecha_vigencia_Moral"          => 'required',
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
                *La validación del registro patronal quedará sujeta a la certificación de la documentación que realice la persona conciliadora, loanterior de conformidad con lo 
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
                        'fechaVigencia'                 => $data["fecha_vigencia_pF"],
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
                
                Poder::create($data_insertar);  
                $data = Poder::latest('idAbogado')->first();

                $mensaje = "Su registro fue guardado con éxito, tu número de folio es: ".$data["idAbogado"]. " 
                *La validación del registro patronal quedará sujeta a la certificación de la documentación que realice la persona conciliadora, loanterior de conformidad con lo 
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
                    'fechaVigencia'                 => $data["fecha_vigencia_Moral"],
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
                    
            Poder::create($data_insertar);  
            $data = Poder::latest('idAbogado')->first();

            $mensaje = "Su registro fue guardado con éxito, tu número de folio es: ".$data["idAbogado"]. " 
            *La validación del registro patronal quedará sujeta a la certificación de la documentación que realice la persona conciliadora, loanterior de conformidad con lo 
            establecido en el artículo 684-I, fracción I y II, de la Ley Federal del Trabajo; por lo que se le solicita acudir a su siguiente audiencia de conciliación con la 
            Documentación original en formato físico, a fin de realizar el cotejo correspondiente.";
                    
                    
            return redirect()->back()->with('success', $mensaje);
        }
    }

}
