<?php

namespace App\Livewire\Admin\Permissions;

use App\Models\Permission;
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

    // Variables de Modal
    public $modal_abierto_personal = false;
    public $modal_abierto_imagen = false;

    //Buscar
    public $searcha;
    public function updatingSearcha(){
        $this->resetPage();
    }

    public function render()
    {
        $lista_activos = Permission::where('activo','1')
            ->when($this->searcha !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->searcha . '%');
                });
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.permissions.activos',compact('lista_activos'));
    }

    public function nuevo(){
        $this->modal_abierto_personal = true;

        $this->modal_header_titulo = 'nuevo';
        $this->modal_header_color = 'primary-subtle';
        $this->btn_guardar_actualizar = 'guardar';
        $this->btn_guardar_actualizar_color = 'primary';
    }

    public function editar(Permission $iusuario){
        $this->modal_abierto_personal = true;

        $this->modal_header_titulo = 'editar';
        $this->modal_header_color = 'success-subtle';
        $this->btn_guardar_actualizar = 'actualizar';
        $this->btn_guardar_actualizar_color = 'success';

        // Llenado de variables

        // $this->dni = $iusuario->dni;

    }

    public function cerrar(){
        $this->modal_abierto_personal = false;

        // Variable de entorno
        // $this->reset(['modal_header_titulo','modal_header_color','btn_guardar_actualizar','btn_guardar_actualizar_color',
        //                 'dni','datos','codsede','sede','coddependencia','dependencia','regimen','cargo','correo_personal','correo_institucional','cel_personal','cel_institucional','observacion','avatar','activo','created_user','updated_user']);
    }
}
