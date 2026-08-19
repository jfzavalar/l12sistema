<?php

namespace App\Livewire\Intranet\Atenciones;

use App\Exports\TicketsfiltrosExport;
use App\Mail\NotificacionInformaticaTicket;
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

class Activos extends Component
{
    // protected $listeners = ['usuarioActivado' => '$refresh'];


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

    // VARIABLES PARA ADMINISTRAR MODALES
    public $colorHeaderModal, $textoHeaderModal;
    public $colorNuevoEditar, $textoNuevoEditar;
    public $colorGuardarActualizar, $textoGuardarActualizar;
    public $colorAgregar;


    //VARIABLES PARA OCULTAR Y MOSTRAR TXT_OTROS
    public $mostrarcontroles = "d-none",$mostrarcontrolgpli="d-none";
    public $mostrarotrosp = "d-none", $mostrarotrosc = "d-none",$mostrarcargafoto = "d-none";

    //VARIABLES PARA BLOQUEAR SECCIONES
    public $seccionFoto, $seccionPersona, $seccionPersonal;

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

    public $filtro_atendido,$filtro_enviadolima,$filtro_atendidou;

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
            $tipo_documento;

    public $atencion_id,
            $reportado_por,
            $solicitud_incidencia,
            $servicio_id,
            $servicio,
            $detalle_servicio_id,
            $detalle_servicio,
            $cea,
            $sgf,
            $glpi,
            $enviado_lima = "NO",
            $detalle_problema,
            $captura_evidencia,
            $ncopias,
            $obs_usuario,
            $obs_informatico,
            $estado_bien = "OPERATIVO",
            $atendido = "SI",
            $atendido_por_id,
            $atendido_por_dni,
            $atendido_por_datos,
            $tiempo_atencion = "NORMAL",
            $respuesta,
            $conformidad,
            $ruta_evidencia,
            $ruta_documento,
            $informatico_dni,
            $informatico,
            $formato1,
            $formato2,
            $formato3,
            $formato4,
            $created_user_cargo;

    Public $bien_id,
            $cod,
            $cod_patrimonial,
            $bien,
            $marca,
            $modelo,
            $serie,
            $medida,
            $medidas,
            $color,
            $estado,
            $clase,
            $familia,
            $bien_ip_anterior,
            $bien_ip,
            $datos_bien;

    public $pdf_acta;

    public $bandera_documento="EVIDENCIA";

    public function updatedEnviadoLima($value)
    {
        if ($value === "SI") {
            $this->atendido = "NO";
            $this->mostrarcontrolgpli = "";
        } else {
            $this->atendido = "SI";
            $this->mostrarcontrolgpli = "d-none";
        }       
    }

    public function updatedInformatico($value)
    {
        if ($value) {
            $data = json_decode($value, true);

            $this->informatico_dni = $data['dni'];
            $this->informatico     = $data['datos'];
        } else {
            $this->informatico_dni = null;
            $this->informatico     = null;
        }
    }

    public $filtro_anio,
            $filtro_mes,
            $filtroinformatico,
            $filtro_sede,
            $filtro_dependencia,
            $filtro_servicio,
            $filtro_incidencia;

    public function mount()
    {
        $this->filtro_anio = date('Y');
        $this->filtro_mes = date('n'); // 🔥 mes actual sin cero (1-12)
    }

    
    public function filtrarTotal($value = null)
    {
        $this->resetFiltros();
        $this->filtroinformatico = $value ? trim($value) : null;
    }
    public function filtrarAtendido($value = null)
    {
        $this->resetFiltros();
        $this->filtro_atendido = 'SI';
        $this->filtroinformatico = $value ? trim($value) : null;
    }
    public function filtrarNoatendido($value = null)
    {
        $this->resetFiltros();
        $this->filtro_atendido = 'NO';
        $this->filtroinformatico = $value ? trim($value) : null;
    }
    public function filtrarEnviadolima($value = null)
    {
        $this->resetFiltros();
        $this->filtro_enviadolima = 'SI';
        $this->filtroinformatico = $value ? trim($value) : null;
    }
    public function filtrarRegistrados($value = null)
    {
        $this->resetFiltros();
        $this->filtro_atendido = 'NN';
        $this->filtroinformatico = $value ? trim($value) : null;
    }
    public function resetFiltros()
    {
        $this->search = null;
        $this->filtro_atendido = null;
        $this->filtro_enviadolima = null; 
        $this->filtro_atendidou = null;
        $this->filtroinformatico = null;

        $this->filtro_sede = null;
        $this->filtro_dependencia = null;
        $this->filtro_servicio = null;
        $this->filtro_incidencia = null;

        $this->resetPage('atencionesPage');
    }

