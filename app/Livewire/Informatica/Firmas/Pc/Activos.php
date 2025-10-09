<?php

namespace App\Livewire\Informatica\Firmas\Pc;

use App\Models\Tbl_firmas_pc;
use App\Models\Tbl_personale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Activos extends Component
{
    protected $listeners = ['pcActivado' => '$refresh'];

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
    public $searchpersonal;
    public function updatingSearchpersonal(){
        $this->resetPage();
    }

    public function render()
    {
        $lista_activos = Tbl_firmas_pc::where('activo',"1")
            ->where(function ($query) {$query
                ->where('dni', 'like', '%' . $this->searcha . '%')
                ->orWhere('datos', 'like', '%' . $this->searcha . '%');
            })
            ->orderBy('id','desc')
            ->paginate(10);

        $totales_asignados = Tbl_firmas_pc::select(
                'created_user',
                DB::raw("SUM(CASE WHEN asignacion = 'ASIGNACION' THEN 1 ELSE 0 END) AS total_asignados"),
                DB::raw("SUM(CASE WHEN asignacion = 'DEVOLUCION' THEN 1 ELSE 0 END) AS total_devueltos")
            )
            ->where('activo', "1")
            ->groupBy('created_user')
            ->get();

        $lista_personal = Tbl_personale::where('activo','1')
            ->where('dni','like','%' .$this->searchpersonal .'%')
            ->orwhere('datos','like','%' .$this->searchpersonal .'%')
            ->paginate(5);

        return view('livewire.informatica.firmas.pc.activos',
            compact('lista_activos','totales_asignados','lista_personal'));
    }
}
