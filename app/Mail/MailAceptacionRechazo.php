<?php
// Archivo: app/Mail/WelcomeMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailAceptacionRechazo extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // Propiedad para pasar datos a la vista

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Define el Asunto y el Remitente (envelope)
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Actualizacion de solicitud',
            // from: new Address('otro_correo@app.com', 'Mi Aplicación') // Opcional, si quieres cambiar el remitente predeterminado
        );
    }

    /**
     * Define el contenido del correo (vista de Blade)
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.confirmacion',
        );
    }
    
    // ... otros métodos (attachments, etc.)
}