    public function render()
    {
        $lista_activos = $this->queryConFiltros()

            ->select(
                'personales_atenciones.*'
            )
            ->where('personales_atenciones.activo', 1)
            ->orderBy('personales_atenciones.id', 'desc')
            ->paginate(30,['*'],'atencionesPage'
            );

        $lista_inactivos = $this->queryConFiltros()

            ->select(
                'personales_atenciones.*'
            )
            ->where('personales_atenciones.activo', 0)
            ->orderBy('personales_atenciones.id', 'desc')
            ->paginate(10,['*'],'atencionesinactivosPage'
            );

        $lista_historial= $this->queryConFiltros()

            ->select(
                'personales_atenciones.*'
            )
            ->orderBy('personales_atenciones.id', 'desc')
            ->paginate(
                10,
                ['*'],
                'atencioneshistorialPage'
            );

        $estadisticas = PersonalesAtencione::select('atendido_por_dni','created_user_cargo','created_user')
            ->selectRaw("COUNT(*) as total")
            ->selectRaw("SUM(CASE WHEN atendido = 'SI' THEN 1 ELSE 0 END) as atendidos")
            ->selectRaw("SUM(CASE WHEN atendido = 'NO' THEN 1 ELSE 0 END) as no_atendidos")
            ->selectRaw("SUM(CASE WHEN enviado_lima = 'SI' THEN 1 ELSE 0 END) as enviado_lima")
            ->selectRaw("SUM(COALESCE(ncopias, 0)) as digitalizado")
            // 🔥 FILTRO AÑO
            ->when($this->filtro_anio, function ($q) {
                $q->whereYear('created_at', $this->filtro_anio);
            })

            // 🔥 FILTRO MES
            ->when($this->filtro_mes, function ($q) {
                $q->whereMonth('created_at', $this->filtro_mes);
            })
            ->orderBy('created_user')
            ->groupBy('atendido_por_dni','created_user_cargo','created_user')
            ->get();

        $estadisticas2 = PersonalesAtencione::where('activo', '1')
            ->selectRaw("
                COUNT(*) as total,

                SUM(CASE 
                    WHEN atendido = 'SI' 
                    THEN 1 ELSE 0 
                END) as atendidos,

                SUM(CASE 
                    WHEN atendido = 'NO' 
                    THEN 1 ELSE 0 
                END) as no_atendidos,

                SUM(CASE 
                    WHEN enviado_lima = 'SI' 
                    THEN 1 ELSE 0 
                END) as enviado_lima,

                SUM(CASE 
                    WHEN atendido = 'NN' 
                    THEN 1 ELSE 0 
                END) as registrados
            ")
            // 🔥 FILTRO AÑO
            ->when($this->filtro_anio, function ($q) {
                $q->whereYear('created_at', $this->filtro_anio);
            })

            // 🔥 FILTRO MES
            ->when($this->filtro_mes, function ($q) {
                $q->whereMonth('created_at', $this->filtro_mes);
            })
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

        $lista_servicios = PersonalesAtencionesServicio::select('id','tipo','servicio')
            ->where('activo','1')
            ->where('servicio','like','%' . $this->searchservicios . '%')
            ->orderBy('servicio')
            ->paginate(20,['*'],'serviciosPage');

        $lista_incidencias_solicitudes = PersonalesAtencionesIncidenciasSolicitudes::select('id','servicio','incidencia_solicitud')
            ->where('activo','1')
            ->where('servicio_id',$this->servicio_id)
            ->where('incidencia_solicitud','like','%' . $this->searchincidenciasolicitud . '%')
            ->orderBy('incidencia_solicitud')
            ->paginate(20,['*'],'incidenciasolicitudPage');

        $lista_bienes = PatrimoniosBiene::where('activo','1')
            ->where('codigo_patrimonial','like','%' . $this->searchbienes . '%')
            ->distinct()
            ->orderBy('descripcion')
            ->paginate(10,['*'],'bienesPage');

        $lista_informaticos = User::select('dni','datos','cargo')
            ->where('activo','1')
            ->where('cargo','INFORMATICO')
            ->orderBy('datos')
            ->get();

        $lista_sedes_filtro = Personales_sede::select('id','nombre','nombred')
            ->where('activo','1')
            ->orderBy('nombre')
            ->get();
            
        $lista_dependencias_filtro = Personales_dependencia::select('id','nombre')
            ->where('activo','1')
            ->where('sede','=',$this->filtro_sede)
            ->orderBy('nombre')
            ->get();

        $lista_servicios_filtro = PersonalesAtencionesServicio::select('id','tipo','servicio')
            ->where('activo','1')
            ->orderBy('servicio')
            ->get();

        $lista_incidencias_solicitudes_filtro = PersonalesAtencionesIncidenciasSolicitudes::select('id','servicio','incidencia_solicitud')
            ->where('activo','1')
            ->where('servicio',$this->filtro_servicio)
            ->orderBy('incidencia_solicitud')
            ->get();

        return view('livewire.intranet.atenciones.activos',
                compact('lista_activos','lista_inactivos','estadisticas','estadisticas2','lista_historial',
                            'lista_personas','lista_sedes','lista_dependencias','lista_despachos','lista_cargos',
                            'lista_servicios','lista_incidencias_solicitudes','lista_bienes',
                            'lista_informaticos',
                            'lista_sedes_filtro','lista_dependencias_filtro',
                            'lista_servicios_filtro','lista_incidencias_solicitudes_filtro'));
    }

    private function queryConFiltros()
    {
        return PersonalesAtencione::query()

            // BUSCADOR
            ->when($this->search, function ($query) {

                $search = trim($this->search);

                $query->where(function ($q) use ($search) {

                    $q->where('personales_atenciones.dni', 'like', '%' . $search . '%')
                    ->orWhere('personales_atenciones.datos', 'like', '%' . $search . '%');

                });

            })
            // FILTRO ATENDIDO
            ->when($this->filtro_atendido, function ($q) {

                $q->where(
                    'personales_atenciones.atendido',
                    $this->filtro_atendido
                );

            })
            // FILTRO ENVIADO LIMA
            ->when($this->filtro_enviadolima, function ($q) {

                $q->where(
                    'personales_atenciones.enviado_lima',
                    $this->filtro_enviadolima
                );

            })
            // FILTRO ATENDIDO USUARIO
            ->when($this->filtro_atendidou, function ($q) {

                $q->where(
                    'personales_atenciones.atendido',
                    $this->filtro_atendidou
                );

            })
            // FILTRO INFORMÁTICO
            ->when($this->filtroinformatico, function ($q) {

                $q->where(
                    'personales_atenciones.updated_user',
                    trim($this->filtroinformatico)
                );

            })
            // FILTRO AÑO
            ->when($this->filtro_anio, function ($q) {

                $q->whereYear(
                    'personales_atenciones.created_at',
                    $this->filtro_anio
                );

            })
            // FILTRO MES
            ->when($this->filtro_mes, function ($q) {

                $q->whereMonth(
                    'personales_atenciones.created_at',
                    $this->filtro_mes
                );

            })
            // FILTRO SEDE
            ->when($this->filtro_sede, function ($q) {

                $q->where(
                    'sededestino',
                    $this->filtro_sede
                );

            })
            // FILTRO DEPENDENCIA
            ->when($this->filtro_dependencia, function ($q) {

                $q->where(
                    'dependenciadestino',
                    $this->filtro_dependencia
                );

            })
            // FILTRO SERVICIO
            ->when($this->filtro_servicio, function ($q) {

                $q->where(
                    'servicio',
                    $this->filtro_servicio
                );

            })
            // FILTRO SERVICIO
            ->when($this->filtro_incidencia, function ($q) {

                $q->where(
                    'detalle_servicio',
                    $this->filtro_incidencia
                );

            })
            // ORDEN
            ->orderByDesc('personales_atenciones.created_at');
    }

    protected function rules(){
        return [
            'dni' => 'required',
            'servicio' => 'required',
            'detalle_servicio' => 'required'
        ];
    }

    protected $messages = [
        'dni.required' => 'El DNI es obligatorio',
        'servicio.required' => 'El Servicio es obligatorio',
        'detalle_servicio.required' => 'El Servicio es obligatorio',
    ];

    public function nuevo()
    {
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // Restablecer todas las variables
        $this->resetExcept(['filtro_anio', 'filtro_mes']);

        $this->foto = null;
        $this->fotoactual = null;
        $this->inputFileKey = rand();

        $this->funcionGuardarActualizar="guardar";

        // $this->mostrarBtnBuscarDni = "d-none";
        $this->mostrarcontroles = "d-none";

        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "NUEVO";
        $this->colorGuardarActualizar = "primary";
        $this->textoGuardarActualizar = "Guardar";
        $this->colorAgregar = "outline-primary";

        $this->tipo_documento = "CONTRATO";

        // CAMBIAR EL VALOR DE LA BANDERA PARA PODER CARGAR EVIDENCIAS PDF
        $this->bandera_documento = "EVIDENCIA";

        // ABRIR MODAL NUEVO - EDITAR
        $this->modalNuevoEditarAbrir = true;
    }

    public function guardar()
    {
        $this->validate();
        
        try {
            $registro = null;

            // Limpiamos la IP de espacios accidentales
            $ip = trim($this->bien_ip);

            // Validar únicamente si hay una IP escrita
            if (!empty($ip) && in_array((int) $this->servicio_id, [9, 11], true)) {
                
                // Si estás editando, ignoramos el ID del bien actual para que no choque consigo mismo
                $existeIp = PatrimoniosBiene::where('ip', $ip)
                    ->when($this->bien_id, function ($query) {
                        $query->where('id', '!=', $this->bien_id);
                    })
                    ->exists();

                if ($existeIp) {
                    $this->dispatch(
                        'alerta-actualizado',
                        titulo: 'Duplicado',
                        mensaje: 'La IP ya está registrada.',
                        tipo: 'warning'
                    );

                    return;
                }
            }

            DB::transaction(function () use (&$registro) {

                $usuario_id = auth()->user()->id;
                $usuario_dni = auth()->user()->dni;
                $usuario_datos = auth()->user()->datos;
                $usuario_cargo = auth()->user()->cargo;

                // GUARDAR DOCUMENTO
                $ruta_evidencia = $this->guardar_acta();

                // OBTENEMOS LOS DATOS DEL INFORMATICO SELECCIONADO PARA FIRMAR EL ACTA
                $iinformatico = User::select('datos')
                    ->where('dni', $this->informatico_dni)
                    ->first();

                // CREAR REGISTRO EN TABLA
                $registro = PersonalesAtencione::create([
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

                    //DATOS DE LA ATENCIÓN
                    'tipo_documento' => $this->tipo_documento,
                    'reportado_por' => $this->reportado_por,
                    'solicitud_incidencia' => $this->solicitud_incidencia,
                    'servicio' => $this->servicio,
                    'detalle_servicio' => $this->detalle_servicio,
                    'bien_id' => $this->bien_id,
                    'cod' => $this->cod,
                    'cod_patrimonial' => $this->cod_patrimonial,
                    'datos_bien' => $this->datos_bien,
                    'ip' => $this->bien_ip,
                    'cea' => $this->cea,
                    'sgf' => $this->sgf,
                    'glpi' => $this->glpi,
                    'enviado_lima' => $this->enviado_lima,
                    'detalle_problema' => $this->detalle_problema,
                    'ncopias' => $this->ncopias,
                    'obs_usuario' => $this->obs_usuario,
                    'obs_informatico' => $this->obs_informatico,
                    'estado' => $this->estado,
                    'atendido' => $this->atendido,
                    'atendido_por_id' => $usuario_id,
                    'atendido_por_dni' => $usuario_dni,
                    'atendido_por_datos' => $usuario_datos,
                    'tiempo_atencion' => $this->tiempo_atencion,
                    'respuesta' => $this->respuesta,
                    'conformidad' => $this->conformidad,
                    'ruta_evidencia' => $ruta_evidencia,
                    // 'ruta_documento' => $this->ruta_documento,
                    'informatico_dni' => $this->informatico_dni,
                    'informatico' => $iinformatico->datos ?? null,
                    'activo' => '1',
                    'created_user_cargo' => $usuario_cargo,
                    'created_user' => $usuario_datos,
                    'updated_user' => $usuario_datos,
                ]);

                if ($this->bien_id) {

                    $ibien = PatrimoniosBiene::where('id', $this->bien_id)
                        ->where('activo', '1')
                        ->first();

                    if ($ibien) {
                        $ibien->update([
                            'ip' => $this->bien_ip,
                            'updated_user' => $usuario_datos,
                        ]);
                    }

                    $iip = InformaticasIp::where('ip', $this->bien_ip)
                        ->where('activo', '1')
                        ->first();

                    if ($iip) {
                        $iip->update([
                            'codigo' => $this->cod,
                            'codigo_patrimonial' => $this->cod_patrimonial,
                            'bien' => $this->datos_bien,
                            'estado' => '1',
                            'updated_user' => $usuario_datos,
                        ]);
                    }

                }

            });

            // ID GENERADO
            $this->atencion_id = $registro->id;

            // 📧 VALIDACIÓN DE CORREO
            // if (empty($this->correoinstitucional)) {
            //     throw new \Exception("El correo institucional está vacío");
            // }

            // if (!filter_var($this->correoinstitucional, FILTER_VALIDATE_EMAIL)) {
            //     throw new \Exception("El correo institucional no es válido");
            // }

            // 📧 ENVÍO DE CORREO
            try {
                if (!in_array($this->detalle_servicio_id, [101, 102])) {
                    // $this->enviar_correo();
                }

                $mensaje = 'Se guardó y se envió el correo correctamente.';
                $tipo = 'success';

            } catch (\Throwable $mailError) {

                // NO ROMPPE EL FLUJO SI FALLA EL CORREO
                report($mailError);

                $mensaje = 'Se guardó correctamente, pero falló el envío del correo.';
                $tipo = 'warning';
            }

            // CERRAR MODAL NUEVO - EDITAR
            $this->modalNuevoEditarAbrir = false;

            // MENSAJE
            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Proceso completado',
                mensaje: $mensaje,
                tipo: $tipo
            );

            // ALERTA DE GUARDADO
            // $this->dispatch('cerrar-modal', id: 'nuevoEditarModal');

        } 
        catch (\Throwable $e) {

            dd($e); // 🔥 Déjalo mientras pruebas

        }
    }

