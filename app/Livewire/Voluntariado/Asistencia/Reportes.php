<?php

namespace App\Livewire\Voluntariado\Asistencia;

use App\Models\Tbl_voluntariado_marcacione;
use Livewire\Component;
use Illuminate\Support\Facades\DB;


class Reportes extends Component
{
    protected $listeners = ['registroGuardado' => '$refresh'];

    public $searchpersonal;
    public $filtro_fecha_inicio, $filtro_fecha_fin;
    public function render()
    {
        $lista_reporte = Tbl_voluntariado_marcacione::select(
                'dni',
                'datos',
                DB::raw("
                    SEC_TO_TIME(
                        SUM(
                            IF(entrada_salida = 0, 
                                TIME_TO_SEC(hora_entrada), 
                                -TIME_TO_SEC(hora_entrada)
                            )
                        )
                    ) as total_tiempo
                ")
            )
            ->where('activo', '1')
            ->when($this->filtro_fecha_inicio && $this->filtro_fecha_fin, function ($query) {
                $query->whereBetween('fecha', [$this->filtro_fecha_inicio, $this->filtro_fecha_fin]);
            })
            ->when($this->searchpersonal !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->searchpersonal . '%')
                    ->orWhere('datos', 'like', '%' . $this->searchpersonal . '%');
                });
            })
            ->groupBy('dni', 'datos')
            ->orderBy('dni')
            ->paginate(10);


        return view('livewire.voluntariado.asistencia.reportes',
                compact('lista_reporte'));
    }
}
