<?php

namespace App\Livewire\Intranet\Atenciones;

use App\Models\Tbl_personale;
use App\Models\Tbl_sede;
use Barryvdh\DomPDF\Facade\Pdf;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Activos extends Component
{
    protected $listeners = ['usuarioActivado' => '$refresh'];

    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    // Variable de entorno
    public $modal_header_titulo = 'nuevo';
    public $modal_header_color = 'primary-subtle';
    public $btn_guardar_actualizar = 'guardar';
    public $btn_guardar_actualizar_color = 'primary';
    public $fieldset_disable = 'disable';

    public $modal_abierto_atenciones = false;
    public $modal_abierto_personal_buscar = false;

    // Variables personal
    public $id_personal,
        $dni,
        $datos,

        $codsede_origen,
        $sede_origen,
        $coddependencia_origen,
        $dependencia_origen,

        $codsede_destino,
        $sede_destino,
        $coddependencia_destino,
        $dependencia_destino,

        $regimen,
        $cargo,
        $correo_personal,
        $correo_institucional,
        $cel_personal,
        $cel_institucional,
        $observacion,
        $avatar,
        $activo,
        $created_user,
        $updated_user;

    public $filtro_anio,$filtro_mes;
    public $searchpersonalatenciones;
    public function updatingSearchpersonalatenciones(){
        $this->resetPage();
    }
    public $searchbuscarpersonal;
    public function updatingSearchbuscarpersonal(){
        $this->resetPage();
    }

    public function render()
    {
        $lista_personal = Tbl_personale::where('activo','1')
            ->where('dni','like','%' .$this->searchbuscarpersonal .'%')
            ->orwhere('datos','like','%' .$this->searchbuscarpersonal .'%')
            ->paginate(5);

        $lista_sedes = Tbl_sede::select('codsedeofi','nomsedeofi')
            ->where('activo','1')
            ->distinct()
            ->orderBy('nomsedeofi')
            ->get();
            
        $lista_dependencias = Tbl_sede::select('coddepofi','nomdepofi')
            ->where('activo','1')
            ->where('codsedeofi',$this->codsede_destino)
            ->distinct()
            ->orderBy('nomdepofi')
            ->get();

        return view('livewire.intranet.atenciones.activos',
                compact('lista_personal','lista_sedes','lista_dependencias'));
    }

    public function nuevo(){
        $this->modal_abierto_atenciones = true;
    }

    public function cerrar(){
        $this->modal_abierto_atenciones = false;
    }

    // PERSONAL
    // ---------------------------------------------------------
    public function buscar_personal(){
        $this->modal_abierto_personal_buscar = true;
    }

    public function agregar_personal(Tbl_personale $ipersonal){
        $this->id_personal = $ipersonal->id;
        $this->dni = $ipersonal->dni;
        $this->datos = $ipersonal->datos;

        $this->codsede_origen = $ipersonal->codsede_origen;
        $this->sede_origen = $ipersonal->sede_origen;
        $this->coddependencia_origen = $ipersonal->coddependencia_origen;
        $this->dependencia_origen = $ipersonal->dependencia_origen;

        $this->codsede_destino = $ipersonal->codsede_destino;
        $this->sede_destino = $ipersonal->sede_destino;
        $this->coddependencia_destino = $ipersonal->coddependencia_destino;
        $this->dependencia_destino = $ipersonal->dependencia_destino;

        $this->regimen = $ipersonal->regimen;
        $this->cargo = $ipersonal->cargo;
        $this->correo_personal = $ipersonal->correo_personal;
        $this->correo_institucional = $ipersonal->correo_institucional;
        $this->cel_personal = $ipersonal->cel_personal;
        $this->cel_institucional = $ipersonal->cel_institucional;

        $this->reset('searchbuscarpersonal');

        $this->modal_abierto_personal_buscar = false;

    }
}
