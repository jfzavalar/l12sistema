<?php

namespace App\Livewire\Voluntariado\Asistencia;

use App\Models\Tbl_personale;
use App\Models\Tbl_sede;
use App\Models\Tbl_voluntariado;
use App\Models\tbl_voluntariado_marcacione;
use App\Models\Tbl_voluntariado_marcacione as ModelsTbl_voluntariado_marcacione;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Activos extends Component
{
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

    //Buscar
    public $searchpersonal;
    public function updatingSearchpersonal(){
        $this->resetPage();
    }
    public $searchbuscarpersonal;
    public function updatingSearchbuscarpersonal(){
        $this->resetPage('personalPage');
    }

    // Variables de tabla
    public $id_voluntario,
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

    // Variables de tabla
    public $entrada_salida,$fecha,$hora,
        $hora_entrada, $hora_salida;

    // Variables filtro
    public $filtro_fecha;

    public function mount()
    {
        $user = auth()->user();

        $this->codsede_destino = $user->codsede_destino;
        $this->coddependencia_destino = $user->coddependencia_destino;

        $this->fecha = now()->format('Y-m-d');
        $this->hora = now()->format('H:i:s');

        $this->filtro_fecha = now()->format('Y-m-d');
    }

    public function render()
    {
        $lista_activos = tbl_voluntariado_marcacione::where('activo', '1')
            ->when($this->filtro_fecha, function ($query) {
                $query->whereDate('fecha', $this->filtro_fecha);
            })
            ->when($this->searchpersonal !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->searchpersonal . '%')
                    ->orWhere('datos', 'like', '%' . $this->searchpersonal . '%');
                });
            })
            ->orderBy('id', 'desc')
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

        $lista_personal = Tbl_voluntariado::where('activo','1')
            ->where('dni','like','%' .$this->searchbuscarpersonal .'%')
            ->orwhere('datos','like','%' .$this->searchbuscarpersonal .'%')
            ->paginate(10,['*'],'personalPage');

        return view('livewire.voluntariado.asistencia.activos', 
                compact('lista_activos','lista_sedes','lista_dependencias','lista_personal'));
    }

    public function updatedDni($value)
    {
        // Buscar solo cuando el DNI tenga 8 dígitos
        if (strlen($value) === 8) {

            $persona = Tbl_voluntariado::where('dni', $value)->first();

            if ($persona) {
                $this->datos = $persona->datos;
                $this->cel_personal = $persona->cel_personal;
                $this->correo_personal = $persona->correo_personal;

            } else {
                // Si no existe, limpiar
                $this->datos = "";
                $this->cel_personal = "";
                $this->correo_personal = "";
            }
        } else {
            // Si DNI aún no tiene 8 dígitos, limpiar campos
            $this->datos = "";
            $this->cel_personal = "";
            $this->correo_personal = "";
        }
    }

    public function nuevo(){
        $this->reset([]);

        $this->modal_abierto_personal = true;

        $this->modal_header_titulo = 'nuevo';
        $this->modal_header_color = 'primary-subtle';
        $this->btn_guardar_actualizar = 'guardar';
        $this->btn_guardar_actualizar_color = 'primary';
        $this->fieldset_disable = '';

        $this->codsede_destino = auth()->user()->codsede_destino;
        $this->coddependencia_destino = auth()->user()->coddependencia_destino;

        $this->fecha = now()->format('Y-m-d');
        $this->hora = now()->format('H:i:s');
    }

    public function guardar()
    {
        try {
            // Validación
            $this->validate([
                'dni' => 'required',
                'datos' => 'required',
                'codsede_destino' => 'required',
                'coddependencia_destino' => 'required',
                'entrada_salida' => 'required|in:0,1',
            ]);

            // Determinar las fechas según entrada o salida
            // $horaEntrada = $this->entrada_salida === "1" ? now()->format('H:i:s') : null;
            // $horaSalida  = $this->entrada_salida === "0" ? now()->format('H:i:s') : null;

            // Obtener valores de sede y dependencia
            $sede = Tbl_sede::where('codsedeofi', $this->codsede_destino)->value('nomsedeofi');
            $dependencia = Tbl_sede::where('coddepofi', $this->coddependencia_destino)->value('nomdepofi');

            // Registrar
            tbl_voluntariado_marcacione::create([
                'dni'                    => $this->dni,
                'datos'                  => strtoupper($this->datos),
                'codsede_destino'        => $this->codsede_destino,
                'sede_destino'           => $sede,
                'coddependencia_destino' => $this->coddependencia_destino,
                'dependencia_destino'    => $dependencia,
                'entrada_salida'         => $this->entrada_salida,
                'fecha'                  => now()->format('Y-m-d'),
                'hora_entrada'            => now()->format('H:i:s'),
                // 'hora_salida'             => $horaSalida,
                'observacion'            => $this->observacion,
                'activo'                 => "1",
                'created_user'           => auth()->user()->datos,
                'updated_user'           => auth()->user()->datos,
            ]);

            // Reset solo del formulario
            $this->reset([
                'dni',
                'datos',
                // 'codsede_destino',
                'sede_destino',
                // 'coddependencia_destino',
                'dependencia_destino',
                'entrada_salida',
                'observacion',
            ]);

            // Cerrar modal
            $this->modal_abierto_personal = false;

            // Notificación
            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Datos guardados',
                mensaje: 'Los datos se han guardado correctamente.',
                tipo: 'success'
            );

        } catch (\Exception $e) {

            session()->flash('error', 'Error al guardar los datos: ' . $e->getMessage());
            $this->modal_abierto_personal = false;
        }
    }


    public function editar(Tbl_voluntariado_marcacione $instanciaTbl){
        $this->modal_abierto_personal = true;

        $this->modal_header_titulo = 'editar';
        $this->modal_header_color = 'success-subtle';
        $this->btn_guardar_actualizar = 'actualizar';
        $this->btn_guardar_actualizar_color = 'success';
        $this->fieldset_disable = '';

        $this->id_voluntario = $instanciaTbl->id;
        $this->dni = $instanciaTbl->dni;
        $this->datos = $instanciaTbl->datos;

        $this->codsede_destino = $instanciaTbl->codsede_destino;
        $this->sede_destino = $instanciaTbl->sede_destino;

        $this->coddependencia_destino = $instanciaTbl->coddependencia_destino;
        $this->dependencia_destino = $instanciaTbl->dependencia_destino;

        $this->entrada_salida= $instanciaTbl->entrada_salida;

        $this->fecha = $instanciaTbl->fecha_hora;
        $this->hora_entrada = $instanciaTbl->hora_entrada;
        $this->hora_salida = $instanciaTbl->hora_salida;

        $this->observacion = $instanciaTbl->observacion;

        $this->activo = $instanciaTbl->activo;

        $this->created_user = $instanciaTbl->created_user;
        $this->updated_user = $instanciaTbl->updated_user;
    }

    public function cerrar(){
        
        $this->modal_abierto_personal = false;
    }


    // PERSONAL
    // ---------------------------------------------------------
    public function buscar_personal(){
        $this->modal_abierto_personal_buscar = true;
    }

    public function agregar_personal(Tbl_voluntariado $ipersonal){
        $this->id_voluntario = $ipersonal->id;
        $this->dni = $ipersonal->dni;
        $this->datos = $ipersonal->datos;
        
        // $this->codsede_origen = $ipersonal->codsede_origen;
        // $this->sede_origen = $ipersonal->sede_origen;
        // $this->coddependencia_origen = $ipersonal->coddependencia_origen;
        // $this->dependencia_origen = $ipersonal->dependencia_origen;
        
        // $this->codsede_destino = $ipersonal->codsede_destino;
        // $this->sede_destino = $ipersonal->sede;
        // $this->coddependencia_destino = $ipersonal->coddependencia_destino;
        // $this->dependencia_destino = $ipersonal->dependencia_destino;

        // $this->regimen = $ipersonal->regimen;
        // $this->cargo = $ipersonal->cargo;
        // $this->correo_personal = $ipersonal->correo_personal;
        // $this->correo_institucional = $ipersonal->correo_institucional;
        // $this->cel_personal = $ipersonal->cel_personal;
        // $this->cel_institucional = $ipersonal->cel_institucional;

        $this->reset('searchbuscarpersonal');

        $this->modal_abierto_personal_buscar = false;
    }

    public function cerrar_personal(){
        $this->modal_abierto_personal_buscar = false;
    }

    public function actualizarHora()
    {
        $this->hora = now()->format('H:i:s');
    }
}
