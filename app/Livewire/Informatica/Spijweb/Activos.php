<?php

namespace App\Livewire\Informatica\Spijweb;

use App\Mail\NotificacionInformatica;
use App\Mail\NotificacionInformaticaSpijweb;

use App\Models\Tbl_personale;
use App\Models\Tbl_spijweb;

use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Activos extends Component
{

    use WithFileUploads;

    use WithPagination;
    protected $paginationTheme = "bootstrap";

    //Variables spijweb
    public $idspijweb,$usuariospijweb,$passwordspijweb,$estado_formato,$estado_userpass;
    Public $idpersonal,$dni,$datos,$sede_origen,$dependencia_origen,$regimen,$cargo,$correo_personal,$correo_institucional,$cel_personal,$cel_institucional,$activo;

    //Variables de modal Nuevo-Editar
    public $nuevo_editar="NUEVO",$color_modal_header="bg-primary-subtle",$color_boton="btn-outline-primary";
    public $guardar_actualizar;

    public $pdf,$pdftutorial;

    //Variables de modal buscar spijweb
    public $search;
    public function updatingSearch(){
        $this->resetPage();
        $this->reset(['filtro_formatos', 'filtro_usuario', 'filtro_usuarios','filtro_rutas']);
    }

    //Variables de modal buscar personal
    public $searchpersonal;
    public function updatingSearchpersonal(){
        $this->resetPage();
    }
    //Variables de modal buscar sede_dependencia
    public $searchcargo;
    public function updatingSearchcargo(){
        $this->resetPage();
    }
    public $searchdependencia;
    public function updatingSearchdependencia(){
        $this->resetPage();
    }
    public $searchsede;
    public function updatingSearchsede(){
        $this->resetPage();
    }

    public $filtro_formatos, $filtro_usuario, $filtro_usuarios, $filtro_rutas;
    public function updatingFiltroFormatos(){
        $this->resetPage();
        $this->reset(['search', 'filtro_usuario', 'filtro_usuarios','filtro_rutas']);
    }
    public function updatingFiltroUsuario(){
        $this->resetPage();
        $this->reset(['filtro_formatos', 'search', 'filtro_usuarios','filtro_rutas']);
    }
    public function updatingFiltroUsuarios(){
        $this->resetPage();
        $this->reset(['filtro_formatos', 'filtro_usuario', 'search','filtro_rutas']);
    }
    public function updatingFiltroRutas(){
        $this->resetPage();
        $this->reset(['filtro_formatos', 'filtro_usuario', 'filtro_usuarios','search']);
    }

    public function mount(){
        $this->search = '';
        $this->filtro_usuario = '';
        $this->filtro_usuarios = '';
        $this->filtro_formatos = '';
        $this->filtro_rutas = '';
    }

    public function render()
    {
        $lista_activos = DB::table('tbl_spijwebs')
            ->select('id','dni','datos','sede_origen','dependencia_origen','regimen','cargo','correo_personal','correo_institucional','cel_personal','cel_institucional','actaruta',
                    'usuariospijweb','passwordspijweb','estado_formato','estado_userpass','activo','created_user','updated_user')
            ->where('activo',"1")
            ->when($this->search !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->search . '%')
                    ->orWhere('datos', 'like', '%' . $this->search . '%');
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

            // Filtro por formatos
            ->when($this->filtro_formatos === 'ENVIADO', function ($query) {
                $query->whereNotNull('estado_formato')->where('estado_formato', '=', 'ENVIADO');
            })            
            ->when($this->filtro_formatos === 'PENDIENTE', function ($query) {
                $query->where(function ($subquery) {
                    $subquery->whereNull('estado_formato')->orWhere('estado_formato', '=','PENDIENTE');
                });
            })

            // Filtro por userpass
            ->when($this->filtro_usuarios === 'ENVIADO', function ($query) {
                $query->whereNotNull('estado_userpass')->where('estado_userpass', '=', 'ENVIADO');
            })            
            ->when($this->filtro_usuarios === 'PENDIENTE', function ($query) {
                $query->where(function ($subquery) {
                    $subquery->whereNull('estado_userpass')->orWhere('estado_userpass', '=','PENDIENTE');
                });
            })

            ->orderBy('id','desc')
            ->paginate();

        $conteo_rutas = DB::table('tbl_spijwebs')
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN actaruta IS NULL OR actaruta = '' THEN 1 ELSE 0 END) as sin_ruta,
                SUM(CASE WHEN actaruta IS NOT NULL AND actaruta <> '' THEN 1 ELSE 0 END) as con_ruta
            ")
            ->where('activo', '1')
            ->first();
        
        $lista_inactivos = DB::table('tbl_spijwebs')
            ->select('id','dni','datos','sede','dependencia','regimen','cargo','correo_personal','correo_institucional','cel_personal','cel_institucional','actaruta',
                    'usuariospijweb','passwordspijweb','estado_formato','estado_userpass','activo')
            ->where('activo',"0")
            ->where(function ($query) {$query
                ->where('dni', 'like', '%' . $this->search . '%')
                ->orWhere('datos', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id','desc')
            ->paginate();
            
        $totales_asignados = DB::table('tbl_spijwebs')
            ->select(
                'created_user',
                DB::raw("SUM(CASE WHEN estado_formato = 'ENVIADO' THEN 1 ELSE 0 END) AS total_enviados"),
                DB::raw("SUM(CASE WHEN estado_formato = 'PENDIENTE' THEN 1 ELSE 0 END) AS total_pendientes"),
                DB::raw("SUM(CASE WHEN estado_userpass = 'ENVIADO' THEN 1 ELSE 0 END) AS total_enviados_u"),
                DB::raw("SUM(CASE WHEN estado_userpass = 'PENDIENTE' THEN 1 ELSE 0 END) AS total_pendientes_u")
            )
            ->where('activo', "1")
            ->groupBy('created_user')
            ->get();

        $lista_personal = DB::table('tbl_personales')
            ->select('id','dni','datos','sede_origen','dependencia_origen','regimen','cargo','correo_personal','correo_institucional','cel_personal','cel_institucional','activo')
            ->where('dni','like','%' .$this->searchpersonal .'%')
            ->orwhere('datos','like','%' .$this->searchpersonal .'%')
            ->paginate(5);

        $lista_cargo = DB::table('tbl_cargos')
            ->select('cargo')
            ->where('activo','1')
            ->where('cargo','like','%' . $this->searchcargo . '%')
            ->orderBy('cargo')
            ->paginate(30);

        $lista_sede = DB::table('tbl_sedes_dependencias')
            ->select('sede')
            ->distinct()
            ->where('sede','like','%' . $this->searchsede . '%')
            ->orderBy('sede')
            ->paginate(30);

        $lista_dependencia = DB::table('tbl_sedes_dependencias')
            ->select('dependencia')
            ->distinct()
            ->where('sede',$this->sede_origen)
            ->where('dependencia','like','%' . $this->searchdependencia . '%')
            ->orderBy('dependencia')
            ->paginate();

        return view('livewire.informatica.spijweb.activos',
                compact('lista_activos','conteo_rutas','lista_inactivos','totales_asignados','lista_personal','lista_cargo','lista_sede','lista_dependencia'));
    }

    // -----------------------------------------------------------------------------------------------

    public function filtro_total(){
        $this->reset('filtro_formatos','filtro_usuario','filtro_usuarios','filtro_rutas');
    }

    // -----------------------------------------------------------------------------------------------

    public function nuevo(){
        $this->nuevo_editar = "NUEVO";
        $this->color_modal_header = "bg-primary-subtle";
        $this->color_boton = "btn-outline-primary";

        $this->guardar_actualizar="guardar";

    }

    public function guardar(){
        $this->validate([
            'dni' => 'required|digits:8|unique:tbl_spijwebs,dni,' . $this->idspijweb,
        ], [
            'dni.required' => 'El campo DNI es obligatorio.',
            'dni.digits' => 'El DNI debe tener exactamente 8 dígitos.',
            'dni.unique' => 'Este DNI ya está registrado.',
        ]);

        Tbl_spijweb::create([
            // 'id',
            'dni' => $this->dni,
            'datos' => mb_strtoupper($this->datos),
            'sede_origen' => $this->sede_origen ?? 'SIN SEDE',
            'dependencia_origen' => $this->dependencia_origen ?? 'SIN DEPENDENCIA',
            'regimen' => $this->regimen,
            'cargo' => $this->cargo,
            'correo_personal' => $this->correo_personal,
            'correo_institucional' => $this->correo_institucional,
            'cel_personal' => $this->cel_personal,
            'cel_institucional' => $this->cel_institucional,

            'usuariospijweb' => $this->usuariospijweb,
            'passwordspijweb' => $this->passwordspijweb,
            'estado_formato' => "PENDIENTE",
            'estado_userpass' => "PENDIENTE",
            'activo' => "1",
            //
            'created_user' => auth()->user()->datos,
            'updated_user' => auth()->user()->datos,
        ]);

        //Reiniciar variables
        $this->reset('idspijweb','usuariospijweb','passwordspijweb','estado_formato','estado_userpass');
        $this->reset('idpersonal','dni','datos','sede_origen','dependencia_origen','regimen','cargo','correo_personal','correo_institucional','cel_personal','cel_institucional','activo');
    
        //Emitir evento al frontend
        $this->dispatch('cerrar-modal');
    }

    public function cargarPDF1(Tbl_spijweb $instanciaTbl){
        $this->idspijweb = $instanciaTbl->id;
        $this->dni = $instanciaTbl->dni;
        // $this->asignacion = $instanciaTbl->asignacion;
        // $this->codtoken = $instanciaTbl->codtoken;

    }

    public function cargarPDF2(){
        $this->validate([
            'pdf' => 'required|mimes:pdf|max:4096', // Máx. 4MB
        ]);

        // Generar un nombre personalizado con timestamp
        $fileName = $this->dni . '.' . $this->pdf->getClientOriginalExtension();

        // Guardar en la carpeta storage/app/public/pdfs
        $path = $this->pdf->storeAs('public/archivos/informatica/spijweb', $fileName);

        //guardar ruta del archivo
        // dd($this->idspijweb);
        $instanciaTbl = Tbl_spijweb::findOrFail($this->idspijweb);

        $instanciaTbl->update([
            'actaruta' => str_replace( 'public/','storage/',$path),

            'updated_user' => auth()->user()->datos,
        ]);

        // Limpia el archivo de la propiedad Livewire si lo deseas
        // $this->reset('pdf');
        $this->dispatch('reset-pdf-input');

        // Cerrar el modal en el navegador
        $this->dispatch('cerrar-modal-pdf');

        // Opcional: mostrar un mensaje flash
        session()->flash('message', 'PDF cargado correctamente.');
    }

    public function exportarPDF($id)
    {
        $instanciaTbl = Tbl_spijweb::findOrFail($id);

        $pdf = Pdf::loadView('pdf.informatica.spijweb-acta', compact('instanciaTbl'));

        //Mostrar PDF
        // return $pdf->stream('spijweb_'.$instanciaTbl->dni.'.pdf');
        
        //Descargar PDF
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'spijweb_'.$instanciaTbl->dni.'.pdf');
    }

    public function cerrar_nuevo(){
        //Reiniciar variables
        $this->reset('idspijweb','usuariospijweb','passwordspijweb','estado_formato','estado_userpass');
        $this->reset('idpersonal','dni','datos','sede_origen','dependencia_origen','regimen','cargo','correo_personal','correo_institucional','cel_personal','cel_institucional','activo');

        // ... algún error
        $this->dispatch('cancelar-proceso');
    }

    // -----------------------------------------------------------------------------------------------
    
    public function editar(Tbl_spijweb $instanciaTbl){
        $this->nuevo_editar = "EDITAR";
        $this->color_modal_header = "bg-success-subtle";
        $this->color_boton = "btn-outline-success";
        $this->guardar_actualizar="actualizar";
        
        // - Editar -
        $this->idspijweb = $instanciaTbl->id;
        $this->dni = $instanciaTbl->dni;
        $this->datos = $instanciaTbl->datos;
        $this->sede_origen = $instanciaTbl->sede;
        $this->dependencia_origen = $instanciaTbl->dependencia;
        $this->regimen = $instanciaTbl->regimen;
        $this->cargo = $instanciaTbl->cargo;
        $this->correo_personal = $instanciaTbl->correo_personal;
        $this->correo_institucional = $instanciaTbl->correo_institucional;
        $this->cel_personal = $instanciaTbl->cel_personal;
        $this->cel_institucional = $instanciaTbl->cel_institucional;

        $this->usuariospijweb = $instanciaTbl->usuariospijweb;
        $this->passwordspijweb = $instanciaTbl->passwordspijweb;
        $this->estado_formato = $instanciaTbl->estado_formato;
        $this->estado_userpass = $instanciaTbl->estado_userpass;

        $this->activo = $instanciaTbl->activo;
    }

    public function actualizar(){
        $instanciaTbl = Tbl_spijweb::findOrFail($this->idspijweb);

        $instanciaTbl->update([
            // 'id',
            'dni' => $this->dni,
            'datos' => mb_strtoupper($this->datos),
            'sede_origen' => $this->sede_origen,
            'dependencia_origen' => $this->dependencia_origen,
            'regimen' => $this->regimen,
            'cargo' => $this->cargo,
            'correo_personal' => mb_strtolower($this->correo_personal),
            'correo_institucional' => ($this->correo_institucional),
            'cel_personal' => $this->cel_personal,
            'cel_institucional' => $this->cel_institucional,

            'usuariospijweb' => $this->usuariospijweb,
            'passwordspijweb' => $this->passwordspijweb,
            'estado_formato' => $this->estado_formato,
            'estado_userpass' => $this->estado_userpass,

            'activo' => "1",
            //
            //'created_user' => auth()->user()->datos,
            'updated_user' => auth()->user()->datos,
        ]);

        //Reiniciar variables
        $this->reset('idspijweb','usuariospijweb','passwordspijweb','estado_formato','estado_userpass');
        $this->reset('idpersonal','dni','datos','sede_origen','dependencia_origen','regimen','cargo','correo_personal','correo_institucional','cel_personal','cel_institucional','activo');

        //Emitir evento al frontend
        $this->dispatch('cerrar-modal');
    }

    public function cerrar_actualizar(){
        //Reiniciar variables
        $this->reset('idspijweb','usuariospijweb','passwordspijweb','estado_formato','estado_userpass');
        $this->reset('idpersonal','dni','datos','sede_origen','dependencia_origen','regimen','cargo','correo_personal','correo_institucional','cel_personal','cel_institucional','activo');
    }

    // -----------------------------------------------------------------------------------------------
    // Modal enviar Correo
    public function enviar_correo1(Tbl_spijweb $instanciaTbl){
        // $this->nuevo_editar = "EDITAR";
        // $this->color_modal_header = "bg-success-subtle";
        // $this->color_boton = "btn-outline-success";
        // $this->guardar_actualizar="actualizar";
        
        // - Editar -
        $this->idspijweb = $instanciaTbl->id;
        $this->dni = $instanciaTbl->dni;
        $this->datos = $instanciaTbl->datos;
        $this->sede_origen = $instanciaTbl->sede;
        $this->dependencia_origen = $instanciaTbl->dependencia;
        $this->regimen = $instanciaTbl->regimen;
        $this->cargo = $instanciaTbl->cargo;
        $this->correo_personal = $instanciaTbl->correo_personal;
        $this->correo_institucional = $instanciaTbl->correo_institucional;
        $this->cel_personal = $instanciaTbl->cel_personal;
        $this->cel_institucional = $instanciaTbl->cel_institucional;

        $this->usuariospijweb = $instanciaTbl->usuariospijweb;
        $this->passwordspijweb = $instanciaTbl->passwordspijweb;

        $this->activo = $instanciaTbl->activo;
    }
    public function enviar_correo2(){
        //Actualizar estado_formato
        $instanciaTbl = Tbl_spijweb::findOrFail($this->idspijweb);
        $instanciaTbl->update([
            //'id',
            //'dni' => $this->dni,
            //'datos' => $this->datos,
            //'sede' => $this->sede,
            //'dependencia' => $this->dependencia,
            //'regimen' => $this->regimen,
            //'cargo' => $this->cargo,
            //'correo_personal' => $this->correo_personal,
            //'correo_institucional' => $this->correo_institucional,
            //'cel_personal' => $this->cel_personal,
            //'cel_institucional' => $this->cel_institucional,

            //'usuariospijweb' => $this->usuariospijweb,
            //'passwordspijweb' => $this->passwordspijweb,
            'estado_formato' => "ENVIADO",
            //'estado_userpass' => $this->estado_userpass,

            //'activo' => "1",
            //
            //'created_user' => auth()->user()->datos,
            'updated_user' => auth()->user()->datos,
        ]);

        // 1. Generar el PDF como contenido binario
        $pdf = Pdf::loadView('pdf.informatica.spijweb-acta', [
            'dni' => $this->dni,
            'datos' => $this->datos,
            'cargo' => $this->cargo,
            'sede' => $this->sede,
            'dependencia' => $this->dependencia,
        ])->output();

        $pdftutorial = public_path('tutoriales/2025_manual_firma_spijweb.pdf');

        // Verificación opcional
        if (!file_exists($pdftutorial)) {
            session()->flash('error', "Uno o ambos archivos no existen.");
            return;
        }

        Mail::to($this->correo_institucional)->send(
            new NotificacionInformatica(
                $this->dni,
                $this->datos,
                $this->cargo,
                $this->sede,
                $this->dependencia,
                $pdf,
                $pdftutorial
            )
        );

        //Reiniciar variables
        $this->reset('idspijweb','usuariospijweb','passwordspijweb','estado_formato','estado_userpass');
        $this->reset('idpersonal','dni','datos','sede_origen','dependencia_origen','regimen','cargo','correo_personal','correo_institucional','cel_personal','cel_institucional','activo');

        //Emitir evento al frontend
        $this->dispatch('cerrar-enviar-modal');

        session()->flash('success', "Correo enviado a {$this->correo_institucional} correctamente.");
    }

    public function enviar_correo3(){
        //Actualizar estado_formato
        $instanciaTbl = Tbl_spijweb::findOrFail($this->idspijweb);
        $instanciaTbl->update([
            //'id',
            //'dni' => $this->dni,
            //'datos' => $this->datos,
            //'sede' => $this->sede,
            //'dependencia' => $this->dependencia,
            //'regimen' => $this->regimen,
            //'cargo' => $this->cargo,
            //'correo_personal' => $this->correo_personal,
            //'correo_institucional' => $this->correo_institucional,
            //'cel_personal' => $this->cel_personal,
            //'cel_institucional' => $this->cel_institucional,

            //'usuariospijweb' => $this->usuariospijweb,
            //'passwordspijweb' => $this->passwordspijweb,
            //'estado_formato' => "ENVIADO",
            'estado_userpass' => "ENVIADO",

            //'activo' => "1",
            //
            //'created_user' => auth()->user()->datos,
            'updated_user' => auth()->user()->datos,
        ]);
        
        Mail::to($this->correo_institucional)->send(
            new NotificacionInformaticaSpijweb(
                $this->dni,
                $this->datos,
                $this->cargo,
                $this->sede,
                $this->dependencia,
                $this->usuariospijweb,
                $this->passwordspijweb,
            )
        );

        //Reiniciar variables
        $this->reset('idspijweb','usuariospijweb','passwordspijweb','estado_formato','estado_userpass');
        $this->reset('idpersonal','dni','datos','sede_origen','dependencia_origen','regimen','cargo','correo_personal','correo_institucional','cel_personal','cel_institucional','activo');

        //Emitir evento al frontend
        $this->dispatch('cerrar-enviar-modal');

        session()->flash('success', "Correo enviado a {$this->correo_institucional} correctamente.");
    }

    // -----------------------------------------------------------------------------------------------
    // Modal buscar Personal
    public function agregar_buscar_personal(Tbl_personale $ipersonal){
        $this->idpersonal = $ipersonal->idpersonal;
        $this->dni = $ipersonal->dni;
        $this->datos = $ipersonal->datos;
        $this->sede_origen = $ipersonal->sede_origen;
        $this->dependencia_origen = $ipersonal->dependencia_origen;
        $this->regimen = $ipersonal->regimen;
        $this->cargo = $ipersonal->cargo;
        $this->correo_personal = $ipersonal->correo_personal;
        $this->correo_institucional = $ipersonal->correo_institucional;
        $this->cel_personal = $ipersonal->cel_personal;
        $this->cel_institucional = $ipersonal->cel_institucional;
        $this->activo = $ipersonal->activo;

        $this->reset('searchpersonal');
    }

    public function cerrar_buscar_personal(){
        $this->reset('searchpersonal');
    }

    public function agregar_buscar_cargo($cargo){
        $this->cargo = $cargo;
    }
    public function cerrar_buscar_cargo(){
        $this->reset('searchcargo');
    }
    
    public function agregar_buscar_sede($sede){
        $this->sede_origen = $sede;
    }
    public function cerrar_buscar_sede(){
        $this->reset('searchsede');
    }

    public function agregar_buscar_dependencia($dependencia){
        $this->dependencia_origen = $dependencia;
    }
    public function cerrar_buscar_dependencia(){
        $this->reset('searchdependencia');
    }

    // -----------------------------------------------------------------------------------------------
    // Alertas
    protected $listeners = ['eliminar','reactivar'];
    
    public function eliminar($id)
    {
        $instanciaTbl = Tbl_spijweb::findOrFail($id);

        $instanciaTbl->update([
            'activo' => '0',
            'updated_user' => auth()->user()->datos,
        ]);

        // Notificar al navegador que se eliminó
        $this->dispatch('registroEliminado');
    }

    public function reactivar($id)
    {
        $instanciaTbl = Tbl_spijweb::findOrFail($id);

        $instanciaTbl->update([
            'activo' => '1',
            'updated_user' => auth()->user()->datos,
        ]);

        // Notificar al navegador que se eliminó
        $this->dispatch('registroActivado');
    }
}
