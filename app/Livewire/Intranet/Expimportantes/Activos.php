<?php

namespace App\Livewire\Intranet\Expimportantes;

use App\Models\AdministracionesExpimportante;
use App\Models\Persona;
use App\Models\Personale;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Activos extends Component
{
    //Actualizar cambios
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $mostrarBtnBuscarDni = "d-none", $mostrarcargafoto = "d-none";

    public $colorHeaderModal, $textoHeaderModal;
    public $colorNuevoEditar, $textoNuevoEditar;
    public $colorGuardarActualizar, $textoGuardarActualizar;
    public $colorAgregar;

    //Variables bloquear de secciones
    public $seccionFoto, $seccionPersona, $seccionPersonal;

    // Variable de función Guardar o Actualizar
    public $funcionGuardarActualizar;


    // Variables de búsqueda
    public $search, $searchi,$searchhistorial, $searchpersonas, $searchsedes,$searchdependencias,$searchdespachos,$searchcargos;
    public function updatingSearch(){
        $this->resetPage('personalesPage');
    }
    public function updatingSearchi(){
        $this->resetPage('personalesiPage');
    }
    public function updatingSearchhistorial(){
        $this->resetPage('historialPage');
    }
    public function updatingSearchpersonas(){
        $this->resetPage('personasPage');
    }
    public function updatingSearchsedes(){
        $this->resetPage('sedesPage');
    }
    public function updatingSearchdependencias(){
        $this->resetPage('dependenciasPage');
    }
    public function updatingSearchdespachos(){
        $this->resetPage('despachosPage');
    }
    public function updatingSearchcargos(){
        $this->resetPage('cargosPage');
    }

    Public $filtrosede, $filtrodependencia;
    public $filtrotipodocumento;
    public $filtroregimen;

    public $user_login;

    public $persona_id,
            $dni,
            $datos,
            $appaterno,
            $apmaterno,
            $nombres,
            $genero,
            $estadocivil,
            $fechanacimiento,
            $celpersonal,
            $correopersonal,
            $foto,$fotoactual,$inputFileKey,
            $activo,
            $created_user,
            $updated_user,
            $created_at,
            $updated_at;

    public $personal_id,
            $regimen,
            $tipo_regimen,
            $cargo,
            $cargo_condicion,

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
            
            $celinstitucional,            
            $correoinstitucional,            

            $numero_convocatoria,
            $tipo_documento,
            $fecha_inicio,
            $fecha_fin,
            $ruta_documento;

    public $expimportante_id,
            $expdetalle,
            $numexpediente,
            $estado,
            $oficina_ubicacion,
            $asignado_a,
            $fecha;


    public $pdf_acta;

    public $bandera_documento="CONTRATO";

    public $bloquear_inputs = "";

    public function mount()
    {
        $this->inputFileKey = rand();
    }

    public function render()
    {
        $usuario = auth()->user();

        $query = AdministracionesExpimportante::where('activo','1');

        // 🔐 CONTROL DE ACCESO
        if (!$usuario->hasAnyRole(['ExpImportantes-Admin', 'Admin-Super'])) {
            $query->where('dni', $usuario->dni); // 👈 clave
        }

        // 🔍 BÚSQUEDA
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('dni', 'like', "%{$this->search}%")
                ->orWhere('datos', 'like', "%{$this->search}%");
            });
        }

        $lista_activos = $query
            ->orderByDesc('id')
            ->paginate(10, ['*'], 'activosPage');

        $lista_historial = AdministracionesExpimportante::where('numexpediente',$this->numexpediente)
            ->whereIn('activo',['1','0'])
            ->orderByDesc('id')
            ->paginate(10, ['*'], 'activosPage');

        $lista_personas = Persona::join('personales','personas.id','=','personales.persona_id')
            ->where('personales.tipo_documento','CONTRATO')
            ->where('personales.activo', "1")
            ->when($this->searchpersonas !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('personas.dni', 'like', '%' . $this->searchpersonas . '%')
                    ->orWhere('personas.datos', 'like', '%' . $this->searchpersonas . '%');
                });
            })
            ->orderBy('personas.datos')
            ->paginate(10,['*'],'personasPage');

        return view('livewire.intranet.expimportantes.activos',
                compact('lista_activos','lista_historial','lista_personas'));
    }

    protected function rules(){
        return [
                'dni' => [
                    'required',
                    'string',
                    Rule::unique('personas', 'dni')
                        ->ignore($this->persona_id, 'id')
                ],
                'numexpediente' => [
                    'required',
                    Rule::unique('administraciones_expimportantes', 'numexpediente')
                        ->ignore($this->expimportante_id) // 👈 IGNORA el mismo registro
                        ->where(fn ($query) => $query->where('activo', 1))
                ],
            'nombres' => 'required',
            'appaterno' => 'required',
            'apmaterno' => 'required',

            'sedeorigen' => 'required',
            'dependenciaorigen' => 'required',
            'despachoorigen' => 'required',
            'regimen' => 'required',
            'cargo' => 'required',  
        ];
    }

    protected $messages = [
        'dni.required' => 'El dni es obligatorio.',
        'dni.unique' => 'El dni ya fue registrado.',
        'nombres.required' => 'Campo requerido',
        'appaterno.required' => 'Campo requerido',
        'apmaterno.required' => 'Campo requerido',

        'sedeorigen.required' => 'Campo requerido',
        'dependenciaorigen.required' => 'Campo requerido',
        'despachoorigen.required' => 'Campo requerido',
        'regimen.required' => 'Campo requerido',
        'cargo.required' => 'Campo requerido',

        'numexpediente.unique' => 'El expediente ya existe',

    ];

    public function nuevo()
    {
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // Restablecer todas las variables
        $this->reset();
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

        $this->bloquear_inputs = "";

        $usuario = auth()->user()->dni;

        $ipersona = Persona::where([['activo',1],['dni',$usuario],])->firstOrFail();
        $this->persona_id = $ipersona->id;
        $this->dni = $ipersona->dni;
        $this->appaterno = $ipersona->appaterno;
        $this->apmaterno = $ipersona->apmaterno;
        $this->nombres = $ipersona->nombres;

        $this->datos = $ipersona->datos;

        $this->celpersonal = $ipersona->celpersonal;
        $this->correopersonal = $ipersona->correopersonal;

        $ipersonal = Personale::where([['activo',1],['persona_dni',$usuario],])->firstOrFail();
        $this->personal_id = $ipersonal->id;
        $this->codsedeorigen = $ipersonal->codsedeorigen;
        $this->sedeorigen = $ipersonal->sedeorigen;
        $this->coddependenciaorigen = $ipersonal->coddependenciaorigen;
        $this->dependenciaorigen = $ipersonal->dependenciaorigen;
        $this->coddespachoorigen = $ipersonal->coddespachoorigen;
        $this->despachoorigen = $ipersonal->despachoorigen;
        $this->celinstitucional = $ipersonal->celinstitucional;
        $this->correoinstitucional = $ipersonal->correoinstitucional;
        $this->regimen = $ipersonal->regimen;
        $this->tipo_regimen = $ipersonal->tipo_regimen;
        $this->cargo = $ipersonal->cargo;
    }

    public function guardar()
    {
        $this->validate();

        try {

            DB::transaction(function () {

                $usuario = auth()->user()->datos;

                AdministracionesExpimportante::create([
                    'persona_id' => $this->persona_id,
                    'dni' => $this->dni,
                    'datos' => strtoupper($this->appaterno . ' ' . $this->apmaterno . ' ' . $this->nombres),
                    'personal_id' => $this->personal_id,
                    'codsedeorigen' => $this->codsedeorigen,
                    'sedeorigen' => $this->sedeorigen,
                    'coddependenciaorigen' => $this->coddependenciaorigen,
                    'dependenciaorigen' => $this->dependenciaorigen,
                    'coddespachoorigen' => $this->coddespachoorigen,
                    'despachoorigen' => $this->despachoorigen,
                    'numexpediente' => Str::upper($this->numexpediente),
                    'expdetalle' => strtoupper($this->expdetalle),
                    'estado' => $this->estado,
                    'oficina_ubicacion' => strtoupper($this->oficina_ubicacion),
                    'asignado_a' => strtoupper($this->asignado_a),
                    'fecha' => $this->fecha,
                    'activo' => "1",
                    'created_user' => $usuario,
                    'updated_user' => $usuario,
                ]);

            });

            $this->reset(); // 🔥 limpia formulario

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Guardado',
                mensaje: 'Registro creado correctamente.',
                tipo: 'success'
            );

            $this->dispatch('cerrar-modal', id: 'nuevoEditarModal');

        } catch (\Throwable $e) {

            report($e);

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Error',
                mensaje: config('app.debug') ? $e->getMessage() : 'Ocurrió un error al guardar.',
                tipo: 'error'
            );
        }
    }

    public function editar(AdministracionesExpimportante $iexpedientesimportantes)
    {
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

        $this->bloquear_inputs = "disabled";

        $this->expimportante_id = $iexpedientesimportantes->id;
        $this->persona_id = $iexpedientesimportantes->persona_id;
        $this->numexpediente = $iexpedientesimportantes->numexpediente;
        $this->expdetalle = $iexpedientesimportantes->expdetalle;
        $this->estado = $iexpedientesimportantes->estado;
        $this->oficina_ubicacion = $iexpedientesimportantes->oficina_ubicacion;
        $this->asignado_a = $iexpedientesimportantes->asignado_a;
        $this->fecha = $iexpedientesimportantes->fecha;

        $ipersona = Persona::where([['activo',1],['id',$this->persona_id],])->firstOrFail();

        // ===== DATOS PERSONA =====
        // $this->persona_id = $ipersona->id;
        $this->dni = $ipersona->dni;
        $this->nombres = $ipersona->nombres;
        $this->appaterno = $ipersona->appaterno;
        $this->apmaterno = $ipersona->apmaterno;
        $this->celpersonal = $ipersona->celpersonal;
        $this->correopersonal = $ipersona->correopersonal;

        $this->fotoactual = $ipersona->foto;

        // ===== DATOS PERSONAL =====
        $ipersonal = Personale::where('persona_dni', $this->dni)->where('activo','1')->firstOrFail();

        $this->personal_id = $ipersonal->id;
        $this->regimen = $ipersonal->regimen;
        $this->tipo_regimen = $ipersonal->tipo_regimen;
        $this->cargo = $ipersonal->cargo;
        $this->cargo_condicion = $ipersonal->cargo_condicion;
        $this->codsedeorigen = $ipersonal->codsedeorigen;
        $this->sedeorigen = $ipersonal->sedeorigen;
        $this->coddependenciaorigen = $ipersonal->coddependenciaorigen;
        $this->dependenciaorigen = $ipersonal->dependenciaorigen;
        $this->coddespachoorigen = $ipersonal->coddespachoorigen;
        $this->despachoorigen = $ipersonal->despachoorigen;

        $this->celinstitucional = $ipersonal->celinstitucional;
        $this->correoinstitucional = $ipersonal->correoinstitucional;      
    }

    public function actualizar()
    {
        try {

            DB::transaction(function () {

                $usuario = auth()->user()->datos;

                // ========================
                // ACTUALIZAR EXPEDIENTE IMPORTANTE
                // ========================
                $iexpedientesimportantes = AdministracionesExpimportante::findOrFail($this->expimportante_id);

                $iexpedientesimportantes->update([
                    'activo' => "0",
                ]);

                // $this->validate();

                AdministracionesExpimportante::create([
                    'persona_id' => $this->persona_id,
                    'dni' => $this->dni,
                    'datos' => strtoupper($this->appaterno . ' ' . $this->apmaterno . ' ' . $this->nombres),
                    'personal_id' => $this->personal_id,
                    'codsedeorigen' => $this->codsedeorigen,
                    'sedeorigen' => $this->sedeorigen,
                    'coddependenciaorigen' => $this->coddependenciaorigen,
                    'dependenciaorigen' => $this->dependenciaorigen,
                    'coddespachoorigen' => $this->coddespachoorigen,
                    'despachoorigen' => $this->despachoorigen,
                    'numexpediente' => Str::upper($this->numexpediente),
                    'expdetalle' => strtoupper($this->expdetalle),
                    'estado' => $this->estado,
                    'oficina_ubicacion' => strtoupper($this->oficina_ubicacion),
                    'asignado_a' => strtoupper($this->asignado_a),
                    'fecha' => $this->fecha,
                    'activo' => "1",
                    'created_user' => $usuario,
                    'updated_user' => $usuario,
                ]);

            });

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Datos actualizados',
                mensaje: 'Los datos se han actualizado correctamente.',
                tipo: 'success'
            );

            $this->dispatch('cerrar-modal', id: 'nuevoEditarModal');

        } catch (\Throwable $e) {

            report($e);

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Error',
                mensaje: 'Ocurrió un error al actualizar.',
                tipo: 'error'
            );
        }
    }

    public function cerrar()
    {
        $this->reset();

        $this->dispatch(
                'alerta-cancelar',
                titulo: 'Cancelar',
                mensaje: 'Se canceló la operación.',
                tipo: 'error'
            );
    }

    // FUNCIONES DE HISTORIAL
    public function historial_documentos($numexpediente)
    {
        $this->numexpediente = $numexpediente;
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

        $this->fotoactual = $ipersona->foto;

        $ipersonal = Personale::where([['activo',1],['persona_dni',$this->dni],])->firstOrFail();

        $this->personal_id = $ipersonal->id;
        $this->codsedeorigen = $ipersonal->codsedeorigen;
        $this->sedeorigen = $ipersonal->sedeorigen;
        $this->coddependenciaorigen = $ipersonal->coddependenciaorigen;
        $this->dependenciaorigen = $ipersonal->dependenciaorigen;
        $this->coddespachoorigen = $ipersonal->coddespachoorigen;
        $this->despachoorigen = $ipersonal->despachoorigen;
        $this->celinstitucional = $ipersonal->celinstitucional;
        $this->correoinstitucional = $ipersonal->correoinstitucional;
        $this->regimen = $ipersonal->regimen;
        $this->tipo_regimen = $ipersonal->tipo_regimen;
        $this->cargo = $ipersonal->cargo;

        $this->reset('searchpersonas');
    }

}
