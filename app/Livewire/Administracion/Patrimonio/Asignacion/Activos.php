<?php

namespace App\Livewire\Administracion\Patrimonio\Asignacion;

use App\Models\Tbl_biene;
use App\Models\Tbl_personale;
use App\Models\Tbl_personales_biene;
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
    public $modal_abierto_personal_buscar = false;
    public $modal_abierto_imagen = false;
    public $modal_abierto_historial = false;
    public $modal_abierto_pdf_cargar = false;
    public $modal_abierto_excel_cargar = false;
    public $modal_abierto_bienes = false;

    //Buscar
    public $searchabienesasignaciona;
    public function updatingSearchabienesasignaciona(){
        $this->resetPage('activosPage');
    }
    public $searchbuscarpersonal;
    public function updatingSearchbuscarpersonal(){
        $this->resetPage('personalPage');
    }
    public $searchhistorial;
    public function updatingSearchhistorial(){
        $this->resetPage('historialPage');
    }
    public $searchbien;
    public function updatingSearchbien(){
        $this->resetPage('bienesPage');
    }

    //Variables de tabla
    public $personal_entrega, $personal_recepciona;
    Public $entrega_recibe;
    public $motivo_traslado;
    
    //Variables Personal
    public $idpersonal,$dni,$datos,$codsede_origen,$sede_origen,$coddependencia_origen,$dependencia_origen,$codsede_destino,$sede_destino,$coddependencia_destino,$dependencia_destino,$despacho,$regimen,$cargo,$correo_personal,$correo_institucional,$cel_personal,$cel_institucional,$avatar,$activo_personal;
    public $idpersonal2,$dni2,$datos2,$codsede_origen2,$sede_origen2,$coddependencia_origen2,$dependencia_origen2,$codsede_destino2,$sede_destino2,$coddependencia_destino2,$dependencia_destino2,$despacho2,$regimen2,$cargo2,$correo_personal2,$correo_institucional2,$cel_personal2,$cel_institucional2,$avatar2,$activo_personal2;

    public $pdf,$excel;
    public $traslado;

    public $tempbienesinformaticos = [];

    public function render()
    {
        $lista_activos = Tbl_personale::where('activo','1')
            ->when($this->searchabienesasignaciona !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->searchabienesasignaciona . '%')
                    ->orWhere('datos', 'like', '%' . $this->searchabienesasignaciona . '%');
                });
            })
            ->orderBy('datos')
            ->paginate(10,['*'], 'activosPage');
        
        $lista_historial = Tbl_personales_biene::where('cod_usuario',$this->dni)
            ->when($this->searchhistorial !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('cod_pat', 'like', '%' . $this->searchhistorial . '%')
                    ->orWhere('serie', 'like', '%' . $this->searchhistorial . '%');
                });
            })
            ->orderBy('id','desc')
            ->paginate(10,['*'], 'historialPage');

        $lista_personal = Tbl_personale::where('activo','1')
            ->where('dni','like','%' .$this->searchbuscarpersonal .'%')
            ->orwhere('datos','like','%' .$this->searchbuscarpersonal .'%')
            ->paginate(10,['*'], 'personalPage');

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

        $lista_dependencias2 = Tbl_sede::select('coddepofi','nomdepofi')
            ->where('activo','1')
            ->where('codsedeofi',$this->codsede_destino)
            ->distinct()
            ->orderBy('nomdepofi')
            ->get();

        $lista_bienes = Tbl_biene::where('activo','1')
            ->when($this->searchbien !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('nro_pecosa', 'like', '%' . $this->searchbien. '%')
                    ->orWhere('cod_pat', 'like', '%' . $this->searchbien . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10,['*'], 'bienesPage');


        return view('livewire.administracion.patrimonio.asignacion.activos',
                compact('lista_activos','lista_historial','lista_personal','lista_sedes','lista_dependencias','lista_dependencias2','lista_bienes'));
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
        $this->reset([]);

        $this->modal_abierto_personal = false;

        //Reiniciar variables
        // $this->resetExcept('search_personal');
    }

    // PERSONAL
    // ---------------------------------------------------------
    public function buscar_personal($campo){
        $this->modal_abierto_personal_buscar = true;

        $this->entrega_recibe= $campo;
    }

    public function agregar_personal(Tbl_personale $ipersonal){
        if ($this->entrega_recibe === "solicitante") {
            $this->idpersonal = $ipersonal->id;
            $this->dni = $ipersonal->dni;
            $this->datos = $ipersonal->datos;
            $this->sede_origen = $ipersonal->sede;
            $this->dependencia_origen = $ipersonal->dependencia;
            $this->regimen = $ipersonal->regimen;
            $this->cargo = $ipersonal->cargo;

            $this->personal_entrega = $this->dni . ' - ' . $this->datos . ' - ' . $this->cargo . ' - ' . $this->regimen;

            $this->correo_personal = $ipersonal->correo_personal;
            $this->correo_institucional = $ipersonal->correo_institucional;
            $this->cel_personal = $ipersonal->cel_personal;
            $this->cel_institucional = $ipersonal->cel_institucional;
            $this->activo_personal = $ipersonal->activo;
        } else {
            $this->idpersonal2 = $ipersonal->id;
            $this->dni2 = $ipersonal->dni;
            $this->datos2 = $ipersonal->datos;
            $this->sede_origen2 = $ipersonal->sede;
            $this->dependencia_origen2 = $ipersonal->dependencia;
            $this->regimen2 = $ipersonal->regimen;
            $this->cargo2 = $ipersonal->cargo;

            $this->personal_recepciona = $this->dni2 . ' - ' . $this->datos2 . ' - ' . $this->cargo2 . ' - ' . $this->regimen2;

            $this->correo_personal2 = $ipersonal->correo_personal;
            $this->correo_institucional2 = $ipersonal->correo_institucional;
            $this->cel_personal2 = $ipersonal->cel_personal;
            $this->cel_institucional2 = $ipersonal->cel_institucional;
            $this->activo_personal2 = $ipersonal->activo;
        }

        $this->tempbienesinformaticos = Tbl_personales_biene::where('cod_usuario', $this->dni)
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();

        $this->modal_abierto_personal_buscar = false;

        $this->reset('searchbuscarpersonal');
    }

    public function borrar_datos_temporal(){
        $this->reset('tempbienesinformaticos');
    }

    public function cerrar_personal(){
        $this->modal_abierto_personal_buscar = false;
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

        $this->reset(['searchhistorial']);
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

    public function buscar_bien(){
        $this->modal_abierto_bienes = true;
    }

    public function cerrar_bienes(){
        $this->modal_abierto_bienes = false;
    }

    public function agregar_bienes($item_cod_patrominial){
        // $this->btndisable = "disabled";
        $ibieninformatico = Tbl_biene::findOrFail($item_cod_patrominial);

        // Verificar si ya existe
        if (collect($this->tempbienesinformaticos)->contains('cod_patrimonial', $ibieninformatico->cod_pat)) {
            // Opcional: mensaje de error
            session()->flash('error_bien_duplicado', 'El equipo con código patrimonial ' . $ibieninformatico->cod_patrimonial . ' ya fue agregado.');
            $this->modal_abierto_bienes= false;
            return;
        } else {

            // Agregar al array si no existe
            $this->tempbienesinformaticos[] = [
                'cod_patrimonial' => $ibieninformatico->cod_pat,
                'cod_barra' => $ibieninformatico->cod_barra,
                'desc_bien' => $ibieninformatico->bien,
                'desc_marca' => $ibieninformatico->marca,
                'modelo' => $ibieninformatico->modelo,
                'nro_serie' => $ibieninformatico->erie,
                'desc_color' => $ibieninformatico->color,
                'des_estado_conservacion' => $ibieninformatico->est_cons,
            ];

            // Concatenar lista
            // $this->lista_equipos_traslado = $this->lista_equipos_traslado . PHP_EOL . $ibieninformatico->cod_pat;

            $this->modal_abierto_bienes= false;
        }        
    }

    public function eliminar_buscar_bieninformatico($item_cod_patrominial){
        unset($this->tempbienesinformaticos[$item_cod_patrominial]);
        $this->tempbienesinformaticos = array_values($this->tempbienesinformaticos); // Reindexar el array
    } 
}
