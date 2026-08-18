<?php

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionInformaticaSpijweb extends Mailable
{
    use Queueable, SerializesModels;

    public $registro;

    public function __construct($registro)
    {
        $this->registro = $registro;
    }

    public function build()
    {
        // Generar el PDF usando la vista spijweb-acta
        $pdf = Pdf::loadView(
            'pdf.informatica.spijweb-acta',
            [
                'registro' => $this->registro,
            ]
        );

        return $this->subject('Remisión de Carta de Riesgo para Usuarios Finales – SPIJ WEB 2026')
            ->view('emails.informatica.spijweb')
            ->with([
                'registro' => $this->registro,
            ])
            ->attachData(
                $pdf->output(),
                'Spigweb-' . $this->registro->dni . '.pdf',
                [
                    'mime' => 'application/pdf',
                ]
            );
    }
}