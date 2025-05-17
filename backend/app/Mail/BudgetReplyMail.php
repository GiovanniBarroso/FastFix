<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BudgetReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $mensaje;

    /**
     * Crea una nueva instancia del mensaje.
     */
    public function __construct($nombre, $mensaje)
    {
        $this->nombre = $nombre;
        $this->mensaje = $mensaje;
    }

    /**
     * Configura el asunto del correo.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '📩 Respuesta a tu solicitud de presupuesto',
        );
    }

    /**
     * Define la vista del contenido del mensaje.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.budget-reply',
        );
    }

    /**
     * Archivos adjuntos (ninguno en este caso).
     */
    public function attachments(): array
    {
        return [];
    }
}
