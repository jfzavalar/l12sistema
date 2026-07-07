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
        $this->resetPage('serviciosdetallesPage');
    }
    public function updatingSearchserviciosdetalles(){
        $this->resetPage('serviciosdetallesPage');
    }

    // VARIABLES DE MODAL
    public $modal_abierto_servicio = false,
            $modal_abierto_servicio_detalle = false;

    public $funcionGuardarActualizarServicio="guardar_servicio";
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
        $this->funcionGuardarActualizarServicio="guardar_servicio";
    
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

    public function guardar_servicio()
    {
        $this->validate([
            'servicio' => 'required|string|max:255',
        ]);

        $usuario = auth()->user()->datos;

        try 
        {
            PersonalesAtencionesServicio::create([
                'servicio' => mb_strtoupper($this->servicio, 'UTF-8'),
                'activo' => '1',
                'created_user' => $usuario,
                'updated_user' => $usuario,
            ]);

            $this->reset('servicio');

            $mensaje = 'Se guardó correctamente.';
            $tipo = 'success';

            // MENSAJE
            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Proceso completado',
                mensaje: $mensaje,
                tipo: $tipo
            );

            $this->modal_abierto_servicio = false;
        } 
        catch (\Throwable $e) {

            dd($e); // 🔥 Déjalo mientras pruebas

        };
    }

    public function editar_servicio(PersonalesAtencionesServicio $iservicio)
    {
        $this->funcionGuardarActualizarServicio="actualizar_servicio";
    
        $this->colorHeaderModal = "success-subtle";
        $this->textoHeaderModal = "EDITAR SERVICIO";

        $this->colorBotonGuardarActualizar = "success";
        $this->textoBotonGuardarActualizar = "Actualizar servicio";

        $this->modal_abierto_servicio = true;

        $this->servicio_id = $iservicio->id;
        $this->servicio = $iservicio->servicio;
    }

    public function actualizar_servicio()
    {
        $this->validate([
            'servicio' => 'required|string|max:255',
        ]);

        $usuario = auth()->user()->datos;

        $servicio = PersonalesAtencionesServicio::where('id',$this->servicio_id)->where('activo',1)->first();

        try 
        {
            $servicio->update([
                'servicio' => mb_strtoupper($this->servicio, 'UTF-8'),
                'activo' => '1',
                'created_user' => $usuario,
                'updated_user' => $usuario,
            ]);

            $this->reset('servicio');

            $mensaje = 'Se actualizó correctamente.';
            $tipo = 'success';

            // MENSAJE
            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Proceso completado',
                mensaje: $mensaje,
                tipo: $tipo
            );

            $this->modal_abierto_servicio = false;
        } 
        catch (\Throwable $e) {

            dd($e); // 🔥 Déjalo mientras pruebas

        };
    }

    public function cerrar_nuevo_servicio()
    {
        $this->modal_abierto_servicio = false;
    }





    public function nuevo_servicio_detalle()
    {
        $this->funcionGuardarActualizarServicio="guardar_servicio_detalle";

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

    public function guardar_servicio_detalle()
    {
        $this->validate([
            'incidencia_solicitud_servicio' => 'required|string|max:255',
            'incidencia_solicitud_tipo_desc' => 'required|string|max:255',
            'incidencia_solicitud' => 'required|string|max:255',
            'incidencia_solicitud_respuesta' => 'required|string|max:255',
        ]);

        $usuario = auth()->user()->datos;

        try 
        {
            PersonalesAtencionesIncidenciasSolicitudes::create([
                'servicio_id' => $this->servicio_id,
                'tipo' => '1',
                'tipo_desc' => mb_strtoupper($this->incidencia_solicitud_tipo_desc,'UTF-8'),
                'servicio' => $this->incidencia_solicitud_servicio,
                'incidencia_solicitud' => mb_strtoupper($this->incidencia_solicitud,'UTF-8'),
                'respuesta' => mb_strtoupper($this->incidencia_solicitud_respuesta,'UTF-8'),
                'activo' => '1',
                'created_user' => $usuario,
                'updated_user' => $usuario,
            ]);

            $this->reset('incidencia_solicitud_id',
                    // 'incidencia_solicitud_servicio_id',
                    'incidencia_solicitud_tipo',
                    'incidencia_solicitud_tipo_desc',
                    // 'incidencia_solicitud_servicio',
                    'incidencia_solicitud',
                    'incidencia_solicitud_respuesta',
                    'incidencia_solicitud_activo');

            $mensaje = 'Se guardó correctamente la Incidencia / Solicitud';
            $tipo = 'success';

            // MENSAJE
            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Proceso completado',
                mensaje: $mensaje,
                tipo: $tipo
            );

            $this->modal_abierto_servicio_detalle = false;
        } 
        catch (\Throwable $e) {

            dd($e); // 🔥 Déjalo mientras pruebas

        };
    }

    public function editar_servicio_detalle(PersonalesAtencionesIncidenciasSolicitudes $iserviciodetalle)
    {
        $this->funcionGuardarActualizarServicio="actualizar_servicio_detalle";

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

    public function actualizar_servicio_detalle()
    {
        $this->validate([
            'incidencia_solicitud_servicio' => 'required|string|max:255',
            'incidencia_solicitud_tipo_desc' => 'required|string|max:255',
            'incidencia_solicitud' => 'required|string|max:255',
            'incidencia_solicitud_respuesta' => 'required|string|max:255',
        ]);

        $usuario = auth()->user()->datos;

        $serviciodetalle = PersonalesAtencionesIncidenciasSolicitudes::where('id',$this->incidencia_solicitud_id)->where('activo',1)->first();

        try 
        {
            $serviciodetalle->update([
                'servicio_id' => $this->servicio_id,
                'tipo' => '1',
                'tipo_desc' => mb_strtoupper($this->incidencia_solicitud_tipo_desc,'UTF-8'),
                'servicio' => $this->incidencia_solicitud_servicio,
                'incidencia_solicitud' => mb_strtoupper($this->incidencia_solicitud,'UTF-8'),
                'respuesta' => mb_strtoupper($this->incidencia_solicitud_respuesta,'UTF-8'),
                'activo' => '1',
                'created_user' => $usuario,
                'updated_user' => $usuario,
            ]);

            $this->reset('incidencia_solicitud_id',
                    // 'incidencia_solicitud_servicio_id',
                    'incidencia_solicitud_tipo',
                    'incidencia_solicitud_tipo_desc',
                    // 'incidencia_solicitud_servicio',
                    'incidencia_solicitud',
                    'incidencia_solicitud_respuesta',
                    'incidencia_solicitud_activo');

            $mensaje = 'Se actualizó correctamente la Incidencia / Solicitud';
            $tipo = 'success';

            // MENSAJE
            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Proceso completado',
                mensaje: $mensaje,
                tipo: $tipo
            );

            $this->modal_abierto_servicio_detalle = false;
        } 
        catch (\Throwable $e) {

            dd($e); // 🔥 Déjalo mientras pruebas

        };
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
