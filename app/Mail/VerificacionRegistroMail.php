<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificacionRegistroMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $nombreCompleto;
    public string $enlaceVerificacion;
    public int $minutosExpiracion;

    public function __construct(string $nombreCompleto, string $token, int $minutosExpiracion = 10)
    {
        $this->nombreCompleto = $nombreCompleto;
        $this->enlaceVerificacion = url("/registro/verificar/{$token}");
        $this->minutosExpiracion = $minutosExpiracion;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verificación de Registro — Sistema UGELAA',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verificacion-registro',
        );
    }
}
