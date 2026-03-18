<?php

namespace App\Livewire\Intranet\Atenciones;

use App\Models\Persona;
use App\Models\Personale;
use App\Models\Personales_cargo;
use App\Models\Personales_dependencia;
use App\Models\Personales_despacho;
use App\Models\Personales_sede;
use App\Models\PersonalesAtencionesIncidenciasSolicitudes;
use App\Models\PersonalesAtencionesServicio;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\Storage;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Activos extends Component
{
    protected $listeners = ['usuarioActivado' => '$refresh'];

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
    public $seccionFoto, $seccionPersona, $seccionPersonal;

    // Variable de función Guardar o Actualizar
    public $funcionGuardarActualizar;

    // Variables de búsqueda
    public $search, $searchi,$searchhistorial, $searchpersonas, $searchsedes,$searchdependencias,$searchdespachos,$searchcargos,
            $searchservicios,$searchincidenciasolicitud;
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
    public function updatingSearchpersonalatenciones(){
        $this->resetPage('personalatencionesPage');
    }
    public function updatingSearchservicios(){
        $this->resetPage('serviciosPage');
    }
    public function updatingSearchincidenciasolicitud(){
        $this->resetPage('incidenciasolicitudPage');
    }

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

    public $servicio_id,
            $servicio,
            $incidenciasolicitud_id,
            $incidenciasolicitud,
            $cea,
            $sgf,
            $enviado_lima,
            $glpi,
            $observacion,
            $atendido,
            $tiempo_atencion,
            $respuesta,
            $cargo_condicion,$reportado_por,$tipo;

    public $soporte_id,
            $preventivo,
            $sede_ubicacion,
            $dependencia_ubicacion,
            $despacho_ubicacion,
            $p01,
            $p02,
            $p03,
            $p04,
            $p05,
            $p06,
            $p07,
            $potros,
            $correctivo,
            $c01,
            $c02,
            $c03,
            $c04,
            $c05,
            $c06,
            $c07,
            $cotros,
            $operativo,
            $observacion_usuario,
            $recomendacion_usuario,
            $ruta_evidencia;

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
            $bien_ip;

    public $pdf_acta;
    public $bandera_documento="EVIDENCIA";

    public $filtro_anio,$filtro_mes;

    public function updatedp07($value)
    {
        $this->mostrarotrosp = $value ? '' : 'd-none';
        if (!$value) {
            $this->cotros = '';
        }
    }

    public function updatedC07($value)
    {
        $this->mostrarotrosc = $value ? '' : 'd-none';
        if (!$value) {
            $this->cotros = '';
        }
    }

    public function mount()
    {
        $this->filtro_anio = date('Y');
        $this->filtro_mes = date('n');
    }

    public function render()
    {
        $lista_activos = Persona::join('personales', 'personas.id', '=', 'personales.persona_id')
            ->join('personales_atenciones','personas.id','=','personales_atenciones.persona_id')
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
            ->when($this->filtrotipodocumento, function ($query) {
                $query->where(function ($q) {
                    $q->where('personales.tipo_documento', 'like', '%' . $this->filtrotipodocumento . '%');
                    // ->orWhere('', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filtroregimen, function ($query) {
                $query->where(function ($q) {
                    $q->where('personales.regimen', 'like', '%' . $this->filtroregimen . '%');
                    // ->orWhere('', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('personales.id','desc')
            // ->distinct()
            ->paginate(10, ['personas.*'], 'personalesPage');

        $lista_inactivos = Persona::join('personales', 'personas.id', '=', 'personales.persona_id')
            ->join('personales_atenciones','personas.id','=','personales_atenciones.persona_id')
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
                'personales.sededestino',
                'personales.dependenciadestino',
                'personales.despachodestino',
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

        $lista_sedes = Personales_sede::select('id','nombre','nombred')
            ->where('activo','1')
            ->where('nombre','like','%' . $this->searchsedes . '%')
            ->distinct()
            ->orderBy('nombre')
            ->paginate(15,['*'], 'sedesPage');
            
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

        $lista_servicios = PersonalesAtencionesServicio::select('id','servicio')
            ->where('activo','1')
            ->where('servicio','like','%' . $this->searchservicios . '%')
            ->orderBy('servicio')
            ->paginate(10,['*'],'serviciosPage');

        $lista_incidencias_solicitudes = PersonalesAtencionesIncidenciasSolicitudes::select('id','servicio','incidencia_solicitud')
            ->where('activo','1')
            ->where('servicio_id',$this->servicio_id)
            ->where('incidencia_solicitud','like','%' . $this->searchincidenciasolicitud . '%')
            ->orderBy('incidencia_solicitud')
            ->paginate(10,['*'],'incidenciasolicitudPage');

        return view('livewire.intranet.atenciones.activos',
                compact('lista_activos','lista_inactivos','lista_historial','lista_personas','lista_sedes','lista_dependencias','lista_despachos','lista_cargos',
                            'lista_servicios','lista_incidencias_solicitudes'));
    }

    protected function rules(){
        return [
            'dni' => 'required',
            'reportado_por' => 'required',
            'descripcion' => 'required',
            'detalle' => 'required',
        ];
    }

    protected $messages = [
        'dni.required' => 'El DNI es obligatorio',
        'reportado_por.required' => 'Seleccionar medio',
        'descripcion.required' => 'Seleccionar el servicio',
        'detalle.required' => 'Seleccionar la incidencia o solicitud',
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
        $this->appaterno = $ipersona->appaterno;
        $this->apmaterno = $ipersona->apmaterno;
        $this->nombres = $ipersona->nombres;

        $this->datos = $ipersona->datos;

        $this->celpersonal = $ipersona->celpersonal;
        $this->correopersonal = $ipersona->correopersonal;

        $this->fotoactual = $ipersona->foto;

        $ipersonal = Personale::where([['activo',1],['persona_dni',$this->dni],])->firstOrFail();

        $this->sedeorigen = $ipersonal->sedeorigen;
        $this->dependenciaorigen = $ipersonal->dependenciaorigen;
        $this->despachoorigen = $ipersonal->despachoorigen;
        $this->celinstitucional = $ipersonal->celinstitucional;
        $this->correoinstitucional = $ipersonal->correoinstitucional;
        $this->regimen = $ipersonal->regimen;
        $this->tipo_regimen = $ipersonal->tipo_regimen;
        $this->cargo = $ipersonal->cargo;

        // $this->reset('searchpersonas');
    }

    public function agregar_servicio(PersonalesAtencionesServicio $iservicio)
    {
        $this->servicio_id = $iservicio->id;
        $this->servicio = $iservicio->servicio;

        $this->incidenciasolicitud = "";

    }

    public function cerrar_servicio()
    {
        $this->reset('searchservicios');
    }

    public function agregar_incidencia_solicitud(PersonalesAtencionesIncidenciasSolicitudes $iincidenciasolicitud)
    {
        $this->incidenciasolicitud_id = $iincidenciasolicitud->id;
        $this->incidenciasolicitud = $iincidenciasolicitud->incidencia_solicitud;

    }

    public function cerrar_incidencia_solicitud()
    {
        $this->reset('searchincidenciasolicitud');
    }
}
