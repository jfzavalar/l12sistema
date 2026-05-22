<?php

namespace App\Livewire\Informatica\Ips;

use App\Models\InformaticasIp;
use App\Models\Patrimonios_biene;
use App\Models\PatrimoniosBiene;
use App\Models\Persona;
use App\Models\Personale;
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

class IpsComponent extends Component
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

    public $codigo_patrimonial,
        $descripcion,
        $marca,
        $modelo,
        $nro_serie,
        $color,
        $estado,
        $bien_ip;

    // Variables de búsqueda
    public $search, $searchi,$searchhistorial, $searchpersonas, $searchsedes,$searchdependencias,$searchdespachos,$searchcargos,
            $searchservicios,$searchincidenciasolicitud,$searchbienes;

    public function updatingSearch(){
        $this->resetPage('ipsPage');
    }

    // FILTROS
    public $filtro_estado,$filtrored,$filtroinformatico; // 1 = asignado, 0 = libre, null = todos

    

    public function filtrarTotal($value)
    {
        $this->resetFiltros();
        $this->filtrored = trim($value);
        $this->resetPage(); // si usas paginación
    }

    public function filtrarAsignados($value)
    {
        $this->resetFiltros();
        $this->filtrored = trim($value);
        $this->filtro_estado = 1;
        $this->resetPage(); // si usas paginación
    }

    public function filtrarLibres($value)
    {
        $this->resetFiltros();
        $this->filtrored = trim($value);
        $this->filtro_estado = 0;
        $this->resetPage(); // si usas paginación
    }

    private function resetFiltros()
    {
        $this->search = null;
        $this->filtro_estado = null;
        $this->filtrored = null;
        $this->filtroinformatico = null;
        $this->resetPage('ipsPage');
    }

    public function render()
    {
        $lista_activos = InformaticasIp::where('activo', 1)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('codigo_patrimonial', 'like', '%' . $this->search . '%')
                    ->orWhere('ip', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filtro_estado !== null, fn($q) =>
                $q->where('estado', $this->filtro_estado)
            )
            ->when($this->filtrored, fn($q) => $q->where('red', $this->filtrored))
            ->when($this->filtroinformatico, fn($q) => $q->where('updated_user', $this->filtroinformatico))
            ->orderByRaw('INET_ATON(ip)')
            ->paginate(20, ['*'], 'ipsPage');
        
        $reportes = InformaticasIp::select('red')
            ->selectRaw("COUNT(*) as total")
            ->selectRaw("SUM(estado = 1) as asignados")
            ->selectRaw("SUM(estado = 0) as libres")
            ->where('activo', 1)
            // ->whereNotNull('updated_user') // 🔥 clave
            ->groupBy('red')
            ->orderBy('red')
            ->get();

        $estadisticas = InformaticasIp::select('updated_user')
            ->selectRaw("COUNT(*) as total")
            ->selectRaw("SUM(estado = 1) as asignados")
            ->where('activo', 1)
            ->whereNotNull('updated_user') // 🔥 clave
            ->groupBy('updated_user')
            ->orderBy('updated_user')
            ->get();

        $estadisticas2 = InformaticasIp::where('activo', '1')
            ->selectRaw("
                COUNT(*) as total,
                SUM(estado = '1') as asignados,
                SUM(estado = '0') as libres
            ")
            ->first();

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
            ->where('personales.tipo_documento','CONTRATO')
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

        $lista_bienes = PatrimoniosBiene::where('activo','1')
            ->where('codigo_patrimonial','like','%' . $this->searchbienes . '%')
            ->distinct()
            ->orderBy('descripcion')
            ->paginate(10,['*'],'bienesPage');
        
        $lista_redes = InformaticasIp::select('red')
            ->where('activo','1')
            ->distinct()
            ->get();

        $lista_informaticos = InformaticasIp::select('updated_user')
            ->where('activo','1')
            ->whereNotNull('updated_user') // 🔥 clave
            ->distinct()
            ->get();

        return view('livewire.informatica.ips.ips-component',
                    compact('lista_activos','reportes','estadisticas','estadisticas2',
                            'lista_personas','lista_bienes','lista_redes','lista_informaticos'));
    }

    public function nuevo_asignar_ip(InformaticasIp $iip)
    {
        $this->resetValidation();
        $this->resetErrorBag();

        $this->funcionGuardarActualizar = "guardar_asignar_ip";

        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "Editar";
        $this->colorGuardarActualizar = "primary";
        $this->textoGuardarActualizar = "Actualizar";
        $this->colorAgregar = "outline-primary";

        $this->bien_ip = $iip->ip;
    }

    public function guardar_asignar_ip()
    {

    }

    public function editar_asignar_ip(InformaticasIp $iip)
    {
        $this->resetValidation();
        $this->resetErrorBag();

        $this->funcionGuardarActualizar = "actualizar_asignar_ip";

        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "success-subtle";
        $this->textoHeaderModal = "Editar";
        $this->colorGuardarActualizar = "success";
        $this->textoGuardarActualizar = "Actualizar";
        $this->colorAgregar = "outline-success";

        $this->bien_ip = $iip->ip;
    }

    public function actualizar_asignar_ip()
    {

    }

    public function cerrar()
    {

        $this->reset();
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

        // $this->reset('searchpersonas');
    }

    public function ver_personal($codigo_patrimonial)
    {

        $this->mostrarBtnBuscarDni = "d-none";
        $this->mostrarcontroles = "d-none";

        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "USUARIO DEL EQUIPO INFORMATICO";
        $this->colorGuardarActualizar = "primary";
        $this->textoGuardarActualizar = "Guardar";
        $this->colorAgregar = "outline-primary";

        $ibien = Patrimonios_biene::where('activo',1)->where('codigo_patrimonial',$codigo_patrimonial)->first();

        $this->codigo_patrimonial = $ibien->codigo_patrimonial;
        $this->descripcion = $ibien->descripcion;
        $this->marca = $ibien->marca;
        $this->modelo = $ibien->modelo;
        $this->nro_serie = $ibien->nro_serie;
        $this->color = $ibien->color;
        $this->estado = $ibien->estado;
        $this->ip = $ibien->ip;

        // ===== DATOS PERSONA =====
        $ipersona = Persona::where('dni', $ibien->usuario_dni)->where('activo','1')->firstOrFail();
        $this->persona_id = $ipersona->id;
        $this->dni = $ipersona->dni;
        $this->nombres = $ipersona->nombres;
        $this->appaterno = $ipersona->appaterno;
        $this->apmaterno = $ipersona->apmaterno;
        $this->celpersonal = $ipersona->celpersonal;
        $this->correopersonal = $ipersona->correopersonal;
        $this->datos = $ipersona->datos;

        $this->fotoactual = $ipersona->foto;

        // // ===== DATOS PERSONAL =====
        $ipersonal = Personale::where('persona_dni', $ibien->usuario_dni)->where('activo','1')->firstOrFail();

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
            'datos_bien' => $ibien->descripcion ." | ". $ibien->marca ." | " . $ibien->modelo ." | " . $ibien->nro_serie ." | " . $ibien->medidas ." | " .$ibien->color ." | " . $ibien->estado,
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

                'codsedeorigen' => $personal->codsedeorigen,
                'sedeorigen' => $personal->sedeorigen,
                'coddependenciaorigen' => $personal->coddependenciaorigen,
                'dependenciaorigen' => $personal->dependenciaorigen,
                'coddespachoorigen' => $personal->coddespachoorigen,
                'despachoorigen' => $personal->despachoorigen,

                'codsededestino' => $personal->codsededestino,
                'sededestino' => $personal->sededestino,
                'coddependenciadestino' => $personal->coddependenciadestino,
                'dependenciadestino' => $personal->dependenciadestino,
                'coddespachodestino' => $personal->coddespachodestino,
                'despachodestino' => $personal->despachodestino,

                'celinstitucional' => $personal->celinstitucional,
                'correoinstitucional' => $personal->correoinstitucional,
                'regimen' => $personal->regimen,
                'tipo_regimen' => $personal->tipo_regimen,
                'cargo' => $personal->cargo,
            ]);
        }

        $this->reset('searchbienes');
    }
}
