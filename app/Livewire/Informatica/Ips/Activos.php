<?php

namespace App\Livewire\Informatica\Ips;

use App\Models\Tbl_biene;
use App\Models\Tbl_sede;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Activos extends Component
{
    protected $listeners = ['ipActivado' => '$refresh'];

    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $modal_header_titulo = 'nuevo';
    public $modal_header_color = 'primary-subtle';
    public $btn_guardar_actualizar = 'guardar';
    public $btn_guardar_actualizar_color = 'primary';

    // Variables de Modal
    public $modal_abierto_personal = false;
    public $modal_abierto_imagen = false;

    // Variables de tabla
    public $codsede,$coddependencia;
    public $filtro_dependencia,$filtro_ip;

    //Buscar
    public $searcha;
    public function updatingSearcha(){
        $this->resetPage();
    }


    public function render()
    {
        $lista_activos = Tbl_biene::where('activo','1')
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
            ->when($this->searcha, function ($query) {
                $query->where(function ($q) {
                    $q->where('cod_usuario', 'like', '%' . $this->searcha . '%')
                    ->orWhere('cod_pat', 'like', '%' . $this->searcha . '%')
                    ->orWhere('ip','like','%' . $this->searcha . '%');
                });
            })
            ->orderBy('desc_usuario', 'desc')
            ->paginate(12);

        $lista_sedes = Tbl_sede::select('codsedeofi','nomsedeofi')
            ->where('activo','1')
            ->distinct()
            ->orderBy('nomsedeofi')
            ->get();
            
        $lista_dependencias = Tbl_sede::select('coddepofi','nomdepofi')
            ->where('activo','1')
            ->when($this->codsede, function($query, $codsede) {
                $query->where('codsedeofi', $codsede);
            })
            ->distinct()
            ->orderBy('nomdepofi')
            ->get();

        //Lista Nombre Sede Oficina
            $lista_sedes_dependencias_despachos = Tbl_biene::select('nomsedeofi', DB::raw('COUNT(cod_pat) as total'))
            ->where('activo', '1')
            ->where('clase', 'COMPUTO')
            ->whereIn('familia', [
                'COMPUTADORA PERSONAL PORTATIL',
                'UNIDAD CENTRAL DE PROCESO - CPU'
            ])
            ->whereNotIn('nomsedeofi', [
                    'CASA ACOGIDA TAMBO'
                ])
            ->groupBy('nomsedeofi')
            ->get();
        

        return view('livewire.informatica.ips.activos',
                compact('lista_activos','lista_sedes_dependencias_despachos',
                'lista_sedes','lista_dependencias')
            );
    }

    public function nuevo(){
        $this->modal_abierto_personal = true;

        $this->modal_header_titulo = 'nuevo';
        $this->modal_header_color = 'primary-subtle';
        $this->btn_guardar_actualizar = 'guardar';
        $this->btn_guardar_actualizar_color = 'primary';
    }

    public function guardar(){

    }


    public function editar(Tbl_biene $ibien){
        $this->modal_abierto_personal = true;

        $this->modal_header_titulo = 'editar';
        $this->modal_header_color = 'success-subtle';
        $this->btn_guardar_actualizar = 'actualizar';
        $this->btn_guardar_actualizar_color = 'success';
    }

    public function actualizar(){
        
    }

    public function cerrar(){
        $this->modal_abierto_personal = false;
    }
}
