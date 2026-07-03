<?php

namespace App\Livewire\Intranet\Atenciones;

use App\Models\PersonalesAtencionesIncidenciasSolicitudes;
use App\Models\PersonalesAtencionesServicio;
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


class ServiciosdetallesComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    // VARIABLES DE TABLE SERVICIO
    public $servicio_id, 
            $servicio;

    // VARIABLES DE TABLA SERVICIO DETALLE
    public $incidencia_solicitud_id,
            $incidencia_solicitud_servicio_id,
            $incidencia_solicitud_tipo,
            $incidencia_solicitud_tipo_desc,
            $incidencia_solicitud_servicio,
            $incidencia_solicitud,
            $incidencia_solicitud_respuesta,
            $incidencia_solicitud_activo;

    // VARIABLES DE BUSQUEDA
    public $searchservicios, 
            $searchserviciosdetalles;

    public function updatingSearchservicios(){
        $this->resetPage('serviciosPage');
    }
    public function updatingSearchserviciosdetalles(){
        $this->resetPage('serviciosdetallesPage');
    }

    // VARIABLES DE MODAL
    public $modal_abierto_servicio = false,
            $modal_abierto_servicio_detalle = false;

    public $colorHeaderModal, $textoHeaderModal;
    public $colorBotonGuardarActualizar, $textoBotonGuardarActualizar;

    public function render()
    {
        $lista_servicios = PersonalesAtencionesServicio::where('activo',1)
                            // BUSCADOR
                            ->when($this->searchservicios, function ($query) {

                                $searchservicios = trim($this->searchservicios);

                                $query->where(function ($q) use ($searchservicios) {

                                    $q->where('servicio', 'like', '%' . $searchservicios . '%');
                                });

                            })
                            ->orderBy('servicio')
                            ->paginate(15,['*'],'serviciosPage');
        
        $lista_servicios_detalles = PersonalesAtencionesIncidenciasSolicitudes::where('activo',1)
                            ->where('servicio_id',$this->incidencia_solicitud_servicio_id)
                            // BUSCADOR
                            ->when($this->searchserviciosdetalles, function ($query) {

                                $searchserviciosdetalles = trim($this->searchserviciosdetalles);

                                $query->where(function ($q) use ($searchserviciosdetalles) {

                                    $q->where('incidencia_solicitud', 'like', '%' . $searchserviciosdetalles . '%');
                                });

                            })
                            ->orderBy('incidencia_solicitud')
                            ->paginate(15,['*'],'serviciosdetallesPage');

        return view('livewire.intranet.atenciones.serviciosdetalles-component',
                        compact('lista_servicios','lista_servicios_detalles'));
    }

    public function nuevo_servicio()
    {
        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "NUEVO SERVICIO";

        $this->colorBotonGuardarActualizar = "primary";
        $this->textoBotonGuardarActualizar = "Guardar servicio";

        // RESTABLECER VARIABLES
        $this->reset(
            'servicio_id',
            'servicio',
        );

        $this->modal_abierto_servicio = true;
    }

    public function editar_servicio(PersonalesAtencionesServicio $iservicio)
    {
        $this->colorHeaderModal = "success-subtle";
        $this->textoHeaderModal = "EDITAR SERVICIO";

        $this->colorBotonGuardarActualizar = "success";
        $this->textoBotonGuardarActualizar = "Actualizar servicio";

        $this->modal_abierto_servicio = true;

        $this->servicio_id = $iservicio->id;
        $this->servicio = $iservicio->servicio;
    }

    public function cerrar_nuevo_servicio()
    {
        $this->modal_abierto_servicio = false;
    }





    public function nuevo_servicio_detalle()
    {
        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "NUEVO INCIDENCIA / SOLICITUD";

        $this->colorBotonGuardarActualizar = "primary";
        $this->textoBotonGuardarActualizar = "Guardar incidencia / solicitud";

        // RESTABLECER VARIABLES
        $this->reset(
            'incidencia_solicitud_id',
            // 'incidencia_solicitud_servicio_id',  
            'incidencia_solicitud_tipo',
            'incidencia_solicitud_tipo_desc',
            // 'incidencia_solicitud_servicio',
            'incidencia_solicitud',
            'incidencia_solicitud_respuesta',
            'incidencia_solicitud_activo',
        );

        $this->modal_abierto_servicio_detalle = true;

    }

    public function editar_servicio_detalle(PersonalesAtencionesIncidenciasSolicitudes $iserviciodetalle)
    {
        $this->colorHeaderModal = "success-subtle";
        $this->textoHeaderModal = "EDITAR INCIDENCIA / SOLICITUD";

        $this->colorBotonGuardarActualizar = "success";
        $this->textoBotonGuardarActualizar = "Actualizar incidencia / solicitud";

        $this->modal_abierto_servicio_detalle = true;

        $this->incidencia_solicitud_id = $iserviciodetalle->id;

        $this->incidencia_solicitud_servicio_id = $iserviciodetalle->servicio_id;

        $this->incidencia_solicitud_tipo = $iserviciodetalle->tipo;

        $this->incidencia_solicitud_tipo_desc = $iserviciodetalle->tipo_desc;

        $this->incidencia_solicitud_servicio = $iserviciodetalle->servicio;
        $this->incidencia_solicitud = $iserviciodetalle->incidencia_solicitud;
        $this->incidencia_solicitud_respuesta = $iserviciodetalle->respuesta;
        $this->incidencia_solicitud_activo = $iserviciodetalle->activo;
    }

    public function listar_servicios_detalle(PersonalesAtencionesServicio $iservicio)
    {
        $this->servicio_id = $iservicio->id;
        
        $this->incidencia_solicitud_servicio_id = $iservicio->id;
        $this->incidencia_solicitud_servicio = $iservicio->servicio;
    }

    public function cerrar_nuevo_servicio_detalle()
    {
        $this->modal_abierto_servicio_detalle = false;
    }
}
