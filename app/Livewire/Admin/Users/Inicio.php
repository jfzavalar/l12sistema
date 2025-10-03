<?php

namespace App\Livewire\Admin\Users;

use App\Models\Tblsede;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Inicio extends Component
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

    // Variables de tabla
    public $dni,$datos,$codsede,$sede,$coddependencia,$dependencia,$regimen,$cargo,$correo_personal,$correo_institucional,$cel_personal,$cel_institucional,$observacion,$avatar,$activo,$created_user,$updated_user;
    public $ip_equipo;

    public function render()
    {
        $lista_activos = User::where('activo','1')
            ->when($this->searcha !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->searcha . '%')
                    ->orWhere('datos', 'like', '%' . $this->searcha . '%');
                });
            })
            ->orderBy('datos')
            ->paginate(10);

        $lista_sedes = Tblsede::select('codsedeofi','nomsedeofi')
            ->where('activo','1')
            ->distinct()
            ->orderBy('nomsedeofi')
            ->get();
            
        $lista_dependencias = Tblsede::select('coddepofi','nomdepofi')
            ->where('activo','1')
            ->when($this->codsede, function($query, $codsede) {
                $query->where('codsedeofi', $codsede);
            })
            ->distinct()
            ->orderBy('nomdepofi')
            ->get();

        return view('livewire.admin.users.inicio',
                compact('lista_activos',
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


    public function editar(User $iusuario){
        $this->modal_abierto_personal = true;

        $this->modal_header_titulo = 'editar';
        $this->modal_header_color = 'success-subtle';
        $this->btn_guardar_actualizar = 'actualizar';
        $this->btn_guardar_actualizar_color = 'success';

        // Llenado de variables

        $this->dni = $iusuario->dni;
        $this->datos = $iusuario->datos;
        $this->codsede = $iusuario->codsede;
        $this->sede = $iusuario->sede;
        $this->coddependencia = $iusuario->coddependencia;
        $this->dependencia = $iusuario->dependencia;
        $this->regimen = $iusuario->regimen;
        $this->cargo = $iusuario->cargo;
        $this->correo_personal = $iusuario->correo_personal;
        $this->correo_institucional = $iusuario->correo_institucional;
        $this->avatar = $iusuario->avatar;
        $this->activo = $iusuario->activo;
        $this->created_user = $iusuario->created_user;
        $this->updated_user = $iusuario->updated_user;

        // Captura la IP del cliente
        $this->ip_equipo = request()->ip();
    }

    public function actualizar(){
        
    }

    public function desactivar(User $iusuario){
        try {
            $iusuario->update([
                'activo' => '0',
                'updated_user' => auth()->user()->datos,
            ]);

            // Comunica que se desactivado
            $this->dispatch('usuarioDesactivado');

            session()->flash('danger', 'Usuario desactivado correctamente');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al desactivar el usuario: ' . $e->getMessage());
        }
    }

    public function cerrar(){
        $this->modal_abierto_personal = false;

        // Variable de entorno
        $this->reset(['modal_header_titulo','modal_header_color','btn_guardar_actualizar','btn_guardar_actualizar_color',
                        'dni','datos','codsede','sede','coddependencia','dependencia','regimen','cargo','correo_personal','correo_institucional','cel_personal','cel_institucional','observacion','avatar','activo','created_user','updated_user']);
    }

    public function editar_imagen(){
        $this->modal_abierto_imagen = true;
    }

    public function cerrar_imagen(){
        $this->modal_abierto_imagen = false;

        // Variable de entorno
        $this->reset(['avatar']);
    }
}
