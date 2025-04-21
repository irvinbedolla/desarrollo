<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\SeerPerGeneral;
use App\Models\SeerCitados;
use App\Models\SeerMotivo;
use App\Models\SolicitudMotivo;
use App\Models\SolicitudRama;
use App\Models\SolicitudEconomica;
use App\Models\SeerMotivoSolicitud;
use App\Models\SeerSolicitante;


class PDFController extends Controller
{
    public function pdfEstadistica(){
        //Generar un PDF desde HTML
        
        //$pdf = app('dompdf.wrapper');
        //$pdf->loadHTML('<h1>Styde.net</h1>');
        //return $pdf->download('mi-archivo.pdf');
        
        //Genera PDF desde la vista
        $data = [
            'titulo' => 'Styde.net'
        ];
    
        $pdf = \PDF::loadView('PDF/vista-prueba', $data);
    
        return $pdf->download('archivo.pdf');


        //$pdf = \PDF::loadView('vista-pdf', $data);
        //return $pdf->download('mi-archivo.pdf');
        //return PDF::loadView('vista-pdf', $data)->stream('archivo.pdf');
    }
    public function pdfCitatorio($id){
        $solicitud = SeerPerGeneral::findOrFail($id);
        $solicitante = SeerSolicitante::where('id_solicitud', $id)->first();
        $citados = SeerCitados::where('id_solicitud', $id)->get();
        $motivoIds = SeerMotivo::where('id_solicitud', $id)->pluck('id_motivo');
        $motivos = SolicitudMotivo::whereIn('id', $motivoIds)->get();
       
        foreach ($citados as $citado) {
            $pdf = \PDF::loadView('PDF.citatorio', compact(
                'solicitud',
                'solicitante',
                'citado',
                'motivos',
            ));

            return $pdf->download('citatorio_' . $solicitud->id . '.pdf');
        }
        
    }    
}
