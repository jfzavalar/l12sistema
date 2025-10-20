<?php

namespace App\Livewire\Administracion\Patrimonio\Bienes;

use App\Models\Tbl_biene;
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
    protected $listeners = ['bienActivado' => '$refresh'];

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
    public $modal_abierto_personal_buscar = false;
    public $modal_abierto_pdf_cargar = false;
    public $modal_abierto_pdf_imprimir = false;
    public $modal_abierto_excel_cargar = false;

    //Buscar
    public $searcha;
    public function updatingSearcha(){
        $this->resetPage('activosPage');
    }
    public $searchpersonal;
    public function updatingSearchpersonal(){
        $this->resetPage('personalPage');
    }
    public $searchbuscarpersonal;
    public function updatingSearchbuscarpersonal(){
        $this->resetPage('personalPage');
    }

    // Variables de tabla
    public $id_bien_asignado,
        $cod_pat,
        $cod_barra,
        $bien,
        $marca,
        $modelo,
        $serie,
        $medidas,
        $color,
        $est_cons,
        $cod_ubif,
        $desc_ubif,
        $dni,//$cod_usuario,
        $datos,//$desc_usuario,
        $desc_cargo,
        $clase,
        $familia,
        $observa,
        $df,
        $nro_pecosa,
        $doc_adq,
        $ndoc_adq,
        $fecha_adq,
        $acoddepofi,
        $coddepofi,
        $nomdepofi,
        $anomdepofi,
        $sedepofi,
        $codsedeofi,
        $nomsedeofi,
        $codsede,
        $nomsede,
        $estadoofi,
        $codgbien,
        $estado,
        $codcat,
        $codgclase,
        $ip,
        $user_admin,
        $pass_admin,
        $sistema_operativo,
        $impresora01,
        $ip_impresora01,
        $impresora02,
        $ip_impresora02,
        $impresora03,
        $ip_impresora03,
        $desplazamiento,
        $asignacion,
        $actaruta,
        $activo,
        $observacion,
        $created_user,
        $updated_user,
        $created_at,
        $updated_at;

    public $cel_personal,$correo_personal;

    public $pdf,$excel;
    public $filtro_asignados, $filtro_usuarios, $filtro_rutas;

    public $tempbienesinformaticos = [];


    public $avatar;
    public $codsede_origen,$sede_origen,$coddependencia_origen,$dependencia_origen;
    public $codsede_destino,$sede_destino,$coddependencia_destino,$dependencia_destino;

    public function render()
    {
        $lista_activos = Tbl_biene::where('activo','1')
            ->when($this->searcha !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('nro_pecosa', 'like', '%' . $this->searcha. '%')
                    ->orWhere('cod_pat', 'like', '%' . $this->searcha . '%');
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
            ->paginate(20,['*'], 'activosPage');

        $lista_personal = Tbl_personale::where('activo','1')
            ->where('dni','like','%' .$this->searchbuscarpersonal .'%')
            ->orwhere('datos','like','%' .$this->searchbuscarpersonal .'%')
            ->paginate(10,['*'], 'personalPage');
        
        $totales_asignados = Tbl_biene::select(
                'created_user',
                DB::raw("SUM(CASE WHEN asignacion = '1' THEN 1 ELSE 0 END) AS total_asignados"),
                DB::raw("SUM(CASE WHEN asignacion = '0' THEN 1 ELSE 0 END) AS total_devueltos")
            )
            ->where('activo', "1")
            ->groupBy('created_user')
            ->get();

        $conteo_rutas = Tbl_biene::selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN actaruta IS NULL OR actaruta = '' THEN 1 ELSE 0 END) as sin_ruta,
                SUM(CASE WHEN actaruta IS NOT NULL AND actaruta <> '' THEN 1 ELSE 0 END) as con_ruta
            ")
            ->where('activo', '1')
            ->first();

        $lista_historial = Tbl_biene::where('cod_pat',$this->cod_pat)
            ->orderBy('id','desc')
            ->paginate();

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

        $lista_clases = Tbl_biene::select('clase')
            ->distinct()
            ->orderBy('clase')
            ->get();

        $lista_familias = Tbl_biene::select('familia')
            ->where('clase',$this->clase)
            ->distinct()
            ->orderBy('familia')
            ->get();

        return view('livewire.administracion.patrimonio.bienes.activos',
                compact('lista_activos','lista_personal',
                    'totales_asignados','conteo_rutas','lista_historial',
                    'lista_sedes','lista_dependencias','lista_clases','lista_familias'));
    }

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

        $totalActivos = Tbl_biene::where('activo', '1')->count() + 1;

        Tbl_tokens_asignado::create([
            // 'id',
            'dni' => $this->dni,
            
        ]);

        $this->reset([]);

        $this->modal_abierto_token = false;

        // Emitimos un evento para mostrar el SweetAlert
        $this->dispatch(
            'alerta-actualizado',
            titulo: 'Datos actualizado',
            mensaje: 'Los datos se han guardado correctamente.',
            tipo: 'success' // success | error | warning | info
        );
    }

    public function editar(Tbl_biene $instanciaTbl){
        $this->modal_abierto_token = true;

        $this->modal_header_titulo = 'editar';
        $this->modal_header_color = 'success-subtle';
        $this->btn_guardar_actualizar = 'actualizar';
        $this->btn_guardar_actualizar_color = 'success';

        // - Editar -
        // $this->id_token = $instanciaTbl->id;
        //
        // $this->idtoken = $instanciaTbl->idtoken;
        // $this->codtoken = $instanciaTbl->codtoken;
    }

    public function actualizar(){
        $instanciaTbl = Tbl_biene::findOrFail($this->id_token);

        $instanciaTbl->update([
            // 'id',
            'dni' => $this->dni,

            // 'activo' => "1",
            //

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

    public function desactivar(Tbl_biene $ibien){
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

    public function cargarPDF1(Tbl_biene $instanciaTbl){
        $this->modal_abierto_pdf_cargar = true;

    }

    public function cargarPDF2(){
        $this->validate([
            'pdf' => 'required|mimes:pdf|max:4096', // Máx. 4MB
        ]);

        // Generar un nombre personalizado con timestamp
        $fileName = $this->dni . '_' . $this->asignacion . '_' . $this->codtoken . '.' . $this->pdf->getClientOriginalExtension();

        $path = $this->pdf->storeAs('archivos/informatica/tokens', $fileName, 'public');

        $instanciaTbl = Tbl_biene::findOrFail($this->id_token);

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

    public function cargarEXCEL1(){

        $this->modal_abierto_excel_cargar = true;

    }

    public function cerrar_EXCEL(){
        //Reiniciar variables
        // $this->reset('searchpersonal');

        $this->modal_abierto_excel_cargar  = false;
    }

    // HISTORIAL DE ASIGNACIONES Y DEVOLUCIONES
    // ---------------------------------------------------------


    public function historial_tokens($codtoken){
        $this->modal_abierto_historial_token = true;
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


        $this->reset('searchpersonal');

        $this->modal_abierto_personal_buscar = false;

        $this->dni = $ipersonal->dni;
        $this->datos = $ipersonal->datos;
    }

    public function cerrar_personal(){
        $this->modal_abierto_personal_buscar = false;
    }

    // REASIGNAR Y DEVOLVER
    // ---------------------------------------------------------
    public function reasignar1(Tbl_biene $instanciaTbl){
        $this->resetExcept('searcha');

        $this->modal_abierto_token = true;

        $this->modal_header_titulo = 'nuevo';
        $this->modal_header_color = 'secondary-subtle';
        $this->btn_guardar_actualizar = 'reasignar2';
        $this->btn_guardar_actualizar_color = 'secondary';

        $this->created_user = $instanciaTbl->created_user;
        $this->updated_user = $instanciaTbl->updated_user;
    }

    public function reasignar2(){
        $validated = $this->validate(); 

        $instanciaTbl = Tbl_biene::findOrFail($this->id_token);

        $instanciaTbl->update([
            'activo' => "0",
        ]);

        Tbl_biene::create([
            // 'id',
            'dni' => $this->dni,

            
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


    public function agregar_bienes()
    {
        // 🔍 Validar los campos requeridos antes de continuar
        $this->validate([
            'nro_pecosa' => 'required|string',
            'clase'      => 'required|string',
            'familia'    => 'required|string',
            'cod_pat'    => 'required|string',
            'cod_barra'  => 'required|string',
            'bien'       => 'required|string',
            'marca'      => 'required|string',
            'modelo'     => 'required|string',
            'serie'      => 'required|string',
            'medidas'    => 'required|string',
            'color'      => 'required|string',
            'estado'     => 'required|string',
        ], [
            // ⚠️ Mensajes personalizados (opcional)
            'required' => 'El campo :attribute es obligatorio.',
        ]);

        // Verificar si ya existe en el array
        $existe = collect($this->tempbienesinformaticos)
            ->contains('cod_pat', $this->cod_pat);

        if ($existe) {
            session()->flash('error', 'El equipo con código patrimonial ' . $this->cod_pat . ' ya fue agregado.');
            return;
        }

        // Si no existe, agregar al array
        $this->tempbienesinformaticos[] = [
            'nro_pecosa' => $this->nro_pecosa,
            'cod_pat' => $this->cod_pat,
            'cod_barra' => $this->cod_barra,
            'bien' => $this->bien,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'serie' => $this->serie,
            'color' => $this->color,
            'est_cons' => $this->est_cons,
        ];
    }

    public function eliminar_buscar_bieninformatico($item_cod_patrominial){
        unset($this->tempbienesinformaticos[$item_cod_patrominial]);
        $this->tempbienesinformaticos = array_values($this->tempbienesinformaticos); // Reindexar el array
    } 


}
