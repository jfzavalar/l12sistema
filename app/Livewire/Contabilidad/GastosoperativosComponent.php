<?php

namespace App\Livewire\Contabilidad;

use App\Models\ContabilidadesGastosoperativosEntrega;
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
use Maatwebsite\Excel\Facades\Excel;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;

class GastosoperativosComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $colorHeaderModal, $textoHeaderModal;
    public $colorNuevoEditar, $textoNuevoEditar;
    public $colorGuardarActualizar, $textoGuardarActualizar;
    public $colorAgregar;
    public $funcionGuardarActualizar;
    public $seccionPersona, $seccionPersonal;

    // VARIABLE DE BUSQUEDA
    public $search, $searchi,$searchhistorial, $searchpersonas, $searchsedes,$searchdependencias,$searchdespachos,$searchcargos;

    public function updatingSearch(){
        $this->resetPage('gastosoperativosentregaPage');
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

    //VARIABLES COMUNES
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

    public $contabilidades_gastosoperativos_entrega_id,
            $anio,
            $enero,
            $febrero,
            $marzo,
            $abril,
            $mayo,
            $junio,
            $julio,
            $agosto,
            $septiembre,
            $octubre,
            $noviembre,
            $diciembre;

    public $mes,
            $mes_observacion;


    // VARIABLES MODAL DE MOTIVO DE CAMBIO
    public $modal_abierto_alerta_cambio_estado = false;

    public $filtroanio;
    
    public function mount()
    {
        $this->filtroanio = now()->year;
    }

    public function render()
    {
        $lista_activos = ContabilidadesGastosoperativosEntrega::where('activo','1')
            // BUSCADOR
            ->when($this->search, function ($query) {
                $search = trim($this->search);
                $query->where(function ($q) use ($search) {
                    $q->where('dni', 'like', '%' . $search . '%')
                    ->orWhere('datos', 'like', '%' . $search . '%');
                });

            })
            ->orderBy('datos')
            ->paginate(30, ['*'], 'gastosoperativosentregaPage');

        $aniosBD = DB::table('contabilidades_gastosoperativos_entregas')
            ->select('anio') // cambia 'fecha' por tu campo real
            ->distinct()
            ->pluck('anio')
            ->toArray();

        // Año actual
        $anioActual = Carbon::now()->year;

        // Unir y evitar duplicados
        $anios = collect($aniosBD)
            ->push($anioActual)
            ->unique()
            ->sortDesc()
            ->values();

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

        $aniosBD = DB::table('contabilidades_gastosoperativos_entregas')
            ->select('anio') // cambia 'fecha' por tu campo real
            ->distinct()
            ->pluck('anio')
            ->toArray();

        return view('livewire.contabilidad.gastosoperativos-component',
                        compact('lista_activos','anios',
                            'lista_personas','lista_sedes','lista_dependencias','lista_despachos','lista_cargos',));
    }

    private function queryConFiltros($tipoDocumento = null)
    {
        return Persona::join('personales', 'personas.id', '=', 'personales.persona_id')
            ->join('contabilidades_gastosoperativos_entregas', 'personas.id', '=', 'contabilidades_gastosoperativos_entregas.persona_id')
            ->select(
                'personas.*',
                'personales.persona_id',
                'personales.celinstitucional',
                'personales.correoinstitucional',
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
                'contabilidades_gastosoperativos_entregas.id as gastosoperativos_id',
                'contabilidades_gastosoperativos_entregas.anio',
                'contabilidades_gastosoperativos_entregas.enero',
                'contabilidades_gastosoperativos_entregas.febrero',
                'contabilidades_gastosoperativos_entregas.marzo',
                'contabilidades_gastosoperativos_entregas.abril',
                'contabilidades_gastosoperativos_entregas.mayo',
                'contabilidades_gastosoperativos_entregas.junio',
                'contabilidades_gastosoperativos_entregas.julio',
                'contabilidades_gastosoperativos_entregas.agosto',
                'contabilidades_gastosoperativos_entregas.septiembre',
                'contabilidades_gastosoperativos_entregas.octubre',
                'contabilidades_gastosoperativos_entregas.noviembre',
                'contabilidades_gastosoperativos_entregas.diciembre',
            )
            ->where('personales.activo', 1)
            ->where('personales.cargo', 'like', 'FISCAL' . '%')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('personas.dni', 'like', '%' . $this->search . '%')
                    ->orWhere('personas.datos', 'like', '%' . $this->search . '%');
                });
            });
    }

    public function nuevo()
    {
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        $this->funcionGuardarActualizar="guardar";

        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "NUEVO";
        $this->colorGuardarActualizar = "primary";
        $this->textoGuardarActualizar = "Guardar";
        $this->colorAgregar = "outline-primary";
    }

    public function guardar()
    {
        $this->validate([
            'dni' => 'required|digits:8',
        ]);

        try {

            $existe = ContabilidadesGastosoperativosEntrega::where('dni', $this->dni)
                ->where('anio', Carbon::now()->year)
                ->exists();

            if ($existe) {
                $this->dispatch(
                    'alerta-actualizado',
                    titulo: 'Registro duplicado',
                    mensaje: 'El DNI ya tiene un registro para el año actual.',
                    tipo: 'warning'
                );

                return;
            }

            DB::transaction(function () {

                $usuario_datos = auth()->user()->datos;

                ContabilidadesGastosoperativosEntrega::create([
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
                    'personal_id' => $this->personal_id,
                    'regimen' => $this->regimen,
                    'tipo_regimen' => $this->tipo_documento,
                    'cargo' => $this->cargo,
                    'cargo_condicion' => $this->cargo_condicion,
                    'sede' => $this->sededestino,
                    'dependencia' => $this->dependenciadestino,
                    'despacho' => $this->despachodestino,
                    'anio' => Carbon::now()->year,
                    'enero' => 0,
                    'febrero' => 0,
                    'marzo' => 0,
                    'abril' => 0,
                    'mayo' => 0,
                    'junio' => 0,
                    'julio' => 0,
                    'agosto' => 0,
                    'septiembre' => 0,
                    'octubre' => 0,
                    'noviembre' => 0,
                    'diciembre' => 0,
                    'activo' => 1,
                    'created_user' => $usuario_datos,
                    'updated_user' => $usuario_datos,
                ]);
            });

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Proceso completado',
                mensaje: 'Se guardó correctamente.',
                tipo: 'success'
            );

            $this->dispatch('cerrar-modal', id: 'nuevoEditarModal');

        } catch (\Throwable $e) {
            dd($e);
        }
    }

    public function cerrar()
    {

    }

    //GENERAR AÑO FISCAL
    public function generarListaDeEntregaDeGastosOperativos($soloNuevo = false, $personaId = null)
    {
        $usuario = auth()->user()->datos; // Mejor que usar propiedad pública    
        
        $anioActual = Carbon::now()->year;

        $query = Persona::join('personales', 'personas.id', '=', 'personales.persona_id')
            ->select(
                'personas.id as persona_id',
                'personas.dni',
                'personas.appaterno',
                'personas.apmaterno',
                'personas.nombres',
                'personas.datos',
                'personas.celpersonal',
                'personales.celinstitucional',
                'personas.correopersonal',
                'personales.correoinstitucional',

                'personales.id as personal_id',
                'personales.regimen',
                'personales.tipo_regimen',
                'personales.cargo',
                'personales.cargo_condicion',
                // 'personales.sedeorigen',
                // 'personales.dependenciaorigen',
                // 'personales.despachoorigen',
                'personales.sededestino',
                'personales.dependenciadestino',
                'personales.despachodestino',
                'personales.tipo_documento'
            )
            ->where('personales.activo', 1)
            ->where('personales.cargo', 'like', 'FISCAL%');

        // 👉 Si solo quieres el nuevo fiscal
        if ($soloNuevo && $personaId) {
            $query->where('personas.id', $personaId);
        }

        $personas = $query->get();

        foreach ($personas as $persona) {

            // 🔒 Evitar duplicados por persona + año
            $existe = ContabilidadesGastosoperativosEntrega::where('persona_id', $persona->persona_id)
                ->where('anio', $anioActual)
                ->exists();

            if (!$existe) {
                ContabilidadesGastosoperativosEntrega::create([
                    'persona_id' => $persona->persona_id,
                    'dni' => $persona->dni,
                    'appaterno' => $persona->appaterno,
                    'apmaterno' => $persona->apmaterno,
                    'nombres' => $persona->nombres,
                    'datos' => $persona->datos,
                    'celpersonal' => $persona->celpersonal,
                    'celinstitucional' => $persona->celinstitucional,
                    'correopersonal' => $persona->correopersonal,
                    'correoinstitucional' => $persona->correoinstitucional,

                    'personal_id' => $persona->personal_id,
                    'regimen' => $persona->regimen,
                    'tipo_regimen' => $persona->tipo_documento,
                    'cargo' => $persona->cargo,
                    'cargo_condicion' => $persona->cargo_condicion,
                    'sede' => $persona->sededestino,
                    'dependencia' => $persona->dependenciadestino,
                    'despacho' => $persona->despachodestino,

                    'anio' => Carbon::now()->year,
                    'enero' => 0,
                    'febrero' => 0,
                    'marzo' => 0,
                    'abril' => 0,
                    'mayo' => 0,
                    'junio' => 0,
                    'julio' => 0,
                    'agosto' => 0,
                    'septiembre' => 0,
                    'octubre' => 0,
                    'noviembre' => 0,
                    'diciembre' => 0,
                    'activo' => 1,
                    'created_user' => $usuario,
                    'updated_user' => $usuario,
                ]);
            }
        }
    }

    // ACTUALIZAR LOS ESTADOS DE ENTREGADO

    public function editar_entregado(ContabilidadesGastosoperativosEntrega $registro, $mes)
    {
        $this->modal_abierto_alerta_cambio_estado = true;

        $this->contabilidades_gastosoperativos_entrega_id = $registro->id;
        $this->mes = $mes;

        // Obtener observación según el mes
        $columnaObservacion = 'm' . $mes;

        $this->mes_observacion = $registro->{$columnaObservacion};
    }

    public function actualizar_entregado()
    {
        $registro = ContabilidadesGastosoperativosEntrega::find(
            $this->contabilidades_gastosoperativos_entrega_id
        );

        if (!$registro) {
            return;
        }

        try {

            $mesesPermitidos = [
                'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio',
                'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre',
            ];

            $columnaObservacion = 'm' . $this->mes;

            if (!in_array($this->mes, $mesesPermitidos)) {
                return;
            }

            $registro->update([
                $this->mes => $registro->{$this->mes} == 1 ? 0 : 1,
                $columnaObservacion => $this->mes_observacion,
            ]);

            $this->modal_abierto_alerta_cambio_estado = false;

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Proceso completado',
                mensaje: 'Se actualizó correctamente.',
                tipo: 'success'
            );

            $this->dispatch('cerrar-modal', id: 'nuevoEditarModal');

        } catch (\Throwable $e) {
            dd($e);
        }
    }


    public function cerrar_alerta_cambio_estado()
    {
        $this->modal_abierto_alerta_cambio_estado = false;
    }


    // FUNCIONES AGREGAR
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

}