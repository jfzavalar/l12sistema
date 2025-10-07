<?php

namespace App\Livewire\Informatica\Ips;

use App\Models\Tbl_biene;
use Livewire\Component;

class Inactivos extends Component
{
    protected $listeners = ['ipDesactivado' => '$refresh'];

    public $filtro_dependencia,$filtro_ip;

    //Buscar
    public $searchi;
    public function updatingSearchi(){
        $this->resetPage();
    }

    public function render()
    {
        $lista_inactivos = Tbl_biene::where('activo','0')
            ->where('clase', 'COMPUTO')
            ->whereIn('familia', [
                'COMPUTADORA PERSONAL PORTATIL',
                'UNIDAD CENTRAL DE PROCESO - CPU'
            ])
            ->whereNotIn('nomsedeofi', [
                'CASA ACOGIDA TAMBO'
            ])
            ->when($this->filtro_dependencia, function ($query) {
                $query->where('nomsedeofi', $this->filtro_dependencia);
            })
            ->when($this->filtro_ip !== null, function ($query) {
                if ($this->filtro_ip === "1") {
                    // Con IP
                    $query->whereNotNull('ip');
                } elseif ($this->filtro_ip === "0") {
                    // Sin IP
                    $query->whereNull('ip');
                }
            })
            ->when($this->searchi, function ($query) {
                $query->where(function ($q) {
                    $q->where('cod_usuario', 'like', '%' . $this->searchi . '%')
                    ->orWhere('cod_pat', 'like', '%' . $this->searchi . '%')
                    ->orWhere('ip','like','%' . $this->searchi . '%');
                });
            })
            ->orderBy('desc_usuario', 'desc')
            ->paginate(12);

        return view('livewire.informatica.ips.inactivos',
                compact('lista_inactivos'));
    }

    public function activar(Tbl_biene $iBien){
        try {
            $iBien->update([
                'activo' => '1',
                'updated_user' => auth()->user()->datos,
            ]);

            // Comunica que se activado
            $this->dispatch('ipActivado');

            session()->flash('success', 'Usuario activado correctamente');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al activar el usuario: ' . $e->getMessage());
        }
        
    }
}
