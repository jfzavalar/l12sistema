<?php

namespace App\Livewire\Informatica\Firmas\Token;

use App\Http\Controllers\Informatica\FirmasdigitalesController;
use App\Models\InformaticasBienesToken;
use App\Models\InformaticasFirmasToken;
use App\Models\Persona;
use App\Models\Personale;
use App\Models\Personales_cargo;
use App\Models\Personales_dependencia;
use App\Models\Personales_despacho;
use App\Models\Personales_sede;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Symfony\Component\Translation\Formatter\IntlFormatter;

class Activos extends Component
{
    protected $listeners = ['tokensActivado' => '$refresh'];

    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $mostrarBtnBuscarDni = "d-none";

    public $colorHeaderModal, $textoHeaderModal;
    public $colorNuevoEditar, $textoNuevoEditar;
    public $colorGuardarActualizar, $textoGuardarActualizar;
    public $colorAgregar;

    //Variables PARA OCULTAR Y MOSTRAR TXT_OTROS
    public $mostrarotrosp = "d-none", $mostrarotrosc = "d-none",$mostrarcargafoto = "d-none";

    //Variables bloquear de secciones
    public $seccionFoto, $seccionPersona, $seccionPersonal,$seccionToken;

    // Variable de función Guardar o Actualizar
    public $funcionGuardarActualizar;
    
    public $pdf;

    public $avatar;

    // Variables para filtrar

    // Variables de búsqueda
    public $search, $searchi,$searchhistorial, $searchpersonas, $searchsedes,$searchdependencias,$searchdespachos,$searchcargos,$searchtokens;

