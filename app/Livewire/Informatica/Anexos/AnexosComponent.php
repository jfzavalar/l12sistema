<?php

namespace App\Livewire\Informatica\Anexos;

use App\Exports\TicketsfiltrosExport;
use App\Mail\NotificacionInformaticaTicket;
use App\Models\InformaticasFirmasToken;
use App\Models\InformaticasIp;
use App\Models\Ip;
use App\Models\Patrimonios_biene;
use App\Models\PatrimoniosBiene;
use App\Models\Persona;
use App\Models\Personale;
use App\Models\Personales_cargo;
use App\Models\Personales_dependencia;
use App\Models\Personales_despacho;
use App\Models\Personales_sede;
use App\Models\PersonalesAtencione;
use App\Models\PersonalesAtencionesIncidenciasSolicitudes;
use App\Models\PersonalesAtencionesServicio;
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

class AnexosComponent extends Component
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

    // VARIABLES PARA ADMINISTRAR MODALES
    public $colorHeaderModal, $textoHeaderModal;
    public $colorNuevoEditar, $textoNuevoEditar;
    public $colorGuardarActualizar, $textoGuardarActualizar;

    //VARIABLES PARA BLOQUEAR SECCIONES
    public $seccionFoto, $seccionPersona, $seccionPersonal;

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
        $this->resetPage('atencionesPage');
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

    public $pdf_acta;

    public $bandera_documento="EVIDENCIA";

    public function render()
    {
        return view('livewire.informatica.anexos.anexos-component');
    }
}
