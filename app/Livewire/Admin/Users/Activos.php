<?php

namespace App\Livewire\Admin\Users;

use App\Models\Persona;
use App\Models\Personale;
use App\Models\Tbl_personale;
use App\Models\Tbl_sede;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Activos extends Component
{
    protected $listeners = ['usuarioActivado' => '$refresh'];

    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $habilitarSeccion = "disable";
    public $mostrarBtnBuscarDni = "d-none";

    public $colorHeaderModal, $textoHeaderModal;
    public $colorNuevoEditar, $textoNuevoEditar;
    public $colorGuardarActualizar, $textoGuardarActualizar;
    public $colorAgregar;

    //Variables PARA OCULTAR Y MOSTRAR TXT_OTROS
    public $mostrarcargafoto = "";

    //Variables bloquear de secciones
    public $seccionFoto, $seccionPersona, $seccionPersonal;

    // Variable de función Guardar o Actualizar
    public $funcionGuardarActualizar;

    //Buscar
    public $searchusuario;
    public function updatingSearchusuario(){
        $this->resetPage('usuarioPage');
    }
    public $searchinactivos;
    public function updatingSearchinactivos(){
        $this->resetPage('inactivosPage');
    }
    public $searchbuscarpersonal;
    public function updatingSearchbuscarpersonal(){
        $this->resetPage();
    }
    public $searchpersonas;
    public function updatingSearchpersonas(){
        $this->resetPage('personasPage');
    }

    // Variables usuario
    Public $user_id,
            $password;

    // Variables de Persona personal
    public $persona_id,
            $dni,
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
            $foto,$fotoactual,$inputFileKey,
            $activo,
            $created_user,
            $updated_user,
            $created_at,
            $updated_at;

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
            ->paginate(10);

        $lista_inactivos = User::where('activo','0')
            ->when($this->searchinactivos !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->searchinactivos . '%')
                    ->orWhere('datos', 'like', '%' . $this->searchinactivos . '%');
                });
            })
            ->orderBy('datos')
            ->paginate(10,['*'],'inactivosPage');

        $lista_personas = Persona::where('activo','1')
            ->when($this->searchpersonas !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->searchpersonas . '%')
                    ->orWhere('datos', 'like', '%' . $this->searchpersonas . '%');
                });
            })
            ->orderBy('datos')
            ->paginate(10,['*'], 'personasPage');

        return view('livewire.admin.users.activos',
                compact('lista_activos','lista_inactivos','lista_personas')
            );
    }

    protected function rules(){
        return [
                    'dni' => [
                    'required',
                    'string',
                    Rule::unique('personas', 'dni')
                        ->ignore($this->persona_id, 'id')
                ],

            'datos' => 'required',
        ];
    }

    protected $messages = [
        'dni.required' => 'El dni es obligatorio.',
        'dni.unique' => 'El dni ya fue registrado.',
        'datos.required' => '',
    ];

    public function nuevo(){
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // Restablecer todas las variables
        // $this->reset();
        $this->foto = null;
        $this->fotoactual = null;
        $this->inputFileKey = rand();

        $this->funcionGuardarActualizar="guardar";

        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "Nuevo";
        $this->colorGuardarActualizar = "primary";
        $this->textoGuardarActualizar = "Guardar";
        $this->colorAgregar = "outline-primary";
    }

    public function guardar(){
        $validated = $this->validate();

        try {
            user::create([
                'dni' => $this->dni,
                'datos' => strtoupper($this->datos),

                'password' => Hash::make($this->dni),

                'activo' => '1',
                
                'created_user' => $this->created_user,
                'updated_user' => $this->updated_user,
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar los datos del personal: ' . $e->getMessage());
        }

        // Reiniciamos todas la variable excepto:
        $this->resetExcept('searchusuario');

        // Emitimos un evento para mostrar el SweetAlert
        $this->dispatch(
            'alerta-actualizado',
            titulo: 'Datos almacenados',
            mensaje: 'Los datos se han guardado correctamente.',
            tipo: 'success' // success | error | warning | info
        );
    }


    public function editar(User $iusuario){
        $this->resetValidation();
        $this->resetErrorBag();

        $this->funcionGuardarActualizar = "actualizar";

        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "success-subtle";
        $this->textoHeaderModal = "Editar";
        $this->colorGuardarActualizar = "success";
        $this->textoGuardarActualizar = "Actualizar";
        $this->colorAgregar = "outline-success";

        // ===== BLOQUEO DE SECCIONES =====
        $this->seccionFoto = "";
        $this->seccionPersona = "";
        $this->seccionPersonal = "";

        // Datos
        $this->user_id = $iusuario->id;
        $this->dni = $iusuario->dni;
        $this->datos = strtoupper($iusuario->datos);

        $ipersona = Persona::where([['activo',1],['dni',$this->dni],])->firstOrFail();

        $this->fotoactual = $ipersona->foto;

        $this->appaterno = $ipersona->appaterno;
        $this->apmaterno = $ipersona->apmaterno;
        $this->nombres = $ipersona->nombres;
        $this->celpersonal = $ipersona->celpersonal;
        $this->correopersonal = $ipersona->correopersonal;

        $ipersonal = Personale::where([['activo',1],['persona_dni',$this->dni],])->firstOrFail();

        $this->sedeorigen = $ipersonal->sedeorigen;
        $this->dependenciaorigen = $ipersonal->dependenciaorigen;
        $this->despachoorigen = $ipersonal->despachoorigen;
        $this->celinstitucional = $ipersonal->celinstitucional;
        $this->correoinstitucional = $ipersonal->correoinstitucional;
        $this->regimen = $ipersonal->regimen;
        $this->cargo = $ipersonal->cargo;
    }

    public function actualizar(){
        $iActualizar = User::where('dni', $this->dni)->firstOrFail();

        try {
            $iActualizar->update([            
                'dni' => $this->dni,
                'datos' => strtoupper($this->datos),

                'activo' => $this->activo,
                
                'created_user' => $this->created_user,
                'updated_user' => $this->updated_user,
            ]);

        } catch (\Exception $e) {
            session()->flash('error', 'Error al desactivar el usuario: ' . $e->getMessage());
        }        

        // Reiniciamos todas la variable excepto:
        $this->resetExcept('searchusuario');

        // Emitimos un evento para mostrar el SweetAlert
        $this->dispatch(
            'alerta-actualizado',
            titulo: 'Datos actualizado',
            mensaje: 'Los datos se han guardado correctamente.',
            tipo: 'success' // success | error | warning | info
        );
        
    }

    public function cerrar()
    {
        $this->reset();
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

    public function editar_imagen(){

    }

    public function cerrar_imagen(){


        // Variable de entorno
        $this->reset(['avatar']);
    }

    // PASSWORD
    // ---------------------------------------------------------
    public function editar_password( User $iusuario)
    {
        $this->dni = $iusuario->dni;
        $this->password = $iusuario->dni;
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

    // FUNCIONES AGREGAR
    public function agregar_persona(Persona $ipersona){
        $this->persona_id = $ipersona->id;
        $this->dni = $ipersona->dni;
        $this->appaterno = $ipersona->appaterno;
        $this->apmaterno = $ipersona->apmaterno;
        $this->nombres = $ipersona->nombres;

        $this->datos = $ipersona->datos;

        $this->celpersonal = $ipersona->celpersonal;
        $this->correopersonal = $ipersona->correopersonal;

        $ipersonal = Personale::where([['activo',1],['persona_dni',$this->dni],])->firstOrFail();

        $this->sedeorigen = $ipersonal->sedeorigen;
        $this->dependenciaorigen = $ipersonal->dependenciaorigen;
        $this->despachoorigen = $ipersonal->despachoorigen;
        $this->celinstitucional = $ipersonal->celinstitucional;
        $this->correoinstitucional = $ipersonal->correoinstitucional;
        $this->regimen = $ipersonal->regimen;
        $this->cargo = $ipersonal->cargo;

        $this->reset('searchpersonas');
    }

    public function cerrar_personal(){

    }
}
