<?php

namespace App\Livewire\Informatica\Spijweb;

use App\Mail\NotificacionInformaticaSpijweb;
use App\Mail\NotificacionInformaticaSpijwebUserPass;
use App\Models\ContabilidadesGastosoperativosEntrega;
use App\Models\InformaticasSpijwebsEntrega;
use App\Models\Persona;
use App\Models\Personale;
use App\Models\Personales_cargo;
use App\Models\Personales_dependencia;
use App\Models\Personales_despacho;
use App\Models\Personales_sede;
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
use PhpOffice\PhpSpreadsheet\Calculation\Financial\CashFlow\Constant\Periodic\InterestAndPrincipal;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;

class SpijwebComponent extends Component
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
        $this->resetPage('spijwebPage');
    }
    public function updatingSearchi(){
        $this->resetPage('spijwebinactivosPage');
    }
    public function updatingSearchhistorial(){
        $this->resetPage('spijwebhistorialPage');
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
            $foto,$fotoactual,$inputFileKey;

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

    public $spijwebasignado_id,
            $anio,
            $enviarformatos,
            $enviarusuario,
            $usuario,
            $password,
            $ruta_evidencia,
            $ruta_documento,

            $informatico_dni,
            $informatico,
            $activo,
            $created_user,
            $updated_user;

    public $pdf_acta, $pdf_evidencia;

    public $enviar_a;



    // VARIABLES MODAL DE MOTIVO DE CAMBIO
    public $modal_abierto_alerta_cambio_estado = false;

    public $filtroanio;
    
    public function mount()
    {
        $this->filtroanio = now()->year;
    }


    public function render()
    {
        $lista_activos = InformaticasSpijwebsEntrega::where('activo',1)
            // BUSCADOR
            ->when($this->search, function ($query) {
                $search = trim($this->search);
                $query->where(function ($q) use ($search) {
                    $q->where('dni', 'like', '%' . $search . '%')
                    ->orWhere('datos', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('datos')
            ->paginate(30,['*'],'spijwebPage');

        $estadisticas = InformaticasSpijwebsEntrega::where('activo', 1)
            ->selectRaw("
                COUNT(*) as total,

                SUM(CASE
                    WHEN enviarformatos = 'SI'
                    THEN 1 ELSE 0
                END) as fasignados,

                SUM(CASE
                    WHEN enviarformatos = 'NO'
                    THEN 1 ELSE 0
                END) as fpendientes,

                SUM(CASE
                    WHEN enviarusuario = 'SI'
                    THEN 1 ELSE 0
                END) as uasignados,

                SUM(CASE
                    WHEN enviarusuario = 'NO'
                    THEN 1 ELSE 0
                END) as upendientes
            ")
            ->first();

        $aniosBD = DB::table('contabilidades_gastosoperativos_entregas')
            ->select('anio') // cambia 'fecha' por tu campo real
            ->distinct()
            ->pluck('anio')
            ->toArray();

        // AÑO ACTUAL
        $anioActual = Carbon::now()->year;

        // UNIR Y EVITAR DUPLICADOS
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

        $lista_informaticos = User::select('dni','datos','cargo')
            ->where('activo','1')
            ->where('cargo','INFORMATICO')
            ->orderBy('datos')
            ->get();

        return view('livewire.informatica.spijweb.spijweb-component',
                        compact('lista_activos','estadisticas','anios',
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

    // ============================================================================================================================
    // FUNCIONES CRUD
    // ============================================================================================================================

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

        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "NUEVO";
        $this->colorGuardarActualizar = "primary";
        $this->textoGuardarActualizar = "Guardar";
        $this->colorAgregar = "outline-primary";

        // ABRIR MODAL NUEVO - EDITAR
        $this->modalNuevoEditarAbrir = true;
    }

    public function guardar()
    {
        $this->validate([
            'dni' => 'required|digits:8',
        ]);

        try {

            $existe = InformaticasSpijwebsEntrega::where('dni', $this->dni)
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

                InformaticasSpijwebsEntrega::create([
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
                    'enviarformatos' => 0,
                    'enviarusuarios' => 0,

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

    public function enviar_acta1(InformaticasSpijwebsEntrega $instanciaTabla)
    {
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // Restablecer todas las variables
        $this->resetExcept(['filtro_anio', 'filtro_mes']);

        $this->foto = null;
        $this->fotoactual = null;
        $this->inputFileKey = rand();

        $this->funcionGuardarActualizar="enviar_acta2";

        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "ENVIAR FORMATOS";
        $this->colorGuardarActualizar = "primary";
        $this->textoGuardarActualizar = "Guardar y enviar";
        $this->colorAgregar = "outline-primary";

        // ASIGNAMOS LOS VALORES DEL REGISTRO
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
        $this->spijwebasignado_id = $instanciaTabla->id;
        $this->usuario = $instanciaTabla->usuario;
        $this->password = $instanciaTabla->password;

        // ABRIR MODAL NUEVO - EDITAR
        $this->modalNuevoEditarAbrir = true;
    }

    public function enviar_acta2()
    {
        try {

            $registro = InformaticasSpijwebsEntrega::findOrFail(
                $this->spijwebasignado_id
            );

            // Correo seleccionado para el envío
            $correo = trim($this->enviar_a);

            if (empty($correo)) {

                $this->dispatch(
                    'alerta-actualizado',
                    titulo: 'No se pudo enviar',
                    mensaje: 'Debe ingresar o seleccionar un correo electrónico.',
                    tipo: 'warning'
                );

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | ACTUALIZAR USUARIO Y PASSWORD
            |--------------------------------------------------------------------------
            */

            $registro->update([
                'usuario' => $this->usuario,
                'password' => $this->password,
            ]);

            /*
            |--------------------------------------------------------------------------
            | REFRESCAR EL REGISTRO
            |--------------------------------------------------------------------------
            |
            | De esta manera $registro contiene los datos recién actualizados.
            |
            */

            $registro->refresh();

            /*
            |--------------------------------------------------------------------------
            | ENVIAR CORREO
            |--------------------------------------------------------------------------
            */

            Mail::to($correo)->send(
                new NotificacionInformaticaSpijweb($registro)
            );

            /*
            |--------------------------------------------------------------------------
            | MARCAR COMO ENVIADO
            |--------------------------------------------------------------------------
            */

            $registro->update([
                'enviarformatos' => 'SI',
            ]);

            // Cerrar modal
            $this->modalNuevoEditarAbrir = false;

            // Limpiar variables
            $this->resetExcept([
                'filtro_anio',
                'filtro_mes'
            ]);

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Formato enviado',
                mensaje: 'El usuario y contraseña fueron actualizados y el PDF fue enviado correctamente al correo ' . $correo,
                tipo: 'success'
            );

        } catch (\Throwable $e) {

            \Log::error('Error al enviar formato PDF', [
                'id' => $this->spijwebasignado_id,
                'correo' => $this->enviar_a,
                'error' => $e->getMessage(),
            ]);

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Error',
                mensaje: 'No se pudo enviar el formato: ' . $e->getMessage(),
                tipo: 'error'
            );
        }
    }

    public function enviar_usuario1(InformaticasSpijwebsEntrega $instanciaTabla)
    {
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // Restablecer todas las variables
        $this->resetExcept(['filtro_anio', 'filtro_mes']);

        $this->foto = null;
        $this->fotoactual = null;
        $this->inputFileKey = rand();

        $this->funcionGuardarActualizar="enviar_usuario2";

        $this->colorHeaderModal = "success-subtle";
        $this->textoHeaderModal = "ENVIAR USUARIO";
        $this->colorGuardarActualizar = "success";
        $this->textoGuardarActualizar = "Guardar y enviar";
        $this->colorAgregar = "outline-success";

        // ASIGNAMOS LOS VALORES DEL REGISTRO
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
        $this->spijwebasignado_id = $instanciaTabla->id;
        $this->usuario = $instanciaTabla->usuario;
        $this->password = $instanciaTabla->password;

        // ABRIR MODAL NUEVO - EDITAR
        $this->modalNuevoEditarAbrir = true;
    }

    public function enviar_usuario2()
    {
        try {

            $registro = InformaticasSpijwebsEntrega::findOrFail(
                $this->spijwebasignado_id
            );

            // Correo seleccionado para el envío
            $correo = trim($this->enviar_a);

            if (empty($correo)) {

                $this->dispatch(
                    'alerta-actualizado',
                    titulo: 'No se pudo enviar',
                    mensaje: 'Debe ingresar o seleccionar un correo electrónico.',
                    tipo: 'warning'
                );

                return;
            }

            // Enviar correo con el PDF adjunto
            Mail::to($correo)->send(
                new NotificacionInformaticaSpijwebUserPass($registro)
            );

            // El correo fue enviado correctamente
            $registro->update([
                'enviarusuario' => 'SI',
            ]);

            // Cerrar modal
            $this->modalNuevoEditarAbrir = false;

            // Limpiar variables
            $this->resetExcept([
                'filtro_anio',
                'filtro_mes'
            ]);

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Credenciales',
                mensaje: 'Usuario y Password fue enviado correctamente al correo ' . $correo,
                tipo: 'success'
            );

        } catch (\Throwable $e) {

            \Log::error('Error al enviar formato PDF', [
                'id' => $this->spijwebasignado_id,
                'correo' => $this->enviar_a,
                'error' => $e->getMessage(),
            ]);

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Error',
                mensaje: 'No se pudo enviar el formato: ' . $e->getMessage(),
                tipo: 'error'
            );
        }
    }

    // ============================================================================================================================
    // GENERAL AÑO FISCAL
    // ============================================================================================================================

    public function generarListaDeEntregaDeSpijweb($soloNuevo = false, $personaId = null)
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

                'personales.codsedeorigen',
                'personales.sedeorigen',
                'personales.coddependenciaorigen',
                'personales.dependenciaorigen',
                'personales.coddespachoorigen',
                'personales.despachoorigen',

                'personales.codsededestino',
                'personales.sededestino',
                'personales.coddependenciadestino',
                'personales.dependenciadestino',
                'personales.coddespachodestino',
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
            $existe = InformaticasSpijwebsEntrega::where('persona_id', $persona->persona_id)
                ->where('anio', $anioActual)
                ->exists();

            if (!$existe) {
                InformaticasSpijwebsEntrega::create([
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

                    'codsedeorigen' => $persona->codsedorigen,
                    'sedorigen' => $persona->sedorigen,
                    'coddependenciorigen' => $persona->coddependenciorigen,
                    'dependenciorigen' => $persona->dependenciorigen,
                    'coddespachorigen' => $persona->coddespachorigen,
                    'despachorigen' => $persona->despachorigen,
                    
                    'codsededestino' => $persona->codsededestino,
                    'sededestino' => $persona->sededestino,
                    'coddependenciadestino' => $persona->coddependenciadestino,
                    'dependenciadestino' => $persona->dependenciadestino,
                    'coddespachodestino' => $persona->coddespachodestino,
                    'despachodestino' => $persona->despachodestino,

                    'regimen' => $persona->regimen,
                    'tipo_regimen' => $persona->tipo_regimen,
                    'cargo' => $persona->cargo,
                    'cargo_condicion' => $persona->cargo_condicion,

                    'anio' => Carbon::now()->year,
                    'enviarformatos' => "NO",
                    'enviarusuario' => "NO",
                    'usuario' => $persona->dni,
                    
                    'activo' => 1,
                    'created_user' => $usuario,
                    'updated_user' => $usuario,
                ]);
            }
        }
    }


    // ============================================================================================================================
    // MODALES CARGAR PDF
    // ============================================================================================================================

    public function editar_pdf($spijwebAsignadoId)
    {
        $this->spijwebasignado_id = $spijwebAsignadoId;

        $this->pdf_acta = null; // 🔥 CLAVE

        // ABRIR MODAL CARGAR PDF
        $this->modalPDFCargar = true;
    }
    
    public function actualizar_pdf()
    {
        // ===== DATOS DE LA INSTANCIA =====
        $iSpijwebAsignado = InformaticasSpijwebsEntrega::where('id', $this->spijwebasignado_id)->firstOrFail();
        
        // ===== VALIDAR SOLOR PDF =====
        $this->validate([
            'pdf_acta' => 'required|file|mimes:pdf|max:5120'
        ]);


        // ===== CARGAR PDF =====
        try {

            DB::transaction(function () use ($iSpijwebAsignado) {

                $usuario_id = auth()->user()->id;
                $usuario_dni = auth()->user()->dni;
                $usuario_datos = auth()->user()->datos;
                $usuario_cargo = auth()->user()->cargo;

                // UTILIZAR UNA FUNCIÓN PRIVADA PARA VERIFICAR SI EXISTE YA UN ARCHIVO Y ASIGNARLE EL MISMO NOMBRE
                $rutaDocumento = $this->validarActa();

                // ACTUALIZAR
                $iSpijwebAsignado->update([
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
        $iSpijwebAsignado = InformaticasSpijwebsEntrega::findOrFail($this->spijwebasignado_id);

        if (empty($iAnexoAsignado->ruta_documento)) {

            $nombreArchivo = 'acta_' . $iSpijwebAsignado->id . '_' .
                            $iSpijwebAsignado->dni . '.pdf';

            return $this->pdf_acta->storeAs(
                'informatica/spijweb/actas',
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
