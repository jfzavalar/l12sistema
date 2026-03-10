<?php

namespace App\Livewire\Informatica;

use App\Models\InformaticasSoporte;
use App\Models\Patrimonios_biene;
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

class SoporteComponent extends Component
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
    public $mostrarotrosp = "d-none", $mostrarotrosc = "d-none";

    //Variables bloquear de secciones
    public $seccionFoto="disabled", $seccionPersona="disabled", $seccionPersonal="disabled",$seccionBienpatrimonial="disabled";

    // Variable de función Guardar o Actualizar
    public $funcionGuardarActualizar;

    // Variables de búsqueda
    public $search, $searchi,$searchpersonal,$searchhistorial, $searchpersonas, $searchsedes,$searchdependencias,$searchdespachos,$searchcargos,
            $searchbienes;
    public function updatingSearch(){
        $this->resetPage('bienesPage');
    }
    public function updatingSearchpersonal(){
        $this->resetPage('personalesPage');
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

    public $soporte_id,
            $preventivo,
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
            $recomendacion_usuario;

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
            $familia;

    public $pdf;

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

    public function render()
    {
        $lista_activos = Persona::join('personales', 'personas.id', '=', 'personales.persona_id')
            ->join('informaticas_soportes','personas.id','=','informaticas_soportes.persona_id')
            ->join('patrimonios_bienes','informaticas_soportes.bien_id','patrimonios_bienes.id')
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
                'informaticas_soportes.id as soporte_id',
                'informaticas_soportes.bien_cod_patrimonial',
                'informaticas_soportes.ruta_documento',
                'patrimonios_bienes.bien')
            ->where('personales.activo', 1)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('personas.dni', 'like', '%' . $this->search . '%')
                    ->orWhere('personas.datos', 'like', '%' . $this->search . '%')
                    ->orWhere('informaticas_soportes.bien_cod_patrimonial', 'like', '%' . $this->search . '%');
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
            ->distinct()
            ->paginate(10, ['personas.*'], 'personalesPage');

        $lista_personas = Persona::where('activo','1')
            ->when($this->searchpersonas !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->searchpersonas . '%')
                    ->orWhere('datos', 'like', '%' . $this->searchpersonas . '%');
                });
            })
            ->orderBy('datos')
            ->paginate(10,['*'],'personasPage');

        $lista_sedes = Personales_sede::select('id','nombre')
            ->where('activo','1')
            ->where('nombre','like','%' . $this->searchsedes . '%')
            ->distinct()
            ->orderBy('nombre')
            ->paginate(10,['*'], 'sedesPage');
            
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

        $lista_bienes = Patrimonios_biene::where('activo','1')
            ->where('cod_patrimonial','like','%' . $this->searchbienes . '%')
            ->distinct()
            ->orderBy('bien')
            ->paginate(10,['*'],'bienesPage');

        return view('livewire.informatica.soporte-component',
                        compact('lista_activos','lista_personas','lista_sedes','lista_dependencias','lista_despachos','lista_cargos',
                                    'lista_bienes'));
    }

    protected function rules(){
        return [
                    'dni' => 'required',
            'nombres' => 'required',
            'appaterno' => 'required',
            'apmaterno' => 'required',

            'sedeorigen' => 'required',
            'dependenciaorigen' => 'required',
            'despachoorigen' => 'required',
            'regimen' => 'required',
            'cargo' => 'required',

            'pdf' => 'nullable|file|mimes:pdf|max:5120', // 5MB
        ];
    }

    protected $messages = [
        'dni.required' => 'El dni es obligatorio.',
        'nombres.required' => 'Campo requerido',
        'appaterno.required' => 'Campo requerido',
        'apmaterno.required' => 'Campo requerido',

        'sedeorigen.required' => 'Campo requerido',
        'dependenciaorigen.required' => 'Campo requerido',
        'despachoorigen.required' => 'Campo requerido',
        'regimen.required' => 'Campo requerido',
        'cargo.required' => 'Campo requerido',

        'pdf.mimes' => 'Solo se permiten archivos PDF.',
        'pdf.max' => 'El archivo no debe superar 5MB.',
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
        $this->textoHeaderModal = "NUEVO";
        $this->colorGuardarActualizar = "primary";
        $this->textoGuardarActualizar = "Guardar";
        $this->colorAgregar = "outline-primary";

        // $this->tipo_documento = "CONTRATO";

        // ===== BLOQUEO DE SECCIONES =====
        $this->seccionFoto = "disabled";
        $this->seccionPersona = "disabled";
        $this->seccionPersonal = "disabled";
        $this->seccionPersonal = "disabled";
    }

    public function guardar()
    {
        $this->validate();
        
        try {

            DB::transaction(function () {

                $usuario = auth()->user()->datos; // Mejor que usar propiedad pública

                // GUARDAR CAMPOS DE SOPORTE

                $persona = InformaticasSoporte::create([
                    'bien_id' => $this->bien_id,
                    'bien_cod' => $this->cod,
                    'bien_cod_patrimonial' => $this->cod_patrimonial,
                    'persona_id' => $this->persona_id,
                    'persona_dni' => $this->dni,
                    'persona_datos' => $this->datos,
                    'personal_id' => $this->personal_id,
                    'preventivo' => $this->preventivo,
                    'p01' => $this->p01,
                    'p02' => $this->p02,
                    'p03' => $this->p03,
                    'p04' => $this->p04,
                    'p05' => $this->p05,
                    'p06' => $this->p06,
                    'p07' => $this->p07,
                    'potros' => strtoupper($this->potros),
                    'correctivo' => $this->correctivo,
                    'c01' => $this->c01,
                    'c02' => $this->c02,
                    'c03' => $this->c03,
                    'c04' => $this->c04,
                    'c05' => $this->c05,
                    'c06' => $this->c06,
                    'c07' => $this->c07,
                    'cotros' => strtoupper($this->cotros),
                    'operativo' => $this->operativo,
                    'observacion_usuario' => strtoupper($this->observacion_usuario),
                    'recomendacion_usuario' => strtoupper($this->recomendacion_usuario),

                    'activo' => '1',
                    'created_user' => $usuario,
                    'updated_user' => $usuario,
                ]);
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

    public function editar($soporte_id)
    {
        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // Restablecer todas las variables
        $this->reset();
        $this->foto = null;
        $this->fotoactual = null;
        $this->inputFileKey = rand();

        $this->funcionGuardarActualizar="actualizar";

        $this->mostrarotrosp = "";
        $this->mostrarotrosc = "";

        $this->colorHeaderModal = "success-subtle";
        $this->textoHeaderModal = "EDITAR";
        $this->colorGuardarActualizar = "success";
        $this->textoGuardarActualizar = "Actualizar";
        $this->colorAgregar = "outline-success";

        // $this->tipo_documento = "CONTRATO";

        // ===== BLOQUEO DE SECCIONES =====
        $this->seccionFoto = "disabled";
        $this->seccionPersona = "disabled";
        $this->seccionPersonal = "disabled";
        $this->seccionPersonal = "disabled";

        // ===== DATOS SOPORTE =====
        $isoporte = InformaticasSoporte::findOrFail($soporte_id);

        $this->soporte_id = $isoporte->id;
        $this->bien_id = $isoporte->bien_id;
        $this->cod = $isoporte->bien_cod;
        $this->persona_id = $isoporte->persona_id;
        $this->datos = $isoporte->persona_datos;
        $this->personal_id = $isoporte->personal_id;
        

        $this->p01 = (bool) $isoporte->p01;
        $this->p02 = (bool) $isoporte->p02;
        $this->p03 = (bool) $isoporte->p03;
        $this->p04 = (bool) $isoporte->p04;
        $this->p05 = (bool) $isoporte->p05;
        $this->p06 = (bool) $isoporte->p06;
        $this->p07 = (bool) $isoporte->p07;
        $this->potros = $isoporte->potros;

        $this->c01 = (bool) $isoporte->c01;
        $this->c02 = (bool) $isoporte->c02;
        $this->c03 = (bool) $isoporte->c03;
        $this->c04 = (bool) $isoporte->c04;
        $this->c05 = (bool) $isoporte->c05;
        $this->c06 = (bool) $isoporte->c06;
        $this->c07 = (bool) $isoporte->c07;
        $this->cotros = $isoporte->cotros;
        $this->observacion_usuario = $isoporte->observacion_usuario;
        $this->recomendacion_usuario = $isoporte->recomendacion_usuario;
        

        $this->cod_patrimonial = $isoporte->bien_cod_patrimonial;

        // ===== DATOS PERSONA =====
        $ipersona = Persona::where('id', $isoporte->persona_id)->where('activo','1')->firstOrFail();

        $this->persona_id = $isoporte->ipersona_id;
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

        // ===== DATOS BIEN PATRIMONIAL =====

        $ibien = Patrimonios_biene::where('id', $isoporte->bien_id)->where('activo','1')->firstOrFail();

        $this->cod_patrimonial = $ibien->cod_patrimonial;
        $this->bien = $ibien->bien;
        $this->marca = $ibien->marca;
        $this->modelo = $ibien->modelo;
        $this->serie = $ibien->serie;
        $this->medida = $ibien->medida;
        $this->color = $ibien->color;
        $this->estado = $ibien->estado;
    }

    public function actualizar()
    {
        $this->validate();

        try {

            DB::transaction(function () {

                $usuario = auth()->user()->datos;

                // ========================
                // ACTUALIZAR SOPORTE
                // ========================
                $soporte = InformaticasSoporte::findOrFail($this->soporte_id);

                $soporte->update([
                    'bien_id' => $this->bien_id,
                    'bien_cod' => $this->cod,
                    'bien_cod_patrimonial' => $this->cod_patrimonial,
                    'persona_id' => $this->persona_id,
                    'persona_dni' => $this->dni,
                    'persona_datos' => $this->datos,
                    'personal_id' => $this->personal_id,
                    'preventivo' => $this->preventivo,
                    'p01' => $this->p01,
                    'p02' => $this->p02,
                    'p03' => $this->p03,
                    'p04' => $this->p04,
                    'p05' => $this->p05,
                    'p06' => $this->p06,
                    'p07' => $this->p07,
                    'potros' => strtoupper($this->potros),
                    'correctivo' => $this->correctivo,
                    'c01' => $this->c01,
                    'c02' => $this->c02,
                    'c03' => $this->c03,
                    'c04' => $this->c04,
                    'c05' => $this->c05,
                    'c06' => $this->c06,
                    'c07' => $this->c07,
                    'cotros' => strtoupper($this->cotros),
                    'operativo' => $this->operativo,
                    'observacion_usuario' => strtoupper($this->observacion_usuario),
                    'recomendacion_usuario' => strtoupper($this->recomendacion_usuario),

                    'activo' => '1',
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

        $this->reset('searchpersonas');
    }

    public function agregar_bien(patrimonios_biene $ibien)
    {
        $this->bien_id = $ibien->id;
        $this->cod = $ibien->cod;
        $this->cod_patrimonial = $ibien->cod_patrimonial;
        $this->bien = $ibien->bien;
        $this->marca = $ibien->marca;
        $this->modelo = $ibien->modelo;
        $this->serie = $ibien->serie;
        $this->medida = $ibien->medida;
        $this->color = $ibien->color;
        $this->estado = $ibien->estado;

        $this->reset('searchbienes');
    }


    // FUNCIONES CARGAR PDF
    public function editar_pdf($soporte_id)
    {
        $this->soporte_id = $soporte_id;
    }
    public function actualizar_pdf()
    {
        // ===== DATOS PERSONAL =====
        $isoporte = InformaticasSoporte::findOrFail($this->soporte_id);
        
        // Validar solo el PDF
        $this->validate([
            'pdf' => 'required|file|mimes:pdf|max:5120'
        ]);

        try {

            DB::transaction(function () use ($isoporte) {

                $usuario = auth()->user()->datos;

                // Ruta actual
                $rutaDocumento = $isoporte->ruta_documento;

                if ($this->pdf) {

                    // Eliminar anterior si existe
                    if ($rutaDocumento &&
                        Storage::disk('public')->exists($rutaDocumento)) {

                        Storage::disk('public')->delete($rutaDocumento);
                    }

                    // Generar nombre limpio
                    $fileName = str_replace(now()->format('Ymd'), '_',
                        $isoporte->bien_cod_patrimonial . '_' .
                        $isoporte->persona_dni . '_' 
                    ) . '.pdf';

                    // Guardar archivo
                    $rutaDocumento = $this->pdf->storeAs(
                        'archivos/informatica/soporte',
                        $fileName,
                        'public'
                    );

                    // Actualizar solo si se subió archivo
                    $isoporte->update([
                        'ruta_documento' => $rutaDocumento,
                        'updated_user' => $usuario,
                    ]);
                }

            });

            $this->reset('pdf');

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
}
