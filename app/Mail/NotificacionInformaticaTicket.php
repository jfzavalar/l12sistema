<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionInformaticaTicket extends Mailable
{
    public $dni, $datos, $cargo, $sede, $dependencia, $despacho;
    public $servicio, $detalle_servicio;
    public $adjuntos;

    public function __construct($dni, $datos, $cargo, $sede, $dependencia, $despacho, $servicio, $detalle_servicio, $adjuntos = [])
    {
        $this->dni = $dni;
        $this->datos = $datos;
        $this->cargo = $cargo;
        $this->sede = $sede;
        $this->dependencia = $dependencia;
        $this->despacho = $despacho;

        $this->servicio = $servicio;
        $this->detalle_servicio = $detalle_servicio;

        $this->adjuntos = $adjuntos;
    }

    public function build()
    {
        $mail = $this->subject('DFJunin: Notificación Informática')
            ->view('emails.informatica.ticket');


        // 📎 Adjuntos dinámicos
        foreach ($this->adjuntos as $file) {
            if (file_exists($file)) {
                $mail->attach($file);
            }
        }

        return $mail;
    }
}
