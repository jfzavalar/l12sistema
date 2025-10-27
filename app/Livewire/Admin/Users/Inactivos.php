<?php

namespace App\Livewire\Admin\Users;

use App\Models\Tblsede;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Inactivos extends Component
{
    protected $listeners = ['usuarioDesactivado' => '$refresh'];

    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    //Buscar
    public $searchusuarioi;
    public function updatingSearchusuarioi(){
        $this->resetPage();
    }
    
    public function render()
    {
        $lista_inactivos = User::where('activo','0')
            ->when($this->searchusuarioi !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->searchusuarioi . '%')
                    ->orWhere('datos', 'like', '%' . $this->searchusuarioi . '%');
                });
            })
            ->orderBy('datos')
            ->paginate(10);

        return view('livewire.admin.users.inactivos',compact('lista_inactivos'));
    }

    public function activar(User $iusuario){
        try {
            $iusuario->update([
                'activo' => '1',
                'updated_user' => auth()->user()->datos,
            ]);

            // Comunica que se activado
            $this->dispatch('usuarioActivado');

            session()->flash('success', 'Usuario activado correctamente');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al activar el usuario: ' . $e->getMessage());
        }
        
    }
}
