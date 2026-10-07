<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RecuperarPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $nombreCompleto;
    public string $enlaceReset;

    public function __construct(string $nombreCompleto, string $token)
    {
        $this->nombreCompleto = $nombreCompleto;
        $this->enlaceReset = url("/reset-password/{$token}");
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Recuperar Contraseña — Sistema UGELAA',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.recuperar-password',
        );
    }
}
