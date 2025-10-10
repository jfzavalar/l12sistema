<?php

namespace App\Livewire\Informatica\Firmas\Token;

use App\Models\Tbl_personale;
use App\Models\Tbl_sede;
use App\Models\Tbl_tokens_asignado;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Activos extends Component
{
    protected $listeners = ['tokensActivado' => '$refresh'];

    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    // Variable de entorno
    public $modal_header_titulo = 'nuevo';
    public $modal_header_color = 'primary-subtle';
    public $btn_guardar_actualizar = 'guardar';
    public $btn_guardar_actualizar_color = 'primary';

    // Variables de Modal
    public $modal_abierto_token = false;
    public $modal_abierto_historial_token = false;
    public $modal_abierto_imagen = false;
    public $modal_abierto_personal = false;
    public $modal_abierto_pdf_cargar = false;
    public $modal_abierto_pdf_imprimir = false;
    

    public $id_token,$codtoken,$operativo,$asignacion,$actaruta,$fecha_expiracion,$observacion,$created_user,$updated_user,$activo;
    public $idpersonal,$dni,$datos,$sede,$dependencia,$despacho,$regimen,$cargo,$correo_personal,$correo_institucional,$cel_personal,$cel_institucional;
    public $pdf;
    public $filtro_asignados, $filtro_usuarios, $filtro_rutas;

    public $avatar;
    public $codsede,$coddependencia;

    //Buscar
    public $searcha;
    public function updatingSearcha(){
        $this->resetPage();
    }
    public $searchpersonal;
    public function updatingSearchpersonal(){
        $this->resetPage();
    }

    public function render()
    {
        $lista_activos = Tbl_tokens_asignado::where('activo','1')
            ->when($this->searcha !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->searcha. '%')
                    ->orWhere('datos', 'like', '%' . $this->searcha . '%');
                });
            })
            // Filtro por rutas
            ->when($this->filtro_rutas === 'con', function ($query) {
                $query->whereNotNull('actaruta')->where('actaruta', '<>', '');
            })
            ->when($this->filtro_rutas === 'sin', function ($query) {
                $query->where(function ($subquery) {
                    $subquery->whereNull('actaruta')->orWhere('actaruta', '');
                });
            })
            // Filtro por usuarios y asignacion
            ->when($this->filtro_asignados === 'ASIGNACION', function ($query) {
                $query->whereNotNull('asignacion')->where('asignacion', '=', 'ASIGNACION')->where('created_user','=',$this->filtro_usuarios);
            })            
            ->when($this->filtro_asignados === 'DEVOLUCION', function ($query) {
                $query->where(function ($subquery) {
                    $subquery->whereNull('asignacion')->orWhere('asignacion', '=','DEVOLUCION')->where('created_user','=',$this->filtro_usuarios);
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        
        $totales_asignados = Tbl_tokens_asignado::select(
                'created_user',
                DB::raw("SUM(CASE WHEN asignacion = 'ASIGNACION' THEN 1 ELSE 0 END) AS total_asignados"),
                DB::raw("SUM(CASE WHEN asignacion = 'DEVOLUCION' THEN 1 ELSE 0 END) AS total_devueltos")
            )
            ->where('activo', "1")
            ->groupBy('created_user')
            ->get();

        $conteo_rutas = Tbl_tokens_asignado::selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN actaruta IS NULL OR actaruta = '' THEN 1 ELSE 0 END) as sin_ruta,
                SUM(CASE WHEN actaruta IS NOT NULL AND actaruta <> '' THEN 1 ELSE 0 END) as con_ruta
            ")
            ->where('activo', '1')
            ->first();

        $lista_historial = Tbl_tokens_asignado::where('codtoken',$this->codtoken)
            ->orderBy('id','desc')
            ->paginate();

        $lista_sedes = Tbl_sede::select('codsedeofi','nomsedeofi')
            ->where('activo','1')
            ->distinct()
            ->orderBy('nomsedeofi')
            ->get();
            
        $lista_dependencias = Tbl_sede::select('coddepofi','nomdepofi')
            ->where('activo','1')
            ->when($this->codsede, function($query, $codsede) {
                $query->where('codsedeofi', $codsede);
            })
            ->distinct()
            ->orderBy('nomdepofi')
            ->get();

        $lista_personal = Tbl_personale::where('activo','1')
            ->where('dni','like','%' .$this->searchpersonal .'%')
            ->orwhere('datos','like','%' .$this->searchpersonal .'%')
            ->paginate(10);

        return view('livewire.informatica.firmas.token.activos',
            compact('lista_activos','totales_asignados','conteo_rutas','lista_historial','lista_personal',
                    'lista_sedes','lista_dependencias'));
    }

    // Reglas de validación de variables

    protected function rules(){
        return [
            'dni' => 'required|string:tbl_tokens_asignados,dni,' . $this->id_token,
        ];
    }

    protected $messages = [
        'dni.required' => 'El dni es obligatorio.',
    ];

    public function nuevo(){
        $this->resetExcept('searcha');

        $this->modal_abierto_token = true;

        $this->modal_header_titulo = 'nuevo';
        $this->modal_header_color = 'primary-subtle';
        $this->btn_guardar_actualizar = 'guardar';
        $this->btn_guardar_actualizar_color = 'primary';
    }

    public function guardar(){
        $validated = $this->validate(); 

        $totalActivos = Tbl_tokens_asignado::where('activo', '1')->count() + 1;

        Tbl_tokens_asignado::create([
            // 'id',
            'dni' => $this->dni,
            'datos' => $this->datos,
            'sede' => $this->sede,
            'dependencia' => $this->dependencia,
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

        $this->modal_abierto_token = false;

        // Emitimos un evento para mostrar el SweetAlert
        $this->dispatch(
            'alerta-actualizado',
            titulo: 'Datos actualizado',
            mensaje: 'Los datos se han guardado correctamente.',
            tipo: 'success' // success | error | warning | info
        );
    }

    public function editar(Tbl_tokens_asignado $instanciaTbl){
        $this->modal_abierto_token = true;

        $this->modal_header_titulo = 'editar';
        $this->modal_header_color = 'success-subtle';
        $this->btn_guardar_actualizar = 'actualizar';
        $this->btn_guardar_actualizar_color = 'success';

        // - Editar -
        $this->id_token = $instanciaTbl->id;
        $this->dni = $instanciaTbl->dni;
        $this->datos = $instanciaTbl->datos;
        $this->sede = $instanciaTbl->sede;
        $this->dependencia = $instanciaTbl->dependencia;
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
        $instanciaTbl = Tbl_tokens_asignado::findOrFail($this->id_token);

        $instanciaTbl->update([
            // 'id',
            'dni' => $this->dni,
            'datos' => $this->datos,
            'sede' => $this->sede,
            'dependencia' => $this->dependencia,
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

        $this->resetExcept('searcha');

        $this->modal_abierto_token = false;

        // Emitimos un evento para mostrar el SweetAlert
        $this->dispatch(
            'alerta-actualizado',
            titulo: 'Datos actualizado',
            mensaje: 'Los datos se han guardado correctamente.',
            tipo: 'success' // success | error | warning | info
        );
    }

    public function desactivar(Tbl_tokens_asignado $ibien){
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
        $this->resetExcept('searcha');
        
        $this->modal_abierto_token = false;
    }

    // PDF
    // ---------------------------------------------------------

    public function imprimirPDF(){
        $this->modal_abierto_pdf_imprimir = true;
    }

    public function cargarPDF1(Tbl_tokens_asignado $instanciaTbl){
        $this->modal_abierto_pdf_cargar = true;

        $this->id_token = $instanciaTbl->id;

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

        $instanciaTbl = Tbl_tokens_asignado::findOrFail($this->id_token);

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
        $this->reset('searchpersonal');

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
        $this->modal_abierto_personal = true;
    }

    public function agregar_personal(Tbl_personale $ipersonal){
        $this->idpersonal = $ipersonal->id;
        $this->dni = $ipersonal->dni;
        $this->datos = $ipersonal->datos;
        $this->sede = $ipersonal->sede;
        $this->dependencia = $ipersonal->dependencia;
        $this->regimen = $ipersonal->regimen;
        $this->cargo = $ipersonal->cargo;
        $this->correo_personal = $ipersonal->correo_personal;
        $this->correo_institucional = $ipersonal->correo_institucional;
        $this->cel_personal = $ipersonal->cel_personal;
        $this->cel_institucional = $ipersonal->cel_institucional;

        $this->reset('searchpersonal');

        $this->modal_abierto_personal = false;
    }

    public function cerrar_personal(){
        $this->modal_abierto_personal = false;
    }

    // REASIGNAR Y DEVOLVER
    // ---------------------------------------------------------
    public function reasignar1(Tbl_tokens_asignado $instanciaTbl){
        $this->resetExcept('searcha');

        $this->modal_abierto_token = true;

        $this->modal_header_titulo = 'nuevo';
        $this->modal_header_color = 'secondary-subtle';
        $this->btn_guardar_actualizar = 'reasignar2';
        $this->btn_guardar_actualizar_color = 'secondary';

        $this->id_token = $instanciaTbl->id;

        $this->created_user = $instanciaTbl->created_user;
        $this->updated_user = $instanciaTbl->updated_user;
    }

    public function reasignar2(){
        $validated = $this->validate(); 

        $instanciaTbl = Tbl_tokens_asignado::findOrFail($this->id_token);

        $instanciaTbl->update([
            'activo' => "0",
        ]);

        Tbl_tokens_asignado::create([
            // 'id',
            'dni' => $this->dni,
            'datos' => $this->datos,
            'sede' => $this->sede,
            'dependencia' => $this->dependencia,
            'regimen' => $this->regimen,
            'cargo' => $this->cargo,
            'correo_personal' => $this->correo_personal,
            'correo_institucional' => $this->correo_institucional,
            'cel_personal' => $this->cel_personal,
            'cel_institucional' => $this->cel_institucional,
            //
            'idtoken' => $instanciaTbl->idtoken,
            'codtoken' => $instanciaTbl->codtoken,
            'operativo' => "OPERATIVO",
            'asignacion' => "ASIGNACION",
            'fecha_expiracion' => $this->fecha_expiracion,
            'observacion' => $this->observacion,
            //
            'activo' => "1",
            //
            'created_user' => $this->created_user,
            'updated_user' => auth()->user()->datos,
            
        ]);

        //Reiniciar variables
        $this->resetExcept('searcha');
    
        //Emitir evento al frontend
        $this->modal_abierto_token = false;

        // Emitimos un evento para mostrar el SweetAlert
        $this->dispatch(
            'alerta-actualizado',
            titulo: 'Datos actualizado',
            mensaje: 'Los datos se han guardado correctamente.',
            tipo: 'success' // success | error | warning | info
        );
    }

    public function devolver1(Tbl_tokens_asignado $instanciaTbl){
        $this->id_token = $instanciaTbl->id;

        $this->created_user = $instanciaTbl->created_user;
        $this->updated_user = $instanciaTbl->updated_user;
    }

    public function devolver2($id){
        $instanciaTbl = Tbl_tokens_asignado::findOrFail($id);

        $this->created_user = $instanciaTbl->created_user;

        $instanciaTbl->update([
            'activo' => "0",
        ]);

        Tbl_tokens_asignado::create([
            // 'id',
            'dni' => $instanciaTbl->dni,
            'datos' => $instanciaTbl->datos,
            'sede' => $instanciaTbl->sede,
            'dependencia' => $instanciaTbl->dependencia,
            'regimen' => $instanciaTbl->regimen,
            'cargo' => $instanciaTbl->cargo,
            'correo_personal' => $instanciaTbl->correo_personal,
            'correo_institucional' => $instanciaTbl->correo_institucional,
            'cel_personal' => $instanciaTbl->cel_personal,
            'cel_institucional' => $instanciaTbl->cel_institucional,
            //
            'idtoken' => $instanciaTbl->idtoken,
            'codtoken' => $instanciaTbl->codtoken,
            'operativo' => "OPERATIVO",
            'asignacion' => "DEVOLUCION",
            'fecha_expiracion' => $instanciaTbl->fecha_expiracion,
            'observacion' => $instanciaTbl->observacion,
            //
            'activo' => "1",
            //
            'created_user' => $this->created_user,
            'updated_user' => auth()->user()->datos,
        ]);

        //Reiniciar variables
        $this->resetExcept('searcha');

        //Emitir evento al frontend
        $this->modal_abierto_token = false;

        // Emitimos un evento para mostrar el SweetAlert
        $this->dispatch(
            'alerta-actualizado',
            titulo: 'Token devuelto',
            mensaje: 'Los datos se han guardado correctamente.',
            tipo: 'success' // success | error | warning | info
        );
    }
}
