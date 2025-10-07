<?php

namespace App\Livewire\Informatica\Firmas\Token;

use App\Models\Tbl_tokens_asignado;
use Barryvdh\DomPDF\Facade\Pdf;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Activos extends Component
{
    protected $listeners = ['tokensActivado' => '$refresh'];

    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    // Variable de entorno
    public $modal_header_titulo = 'nuevo';
    public $modal_header_color = 'primary-subtle';
    public $btn_guardar_actualizar = 'guardar';
    public $btn_guardar_actualizar_color = 'primary';

    // Variables de Modal
    public $modal_abierto_personal = false;
    public $modal_abierto_imagen = false;

    public $filtro_rutas,$filtro_asignados;

    //Buscar
    public $searcha;
    public function updatingSearcha(){
        $this->resetPage();
    }

    public function render()
    {
        $lista_activos = Tbl_tokens_asignado::where('activo','1')
            ->when($this->searcha !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->searcha. '%')
                    ->orWhere('datos', 'like', '%' . $this->searcha . '%');
                });
            })
            // Filtro por rutas
            ->when($this->filtro_rutas === 'con', function ($query) {
                $query->whereNotNull('actaruta')->where('actaruta', '<>', '');
            })
            ->when($this->filtro_rutas === 'sin', function ($query) {
                $query->where(function ($subquery) {
                    $subquery->whereNull('actaruta')->orWhere('actaruta', '');
                });
            })
            // Filtro por usuarios y asignacion
            ->when($this->filtro_asignados === 'ASIGNACION', function ($query) {
                $query->whereNotNull('asignacion')->where('asignacion', '=', 'ASIGNACION')->where('created_user','=',$this->filtro_usuarios);
            })            
            ->when($this->filtro_asignados === 'DEVOLUCION', function ($query) {
                $query->where(function ($subquery) {
                    $subquery->whereNull('asignacion')->orWhere('asignacion', '=','DEVOLUCION')->where('created_user','=',$this->filtro_usuarios);
                });
            })

            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.informatica.firmas.token.activos',
            compact('lista_activos'));
    }
}
