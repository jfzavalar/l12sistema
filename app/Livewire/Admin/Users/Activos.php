<?php

namespace App\Livewire\Admin\Users;

use App\Models\Tbl_personale;
use App\Models\Tbl_sede;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Hash;

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

    // Variables de Modal
    public $modal_abierto_personal = false;
    public $modal_abierto_personal_buscar = false;
    public $modal_abierto_imagen = false;

    //Buscar
    public $searchusuario;
    public function updatingSearchusuario(){
        $this->resetPage('usuarioPage');
    }
    public $searchbuscarpersonal;
    public function updatingSearchbuscarpersonal(){
        $this->resetPage();
    }

    // Variables de tabla
    public $id_usuario,
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
        $password,
        $activo,
        $created_user,
        $updated_user;

    public function render()
    {
        $lista_activos = User::where('activo','1')
            ->when($this->searchusuario !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->searchusuario . '%')
                    ->orWhere('datos', 'like', '%' . $this->searchusuario . '%');
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
            ->where('codsedeofi',$this->codsede_destino)
            ->distinct()
            ->orderBy('nomdepofi')
            ->get();

        $lista_personal = Tbl_personale::where('activo','1')
            ->where('dni','like','%' .$this->searchbuscarpersonal .'%')
            ->orwhere('datos','like','%' .$this->searchbuscarpersonal .'%')
            ->paginate(5);

        return view('livewire.admin.users.activos',
                compact('lista_activos',
                'lista_sedes','lista_dependencias','lista_personal')
            );
    }

    protected function rules(){
        return [
            'dni' => 'required|string|unique:users,dni,' . $this->id_usuario,
            'datos' => 'required',
            'codsede_destino' => 'required',
            'coddependencia_destino' => 'required',
            'regimen' => 'required',
            'cargo' => 'required',
        ];
    }

    protected $messages = [
        'dni.required' => 'El dni es obligatorio.',
        'dni.unique' => 'El dni ya fue registrado.',
        'datos.required' => '',
        'sede.required' => '',
        'dependencia.required' => '',
        'regimen.required' => '',
        'cargo.required' => '',
    ];

    public function nuevo(){
        $this->reset([]);

        $this->modal_abierto_personal = true;

        $this->modal_header_titulo = 'nuevo';
        $this->modal_header_color = 'primary-subtle';
        $this->btn_guardar_actualizar = 'guardar';
        $this->btn_guardar_actualizar_color = 'primary';
    }

    public function guardar(){
        $validated = $this->validate();

        try {
            user::create([
                'dni' => $this->dni,
                'datos' => strtoupper($this->datos),

                'codsede_origen' => $this->codsede_origen,
                'sede_origen' => $this->sede_origen,
                'coddependencia_origen' => $this->coddependencia_origen,
                'dependencia_origen' => $this->dependencia_origen,

                'codsede_destino' => $this->codsede_destino,
                'sede_destino' => Tbl_sede::where('codsedeofi',$this->codsede_destino)->value('nomsedeofi'),
                'coddependencia_destino' => $this->coddependencia_destino,
                'dependencia_destino' => Tbl_sede::where('coddepofi',$this->coddependencia_destino)->value('nomdepofi'),

                'regimen' => $this->regimen,
                'cargo' => $this->cargo,
                'cel_personal' => $this->cel_personal,
                'correo_personal' => strtolower($this->correo_personal),
                'cel_institucional' => $this->cel_institucional,
                'correo_institucional' => strtolower($this->correo_institucional),

                'password' => Hash::make($this->dni),

                'avatar' => $this->avatar,
                'activo' => '1',
                
                'created_user' => $this->created_user,
                'updated_user' => $this->updated_user,
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar los datos del personal: ' . $e->getMessage());
        }

        // Reiniciamos todas la variable excepto:
        $this->resetExcept('searchusuario');
        
        // Cerramos modal
        $this->modal_abierto_personal = false;

        // Emitimos un evento para mostrar el SweetAlert
        $this->dispatch(
            'alerta-actualizado',
            titulo: 'Datos almacenados',
            mensaje: 'Los datos se han guardado correctamente.',
            tipo: 'success' // success | error | warning | info
        );
    }


    public function editar(User $iEditar){
        $this->modal_abierto_personal = true;

        $this->modal_header_titulo = 'editar';
        $this->modal_header_color = 'success-subtle';
        $this->btn_guardar_actualizar = 'actualizar';
        $this->btn_guardar_actualizar_color = 'success';
        $this->fieldset_disable = '';

        // Datos
        $this->id_usuario = $iEditar->id;
        $this->dni = $iEditar->dni;
        $this->datos = strtoupper($iEditar->datos);

        // Origen
        $this->codsede_origen = $iEditar->codsede_origen;
        $this->sede_origen = $iEditar->sede_origen;
        $this->coddependencia_origen = $iEditar->coddependencia_origen;
        $this->dependencia_origen = $iEditar->dependencia_origen;

        // Destino
        $this->codsede_destino = $iEditar->codsede_destino;
        $this->sede_destino = $iEditar->sede_destino;
        $this->coddependencia_destino = $iEditar->coddependencia_destino;
        $this->dependencia_destino = $iEditar->dependencia_destino;

        // Otros campos
        $this->regimen = $iEditar->regimen;
        $this->cargo = $iEditar->cargo;
        $this->cel_personal = $iEditar->cel_personal;
        $this->correo_personal = strtolower($iEditar->correo_personal);
        $this->cel_institucional = $iEditar->cel_institucional;
        $this->correo_institucional = strtolower($iEditar->correo_institucional);
        $this->avatar = $iEditar->avatar;
        $this->activo = $iEditar->activo;
        $this->created_user = $iEditar->created_user;
        $this->updated_user = $iEditar->updated_user;
    }

    public function actualizar(){
        $iActualizar = User::where('dni', $this->dni)->firstOrFail();

        try {
            $iActualizar->update([            
                'dni' => $this->dni,
                'datos' => strtoupper($this->datos),

                'codsede_origen' => $this->codsede_origen,
                'sede_origen' => $this->sede_origen,
                'coddependencia_origen' => $this->coddependencia_origen,
                'dependencia_origen' => $this->dependencia_origen,

                'codsede_destino' => $this->codsede_destino,
                'sede_destino' => $this->sede_destino,
                'coddependencia_destino' => $this->coddependencia_destino,
                'dependencia_destino' => $this->dependencia_destino,

                'regimen' => $this->regimen,
                'cargo' => $this->cargo,
                'cel_personal' => $this->cel_personal,
                'correo_personal' => strtolower($this->correo_personal),
                'cel_institucional' => $this->cel_institucional,
                'correo_institucional' => strtolower($this->correo_institucional),

                'avatar' => $this->avatar,
                'activo' => $this->activo,
                
                'created_user' => $this->created_user,
                'updated_user' => $this->updated_user,
            ]);

        } catch (\Exception $e) {
            session()->flash('error', 'Error al desactivar el usuario: ' . $e->getMessage());
        }        

        // Reiniciamos todas la variable excepto:
        $this->resetExcept('searchusuario');
        
        // Cerramos modal
        $this->modal_abierto_personal = false;

        // Emitimos un evento para mostrar el SweetAlert
        $this->dispatch(
            'alerta-actualizado',
            titulo: 'Datos actualizado',
            mensaje: 'Los datos se han guardado correctamente.',
            tipo: 'success' // success | error | warning | info
        );
        
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

        // Reiniciamos todas la variable excepto:
        $this->resetExcept('searcha');
    }

    public function editar_imagen(){
        $this->modal_abierto_imagen = true;
    }

    public function cerrar_imagen(){
        $this->modal_abierto_imagen = false;

        // Variable de entorno
        $this->reset(['avatar']);
    }

    // PERSONAL
    // ---------------------------------------------------------
    public function buscar_personal(){
        $this->modal_abierto_personal_buscar = true;
    }

    public function agregar_personal(Tbl_personale $ipersonal){
        $this->id_usuario = $ipersonal->id;
        $this->dni = $ipersonal->dni;
        $this->datos = $ipersonal->datos;

        $this->codsede_origen = $ipersonal->codsede_origen;
        $this->sede_origen = $ipersonal->sede_origen;
        $this->coddependencia_origen = $ipersonal->coddependencia_origen;
        $this->dependencia_origen = $ipersonal->dependencia_origen;

        $this->codsede_destino = $ipersonal->codsede_destino;
        $this->sede_destino = $ipersonal->sede_destino;
        $this->coddependencia_destino = $ipersonal->coddependencia_destino;
        $this->dependencia_destino = $ipersonal->depencia_destino;

        $this->regimen = $ipersonal->regimen;
        $this->cargo = $ipersonal->cargo;
        $this->correo_personal = $ipersonal->correo_personal;
        $this->correo_institucional = $ipersonal->correo_institucional;
        $this->cel_personal = $ipersonal->cel_personal;
        $this->cel_institucional = $ipersonal->cel_institucional;

        $this->reset('searchbuscarpersonal');

        $this->modal_abierto_personal_buscar = false;
    }

    public function cerrar_personal(){
        $this->modal_abierto_personal_buscar = false;
    }

    // PASSWORD
    // ---------------------------------------------------------
    public function editar_password( $dni)
    {
        $this->dni = $dni;
        $this->password = $dni;
    }

    public function actualizar_password()
    {
        try {
            $iActualizarpass = User::where('dni', $this->dni)->firstOrFail();

            $iActualizarpass->update([
                'password' => Hash::make($this->dni),
                'updated_user' => auth()->user()->datos,
            ]);

            // ✅ Limpiar la propiedad del componente
            $this->reset(['dni','password']);

            // ✅ Emitir evento de éxito para SweetAlert
            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Contraseña actualizada',
                mensaje: 'La contraseña se ha restablecido correctamente.',
                tipo: 'success' // success | error | warning | info
            );

        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar la contraseña: ' . $e->getMessage());
        }
    }
}
