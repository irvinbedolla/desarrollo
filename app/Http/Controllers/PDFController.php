<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


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
}
