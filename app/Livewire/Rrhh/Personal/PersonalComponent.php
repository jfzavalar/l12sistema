<?php

namespace App\Livewire\Rrhh\Personal;

use App\Models\Persona;
use App\Models\Personale;
use App\Models\Personales_cargo;
use App\Models\Personales_dependencia;
use App\Models\Personales_despacho;
use App\Models\Personales_sede;
use App\Models\Tbl_cargo;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
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
    public $colorAgregar;

    //Variables bloquear de secciones
    public $seccionFoto, $seccionPersona, $seccionPersonal;

    // Variable de función Guardar o Actualizar
    public $funcionGuardarActualizar;

    //Variable mostrar modal al cerrar buscadores de sede, dependencia y despacho

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

    public $pdf;

    public function mount()
    {
        $this->inputFileKey = rand();
    }

    //FUNCIONES EN TIEMPO REAL
    public function updatedRegimen($value)
    {
        if ($value === 'D.L.728') {
            $this->tipo_regimen = 'INDETERMINADO';
            $this->fecha_fin = '3000-12-31';
        } elseif ($value === 'D.L.276') {
            $this->tipo_regimen = 'INDETERMINADO';
            $this->fecha_fin = '3000-12-31';
        } else {
            $this->tipo_regimen = 'TRANSITORIO';
            $this->fecha_fin = null;
        }
    }
    public function updatedTipoRegimen($value)
    {
        if ($value === 'INDETERMINADO') {
            $this->fecha_fin = '3000-12-31';
        } else {
            $this->fecha_fin = null;
        }
    }

    public function render()
    {
        $lista_activos = Persona::join('personales', 'personas.id', '=', 'personales.persona_id')
            ->select('personas.*',
                'personales.persona_id',
                'personales.regimen',
                'personales.tipo_regimen',
                'personales.cargo',
                'personales.sedeorigen',
                'personales.dependenciaorigen',
                'personales.despachoorigen',
                'personales.sededestino',
                'personales.dependenciadestino',
                'personales.despachodestino',
                'personales.tipo_documento')
            ->where('personales.activo', 1)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('personas.dni', 'like', '%' . $this->search . '%')
                    ->orWhere('personas.datos', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('personales.id','desc')
            ->distinct()
            ->paginate(10, ['personas.*'], 'personalesPage');

        $lista_inactivos = Persona::join('personales', 'personas.id', '=', 'personales.persona_id')
            ->select('personas.*',
                'personales.persona_id',
                'personales.regimen',
                'personales.tipo_regimen',
                'personales.cargo',
                'personales.sedeorigen',
                'personales.dependenciaorigen',
                'personales.despachoorigen',
                'personales.sededestino',
                'personales.dependenciadestino',
                'personales.despachodestino')
            ->where([['personas.activo',0],['personales.activo', 0]])
            ->when($this->searchi, function ($query) {
                $query->where(function ($q) {
                    $q->where('personas.dni', 'like', '%' . $this->searchi . '%')
                    ->orWhere('personas.datos', 'like', '%' . $this->searchi . '%');
                });
            })
            ->orderBy('personas.datos')
            ->distinct()
            ->paginate(10, ['personas.*'], 'personalesiPage');

        $lista_historial = Persona::join('personales', 'personas.id', '=', 'personales.persona_id')
            ->select('personas.*',
                'personales.id as personal_id',
                'personales.persona_id',
                'personales.regimen',
                'personales.tipo_regimen',
                'personales.cargo',
                'personales.sedeorigen',
                'personales.dependenciaorigen',
                'personales.despachoorigen',
                'personales.numero_convocatoria',
                'personales.tipo_documento',
                'personales.fecha_inicio',
                'personales.fecha_fin',
                'personales.ruta_documento')
            ->where('personales.persona_dni', $this->dni)
            ->when($this->searchhistorial, function ($query) {
                $query->where(function ($q) {
                    $q->where('personales.numero_convocatoria', 'like', '%' . $this->searchhistorial . '%')
                    ->orWhere('personales.tipo_documento', 'like', '%' . $this->searchhistorial . '%');
                });
            })
            ->orderBy('personales.id','desc')
            ->paginate(10, ['personas.*'], 'historialPage');

        $lista_personas = Persona::where('activo','1')
            ->when($this->searchpersonas !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->searchpersonas . '%')
                    ->orWhere('datos', 'like', '%' . $this->searchpersonas . '%');
                });
            })
            ->orderBy('datos')
            ->paginate(10,['*'],'personasPage');

        $lista_sedes = Personales_sede::select('id','nombre')
            ->where('activo','1')
            ->where('nombre','like','%' . $this->searchsedes . '%')
            ->distinct()
            ->orderBy('nombre')
            ->paginate(10,['*'], 'sedesPage');
            
        $lista_dependencias = Personales_dependencia::select('id','nombre')
            ->where('activo','1')
            ->where('sede_id',$this->codsedeorigen)
            ->where('nombre','like','%' . $this->searchdependencias . '%')
            ->distinct()
            ->orderBy('nombre')
            ->paginate(10,['*'], 'dependenciasPage');

        $lista_despachos = Personales_despacho::select('id','nombre')
            ->where('activo','1')
            ->where('nombre','like','%' . $this->searchdespachos . '%')
            ->distinct()
            ->orderBy('nombre')
            ->paginate(10,['*'], 'despachosPage');

        $lista_cargos = Personales_cargo::select('id','nombre')
            ->where('activo','1')
            ->where('nombre','like','%' . $this->searchcargos . '%')
            ->distinct()
            ->orderBy('nombre')
            ->paginate(10,['*'], 'cargosPage');

        return view('livewire.rrhh.personal.personal-component',
                        compact('lista_activos','lista_inactivos','lista_historial','lista_personas','lista_sedes','lista_dependencias','lista_despachos','lista_cargos'));
    }

    protected function rules(){
        return [
                    'dni' => [
                    'required',
                    'string',
                    Rule::unique('personas', 'dni')
                        ->ignore($this->persona_id, 'id')
                ],
            'nombres' => 'required',
            'appaterno' => 'required',
            'apmaterno' => 'required',

            'sedeorigen' => 'required',
            'dependenciaorigen' => 'required',
            'despachoorigen' => 'required',
            'regimen' => 'required',
            'cargo' => 'required',

            'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',

            'foto' => 'nullable|image|mimes:jpg,jpeg|max:2048', // 2MB máximo

            'pdf' => 'nullable|file|mimes:pdf|max:5120', // 5MB
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

        'fecha_inicio.required' => 'Campo requerido',
        'fecha_fin.required' => 'Campo requerido',

        'fecha_inicio.before_or_equal' => 'La fecha de inicio no puede ser mayor a la fecha de fin.',
        'fecha_fin.after_or_equal' => 'La fecha de fin no puede ser menor a la fecha de inicio.',

        'pdf.mimes' => 'Solo se permiten archivos PDF.',
        'pdf.max' => 'El archivo no debe superar 5MB.',
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

        $this->tipo_documento = "CONTRATO";
    }

    public function guardar()
    {
        $this->validate();

        try {

            DB::transaction(function () {

                $usuario = auth()->user()->datos; // Mejor que usar propiedad pública

                // 📌 Subir FOTO si existe
                $rutaFoto = null;

                if ($this->foto) {

                    $nombreFoto = time() . '_foto_' . $this->foto->getClientOriginalName();

                    $rutaFoto = $this->foto->storeAs(
                        'imagenes/rrhh/personal',
                        $nombreFoto,
                        'public'
                    );
                }

                // GUARDAR CAMPOS DE PERSONA

                $persona = Persona::create([
                    'dni' => $this->dni,
                    'appaterno' => strtoupper($this->appaterno),
                    'apmaterno' => strtoupper($this->apmaterno),
                    'nombres' => strtoupper($this->nombres),
                    'datos' => strtoupper($this->appaterno . ' ' . $this->apmaterno . ' ' . $this->nombres),
                    'genero' => $this->genero,
                    'estadocivil' => $this->estadocivil,
                    'fechanacimiento' => $this->fechanacimiento,
                    'celpersonal' => $this->celpersonal,
                    'correopersonal' => $this->correopersonal,
                    'foto' => $rutaFoto, // 🔥 GUARDAMOS FOTO
                    'activo' => '1',
                    'created_user' => $usuario,
                    'updated_user' => $usuario,
                ]);

                // FUNCIÓN PARA CARGAR DOCUMENTO
                $rutaDocumento = $this->guardar_documento();

                // GUARDAR CAMPOS DE PERSONAL
                Personale::create([
                    'persona_id' => $persona->id,
                    'persona_dni' => $persona->dni,
                    'regimen' => $this->regimen,
                    'tipo_regimen' => $this->tipo_regimen,
                    'cargo' => $this->cargo,

                    'codsedeorigen' => $this->codsedeorigen,
                    'sedeorigen' => $this->sedeorigen,
                    'coddependenciaorigen' => $this->coddependenciaorigen,
                    'dependenciaorigen' => $this->dependenciaorigen,
                    'coddespachoorigen' => $this->coddespachoorigen,
                    'despachoorigen' => $this->despachoorigen,
                    'codsededestino' => $this->codsedeorigen,
                    'sededestino' => $this->sedeorigen,
                    'coddependenciadestino' => $this->coddependenciaorigen,
                    'dependenciadestino' => $this->dependenciaorigen,
                    'coddespachodestino' => $this->coddespachoorigen,
                    'despachodestino' => $this->despachoorigen,

                    'celinstitucional' => $this->celinstitucional,
                    'correoinstitucional' => $this->correoinstitucional,

                    'numero_convocatoria' => $this->numero_convocatoria,
                    'tipo_documento' => $this->tipo_documento,
                    'fecha_inicio' => $this->fecha_inicio,
                    'fecha_fin' => $this->fecha_fin,

                    // 🔥 Guardamos la ruta real del archivo
                    'ruta_documento' => $rutaDocumento,

                    'activo' => '1',
                    'created_user' => $usuario,
                    'updated_user' => $usuario,
                ]);
            });

            $this->resetExcept('searchPersonal');

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Datos actualizados',
                mensaje: 'Los datos se han actualizado correctamente.',
                tipo: 'success'
            );

            // Evento para cerrar el modal
            $this->dispatch('cerrar-modal', id: 'nuevoEditarModal');

        } catch (\Throwable $e) {

            report($e);

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Error',
                mensaje: 'Ocurrió un error al guardar.',
                tipo: 'error'
            );
        }
    }

    public function editar(Persona $ipersona)
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

        // ===== DATOS PERSONA =====
        $this->persona_id = $ipersona->id;
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
        $this->codsedeorigen = $ipersonal->codsedeorigen;
        $this->sedeorigen = $ipersonal->sedeorigen;
        $this->coddependenciaorigen = $ipersonal->coddependenciaorigen;
        $this->dependenciaorigen = $ipersonal->dependenciaorigen;
        $this->coddespachoorigen = $ipersonal->coddespachoorigen;
        $this->despachoorigen = $ipersonal->despachoorigen;

        $this->codsededestino = $ipersonal->codsededestino;
        $this->sededestino = $ipersonal->sededestino;
        $this->coddependenciadestino = $ipersonal->coddependenciadestino;
        $this->dependenciadestino = $ipersonal->dependenciadestino;
        $this->coddespachodestino = $ipersonal->coddespachodestino;
        $this->despachodestino = $ipersonal->despachodestino;

        $this->celinstitucional = $ipersonal->celinstitucional;
        $this->correoinstitucional = $ipersonal->correoinstitucional;

        // ===== DATOS CONTRATO =====
        $this->numero_convocatoria = $ipersonal->numero_convocatoria;
        $this->tipo_documento = $ipersonal->tipo_documento;
        $this->fecha_inicio = $ipersonal->fecha_inicio;
        $this->fecha_fin = $ipersonal->fecha_fin;
        $this->ruta_documento = $ipersonal->ruta_documento;
        
    }

    public function actualizar()
    {
        $this->validate();

        try {

            DB::transaction(function () {

                $usuario = auth()->user()->datos;

                // ========================
                // ACTUALIZAR PERSONA
                // ========================
                $persona = Persona::findOrFail($this->persona_id);

                // Mantener imagen actual
                $rutaFoto = $persona->foto;

                // 📌 Si se sube nueva imagen
                if ($this->foto) {

                    // Eliminar anterior si existe
                    if ($persona->foto && 
                        Storage::disk('public')->exists($persona->foto)) {

                        Storage::disk('public')->delete($persona->foto);
                    }

                    // Nombre limpio
                    $fileName = 'perfil_' . $this->dni . '.' . 
                                $this->foto->getClientOriginalExtension();

                    // Guardar imagen
                    $rutaFoto = $this->foto->storeAs(
                        'archivos/rrhh/personal/fotos',
                        $fileName,
                        'public'
                    );
                }

                $persona->update([
                    'datos' => strtoupper($this->appaterno . ' ' . $this->apmaterno . ' ' . $this->nombres),
                    'appaterno' => strtoupper($this->appaterno),
                    'apmaterno' => strtoupper($this->apmaterno),
                    'nombres' => strtoupper($this->nombres),
                    'genero' => $this->genero,
                    'estadocivil' => $this->estadocivil,
                    'fechanacimiento' => $this->fechanacimiento,
                    'celpersonal' => $this->celpersonal,
                    'correopersonal' => $this->correopersonal,
                    'foto' => $rutaFoto, //AQUÏ
                    'updated_user' => $usuario,
                ]);

                // ========================
                // ACTUALIZAR PERSONAL
                // ========================
                $personal = Personale::where([
                    ['activo', "1"],
                    ['persona_dni', $this->dni],
                ])->firstOrFail();

                // Llamamos a la función privada para cargar documento
                $rutaDocumento = $this->actualizar_documento($personal);

                $personal->update([
                    'regimen' => $this->regimen,
                    'tipo_regimen' => $this->tipo_regimen,
                    'cargo' => $this->cargo,

                    'codsedeorigen' => $this->codsedeorigen,
                    'sedeorigen' => $this->sedeorigen,
                    'coddependenciaorigen' => $this->coddependenciaorigen,
                    'dependenciaorigen' => $this->dependenciaorigen,
                    'coddespachoorigen' => $this->coddespachoorigen,
                    'despachoorigen' => $this->despachoorigen,

                    'codsededestino' => $this->codsededestino,
                    'sededestino' => $this->sededestino,
                    'coddependenciadestino' => $this->coddependenciadestino,
                    'dependenciadestino' => $this->dependenciadestino,
                    'coddespachodestino' => $this->coddespachodestino,

                    'celinstitucional' => $this->celinstitucional,
                    'correoinstitucional' => $this->correoinstitucional,
                    'numero_convocatoria' => $this->numero_convocatoria,

                    // 🔥 Solo cambia si hay nuevo archivo
                    'ruta_documento' => $rutaDocumento,

                    'fecha_inicio' => $this->fecha_inicio,
                    'fecha_fin' => $this->fecha_fin,
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

    private function guardar_documento(){
        if (!$this->pdf) {
            return null;
        }

        // 1️⃣ Crear nombre base
        $fileNameBase =
            $this->numero_convocatoria . '_' .
            $this->dni . '_' .
            $this->tipo_documento . '_' .
            $this->fecha_inicio . '_' .
            $this->fecha_fin;

        // 2️⃣ Limpiar y hacer único
        $fileName = Str::slug($fileNameBase) . '_' . Str::uuid();
        $fileName .= '.' . $this->pdf->getClientOriginalExtension();

        // 3️⃣ Guardar archivo
        return $this->pdf->storeAs(
            'archivos/rrhh/personal/documentos',
            $fileName,
            'public'
        );
    }

    private function actualizar_documento($personal)
    {
        // Mantener archivo actual
        $rutaDocumento = $personal->ruta_documento;

        // 📌 Si se sube nuevo PDF
        if ($this->pdf) {

            // Eliminar anterior si existe
            if ($personal->ruta_documento &&
                Storage::disk('public')->exists($personal->ruta_documento)) {

                Storage::disk('public')->delete($personal->ruta_documento);
            }

            // Nombre limpio (sin espacios)
            $fileName = str_replace(' ', '_',
                $this->numero_convocatoria . '_' .
                $this->dni . '_' .
                $this->tipo_documento . '_' .
                $this->fecha_inicio . '_' .
                $this->fecha_fin
            ) . '.' . $this->pdf->getClientOriginalExtension();

            // Guardar archivo
            $rutaDocumento = $this->pdf->storeAs(
                'archivos/rrhh/personal/documentos',
                $fileName,
                'public'
            );
        }

        return $rutaDocumento; // 🔥 FALTABA ESTO
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

    // FUNCIONES AGREGAR

    public function agregar_persona(Persona $ipersona){
        $this->persona_id = $ipersona->id;
        $this->dni = $ipersona->dni;
        $this->datos = $ipersona->datos;

        $this->reset('searchpersonas');
    }

    public function agregar_sede(Personales_sede $isede)
    {
        $this->codsedeorigen = $isede->id;
        $this->sedeorigen = $isede->nombre;

        $this->codsededestino = $isede->id;
        $this->sededestino = $isede->nombre;

        $this->reset(['dependenciaorigen','despachoorigen']);

        $this->reset(['searchdependencias','searchdespachos']);
    }

    public function agregar_dependencia(Personales_dependencia $idependencia)
    {
        $this->coddependenciaorigen = $idependencia->id;
        $this->dependenciaorigen = $idependencia->nombre;

        $this->coddependenciadestino = $idependencia->id;
        $this->dependenciadestino = $idependencia->nombre;

        $this->reset('despachoorigen');

        $this->reset('searchdespachos');
    }

    public function agregar_despacho(Personales_despacho $idespacho)
    {
        $this->coddespachoorigen = $idespacho->id;
        $this->despachoorigen = $idespacho->nombre;

        $this->coddespachodestino = $idespacho->id;
        $this->despachodestino = $idespacho->nombre;
    }

    public function agregar_cargo(Personales_cargo $icargo)
    {
        $this->cargo = $icargo->nombre;
    }


    // FUNCIONES PARA NUEVOS DOCUMENTOS
    public function nuevo_adenda(Persona $ipersona)
    {
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // RESTABLECER VARIABLES
        $this->reset();

        $this->funcionGuardarActualizar="guardar_adenda";

        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "Adenda";
        $this->colorGuardarActualizar = "primary";
        $this->textoGuardarActualizar = "Guardar adenda";
        $this->colorAgregar = "outline-primary";

        // ===== BLOQUEO DE SECCIONES =====
        $this->seccionFoto = "disabled";
        $this->seccionPersona = "disabled";
        $this->seccionPersonal = "disabled";

        // DATOS PERSONA
        $this->ver_persona($ipersona);

        // DATOS PERSONAL
        $ipersonal = Personale::where([['activo',"1"],['persona_dni', $this->dni],])->firstOrFail();

        $this->ver_personal($ipersonal);
        
        $this->tipo_documento = "ADENDA";
        $this->fecha_inicio = $ipersonal->fecha_fin
            ? Carbon::parse($ipersonal->fecha_fin)->addDay()->format('Y-m-d')
            : null;
        $this->fecha_fin = "";
    }

    public function guardar_adenda()
    {
        $this->validate();

        try {

            DB::transaction(function () {
                $ipersonal = Personale::where('id', $this->personal_id)->firstOrFail();

                // Actualizar Personal
                $ipersonal->update([
                    'activo' => "0",
                ]);

                // FUNCIÓN PARA CARGAR DOCUMENTO
                $rutaDocumento = $this->guardar_documento();

                // GUARDAR CAMPOS DE PERSONAL
                $this->guardar_personal($rutaDocumento);
            });

            $this->resetExcept('searchPersonal');

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Datos actualizados',
                mensaje: 'Los datos se han actualizado correctamente.',
                tipo: 'success'
            );

            // Evento para cerrar el modal
            $this->dispatch('cerrar-modal', id: 'nuevoEditarModal');

        } catch (\Throwable $e) {

            report($e);

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Error',
                mensaje: 'Ocurrió un error al guardar.',
                tipo: 'error'
            );
        }
    }

    public function nuevo_renuncia(Persona $ipersona)
    {
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // Restablecer todas las variables
        // $this->reset();

        $this->funcionGuardarActualizar="guardar_renuncia";

        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "dark-subtle";
        $this->textoHeaderModal = "Renuncia";
        $this->colorGuardarActualizar = "dark";
        $this->textoGuardarActualizar = "Guardar renuncia";
        $this->colorAgregar = "outline-dark";

        // ===== BLOQUEO DE SECCIONES =====
        $this->seccionFoto = "disabled";
        $this->seccionPersona = "disabled";
        $this->seccionPersonal = "disabled";

        // DATOS PERSONA
        $this->ver_persona($ipersona);

        // DATOS PERSONAL
        $ipersonal = Personale::where([['activo',"1"],['persona_dni', $this->dni],])->firstOrFail();

        $this->ver_personal($ipersonal);

        $this->tipo_documento = "RENUNCIA";
        
        $this->fecha_inicio = $ipersonal->fecha_inicio;
    }

    public function guardar_renuncia()
    {
        $this->validate();

        try {

            DB::transaction(function () {
                $usuario = auth()->user()->datos; // Mejor que usar propiedad pública

                $ipersonal = Personale::where('id', $this->personal_id)->firstOrFail();

                // Actualizar Personal
                $ipersonal->update([
                    'fecha_fin' => $this->fecha_fin,
                    'activo' => "0",
                ]);

                // FUNCIÓN PARA CARGAR DOCUMENTO
                $rutaDocumento = $this->guardar_documento();

                // GUARDAR CAMPOS DE PERSONAL
                $this->guardar_personal($rutaDocumento);
            });

            $this->resetExcept('searchPersonal');

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Datos actualizados',
                mensaje: 'Los datos se han actualizado correctamente.',
                tipo: 'success'
            );

            // Evento para cerrar el modal
            $this->dispatch('cerrar-modal', id: 'nuevoEditarModal');

        } catch (\Throwable $e) {

            report($e);

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Error',
                mensaje: 'Ocurrió un error al guardar.',
                tipo: 'error'
            );
        }
    }

    public function nuevo_contrato(Persona $ipersona)
    {
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // Restablecer todas las variables
        // $this->reset();

        $this->funcionGuardarActualizar="guardar_contrato";

        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "info-subtle";
        $this->textoHeaderModal = "Contrato";
        $this->colorGuardarActualizar = "info";
        $this->textoGuardarActualizar = "Guardar contrato";
        $this->colorAgregar = "outline-info";

        // ===== BLOQUEO DE SECCIONES =====
        $this->seccionFoto = "disabled";
        $this->seccionPersona = "disabled";
        $this->seccionPersonal = "";

        /// DATOS PERSONA
        $this->ver_persona($ipersona);

        // DATOS PERSONAL
        $ipersonal = Personale::where([['activo',"1"],['persona_dni', $this->dni],])->firstOrFail();

        $this->ver_personal($ipersonal);

        $this->tipo_documento = "CONTRATO";

        $this->personal_id = $ipersonal->id;
    }

    public function guardar_contrato()
    {
        $this->validate();

        try {

            DB::transaction(function () {
                $ipersonal = Personale::where('id', $this->personal_id)->firstOrFail();

                // Actualizar Personal
                $ipersonal->update([
                    'activo' => "0",
                ]);

                // FUNCIÓN PARA CARGAR DOCUMENTO
                $rutaDocumento = $this->guardar_documento();

                // GUARDAR CAMPOS DE PERSONAL
                $this->guardar_personal($rutaDocumento);
            });

            $this->resetExcept('searchPersonal');

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Datos actualizados',
                mensaje: 'Los datos se han actualizado correctamente.',
                tipo: 'success'
            );

            // Evento para cerrar el modal
            $this->dispatch('cerrar-modal', id: 'nuevoEditarModal');

        } catch (\Throwable $e) {

            report($e);

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Error',
                mensaje: 'Ocurrió un error al guardar.',
                tipo: 'error'
            );
        }
    }

    // FUNCIONES DE HISTORIAL
    public function historial_documentos($persona_dni)
    {
        $this->dni = $persona_dni;
    }

    // FUNCIONES DE TRANSFERIR PERSONAL

    public function nuevo_transferir_personal(Persona $ipersona)
    {
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // Restablecer todas las variables
        // $this->reset();

        $this->funcionGuardarActualizar="guardar_transferir_personal";

        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "Nuevo ubicación de personal";
        $this->colorGuardarActualizar = "primary";
        $this->textoGuardarActualizar = "Guardar";
        $this->colorAgregar = "outline-primary";
        
        $this->dni = $ipersona->dni;

        $this->codsededestino = "";
        $this->sededestino = "";
        $this->coddependenciadestino = "";
        $this->dependenciadestino = "";
        $this->coddespachodestino = "";
        $this->despachodestino = "";

    }

    public function guardar_transferir_personal()
    {
        try {

            DB::transaction(function () {

                $usuario = auth()->user()->datos;

                // Buscar Personal
                // ===== DATOS PERSONAL =====
                $personal = Personale::where([['activo',"1"],['persona_dni', $this->dni],])->firstOrFail();

                // Actualizar Personal
                $personal->update([
                    'codsededestino' => $this->codsedeorigen,
                    'sededestino' => $this->sedeorigen,
                    'coddependenciadestino' => $this->coddependenciaorigen,
                    'dependenciadestino' => $this->dependenciaorigen,
                    'coddespachodestino' => $this->coddespachoorigen,
                    'despachodestino' => $this->despachoorigen,
                    'updated_user' => $usuario,
                ]);
            });

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Datos actualizados',
                mensaje: 'Los datos se han actualizado correctamente.',
                tipo: 'success'
            );

            // Evento para cerrar el modal
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

    public function cerrar_transferir_personal()
    {
        // Restablecer todas las variables
        $this->reset();
    }

    // FUNCIONES PARA HISTORIAL
    public function editar_pdf($personal_id)
    {
        $this->personal_id = $personal_id;
    }
    public function actualizar_pdf()
    {
        // ===== DATOS PERSONAL =====
        $ipersonal = Personale::where('id', $this->personal_id)->firstOrFail();
        
        // Validar solo el PDF
        $this->validate([
            'pdf' => 'required|file|mimes:pdf|max:5120'
        ]);

        try {

            DB::transaction(function () use ($ipersonal) {

                $usuario = auth()->user()->datos;

                // Ruta actual
                $rutaDocumento = $ipersonal->ruta_documento;

                if ($this->pdf) {

                    // Eliminar anterior si existe
                    if ($rutaDocumento &&
                        Storage::disk('public')->exists($rutaDocumento)) {

                        Storage::disk('public')->delete($rutaDocumento);
                    }

                    // Generar nombre limpio
                    $fileName = str_replace(' ', '_',
                        $ipersonal->numero_convocatoria . '_' .
                        $ipersonal->persona_dni . '_' .
                        $ipersonal->tipo_documento . '_' .
                        $ipersonal->fecha_inicio . '_' .
                        $ipersonal->fecha_fin
                    ) . '.pdf';

                    // Guardar archivo
                    $rutaDocumento = $this->pdf->storeAs(
                        'archivos/rrhh/personal/documentos',
                        $fileName,
                        'public'
                    );

                    // Actualizar solo si se subió archivo
                    $ipersonal->update([
                        'ruta_documento' => $rutaDocumento,
                        'updated_user' => $usuario,
                    ]);
                }

            });

            $this->reset('pdf');

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Documento cargado',
                mensaje: 'El PDF se cargó correctamente.',
                tipo: 'success'
            );

        } catch (\Throwable $e) {

            report($e);

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Error',
                mensaje: 'Ocurrió un error al cargar el PDF.',
                tipo: 'error'
            );
        }
    }

    // FUNCIONES PERSONA - PERSONAL

    private function ver_persona(Persona $ipersona)
    {
        $this->persona_id = $ipersona->id;

        $this->dni = $ipersona->dni;
        $this->nombres = $ipersona->nombres;
        $this->appaterno = $ipersona->appaterno;
        $this->apmaterno = $ipersona->apmaterno;
        $this->celpersonal = $ipersona->celpersonal;
        $this->correopersonal = $ipersona->correopersonal;

        $this->fotoactual = $ipersona->foto;
    }

    private function ver_personal(Personale $ipersonal){
        $this->personal_id = $ipersonal->id;

        $this->regimen = $ipersonal->regimen;
        $this->tipo_regimen = $ipersonal->tipo_regimen;
        $this->cargo = $ipersonal->cargo;
        $this->codsedeorigen = $ipersonal->codsedeorigen;
        $this->sedeorigen = $ipersonal->sedeorigen;
        $this->coddependenciaorigen = $ipersonal->coddependenciaorigen;
        $this->dependenciaorigen = $ipersonal->dependenciaorigen;
        $this->coddespachoorigen = $ipersonal->coddespachoorigen;
        $this->despachoorigen = $ipersonal->despachoorigen;

        $this->codsededestino = $ipersonal->codsededestino;
        $this->sededestino = $ipersonal->sededestino;
        $this->coddependenciadestino = $ipersonal->coddependenciadestino;
        $this->dependenciadestino = $ipersonal->dependenciadestino;
        $this->coddespachoorigen = $ipersonal->coddespachoorigen;
        $this->despachodestino = $ipersonal->despachodestino;

        $this->celinstitucional = $ipersonal->celinstitucional;
        $this->correoinstitucional = $ipersonal->correoinstitucional;

        $this->numero_convocatoria = $ipersonal->numero_convocatoria;
    }

    private function guardar_personal($rutaDocumento)
    {
        $usuario = auth()->user()->datos; // Mejor que usar propiedad pública

        Personale::create([
                    'persona_id' => $this->persona_id,
                    'persona_dni' => $this->dni,

                    'regimen' => $this->regimen,
                    'tipo_regimen' => $this->tipo_regimen,
                    'cargo' => $this->cargo,
                    'codsedeorigen' => $this->codsedeorigen,
                    'sedeorigen' => $this->sedeorigen,
                    'coddependenciaorigen' => $this->coddependenciaorigen,
                    'dependenciaorigen' => $this->dependenciaorigen,
                    'coddespachoorigen' => $this->coddespachoorigen,
                    'despachoorigen' => $this->despachoorigen,

                    'codsededestino' => $this->codsededestino,
                    'sededestino' => $this->sededestino,
                    'coddependenciadestino' => $this->coddependenciadestino,
                    'dependenciadestino' => $this->dependenciadestino,
                    'coddespachoorigen' => $this->coddespachoorigen,
                    'despachodestino' => $this->despachodestino,

                    'celinstitucional' => $this->celinstitucional,
                    'correoinstitucional' => $this->correoinstitucional,

                    'numero_convocatoria' => strtoupper($this->numero_convocatoria),
                    'tipo_documento' => strtoupper($this->tipo_documento),
                    'fecha_inicio' => $this->fecha_inicio,
                    'fecha_fin' => $this->fecha_fin,

                    // 🔥 Guardamos la ruta real del archivo
                    'ruta_documento' => $rutaDocumento,

                    'activo' => '1',
                    'created_user' => $usuario,
                    'updated_user' => $usuario,
                ]);
    }
}
