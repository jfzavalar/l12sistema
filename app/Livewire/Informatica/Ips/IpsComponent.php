<?php

namespace App\Livewire\Informatica\Ips;

use App\Models\Ip;
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

    // Variables de búsqueda
    public $search, $searchi,$searchhistorial, $searchpersonas, $searchsedes,$searchdependencias,$searchdespachos,$searchcargos,
            $searchservicios,$searchincidenciasolicitud,$searchbienes;

    public function updatingSearch(){
        $this->resetPage('ipsPage');
    }

    // FILTROS
    public $filtro_estado,$filtrored,$filtroinformatico; // 1 = asignado, 0 = libre, null = todos

    

    public function filtrarTotal()
    {
        $this->resetFiltros();
    }

    public function filtrarAsignados()
    {
        $this->resetFiltros();
        $this->filtro_estado = 1;
    }

    public function filtrarLibres()
    {
        $this->resetFiltros();
        $this->filtro_estado = 0;
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
        $lista_activos = Ip::leftJoin('patrimonios_bienes','ips.ip','=','patrimonios_bienes.ip')
            ->select('ips.*',
                'patrimonios_bienes.codigo_patrimonial',
                'patrimonios_bienes.descripcion',
                'patrimonios_bienes.ubicac_fisica')
            ->where('ips.activo', 1)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('ips.grupo', 'like', '%' . $this->search . '%')
                    ->orWhere('ips.ip', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filtro_estado !== null, fn($q) =>
                $q->where('ips.estado', $this->filtro_estado)
            )
            ->when($this->filtrored, fn($q) => $q->where('ips.red', $this->filtrored))
            ->when($this->filtroinformatico, fn($q) => $q->where('ips.updated_user', $this->filtroinformatico))
            // ->when($this->filtrored !== null, fn($q) =>
            //     $q->where('ips.red', $this->filtrored)
            // )
            // ->when($this->filtroinformatico !== null, fn($q) =>
            //     $q->where('ips.updated_user', $this->filtroinformatico)
            // )
            ->orderBy('ips.ip')
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
}
