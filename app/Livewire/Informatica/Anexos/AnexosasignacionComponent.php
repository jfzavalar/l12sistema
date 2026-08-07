<?php

namespace App\Livewire\Informatica\Anexos;

use App\Exports\TicketsfiltrosExport;
use App\Mail\NotificacionInformaticaTicket;
use App\Models\InformaticasBienesAnexos;
use App\Models\InformaticasBienesAnexosAsignaciones;
use App\Models\InformaticasFirmasToken;
use App\Models\InformaticasIp;
use App\Models\Ip;
use App\Models\Patrimonios_biene;
use App\Models\PatrimoniosBiene;
use App\Models\Persona;
use App\Models\Personale;
use App\Models\Personales_cargo;
use App\Models\Personales_dependencia;
use App\Models\Personales_despacho;
use App\Models\Personales_sede;
use App\Models\PersonalesAtencione;
use App\Models\PersonalesAtencionesIncidenciasSolicitudes;
use App\Models\PersonalesAtencionesServicio;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class AnexosasignacionComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    // VARIABLES PARA MODALES
    public $modalNuevoEditarAbrir = false, $modalReportesFiltros = false;

    public $modalPersonalBuscar = false;
    public $modalPersonalSedeBuscar = false;
    public $modalPersonalDependenciaBuscar = false;
    public $modalPersonalDespachoBuscar = false;
    public $modalPersonalCargoBuscar = false;
    public $modalInformaticaServicioBuscar = false;
    public $modalInformaticaServicioDetalleBuscar = false;
    public $modalPatrimonioBienesBuscar = false;
    public $modalPDFCargar = false;
    public $modalPDFEvidenciaCargar = false;
    public $modalHistorial = false;

    // VARIABLES PARA ADMINISTRAR MODALES
    public $colorHeaderModal, $textoHeaderModal;
    public $colorNuevoEditar, $textoNuevoEditar;
    public $colorGuardarActualizar, $textoGuardarActualizar;
    public $colorAgregar;

    //VARIABLES PARA OCULTAR Y MOSTRAR TXT_OTROS
    public $mostrarcontroles = "d-none",$mostrarcontrolgpli="d-none";
    public $mostrarotrosp = "d-none", $mostrarotrosc = "d-none",$mostrarcargafoto = "d-none";

    //VARIABLES PARA BLOQUEAR SECCIONES
    public $seccionFoto = "",
            $seccionPersona = "",
            $seccionPersonal    = "",
            $seccionDetalle = "";

     // VARIABLES DE FUNCION GUARDAR O ACTUALIZAR
    public $funcionGuardarActualizar;

    // VARIABLES INPUTS DE BUSQUEDA
    public $search, 
            $searchi,
            $searchhistorial, 
            $searchpersonas, 
            $searchsedes,
            $searchdependencias,
            $searchdespachos,
            $searchcargos,
            $searchservicios,
            $searchincidenciasolicitud,
            $searchbienes;
    
    public function updatingSearch(){
        $this->resetPage('atencionesPage');
    }
    public function updatingSearchi(){
        $this->resetPage('atencionesinactivosPage');
    }
    public function updatingSearchhistorial(){
        $this->resetPage('atencioneshistorialPage');
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
    public function updatingSearchpersonalatenciones(){
        $this->resetPage('personalatencionesPage');
    }
    public function updatingSearchservicios(){
        $this->resetPage('serviciosPage');
    }
    public function updatingSearchincidenciasolicitud(){
        $this->resetPage('incidenciasolicitudPage');
    }
    public function updatingSearchbienes(){
        $this->resetPage('bienesPage');
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
            $tipo_documento;

    public $anexoasignado_id,
            $anexo_id,
            $serie,
            $tipo = "1",
            $modelo = "J189",
            $anexo,
            $marca = "AVAYA",
            $transformador = "SI",
            $auriculares = "NO",
            $baseauriculares = "NO",
            $motivo,
            $asignacionlibrecustodia = "ASIGNACION",
            $asignacionlibrecustodiadesde,
            $asignacionlibrecustodiahasta,
            $custodia = "NO",
            $observacion,
            $ruta_evidencia,
            $ruta_documento,
            $estado = "BUENO",
            $informatico_dni,
            $informatico,
            $activo,
            $created_user_cargo,
            $created_user,
            $updated_user;

    public $pdf_acta;

    public $bandera_documento="EVIDENCIA";

    public function updatedTipo($value)
    {
        if ($value === "1"){
            $this->modelo = "J189";
            $this->auriculares = "NO";
            $this->baseauriculares = "NO";
        }
        elseif ($value === "2") {
            $this->modelo = "J139";
            $this->auriculares = "NO";
            $this->baseauriculares = "NO";
        }
        elseif ($value === "3") {
            $this->modelo = "K155";
            $this->auriculares = "SI";
            $this->baseauriculares = "SI";
        }
    }


    // ============================================================================================================================
    // RENDERIZADO DE PÁGINA
    // ============================================================================================================================

    public function render()
    {
        $lista_activos = InformaticasBienesAnexosAsignaciones::where('activo',1)
            ->orderBy('id','desc')
            ->paginate(10,['*'],'atencionesPage');

        $lista_historial = InformaticasBienesAnexosAsignaciones::where('anexo_id',$this->anexo_id)
            ->orderBy('id','desc')
            ->paginate(10,['*'],'atencionesHistorialPage');
        
        $estadisticas = InformaticasBienesAnexosAsignaciones::where('activo', 1)
            ->selectRaw("
                COUNT(*) as total,

                SUM(CASE
                    WHEN asignacionlibrecustodia = 'ASIGNACION'
                    THEN 1 ELSE 0
                END) as asignados,

                SUM(CASE
                    WHEN asignacionlibrecustodia = 'REASIGNACION'
                    THEN 1 ELSE 0
                END) as reasignados,

                SUM(CASE
                    WHEN asignacionlibrecustodia = 'DEVOLUCION'
                    THEN 1 ELSE 0
                END) as libres,

                SUM(CASE
                    WHEN asignacionlibrecustodia = 'CUSTODIA'
                    THEN 1 ELSE 0
                END) as custodia
            ")
            ->first();

        $lista_personas = Persona::join('personales','personas.id','=','personales.persona_id')
            ->select(
                'personas.*',
                'personales.persona_id',
                'personales.celinstitucional',
                'personales.correoinstitucional',
                'personales.regimen',
                'personales.tipo_regimen',
                'personales.cargo',
                'personales.cargo_condicion',
                'personales.sedeorigen',
                'personales.dependenciaorigen',
                'personales.despachoorigen',
                'personales.sededestino',
                'personales.dependenciadestino',
                'personales.despachodestino',
                'personales.tipo_documento'
            )
            // ->where('personales.tipo_documento','CONTRATO')
            ->where('personales.activo', "1")
            ->where('personas.activo','1')
            ->when($this->searchpersonas !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('personas.dni', 'like', '%' . $this->searchpersonas . '%')
                    ->orWhere('personas.datos', 'like', '%' . $this->searchpersonas . '%');
                });
            })
            ->orderBy('personas.datos')
            ->paginate(10,['*'],'personasPage');

        $lista_sedes = Personales_sede::select('id','nombre','nombred')
            ->where('activo','1')
            ->where('nombre','like','%' . $this->searchsedes . '%')
            ->distinct()
            ->orderBy('nombre')
            ->paginate(15,['*'], 'sedesPage');
            
        $lista_dependencias = Personales_dependencia::select('id','nombre')
            ->where('activo','1')
            ->where('sede_id',$this->codsededestino)
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

        $lista_informaticos = User::select('dni','datos','cargo')
            ->where('activo','1')
            ->where('cargo','INFORMATICO')
            ->orderBy('datos')
            ->get();

        return view('livewire.informatica.anexos.anexosasignacion-component',
                    compact('lista_activos','lista_historial','estadisticas',
                            'lista_personas','lista_sedes','lista_dependencias','lista_despachos','lista_cargos','lista_informaticos'));
    }

    // ============================================================================================================================
    // REGLAS DE VALIDACIÓN
    // ============================================================================================================================

    protected function rules(){
        return [
            'dni' => 'required',
        ];
    }

    protected $messages = [
        'dni.required' => 'El DNI es obligatorio',
    ];

    // ============================================================================================================================
    // FUNCIONES CRUD
    // ============================================================================================================================

    public function nuevo(InformaticasBienesAnexosAsignaciones $instanciaTabla = null, $vAsignacionlibrecustodia = null)
    {
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // Restablecer todas las variables
        $this->resetExcept(['filtro_anio', 'filtro_mes']);

        $this->foto = null;
        $this->fotoactual = null;
        $this->inputFileKey = rand();

        $this->funcionGuardarActualizar="guardar";

        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "NUEVO";
        $this->colorGuardarActualizar = "primary";
        $this->textoGuardarActualizar = "Guardar";
        $this->colorAgregar = "outline-primary";

        if ($instanciaTabla) {
            
            if ($vAsignacionlibrecustodia === 'DEVOLUCION') {
                // BLOQUEAMOS LAS SECCIONES
                $this->seccionFoto = "disabled";
                $this->seccionPersona = "disabled";
                $this->seccionPersonal    = "disabled";
                $this->seccionDetalle = "disabled";

                // DATOS DE LA PERSONA
                $this->persona_id = $instanciaTabla->persona_id;
                $this->dni = $instanciaTabla->dni;
                $this->appaterno = $instanciaTabla->appaterno;
                $this->apmaterno = $instanciaTabla->apmaterno;
                $this->nombres = $instanciaTabla->nombres;
                $this->datos = $instanciaTabla->datos;
                $this->celpersonal = $instanciaTabla->celpersonal;
                $this->celinstitucional = $instanciaTabla->celinstitucional;
                $this->correopersonal = $instanciaTabla->correopersonal;
                $this->correoinstitucional = $instanciaTabla->correoinstitucional;

                // DATOS DEL PERSONAL
                $this->personal_id = $instanciaTabla->personal_id;

                $this->codsedeorigen = $instanciaTabla->codsededestino;
                $this->sedeorigen = $instanciaTabla->sededestino;
                $this->coddependenciaorigen= $instanciaTabla->coddependenciadestino;
                $this->dependenciaorigen = $instanciaTabla->dependenciadestino;
                $this->coddespachoorigen = $instanciaTabla->coddespachodestino;
                $this->despachoorigen = $instanciaTabla->despachodestino;

                $this->codsededestino = $instanciaTabla->codsededestino;
                $this->sededestino = $instanciaTabla->sededestino;
                $this->coddependenciadestino= $instanciaTabla->coddependenciadestino;
                $this->dependenciadestino = $instanciaTabla->dependenciadestino;
                $this->coddespachodestino = $instanciaTabla->coddespachodestino;
                $this->despachodestino = $instanciaTabla->despachodestino;

                $this->regimen = $instanciaTabla->regimen;
                $this->tipo_regimen = $instanciaTabla->tipo_regimen;
                $this->cargo = $instanciaTabla->cargo;
                $this->cargo_condicion = $instanciaTabla->cargo_condicion;

                // DATOS DEL REGISTRO
                $this->anexoasignado_id = $instanciaTabla->id;
                $this->anexo_id = $instanciaTabla->anexo_id;
                $this->serie = $instanciaTabla->serie;
                $this->tipo = $instanciaTabla->tipo;
                $this->modelo = $instanciaTabla->modelo;
                $this->anexo = $instanciaTabla->anexo;
                $this->marca = $instanciaTabla->marca;
                $this->transformador = $instanciaTabla->transformador;
                $this->auriculares = $instanciaTabla->auriculares;
                $this->baseauriculares = $instanciaTabla->baseauriculares;
                $this->estado = $instanciaTabla->estado;
                $this->asignacionlibrecustodia = $vAsignacionlibrecustodia;
            } elseif ($vAsignacionlibrecustodia === 'REASIGNACION'){
                // DATOS DEL REGISTRO
                $this->anexoasignado_id = $instanciaTabla->id;
                $this->anexo_id = $instanciaTabla->anexo_id;
                $this->serie = $instanciaTabla->serie;
                $this->tipo = $instanciaTabla->tipo;
                $this->modelo = $instanciaTabla->modelo;
                $this->anexo = $instanciaTabla->anexo;
                $this->marca = $instanciaTabla->marca;
                $this->transformador = $instanciaTabla->transformador;
                $this->auriculares = $instanciaTabla->auriculares;
                $this->baseauriculares = $instanciaTabla->baseauriculares;
                $this->estado = $instanciaTabla->estado;
                $this->asignacionlibrecustodia = $vAsignacionlibrecustodia;

                $this->seccionFoto = "";
                $this->seccionPersona = "";
                $this->seccionPersonal    = "";
                $this->seccionDetalle = "disabled";
            } else{
                $this->seccionFoto = "";
                $this->seccionPersona = "";
                $this->seccionPersonal    = "";
                $this->seccionDetalle = "";
            }

            // $this->estado = $instanciaTabla->estado;

            // $this->activo = $instanciaTabla->activo;
            $this->created_user_cargo = $instanciaTabla->created_user_cargo;
            $this->created_user = $instanciaTabla->created_user;
            $this->updated_user = $instanciaTabla->updated_user;
        }     

        // ABRIR MODAL NUEVO - EDITAR
        $this->modalNuevoEditarAbrir = true;
    }

    public function guardar()
    {
        try
        {
            $registro = null;
            $registro2 = null;

            // BUSCAR SI EL ANEXO YA EXISTE
            $registro = InformaticasBienesAnexos::where('anexo', $this->anexo)->first();

            // VALIDAR SI EL ANEXO YA ESTÁ ASIGNADO
            if ( $registro && $this->asignacionlibrecustodia === 'ASIGNACION') {

                $existeAsignacion = InformaticasBienesAnexosAsignaciones::where('anexo_id', $registro->id)
                    ->where('activo', 1)
                    ->exists();

                if ($existeAsignacion) {

                    $this->dispatch(
                        'alerta-actualizado',
                        titulo: 'No se pudo guardar',
                        mensaje: 'El anexo ya se encuentra asignado.',
                        tipo: 'warning',
                    );

                    return;
                }
            }

            DB::transaction(function () use (&$registro, &$registro2) {

                $usuario_id = auth()->user()->id;
                $usuario_dni = auth()->user()->dni;
                $usuario_datos = auth()->user()->datos;
                $usuario_cargo = auth()->user()->cargo;

                // OBTENEMOS LOS DATOS DEL INFORMATICO SELECCIONADO PARA FIRMAR EL ACTA
                $iinformatico = User::select('datos')
                    ->where('dni', $this->informatico_dni)
                    ->first();

                // SOLO CREAR SI EL ANEXO NO EXISTE
                $registro = InformaticasBienesAnexos::firstOrCreate(
                    [
                        'anexo' => $this->anexo, // Campo que identifica si ya existe
                    ],
                    [
                        'serie' => $this->serie,
                        'tipo' => $this->tipo,
                        'modelo' => $this->modelo,
                        'marca' => $this->marca,
                        'transformador' => $this->transformador,
                        'auriculares' => $this->auriculares,
                        'baseauriculares' => $this->baseauriculares,
                        'asignacionlibrecustodia' => $this->asignacionlibrecustodia,
                        'observacion' => $this->observacion,
                        'estado' => $this->estado,
                        'activo' => '1',
                        'created_user_cargo' => $usuario_cargo,
                        'created_user' => $usuario_datos,
                        'updated_user' => $usuario_datos,
                    ]
                );

                // ACTUALIZAR EL REGISTRO ANTERIOR EN CASO SEA UNA ASIGANCION, DEVOLUCION O CUSTODIA
                if (!empty($this->anexoasignado_id)){
                    $iInformaticaBienesAnexoAsignado = InformaticasBienesAnexosAsignaciones::findOrFail($this->anexoasignado_id);

                    $iInformaticaBienesAnexoAsignado->update([
                        'activo' => "0",
                    ]);
                }

                // CREAR REGISTRO EN TABLA
                $registro2 = InformaticasBienesAnexosAsignaciones::create([
                    // DATOS DE LA PERSONA
                    'persona_id' => $this->persona_id,
                    'dni' => $this->dni,
                    'appaterno' => $this->appaterno,
                    'apmaterno' => $this->apmaterno,
                    'nombres' => $this->nombres,                   
                    'datos' => $this->datos,
                    'celpersonal' => $this->celpersonal,
                    'celinstitucional' => $this->celinstitucional,
                    'correopersonal' => $this->correopersonal,
                    'correoinstitucional' => $this->correoinstitucional,

                    // DATOS DEL PERSONAL 
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

                    'regimen' => $this->regimen,
                    'tipo_regimen' => $this->tipo_regimen,
                    'cargo' => $this->cargo,
                    'cargo_condicion' => $this->cargo_condicion,

                    // DATOS DEl ANEXO
                    'anexo_id' => $registro->id,
                    'serie' => $this->serie,
                    'tipo' => $this->tipo,
                    'modelo' => $this->modelo,
                    'anexo' => $this->anexo,
                    'marca' => $this->marca,
                    'transformador' => $this->transformador,
                    'auriculares' => $this->auriculares,
                    'baseauriculares' => $this->baseauriculares,
                    'motivo' => $this->motivo,
                    'asignacionlibrecustodia' => $this->asignacionlibrecustodia,
                    'asignacionlibrecustodiadesde' => $this->asignacionlibrecustodiadesde,
                    'asignacionlibrecustodiahasta' => $this->asignacionlibrecustodiahasta,
                    'observacion' => $this->observacion,
                    'estado' => $this->estado,

                    'informatico_dni' => $this->informatico_dni,
                    'informatico' => $iinformatico->datos ?? null,
                    'activo' => '1',
                    'created_user_cargo' => $usuario_cargo,
                    'created_user' => $usuario_datos,
                    'updated_user' => $usuario_datos,
                ]);

                // ACTUALIZAMOS ACTIVO DE LA TABLA INFORMATICASBIENESANEXOS
                
                $iInformaticaBienesAnexo = InformaticasBienesAnexos::findOrFail($registro2->anexo_id);

                if ($this->asignacionlibrecustodia === "DEVOLUCION") {
                    $iInformaticaBienesAnexo->update([
                        'activo' => "0",
                    ]);
                } else {
                    $iInformaticaBienesAnexo->update([
                        'activo' => "1",
                    ]);
                }
                
            });

            // CERRAR MODAL NUEVO - EDITAR
            $this->modalNuevoEditarAbrir = false;

            // MENSAJE
            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Proceso completado',
                mensaje: 'Se guardaron los datos correctamente.',
                tipo: 'success',
            );
        }

        catch (\Throwable $e) 
        {
            dd($e); // 🔥 Déjalo mientras pruebas
        }
    }

    public function editar(InformaticasBienesAnexosAsignaciones $instanciaTabla)
    {
        $this->resetValidation();
        $this->resetErrorBag();

        $this->funcionGuardarActualizar = "actualizar";

        // $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "success-subtle";
        $this->textoHeaderModal = "Editar";
        $this->colorGuardarActualizar = "success";
        $this->textoGuardarActualizar = "Actualizar";
        $this->colorAgregar = "outline-success";

        // ===== BLOQUEO DE SECCIONES =====
        $this->seccionFoto = "";
        $this->seccionPersona = "";
        $this->seccionPersonal = "";

        // DATOS DE LA PERSONA
        // $this->atencion_id = $ipersonalatencion->id;

        $this->persona_id = $instanciaTabla->persona_id;
        $this->dni = $instanciaTabla->dni;
        $this->appaterno = $instanciaTabla->appaterno;
        $this->apmaterno = $instanciaTabla->apmaterno;
        $this->nombres = $instanciaTabla->nombres;
        $this->datos = $instanciaTabla->datos;
        $this->celpersonal = $instanciaTabla->celpersonal;
        $this->celinstitucional = $instanciaTabla->celinstitucional;
        $this->correopersonal = $instanciaTabla->correopersonal;
        $this->correoinstitucional = $instanciaTabla->correoinstitucional;

        // DATOS DEL PERSONAL
        $this->personal_id = $instanciaTabla->personal_id;

        $this->codsedeorigen = $instanciaTabla->codsededestino;
        $this->sedeorigen = $instanciaTabla->sededestino;
        $this->coddependenciaorigen= $instanciaTabla->coddependenciadestino;
        $this->dependenciaorigen = $instanciaTabla->dependenciadestino;
        $this->coddespachoorigen = $instanciaTabla->coddespachodestino;
        $this->despachoorigen = $instanciaTabla->despachodestino;

        $this->codsededestino = $instanciaTabla->codsededestino;
        $this->sededestino = $instanciaTabla->sededestino;
        $this->coddependenciadestino= $instanciaTabla->coddependenciadestino;
        $this->dependenciadestino = $instanciaTabla->dependenciadestino;
        $this->coddespachodestino = $instanciaTabla->coddespachodestino;
        $this->despachodestino = $instanciaTabla->despachodestino;

        $this->regimen = $instanciaTabla->regimen;
        $this->tipo_regimen = $instanciaTabla->tipo_regimen;
        $this->cargo = $instanciaTabla->cargo;
        $this->cargo_condicion = $instanciaTabla->cargo_condicion;

        // DATOS DEL REGISTRO

        $this->anexoasignado_id = $instanciaTabla->id;
        $this->anexo_id = $instanciaTabla->anexo_id;
        $this->serie = $instanciaTabla->serie;
        $this->tipo = $instanciaTabla->tipo;
        $this->modelo = $instanciaTabla->modelo;
        $this->anexo = $instanciaTabla->anexo;
        $this->marca = $instanciaTabla->marca;
        $this->transformador = $instanciaTabla->trasformador;
        $this->auriculares = $instanciaTabla->auriculares;
        $this->baseauriculares = $instanciaTabla->baseauriculares;
        $this->motivo = $instanciaTabla->motivo;
        $this->asignacionlibrecustodia = $instanciaTabla->asignacionlibrecustodia;
        $this->observacion = $instanciaTabla->observacion;
        $this->estado = $instanciaTabla->estado;
        $this->informatico_dni = $instanciaTabla->informatico_dni;
        $this->informatico = $instanciaTabla->informatico;
        $this->activo = $instanciaTabla->activo;
        $this->created_user_cargo = $instanciaTabla->created_user_cargo;
        $this->created_user = $instanciaTabla->created_user;
        $this->updated_user = $instanciaTabla->updated_user;

        // ABRIR MODAL NUEVO - EDITAR
        $this->modalNuevoEditarAbrir = true;
        
    }

    public function cerrar()
    {
        $this->modalNuevoEditarAbrir = false;
        $this->modalPDFCargar = false;
        $this->modalPDFEvidenciaCargar = false;

        $this->dispatch(
                'alerta-cancelar',
                titulo: 'Cancelar',
                mensaje: 'Se canceló la operación.',
                tipo: 'error'
            );
    }

    public function historial( $anexoAsignadoId)
    {
        $this->anexo_id = $anexoAsignadoId;

        $this->colorHeaderModal = "info-subtle";
        $this->textoHeaderModal = "NUEVO";
        $this->colorGuardarActualizar = "info";
        $this->textoGuardarActualizar = "Guardar";
        $this->colorAgregar = "outline-info";

         // ABRIR MODAL HISTORIAL
        $this->modalHistorial = true;
    }

    public function historial_cerrar()
    {
        $this->modalHistorial = false;
    }

    // ============================================================================================================================
    // MODALES CARGAR PDF
    // ============================================================================================================================

    public function editar_pdf($anexoAsignadoId)
    {
        $this->anexoasignado_id = $anexoAsignadoId;

        $this->pdf_acta = null; // 🔥 CLAVE

        // ABRIR MODAL CARGAR PDF
        $this->modalPDFCargar = true;
    }
    
    public function actualizar_pdf()
    {
        // ===== DATOS DE LA INSTANCIA =====
        $iAnexoAsignado = InformaticasBienesAnexosAsignaciones::where('id', $this->anexoasignado_id)->firstOrFail();

        $this->anexo = $iAnexoAsignado->token_codigo;
        $this->asignacionlibrecustodia = $iAnexoAsignado->asignacionlibrecustodia;
        
        // ===== VALIDAR SOLOR PDF =====
        $this->validate([
            'pdf_acta' => 'required|file|mimes:pdf|max:5120'
        ]);


        // ===== CARGAR PDF =====
        try {

            DB::transaction(function () use ($iAnexoAsignado) {

                $usuario_id = auth()->user()->id;
                $usuario_dni = auth()->user()->dni;
                $usuario_datos = auth()->user()->datos;
                $usuario_cargo = auth()->user()->cargo;

                // UTILIZAR UNA FUNCIÓN PRIVADA PARA VERIFICAR SI EXISTE YA UN ARCHIVO Y ASIGNARLE EL MISMO NOMBRE
                $rutaDocumento = $this->validarActa();

                // ACTUALIZAR
                $iAnexoAsignado->update([
                    'ruta_documento' => $rutaDocumento,
                    'updated_user' => $usuario_datos,
                ]);

            });

            $this->reset('pdf_acta');

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Documento cargado',
                mensaje: 'El PDF se cargó correctamente.',
                tipo: 'success'
            );

            // CERRAR MODAL CARGAR PDF
            $this->modalPDFCargar = false;

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

    public function editarEvidencia()
    {
        
    }

    public function actualizarEvidencia()
    {
        
    }

    private function validarActa()
    {
        $iAnexoAsignado = InformaticasBienesAnexosAsignaciones::findOrFail($this->anexoasignado_id);

        if (empty($iAnexoAsignado->ruta_documento)) {

            $nombreArchivo = 'acta_' . $iAnexoAsignado->id . '_' .
                            $iAnexoAsignado->anexo . '_' .
                            $iAnexoAsignado->dni . '.pdf';

            return $this->pdf_acta->storeAs(
                'informatica/anexos/actas',
                $nombreArchivo,
                'public'
            );
        }

        return $this->pdf_acta->storeAs(
            dirname($iAnexoAsignado->ruta_documento),
            basename($iAnexoAsignado->ruta_documento),
            'public'
        );
    }

    // ============================================================================================================================
    // MODALES BUSCAR
    // ============================================================================================================================

    public function personalBuscar()
    {
        $this->modalPersonalBuscar = true;

        $this->dispatch('focus-input', id: 'txtSearchPersonal');
    }
    public function sedeBuscar()
    {
        $this->modalPersonalSedeBuscar = true;

        $this->dispatch('focus-input', id: 'txtSearchSede');
    }
    public function dependenciaBuscar()
    {
        $this->modalPersonalDependenciaBuscar = true;

        $this->dispatch('focus-input', id: 'txtSearchDependencia');
    }
    public function despachoBuscar()
    {
        $this->modalPersonalDespachoBuscar = true;

        $this->dispatch('focus-input', id: 'txtSearchDespacho');
    }
    public function cargoBuscar()
    {
        $this->modalPersonalCargoBuscar = true;

        $this->dispatch('focus-input', id: 'txtSearchCargo');
    }
    public function cerrarBuscar()
    {
        $this->modalReportesFiltros = false;

        $this->modalPersonalBuscar = false;
        $this->modalPersonalSedeBuscar = false;
        $this->modalPersonalDependenciaBuscar = false;
        $this->modalPersonalDespachoBuscar = false;
        $this->modalPersonalCargoBuscar = false;
        $this->modalInformaticaServicioBuscar = false;
        $this->modalInformaticaServicioDetalleBuscar = false;
        $this->modalPatrimonioBienesBuscar = false;
    } 

    // FUNCIONES AGREGAR
    // ============================================================================================================================
    public function agregar_persona(Persona $ipersona){
        // DATOS DE LA PERSONA
        $this->persona_id = $ipersona->id;
        $this->dni = $ipersona->dni;
        $this->appaterno = $ipersona->appaterno;
        $this->apmaterno = $ipersona->apmaterno;
        $this->nombres = $ipersona->nombres;
        $this->datos = $ipersona->datos;
        $this->celpersonal = $ipersona->celpersonal;
        $this->correopersonal = $ipersona->correopersonal;
        $this->fotoactual = $ipersona->foto;

        // DATOS DEL PERSONAL
        $ipersonal = Personale::where([['persona_dni',$this->dni],['activo',1],])->firstOrFail();

        $this->personal_id = $ipersonal->id;

        $this->codsedeorigen = $ipersonal->codsedeorigen;
        $this->sedeorigen = $ipersonal->sededestino;   
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
        $this->cargo_condicion = $ipersonal->cargo_condicion;
        $this->tipo_documento = $ipersonal->tipo_documento;

        // RESTABLECER VARIABLES DE BUSQUEDA
        $this->reset([
            'searchpersonas',
            'searchsedes',
            'searchdependencias',
            'searchdespachos',
            'searchcargos',
            'searchservicios',
            'searchincidenciasolicitud',
            'searchbienes',
        ]);

        // CERRAR MODAL
        $this->modalPersonalBuscar = false;
    }

    public function agregar_sede(Personales_sede $isede)
    {
        $this->codsedeorigen = $isede->id;
        $this->sedeorigen = $isede->nombre;

        $this->codsededestino = $isede->id;
        $this->sededestino = $isede->nombre;

        // RESTABLECER DEPENDENCIA Y DESPACHO
        $this->reset([
            'dependenciaorigen',
            'despachoorigen',
        ]);

        // RESTABLECER VARIABLES DE BUSQUEDA
        $this->reset([
            'searchpersonas',
            'searchsedes',
            'searchdependencias',
            'searchdespachos',
            'searchcargos',
            'searchservicios',
            'searchincidenciasolicitud',
            'searchbienes',
        ]);

        // CERRAR MODAL
        $this->modalPersonalSedeBuscar = false;
    }

    public function agregar_dependencia(Personales_dependencia $idependencia)
    {
        $this->coddependenciaorigen = $idependencia->id;
        $this->dependenciaorigen = $idependencia->nombre;

        $this->coddependenciadestino = $idependencia->id;
        $this->dependenciadestino = $idependencia->nombre;

        // RESTABLECER VARIABLES DE BUSQUEDA
        $this->reset([
            'searchpersonas',
            'searchsedes',
            'searchdependencias',
            'searchdespachos',
            'searchcargos',
            'searchservicios',
            'searchincidenciasolicitud',
            'searchbienes',
        ]);

        // CERRAR MODAL
        $this->modalPersonalDependenciaBuscar = false;
    }

    public function agregar_despacho(Personales_despacho $idespacho)
    {
        $this->coddespachoorigen = $idespacho->id;
        $this->despachoorigen = $idespacho->nombre;

        $this->coddespachodestino = $idespacho->id;
        $this->despachodestino = $idespacho->nombre;

        // RESTABLECER VARIABLES DE BUSQUEDA
        $this->reset([
            'searchpersonas',
            'searchsedes',
            'searchdependencias',
            'searchdespachos',
            'searchcargos',
            'searchservicios',
            'searchincidenciasolicitud',
            'searchbienes',
        ]);

        // CERRAR MODAL
        $this->modalPersonalDespachoBuscar = false;
    }

    public function agregar_cargo(Personales_cargo $icargo)
    {
        $this->cargo = $icargo->nombre;

        // RETABLECER SERVICIO DETALLE
        
        // RESTABLECER VARIABLES DE BUSQUEDA
        $this->reset([
            'searchpersonas',
            'searchsedes',
            'searchdependencias',
            'searchdespachos',
            'searchcargos',
            'searchservicios',
            'searchincidenciasolicitud',
            'searchbienes',
        ]);

        // CERRAR MODAL
        $this->modalPersonalCargoBuscar = false;
    }
}