    public function editar(PersonalesAtencione $ipersonalatencion)
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

        // CAMBIAR EL VALOR DE LA BANDERA PARA PODER CARGAR EVIDENCIAS PDF
        $this->bandera_documento = "EVIDENCIA";

        // DATOS DE LA PERSONA
        $this->atencion_id = $ipersonalatencion->id;

        $this->persona_id = $ipersonalatencion->persona_id;
        $this->dni = $ipersonalatencion->dni;
        $this->appaterno = $ipersonalatencion->appaterno;
        $this->apmaterno = $ipersonalatencion->apmaterno;
        $this->nombres = $ipersonalatencion->nombres;
        $this->datos = $ipersonalatencion->datos;
        $this->celpersonal = $ipersonalatencion->celpersonal;
        $this->celinstitucional = $ipersonalatencion->celinstitucional;
        $this->correopersonal = $ipersonalatencion->correopersonal;
        $this->correoinstitucional = $ipersonalatencion->correoinstitucional;

        // DATOS DEL PERSONAL
        $this->personal_id = $ipersonalatencion->personal_id;

        $this->codsedeorigen = $ipersonalatencion->codsededestino;
        $this->sedeorigen = $ipersonalatencion->sededestino;
        $this->coddependenciaorigen= $ipersonalatencion->coddependenciadestino;
        $this->dependenciaorigen = $ipersonalatencion->dependenciadestino;
        $this->coddespachoorigen = $ipersonalatencion->coddespachodestino;
        $this->despachoorigen = $ipersonalatencion->despachodestino;

