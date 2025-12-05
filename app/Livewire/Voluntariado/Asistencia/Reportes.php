<?php

namespace App\Livewire\Voluntariado\Asistencia;

use App\Models\Tbl_voluntariado_marcacione;
use Illuminate\Support\Facades\DB;

use Livewire\Component;

use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Reportes extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = "bootstrap";

    // Variable de entorno
    public $modal_header_titulo = 'nuevo';
    public $modal_header_color = 'primary-subtle';
    public $btn_guardar_actualizar = 'guardar';
    public $btn_guardar_actualizar_color = 'primary';
    public $fieldset_disable = 'disabled';

    public $filtro_fecha_inicio,$filtro_fecha_fin;

    //Buscar
    public $searchpersonalr;
    public function updatingSearchpersonalr(){
        $this->resetPage();
    }
    
    public function render()
    {
        $lista_reportes = Tbl_voluntariado_marcacione::select(
                'dni',
                'datos',
                'sede_destino',
                'dependencia_destino',
                DB::raw("
                    SEC_TO_TIME(
                        SUM(
                            TIMESTAMPDIFF(SECOND, hora_entrada, hora_salida)
                        )
                    ) as total_tiempo
                ")
            )
            ->where('activo', '1')
            ->when($this->filtro_fecha_inicio && $this->filtro_fecha_fin, function ($query) {
                $query->whereBetween('fecha', [$this->filtro_fecha_inicio, $this->filtro_fecha_fin]);
            })
            ->when($this->searchpersonalr !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->searchpersonalr . '%')
                    ->orWhere('datos', 'like', '%' . $this->searchpersonalr . '%');
                });
            })
            ->groupBy('dni', 'datos','sede_destino','dependencia_destino')
            ->orderBy('datos')
            ->paginate(10);

        return view('livewire.voluntariado.asistencia.reportes',
                compact('lista_reportes'));
    }
}
