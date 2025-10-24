<?php

namespace App\Livewire\Informatica\Firmas\Pc;

use App\Models\Tbl_firmas_pc;
use App\Models\Tbl_personale;
use App\Models\Tbl_sede;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Activos extends Component
{
    protected $listeners = ['pcActivado' => '$refresh'];

    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    // Variable de entorno
    public $modal_header_titulo = 'nuevo';
    public $modal_header_color = 'primary-subtle';
    public $btn_guardar_actualizar = 'guardar';
    public $btn_guardar_actualizar_color = 'primary';

    // Variables de Modal
    public $modal_abierto_firmapc = false;
    public $modal_abierto_historial_token = false;
    public $modal_abierto_imagen = false;
    public $modal_abierto_personal_buscar = false;
    public $modal_abierto_pdf_cargar = false;
    public $modal_abierto_pdf_imprimir = false;
    

    public $id_firmapc,$codtoken,$operativo,$asignacion,$actaruta,$fecha_expiracion,$observacion,$created_user,$updated_user,$activo;
    public $idpersonal,$dni,$datos,
        $codsede_origen,$sede_origen,$coddependencia_origen,$dependencia_origen,$codsede_destino,$sede_destino,$coddependencia_destino,$dependencia_destino,
        $despacho,$regimen,$cargo,$correo_personal,$correo_institucional,$cel_personal,$cel_institucional;
    public $pdf;
    public $filtro_asignados, $filtro_usuarios, $filtro_rutas;

    public $avatar;

    //Buscar
    public $searchafirmapc;
    public function updatingSearchafirmapc(){
        $this->resetPage('firmapcPage');
    }
    public $searchbuscarpersonal;
    public function updatingSearchbuscarpersonal(){
        $this->resetPage('personalPage');
    }

    public function render()
    {
        $lista_activos = Tbl_firmas_pc::where('activo',"1")
            ->where(function ($query) {$query
                ->where('dni', 'like', '%' . $this->searchafirmapc . '%')
                ->orWhere('datos', 'like', '%' . $this->searchafirmapc . '%');
            })
            ->orderBy('id','desc')
            ->paginate(10,['*'],'firmapcPage');

        $totales_asignados = Tbl_firmas_pc::select(
                'created_user',
                DB::raw("SUM(CASE WHEN asignacion = 'ASIGNACION' THEN 1 ELSE 0 END) AS total_asignados"),
                DB::raw("SUM(CASE WHEN asignacion = 'DEVOLUCION' THEN 1 ELSE 0 END) AS total_devueltos")
            )
            ->where('activo', "1")
            ->groupBy('created_user')
            ->get();

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

        $lista_personal = Tbl_personale::where('activo','1')
            ->where('dni','like','%' .$this->searchbuscarpersonal .'%')
            ->orwhere('datos','like','%' .$this->searchbuscarpersonal .'%')
            ->paginate(10,['*'],'personalPage');

        return view('livewire.informatica.firmas.pc.activos',
            compact('lista_activos','totales_asignados','lista_personal',
                    'lista_sedes','lista_dependencias'));
    }

    protected function rules(){
        return [
            'dni' => 'required|string:tbl_tokens_asignados,dni,' . $this->id_firmapc,
        ];
    }

    protected $messages = [
        'dni.required' => 'El dni es obligatorio.',
    ];

    public function nuevo(){
        $this->resetExcept('searcha2');

        $this->modal_abierto_firmapc = true;

        $this->modal_header_titulo = 'nuevo';
        $this->modal_header_color = 'primary-subtle';
        $this->btn_guardar_actualizar = 'guardar';
        $this->btn_guardar_actualizar_color = 'primary';
    }

    public function guardar(){
        $validated = $this->validate(); 

        $totalActivos = Tbl_firmas_pc::where('activo', '1')->count() + 1;

        Tbl_firmas_pc::create([
            // 'id',
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
            'correo_personal' => $this->correo_personal,
            'correo_institucional' => $this->correo_institucional,
            'cel_personal' => $this->cel_personal,
            'cel_institucional' => $this->cel_institucional,
            //
            'idtoken' => $totalActivos,
            'codtoken' => "token" . $totalActivos,
            'operativo' => "OPERATIVO",
            'asignacion' => "ASIGNACION",
            'fecha_expiracion' => $this->fecha_expiracion,
            'observacion' => $this->observacion,
            'activo' => "1",
            //
            'created_user' => auth()->user()->datos,
            'updated_user' => auth()->user()->datos,
            
        ]);

        $this->reset();

        $this->modal_abierto_firmapc = false;

        // Emitimos un evento para mostrar el SweetAlert
        $this->dispatch(
            'alerta-actualizado',
            titulo: 'Datos actualizado',
            mensaje: 'Los datos se han guardado correctamente.',
            tipo: 'success' // success | error | warning | info
        );
    }

    public function editar(Tbl_firmas_pc $instanciaTbl){
        $this->modal_abierto_firmapc = true;

        $this->modal_header_titulo = 'editar';
        $this->modal_header_color = 'success-subtle';
        $this->btn_guardar_actualizar = 'actualizar';
        $this->btn_guardar_actualizar_color = 'success';

        // - Editar -
        $this->id_firmapc = $instanciaTbl->id;
        $this->dni = $instanciaTbl->dni;
        $this->datos = $instanciaTbl->datos;

        $this->codsede_origen = $instanciaTbl->codsede_origen;
        $this->sede_origen = $instanciaTbl->sede_origen;
        $this->coddependencia_origen = $instanciaTbl->coddependencia_origen;
        $this->dependencia_origen = $instanciaTbl->dependencia_origen;

        $this->codsede_destino = $instanciaTbl->codsede_destino;
        $this->sede_destino = $instanciaTbl->sede_destino;
        $this->coddependencia_destino = $instanciaTbl->coddependencia_destino;
        $this->dependencia_destino = $instanciaTbl->dependencia_destino;

        $this->regimen = $instanciaTbl->regimen;
        $this->cargo = $instanciaTbl->cargo;
        $this->correo_personal = $instanciaTbl->correo_personal;
        $this->correo_institucional = $instanciaTbl->correo_institucional;
        $this->cel_personal = $instanciaTbl->cel_personal;
        $this->cel_institucional = $instanciaTbl->cel_institucional;
        $this->created_user = $instanciaTbl->created_user;
        $this->updated_user = $instanciaTbl->updated_user;
        //
        // $this->idtoken = $instanciaTbl->idtoken;
        $this->codtoken = $instanciaTbl->codtoken;
        $this->operativo = $instanciaTbl->operativo;
        $this->asignacion = $instanciaTbl->asignacion;
        $this->fecha_expiracion = $instanciaTbl->fecha_expiracion;
        $this->observacion = $instanciaTbl->observacion;
    }

    public function actualizar(){
        $instanciaTbl = Tbl_firmas_pc::findOrFail($this->id_firmapc);

        $instanciaTbl->update([
            // 'id',
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
            'correo_personal' => $this->correo_personal,
            'correo_institucional' => $this->correo_institucional,
            'cel_personal' => $this->cel_personal,
            'cel_institucional' => $this->cel_institucional,
            'fecha_expiracion' => $this->fecha_expiracion,
            'observacion' => $this->observacion,
            // 'activo' => "1",
            //
            'created_user' => $this->created_user,
            'updated_user' => auth()->user()->datos,
        ]);

        $this->resetExcept('searcha2');

        $this->modal_abierto_firmapc = false;

        // Emitimos un evento para mostrar el SweetAlert
        $this->dispatch(
            'alerta-actualizado',
            titulo: 'Datos actualizado',
            mensaje: 'Los datos se han guardado correctamente.',
            tipo: 'success' // success | error | warning | info
        );
    }

        public function desactivar(Tbl_firmas_pc $ibien){
        try {
            $ibien->update([
                'activo' => '0',
                'updated_user' => auth()->user()->datos,
            ]);

            // Comunica que se desactivado
            $this->dispatch('ipDesactivado');

            session()->flash('danger', 'Usuario desactivado correctamente');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al desactivar el usuario: ' . $e->getMessage());
        }
    }

    public function cerrar(){
        $this->resetExcept('searcha2');
        
        $this->modal_abierto_firmapc = false;
    }

    // PDF
    // ---------------------------------------------------------

    public function imprimirPDF(){
        $this->modal_abierto_pdf_imprimir = true;
    }

    public function cargarPDF1(Tbl_firmas_pc $instanciaTbl){
        $this->modal_abierto_pdf_cargar = true;

        $this->id_firmapc = $instanciaTbl->id;

        $this->dni = $instanciaTbl->dni;
        $this->asignacion = $instanciaTbl->asignacion;
        $this->codtoken = $instanciaTbl->codtoken;
    }

    public function cargarPDF2(){
        $this->validate([
            'pdf' => 'required|mimes:pdf|max:4096', // Máx. 4MB
        ]);

        // Generar un nombre personalizado con timestamp
        $fileName = $this->dni . '_' . $this->asignacion . '_' . $this->codtoken . '.' . $this->pdf->getClientOriginalExtension();

        $path = $this->pdf->storeAs('archivos/informatica/tokens', $fileName, 'public');

        $instanciaTbl = Tbl_firmas_pc::findOrFail($this->id_firmapc);

        $instanciaTbl->update([
            'actaruta' => 'storage/archivos/informatica/tokens/' . $fileName,
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
        $this->reset('searchbuscarpersonal');

        $this->modal_abierto_pdf_cargar  = false;
    }

    // HISTORIAL DE ASIGNACIONES Y DEVOLUCIONES
    // ---------------------------------------------------------


    public function historial_tokens($codtoken){
        $this->modal_abierto_historial_token = true;
        $this->codtoken = $codtoken;
    }

    public function cerrar_historial_tokens(){
        $this->modal_abierto_historial_token = false;
    }

    // PERSONAL
    // ---------------------------------------------------------
    public function buscar_personal(){
        $this->modal_abierto_personal_buscar = true;
    }

    public function agregar_personal(Tbl_personale $ipersonal){
        $this->idpersonal = $ipersonal->id;
        $this->dni = $ipersonal->dni;
        $this->datos = $ipersonal->datos;
        
        $this->codsede_origen = $ipersonal->codsede_origen;
        $this->sede_origen = $ipersonal->sede_origen;
        $this->coddependencia_origen = $ipersonal->coddependencia_origen;
        $this->dependencia_origen = $ipersonal->dependencia_origen;
        
        $this->codsede_destino = $ipersonal->codsede_destino;
        $this->sede_destino = $ipersonal->sede;
        $this->coddependencia_destino = $ipersonal->coddependencia_destino;
        $this->dependencia_destino = $ipersonal->dependencia_destino;

        $this->regimen = $ipersonal->regimen;
        $this->cargo = $ipersonal->cargo;
        $this->correo_personal = $ipersonal->correo_personal;
        $this->correo_institucional = $ipersonal->correo_institucional;
        $this->cel_personal = $ipersonal->cel_personal;
        $this->cel_institucional = $ipersonal->cel_institucional;

        $this->reset('searchbuscarpersonal');

        $this->modal_abierto_personal_buscar = false;
    }

    public function cerrar_personal(){
        $this->modal_abierto_personal_buscar = false;
    }

}
