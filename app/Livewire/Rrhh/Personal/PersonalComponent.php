<?php

namespace App\Livewire\Rrhh\Personal;

use App\Models\Personale;
use App\Models\Tbl_cargo;
use App\Models\Tbl_sede;
use App\Models\Tblsede;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PersonalComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $mostrarBtnBuscarDni = "d-none";

    public $colorHeaderModal, $textoHeaderModal;
    public $colorNuevoEditar, $textoNuevoEditar;
    public $colorGuardarActualizar, $textoGuardarActualizar;

    public $search;
    public function updatingSearch(){
        $this->resetPage('usuarioPage');
    }

    public $dni,
            $datos,
            $appaterno,
            $apmaterno,
            $nombres,
            $genero,
            $estadocivil,
            $fechanacimiento,
            $regimen,
            $cargo,
            $codsedeorigen,
            $sedeorigen,
            $coddependenciaorigen,
            $dependenciaorigen,
            $coddespachoorigen,
            $despachoorigen,
            $codsededestino,
            $sededestino,
            $coddependenciadestino,
            $dependenciadestino,
            $coddespachodestino,
            $despachodestino,
            $celpersonal,
            $celinstitucional,
            $correopersonal,
            $correoinstitucional,
            $foto,
            $activo,
            $created_user,
            $updated_user,
            $created_at,
            $updated_at;

    public function render()
    {
        $lista_activos = Personale::where('activo','1')
            ->when($this->search !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->search . '%')
                    ->orWhere('datos', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('datos')
            ->paginate();

        $lista_sedes = Tbl_sede::select('codsedeofi','nomsedeofi')
            ->where('activo','1')
            ->distinct()
            ->orderBy('nomsedeofi')
            ->get();
            
        $lista_dependencias = Tbl_sede::select('coddepofi','nomdepofi')
            ->where('activo','1')
            ->where('codsedeofi',$this->codsedeorigen)
            ->distinct()
            ->orderBy('nomdepofi')
            ->get();

        $lista_cargos = Tbl_cargo::select('id','cargo')
            ->where('activo','1')
            ->orderBy('cargo')
            ->get();

        return view('livewire.rrhh.personal.personal-component',
                        compact('lista_activos','lista_sedes','lista_dependencias','lista_cargos'));
    }

    public function nuevo()
    {
        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "Nuevo";
        $this->colorGuardarActualizar = "primary";
        $this->textoGuardarActualizar = "Guardar";
    }

    public function guardar()
    {

    }

    public function editar()
    {
        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "success-subtle";
        $this->textoHeaderModal = "Editar";
        $this->colorGuardarActualizar = "success";
        $this->textoGuardarActualizar = "Actualizar";
    }

    public function actualizar()
    {

    }

    public function cerrar()
    {

    }

    // FUNCIONES PARA BUSCAR

    public function buscar_sede()
    {

    }

    public function buscar_dependencia()
    {
        
    }

    public function buscar_cargo()
    {
        
    }

    // FUNCIONES AGREGAR

    public function agregar_sede(Tblsede $isede)
    {
        $this->codsedeorigen = (string) $isede->codsedeofi;
    }
}
