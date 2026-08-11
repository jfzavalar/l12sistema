<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionInformaticaSpijwebUserPass extends Mailable
{
    use Queueable, SerializesModels;

    public $registro;

    public function __construct($registro)
    {
        $this->registro = $registro;
    }

    public function build()
    {
        // Enviamos el correo

        return $this->subject('DFJunin: Notificación Informática')
            ->view('emails.informatica.spijwebuserpass')
            ->with([
                'registro' => $this->registro,
            ]);
    }
}
