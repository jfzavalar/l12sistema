<?php

namespace App\Livewire\Administracion\Patrimonio\Desplazamiento;

use App\Models\PatrimoniosBienesDesplazamiento;
use App\Models\Patrimonios_biene;
use App\Models\Persona;
use App\Models\Personales_cargo;
use App\Models\Personale;
use App\Models\Personales_despacho;
use App\Models\Personales_dependencia;
use App\Models\Personales_sede;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Activos extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    public $mostrarBtnBuscarDni = "d-none";

    public $colorHeaderModal, $textoHeaderModal;
    public $colorNuevoEditar, $textoNuevoEditar;
    public $colorGuardarActualizar, $textoGuardarActualizar;
    public $colorAgregar;

    //Variables PARA OCULTAR Y MOSTRAR TXT_OTROS
    public $mostrarotrosp = "d-none", $mostrarotrosc = "d-none",$mostrarcargafoto = "d-none";

    //Variables bloquear de secciones
    public $seccionFoto="disabled", $seccionPersona="disabled", $seccionPersonal="disabled",$seccionBienpatrimonial="disabled";

    // Variable de función Guardar o Actualizar
    public $funcionGuardarActualizar;

    // Variables de búsqueda
    public $search, $searchi,$searchpersonal,$searchhistorial, $searchpersonas, $searchsedes,$searchdependencias,$searchdespachos,$searchcargos,
            $searchbienes;
    public function updatingSearch(){
        $this->resetPage('bienesPage');
    }
    public function updatingSearchpersonal(){
        $this->resetPage('personalesPage');
    }
    public function updatingSearchhistorial(){
        $this->resetPage('historialPage');
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
    public function updatingSearchbienes(){
        $this->resetPage('bienesPage');
    }

    public $filtrotipodocumento;
    public $filtroregimen;

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

            $numero_convocatoria,
            $tipo_documento,
            $fecha_inicio,
            $fecha_fin;

    public $soporte_id,
            $preventivo,
            $sede_ubicacion,
            $dependencia_ubicacion,
            $despacho_ubicacion,
            $p01,
            $p02,
            $p03,
            $p04,
            $p05,
            $p06,
            $p07,
            $potros,
            $correctivo,
            $c01,
            $c02,
            $c03,
            $c04,
            $c05,
            $c06,
            $c07,
            $cotros,
            $operativo,
            $observacion_usuario,
            $recomendacion_usuario,
            $ruta_evidencia,
            $ruta_documento;

    Public $bien_id,
            $cod,
            $cod_patrimonial,
            $bien,
            $marca,
            $modelo,
            $serie,
            $medida,
            $medidas,
            $color,
            $estado,
            $clase,
            $familia,
            $bien_ip;

    public $desplazamiento_id;

    public $pdf_acta;
    public $bandera_documento="EVIDENCIA";
    
    public function render()
    {
        $lista_activos = PatrimoniosBienesDesplazamiento::select(
                'id',
                'dni_solicitante',
                'solicitante',
                'dni_responsabletraslado',
                'responsabletraslado',
                'sede_origen',
                'dependencia_origen',
                'sede_destino',
                'dependencia_destino',
                'motivo_traslado',
                'tipotraslado',
                'fechasalida',
                'fecharetorno',
                'observacion',
                'traslado',
                'lista_equipos_traslado',
                'actaruta',
                'activo',
                'created_user',
                'updated_user')
            ->where('activo','1')
            // ->where('lista_equipos_traslado','like','%' . $this->searchabienesdesplazamientoa . '%')
            ->orderBy('id','desc')
            ->paginate(30);

        $lista_desplazamientos_detalle = DB::table('tbl_patrimonio_bienes_desplazamientos_detalles as d')
            ->join('tbl_bienes as b', 'b.cod_pat', '=', 'd.cod_patrimonial')
            ->select(
                'd.id',
                'd.id_biendesplazamiento',
                'd.cod_patrimonial',
                'd.traslado',
                'd.activo',
                'd.created_user',
                'd.updated_user',
                'b.cod_barra',
                'b.bien',
                'b.marca',
                'b.modelo',
                'b.serie',
                'b.color',
                'b.est_cons'
            )
            ->where('d.activo', '1')
            ->where('d.id_biendesplazamiento', $this->desplazamiento_id)
            ->paginate(30);

        $lista_personas = Persona::where('activo','1')
            ->when($this->searchpersonas !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->searchpersonas . '%')
                    ->orWhere('datos', 'like', '%' . $this->searchpersonas . '%');
                });
            })
            ->orderBy('datos')
            ->paginate(10,['*'],'personasPage');
        
        $lista_sedes = Personales_sede::select('id','nombre')
            ->where('activo','1')
            ->where('nombre','like','%' . $this->searchsedes . '%')
            ->distinct()
            ->orderBy('nombre')
            ->paginate(10,['*'], 'sedesPage');
            
        $lista_dependencias = Personales_dependencia::select('id','nombre')
            ->where('activo','1')
            ->where('sede_id',$this->codsedeorigen)
            ->where('nombre','like','%' . $this->searchdependencias . '%')
            ->distinct()
            ->orderBy('nombre')
            ->paginate(10,['*'], 'dependenciasPage');

        $lista_despachos = Personales_despacho::select('id','nombre')
            ->where('activo','1')
            ->where('nombre','like','%' . $this->searchdespachos . '%')
            ->distinct()
            ->orderBy('nombre')
            ->paginate(10,['*'], 'despachosPage');

        $lista_cargos = Personales_cargo::select('id','nombre')
            ->where('activo','1')
            ->where('nombre','like','%' . $this->searchcargos . '%')
            ->distinct()
            ->orderBy('nombre')
            ->paginate(10,['*'], 'cargosPage');

        $lista_bienes = Patrimonios_biene::where('activo','1')
            ->where('cod_patrimonial','like','%' . $this->searchbienes . '%')
            ->distinct()
            ->orderBy('bien')
            ->paginate(10,['*'],'bienesPage');
        
        return view('livewire.administracion.patrimonio.desplazamiento.activos',
                    compact('lista_activos','lista_desplazamientos_detalle','lista_personas','lista_cargos','lista_bienes',
                        'lista_sedes','lista_dependencias')
                );
    }

    public function nuevo(){

        $this->resetValidation();   // ← limpia los errores
        $this->resetErrorBag();     // ← opcional extra seguridad

        // Restablecer todas las variables
        $this->reset();
        $this->foto = null;
        $this->fotoactual = null;
        $this->inputFileKey = rand();

        $this->funcionGuardarActualizar="guardar";

        $this->mostrarBtnBuscarDni = "d-none";

        $this->colorHeaderModal = "primary-subtle";
        $this->textoHeaderModal = "Nuevo";
        $this->colorGuardarActualizar = "primary";
        $this->textoGuardarActualizar = "Guardar";
        $this->colorAgregar = "outline-primary";
    }

    public function guardar(){

        DB::transaction(function () {
            // Crear cabecera del desplazamiento
            $idesplazamiento = Tbl_patrimonio_bienes_desplazamiento::create([
                'dni_solicitante' => $this->dni,
                'solicitante' => $this->dni . ' - ' . $this->datos . ' - ' . $this->cargo . ' - ' . $this->regimen,
                'dni_responsabletraslado' => $this->dni2,
                'responsabletraslado' => $this->dni2 . ' - ' . $this->datos2 . ' - ' . $this->cargo2 . ' - ' . $this->regimen2,
                'sede_origen' => $this->sede_origen,
                'dependencia_origen' => $this->dependencia_origen,
                'sede_destino' => $this->sede_destino,
                'dependencia_destino' => $this->dependencia_destino,
                'motivo_traslado' => mb_strtoupper($this->motivo_traslado),
                'tipotraslado' => $this->tipotraslado,
                'fechasalida' => $this->fechasalida,
                'fecharetorno' => $this->fecharetorno,
                'observacion' => mb_strtoupper($this->observacion),
                'traslado' => $this->traslado,
                'lista_equipos_traslado' => $this->lista_equipos_traslado,
                'activo' => 1,
                'created_user' => auth()->user()->datos,
                'updated_user' => auth()->user()->datos,
            ]);

            $iddesplazamiento = $idesplazamiento->id;

            // Recorrer bienes informáticos
            foreach ($this->tempbienesinformaticos as $temp) {
                // Guardar detalle
                Tbl_patrimonio_bienes_desplazamientos_detalle::create([
                    'id_biendesplazamiento' => $iddesplazamiento,
                    'cod_patrimonial' => $temp['cod_patrimonial'],
                    'traslado' => $this->traslado,
                    'activo' => 1,
                    'created_user' => auth()->user()->datos,
                    'updated_user' => auth()->user()->datos,
                ]);

                // Actualizar bien informático
                $ibien = Tbl_biene::where('cod_pat', $temp['cod_patrimonial'])->first();
                if ($ibien) {
                    $ibien->update([
                        'desplazamiento' => $this->traslado === "TRASLADADO" ? "1" : "0",
                    ]);
                } else {
                    dd('No se encontró el bien con código:', $temp['cod_patrimonial']);
                }
            }
        });

        // Resetear variables después de guardar
        $this->reset();

        $this->modal_abierto_bien_desplazamiento = false;
    }


    public function editar(){
        $this->modal_header_titulo = 'editar';
        $this->modal_header_color = 'success-subtle';
        $this->btn_guardar_actualizar = 'actualizar';
        $this->btn_guardar_actualizar_color = 'success';
    }

    public function actualizar(){
        
    }

    public function ver(Tbl_patrimonio_bienes_desplazamiento $instanciaTbl){
        $this->modal_abierto_bien_desplazamiento_detalle = true;
        $this->iddesplazamiento = $instanciaTbl->id;
    }

    public function imprimir(Tbl_patrimonio_bienes_desplazamiento $instanciaTbl){
        $this->modal_abierto_pdf_vista_previa = true;

        $this->iddesplazamiento = $instanciaTbl->id;
    }
    public function cerrar(){

        $this->reset([
            // Variables de traslado del bien informático
            'iddesplazamiento','solicitante','responsabletraslado','sede_origen','dependencia_origen','sede_destino','dependencia_destino','motivo_traslado','tipotraslado','traslado','activo_traslado',
            'iddesplazamientodetalle','fechasalida','fecharetorno','observacion','lista_equipos_traslado','activo_trasladodetalle',
            //Variables Personal
            'idpersonal','dni','datos','sede','dependencia','regimen','cargo','correo_personal','correo_institucional','cel_personal','cel_institucional','activo_personal',
            'idpersonal2','dni2','datos2','sede2','dependencia2','regimen2','cargo2','correo_personal2','correo_institucional2','cel_personal2','cel_institucional2','activo_personal2',
            //Variable tabla temporal
            'tempbienesinformaticos',
            //Variable para habilitar el agregar equipo informático
            'habilitar_btn_agregar_bienes',
        ]);

        $this->modal_abierto_bien_desplazamiento = false;
        $this->modal_abierto_bien_desplazamiento_detalle = false;
        $this->modal_abierto_pdf_vista_previa = false;
    }

    // ---- PROCESOS TIPO DE OPERACION ----
    Public function operacion_traslado_equipos(){
        $this->habilitar_btn_agregar_bienes = "";
        //Variable tabla temporal
        $this->reset(['tempbienesinformaticos']);

    }

    // ---- PROCESOS MODAL BUSCAR BIENINFORMATICO ----
    public function buscar_bien(){
       $this->modal_abierto_bienes= true;
    }

    public function agregar_bienes($item_cod_patrominial){
        // $this->btndisable = "disabled";
        $ibieninformatico = Tbl_biene::findOrFail($item_cod_patrominial);

        // Verificar si ya existe
        if (collect($this->tempbienesinformaticos)->contains('cod_patrimonial', $ibieninformatico->cod_pat)) {
            // Opcional: mensaje de error
            session()->flash('error', 'El equipo con código patrimonial ' . $ibieninformatico->cod_patrimonial . ' ya fue agregado.');
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
            $this->lista_equipos_traslado = $this->lista_equipos_traslado . PHP_EOL . $ibieninformatico->cod_pat;

            $this->modal_abierto_bienes= false;
        }        
    }

    public function cerrar_bienes(){

        $this->modal_abierto_bienes= false;
    }

    public function eliminar_buscar_bieninformatico($item_cod_patrominial){
        unset($this->tempbienesinformaticos[$item_cod_patrominial]);
        $this->tempbienesinformaticos = array_values($this->tempbienesinformaticos); // Reindexar el array
    } 

    // ---- PROCESOS MODAL NUEVO DESPLAZAMIENTO DEVOLVER ----

    Public function crear_devolver_registro(Tbl_patrimonio_bienes_desplazamiento $ibiendesplazado){
        $this->nuevo_editar="DEVOLVER";
        $this->color_modal_header="bg-warning-subtle";
        $this->color_boton = "btn-outline-warning";

        $this->iddesplazamiento = $ibiendesplazado->id;
        $this->solicitante = $ibiendesplazado->solicitante;
        $this->responsabletraslado = $ibiendesplazado->responsabletraslado;
        $this->sede_origen = $ibiendesplazado->sede_origen;
        $this->dependencia_origen = $ibiendesplazado->dependencia_origen;
        $this->sede_destino = $ibiendesplazado->sede_destino;
        $this->dependencia_destino = $ibiendesplazado->dependencia_destino;
        $this->motivo_traslado = $ibiendesplazado->motivo_traslado;
        $this->tipotraslado = $ibiendesplazado->tipotraslado;
        $this->fechasalida = $ibiendesplazado->fechasalida;
        $this->fecharetorno = $ibiendesplazado->fecharetorno;
        $this->observacion = $ibiendesplazado->observacion;
        $this->activo_traslado = $ibiendesplazado->activo_traslado;

        // Aquí llenamos el array
        $this->tempbienesinformaticos = DB::table('tbl_patrimonio_bienes_desplazamientos_detalles as d')
            ->join('tbl_patrimonio_bienes as b', 'b.cod_pat', '=', 'd.cod_patrimonial')
            ->where('d.id_biendesplazamiento', $this->iddesplazamiento)
            ->get()
            ->map(function ($item) {
                return (array) $item; // convierte cada objeto en array
            })
            ->toArray();
    }

    // PERSONAL
    // ---------------------------------------------------------
    public function buscar_personal($campo){
        $this->modal_abierto_personal_buscar = true;

        $this->solicitante_traslado= $campo;
    }

    public function agregar_personal(Tbl_personale $ipersonal){
        if ($this->solicitante_traslado === "solicitante") {
            $this->idpersonal = $ipersonal->id;
            $this->dni = $ipersonal->dni;
            $this->datos = $ipersonal->datos;
            $this->sede = $ipersonal->sede;
            $this->dependencia = $ipersonal->dependencia;
            $this->regimen = $ipersonal->regimen;
            $this->cargo = $ipersonal->cargo;

            $this->solicitante = $this->dni . ' - ' . $this->datos . ' - ' . $this->cargo . ' - ' . $this->regimen;

            $this->correo_personal = $ipersonal->correo_personal;
            $this->correo_institucional = $ipersonal->correo_institucional;
            $this->cel_personal = $ipersonal->cel_personal;
            $this->cel_institucional = $ipersonal->cel_institucional;
            $this->activo_personal = $ipersonal->activo;
        } else {
            $this->idpersonal2 = $ipersonal->id;
            $this->dni2 = $ipersonal->dni;
            $this->datos2 = $ipersonal->datos;
            $this->sede2 = $ipersonal->sede;
            $this->dependencia2 = $ipersonal->dependencia;
            $this->regimen2 = $ipersonal->regimen;
            $this->cargo2 = $ipersonal->cargo;

            $this->responsabletraslado = $this->dni2 . ' - ' . $this->datos2 . ' - ' . $this->cargo2 . ' - ' . $this->regimen2;

            $this->correo_personal2 = $ipersonal->correo_personal;
            $this->correo_institucional2 = $ipersonal->correo_institucional;
            $this->cel_personal2 = $ipersonal->cel_personal;
            $this->cel_institucional2 = $ipersonal->cel_institucional;
            $this->activo_personal2 = $ipersonal->activo;
        }

        $this->modal_abierto_personal_buscar = false;

        $this->reset('searchpersonal');
    }

    public function cerrar_personal(){
        $this->modal_abierto_personal_buscar = false;
    }

    // ---- PROCESOS MODAL BUSCAR CARGO ----

    public function agregar_buscar_cargo($cargo){
        $this->cargo = $cargo;
    }
    public function cerrar_buscar_cargo(){
        $this->reset('searchsede');
    }

    // ---- PROCESOS MODAL BUSCAR SEDE ----

    public function agregar_buscar_sede($sede){
        $this->sede_origen = $sede;
        $this->reset('searchsede');
    }
    public function agregar2_buscar_sede($sede){
        $this->sede_destino = $sede;
        $this->reset('searchsede');
    }
    public function cerrar_buscar_sede(){
        $this->reset('searchsede');
    }

    // ---- PROCESOS MODAL BUSCAR DEPENDENCIA ----

    public function agregar_buscar_dependencia($dependencia){
        $this->dependencia_origen = $dependencia;
        $this->reset('searchdependencia');
    }
    public function agregar2_buscar_dependencia($dependencia){
        $this->dependencia_destino = $dependencia;
        $this->reset('searchdependencia');
    }
    public function cerrar_buscar_dependencia(){
        $this->reset('searchdependencia');
    }

    // ---- PROCESOS MODAL CARGAR PDF ----
    public function cargarPDF1(Tbl_patrimonio_bienes_desplazamiento $instanciaTbl){
        $this->modal_abierto_pdf_cargar = true;

        $this->id_index = $instanciaTbl->id;
        $this->dni = $instanciaTbl->dni_solicitante;
        $this->dni2 = $instanciaTbl->dni_responsabletraslado;
        // $this->asignacion = $instanciaTbl->asignacion;
        // $this->codtoken = $instanciaTbl->codtoken;

    }

    public function cargarPDF2(){

       $this->validate([
            'pdf' => 'required|mimes:pdf|max:4096', // Máx. 4MB
        ]);

        // Generar un nombre personalizado con timestamp
        $fileName = 'solicitante_' . $this->dni . '_traslado_' . $this->dni2 . '.' . $this->pdf->getClientOriginalExtension();

        $path = $this->pdf->storeAs('archivos/patrimonio/actasdesplazamientobienes', $fileName, 'public');

        $instanciaTbl = Tbl_patrimonio_bienes_desplazamiento::findOrFail($this->id_index);

        $instanciaTbl->update([
            'actaruta' => 'storage/archivos/patrimonio/actasdesplazamientobienes/' . $fileName,
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

        $this->modal_abierto_pdf_cargar = false; 
    }

    public function cerrar_PDF(){
        $this->modal_abierto_pdf_cargar = false; 
    }
}
