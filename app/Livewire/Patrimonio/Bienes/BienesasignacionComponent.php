<?php

namespace App\Livewire\Patrimonio\Bienes;

use App\Models\Patrimonios_biene;
use App\Models\PatrimoniosBiene;
use App\Models\PatrimoniosBienesAsignacione;
use App\Models\PatrimoniosBienesAsignacionesDetalle;
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

class BienesasignacionComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $habilitarInputs = "";
    public $mostrarBtnBuscarDni = "d-none";

    public $colorHeaderModal, $textoHeaderModal;
    public $colorNuevoEditar, $textoNuevoEditar;
    public $colorGuardarActualizar, $textoGuardarActualizar;
    public $colorAgregar;

    //Variables PARA OCULTAR Y MOSTRAR TXT_OTROS
    public $mostrarcargafoto = "d-none";

    //Variables bloquear de secciones
    public $seccionFoto = "disabled", $seccionPersona = "disabled", $seccionPersonal = "disabled";

    // Variable de función Guardar o Actualizar
    public $funcionGuardarActualizar;

    // Variables de búsqueda
    public $search, $searchlicencias,$searchrenuncias,$searchhistorial, $searchpersonas, $searchsedes,$searchdependencias,$searchdespachos,$searchcargos,$searchbienes;
    public function updatingSearch(){
        $this->resetPage('bienesasignacionPage');
    }
    public function updatingSearchrenuncias(){
        $this->resetPage('renunciasPage');
    }
    public function updatingSearchlicencias(){
        $this->resetPage('licenciasPage');
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
    public function updatingSearchbienes(){
        $this->resetPage('bienesPage');
    }

    Public $filtrosede, $filtrodependencia;
    public $filtrotipodocumento;
    public $filtroregimen;
    public $filtrocargo;

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
            $fot2o,$fotoactual2,$inputFileKey2,
            $activo2,
            $created_user2,
            $updated_user2,
            $created_at2,
            $updated_at2;

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

            $numero_convocatoria2,
            $tipo_documento2,
            $fecha_inicio2,
            $fecha_fin2,
            $ruta_documento2;

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

    public $pdf_acta;

    public $bienes = [];

    public function render()
    {
        $lista_activos = PatrimoniosBienesAsignacione::select(
                'id',
                'persona_id',
                'dni',
                'personal_id',
                'datos',
                'regimen',
                'cargo',
                'sede_id',
                'sede',
                'dependencia_id',
                'dependencia',
                'despacho_id',
                'persona_id2',
                'dni2',
                'personal_id2',
                'datos2',
                'regimen2',
                'cargo2',
                'sede_id2',
                'sede2',
                'dependencia_id2',
                'dependencia2',
                'despacho_id2',
                'despacho2',
                'bien_id',
                'cod',
                'cod_patrimonial',
                'bien',
                'ruta_documento',
                'activo',
                'created_user',
                'updated_user',
            )
            ->where('activo', "1")
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('dni2', 'like', '%' . $this->search . '%')
                    ->orWhere('datos2', 'like', '%' . $this->search . '%');
                });
            })
            // ->when($this->filtrosede, fn($q) => $q->where('personales.codsedeorigen', $this->filtrosede))
            // ->when($this->filtrodependencia, fn($q) => $q->where('personales.coddependenciaorigen', $this->filtrodependencia))
            // ->when($this->filtroregimen, fn($q) => $q->where('personales.regimen', 'like', '%' . $this->filtroregimen . '%'))
            // ->when($this->filtrocargo, fn($q) => $q->where('personales.cargo', '=', $this->filtrocargo))
            ->orderBy('id', 'desc')
            ->paginate(30, ['*'], 'bienesasignacionPage');

        $lista_personas = Persona::where('activo','1')
            ->when($this->searchpersonas !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->searchpersonas . '%')
                    ->orWhere('datos', 'like', '%' . $this->searchpersonas . '%');
                });
            })
            ->orderBy('datos')
            ->paginate(10,['*'],'personasPage');
        
        $lista_personas2 = Persona::where('activo','1')
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
            // ->distinct()
            ->orderBy('nombre')
            ->paginate(30,['*'], 'sedesPage');
            
        $lista_dependencias = Personales_dependencia::select('id','nombre')
            ->where('activo','1')
            ->where(function ($query) {
                $query->where('sede_id', $this->codsedeorigen)
                    ->orWhere('sede_id', $this->filtrosede);
            })
            ->where('nombre','like','%' . $this->searchdependencias . '%')
            ->orderBy('nombre')
            ->paginate(30,['*'], 'dependenciasPage');

        $lista_despachos = Personales_despacho::select('id','nombre')
            ->where('activo','1')
            ->where('nombre','like','%' . $this->searchdespachos . '%')
            ->distinct()
            ->orderBy('nombre')
            ->paginate(30,['*'], 'despachosPage');

        $lista_cargos = Personales_cargo::select('id','nombre')
            ->where('activo','1')
            ->where('nombre','like','%' . $this->searchcargos . '%')
            ->distinct()
            ->orderBy('nombre')
            ->paginate(30,['*'], 'cargosPage');

        $lista_cargos2 = Personales_cargo::select('id','nombre')
            ->where('activo','1')
            ->orderBy('nombre')
            ->get();

        $lista_bienes = Patrimonios_biene::where('activo','1')
            ->where('cod_patrimonial','like','%' . $this->searchbienes . '%')
            ->distinct()
            ->orderBy('bien')
            ->paginate(10,['*'],'bienesPage');

        return view('livewire.patrimonio.bienes.bienesasignacion-component',
                        compact('lista_activos',
                                    'lista_personas','lista_personas2','lista_sedes','lista_dependencias','lista_despachos','lista_cargos','lista_cargos2',
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

        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "Nuevo";
        $this->colorGuardarActualizar = "primary";
        $this->textoGuardarActualizar = "Guardar";
        $this->colorAgregar = "outline-primary";
    }

    public function guardar()
    {
        try {

            // ✅ Validación previa
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
                $iasignacion = PatrimoniosBienesAsignacione::create([
                    'persona_id' => $this->persona_id,
                    'dni' => $this->dni,
                    'personal_id' => $this->personal_id,
                    'datos' => $this->datos,
                    'regimen' => $this->regimen,
                    'cargo' => $this->cargo,
                    'sede_id' => $this->codsedeorigen,
                    'sede' => $this->sedeorigen,
                    'dependencia_id' => $this->coddependenciaorigen,
                    'dependencia' => $this->dependenciaorigen,
                    'despacho_id' => $this->coddespachoorigen,
                    'despacho' => $this->despachoorigen,

                    'persona_id2' => $this->persona_id2,
                    'dni2' => $this->dni2,
                    'personal_id2' => $this->personal_id2,
                    'datos2' => $this->datos2,
                    'regimen2' => $this->regimen2,
                    'cargo2' => $this->cargo2,
                    'sede_id2' => $this->codsedeorigen2,
                    'sede2' => $this->sedeorigen2,
                    'dependencia_id2' => $this->coddependenciaorigen2,
                    'dependencia2' => $this->dependenciaorigen2,
                    'despacho_id2' => $this->coddespachoorigen2,
                    'despacho2' => $this->despachoorigen2,

                    'activo' => "1",
                    'created_user' => $usuario,
                    'updated_user' => $usuario,
                ]);

                // ✅ Preparar datos
                $detalles = [];
                $ids = [];

                foreach ($this->bienes as $bien) {

                    // Validación básica
                    if (!isset($bien['id'], $bien['cod'], $bien['cod_patrimonial'], $bien['bien'])) {
                        continue;
                    }

                    $detalles[] = [
                        'asignacion_id' => $iasignacion->id,
                        'bien_id' => $bien['id'],
                        'cod' => $bien['cod'],
                        'cod_patrimonial' => $bien['cod_patrimonial'],
                        'bien' => $bien['bien'],
                        'created_user' => $usuario,
                        'updated_user' => $usuario,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

                    $ids[] = $bien['id'];
                }

                // ✅ Insertar detalles
                if (!empty($detalles)) {
                    PatrimoniosBienesAsignacionesDetalle::insert($detalles);
                }

                // ✅ Actualizar estado (1 solo query)
                if (!empty($ids)) {

                    $updated = PatrimoniosBiene::whereIn('id', $ids)
                        ->where('asignacion', '!=', 'ASIGNADO')
                        ->update(['asignacion' => 'ASIGNADO']);

                    // 🔥 Control de concurrencia
                    if ($updated !== count($ids)) {
                        throw new \Exception('Algunos bienes ya fueron asignados.');
                    }
                }
            });

            // ✅ Reset
            $this->reset();

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
                mensaje: $e->getMessage(), // 👈 ahora muestra el error real
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

        $this->reset('searchpersonas');
    }

    public function agregar_persona2(Persona $ipersona){
        $this->persona_id2 = $ipersona->id;
        $this->dni2 = $ipersona->dni;
        $this->appaterno2 = $ipersona->appaterno;
        $this->apmaterno2 = $ipersona->apmaterno;
        $this->nombres2 = $ipersona->nombres;

        $this->datos2 = $ipersona->datos;

        $this->celpersonal2 = $ipersona->celpersonal;
        $this->correopersonal2 = $ipersona->correopersonal;

        $this->fotoactual2 = $ipersona->foto;

        $ipersonal = Personale::where([['activo',1],['persona_dni',$this->dni2],])->firstOrFail();

        $this->sedeorigen2 = $ipersonal->sedeorigen;
        $this->dependenciaorigen2 = $ipersonal->dependenciaorigen;
        $this->despachoorigen2 = $ipersonal->despachoorigen;
        $this->celinstitucional2 = $ipersonal->celinstitucional;
        $this->correoinstitucional2 = $ipersonal->correoinstitucional;
        $this->regimen2 = $ipersonal->regimen;
        $this->tipo_regimen2 = $ipersonal->tipo_regimen;
        $this->cargo2 = $ipersonal->cargo;

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
    public function agregar_sede2(Personales_sede $isede)
    {
        // $this->codsedeorigen = $isede->id;
        // $this->sedeorigen = $isede->nombre;

        $this->codsededestino = $isede->id;
        $this->sededestino = $isede->nombre;

        $this->reset(['dependenciadestino','despachodestino']);

        $this->reset(['searchdependencias','searchdespachos']);
    }

    public function agregar_dependencia(Personales_dependencia $idependencia)
    {
        // $this->coddependenciaorigen = $idependencia->id;
        // $this->dependenciaorigen = $idependencia->nombre;

        $this->coddependenciadestino = $idependencia->id;
        $this->dependenciadestino = $idependencia->nombre;

        $this->reset('despachodestino');

        $this->reset('searchdespachos');
    }
    public function agregar_dependencia2(Personales_dependencia $idependencia)
    {
        // $this->coddependenciaorigen = $idependencia->id;
        // $this->dependenciaorigen = $idependencia->nombre;

        $this->coddependenciadestino = $idependencia->id;
        $this->dependenciadestino = $idependencia->nombre;

        // $this->reset('despachoorigen');

        $this->reset('searchdespachos');
    }

    public function agregar_despacho(Personales_despacho $idespacho)
    {
        $this->coddespachoorigen = $idespacho->id;
        $this->despachoorigen = $idespacho->nombre;

        $this->coddespachodestino = $idespacho->id;
        $this->despachodestino = $idespacho->nombre;
    }
    public function agregar_despacho2(Personales_despacho $idespacho)
    {
        // $this->coddespachoorigen = $idespacho->id;
        // $this->despachoorigen = $idespacho->nombre;

        $this->coddespachodestino = $idespacho->id;
        $this->despachodestino = $idespacho->nombre;
    }

    public function agregar_cargo(Personales_cargo $icargo)
    {
        $this->cargo = $icargo->nombre;
    }

    public function agregar_bien(patrimonios_biene $ibien)
    {
        // Datos del bien
        $item = [
            'id' => $ibien->id,
            'cod' => $ibien->cod,
            'cod_patrimonial' => $ibien->cod_patrimonial,
            'bien' => $ibien->bien,
            'marca' => $ibien->marca,
            'modelo' => $ibien->modelo,
            'serie' => $ibien->serie,
            'medida' => $ibien->medida,
            'color' => $ibien->color,
            'estado' => $ibien->estado,
            'ip' => $ibien->ip,
            'datos_bien' => $ibien->bien ." | ". $ibien->marca ." | " . $ibien->modelo ." | " . $ibien->serie ." | " . $ibien->medida ." | " .$ibien->color ." | " . $ibien->estado,
        ];

        // Evitar duplicados (opcional)
        if (!collect($this->bienes)->contains('id', $ibien->id)) {
            $this->bienes[] = $item;
        }

        $this->reset('searchbienes');
    }

    public function eliminarBien($index)
    {
        unset($this->bienes[$index]);
        $this->bienes = array_values($this->bienes); // reindexar
    }
}
