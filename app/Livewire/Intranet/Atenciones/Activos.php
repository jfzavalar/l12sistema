<?php

namespace App\Livewire\Intranet\Atenciones;

use App\Models\Tbl_incidencias_solicitude;
use App\Models\Tbl_personale;
use App\Models\Tbl_personales_atencione;
use App\Models\Tbl_sede;
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

    // Variable de entorno
    public $modal_header_titulo = 'nuevo';
    public $modal_header_color = 'primary-subtle';
    public $btn_guardar_actualizar = 'guardar';
    public $btn_guardar_actualizar_color = 'primary';
    public $fieldset_disable = 'disable';

    public $modal_abierto_atenciones = false;
    public $modal_abierto_personal_buscar = false;
    public $modal_abierto_pdf_cargar = false;

    public $modal_abierto_incidencia_solicitud = false;
    public $modal_abierto_incidencia_solicitud_detalle = false;

    // Variables personal
    public $id_personal,
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
        $activo,
        $created_user,
        $updated_user;

    // Variables incidencias - solicitudes
    public $id_is,
        $reportado_por,
        $tipo = 1, // 0-1
        $tipo_desc,
        $descripcion,
        $detalle, // Detalle de la incidecnia o solicitud
        $cea,
        $cf,
        $enviado_lima = 'NO', //1-0
        $glpi,
        $observacion_is, // Descripcion

        $atendido = 'SI', // Si - No
        $tiempo_atencion = 'NORMAL', // NORMAL - REGULAR - COMPLEJO
        $respuesta,

        $conformidad_dni_personal,
        $conformidad_datos_personal,

        $activo_is,
        $created_user_i_s,
        $updated_user_i_s;

    public $filtro_anio,$filtro_mes;

    public $searchpersonalatenciones;
    public function updatingSearchpersonalatenciones()
    {
        $this->resetPage('atencionesPage');
    }
    public $searchbuscarpersonal;
    public function updatingSearchbuscarpersonal()
    {
        $this->resetPage('personalPage');
    }
    public $searchincidenciasolicitud;
    public function updatingSearchincidenciasolicitud()
    {
        $this->resetPage('incidenciasolicitudPage');
    }
    public $searchincidenciasolicituddesc;
    public function updatingSearchincidenciasolicituddesc()
    {
        $this->resetPage('incidenciasolicituddescPage');
    }

    // Cargar varios documentos
    public $pdfs = [];
    protected $rules = [
        'pdfs.*' => 'required|mimes:pdf|max:10240', // máximo 10MB por archivo
    ];

    public function mount()
    {
        $this->filtro_anio = date('Y');
        $this->filtro_mes = date('n');
    }

    public function render()
    {
        $lista_atenciones = Tbl_personales_atencione::paginate(15,['*'],'atencionesPage');

        $lista_personal = Tbl_personale::where('activo','1')
            ->where('dni','like','%' .$this->searchbuscarpersonal .'%')
            ->orwhere('datos','like','%' .$this->searchbuscarpersonal .'%')
            ->paginate(15,['*'],'personalPage');

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

        $lista_indicencias_solicitudes = Tbl_incidencias_solicitude::select('descripcion')
            ->where('activo','1')
            ->where('descripcion', 'like', '%' . $this->searchincidenciasolicitud . '%')
            ->distinct('descripcion')
            ->orderBy('descripcion')
            ->paginate(15,['*'],'incidenciassolicitudesPage');

        $lista_indicencias_solicitudes_desc = Tbl_incidencias_solicitude::select('detalle')
            ->where('activo','1')
            ->where('descripcion',$this->descripcion)
            ->where('detalle', 'like', '%' . $this->searchincidenciasolicituddesc . '%')
            ->orderBy('detalle')
            ->paginate(15,['*'],'incidenciassolicitudesdescPage');

        return view('livewire.intranet.atenciones.activos',
                compact('lista_atenciones',
                        'lista_personal','lista_sedes','lista_dependencias',
                        'lista_indicencias_solicitudes','lista_indicencias_solicitudes_desc'));
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

    public function nuevo(){
        // Variable de entorno
    $this->modal_header_titulo = 'nuevo';
    $this->modal_header_color = 'primary-subtle';
    $this->btn_guardar_actualizar = 'guardar';
    $this->btn_guardar_actualizar_color = 'primary';

    $this->modal_abierto_atenciones = true;
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