    public function updatingSearch(){
        $this->resetPage('firmastokensPage');
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
    public function updatingSearchtokens(){
        $this->resetPage('tokensPage');
    }

    Public $filtro_firma,$filtro_asignacion,$filtro_verificar;

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
            $persona_dni,
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

    public $firma_token_id,
            $token_codigo,          
            $asignacion,
            $fecha_expiracion,
            $verificar,
            $observacion;

    public $token_id,
            $codigo,
            $equipo,
            $modelo,
            $operativo,
            $asignado;

    public $pdf_acta;

    public function filtrarTotal()
    {
        $this->resetFiltros();
    }

    public function filtrarFirmadas()
    {
        $this->resetFiltros();
        $this->filtro_firma = 'con';
    }

    public function filtrarSinFirmar()
    {
        $this->resetFiltros();
        $this->filtro_firma = 'sin';
    }

    public function filtrarAsignados()
    {
        $this->resetFiltros();
        $this->filtro_asignacion = 'ASIGNACION';
    }

    public function filtrarDevueltos()
    {
        $this->resetFiltros();
        $this->filtro_asignacion = 'DEVOLUCION';
    }

    public function filtrarVerificados()
    {
        $this->resetFiltros();
        $this->filtro_verificar = '1';
    }

    public function filtrarNoVerificados()
    {
        $this->resetFiltros();
        $this->filtro_verificar = '0';
    }

    private function resetFiltros()
    {
        $this->search = '';
        $this->filtro_firma = '';
        $this->filtro_asignacion = '';
        $this->filtro_verificar= '';

        $this->resetPage('firmastokensPage');
    }

    public function render()
    {
        $lista_activos = $this->queryConFiltros()
            ->orderByDesc('id')
            ->paginate(30, ['*'], 'firmastokensPage');

        $estadisticas = InformaticasFirmasToken::where('activo', '1')
            ->selectRaw("
                COUNT(*) as total,

                SUM(CASE 
                    WHEN ruta_documento IS NOT NULL 
                    AND ruta_documento <> '' 
                    THEN 1 ELSE 0 
                END) as firmadas,

                SUM(CASE 
                    WHEN ruta_documento IS NULL 
                    OR ruta_documento = '' 
                    THEN 1 ELSE 0 
                END) as sin_firmar,

                SUM(CASE 
                    WHEN asignacion IS NULL 
                    OR asignacion = 'ASIGNACION' 
                    THEN 1 ELSE 0 
                END) as asignacion,

                SUM(CASE 
                    WHEN asignacion IS NULL 
                    OR asignacion = 'DEVOLUCION' 
                    THEN 1 ELSE 0 
                END) as devolucion,

                -- 🔥 NUEVO: verificar = 1
                SUM(CASE 
                    WHEN verificar = 1 
                    THEN 1 ELSE 0 
                END) as verificados,

                -- 🔥 NUEVO: verificar = 0
                SUM(CASE 
                    WHEN verificar = 0 
                    THEN 1 ELSE 0 
                END) as no_verificados
            ")
            ->first();

        $lista_historial = InformaticasFirmasToken::where('token_id',$this->token_id)
            ->when($this->searchpersonas !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->searchhistorial . '%')
                    ->orWhere('datos', 'like', '%' . $this->searchhistorial . '%');
                });
            })
            ->orderBy('id','desc')
            ->paginate(10,['*'],'historialPaginate');

        $lista_personas = Persona::where('activo','1')
            ->when($this->searchpersonas !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->searchpersonas . '%')
                    ->orWhere('datos', 'like', '%' . $this->searchpersonas . '%');
                });
            })
            ->orderBy('datos')
            ->paginate(10,['*'],'personasPage');

        $lista_sedes = Personales_sede::select('id','nombre','nombre')
            ->where('activo','1')
            ->where('nombre','like','%' . $this->searchsedes . '%')
            // ->distinct()
            ->orderBy('nombre')
            ->paginate(30,['*'], 'sedesPage');
            
        $lista_dependencias = Personales_dependencia::select('id','nombre')
            ->where('activo','1')
            // ->where(function ($query) {
            //     $query->where('sede_id', $this->codsedeorigen)
            //         ->orWhere('sede_id', $this->filtrosede);
            // })
            ->where('nombre','like','%' . $this->searchdependencias . '%')
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

        $lista_bienes_tokens = InformaticasBienesToken::where('activo','1')
            ->where('asignado','0')
            ->where('codigo','like','%' . $this->searchtokens . '%')
            ->orderBy('codigo')
            ->paginate(10,['*'],'tokensPage');

        return view('livewire.informatica.firmas.token.activos',
            compact('lista_activos','lista_personas','lista_historial',
                    'lista_sedes','lista_dependencias','lista_bienes_tokens','estadisticas'));
    }

    private function queryConFiltros()
    {
        return InformaticasFirmasToken::where('activo', '1')

            ->when($this->search, fn($q) =>
                $q->where(fn($q2) =>
                    $q2->where('dni', 'like', "%{$this->search}%")
                    ->orWhere('datos', 'like', "%{$this->search}%")
                )
            )

            ->when($this->filtro_firma === 'con', fn($q) =>
                $q->whereNotNull('ruta_documento')
                ->where('ruta_documento', '<>', '')
            )

            ->when($this->filtro_firma === 'sin', fn($q) =>
                $q->where(fn($q2) =>
                    $q2->whereNull('ruta_documento')
                    ->orWhere('ruta_documento', '')
                )
            )

            ->when($this->filtro_asignacion, fn($q) =>
                $q->where('asignacion', $this->filtro_asignacion)
            )

            ->when($this->filtro_verificar !== null, fn($q) =>
                $q->where('verificar', $this->filtro_verificar)
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
            'nombres' => 'required',
            'appaterno' => 'required',
            'apmaterno' => 'required',

            'sedeorigen' => 'required',
            'dependenciaorigen' => 'required',
            'despachoorigen' => 'required',
            'regimen' => 'required',
            'cargo' => 'required',

            // 'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
            // 'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',

            // 'foto' => 'nullable|image|mimes:jpg,jpeg|max:2048', // 2MB máximo

            // 'pdf_acta' => 'nullable|file|mimes:pdf|max:5120', // 5MB            
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

        // 'fecha_inicio.required' => 'Campo requerido',
        // 'fecha_fin.required' => 'Campo requerido',

        // 'fecha_inicio.before_or_equal' => 'La fecha de inicio no puede ser mayor a la fecha de fin.',
        // 'fecha_fin.after_or_equal' => 'La fecha de fin no puede ser menor a la fecha de inicio.',

        // 'pdf_acta.mimes' => 'Solo se permiten archivos PDF.',
        // 'pdf_acta.max' => 'El archivo no debe superar 5MB.',
    ];

    public function nuevo(){
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
    }

    public function guardar()
    {
        $this->validate();

        try {

            DB::transaction(function () {

                $usuario = auth()->user()->datos; // Mejor que usar propiedad pública

                InformaticasFirmasToken::create([
                    'persona_id' => $this->persona_id,
                    'dni' => $this->dni,
                    'datos' => $this->datos,
                    'personal_id' => $this->personal_id,
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
                    'despachodestino' => $this->despachodestino,
                    'token_id' => $this->token_id,
                    'token_codigo' => $this->token_codigo,
                    'asignacion' => "ASIGNACION",
                    'fecha_expiracion' => $this->fecha_expiracion,
                    'observacion' => $this->observacion,
                    'ruta_documento' => $this->ruta_documento,
                    'activo' => '1',
                    'created_user' => $usuario,
                    'updated_user' => $usuario,
                ]);

                $itoken = InformaticasBienesToken::findOrFail($this->token_id);

                $itoken->update([
                    'asignado' => '1',
                ]);

            });

            // $this->resetExcept('searchPersonal');

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

    public function editar($firmatoken_id)
    {
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // Restablecer todas las variables
        $this->reset();
        $this->foto = null;
        $this->fotoactual = null;
        $this->inputFileKey = rand();

        $this->funcionGuardarActualizar="actualizar";

        $this->colorHeaderModal = "success-subtle";
        $this->textoHeaderModal = "EDITAR";
        $this->colorGuardarActualizar = "success";
        $this->textoGuardarActualizar = "Actualizar";
        $this->colorAgregar = "outline-success";

        // $this->tipo_documento = "CONTRATO";

        // ===== BLOQUEO DE SECCIONES =====
        $this->seccionFoto = "disabled";
        $this->seccionPersona = "disabled";
        $this->seccionPersonal = "disabled";

        // ===== DATOS FIRMA TOKEN =====
        $ifirmatoken = InformaticasFirmasToken::findOrFail($firmatoken_id);

        $this->firma_token_id = $ifirmatoken->id;
        $this->token_id = $ifirmatoken->token_id;
        $this->persona_id = $ifirmatoken->persona_id;
        $this->dni = $ifirmatoken->dni;
        $this->datos = $ifirmatoken->persona_datos;
        $this->personal_id = $ifirmatoken->personal_id;
        $this->fecha_expiracion = $ifirmatoken->fecha_expiracion;
        $this->observacion = $ifirmatoken->observacion;

        // ===== DATOS FIRMA TOKEN =====
        $itoken = InformaticasBienesToken::findOrFail($this->token_id);
        
        $this->token_codigo = $itoken->codigo;
        $this->equipo = $itoken->equipo;
        $this->modelo = $itoken->modelo;
        $this->operativo = $itoken->operativo;
        $this->asignado = $itoken->asignado;

        // ===== DATOS PERSONA =====
        if ($ifirmatoken->dni) {

            $ipersona = Persona::where('dni', $ifirmatoken->dni)
                ->where('activo','1')
                ->first();

            if (!$ipersona) {
                session()->flash('error', 'Persona no encontrada');
                return;
            }

            $this->persona_id = $ipersona->id;
            $this->dni = $ipersona->dni;
            $this->datos = $ipersona->datos;
            $this->nombres = $ipersona->nombres;
            $this->appaterno = $ipersona->appaterno;
            $this->apmaterno = $ipersona->apmaterno;
            $this->celpersonal = $ipersona->celpersonal;
            $this->correopersonal = $ipersona->correopersonal;
            $this->fotoactual = $ipersona->foto;

            // SOLO después de validar
            $ipersonal = Personale::where([['persona_dni', $this->dni],['activo','1']])
                ->where('activo','1')
                ->first();

            if ($ipersonal) {
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
                $this->sededestino = $ifirmatoken->sededestino;
                $this->coddependenciadestino = $ipersonal->coddependenciadestino;
                $this->dependenciadestino = $ifirmatoken->dependenciadestino;
                $this->coddespachodestino = $ipersonal->coddespachodestino;
                $this->despachodestino = $ifirmatoken->despachodestino;

                $this->celinstitucional = $ipersonal->celinstitucional;
                $this->correoinstitucional = $ipersonal->correoinstitucional;
            }
        }
    }

    public function actualizar()
    {
        $this->validate();

        try {

            $usuario = optional(auth()->user())->datos ?? 'SYSTEM';

            $ifirmatoken = InformaticasFirmasToken::findOrFail($this->firma_token_id);

            $ifirmatoken->update([
                'persona_id' => $this->persona_id,
                'dni' => $this->dni,
                'datos' => $this->datos,
                'personal_id' => $this->personal_id,
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
                'despachodestino' => $this->despachodestino,
                'token_id' => $this->token_id,
                'token_codigo' => $this->token_codigo,
                'asignacion' => "ASIGNACION",
                'fecha_expiracion' => $this->fecha_expiracion,
                'observacion' => $this->observacion,
                'updated_user' => $usuario,
            ]);

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
                mensaje: config('app.debug') ? $e->getMessage() : 'Ocurrió un error al actualizar.',
                tipo: 'error'
            );
        }
    }

    public function desactivar(InformaticasFirmasToken $ibien){
        try {
            $usuario = auth()->user()->datos; // Mejor que usar propiedad pública

            $ibien->update([
                'activo' => '0',
                'updated_user' => $usuario,
            ]);

            // Comunica que se desactivado
            $this->dispatch('ipDesactivado');

            session()->flash('danger', 'Usuario desactivado correctamente');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al desactivar el usuario: ' . $e->getMessage());
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

    //TRÁMITES TOKEN DEVOLVER - REASIGNAR
    public function nuevo_devolucion($firmatoken_id)
    {
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // Restablecer todas las variables
        $this->reset();
        $this->foto = null;
        $this->fotoactual = null;
        $this->inputFileKey = rand();

        $this->funcionGuardarActualizar="guardar_devolucion";

        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "danger-subtle";
        $this->textoHeaderModal = "NUEVA DEVOLUCION";
        $this->colorGuardarActualizar = "danger";
        $this->textoGuardarActualizar = "Guardar devolucion";
        $this->colorAgregar = "outline-danger";

        // ===== BLOQUEO DE SECCIONES =====
        $this->seccionFoto = "disabled";
        $this->seccionPersona = "disabled";
        $this->seccionPersonal = "disabled";
        $this->seccionToken = "disabled";

        // ===== DATOS FIRMA TOKEN =====
        $ifirmatoken = InformaticasFirmasToken::findOrFail($firmatoken_id);

        $this->firma_token_id = $ifirmatoken->id;
        $this->token_id = $ifirmatoken->token_id;
        $this->persona_id = $ifirmatoken->persona_id;
        $this->dni = $ifirmatoken->dni;
        $this->datos = $ifirmatoken->persona_datos;
        $this->personal_id = $ifirmatoken->personal_id;
        $this->fecha_expiracion = $ifirmatoken->fecha_expiracion;
        $this->observacion = $ifirmatoken->observacion;

        // ===== DATOS FIRMA TOKEN =====
        $itoken = InformaticasBienesToken::findOrFail($this->token_id);
        
        $this->token_codigo = $itoken->codigo;
        $this->equipo = $itoken->equipo;
        $this->modelo = $itoken->modelo;
        $this->operativo = $itoken->operativo;
        $this->asignado = $itoken->asignado;

        // ===== DATOS PERSONA =====
        if ($ifirmatoken->dni) {

            $ipersona = Persona::where('dni', $ifirmatoken->dni)
                ->where('activo','1')
                ->first();

            if (!$ipersona) {
                session()->flash('error', 'Persona no encontrada');
                return;
            }

            $this->persona_id = $ipersona->id;
            $this->dni = $ipersona->dni;
            $this->datos = $ipersona->datos;
            $this->nombres = $ipersona->nombres;
            $this->appaterno = $ipersona->appaterno;
            $this->apmaterno = $ipersona->apmaterno;
            $this->celpersonal = $ipersona->celpersonal;
            $this->correopersonal = $ipersona->correopersonal;
            $this->fotoactual = $ipersona->foto;

            // SOLO después de validar
            $ipersonal = Personale::where([['persona_dni', $this->dni],['activo','1']])
                ->where('activo','1')
                ->first();

            if ($ipersonal) {
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
                $this->sededestino = $ifirmatoken->sededestino;
                $this->coddependenciadestino = $ipersonal->coddependenciadestino;
                $this->dependenciadestino = $ifirmatoken->dependenciadestino;
                $this->coddespachodestino = $ipersonal->coddespachodestino;
                $this->despachodestino = $ifirmatoken->despachodestino;

                $this->celinstitucional = $ipersonal->celinstitucional;
                $this->correoinstitucional = $ipersonal->correoinstitucional;
            }
        }
    }

    public function guardar_devolucion()
    {
        $this->validate();

        try {

            DB::transaction(function () {

            $usuario = auth()->user()->datos;

            // Desactivar anterior
            $ifirmatoken = InformaticasFirmasToken::findOrFail($this->firma_token_id);
            $ifirmatoken->update([
                'activo' => '0',
            ]);

            // Liberar token
            $itoken = InformaticasBienesToken::findOrFail($this->token_id);
            $itoken->update([
                'asignado' => '0',
            ]);

            // Guardar PDF correctamente
            $rutaDocumento = $this->guardar_acta();

            // Crear devolución
            InformaticasFirmasToken::create([
                'persona_id' => $this->persona_id,
                'dni' => $this->dni,
                'datos' => $this->datos,
                'personal_id' => $this->personal_id,
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
                'despachodestino' => $this->despachodestino,
                'token_id' => $this->token_id,
                'token_codigo' => $this->token_codigo,
                'asignacion' => "DEVOLUCION",
                'fecha_expiracion' => $this->fecha_expiracion,
                'observacion' => $this->observacion,
                'ruta_documento' => $rutaDocumento, // 🔥 FIX
                'activo' => '1',
                'created_user' => $usuario,
                'updated_user' => $usuario,
            ]);

        });

            // $this->resetExcept('searchPersonal');

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
                // mensaje: $e->getMessage(),
                mensaje: 'Ocurrió un error al guardar.',
                tipo: 'error'
            );
        }
    }

    public function nuevo_reasignacion($firmatoken_id){
         $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // Restablecer todas las variables
        $this->reset();
        $this->foto = null;
        $this->fotoactual = null;
        $this->inputFileKey = rand();

        $this->funcionGuardarActualizar="guardar_reasignacion";

        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "NUEVA REASIGNACION";
        $this->colorGuardarActualizar = "primary";
        $this->textoGuardarActualizar = "Guardar reasignación";
        $this->colorAgregar = "outline-primary";

        // ===== BLOQUEO DE SECCIONES =====
        $this->seccionFoto = "disabled";
        $this->seccionPersona = "disabled";
        $this->seccionPersonal = "disabled";
        $this->seccionToken = "disabled";

        // ===== DATOS FIRMA TOKEN =====
        $ifirmatoken = InformaticasFirmasToken::findOrFail($firmatoken_id);

        $this->firma_token_id = $ifirmatoken->id;
        $this->token_id = $ifirmatoken->token_id;
        $this->persona_id = $ifirmatoken->persona_id;
        // $this->dni = $ifirmatoken->dni;
        $this->datos = $ifirmatoken->persona_datos;
        $this->personal_id = $ifirmatoken->personal_id;
        $this->fecha_expiracion = $ifirmatoken->fecha_expiracion;
        $this->observacion = $ifirmatoken->observacion;

        // ===== DATOS FIRMA TOKEN =====
        $itoken = InformaticasBienesToken::findOrFail($this->token_id);
        
        $this->token_codigo = $itoken->codigo;
        $this->equipo = $itoken->equipo;
        $this->modelo = $itoken->modelo;
        $this->operativo = $itoken->operativo;
        $this->asignado = $itoken->asignado;
    }

    public function guardar_reasignacion()
    {
        $this->validate();

        try {

            DB::transaction(function () {

                $usuario = auth()->user()->datos; // Mejor que usar propiedad pública

                //Desahabilitamos el registro anterior
                $ifirmatoken = InformaticasFirmasToken::findOrFail($this->firma_token_id);
                $ifirmatoken->update([
                    'activo' => '0',
                ]);

                $itoken = InformaticasBienesToken::findOrFail($this->token_id);
                $itoken->update([
                    'asignado' => '1',
                ]);

                InformaticasFirmasToken::create([
                    'persona_id' => $this->persona_id,
                    'dni' => $this->dni,
                    'datos' => $this->datos,
                    'personal_id' => $this->personal_id,
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
                    'despachodestino' => $this->despachodestino,
                    'token_id' => $this->token_id,
                    'token_codigo' => $this->token_codigo,
                    'asignacion' => "ASIGNACION",
                    'fecha_expiracion' => $this->fecha_expiracion,
                    'observacion' => $this->observacion,
                    'ruta_documento' => $this->ruta_documento,
                    'activo' => '1',
                    'created_user' => $usuario,
                    'updated_user' => $usuario,
                ]);

            });

            // $this->resetExcept('searchPersonal');

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

    public function historial_tokens($token_id)
    {
        $this->token_id = $token_id;
    }

    // PERSONAL
    // ---------------------------------------------------------
    public function buscar_personal(){

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

        $this->codsededestino = $ipersonal->codsededestino;
        $this->sededestino = $ipersonal->sededestino;
        $this->coddependenciadestino = $ipersonal->coddependenciadestino;
        $this->dependenciadestino = $ipersonal->dependenciadestino;
        $this->coddespachodestino = $ipersonal->coddespachodestino;
        $this->despachodestino = $ipersonal->despachodestino;

        $this->celinstitucional = $ipersonal->celinstitucional;
        $this->correoinstitucional = $ipersonal->correoinstitucional;
        $this->regimen = $ipersonal->regimen;
        $this->tipo_regimen = $ipersonal->tipo_regimen;
        $this->cargo = $ipersonal->cargo;
    }

    public function agregar_token(InformaticasBienesToken $itoken)
    {
        $this->token_id = $itoken->id;
        $this->token_codigo = $itoken->codigo;
        $this->equipo = $itoken->equipo;
        $this->modelo = $itoken->modelo;
        $this->operativo = $itoken->operativo;
        $this->asignado = $itoken->asignado;
    }

    public function cerrar_token()
    {
        $this->reset('searchtokens');
    }


    // FUNCIONES PARA CARGAR PDF


    public function editar_pdf($firma_token_id)
    {
        $this->firma_token_id = $firma_token_id;
    }

    public function actualizar_pdf()
    {
        // ===== DATOS PERSONAL =====
        $ifirmatoken = InformaticasFirmasToken::where('id', $this->firma_token_id)->firstOrFail();

        $this->token_codigo = $ifirmatoken->token_codigo;
        $this->asignacion = $ifirmatoken->asignacion;
        
        // Validar solo el PDF
        $this->validate([
            'pdf_acta' => 'required|file|mimes:pdf|max:5120'
        ]);

        try {

            DB::transaction(function () use ($ifirmatoken) {

                $usuario = auth()->user()->datos;

                // Ruta actual
                $rutaDocumento = $this->actualizar_acta();

                $ifirmatoken->update([
                    'ruta_documento' => $rutaDocumento,
                    'updated_user' => $usuario,
                ]);

            });

            $this->reset('pdf_acta');

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



    private function guardar_acta()
    {
        if (!$this->pdf_acta) {
            return null;
        }

        $fileName = now()->format('Ymd_His') . '_'
            . ($this->dni ?? 'sin-dni') . '_'
            . Str::slug($this->asignacion ?? 'sin-asignacion') . '_'
            . Str::slug($this->token_codigo ?? 'sin-token')
            . '.pdf';

        $path = $this->pdf_acta->storeAs(
            'archivos/informatica/tokens',
            $fileName,
            'public'
        );

        // 🔥 Guardas con storage/
        return 'storage/' . $path;
    }

    private function actualizar_acta()
    {
        $ifirmatoken = InformaticasFirmasToken::findOrFail($this->firma_token_id);

        $rutaDocumento = $ifirmatoken->ruta_documento;

        if (!$this->pdf_acta) {
            return $rutaDocumento;
        }

        // 🔥 Convertir ruta BD → ruta usable por Storage
        $rutaStorage = Str::after($rutaDocumento, 'storage/');

        // Si no existe archivo previo
        if (!$rutaDocumento) {
            return $this->guardar_acta();
        }

        $fileName = basename($rutaStorage);
        $directory = dirname($rutaStorage);

        // Eliminar archivo anterior
        if (Storage::disk('public')->exists($rutaStorage)) {
            Storage::disk('public')->delete($rutaStorage);
        }

        // Guardar nuevo archivo con mismo nombre
        $nuevoPath = $this->pdf_acta->storeAs(
            $directory,
            $fileName,
            'public'
        );

        // 🔥 Volver a formato BD (con storage/)
        return 'storage/' . $nuevoPath;
    }

    // PDF exportar
    public function exportarPDF()
    {
        $datos = $this->queryConFiltros()
            ->orderBy('datos')
            ->get();

        $pdf = Pdf::loadView('pdf.informatica.token-reporte-filtro', [
            'datos' => $datos,
            'filtro_firma' => $this->filtro_firma,
            'filtro_asignacion' => $this->filtro_asignacion,
            'search' => $this->search
        ]);

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'reporte-activos.pdf'
        );
    }

    public function verificarfirmatoken($id)
    {
        $registro = InformaticasFirmasToken::find($id);

        if (!$registro) return;

        // 🔄 Toggle (0 ↔ 1)
        $registro->verificar = $registro->verificar == 1 ? 0 : 1;

        $registro->save(); // 🔥 ESTO FALTABA
    }
}
