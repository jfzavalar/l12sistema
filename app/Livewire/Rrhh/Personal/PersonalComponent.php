<?php

namespace App\Livewire\Rrhh\Personal;

use App\Models\Personale;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PersonalComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

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

        return view('livewire.rrhh.personal.personal-component',
                        compact('lista_activos'));
    }

    public function nuevo()
    {
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
}
