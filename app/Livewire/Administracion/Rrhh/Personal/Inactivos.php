<?php

namespace App\Livewire\Administracion\Rrhh\Personal;

use App\Models\Tbl_personale;
use App\Models\Tbl_personales_contrato;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Inactivos extends Component
{
    protected $listeners = ['personalDesactivado' => '$refresh'];

    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    // Variable de entorno
    public $modal_header_titulo = 'nuevo';
    public $modal_header_color = 'primary-subtle';
    public $btn_guardar_actualizar = 'guardar';
    public $btn_guardar_actualizar_color = 'primary';
    public $fieldset_disable = 'disabled';

    // Variables de Modal
    public $modal_abierto_personal = false;
    public $modal_abierto_imagen = false;
    public $modal_abierto_historial = false;

    //Buscar
    public $search_personali;
    public function updatingSearch_personali(){
        $this->resetPage();
    }

    // Variables de tabla
    public $id_personal,
        $dni;

    public function render()
    {
        $lista_inactivos = Tbl_personale::where('activo','0')
            ->when($this->search_personali !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->search_personali . '%')
                    ->orWhere('datos', 'like', '%' . $this->search_personali . '%');
                });
            })
            ->orderBy('datos')
            ->paginate(10);

        $lista_historial = Tbl_personales_contrato::where('dni',$this->dni)
            ->orderBy('id','desc')
            ->paginate(10);

        return view('livewire.administracion.rrhh.personal.inactivos',
                compact('lista_inactivos','lista_historial'));
    }

    public function activar(Tbl_personale $iActivar){
        try {
            $iActivar->update([
                'activo' => '1',
                'updated_user' => auth()->user()->datos,
            ]);

            // Comunica que se desactivado
            $this->dispatch('personalActivado');

            session()->flash('danger', 'Usuario activado correctamente');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al activar el usuario: ' . $e->getMessage());
        }
    }
}
