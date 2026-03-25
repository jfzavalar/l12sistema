<?php

namespace App\Livewire\Rrhh\Personal;

use App\Models\Persona;
use App\Models\Personale;
use App\Models\Personales_cargo;
use App\Models\Personales_dependencia;
use App\Models\Personales_despacho;
use App\Models\Personales_sede;
use App\Models\PersonalesRotacione;
use App\Models\Tbl_cargo;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PersonalrotacionComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

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

    Public $filtrosede, $filtrodependencia;
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

    public $rotacion_id,
            $num_expediente,
            $fecha_iniciou,
            $fecha_finu,
            $motivo_ubicacion;

    public $pdf_acta;

    public $bandera_documento="CONTRATO";

    public function mount()
    {
        $this->inputFileKey = rand();
    }

    //FUNCIONES EN TIEMPO REAL
    public function updatedRegimen($value)
    {
        if ($value === 'D.L.728') {
            $this->tipo_regimen = 'INDETERMINADO';
            $this->fecha_fin = '3000-12-31';
        } elseif ($value === 'D.L.276') {
            $this->tipo_regimen = 'INDETERMINADO';
            $this->fecha_fin = '3000-12-31';
        } else {
            $this->tipo_regimen = 'TRANSITORIO';
            $this->fecha_fin = null;
        }
    }
    public function updatedTipoRegimen($value)
    {
        if ($value === 'INDETERMINADO') {
            $this->fecha_fin = '3000-12-31';
        } else {
            $this->fecha_fin = null;
        }
    }

    public function render()
    {
        $lista_activos = Persona::join('personales', 'personas.id', '=', 'personales.persona_id')
            ->join('personales_rotaciones','personas.id','=','personales_rotaciones.persona_id')
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
            ->where('personales_rotaciones.activo', '1')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('personas.dni', 'like', '%' . $this->search . '%')
                    ->orWhere('personas.datos', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filtrodependencia, function ($query) {
                $query->where(function ($q) {
                    $q->where('personales.coddependenciaorigen', $this->filtrodependencia );
                    // ->orWhere('', 'like', '%' . $this->search . '%');
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
            ->paginate(30, ['personas.*'], 'personalesPage');

        $lista_inactivos = Persona::join('personales', 'personas.id', '=', 'personales.persona_id')
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

        $lista_historial_rotaciones = Persona::join('personales_rotaciones', 'personas.id', '=', 'personales_rotaciones.persona_id')
            ->select('personas.*',
                'personales_rotaciones.id as personal_id',
                'personales_rotaciones.persona_id',
                'personales_rotaciones.sede',
                'personales_rotaciones.dependencia',
                'personales_rotaciones.despacho',
                'personales_rotaciones.num_expediente',
                'personales_rotaciones.motivo_ubicacion',
                'personales_rotaciones.fecha_iniciou',
                'personales_rotaciones.fecha_finu',
                'personales_rotaciones.ruta_documento')
            ->where('personales_rotaciones.persona_dni', $this->dni)
            // ->when($this->searchhistorial, function ($query) {
            //     $query->where(function ($q) {
            //         $q->where('personales.numero_convocatoria', 'like', '%' . $this->searchhistorial . '%')
            //         ->orWhere('personales.tipo_documento', 'like', '%' . $this->searchhistorial . '%');
            //     });
            // })
            ->orderByDesc('id')
            ->paginate(10, ['*'], 'historialrotacionesPage');

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
            ->paginate(10,['*'], 'dependenciasPage');

        $lista_despachos = Personales_despacho::select('id','nombre')
            ->where('activo','1')
            ->where('nombre','like','%' . $this->searchdespachos . '%')
            ->distinct()
            ->orderBy('nombre')
            ->paginate(10,['*'], 'despachosPage');

        $lista_sedes2 = Personales_sede::select('id','nombre','nombred')
            ->where('activo','1')
            ->where('nombre','like','%' . $this->searchsedes . '%')
            // ->distinct()
            ->orderBy('nombre')
            ->paginate(30,['*'], 'sedesPage');
            
        $lista_dependencias2 = Personales_dependencia::select('id','nombre')
            ->where('activo','1')
            ->where(function ($query) {
                $query->where('sede_id', $this->codsededestino)
                    ->orWhere('sede_id', $this->filtrosede);
            })
            ->where('nombre','like','%' . $this->searchdependencias . '%')
            ->orderBy('nombre')
            ->paginate(10,['*'], 'dependenciasPage');

        $lista_despachos2 = Personales_despacho::select('id','nombre')
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

        return view('livewire.rrhh.personal.personalrotacion-component',
                        compact('lista_activos','lista_inactivos','lista_historial_rotaciones',
                                    'lista_personas','lista_sedes','lista_dependencias','lista_despachos','lista_cargos',
                                    'lista_sedes2','lista_dependencias2','lista_despachos2'));
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
            
            'sededestino' => 'required',
            'dependenciadestino' => 'required',
            'despachodestino' => 'required',
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

        'sededestino.required' => 'Campo requierido',
        'dependenciadestino.required' => 'Campo requierido',
        'despachodestino.required' => 'Campo requierido',
    ];

    public function nuevo()
    {
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // Restablecer todas las variables
        // $this->reset();

        $this->funcionGuardarActualizar="guardar";

        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "Nuevo ubicación de personal";
        $this->colorGuardarActualizar = "primary";
        $this->textoGuardarActualizar = "Guardar";
        $this->colorAgregar = "outline-primary";

        $this->codsededestino = "";
        $this->sededestino = "";
        $this->coddependenciadestino = "";
        $this->dependenciadestino = "";
        $this->coddespachodestino = "";
        $this->despachodestino = "";

        $this->bandera_documento = "RESOLUCION";
    }

    public function guardar()
    {
        $this->validate();

        try {

            DB::transaction(function () {

                $usuario = auth()->user()->datos;

                // Buscar Personal
                // ===== DATOS PERSONAL =====
                $personal = Personale::where([['activo',"1"],['persona_dni', $this->dni],])->firstOrFail();

                // Actualizar Personal
                $personal->update([
                    'codsededestino' => $this->codsededestino,
                    'sededestino' => $this->sededestino,
                    'coddependenciadestino' => $this->coddependenciadestino,
                    'dependenciadestino' => $this->dependenciadestino,
                    'coddespachodestino' => $this->coddespachodestino,
                    'despachodestino' => $this->despachodestino,
                    'updated_user' => $usuario,
                ]);

                $ipersonalrotacion = PersonalesRotacione::where([['activo',"1"],['persona_dni', $this->dni],])->first();

                if ($ipersonalrotacion) {
                    $ipersonalrotacion->update([
                        'activo' => "0",
                    ]);
                }

                // FUNCIÓN PARA CARGAR DOCUMENTO
                $rutaDocumento = $this->guardar_acta();

                //Insertar datos en la tabla historial ubicaciones
                PersonalesRotacione::create([
                    'persona_id' => $personal->persona_id,
                    'persona_dni' => $personal->persona_dni,
                    'personal_id' => $personal->id,
                    'sede_id' => $this->codsededestino,
                    'sede' => $this->sededestino,
                    'dependencia_id' => $this->coddependenciadestino,
                    'dependencia' => $this->dependenciadestino,
                    'despacho_id' => $this->coddespachodestino,
                    'despacho' => $this->despachodestino,
                    'num_expediente' => $this->num_expediente,
                    'fecha_iniciou' => $this->fecha_iniciou,
                    'fecha_finu' => $this->fecha_finu,
                    'motivo_ubicacion' => $this->motivo_ubicacion,
                    'ruta_documento' => $rutaDocumento,
                    'activo' => "1",
                    'created_user' => $usuario,
                    'updated_user' => $usuario,
                ]);

            });

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
                mensaje: 'Ocurrió un error al actualizar.',
                tipo: 'error'
            );
        }
    }

    public function editar(Persona $ipersona)
    {
        $this->resetValidation();
        $this->resetErrorBag();

        $this->funcionGuardarActualizar = "actualizar";

        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "success-subtle";
        $this->textoHeaderModal = "Editar rotación";
        $this->colorGuardarActualizar = "success";
        $this->textoGuardarActualizar = "Actualizar rotacion";
        $this->colorAgregar = "outline-success";

        $this->persona_id = $ipersona->id;
        $this->dni = $ipersona->dni;
        $this->nombres = $ipersona->nombres;
        $this->appaterno = $ipersona->appaterno;
        $this->apmaterno = $ipersona->apmaterno;
        $this->celpersonal = $ipersona->celpersonal;
        $this->correopersonal = $ipersona->correopersonal;
        $this->fotoactual = $ipersona->foto;

        // ===== DATOS PERSONAL =====
        $ipersonal = Personale::where('persona_dni', $this->dni)->where('activo','1')->firstOrFail();

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

        // $this->codsededestino = $ipersonal->codsededestino;
        // $this->sededestino = $ipersonal->sededestino;
        // $this->coddependenciadestino = $ipersonal->coddependenciadestino;
        // $this->dependenciadestino = $ipersonal->dependenciadestino;
        // $this->coddespachodestino = $ipersonal->coddespachodestino;
        // $this->despachodestino = $ipersonal->despachodestino;

        $this->celinstitucional = $ipersonal->celinstitucional;
        $this->correoinstitucional = $ipersonal->correoinstitucional;

        // ===== DATOS PERSONAL =====
        $ipersonalrotacion = PersonalesRotacione::where('persona_id', $this->persona_id)
            ->where('activo', '1')
            ->first();

        if (!$ipersonalrotacion) {
            session()->flash('error', 'No se encontró la rotación activa');
            return;
        }

        $this->rotacion_id = $ipersonalrotacion->id;
        $this->dni = $ipersonalrotacion->persona_dni;
        $this->personal_id = $ipersonalrotacion->personal_id;
        $this->codsededestino = $ipersonalrotacion->sede_id;
        $this->sededestino = $ipersonalrotacion->sede;
        $this->coddependenciadestino = $ipersonalrotacion->dependencia_id;
        $this->dependenciadestino = $ipersonalrotacion->dependencia;
        $this->coddespachodestino = $ipersonalrotacion->despacho_id;
        $this->despachodestino = $ipersonalrotacion->despacho;
        $this->num_expediente = $ipersonalrotacion->num_expediente;
        $this->fecha_iniciou = $ipersonalrotacion->fecha_iniciou;
        $this->fecha_finu = $ipersonalrotacion->fecha_finu;
        $this->motivo_ubicacion = $ipersonalrotacion->motivo_ubicacion;
        $this->ruta_documento = $ipersonalrotacion->ruta_documento;
        
    }

    public function actualizar()
    {
        $this->validate();

        try {

            DB::transaction(function () {

                $usuario = auth()->user()->datos;

                // Buscar Personal
                // ===== DATOS PERSONAL =====
                $personal = Personale::where([['activo',"1"],['persona_dni', $this->dni],])->firstOrFail();

                // Actualizar Personal
                $personal->update([
                    'codsededestino' => $this->codsededestino,
                    'sededestino' => $this->sededestino,
                    'coddependenciadestino' => $this->coddependenciadestino,
                    'dependenciadestino' => $this->dependenciadestino,
                    'coddespachodestino' => $this->coddespachodestino,
                    'despachodestino' => $this->despachodestino,
                    'updated_user' => $usuario,
                ]);

                // Llamamos a la función privada para cargar documento
                $rutaDocumento = $this->actualizar_acta();

                // ===== DATOS DE LA ROTACION =====
                $ipersonalrotacion = PersonalesRotacione::findOrFail($this->rotacion_id);
                $ipersonalrotacion->update([
                    'sede_id' => $this->codsededestino,
                    'sede' => $this->sededestino,
                    'dependencia_id' => $this->coddependenciadestino,
                    'dependencia' => $this->dependenciadestino,
                    'despacho_id' => $this->coddespachodestino,
                    'despacho' => $this->despachodestino,
                    'num_expediente' => $this->num_expediente,
                    'fecha_iniciou' => $this->fecha_iniciou,
                    'fecha_finu' => $this->fecha_finu,
                    'motivo_ubicacion' => $this->motivo_ubicacion,
                    'ruta_documento' => $rutaDocumento,
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

        } catch (\Throwable $e) {

            report($e);

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Error',
                mensaje: 'Ocurrió un error al actualizar.',
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

        // $this->reset('searchpersonas');
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


    // FUNCIONES PARA NUEVOS DOCUMENTOS


    public function nuevo_adenda(Persona $ipersona)
    {
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // RESTABLECER VARIABLES
        $this->reset();

        $this->funcionGuardarActualizar="guardar_adenda";

        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "ADENDA";
        $this->colorGuardarActualizar = "primary";
        $this->textoGuardarActualizar = "Guardar adenda";
        $this->colorAgregar = "outline-primary";

        // ===== BLOQUEO DE SECCIONES =====
        $this->seccionFoto = "disabled";
        $this->seccionPersona = "disabled";
        $this->seccionPersonal = "disabled";

        $this->bandera_documento = "CONTRATO";

        // DATOS PERSONA
        $this->ver_persona($ipersona);

        // DATOS PERSONAL
        $ipersonal = Personale::where([['activo',"1"],['persona_dni', $this->dni],])->firstOrFail();

        $this->ver_personal($ipersonal);
        
        $this->tipo_documento = "ADENDA";
        $this->fecha_inicio = $ipersonal->fecha_fin
            ? Carbon::parse($ipersonal->fecha_fin)->addDay()->format('Y-m-d')
            : null;
        $this->fecha_fin = "";
    }

    public function guardar_adenda()
    {
        $this->validate();

        try {

            DB::transaction(function () {
                $ipersonal = Personale::where('id', $this->personal_id)->firstOrFail();

                // Actualizar Personal
                $ipersonal->update([
                    'activo' => "0",
                ]);

                // FUNCIÓN PARA CARGAR DOCUMENTO
                $rutaDocumento = $this->guardar_acta();

                // GUARDAR CAMPOS DE PERSONAL
                $this->guardar_personal($rutaDocumento);
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

    public function nuevo_renuncia(Persona $ipersona)
    {
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // Restablecer todas las variables
        // $this->reset();

        $this->funcionGuardarActualizar="guardar_renuncia";

        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "dark-subtle";
        $this->textoHeaderModal = "RENUNCIA";
        $this->colorGuardarActualizar = "dark";
        $this->textoGuardarActualizar = "Guardar renuncia";
        $this->colorAgregar = "outline-dark";

        // ===== BLOQUEO DE SECCIONES =====
        $this->seccionFoto = "disabled";
        $this->seccionPersona = "disabled";
        $this->seccionPersonal = "disabled";

        $this->bandera_documento = "CONTRATO";

        // DATOS PERSONA
        $this->ver_persona($ipersona);

        // DATOS PERSONAL
        $ipersonal = Personale::where([['activo',"1"],['persona_dni', $this->dni],])->firstOrFail();

        $this->ver_personal($ipersonal);

        $this->tipo_documento = "RENUNCIA";
        
        $this->fecha_inicio = $ipersonal->fecha_inicio;
    }

    public function guardar_renuncia()
    {
        $this->validate();

        try {

            DB::transaction(function () {
                $usuario = auth()->user()->datos; // Mejor que usar propiedad pública

                $ipersonal = Personale::where('id', $this->personal_id)->firstOrFail();

                // Actualizar Personal
                $ipersonal->update([
                    'fecha_fin' => $this->fecha_fin,
                    'activo' => "0",
                ]);

                // FUNCIÓN PARA CARGAR DOCUMENTO
                $rutaDocumento = $this->guardar_acta();

                // GUARDAR CAMPOS DE PERSONAL
                $this->guardar_personal($rutaDocumento);
            });

            $this->resetExcept('searchPersonal');

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

    public function nuevo_licencia(Persona $ipersona)
    {
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // Restablecer todas las variables
        // $this->reset();

        $this->funcionGuardarActualizar="guardar_licencia";

        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "danger-subtle";
        $this->textoHeaderModal = "LICENCIA";
        $this->colorGuardarActualizar = "danger";
        $this->textoGuardarActualizar = "Guardar licencia";
        $this->colorAgregar = "outline-danger";

        // ===== BLOQUEO DE SECCIONES =====
        $this->seccionFoto = "disabled";
        $this->seccionPersona = "disabled";
        $this->seccionPersonal = "disabled";

        $this->bandera_documento = "CONTRATO";

        // DATOS PERSONA
        $this->ver_persona($ipersona);

        // DATOS PERSONAL
        $ipersonal = Personale::where([['activo',"1"],['persona_dni', $this->dni],])->firstOrFail();

        $this->ver_personal($ipersonal);

        $this->tipo_documento = "LICENCIA";
        
        $this->fecha_inicio = $ipersonal->fecha_inicio;
    }

    public function guardar_licencia()
    {
        $this->validate();

        try {

            DB::transaction(function () {
                $usuario = auth()->user()->datos; // Mejor que usar propiedad pública

                $ipersonal = Personale::where('id', $this->personal_id)->firstOrFail();

                // Actualizar Personal
                $ipersonal->update([
                    'fecha_fin' => $this->fecha_fin,
                    'activo' => "0",
                ]);

                // FUNCIÓN PARA CARGAR DOCUMENTO
                $rutaDocumento = $this->guardar_acta();

                // GUARDAR CAMPOS DE PERSONAL
                $this->guardar_personal($rutaDocumento);
            });

            $this->resetExcept('searchPersonal');

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

    public function nuevo_contrato(Persona $ipersona)
    {
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // Restablecer todas las variables
        // $this->reset();

        $this->funcionGuardarActualizar="guardar_contrato";

        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "info-subtle";
        $this->textoHeaderModal = "CONTRATO";
        $this->colorGuardarActualizar = "info";
        $this->textoGuardarActualizar = "Guardar contrato";
        $this->colorAgregar = "outline-info";

        // ===== BLOQUEO DE SECCIONES =====
        $this->seccionFoto = "disabled";
        $this->seccionPersona = "disabled";
        $this->seccionPersonal = "";

        $this->bandera_documento = "CONTRATO";

        /// DATOS PERSONA
        $this->ver_persona($ipersona);

        // DATOS PERSONAL
        $ipersonal = Personale::where([['activo',"1"],['persona_dni', $this->dni],])->firstOrFail();

        $this->ver_personal($ipersonal);

        $this->tipo_documento = "CONTRATO";

        $this->personal_id = $ipersonal->id;
    }

    public function guardar_contrato()
    {
        $this->validate();

        try {

            DB::transaction(function () {
                $ipersonal = Personale::where('id', $this->personal_id)->firstOrFail();

                // Actualizar Personal
                $ipersonal->update([
                    'activo' => "0",
                ]);

                // FUNCIÓN PARA CARGAR DOCUMENTO
                $rutaDocumento = $this->guardar_acta();

                // GUARDAR CAMPOS DE PERSONAL
                $this->guardar_personal($rutaDocumento);
            });

            $this->resetExcept('searchPersonal');

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

    public function nuevo_incorporacion(Persona $ipersona)
    {
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // Restablecer todas las variables
        // $this->reset();

        $this->funcionGuardarActualizar="guardar_incorporacion";

        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "danger-subtle";
        $this->textoHeaderModal = "INCORPORACIÓN";
        $this->colorGuardarActualizar = "danger";
        $this->textoGuardarActualizar = "Guardar incorporación";
        $this->colorAgregar = "outline-danger";

        // ===== BLOQUEO DE SECCIONES =====
        $this->seccionFoto = "disabled";
        $this->seccionPersona = "disabled";
        $this->seccionPersonal = "disabled";

        $this->bandera_documento = "CONTRATO";

        /// DATOS PERSONA
        $this->ver_persona($ipersona);

        // DATOS PERSONAL
        $ipersonal = Personale::where([['activo',"1"],['persona_dni', $this->dni],])->firstOrFail();

        $this->ver_personal($ipersonal);

        $this->tipo_documento = "INCORPORACION";

        $this->personal_id = $ipersonal->id;
    }

    public function guardar_incorporacion()
    {
        $this->validate();

        try {

            DB::transaction(function () {
                $ipersonal = Personale::where('id', $this->personal_id)->firstOrFail();

                // Actualizar Personal
                $ipersonal->update([
                    'activo' => "0",
                ]);

                // FUNCIÓN PARA CARGAR DOCUMENTO
                $rutaDocumento = $this->guardar_acta();

                // GUARDAR CAMPOS DE PERSONAL
                $this->guardar_personal($rutaDocumento);
            });

            $this->resetExcept('searchPersonal');

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

    // FUNCIONES DE HISTORIAL
    public function historial_documentos($persona_dni)
    {
        $this->dni = $persona_dni;
    }

    public function historial_rotaciones($persona_dni)
    {
        $this->dni = $persona_dni;
    }


    // FUNCIONES PARA CARGAR PDF


    public function editar_pdf($personal_id)
    {
        $this->personal_id = $personal_id;
    }

    public function actualizar_pdf()
    {
        // ===== DATOS PERSONAL =====
        $ipersonal = Personale::where('id', $this->personal_id)->firstOrFail();

        $this->tipo_documento = $ipersonal->tipo_documento;
        $this->numero_convocatoria = $ipersonal->numero_convocatoria;
        
        // Validar solo el PDF
        $this->validate([
            'pdf_acta' => 'required|file|mimes:pdf|max:5120'
        ]);

        try {

            DB::transaction(function () use ($ipersonal) {

                $usuario = auth()->user()->datos;

                // Ruta actual
                $rutaDocumento = $this->actualizar_acta();

                $ipersonal->update([
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



    // FUNCIONES PRIVADAS PARA REUTILIZAR

    private function ver_persona(Persona $ipersona)
    {
        $this->persona_id = $ipersona->id;

        $this->dni = $ipersona->dni;
        $this->nombres = $ipersona->nombres;
        $this->appaterno = $ipersona->appaterno;
        $this->apmaterno = $ipersona->apmaterno;
        $this->celpersonal = $ipersona->celpersonal;
        $this->correopersonal = $ipersona->correopersonal;

        $this->fotoactual = $ipersona->foto;
    }

    private function ver_personal(Personale $ipersonal){
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

        $this->numero_convocatoria = $ipersonal->numero_convocatoria;
    }

    private function guardar_personal($rutaDocumento)
    {
        $usuario = auth()->user()->datos; // Mejor que usar propiedad pública

        Personale::create([
            'persona_id' => $this->persona_id,
            'persona_dni' => $this->dni,

            'regimen' => $this->regimen,
            'tipo_regimen' => $this->tipo_regimen,
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

            'celinstitucional' => $this->celinstitucional,
            'correoinstitucional' => $this->correoinstitucional,

            'numero_convocatoria' => strtoupper($this->numero_convocatoria),
            'tipo_documento' => strtoupper($this->tipo_documento),
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,

            // 🔥 Guardamos la ruta real del archivo
            'ruta_documento' => $rutaDocumento,

            'activo' => '1',
            'created_user' => $usuario,
            'updated_user' => $usuario,
        ]);
    }

    private function guardar_acta()
    {
        if (!$this->pdf_acta) {
            return null;
        }

        if($this->bandera_documento === "CONTRATO"){
            $fileName =
            now()->timestamp . '_'
            . $this->dni . '_'
            . Str::slug($this->tipo_documento) . '_'
            . Str::slug($this->numero_convocatoria) 
            . '.pdf';

            return $this->pdf_acta->storeAs(
                'archivos/rrhh/personal/contratos',
                $fileName,
                'public'
            );
        }else{
            $fileName =
            now()->timestamp . '_'
            . $this->dni . '_'
            . Str::slug($this->num_expediente) . '_'
            . Str::slug($this->numero_convocatoria) 
            . '.pdf';

            return $this->pdf_acta->storeAs(
                'archivos/rrhh/personal/traslados',
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
        $ipersonal = Personale::findOrFail($this->personal_id);

        $rutaDocumento = $ipersonal->ruta_documento;

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
