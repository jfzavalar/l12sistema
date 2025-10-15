<?php

namespace App\Livewire\Administracion\Rrhh\Personal;

use App\Models\Tbl_personale;
use App\Models\Tbl_personales_contrato;
use App\Models\Tbl_sede;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Activos extends Component
{
    protected $listeners = ['personalActivado' => '$refresh'];

    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    // Variable de entorno
    public $modal_header_titulo = 'nuevo';
    public $modal_header_color = 'primary-subtle';
    public $btn_guardar_actualizar = 'guardar';
    public $btn_guardar_actualizar_color = 'primary';
    public $fieldset_disable = 'disabled';

    // Variables de Modal
    public $modal_abierto_personal = false;
    public $modal_abierto_imagen = false;
    public $modal_abierto_historial = false;
    public $modal_abierto_pdf_cargar = false;

    //Buscar
    public $searchpersonal;
    public function updatingSearchpersonal(){
        $this->resetPage();
    }

    // Variables de tabla
    public $id_personal,
        $dni,
        $datos,

        $codsede_origen,
        $sede_origen,
        $coddependencia_origen,
        $dependencia_origen,

        $codsede_destino,
        $sede_destino,
        $coddependencia_destino,
        $dependencia_destino,

        $regimen,
        $cargo,
        $correo_personal,
        $correo_institucional,
        $cel_personal,
        $cel_institucional,
        $observacion,
        $avatar,
        $activo,
        $created_user,
        $updated_user;

    public $id_personal_contrato,
        $fecha_inicio,
        $fecha_fin,
        $causal,
        $actaruta,
        $observacion_contrato;

    public $pdf;

    public function render()
    {
        $lista_activos = Tbl_personale::where('activo','1')
            ->when($this->searchpersonal !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->searchpersonal . '%')
                    ->orWhere('datos', 'like', '%' . $this->searchpersonal . '%');
                });
            })
            ->orderBy('datos')
            ->paginate(10);
        
        $lista_historial = Tbl_personales_contrato::where('dni',$this->dni)
            // ->when($this->search_personal !== '', function ($query) {
            //     $query->where(function ($q) {
            //         $q->where('dni', 'like', '%' . $this->search_personal . '%')
            //         ->orWhere('datos', 'like', '%' . $this->search_personal . '%');
            //     });
            // })
            ->orderBy('id','desc')
            ->paginate(10);

        $lista_sedes = Tbl_sede::select('codsedeofi','nomsedeofi')
            ->where('activo','1')
            ->distinct()
            ->orderBy('nomsedeofi')
            ->get();
            
        $lista_dependencias = Tbl_sede::select('coddepofi','nomdepofi')
            ->where('activo','1')
            ->where('codsedeofi',$this->codsede_destino)
            ->distinct()
            ->orderBy('nomdepofi')
            ->get();

        return view('livewire.administracion.rrhh.personal.activos',
                compact('lista_activos','lista_historial','lista_sedes','lista_dependencias'));
    }

    protected function rules(){
        return [
            'dni' => 'required|string|unique:tbl_personales,dni,' . $this->id_personal,
            'datos' => 'required',
            'sede' => 'required',
            'dependencia' => 'required',
            'regimen' => 'required',
            'cargo' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'causal' => 'required',
        ];
    }

    protected $messages = [
        'dni.required' => 'El dni es obligatorio.',
        'dni.unique' => 'El dni ya fue registrado.',
        'datos.required' => '',
        'sede.required' => '',
        'dependencia.required' => '',
        'regimen.required' => '',
        'cargo.required' => '',
        'fecha_inicio.required' => '',
        'fecha_fin.required' => '',
        'causal.required' => '',
    ];

    public function nuevo(){
        $this->reset([]);

        $this->modal_abierto_personal = true;

        $this->modal_header_titulo = 'nuevo';
        $this->modal_header_color = 'primary-subtle';
        $this->btn_guardar_actualizar = 'guardar';
        $this->btn_guardar_actualizar_color = 'primary';
        $this->fieldset_disable = '';
    }

    public function guardar(){
        $validated = $this->validate(); 
    }


    public function editar(Tbl_personale $iEditar)
    {
        $this->modal_abierto_personal = true;

        $this->modal_header_titulo = 'editar';
        $this->modal_header_color = 'success-subtle';
        $this->btn_guardar_actualizar = 'actualizar';
        $this->btn_guardar_actualizar_color = 'success';
        $this->fieldset_disable = '';

        // Datos
        $this->id_personal = $iEditar->id;
        $this->dni = $iEditar->dni;
        $this->datos = $iEditar->datos;

        // Origen
        $this->codsede_origen = $iEditar->codsede_origen;
        $this->sede_origen = $iEditar->sede_origen;
        $this->coddependencia_origen = $iEditar->coddependencia_origen;
        $this->dependencia_origen = $iEditar->dependencia_origen;

        // Destino
        $this->codsede_destino = $iEditar->codsede_destino;
        $this->sede_destino = $iEditar->sede_destino;
        $this->coddependencia_destino = $iEditar->coddependencia_destino;
        $this->dependencia_destino = $iEditar->dependencia_destino;

        // Otros campos
        $this->regimen = $iEditar->regimen;
        $this->cargo = $iEditar->cargo;
        $this->cel_personal = $iEditar->cel_personal;
        $this->correo_personal = $iEditar->correo_personal;
        $this->cel_institucional = $iEditar->cel_institucional;
        $this->correo_institucional = $iEditar->correo_institucional;
        $this->avatar = $iEditar->avatar;
        $this->activo = $iEditar->activo;
        $this->created_user = $iEditar->created_user;
        $this->updated_user = $iEditar->updated_user;

        // Variable de contrato
        $iContrato = Tbl_personales_contrato::where('dni', $iEditar->dni)->orderBy('id','desc')->firstOrFail();
        
        $this->id_personal_contrato = $iContrato->id;
        $this->fecha_inicio = $iContrato->fecha_inicio;
        $this->fecha_fin = $iContrato->fecha_fin;
        $this->causal = $iContrato->causal;
        $this->observacion_contrato = $iContrato->observacion;

        // Refrescar visualmente el select
        // $this->dispatch('refresh');
        // $this->js('$wire.$refresh()');
    }

    public function actualizar(){
        $iActualizar = Tbl_personale::where('dni', $this->dni)->firstOrFail();

        $iContrato = Tbl_personales_contrato::where('id', $this->id_personal_contrato)->firstOrFail();

        try {
            $iActualizar->update([            
                'dni' => $this->dni,
                'datos' => $this->datos,

                'codsede_origen' => $this->codsede_origen,
                'sede_origen' => $this->sede_origen,
                'coddependencia_origen' => $this->coddependencia_origen,
                'dependencia_origen' => $this->dependencia_origen,

                'codsede_destino' => $this->codsede_destino,
                'sede_destino' => $this->sede_destino,
                'coddependencia_destino' => $this->coddependencia_destino,
                'dependencia_destino' => $this->dependencia_destino,

                'regimen' => $this->regimen,
                'cargo' => $this->cargo,
                'cel_personal' => $this->cel_personal,
                'correo_personal' => $this->correo_personal,
                'cel_institucional' => $this->cel_institucional,
                'correo_institucional' => $this->correo_institucional,
                'avatar' => $this->avatar,
                'activo' => $this->activo,
                
                'created_user' => $this->created_user,
                'updated_user' => $this->updated_user,
            ]);

            $iContrato->update([
                'codsede_destino' => $this->codsede_destino,
                'sede_destino' => $this->sede_destino,
                'coddependencia_destino' => $this->coddependencia_destino,
                'dependencia_destino' => $this->dependencia_destino,

                'regimen' => $this->regimen,
                'cargo' => $this->cargo,

                'fecha_inicio' => $this->fecha_inicio,
                'fecha_fin' => $this->fecha_fin,
                'causal' => $this->causal,
                'observacion' => $this->observacion_contrato,
            ]);

        } catch (\Exception $e) {
            session()->flash('error', 'Error al desactivar el usuario: ' . $e->getMessage());
        }        

        // Reiniciamos todas la variable excepto:
        $this->resetExcept('search_personal');
        
        // Cerramos modal
        $this->modal_abierto_personal = false;

        // Emitimos un evento para mostrar el SweetAlert
        $this->dispatch(
            'alerta-actualizado',
            titulo: 'Datos actualizado',
            mensaje: 'Los datos se han guardado correctamente.',
            tipo: 'success' // success | error | warning | info
        );
    }

    public function desactivar(Tbl_personale $iDesactivar){
        try {
            $iDesactivar->update([
                'activo' => '0',
                'updated_user' => auth()->user()->datos,
            ]);

            // Comunica que se desactivado
            $this->dispatch('personalDesactivado');

            session()->flash('danger', 'Usuario desactivado correctamente');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al desactivar el usuario: ' . $e->getMessage());
        }
    }

    public function cerrar(){
        $this->reset([
        'id_personal',
        'dni',
        'datos',
        'codsede_origen',
        'sede_origen',
        'coddependencia_origen',
        'dependencia_origen',
        'codsede_destino',
        'sede_destino',
        'coddependencia_destino',
        'dependencia_destino',
        'regimen',
        'cargo',
        'correo_personal',
        'correo_institucional',
        'cel_personal',
        'cel_institucional',
        'observacion',
        'avatar',
        'activo',
        'created_user',
        'updated_user',
    ]);

        $this->modal_abierto_personal = false;

        //Reiniciar variables
        // $this->resetExcept('search_personal');
    }

    public function nuevo_contrato(Tbl_personale $iEditar){
        $this->reset(['fecha_inicio','fecha_fin','causal','observacion_contrato']);

        $this->modal_abierto_personal = true;

        $this->modal_header_titulo = 'nuevo_contrato';
        $this->modal_header_color = 'secondary-subtle';
        $this->btn_guardar_actualizar = 'guardar_contrato';
        $this->btn_guardar_actualizar_color = 'secondary';
        $this->fieldset_disable = 'disabled';

        // Datos
        $this->id_personal = $iEditar->id;
        $this->dni = $iEditar->dni;
        $this->datos = $iEditar->datos;

        // Origen
        $this->codsede_origen = $iEditar->codsede_origen;
        $this->sede_origen = $iEditar->sede_origen;
        $this->coddependencia_origen = $iEditar->coddependencia_origen;
        $this->dependencia_origen = $iEditar->dependencia_origen;

        // Destino
        $this->codsede_destino = $iEditar->codsede_destino;
        $this->sede_destino = $iEditar->sede_destino;
        $this->coddependencia_destino = $iEditar->coddependencia_destino;
        $this->dependencia_destino = $iEditar->dependencia_destino;

        // Otros campos
        $this->regimen = $iEditar->regimen;
        $this->cargo = $iEditar->cargo;
        $this->cel_personal = $iEditar->cel_personal;
        $this->correo_personal = $iEditar->correo_personal;
        $this->cel_institucional = $iEditar->cel_institucional;
        $this->correo_institucional = $iEditar->correo_institucional;
        $this->avatar = $iEditar->avatar;
        $this->activo = $iEditar->activo;
        $this->created_user = $iEditar->created_user;
        $this->updated_user = $iEditar->updated_user;
    }

    public function guardar_contrato(){
        $iContrato = Tbl_personale::where('dni', $this->dni)->firstOrFail();

        try {
            $iContrato->update([            
                'dni' => $this->dni,
                'datos' => $this->datos,

                'codsede_destino' => $this->codsede_destino,
                'sede_destino' => $this->sede_destino,
                'coddependencia_destino' => $this->coddependencia_destino,
                'dependencia_destino' => $this->dependencia_destino,

                'regimen' => $this->regimen,
                'cargo' => $this->cargo,
                
                'created_user' => $this->created_user,
                'updated_user' => $this->updated_user,
            ]);

            Tbl_personales_contrato::create([
                'dni' => $this->dni,
                'datos' => $this->datos,

                'codsede_origen' => $this->codsede_origen,
                'sede_origen' => $this->sede_origen,
                'coddependencia_origen' => $this->coddependencia_origen,
                'dependencia_origen' => $this->dependencia_origen,

                'codsede_destino' => $this->codsede_destino,
                'sede_destino' => $this->sede_destino,
                'coddependencia_destino' => $this->coddependencia_destino,
                'dependencia_destino' => $this->dependencia_destino,

                'regimen' => $this->regimen,
                'cargo' => $this->cargo,


                'fecha_inicio' => $this->fecha_inicio,
                'fecha_fin' => $this->fecha_fin,
                'causal' => $this->causal,
                'observacion' => $this->observacion_contrato,
                'activo' => '1',
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al desactivar el usuario: ' . $e->getMessage());
        }        

        // Reiniciamos todas la variable excepto:
        $this->resetExcept('search_personal');
        
        // Cerramos modal
        $this->modal_abierto_personal = false;

        // Emitimos un evento para mostrar el SweetAlert
        $this->dispatch(
            'alerta-actualizado',
            titulo: 'Datos actualizado',
            mensaje: 'Los datos se han guardado correctamente.',
            tipo: 'success' // success | error | warning | info
        );
    }

    public function editar_imagen(){
        $this->modal_abierto_imagen = true;
    }

    public function cerrar_imagen(){
        $this->modal_abierto_imagen = false;

        // Variable de entorno
        $this->reset(['avatar']);
    }

    public function historial($vDni){
        $this->modal_abierto_historial = true;

        $this->dni = $vDni;
    }

    public function cerrar_historial(){
        $this->modal_abierto_historial = false;
    }

    // PDF
    // ---------------------------------------------------------

    public function imprimirPDF(){
        // $this->modal_abierto_pdf_imprimir = true;
    }

    public function cargarPDF1(Tbl_personales_contrato $iCargarPdf){
        $this->modal_abierto_pdf_cargar = true;

        $this->id_personal_contrato = $iCargarPdf->id;
        $this->fecha_inicio = $iCargarPdf->fecha_inicio;
        $this->fecha_fin = $iCargarPdf->fecha_fin;
    }

    public function cargarPDF2(){
        $this->validate([
            'pdf' => 'required|mimes:pdf|max:4096', // Máx. 4MB
        ]);

        // Generar un nombre personalizado con timestamp
        $fileName = $this->dni . '_' . $this->fecha_inicio . '_' . $this->fecha_fin . '.' . $this->pdf->getClientOriginalExtension();

        $path = $this->pdf->storeAs('archivos/administracion/rrhh/personal/contratos', $fileName, 'public');

        $instanciaTbl = Tbl_personales_contrato::findOrFail($this->id_personal_contrato);

        $instanciaTbl->update([
            'actaruta' => 'storage/archivos/administracion/rrhh/personal/contratos/' . $fileName,
            'updated_user' => auth()->user()->datos,
        ]);

        // Limpia el archivo de la propiedad Livewire si lo deseas
        $this->reset('pdf');

        // Cerrar el modal en el navegador
        $this->modal_abierto_pdf_cargar = false;

        // Emitimos un evento para mostrar el SweetAlert
        $this->dispatch(
            'alerta-actualizado',
            titulo: 'PDF actualizado',
            mensaje: 'Los datos se han guardado correctamente.',
            tipo: 'success' // success | error | warning | info
        );
    }

    public function cerrar_PDF(){
        //Reiniciar variables
        // $this->reset('searchpersonal');

        $this->modal_abierto_pdf_cargar  = false;
    }
}
