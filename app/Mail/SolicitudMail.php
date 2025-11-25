<?php
// Archivo: app/Mail/SolicitudMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SolicitudMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $pdfContent;
    public $variables; // Propiedad para pasar datos a la vista

    public function __construct($pdfContent, $variables)
    {
        $this->pdfContent = $pdfContent;
        $this->variables = $variables;
    }

    /**
     * Define el Asunto y el Remitente (envelope)
     */
    public function build()
    {
        return $this->subject('Solicitud Capturada')
                    
                    // 1. Define el cuerpo del correo (el mensaje)
                    // Pasa los datos dinámicos a la vista del email
                    ->view('emails.confirmacion_solicitud') 
                    ->with([
                        'variables' => $this->variables,
                    ])
                    
                    // 2. Adjunta el PDF generado en memoria
                    ->attachData($this->pdfContent, 'Acuse de solicitud.pdf', [
                        'mime' => 'application/pdf', 
                    ]);
    }
   
}