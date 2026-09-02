<?php

namespace App\Livewire\Patrimonio\Bienes;

use App\Models\Patrimonios_biene;
use App\Models\PatrimoniosBiene;
use App\Models\PatrimoniosBienesAsignacione;
use App\Models\PatrimoniosBienesAsignacionesDetalle;
use App\Models\PatrimoniosBienesDesplazamientosTemporale;
use App\Models\PatrimoniosBienesDesplazamientosTemporalesDetalle;
use App\Models\Persona;
use App\Models\Personale;
use App\Models\Personales_cargo;
use App\Models\Personales_dependencia;
use App\Models\Personales_despacho;
use App\Models\Personales_sede;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class BienestrasladoComponent extends Component
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

    // VARIABLES PARA MODALES SECUNDARIAS
    public $modalNuevoEditarAbrir2 = false, $modalReportesFiltros2 = false;

    public $modalPersonalBuscar2 = false;
    public $modalPersonalSedeBuscar2 = false;
    public $modalPersonalDependenciaBuscar2 = false;
    public $modalPersonalDespachoBuscar2 = false;
    public $modalPersonalCargoBuscar2 = false;
    public $modalInformaticaServicioBuscar2 = false;
    public $modalInformaticaServicioDetalleBuscar2 = false;
    public $modalPatrimonioBienesBuscar2 = false;
    public $modalPDFCargar2 = false;
    public $modalPDFEvidenciaCargar2 = false;

    // VARIABLES PARA ADMINISTRAR MODALES
    public $colorHeaderModal, $textoHeaderModal;
    public $colorNuevoEditar, $textoNuevoEditar;
    public $colorGuardarActualizar, $textoGuardarActualizar;
    public $colorAgregar;

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
        $this->resetPage('desplazamientosPage');
    }
    public function updatingSearchi(){
        $this->resetPage('desplazamientosinactivosPage');
    }
    public function updatingSearchhistorial(){
        $this->resetPage('desplazamientoshistorialPage');
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

    Public $filtrosede, $filtrodependencia;
    public $filtrotipodocumento;
    public $filtroregimen;
    public $filtrocargo;

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
            $activo;

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

    public $persona_id2,
            $dni2,
            $datos2,
            $appaterno2,
            $apmaterno2,
            $nombres2,
            $genero2,
            $estadocivil2,
            $fechanacimiento2,
            $celpersonal2,
            $correopersonal2,
            $foto2,$fotoactual2,$inputFileKey2,
            $activo2;

    public $personal_id2,
            $regimen2,
            $tipo_regimen2,
            $cargo2,
            $cargo_condicion2,

            $codsedeorigen2,
            $sedeorigen2,
            $coddependenciaorigen2,
            $dependenciaorigen2,
            $coddespachoorigen2,
            $despachoorigen2,

            $codsededestino2,
            $sededestino2,
            $coddependenciadestino2,
            $dependenciadestino2,
            $coddespachodestino2,
            $despachodestino2,
            
            $celinstitucional2,          
            $correoinstitucional2,
            $tipo_documento2;

    public $bienes = [];

    public $bien_id,
            $cod_patrimonial,
            $cod,
            $bien,
            $marca,
            $modelo,
            $serie,
            $medidas,
            $color,
            $estado,

            $clase,
            $familia,
            $observa,

            $nro_pecosa,
            $doc_adq,
            $ndoc_adq,
            $fecha_adq;

    public $desplazamiento_id,
            $referencia, 
            $motivo;

    public $desplazamiento_detalle_id;

    public $pdf_acta;

    public function render()
    {
        $lista_activos = PatrimoniosBienesDesplazamientosTemporale::where('activo', "1")
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->search . '%')
                    ->orWhere('datos', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(30, ['*'], 'desplazamientosPage');


        // ======================================================
        // IDs DE LOS DESPLAZAMIENTOS DE LA PÁGINA ACTUAL
        // ======================================================

        $idsDesplazamientos = $lista_activos->pluck('id');


        // ======================================================
        // DETALLES DE LOS BIENES
        // ======================================================

        $lista_activos_detalle = PatrimoniosBienesDesplazamientosTemporalesDetalle::whereIn('desplazamiento_id', $idsDesplazamientos)
            ->join(
                'patrimonios_bienes as pb',
                'pb.id',
                '=',
                'patrimonios_bienes_desplazamientos_temporales_detalles.bien_id'
            )
            ->get()
            ->map(function ($item) {
                return [
                    'desplazamiento_id'   => $item->desplazamiento_id,
                    'id'                  => $item->bien_id,
                    'codigo_barra'        => $item->cod,
                    'codigo_patrimonial'  => $item->cod_patrimonial,
                    'descripcion'         => $item->bien,
                    'marca'               => $item->marca,
                    'modelo'              => $item->modelo,
                    'nro_serie'           => $item->nro_serie,
                    'medidas'             => $item->medidas,
                    'color'               => $item->color,
                    'estado'              => $item->estado,
                ];
            })
            ->groupBy('desplazamiento_id');

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

        $lista_personas2 = Persona::join('personales','personas.id','=','personales.persona_id')
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

        $lista_sedes2 = Personales_sede::select('id','nombre','nombred')
            ->where('activo','1')
            ->where('nombre','like','%' . $this->searchsedes . '%')
            ->distinct()
            ->orderBy('nombre')
            ->paginate(15,['*'], 'sedesPage');
            
        $lista_dependencias2 = Personales_dependencia::select('id','nombre')
            ->where('activo','1')
            ->where('sede_id',$this->codsededestino2)
            ->where('nombre','like','%' . $this->searchdependencias . '%')
            ->distinct()
            ->orderBy('nombre')
            ->paginate(10,['*'], 'dependenciasPage');

        $lista_despachos2 = Personales_despacho::select('id','nombre')
            ->where('activo','1')
            ->where('nombre','like','%' . $this->searchdespachos . '%')
            ->distinct()
            ->orderBy('nombre')
            ->paginate(10,['*'], 'despachosPage');

        $lista_cargos2 = Personales_cargo::select('id','nombre')
            ->where('activo','1')
            ->where('nombre','like','%' . $this->searchcargos . '%')
            ->distinct()
            ->orderBy('nombre')
            ->paginate(10,['*'], 'cargosPage');

        $lista_bienes = PatrimoniosBiene::where('activo','1')
            ->where('codigo_patrimonial','like','%' . $this->searchbienes . '%')
            ->distinct()
            ->orderBy('descripcion')
            ->paginate(15,['*'],'bienesPage');

        return view('livewire.patrimonio.bienes.bienestraslado-component',
                        compact('lista_activos','lista_activos_detalle',
                                    'lista_personas','lista_sedes','lista_dependencias','lista_despachos','lista_cargos',
                                    'lista_personas2','lista_sedes2','lista_dependencias2','lista_despachos2','lista_cargos2',
                                    'lista_bienes'));
    }

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

        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "NUEVO DESPLAZAMIENTO DE BIENES";
        $this->colorGuardarActualizar = "primary";
        $this->textoGuardarActualizar = "Guardar";
        $this->colorAgregar = "outline-primary";

        // ABRIR MODAL NUEVO - EDITAR
        $this->modalNuevoEditarAbrir = true;
    }

    public function guardar()
    {
        try {

            if (empty($this->bienes)) {
                $this->dispatch(
                    'alerta-actualizado',
                    titulo: 'Error',
                    mensaje: 'Debe agregar al menos un bien.',
                    tipo: 'error'
                );
                return;
            }

            DB::transaction(function () {

                $usuario = auth()->user()->datos;
                $now = now();

                // ✅ Crear cabecera
                $registro1 = PatrimoniosBienesDesplazamientosTemporale::create([
                    'persona_id' => $this->persona_id,
                    'dni' => $this->dni,
                    'personal_id' => $this->personal_id,
                    'datos' => $this->datos,
                    'regimen' => $this->regimen,
                    'regimen_tipo' => $this->regimen_tipo,
                    'cargo' => $this->cargo,
                    'cargo_condicion' => $this->cargo_condicion,

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

                    'persona_id2' => $this->persona_id2,
                    'dni2' => $this->dni2,
                    'personal_id2' => $this->personal_id2,
                    'datos2' => $this->datos2,
                    'regimen2' => $this->regimen2,
                    'regimen_tipo2' => $this->regimen_tipo2,
                    'cargo2' => $this->cargo2,
                    'cargo_condicion2' => $this->cargo_condicion2,

                    'codsedeorigen2' => $this->codsedeorigen2,
                    'sedeorigen2' => $this->sedeorigen2,
                    'coddependenciaorigen2' => $this->coddependenciaorigen2,
                    'dependenciaorigen2' => $this->dependenciaorigen2,
                    'coddespachoorigen2' => $this->coddespachoorigen2,
                    'despachoorigen2' => $this->despachoorigen2,

                    'codsededestino2' => $this->codsededestino2,
                    'sededestino2' => $this->sededestino2,
                    'coddependenciadestino2' => $this->coddependenciadestino2,
                    'dependenciadestino2' => $this->dependenciadestino2,
                    'coddespachodestino2' => $this->coddespachodestino2,
                    'despachodestino2' => $this->despachodestino2,

                    'referencia' => $this->referencia,
                    'motivo' => $this->motivo,

                    'activo' => "1",
                    'created_user' => $usuario,
                    'updated_user' => $usuario,
                ]);

                $detalles = [];
                $ids = [];

                foreach ($this->bienes as $bien) {

                    $id = data_get($bien, 'id');
                    $codigoBarra = data_get($bien, 'codigo_barra');
                    $codigoPatrimonial = data_get($bien, 'codigo_patrimonial');
                    $descripcion = data_get($bien, 'descripcion');

                    if (!$id || !$codigoPatrimonial) {
                        continue;
                    }

                    $detalles[] = [
                        'desplazamiento_id' => $registro1->id,
                        'bien_id' => $id,
                        'cod' => $codigoBarra,
                        'cod_patrimonial' => $codigoPatrimonial,
                        'bien' => $descripcion,
                        'activo' => "1",
                        'created_user' => $usuario,
                        'updated_user' => $usuario,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

                    $ids[] = $id;
                }

                if (empty($detalles)) {
                    throw new \Exception('No hay bienes válidos para registrar.');
                }


                // ✅ VALIDAR ANTES (CORRECTO)
                // $yaAsignados = PatrimoniosBiene::whereIn('id', $ids)
                //     ->where('asignacion', 'ASIGNADO')
                //     ->exists();

                // if ($yaAsignados) {
                //     throw new \Exception('Algunos bienes ya fueron asignados.');
                // }


                // ✅ Insertar detalles
                PatrimoniosBienesDesplazamientosTemporalesDetalle::insert($detalles);

                // ✅ Update sin validación incorrecta
                // PatrimoniosBiene::whereIn('id', $ids)
                //     ->update(['asignacion' => 'ASIGNADO']);
            });

            $this->reset();

            // CERRAR MODAL NUEVO ACTUALIZAR
            $this->modalNuevoEditarAbrir = false;

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Datos actualizados',
                mensaje: 'Los datos se han actualizado correctamente.',
                tipo: 'success'
            );


        } catch (\Throwable $e) {

            report($e);

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Error',
                mensaje: $e->getMessage(),
                tipo: 'error'
            );
        }
    }


    public function editar($id)
    {
        $this->resetValidation();
        $this->resetErrorBag();

        $this->funcionGuardarActualizar = "actualizar";

        $this->colorHeaderModal = "success-subtle";
        $this->textoHeaderModal = "EDITAR DESPLAZAMIENTO DE BIENES";
        $this->colorGuardarActualizar = "success";
        $this->textoGuardarActualizar = "Actualizar";
        $this->colorAgregar = "outline-success";
        
        $desplazamiento = PatrimoniosBienesDesplazamientosTemporale::findOrFail($id);

        $this->desplazamiento_id = $desplazamiento->id;

        // ===== ORIGEN =====
        $this->persona_id = $desplazamiento->persona_id;

        $persona = Persona::findOrFail($this->persona_id);
        $this->dni = $persona->dni;
        $this->nombres = $persona->nombres;
        $this->appaterno = $persona->appaterno;
        $this->apmaterno = $persona->apmaterno;
        $this->celpersonal = $persona->celpersonal;
        $this->correopersonal = $persona->correopersonal;

        $this->personal_id = $desplazamiento->personal_id;

        $personal = Personale::findOrFail($this->personal_id);
        $this->correoinstitucional = $personal->correoinstitucional;

        $this->datos = $desplazamiento->datos;
        $this->regimen = $desplazamiento->regimen;
        $this->cargo = $desplazamiento->cargo;

        $this->codsedeorigen = $desplazamiento->codsedeorigen;
        $this->sedeorigen = $desplazamiento->sedeorigen;

        $this->coddependenciaorigen = $desplazamiento->coddependenciaorigen;
        $this->dependenciaorigen = $desplazamiento->dependenciaorigen;

        $this->coddespachoorigen = $desplazamiento->coddespachoorigen;
        $this->despachoorigen = $desplazamiento->despachoorigen;

        $this->codsededestino = $desplazamiento->codsededestino;
        $this->sededestino = $desplazamiento->sededestino;

        $this->coddependenciadestino = $desplazamiento->coddependenciadestino;
        $this->dependenciadestino = $desplazamiento->dependenciadestino;

        $this->coddespachodestino = $desplazamiento->coddespachodestino;
        $this->despachodestino = $desplazamiento->despachodestino;

        // ===== DESTINO =====
        $this->persona_id2 = $desplazamiento->persona_id2;

        $persona2 = Persona::findOrFail($this->persona_id2);
        $this->dni2 = $persona2->dni;
        $this->nombres2 = $persona2->nombres;
        $this->appaterno2 = $persona2->appaterno;
        $this->apmaterno2 = $persona2->apmaterno;
        $this->celpersonal2 = $persona2->celpersonal;
        $this->correopersonal2 = $persona2->correopersonal;

        $this->personal_id2 = $desplazamiento->personal_id2;

        $personal2 = Personale::findOrFail($this->personal_id2);
        $this->correoinstitucional2 = $personal2->correoinstitucional;

        $this->datos2 = $desplazamiento->datos2;
        $this->regimen2 = $desplazamiento->regimen2;
        $this->cargo2 = $desplazamiento->cargo2;

        $this->codsedeorigen2 = $desplazamiento->codsedeorigen2;
        $this->sedeorigen2 = $desplazamiento->sedeorigen2;

        $this->coddependenciaorigen2 = $desplazamiento->coddependenciaorigen2;
        $this->dependenciaorigen2 = $desplazamiento->dependenciaorigen2;

        $this->coddespachoorigen2 = $desplazamiento->coddespachoorigen2;
        $this->despachoorigen2 = $desplazamiento->despachoorigen2;

        $this->codsededestino2 = $desplazamiento->codsededestino2;
        $this->sededestino2 = $desplazamiento->sededestino2;

        $this->coddependenciadestino2 = $desplazamiento->coddependenciadestino2;
        $this->dependenciadestino2 = $desplazamiento->dependenciadestino2;

        $this->coddespachodestino2 = $desplazamiento->coddespachodestino2;
        $this->despachodestino2 = $desplazamiento->despachodestino2;

        $this->referencia = $desplazamiento->referencia;
        $this->motivo = $desplazamiento->motivo;

        // ===== DETALLES =====
        $this->bienes = PatrimoniosBienesDesplazamientosTemporalesDetalle::where('desplazamiento_id', $id)
            ->join('patrimonios_bienes as pb', 'pb.id', '=', 'patrimonios_bienes_desplazamientos_temporales_detalles.bien_id')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->bien_id,
                    'codigo_barra' => $item->cod,
                    'codigo_patrimonial' => $item->cod_patrimonial,
                    'descripcion' => $item->bien,
                    'marca' => $item->marca,
                    'modelo' => $item->modelo,
                    'nro_serie' => $item->nro_serie,
                    'medidas' => $item->medidas,
                    'color' => $item->color,
                    'estado' => $item->estado,
                ];
            })
            ->toArray();

        // ABRIR MODAL NUEVO - EDITAR
        $this->modalNuevoEditarAbrir = true;
    }


    public function actualizar()
    {
        try {

            if (empty($this->bienes)) {
                $this->dispatch(
                    'alerta-actualizado',
                    titulo: 'Error',
                    mensaje: 'Debe agregar al menos un bien.',
                    tipo: 'error'
                );
                return;
            }

            DB::transaction(function () {

                $usuario = auth()->user()->datos;
                $now = now();

                $desplazamiento = PatrimoniosBienesDesplazamientosTemporale::findOrFail($this->desplazamiento_id);

                // =========================
                // 🔥 OBTENER BIENES ANTERIORES
                // =========================
                $bienesAntiguos = PatrimoniosBienesDesplazamientosTemporalesDetalle::where('desplazamiento_id', $desplazamiento->id)
                    ->pluck('bien_id')
                    ->toArray();

                // =========================
                // 🔓 LIBERAR ANTERIORES
                // =========================
                // if (!empty($bienesAntiguos)) {
                //     PatrimoniosBiene::whereIn('id', $bienesAntiguos)
                //         ->update(['asignacion' => 'DISPONIBLE']);
                // }

                // =========================
                // ✏️ ACTUALIZAR CABECERA
                // =========================
                $desplazamiento->update([
                    'persona_id' => $this->persona_id,
                    'dni' => $this->dni,
                    'personal_id' => $this->personal_id,
                    'datos' => $this->datos,
                    'regimen' => $this->regimen,
                    'regimen_tipo' => $this->regimen_tipo,
                    'cargo' => $this->cargo,
                    'cargo_condicion' => $this->cargo_condicion,

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

                    'persona_id2' => $this->persona_id2,
                    'dni2' => $this->dni2,
                    'personal_id2' => $this->personal_id2,
                    'datos2' => $this->datos2,
                    'regimen2' => $this->regimen2,
                    'regimen_tipo2' => $this->regimen_tipo2,
                    'cargo2' => $this->cargo2,
                    'cargo_condicion2' => $this->cargo_condicion2,

                    'codsedeorigen2' => $this->codsedeorigen2,
                    'sedeorigen2' => $this->sedeorigen2,
                    'coddependenciaorigen2' => $this->coddependenciaorigen2,
                    'dependenciaorigen2' => $this->dependenciaorigen2,
                    'coddespachoorigen2' => $this->coddespachoorigen2,
                    'despachoorigen2' => $this->despachoorigen2,

                    'codsededestino2' => $this->codsededestino2,
                    'sededestino2' => $this->sededestino2,
                    'coddependenciadestino2' => $this->coddependenciadestino2,
                    'dependenciadestino2' => $this->dependenciadestino2,
                    'coddespachodestino2' => $this->coddespachodestino2,
                    'despachodestino2' => $this->despachodestino2,

                    'referencia' => $this->referencia,
                    'motivo' => $this->motivo,

                    'updated_user' => $usuario,
                ]);

                // =========================
                // 🗑️ ELIMINAR DETALLES
                // =========================
                PatrimoniosBienesDesplazamientosTemporalesDetalle::where('desplazamiento_id', $desplazamiento->id)->delete();

                // =========================
                // 🆕 NUEVOS DETALLES
                // =========================
                $detalles = [];
                $ids = [];

                foreach ($this->bienes as $bien) {

                    $id = data_get($bien, 'id');

                    if (!$id) continue;

                    $detalles[] = [
                        'desplazamiento_id' => $desplazamiento->id,
                        'bien_id' => $id,
                        'cod' => data_get($bien, 'codigo_barra'),
                        'cod_patrimonial' => data_get($bien, 'codigo_patrimonial'),
                        'bien' => data_get($bien, 'descripcion'),
                        'activo' => "1",
                        'created_user' => $usuario,
                        'updated_user' => $usuario,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

                    $ids[] = $id;
                }

                if (empty($detalles)) {
                    throw new \Exception('No hay bienes válidos.');
                }

                // =========================
                // ⚠️ VALIDAR
                // =========================
                // $yaAsignados = PatrimoniosBiene::whereIn('id', $ids)
                //     ->where('asignacion', 'ASIGNADO')
                //     ->whereNotIn('id', $bienesAntiguos)
                //     ->exists();

                // if ($yaAsignados) {
                //     throw new \Exception('Algunos bienes ya están asignados.');
                // }

                // =========================
                // 💾 GUARDAR
                // =========================
                PatrimoniosBienesDesplazamientosTemporalesDetalle::insert($detalles);

                PatrimoniosBiene::whereIn('id', $ids)
                    ->update(['asignacion' => 'ASIGNADO']);
            });

            $this->reset();

            // CERRAR MODAL NUEVO - EDITAR
            $this->modalNuevoEditarAbrir = false;

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Actualizado',
                mensaje: 'Registro actualizado correctamente.',
                tipo: 'success'
            );

            $this->dispatch('cerrar-modal', id: 'nuevoEditarModal');

        } catch (\Throwable $e) {

            report($e);

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Error',
                mensaje: $e->getMessage(),
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
        $this->regimen_tipo = $ipersonal->tipo_regimen;
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

    // ============================================================================================================================
    // MODALES BUSCAR SECUNDARIAS
    // ============================================================================================================================

    public function personalBuscar2()
    {
        $this->modalPersonalBuscar2 = true;

        $this->dispatch('focus-input', id: 'txtSearchPersonal');
    }
    public function sedeBuscar2()
    {
        $this->modalPersonalSedeBuscar2 = true;

        $this->dispatch('focus-input', id: 'txtSearchSede');
    }
    public function dependenciaBuscar2()
    {
        $this->modalPersonalDependenciaBuscar2 = true;

        $this->dispatch('focus-input', id: 'txtSearchDependencia');
    }
    public function despachoBuscar2()
    {
        $this->modalPersonalDespachoBuscar2 = true;

        $this->dispatch('focus-input', id: 'txtSearchDespacho');
    }
    public function cargoBuscar2()
    {
        $this->modalPersonalCargoBuscar2 = true;

        $this->dispatch('focus-input', id: 'txtSearchCargo');
    }
    public function servicioBuscar2()
    {
        $this->modalInformaticaServicioBuscar2 = true;

        $this->dispatch('focus-input', id: 'txtSearchServicio');
    }
    public function servicioDetalleBuscar2()
    {
        $this->modalInformaticaServicioDetalleBuscar2 = true;

        $this->dispatch('focus-input', id: 'txtSearchServicioDetalle');
    }
    public function bienesBuscar2()
    {
        $this->modalPatrimonioBienesBuscar2 = true;

        $this->dispatch('focus-input', id: 'txtSearchBienes');
    }
    public function cerrarBuscar2()
    {
        $this->modalReportesFiltros2 = false;

        $this->modalPersonalBuscar2 = false;
        $this->modalPersonalSedeBuscar2 = false;
        $this->modalPersonalDependenciaBuscar2 = false;
        $this->modalPersonalDespachoBuscar2 = false;
        $this->modalPersonalCargoBuscar2 = false;
        $this->modalInformaticaServicioBuscar2 = false;
        $this->modalInformaticaServicioDetalleBuscar2 = false;
        $this->modalPatrimonioBienesBuscar2 = false;
    } 

    // ============================================================================================================================
    // FUNCIONES AGREGAR SECUNDARIAS
    // ============================================================================================================================

    public function agregar_persona2(Persona $ipersona2){
        // DATOS DE LA PERSONA
        $this->persona_id2 = $ipersona2->id;
        $this->dni2 = $ipersona2->dni;
        $this->appaterno2 = $ipersona2->appaterno;
        $this->apmaterno2 = $ipersona2->apmaterno;
        $this->nombres2 = $ipersona2->nombres;
        $this->datos2 = $ipersona2->datos;
        $this->celpersonal2 = $ipersona2->celpersonal;
        $this->correopersonal2 = $ipersona2->correopersonal;
        $this->fotoactual2 = $ipersona2->foto;

        // DATOS DEL PERSONAL
        $ipersonal2 = Personale::where([['persona_dni',$this->dni2],['activo',1],])->firstOrFail();

        $this->personal_id2 = $ipersonal2->id;

        $this->codsedeorigen2 = $ipersonal2->codsededestino;
        $this->sedeorigen2 = $ipersonal2->sededestino;   
        $this->coddependenciaorigen2 = $ipersonal2->coddependenciadestino;
        $this->dependenciaorigen2 = $ipersonal2->dependenciadestino;
        $this->coddespachoorigen2 = $ipersonal2->coddespachodestino;
        $this->despachoorigen2 = $ipersonal2->despachodestino;

        $this->codsededestino2 = $ipersonal2->codsededestino;
        $this->sededestino2 = $ipersonal2->sededestino;   
        $this->coddependenciadestino2 = $ipersonal2->coddependenciadestino;
        $this->dependenciadestino2 = $ipersonal2->dependenciadestino;
        $this->coddespachodestino2 = $ipersonal2->coddespachodestino;
        $this->despachodestino2 = $ipersonal2->despachodestino;

        $this->celinstitucional2 = $ipersonal2->celinstitucional;
        $this->correoinstitucional2 = $ipersonal2->correoinstitucional;
        $this->regimen2 = $ipersonal2->regimen;
        $this->regimen_tipo2 = $ipersonal2->tipo_regimen;
        $this->cargo2 = $ipersonal2->cargo;
        $this->cargo_condicion2 = $ipersonal2->cargo_condicion;
        $this->tipo_documento2 = $ipersonal2->tipo_documento;

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
        $this->modalPersonalBuscar2 = false;
    }

    public function agregar_sede2(Personales_sede $isede)
    {
        $this->codsedeorigen2 = $isede->id;
        $this->sedeorigen2 = $isede->nombre;

        $this->codsededestino2 = $isede->id;
        $this->sededestino2 = $isede->nombre;

        // RESTABLECER DEPENDENCIA Y DESPACHO
        $this->reset([
            'dependenciaorigen2',
            'despachoorigen2',
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
        $this->modalPersonalSedeBuscar2 = false;
    }

    public function agregar_dependencia2(Personales_dependencia $idependencia)
    {
        $this->coddependenciaorigen2 = $idependencia->id;
        $this->dependenciaorigen2 = $idependencia->nombre;

        $this->coddependenciadestino2 = $idependencia->id;
        $this->dependenciadestino2 = $idependencia->nombre;

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
        $this->modalPersonalDependenciaBuscar2 = false;
    }

    public function agregar_despacho2(Personales_despacho $idespacho)
    {
        $this->coddespachoorigen2 = $idespacho->id;
        $this->despachoorigen2 = $idespacho->nombre;

        $this->coddespachodestino2 = $idespacho->id;
        $this->despachodestino2 = $idespacho->nombre;

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
        $this->modalPersonalDespachoBuscar2 = false;
    }

    public function agregar_cargo2(Personales_cargo $icargo)
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
        $this->modalPersonalCargoBuscar2 = false;
    }

    // ============================================================================================================================
    // FUNCIONES ARRAY PARA AGREGAR BIENES
    // ============================================================================================================================

    public function agregar_bien(PatrimoniosBiene $ibien)
    {
        // Datos del bien
        $item = [
            'id' => $ibien->id,
            'codigo_barra' => $ibien->codigo_barra,
            'codigo_patrimonial' => $ibien->codigo_patrimonial,
            'descripcion' => $ibien->descripcion,
            'marca' => $ibien->marca,
            'modelo' => $ibien->modelo,
            'nro_serie' => $ibien->nro_serie,
            'medidas' => $ibien->medidas,
            'color' => $ibien->color,
            'estado' => $ibien->estado,
            'ip' => $ibien->ip,
            'datos_bien' => $ibien->descripcion ." | ". $ibien->marca ." | " . $ibien->modelo ." | " . $ibien->nro_serie ." | " . $ibien->medidas ." | " .$ibien->color ." | " . $ibien->estado,
        ];

        // Evitar duplicados (opcional)
        if (!collect($this->bienes)->contains('id', $ibien->id)) {
            $this->bienes[] = $item;
        }

        $this->reset('searchbienes');

        // CERRAR BUSCAR BIENES
        $this->modalPatrimonioBienesBuscar = false;
    }

    public function eliminarBien($index)
    {
        unset($this->bienes[$index]);
        $this->bienes = array_values($this->bienes); // reindexar
    }
}
