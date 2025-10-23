<?php

namespace App\Livewire\Administracion\Patrimonio\Bienes;

use App\Models\Tbl_biene;
use Livewire\Component;

class Inactivos extends Component
{
    //Buscar
    public $searchbienesinactivos;
    public function updatingSearchbienesinactivos(){
        $this->resetPage('activosPage');
    }

    public function render()
    {
        $lista_inactivos = Tbl_biene::where('activo','0')
            ->when($this->searchbienesinactivos !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('nro_pecosa', 'like', '%' . $this->searchbienesinactivos. '%')
                    ->orWhere('cod_pat', 'like', '%' . $this->searchbienesinactivos . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(20,['*'], 'activosPage');

        return view('livewire.administracion.patrimonio.bienes.inactivos',
                compact('lista_inactivos'));
    }
}