        $this->codsededestino = $ipersonalatencion->codsededestino;
        $this->sededestino = $ipersonalatencion->sededestino;
        $this->coddependenciadestino= $ipersonalatencion->coddependenciadestino;
        $this->dependenciadestino = $ipersonalatencion->dependenciadestino;
        $this->coddespachodestino = $ipersonalatencion->coddespachodestino;
        $this->despachodestino = $ipersonalatencion->despachodestino;

        $this->regimen = $ipersonalatencion->regimen;
        $this->tipo_regimen = $ipersonalatencion->tipo_regimen;
        $this->cargo = $ipersonalatencion->cargo;
        $this->cargo_condicion = $ipersonalatencion->cargo_condicion;

        // DATOS DE LA ATENCIÓN
        $this->reportado_por = $ipersonalatencion->reportado_por;
        $this->solicitud_incidencia = $ipersonalatencion->solicitud_incidencia;
        $this->servicio = $ipersonalatencion->servicio;
        $this->detalle_servicio = $ipersonalatencion->detalle_servicio;
        $this->bien_id = $ipersonalatencion->bien_id;
        $this->cod = $ipersonalatencion->cod;
        $this->cod_patrimonial = $ipersonalatencion->cod_patrimonial;
        $this->bien_ip_anterior = $ipersonalatencion->ip;
        $this->bien_ip = $ipersonalatencion->ip;
        $this->datos_bien = $ipersonalatencion->datos_bien;
        $this->cea = $ipersonalatencion->cea;
        $this->sgf = $ipersonalatencion->sgf;
        $this->glpi = $ipersonalatencion->glpi;
        $this->enviado_lima = $ipersonalatencion->enviado_lima;
        $this->detalle_problema = $ipersonalatencion->detalle_problema;
        $this->ncopias = $ipersonalatencion->ncopias;
        $this->obs_usuario = $ipersonalatencion->obs_usuario;
        $this->obs_informatico = $ipersonalatencion->obs_informatico;
        $this->estado = $ipersonalatencion->estado;
        $this->atendido = $ipersonalatencion->atendido;
        $this->atendido_por_id = $ipersonalatencion->atendido_por_id;
        $this->atendido_por_dni = $ipersonalatencion->atendido_por_dni;
        $this->atendido_por_datos = $ipersonalatencion->atendido_por_datos;
        $this->tiempo_atencion = $ipersonalatencion->tiempo_atencion;
        $this->respuesta = $ipersonalatencion->respuesta;
        $this->conformidad = $ipersonalatencion->conformidad;
        $this->ruta_evidencia = $ipersonalatencion->ruta_evidencia;
        $this->ruta_documento = $ipersonalatencion->ruta_documento;
        $this->informatico_dni = $ipersonalatencion->informatico_dni;
        $this->informatico = $ipersonalatencion->informatico;
        $this->activo = $ipersonalatencion->activo;
        $this->created_user_cargo = $ipersonalatencion->created_user_cargo;
        $this->created_user = $ipersonalatencion->created_user;
        $this->updated_user = $ipersonalatencion->updated_user;


