<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class Inicio extends Component
{
    public $modal_header_titulo = 'nuevo';
    public $modal_header_color = 'primary-subtle';
    public $btn_guardar_actualizar = 'guardar';
    public $btn_guardar_actualizar_color = 'primary';

    // Variables de tabla

    public function render()
    {
        return view('livewire.dashboard.inicio');
    }

    public function nuevo(){
        $this->modal_header_titulo = 'nuevo';
        $this->modal_header_color = 'primary-subtle';
        $this->btn_guardar_actualizar = 'guardar';
        $this->btn_guardar_actualizar_color = 'primary';
    }

    public function guardar(){

    }

    public function guardar_cerrar(){

    }


    public function editar(){
        $this->modal_header_titulo = 'editar';
        $this->modal_header_color = 'success-subtle';
        $this->btn_guardar_actualizar = 'actualizar';
        $this->btn_guardar_actualizar_color = 'success';
    }

    public function actualizar(){
        
    }

    public function actualizar_cerrar(){

    }
}
