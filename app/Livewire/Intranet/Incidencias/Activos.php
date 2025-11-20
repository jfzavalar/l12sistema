<?php

namespace App\Livewire\Intranet\Incidencias;

use Livewire\Component;

class Activos extends Component
{

    public $filtro_anio,$filtro_mes;

    public function render()
    {
        return view('livewire.intranet.incidencias.activos');
    }
}
