<?php

namespace App\Livewire\Admin\Sedes;

use App\Models\Personales_sede;
use Livewire\Component;

class SedesComponent extends Component
{

    // Variables de búsqueda
    public $search;
    public function updatingSearch(){
        $this->resetPage('sedesPage');
    }

    public function render()
    {
        $lista_activos = Personales_sede::where('activo','1')
            ->where('nombre','like','%' . $this->search . '%')
            ->orderBy('nombre')
            ->paginate(30,['*'], 'sedesPage');

        return view('livewire.admin.sedes.sedes-component',
                        compact('lista_activos'));
    }
}
