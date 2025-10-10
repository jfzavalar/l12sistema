<?php

namespace App\Livewire\Administracion\Patrimonio\Bienes;

use Livewire\Component;

class Activos extends Component
{
    public $modal_header_titulo = 'nuevo';
    public $modal_header_color = 'primary-subtle';
    public $btn_guardar_actualizar = 'guardar';
    public $btn_guardar_actualizar_color = 'primary';

    public function render()
    {
        return view('livewire.administracion.patrimonio.bienes.activos');
    }

    public function nuevo(){
        $this->modal_header_titulo = 'nuevo';
        $this->modal_header_color = 'primary-subtle';
        $this->btn_guardar_actualizar = 'guardar';
        $this->btn_guardar_actualizar_color = 'primary';
    }

    public function guardar(){

    }


    public function editar(){
        $this->modal_header_titulo = 'editar';
        $this->modal_header_color = 'success-subtle';
        $this->btn_guardar_actualizar = 'actualizar';
        $this->btn_guardar_actualizar_color = 'success';
    }

    public function actualizar(){
        
    }

    public function cerrar(){

    }
}
