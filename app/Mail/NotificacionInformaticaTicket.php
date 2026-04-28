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
    public $servicio, $detalle_servicio, $respuesta;
    public $enviado_lima, $glpi, $ncopias, $cod_patrimonial, $datos_bien;
    public $adjuntos;

    public function __construct($dni, $datos, $cargo, $sede, $dependencia, $despacho, $servicio, $detalle_servicio, $respuesta,
                                $enviado_lima, $glpi, $ncopias, $cod_patrimonial, $datos_bien,
                                $adjuntos = [])
    {
        $this->dni = $dni;
        $this->datos = $datos;
        $this->cargo = $cargo;
        $this->sede = $sede;
        $this->dependencia = $dependencia;
        $this->despacho = $despacho;

        $this->servicio = $servicio;
        $this->detalle_servicio = $detalle_servicio;
        $this->respuesta = $respuesta;

        $this->enviado_lima = $enviado_lima;
        $this->glpi = $glpi;
        $this->ncopias = $ncopias;
        $this->cod_patrimonial = $cod_patrimonial;
        $this->datos_bien = $datos_bien;

        $this->adjuntos = $adjuntos;
    }

    public function build()
    {
        $mail = $this->subject($this->servicio . ': ' . $this->detalle_servicio)
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
