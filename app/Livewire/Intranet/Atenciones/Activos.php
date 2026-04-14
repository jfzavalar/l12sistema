<?php

namespace App\Livewire\Intranet\Atenciones;

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
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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
    public $mostrarcontroles = "d-none",$mostrarcontrolgpli="d-none";
    public $mostrarotrosp = "d-none", $mostrarotrosc = "d-none",$mostrarcargafoto = "d-none";

    //Variables bloquear de secciones
    public $seccionFoto, $seccionPersona, $seccionPersonal;

    // Variable de función Guardar o Actualizar
    public $funcionGuardarActualizar;

    // Variables de búsqueda
    public $search, $searchi,$searchhistorial, $searchpersonas, $searchsedes,$searchdependencias,$searchdespachos,$searchcargos,
            $searchservicios,$searchincidenciasolicitud,$searchbienes;
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
    public function updatingSearchbienes(){
        $this->resetPage('bienesPage');
    }

    public $filtrotipodocumento;
    public $filtroregimen;
    public $filtroatendido;

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
            $enviado_lima,
            $detalle_problema,
            $captura_evidencia,
            $ncopias,
            $obs_usuario,
            $obs_informatico,
            $estado_bien,
            $atendido,
            $atendido_por_id,
            $atendido_por_dni,
            $atendido_por_datos,
            $tiempo_atencion,
            $respuesta,
            $conformidad,
            $ruta_evidencia,
            $ruta_documento,
            $formato1,
            $formato2,
            $formato3,
            $formato4;

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

    public $filtro_anio,$filtro_mes;

    public function mount()
    {
        $this->filtro_anio = date('Y');
        $this->filtro_mes = date('n');
    }

    public function render()
    {
        $lista_activos = $this->queryConFiltros()
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
                'personales.tipo_documento',
                'personales_atenciones.id as personalatencion_id',
                'personales_atenciones.reportado_por',
                'personales_atenciones.servicio',
                'personales_atenciones.detalle_servicio',
                'personales_atenciones.solicitud_incidencia',
                'personales_atenciones.atendido',
                'personales_atenciones.atendido_por_datos',
                'personales_atenciones.created_user as utencioncreado',
                'personales_atenciones.ruta_documento')
            ->where('personales_atenciones.activo', 1)
            ->orderBy('personales_atenciones.id','desc')
            ->paginate(10, ['personas.*'], 'personalesPage');

        $lista_inactivos = $this->queryConFiltros()
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
                'personales.tipo_documento',
                'personales_atenciones.reportado_por',
                'personales_atenciones.servicio',
                'personales_atenciones.detalle_servicio',
                'personales_atenciones.solicitud_incidencia',
                'personales_atenciones.atendido',
                'personales_atenciones.atendido_por_datos')
            ->where('personales.activo', 0)
            ->orderBy('personales_atenciones.id','desc')
            ->paginate(10, ['personas.*'], 'personalesiPage');

        $estadisticas = PersonalesAtencione::select('created_user')
            ->selectRaw("COUNT(*) as total")
            ->selectRaw("SUM(CASE WHEN atendido = 'SI' THEN 1 ELSE 0 END) as atendidos")
            ->selectRaw("SUM(CASE WHEN atendido = 'NO' THEN 1 ELSE 0 END) as no_atendidos")
            ->groupBy('created_user')
            ->get();

        $lista_historial = $this->queryConFiltros()
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
                'personales.tipo_documento',
                'personales_atenciones.id as personalatencion_id',
                'personales_atenciones.reportado_por',
                'personales_atenciones.servicio',
                'personales_atenciones.detalle_servicio',
                'personales_atenciones.solicitud_incidencia',
                'personales_atenciones.atendido',
                'personales_atenciones.atendido_por_datos',
                'personales_atenciones.created_user as utencioncreado')
            ->whereIn('personales_atenciones.activo', [1,0])
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

        return view('livewire.intranet.atenciones.activos',
                compact('lista_activos','lista_inactivos','estadisticas','lista_historial',
                            'lista_personas','lista_sedes','lista_dependencias','lista_despachos','lista_cargos',
                            'lista_servicios','lista_incidencias_solicitudes','lista_bienes'));
    }

    private function queryConFiltros()
    {
        return Persona::join('personales', 'personas.id', '=', 'personales.persona_id')
            ->join('personales_atenciones','personas.id','=','personales_atenciones.persona_id')

            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('personas.dni', 'like', '%' . $this->search . '%')
                    ->orWhere('personas.datos', 'like', '%' . $this->search . '%');
                });
            });

            // ->when($this->filtroatendido, function ($query) {
            //     $query->where(function ($q) {
            //         $q->where('personales.tipo_documento', '=', $this->filtroatendido);
            //         // ->orWhere('', 'like', '%' . $this->search . '%');
            //     });
            // });
    }

    protected function rules(){
        return [
            'dni' => 'required',
        ];
    }

    protected $messages = [
        'dni.required' => 'El DNI es obligatorio',
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
        $this->mostrarcontroles = "d-none";

        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "Nuevo";
        $this->colorGuardarActualizar = "primary";
        $this->textoGuardarActualizar = "Guardar";
        $this->colorAgregar = "outline-primary";

        $this->tipo_documento = "CONTRATO";
    }

    public function guardar()
    {
        // $this->validate();

        try {

            DB::transaction(function () {

                $usuario = auth()->user()->datos; // Mejor que usar propiedad pública

                // FUNCIÓN PARA CARGAR DOCUMENTO
                $rutaDocumento = $this->guardar_acta();

                PersonalesAtencione::create([
                    'persona_id' => $this->persona_id,
                    'dni' => $this->dni,
                    'personal_id' => $this->personal_id,
                    'datos' => $this->datos,
                    'codsede_origen' => $this->codsedeorigen,
                    'sede_origen' => $this->sedeorigen,
                    'coddependencia_origen' => $this->coddependenciaorigen,
                    'dependencia_origen' => $this->dependenciaorigen,
                    'coddespacho_origen' => $this->coddespachoorigen,
                    'despacho_origen' => $this->despachoorigen,
                    'codsede_destino' => $this->codsededestino,
                    'sede_destino' => $this->sededestino,
                    'coddependencia_destino' => $this->coddependenciadestino,
                    'dependencia_destino' => $this->dependenciadestino,
                    'coddespacho_destino' => $this->coddespachodestino,
                    'despacho_destino' => $this->despachodestino,
                    'reportado_por' => $this->reportado_por,
                    'solicitud_incidencia' => $this->solicitud_incidencia,
                    'servicio_id' => $this->servicio_id,
                    'servicio' => $this->servicio,
                    'detalle_servicio_id' => $this->detalle_servicio_id,
                    'detalle_servicio' => $this->detalle_servicio,
                    'bien_id' => $this->bien_id,
                    'cod' => $this->cod,
                    'cod_patrimonial' => $this->cod_patrimonial,
                    'datos_bien' => $this->datos_bien,
                    'cea' => strtoupper($this->cea),
                    'sgf' => strtoupper($this->sgf),
                    'glpi' => strtoupper($this->glpi),
                    'enviado_lima' => $this->enviado_lima,
                    'detalle_problema' => strtoupper($this->detalle_problema),

                    'obs_usuario' => strtoupper($this->obs_usuario),
                    'obs_informatico' => strtoupper($this->obs_informatico),
                    'estado' => $this->estado_bien,

                    'atendido' => $this->atendido,
                    'atendido_por_id' => auth()->user()->id,
                    'atendido_por_dni' => auth()->user()->dni,
                    'atendido_por_datos' => $usuario,
                    'tiempo_atencion' => $this->tiempo_atencion,
                    'respuesta' => strtoupper($this->respuesta),
                    'conformidad' => $this->conformidad,
                    'ruta_evidencia' => $rutaDocumento,
                    'activo' => "1",
                    'created_user' => $usuario,
                    'updated_user' => $usuario,
                ]);
            });

            // Restablecer todas las variables
            $this->reset();

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Datos actualizados',
                mensaje: 'Los datos se han actualizado correctamente.',
                tipo: 'success'
            );

            // Evento para cerrar el modal
            $this->dispatch('cerrar-modal', id: 'nuevoEditarModal');

        // } catch (\Throwable $e) {

        //     dd($e); // 🔥 Esto te dirá TODO
        // };

        } catch (\Throwable $e) {

            report($e);

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Error',
                mensaje: 'Ocurrió un error al guardar.',
                tipo: 'error'
            );
        };
    }

    public function editar(PersonalesAtencione $ipersonalatencion)
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

        // ===== DATOS ATENCION =====
        // $ipersonalatencion = PersonalesAtencione::where('id', $personalatencion_id)->where('activo','1')->firstOrFail();
        $this->atencion_id = $ipersonalatencion->id;
        $this->persona_id = $ipersonalatencion->persona_id;
        $this->dni = $ipersonalatencion->dni;
        $this->reportado_por = $ipersonalatencion->reportado_por;
        $this->solicitud_incidencia = $ipersonalatencion->solicitud_incidencia;
        $this->servicio_id = $ipersonalatencion->servicio_id;
        $this->servicio = $ipersonalatencion->servicio;
        $this->detalle_servicio_id = $ipersonalatencion->detalle_servicio_id;
        $this->detalle_servicio = $ipersonalatencion->detalle_servicio;

        $this->bien_id = $ipersonalatencion->bien_id;
        $this->cod = $ipersonalatencion->cod;
        $this->cod_patrimonial = $ipersonalatencion->cod_patrimonial;
        $this->datos_bien = $ipersonalatencion->datos_bien;

        $this->cea = $ipersonalatencion->cea;
        $this->sgf = $ipersonalatencion->sgf;
        $this->glpi = $ipersonalatencion->glpi;
        $this->enviado_lima = $ipersonalatencion->enviado_lima;
        $this->detalle_problema = $ipersonalatencion->detalle_problema;
        $this->ncopias = $ipersonalatencion->ncopias;

        $this->obs_usuario = $ipersonalatencion->obs_usuario;
        $this->obs_informatico = $ipersonalatencion->obs_informatico;
        $this->estado_bien = $ipersonalatencion->estado;

        $this->atendido = $ipersonalatencion->atendido;
        $this->atendido_por_id = $ipersonalatencion->atendido_por_id;
        $this->atendido_por_dni = $ipersonalatencion->atendido_por_dni;
        $this->atendido_por_datos = $ipersonalatencion->atendido_por_datos;
        $this->tiempo_atencion = $ipersonalatencion->tiempo_atencion;
        $this->respuesta = $ipersonalatencion->respuesta;
        $this->conformidad = $ipersonalatencion->conformidad;
        $this->ruta_evidencia = $ipersonalatencion->ruta_evidencia;

        if (in_array($this->servicio, ["EQUIPO DE COMPUTO", "IMPRESORA", "SERVIDORES"]))
        {
            $this->mostrarcontroles = "";
        } else {
            $this->mostrarcontroles = "d-none";
        }

        // ===== DATOS PERSONA =====
        $ipersona = Persona::where('dni', $this->dni)->where('activo','1')->firstOrFail();
        $this->persona_id = $ipersona->id;
        $this->dni = $ipersona->dni;
        $this->nombres = $ipersona->nombres;
        $this->appaterno = $ipersona->appaterno;
        $this->apmaterno = $ipersona->apmaterno;
        $this->celpersonal = $ipersona->celpersonal;
        $this->correopersonal = $ipersona->correopersonal;

        $this->fotoactual = $ipersona->foto;

        // // ===== DATOS PERSONAL =====
        $ipersonal = Personale::where('persona_dni', $ipersonalatencion->dni)->where('activo','1')->firstOrFail();

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

        $this->codsededestino = $ipersonal->codsededestino;
        $this->sededestino = $ipersonal->sededestino;
        $this->coddependenciadestino = $ipersonal->coddependenciadestino;
        $this->dependenciadestino = $ipersonal->dependenciadestino;
        $this->coddespachodestino = $ipersonal->coddespachodestino;
        $this->despachodestino = $ipersonal->despachodestino;

        $this->celinstitucional = $ipersonal->celinstitucional;
        $this->correoinstitucional = $ipersonal->correoinstitucional;
        
    }

    public function actualizar(){
        
        try {

            DB::transaction(function () {

                $usuario = auth()->user()->datos;

                // FUNCIÓN PARA CARGAR DOCUMENTO
                $rutaDocumento = $this->actualizar_acta();

                $ipersonalatencion = PersonalesAtencione::where('id', $this->atencion_id)->where('activo','1')->firstOrFail();

                $ipersonalatencion->update([
                    'persona_id' => $this->persona_id,
                    'dni' => $this->dni,
                    'personal_id' => $this->personal_id,
                    'datos' => $this->datos,
                    'codsede_origen' => $this->codsedeorigen,
                    'sede_origen' => $this->sedeorigen,
                    'coddependencia_origen' => $this->coddependenciaorigen,
                    'dependencia_origen' => $this->dependenciaorigen,
                    'coddespacho_origen' => $this->coddespachoorigen,
                    'despacho_origen' => $this->despachoorigen,
                    'codsede_destino' => $this->codsededestino,
                    'sede_destino' => $this->sededestino,
                    'coddependencia_destino' => $this->coddependenciadestino,
                    'dependencia_destino' => $this->dependenciadestino,
                    'coddespacho_destino' => $this->coddespachodestino,
                    'despacho_destino' => $this->despachodestino,
                    'reportado_por' => $this->reportado_por,
                    'solicitud_incidencia' => $this->solicitud_incidencia,
                    'servicio' => $this->servicio,
                    'detalle_servicio' => $this->detalle_servicio,
                    'cea' => $this->cea,
                    'sgf' => $this->sgf,
                    'glpi' => $this->glpi,
                    'enviado_lima' => $this->enviado_lima,
                    'detalle_problema' => $this->detalle_problema,

                    'obs_usuario' => $this->obs_usuario,
                    'obs_informatico' => $this->obs_informatico,
                    'estado' => $this->estado_bien,

                    'atendido' => $this->atendido,
                    'atendido_por_id' => auth()->user()->id,
                    'atendido_por_dni' => auth()->user()->dni,
                    'atendido_por_datos' => $usuario,
                    'tiempo_atencion' => $this->tiempo_atencion,
                    'respuesta' => $this->respuesta,
                    'conformidad' => $this->conformidad,
                    'ruta_evidencia' => $rutaDocumento,
                    'activo' => "1",
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

        } 
        catch (\Throwable $e) {

            report($e);

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Error',
                mensaje: 'Ocurrió un error al actualizar.',
                tipo: 'error'
            );
        };
        // catch (\Throwable $e) {

        //     dd($e); // 🔥 Esto te dirá TODO
        // };
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

    // FUNCIONES PARA CARGAR PDF


    public function editar_pdf($atencion_id)
    {
        $this->atencion_id = $atencion_id;
        
        $this->bandera_documento = "ACTA";
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

        // $this->reset('searchpersonas');
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
        
        $this->reset('searchservicios','searchbienes',
                        'bien_id','cod','cod_patrimonial','datos_bien');

    }

    public function cerrar_servicio()
    {
        $this->reset('searchservicios');
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
        $this->formato1 = $iincidenciasolicitud->formato1;
        $this->formato2 = $iincidenciasolicitud->formato2;
        $this->formato3 = $iincidenciasolicitud->formato3;
        $this->formato4 = $iincidenciasolicitud->formato4;
    }

    public function cerrar_incidencia_solicitud()
    {
        $this->reset('searchincidenciasolicitud');
    }

    public function agregar_bien(patrimonios_biene $ibien)
    {
        $this->reset([
            'dni','datos','appaterno','apmaterno','nombres','genero','estadocivil',
            'fechanacimiento','celpersonal','correopersonal','foto',
            'tipo_regimen','regimen','cargo',
            'codsedeorigen','sedeorigen',
            'coddependenciaorigen','dependenciaorigen',
            'coddespachoorigen','despachoorigen',
            'codsededestino','sededestino',
            'coddependenciadestino','dependenciadestino',
            'coddespachodestino','despachodestino',
            'celinstitucional','correoinstitucional'
        ]);

        // Datos del bien
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
            'datos_bien' => $ibien->bien ." | ". $ibien->marca ." | " . $ibien->modelo ." | " . $ibien->serie ." | " . $ibien->medida ." | " .$ibien->color ." | " . $ibien->estado,
        ]);

        $dni = $ibien->usuario_dni;

        // Persona
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

        // Personal
        if ($personal = Personale::where('activo',1)->where('persona_dni',$dni)->first()) {

            $this->fill([
                'personal_id' => $personal->id,
                'sedeorigen' => $personal->sedeorigen,
                'dependenciaorigen' => $personal->dependenciaorigen,
                'despachoorigen' => $personal->despachoorigen,
                'celinstitucional' => $personal->celinstitucional,
                'correoinstitucional' => $personal->correoinstitucional,
                'regimen' => $personal->regimen,
                'tipo_regimen' => $personal->tipo_regimen,
                'cargo' => $personal->cargo,
            ]);
        }

        $this->reset('searchbienes');
    }

    public function cerrar_bien()
    {

    }

    // --------------------------------------------------

    private function guardar_acta()
    {
        if (!$this->pdf_acta) {
            return null;
        }

        if ($this->bandera_documento === "EVIDENCIA") {
            $fileName =
            now()->timestamp.'_'
            .$this->dni.'_'
            // .$this->cod_patrimonial.'_'
            ."EVIDENCIA"
            .'.pdf';

            return $this->pdf_acta->storeAs(
                'archivos/informatica/atenciones/evidencias',
                $fileName,
                'public'
            );
        } else {
            $fileName =
            now()->timestamp.'_'
            .$this->dni.'_'
            // .$this->cod_patrimonial.'_'
            ."ACTA"
            .'.pdf';

            return $this->pdf_acta->storeAs(
                'archivos/informatica/atenciones/actas',
                $fileName,
                'public'
            );
        }
        
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
}
