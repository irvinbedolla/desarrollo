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

    public $userData; // Propiedad para pasar datos a la vista

    public function __construct($userData)
    {
        $this->userData = $userData;
    }

    /**
     * Define el Asunto y el Remitente (envelope)
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Solicitud Capturada',
            // from: new Address('otro_correo@app.com', 'Mi Aplicación') // Opcional, si quieres cambiar el remitente predeterminado
        );
    }

    /**
     * Define el contenido del correo (vista de Blade)
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.confirmacion_solicitud', // Nombre de la plantilla Blade (archivo: resources/views/emails/welcome.blade.php)
        );
    }
    
}