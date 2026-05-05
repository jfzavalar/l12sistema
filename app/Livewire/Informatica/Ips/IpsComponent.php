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

    public function render()
    {
        $lista_activos = Ip::where('activo',1)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('grupo', 'like', '%' . $this->search . '%')
                    ->orWhere('ip', 'like', '%' . $this->search . '%');
                });
            })
            ->paginate(20, ['*'], 'ipsPage');

        return view('livewire.informatica.ips.ips-component',
                    compact('lista_activos'));
    }
}
