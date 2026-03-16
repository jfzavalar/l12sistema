<?php

namespace App\Livewire\Intranet\Atenciones;

use App\Models\Persona;
use App\Models\Personales_cargo;
use App\Models\Personales_dependencia;
use App\Models\Personales_despacho;
use App\Models\Personales_sede;
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
    public $mostrarcargafoto = "";

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

    public $num_expediente,
            $fecha_iniciou,
            $fecha_finu,
            $motivo_ubicacion;

    public $pdf_acta;

    public $filtro_anio,$filtro_mes ;

    public function mount()
    {
        $this->filtro_anio = date('Y');
        $this->filtro_mes = date('n');
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

        return view('livewire.intranet.atenciones.activos',
                compact('lista_activos','lista_inactivos','lista_historial','lista_personas','lista_sedes','lista_dependencias','lista_despachos','lista_cargos'));
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
        $this->bandera_documento = "CONTRATO";
    }

    public function guardar(){
        $validated = $this->validate(); 

        $this->modal_abierto_atenciones = false;
        // Emitimos un evento para mostrar el SweetAlert
        $this->dispatch(
            'alerta-actualizado',
            titulo: 'Datos Almacenados',
            mensaje: 'Los datos se han guardado correctamente.',
            tipo: 'success' // success | error | warning | info
        );
    }

    public function editar(Tbl_personales_atencione $iatencion){
        $this->modal_header_titulo = 'actualizar';
        $this->modal_header_color = 'success-subtle';
        $this->btn_guardar_actualizar = 'actualizar';
        $this->btn_guardar_actualizar_color = 'success';

        $this->modal_abierto_atenciones = true;
    }

    public function actualizar(){
        $validated = $this->validate(); 
    }

    public function cerrar(){
        $this->modal_abierto_atenciones = false;
    }

    // PERSONAL
    // ---------------------------------------------------------
    public function buscar_personal(){
        $this->modal_abierto_personal_buscar = true;
    }

    public function agregar_personal(Tbl_personale $ipersonal){
        $this->id_personal = $ipersonal->id;
        $this->dni = $ipersonal->dni;
        $this->datos = $ipersonal->datos;

        $this->codsede_origen = $ipersonal->codsede_origen;
        $this->sede_origen = $ipersonal->sede_origen;
        $this->coddependencia_origen = $ipersonal->coddependencia_origen;
        $this->dependencia_origen = $ipersonal->dependencia_origen;

        $this->codsede_destino = $ipersonal->codsede_destino;
        $this->sede_destino = $ipersonal->sede_destino;
        $this->coddependencia_destino = $ipersonal->coddependencia_destino;
        $this->dependencia_destino = $ipersonal->dependencia_destino;

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

    // INCIDENCIAS Y SOLICITUDES
    public function buscar_indicencia_solicitud(){
        $this->modal_abierto_incidencia_solicitud = true;
    }

    public function agregar_indicencia_solicitud($vdescripcion){
        $this->descripcion = $vdescripcion;
        $this->modal_abierto_incidencia_solicitud = false;
    }

    public function cerrar_indicencia_solicitud(){
        $this->modal_abierto_incidencia_solicitud = false;
    }

    //  DETALLES INCIDENCIAS Y SOLICITUDES
    public function buscar_indicencia_solicitud_desc(){
        $this->modal_abierto_incidencia_solicitud_detalle = true;
    }

    public function agregar_indicencia_solicitud_desc($vdescripcion_desc){
        $this->detalle = $vdescripcion_desc;
        $this->respuesta = 'SE REALIZA: ' . $vdescripcion_desc . ' DE ' . $this->descripcion;
        $this->modal_abierto_incidencia_solicitud_detalle = false;
    }

    public function cerrar_indicencia_solicitud_desc(){
        $this->modal_abierto_incidencia_solicitud_detalle = false;
    }

    // PDF
    // ---------------------------------------------------------
    public function cargarPDF1(){
        $this->modal_abierto_pdf_cargar = true;
    }

    public function cargarPDF2(){
    }
    public function eliminarPDF($index)
    {
        if (isset($this->pdfs[$index])) {
            unset($this->pdfs[$index]);
            $this->pdfs = array_values($this->pdfs); // reindexar el array
        }
    }
    public function cerrar_PDF(){
        $this->modal_abierto_pdf_cargar = false;
    }
}
