<?php

namespace App\Livewire\Informatica\Ips;

use App\Models\Ip;
use App\Models\Patrimonios_biene;
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
        $ip;

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
        $lista_activos = Ip::where('ips.activo', 1)
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
        
        $reportes = Ip::select('red')
            ->selectRaw("COUNT(*) as total")
            ->selectRaw("SUM(estado = 1) as asignados")
            ->selectRaw("SUM(estado = 0) as libres")
            ->where('activo', 1)
            // ->whereNotNull('updated_user') // 🔥 clave
            ->groupBy('red')
            ->orderBy('red')
            ->get();

        $estadisticas = Ip::select('updated_user')
            ->selectRaw("COUNT(*) as total")
            ->selectRaw("SUM(estado = 1) as asignados")
            ->where('activo', 1)
            ->whereNotNull('updated_user') // 🔥 clave
            ->groupBy('updated_user')
            ->orderBy('updated_user')
            ->get();

        $estadisticas2 = Ip::where('activo', '1')
            ->selectRaw("
                COUNT(*) as total,
                SUM(estado = '1') as asignados,
                SUM(estado = '0') as libres
            ")
            ->first();
        
        $lista_redes = Ip::select('red')
            ->where('activo','1')
            ->distinct()
            ->get();

        $lista_informaticos = Ip::select('updated_user')
            ->where('activo','1')
            ->whereNotNull('updated_user') // 🔥 clave
            ->distinct()
            ->get();

        return view('livewire.informatica.ips.ips-component',
                    compact('lista_activos','reportes','estadisticas','estadisticas2','lista_redes','lista_informaticos'));
    }

    public function cerrar()
    {

        // $this->dispatch(
        //         'alerta-cancelar',
        //         titulo: 'Cancelar',
        //         mensaje: 'Se canceló la operación.',
        //         tipo: 'error'
        //     );
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
}
