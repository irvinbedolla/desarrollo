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
            'nombresAbogadoAlta'        => 'required',
            'primer_apellido'           => 'required',
            'segundo_apellido'          => 'required',
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
        $abogado = Poder::where(['nombres' => $data["nombresAbogadoAlta"], 'primer_apellido' => $data["primer_apellido"], 
        'segundo_apellido' => $data["segundo_apellido"], 'empresa' => $data["empresaAbogadoAlta"]])->first();
        if(!$abogado){

            $data_insertar= array(
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
                'estatus'               => "Pendiente"
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

            Poder::create($data_insertar);  
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
        $data = $request->all();
        $poder = Poder::find($id);



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


        request()->validate([
            'nombresAbogadoAlta'        => 'required',
            'primer_apellido'           => 'required',
            'segundo_apellido'          => 'required',
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
            'documentoIne'              => 'nullable',
            'documentoRepresentacion'   => 'nullable',
            'documentoPoder'            => 'nullable',
            'documentoAnexo'            => 'nullable',
            'estatus'                   => 'required',
        ], $data);
        

        //Validar las regiones
        if($regionmorelia == "No" && $regionuruapan == "No" && $regionzamora == "No"){
            return back()->withErrors('Debes seleccionar al menos una Región.');
        }
        

        //Vamos a revisar si cambiaron algun documento
        if(!$request->file('documentoIne')){
            $nombre_ine = $poder->ine;
        }
        else{
            $nombre_ine = $data["nombresAbogadoAlta"]."".$data["primer_apellido"]."".$data["segundo_apellido"]."-".$data["empresaAbogadoAlta"]."_IDENTIFICACION.pdf";
            //$Ine = $request->file('documentoIne')->getClientOriginalName();
        }
        if(!$request->file('documentoRepresentacion')){
            $nombre_representación = $poder->representacion;
        }
        else{
            $nombre_representación = $data["nombresAbogadoAlta"]."".$data["primer_apellido"]."".$data["segundo_apellido"]."-".$data["empresaAbogadoAlta"]."_REPRESENTACION.pdf";
            //$Reprecentacion = $request->file('documentoRepresentacion')->getClientOriginalName();
        }
        if(!$request->file('documentoAnexo')){
            if($poder->anexo === "Sin anexo"){
                $nombre_anexo = "Sin anexo";
            }
            else{
                $nombre_anexo = $poder->anexo;
            }
        }
        else{
            $nombre_anexo = $data["nombresAbogadoAlta"]."".$data["primer_apellido"]."".$data["segundo_apellido"]."-".$data["empresaAbogadoAlta"]."_ANEXO.pdf";
            //$Anexo = $request->file('documentoAnexo')->getClientOriginalName();
        }
        if(!$request->file('documentoPoder')){
            if($poder->cedula === "Sin anexo"){
                $nombre_poder = "Sin anexo";
            }
            else{
                $nombre_poder = $poder->poder;
            }
        }
        else{
            $nombre_poder = $data["nombresAbogadoAlta"]."".$data["primer_apellido"]."".$data["segundo_apellido"]."-".$data["empresaAbogadoAlta"]."_PODER.pdf";
            //$Poder = $request->file('documentoPoder')->getClientOriginalName();
        }



        if(isset($data["documentoIne"])){
            //$nombre_ine = $data["nombresAbogadoAlta"]."".$data["primer_apellido"]."".$data["segundo_apellido"]."-".$data["empresaAbogadoAlta"]."_IDENTIFICACION.pdf";
            $path = Storage::putFileAs(
                'documentos_abogados', $request->file('documentoIne'), $nombre_ine
            );
        }

        if(isset($data["documentoRepresentacion"])){
            //$nombre_representación = $data["nombresAbogadoAlta"]."".$data["primer_apellido"]."".$data["segundo_apellido"]."-".$data["empresaAbogadoAlta"]."_REPRESENTACION.pdf";
            $path = Storage::putFileAs(
                'documentos_abogados', $request->file('documentoRepresentacion'), $nombre_representación
            );
        }

        if(isset($data["documentoAnexo"])){
            //$nombre_anexo = $data["nombresAbogadoAlta"]."".$data["primer_apellido"]."".$data["segundo_apellido"]."-".$data["empresaAbogadoAlta"]."_ANEXO.pdf";
            $path = Storage::putFileAs(
                'documentos_abogados', $request->file('documentoAnexo'), $nombre_anexo
            );
        }

        if(isset($data["documentoPoder"])){
            //$nombre_poder = $data["nombresAbogadoAlta"]."".$data["primer_apellido"]."".$data["segundo_apellido"]."-".$data["empresaAbogadoAlta"]."_PODER.pdf";
            $path = Storage::putFileAs(
                'documentos_abogados', $request->file('documentoPoder'), $nombre_poder
            );
        }

        
        $data_update= array(
            'nombres'       => $data["nombresAbogadoAlta"],
            'primer_apellido' => $data["primer_apellido"],
            'segundo_apellido'=> $data["segundo_apellido"], 
            'telefono'      => $data["telefonoAbogadoAlta"], 
            'email'         => $data["correoAbogadoAlta"],
            'ine'           => $nombre_ine,
            'representacion'=> $nombre_representación,
            'cedula'        => $nombre_poder,
            'anexo'         => $nombre_anexo,
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
            'estatus'       => $data["estatus"]
        );


        $poder->update($data_update);
        return redirect()->route('poderes');
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
        $abogado = Poder::where(['nombres' => $data["nombresAbogadoAlta"], 'primer_apellido' => $data["primer_apellido"], 
        'segundo_apellido' => $data["segundo_apellido"], 'empresa' => $data["empresaAbogadoAlta"]])->first();
        if(!$abogado){

            $data_insertar = array(
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
                'estado_poder'          => $data["estado_poder"],
                'municipio_poder'       => $data["municipio_poder"],
                'vialidadPoder'         => $data["vialidadPoder"],
                'vialidad_callePoder'   => $data["vialidad_callePoder"],
                'coloniaAbogadoAlta'    => $data["coloniaAbogadoAlta"],
                'NExtAbogadoAlta'       => $data["NExtAbogadoAlta"],
                'NIntAbogadoAlta'       => $data["NIntAbogadoAlta"],
                'cpAbogadoAlta'         => $data["cpAbogadoAlta"],
                'rfc'               => $data["RFCAbogadoAlta"],
                'industria'         => $data["industriaAlta"],
                'poder'             => $data["descripcionpoderAlta"],
                'regionMorelia'     => $regionmorelia,
                'regionUruapan'     => $regionuruapan,
                'regionZamora'      => $regionuruapan,
                'estatus'           => "Pendiente"
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

            Poder::create($data_insertar);  
            $data = Poder::latest('idAbogado')->first();

            return redirect()->back()->with('success', ', Tu número de folio es: '.$data["idAbogado"].' Tienes 5 días para presentarte al centro de conciliación laboral, para confirmar tu identidad, con los documentos originales y una copia para cotejo, para la validación de tu registro.');   
        }
        else{
            return back()->withErrors('El poder ya tiene asignado ese abogado.');
        }
    }

}