        if (in_array($this->servicio_id, [9, 11, 19]) || in_array($this->servicio, ["EQUIPO DE COMPUTO", "IMPRESORA-MULTIFUNCIONAL", "SERVIDORES"]))
        {
            $this->mostrarcontroles = "";
        } else {
            $this->mostrarcontroles = "d-none";
        }

        // ABRIR MODAL NUEVO - EDITAR
        $this->modalNuevoEditarAbrir = true;
        
    }

    public function actualizar(){

        $this->validate();

        try {

            if ($this->bien_ip != $this->bien_ip_anterior) {

                $existe = InformaticasIp::where('ip', $this->bien_ip)
                ->where('activo', '1')
                ->where('estado', '1')
                ->exists();

                if ($existe) {

                    $this->dispatch(
                        'alerta-actualizado',
                        titulo: 'Duplicado',
                        mensaje: 'La IP ya está registrada.',
                        tipo: 'warning'
                    );

                    return;
                }
            }

            DB::transaction(function () {

                $usuario_id = auth()->user()->id;
                $usuario_dni = auth()->user()->dni;
                $usuario_datos = auth()->user()->datos;
                $usuario_cargo = auth()->user()->cargo;

                //RETABLECER LOS VALORES DE LOS CAMPOS DE LA TABLA PATRIMONIO E IP
                
                if ($this->bien_ip != $this->bien_ip_anterior) {

                    $ibien = PatrimoniosBiene::where('id', $this->bien_id)
                        ->where('activo', '1')
                        ->first();

                    if ($ibien) {
                        $ibien->update([
                            'ip' => null,
                            'updated_user' => $usuario_datos,
                        ]);
                    }

                    $iip = InformaticasIp::where('ip', $this->bien_ip_anterior)
                        ->where('activo', '1')
                        ->first();

                    if ($iip) {
                        $iip->update([
                            'codigo' => null,
                            'codigo_patrimonial' => null,
                            'bien' => null,
                            'estado' => '0',
                            'updated_user' => $usuario_datos,
                        ]);
                    }

                }

                $ipersonalatencion = PersonalesAtencione::findOrFail($this->atencion_id);
        

                // FUNCIÓN PARA CARGAR DOCUMENTO
                $ruta_evidencia = $this->pdf_acta
                    ? $this->guardar_acta()
                    : $ipersonalatencion->ruta_evidencia;
                

                // OBTENEMOS LOS DATOS DEL INFORMATICO SELECCIONADO PARA FIRMAR EL ACTA
                $iinformatico = User::select('datos')
                    ->where('dni', $this->informatico_dni)
                    ->first();

                $ipersonalatencion->update([
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

                    'codsededestino' => $this->codsedeorigen,
                    'sededestino' => $this->sedeorigen,
                    'coddependenciadestino' => $this->coddependenciaorigen,
                    'dependenciadestino' => $this->dependenciaorigen,
                    'coddespachodestino' => $this->coddespachoorigen,
                    'despachodestino' => $this->despachoorigen,

                    'regimen' => $this->regimen,
                    'tipo_regimen' => $this->tipo_regimen,
                    'cargo' => $this->cargo,
                    'cargo_condicion' => $this->cargo_condicion,

                    //DATOS DE LA ATENCIÓN
                    'tipo_documento' => $this->tipo_documento,
                    'reportado_por' => $this->reportado_por,
                    'solicitud_incidencia' => $this->solicitud_incidencia,
                    'servicio' => $this->servicio,
                    'detalle_servicio' => $this->detalle_servicio,
                    'bien_id' => $this->bien_id,
                    'cod' => $this->cod,
                    'cod_patrimonial' => $this->cod_patrimonial,
                    'datos_bien' => $this->datos_bien,
                    'ip' => $this->bien_ip,
                    'cea' => $this->cea,
                    'sgf' => $this->sgf,
                    'glpi' => $this->glpi,
                    'enviado_lima' => $this->enviado_lima,
                    'detalle_problema' => $this->detalle_problema,
                    'ncopias' => $this->ncopias,
                    'obs_usuario' => $this->obs_usuario,
                    'obs_informatico' => $this->obs_informatico,
                    'estado' => $this->estado,
                    'atendido' => $this->atendido,
                    'atendido_por_id' => $usuario_id,
                    'atendido_por_dni' => $usuario_dni,
                    'atendido_por_datos' => $usuario_datos,
                    'tiempo_atencion' => $this->tiempo_atencion,
                    'respuesta' => $this->respuesta,
                    'conformidad' => $this->conformidad,
                    'ruta_evidencia' => $ruta_evidencia,
                    'ruta_documento' => $this->ruta_documento,
                    'informatico_dni' => $this->informatico_dni,
                    'informatico' => $iinformatico->datos ?? null,
                    'activo' => '1',
                    'created_user_cargo' => $usuario_cargo,
                    'created_user' => $usuario_datos,
                    'updated_user' => $usuario_datos,
                ]);

                if ($this->bien_ip != $this->bien_ip_anterior) {

                    $ibien = PatrimoniosBiene::where('id', $this->bien_id)
                        ->where('activo', '1')
                        ->first();

                    if ($ibien) {
                        $ibien->update([
                            'ip' => $this->bien_ip,
                            'updated_user' => $usuario_datos,
                        ]);
                    }

                    $iip = InformaticasIp::where('ip', $this->bien_ip)
                        ->where('activo', '1')
                        ->first();

                    if ($iip) {
                        $iip->update([
                            'codigo' => $this->cod,
                            'codigo_patrimonial' => $this->cod_patrimonial,
                            'bien' => $this->datos_bien,
                            'estado' => '1',
                            'updated_user' => $usuario_datos,
                        ]);
                    }

                }

            });

            // CERRAR MODAL NUEVO - EDITAR
            $this->modalNuevoEditarAbrir = false;
            $this->modalPDFCargar = false;
            $this->modalPDFEvidenciaCargar = false;
            
            // ALERTA DE ACTUALIZACIÓN
            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Datos actualizados',
                mensaje: 'Los datos se han actualizado correctamente.',
                tipo: 'success'
            );

            $this->dispatch('cerrar-modal', id: 'nuevoEditarModal');

        // } catch (\Throwable $e) {

        //     report($e);

        //     $this->dispatch(
        //         'alerta-actualizado',
        //         titulo: 'Error',
        //         mensaje: 'Ocurrió un error al actualizar.',
        //         tipo: 'error'
        //     );
        // };

        } catch (\Throwable $e) {

            dd($e); // 🔥 Déjalo mientras pruebas

        };
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

    // ============================================================================================================================
    // MODALES REPORTES CON FILTROS
    // ============================================================================================================================

    public function reportesFiltros()
    {
        $this->modalReportesFiltros = true;
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
    public function servicioBuscar()
    {
        $this->modalInformaticaServicioBuscar = true;

        $this->dispatch('focus-input', id: 'txtSearchServicio');
    }
    public function servicioDetalleBuscar()
    {
        $this->modalInformaticaServicioDetalleBuscar = true;

        $this->dispatch('focus-input', id: 'txtSearchServicioDetalle');
    }
    public function bienesBuscar()
    {
        $this->modalPatrimonioBienesBuscar = true;

        $this->dispatch('focus-input', id: 'txtSearchBienes');
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

    // ============================================================================================================================
    // FUNCIONES PARA CARGAR PDF
    // ============================================================================================================================

    public function editar_pdf($atencion_id)
    {
        $this->atencion_id = $atencion_id;

        $this->pdf_acta = null; // 🔥 CLAVE
        
        
        // CAMBIAR EL VALOR DE LA BANDERA PARA PODER CARGAR ACTA PDF
        $this->bandera_documento = "ACTA";

        // ABRIR MODAL CARGAR PDF
        $this->modalPDFCargar = true;
    }

    public function actualizar_pdf()
    {
        // ===== DATOS PERSONAL =====
        $iatencion = PersonalesAtencione::where('id', $this->atencion_id)->firstOrFail();

        $this->dni = $iatencion->dni;
        // $this->cod_patrimonial = $isoporte->bien_cod_patrimonial;
        
        // Validar solo el PDF
        $this->validate([
            'pdf_acta' => 'required|file|mimes:pdf|max:5120'
        ]);

        try {

            DB::transaction(function () use ($iatencion) {

                $usuario = auth()->user()->datos;

                // Ruta actual
                $rutaDocumento = $this->actualizar_acta();

                $iatencion->update([
                    'ruta_documento' => $rutaDocumento,
                    'updated_user' => $usuario,
                ]);

            });

            $this->reset('pdf_acta');

            // CERRAR EL MODAL
            $this->modalPDFCargar = false;

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Documento cargado',
                mensaje: 'El PDF se cargó correctamente.',
                tipo: 'success'
            );

        }
        catch (\Throwable $e) {

            report($e);

            $this->pdf_acta = null;

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Error',
                mensaje: 'Ocurrió un error al cargar el PDF.',
                tipo: 'error'
            );
        }
    }

    // ============================================================================================================================
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

        $this->codsedeorigen = $ipersonal->codsededestino;
        $this->sedeorigen = $ipersonal->sededestino;   
        $this->coddependenciaorigen = $ipersonal->coddependenciadestino;
        $this->dependenciaorigen = $ipersonal->dependenciadestino;
        $this->coddespachoorigen = $ipersonal->coddespachodestino;
        $this->despachoorigen = $ipersonal->despachodestino;

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

    public function agregar_servicio(PersonalesAtencionesServicio $iservicio)
    {
        $this->servicio_id = $iservicio->id;
        $this->servicio = $iservicio->servicio;

        $this->detalle_servicio = "";

        if (in_array($this->servicio_id, [9, 11, 19])) {
            $this->mostrarcontroles = "";
        } else {
            $this->mostrarcontroles = "d-none";
        }

        // RESTABLECER VARIABLES
        $this->reset([
            'detalle_servicio',

            'cod',
            'cod_patrimonial',
            'datos_bien',
            'bien_ip',

            'obs_usuario',
            'obs_informatico',

            'obs_informatico',
            'informatico_dni',
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
        $this->modalInformaticaServicioBuscar = false;

    }

    public function agregar_incidencia_solicitud(PersonalesAtencionesIncidenciasSolicitudes $iincidenciasolicitud)
    {
        $this->detalle_servicio_id = $iincidenciasolicitud->id;
        $this->solicitud_incidencia = $iincidenciasolicitud->tipo_desc;
        $this->detalle_servicio = $iincidenciasolicitud->incidencia_solicitud;
        $this->respuesta = $iincidenciasolicitud->respuesta;
        
        // 🔴 LIMPIAR SIEMPRE
        $this->formato1 = null;
        $this->formato2 = null;
        $this->formato3 = null;
        $this->formato4 = null;
        $this->ncopias = null;

        $this->formato1 = $iincidenciasolicitud->formato1;
        $this->formato2 = $iincidenciasolicitud->formato2;
        $this->formato3 = $iincidenciasolicitud->formato3;
        $this->formato4 = $iincidenciasolicitud->formato4;

        // RESTABLECER VARIABLES
        $this->reset([
            'cod',
            'cod_patrimonial',
            'datos_bien',
            'bien_ip',

            'obs_usuario',
            'obs_informatico',

            'obs_informatico',
            'informatico_dni',
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
        $this->modalInformaticaServicioDetalleBuscar = false;
    }

    public function agregar_bien(patrimonios_biene $ibien)
    {
        $this->reset([
            // DATOS DE LA PERSONA
            'persona_id',
            'dni',
            'nombres',
            'appaterno',
            'apmaterno',
            'celpersonal',
            'celinstitucional',
            'correopersonal',
            'correoinstitucional',
            'datos',
            // DATOS DEL PERSONAL
            'personal_id',
            'codsedeorigen',
            'sedeorigen',
            'coddependenciaorigen',
            'dependenciaorigen',
            'coddespachoorigen',
            'despachoorigen',

            'codsededestino',
            'sededestino',
            'coddependenciadestino',
            'dependenciadestino',
            'coddespachodestino',
            'despachodestino',

            'regimen',
            'tipo_regimen',
            'cargo',
            'cargo_condicion',
        ]);

        // INSTANCIA DEL BIEN RECEPTADO COMO PARAMETRO
        $this->bien_id = $ibien->id;
        $this->fill([
            'cod' => $ibien->codigo_barra,
            'cod_patrimonial' => $ibien->codigo_patrimonial,
            'bien' => $ibien->descripcion,
            'marca' => $ibien->marca,
            'modelo' => $ibien->modelo,
            'serie' => $ibien->nro_serie,
            'medida' => $ibien->medidas,
            'color' => $ibien->color,
            'estado' => $ibien->estado,
            'bien_ip' => $ibien->ip,
            'datos_bien' => $ibien->descripcion ." | ". $ibien->marca ." | " . $ibien->modelo ." | " . $ibien->nro_serie ." | " . $ibien->medidas ." | " .$ibien->color ." | " . $ibien->estado,
        ]);

        $dni = $ibien->usuario_dni;

        // DATOS DE LA PERSONA
        if ($persona = Persona::where('activo',1)->where('dni',$dni)->first()) {

            $this->fill([
                'persona_id' => $persona->id,
                'dni' => $persona->dni,
                'appaterno' => $persona->appaterno,
                'apmaterno' => $persona->apmaterno,
                'nombres' => $persona->nombres,
                'datos' => $persona->datos,
                'celpersonal' => $persona->celpersonal,
                'correopersonal' => $persona->correopersonal,
            ]);

            $this->fotoactual = $persona->foto;
        }

        // DATOS DEL PERSONAL
        if ($personal = Personale::where('activo',1)->where('persona_dni',$dni)->first()) {

            $this->fill([
                'personal_id' => $personal->id,

                'codsedeorigen' => $personal->codsedeorigen,
                'sedeorigen' => $personal->sedeorigen,
                'coddependenciaorigen' => $personal->coddependenciaorigen,
                'dependenciaorigen' => $personal->dependenciaorigen,
                'coddespachoorigen' => $personal->coddespachoorigen,
                'despachoorigen' => $personal->despachoorigen,

                'codsededestino' => $personal->codsededestino,
                'sededestino' => $personal->sededestino,
                'coddependenciadestino' => $personal->coddependenciadestino,
                'dependenciadestino' => $personal->dependenciadestino,
                'coddespachodestino' => $personal->coddespachodestino,
                'despachodestino' => $personal->despachodestino,

                'celinstitucional' => $personal->celinstitucional,
                'correoinstitucional' => $personal->correoinstitucional,
                'regimen' => $personal->regimen,
                'tipo_regimen' => $personal->tipo_regimen,
                'cargo' => $personal->cargo,
                'cargo_condicion' => $personal->cargo_condicion,
            ]);
        }

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
        $this->modalPatrimonioBienesBuscar = false;
    }


    // ============================================================================================================================
    // CAGAR PDF
    // ============================================================================================================================

    private function guardar_acta()
    {
        if (!$this->pdf_acta) {
            return null;
        }

        if ($this->bandera_documento === 'EVIDENCIA') {

            $directorio = 'archivos/informatica/atenciones/evidencias';

            // Si ya existe una ruta, reutilizar el nombre
            if (!empty($this->ruta_evidencia)) {
                $fileName = basename($this->ruta_evidencia);

                // Opcional: eliminar el archivo anterior antes de guardar
                Storage::disk('public')->delete($this->ruta_evidencia);
            } else {
                $fileName = now()->timestamp . '_' . $this->dni . '_EVIDENCIA.pdf';
            }

            return $this->pdf_acta->storeAs(
                $directorio,
                $fileName,
                'public'
            );
        }

        $directorio = 'archivos/informatica/atenciones/actas';

        if (!empty($this->ruta_documento)) {
            $fileName = basename($this->ruta_documento);

            Storage::disk('public')->delete($this->ruta_documento);
        } else {
            $fileName = now()->timestamp . '_' . $this->dni . '_ACTA.pdf';
        }

        return $this->pdf_acta->storeAs(
            $directorio,
            $fileName,
            'public'
        );
    }

    private function editar_acta($personal_id)
    {
        $this->personal_id = $personal_id;
    }

    private function actualizar_acta()
    {
        $iatencion = PersonalesAtencione::findOrFail($this->atencion_id);

        if ($this->bandera_documento === "EVIDENCIA") {
            $rutaDocumento = $iatencion->ruta_evidencia;
        } else {
            $rutaDocumento = $iatencion->ruta_documento;
        }

        if (!$this->pdf_acta) {
            return $rutaDocumento;
        }

        // Si no existe archivo previo
        if (!$rutaDocumento) {
            return $this->guardar_acta();
        }

        $fileName = basename($rutaDocumento);
        $directory = dirname($rutaDocumento);

        if (Storage::disk('public')->exists($rutaDocumento)) {
            Storage::disk('public')->delete($rutaDocumento);
        }

        return $this->pdf_acta->storeAs(
            $directory,
            $fileName,
            'public'
        );
    }

    public function pdf_cerrar()
    {
        // CERRAR MODAL CARGAR PDF
        $this->modalPDFCargar = false;
    }

    // FUNCIÓN PARA MODAL ENVIAR CORREO
    // ============================================================================================================================
    public function enviar_correo()
    {
        $instanciaTbl = PersonalesAtencione::findOrFail($this->atencion_id);

        // 📎 Array dinámico de adjuntos
        $adjuntos = [];

        if ($this->servicio === "CERTIFICADO DIGITAL" && $this->detalle_servicio === "REQUISITOS") {

            $archivos = [
                public_path('formatos/certificado_digital/formato01.pdf'),
                public_path('formatos/certificado_digital/formato02.pdf'),
                public_path('formatos/certificado_digital/formato03.xlsx'),
            ];

            foreach ($archivos as $file) {
                if (!file_exists($file)) {
                    session()->flash('error', "El archivo no existe: {$file}");
                    return;
                }
                $adjuntos[] = $file;
            }

        } elseif ($this->detalle_servicio === "REQUISITOS") {

            $file = public_path('formatos/carta_de_riesgo.docx');

            if (file_exists($file)) {
                $adjuntos[] = $file;
            }
        }

        // ✅ AQUÍ VA LA VALIDACIÓN / NORMALIZACIÓN
        $enviado_lima = filled($this->enviado_lima) ? $this->enviado_lima : null;
        $glpi = filled($this->glpi) ? $this->glpi : null;
        $ncopias = filled($this->ncopias) ? $this->ncopias : null;
        $cod_patrimonial = filled($this->cod_patrimonial) ? $this->cod_patrimonial : null;
        $datos_bien      = filled($this->datos_bien) ? $this->datos_bien : null;

        // 📧 Enviar correo
        // Mail::to($this->correoinstitucional)->queue(
        Mail::to($this->correoinstitucional)->send(
            new NotificacionInformaticaTicket(
                $this->dni,
                $this->datos,
                $this->cargo,
                $this->sedeorigen,
                $this->dependenciaorigen,
                $this->despachoorigen,

                $this->servicio,
                $this->detalle_servicio,
                $this->respuesta,
                $enviado_lima,
                $glpi,
                $ncopias,
                $cod_patrimonial,
                $datos_bien,

                $adjuntos // 👈 ahora envías un array
            )
        );

        session()->flash('success', "Correo enviado correctamente");
    }

    // ============================================================================================================================
    // COPIAR DATOS
    // ============================================================================================================================

    public function generarTexto()
    {
        return "DATOS:
    - Solicitud/Incidente: {$this->servicio}
    - Nombres: {$this->datos}
    - DNI: {$this->dni}
    - Correo: {$this->correoinstitucional}
    - Celular: {$this->celinstitucional}
    - Cargo: {$this->cargo}
    - Dependencia/Fiscalía: {$this->dependenciadestino}
    - Despacho: {$this->despachodestino}";
    }

    public function copiarDatos()
    {
        $texto = $this->generarTexto();

        $this->dispatch('copiar-portapapeles', texto: $texto);
    }

    // ============================================================================================================================
    // EXPORTAR EXCEL
    // ============================================================================================================================

    public function exportarExcel()
    {
        return Excel::download(
            new TicketsfiltrosExport(
                $this->search,
                $this->filtro_atendido, 
                $this->filtro_enviadolima, 
                $this->filtro_atendidou,

                $this->filtro_anio,
                $this->filtro_mes,

                $this->filtro_sede,
                $this->filtro_dependencia,
                $this->filtro_servicio,
                $this->filtro_incidencia,
            ),
            'reporte_tickes.xlsx'
        );
    }

}
