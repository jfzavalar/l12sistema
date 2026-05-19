<?php

namespace App\Livewire\Voluntariado\Asistencia;

use App\Models\Personales_dependencia;
use App\Models\Personales_sede;
use App\Models\Tbl_personale;
use App\Models\Tbl_sede;
use App\Models\Tbl_voluntariado;
use App\Models\Tbl_voluntariado_marcacione;
use App\Models\Tbl_voluntariado_marcacione as ModelsTbl_voluntariado_marcacione;
use App\Models\Voluntarios;
use App\Models\VoluntariosMarcaciones;
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

    public $mostrarBtnBuscarDni = "d-none";

    public $colorHeaderModal, $textoHeaderModal;
    public $colorNuevoEditar = "primary-subtle", $textoNuevoEditar;
    public $colorGuardarActualizar = "primary", $textoGuardarActualizar;
    public $colorAgregar = "primary";

    //Variables PARA OCULTAR Y MOSTRAR TXT_OTROS
    public $mostrarcontroles = "d-none",$mostrarcontrolgpli="d-none";
    public $mostrarotrosp = "d-none", $mostrarotrosc = "d-none",$mostrarcargafoto = "d-none";

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
    public function updatedFiltroFecha()
    {
        $this->resetPage(); 
    }


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
        $lista_activos = VoluntariosMarcaciones::where('activo', '1')
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
            ->paginate(20);

        $lista_sedes = Personales_sede::select('id','cod','nombre','nombred')
            ->where('activo','1')
            // ->where('nombre','like','%' . $this->searchsedes . '%')
            ->distinct()
            ->orderBy('nombre')
            ->get();
            
        $lista_dependencias = Personales_dependencia::select('id','nombre','sede_id')
            ->where('activo','1')
            ->where('sede_id',$this->codsede_origen)
            // ->where('nombre','like','%' . $this->searchdependencias . '%')
            ->distinct()
            ->orderBy('nombre')
            ->get();

        $lista_voluntarios = Voluntarios::where('activo','1')
            ->where('dni','like','%' .$this->searchbuscarpersonal .'%')
            ->orwhere('datos','like','%' .$this->searchbuscarpersonal .'%')
            ->paginate(10,['*'],'personalPage');

        return view('livewire.voluntariado.asistencia.activos', 
                compact('lista_activos','lista_sedes','lista_dependencias','lista_voluntarios'));
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

            // VALIDACIÓN DE DUPLICADO (Entrada o Salida)
            $existe = Tbl_voluntariado_marcacione::where('dni', $this->dni)
                ->whereDate('fecha', now()->format('Y-m-d'))
                ->where('entrada_salida', $this->entrada_salida)
                ->where('activo', '1')
                ->exists();

            if ($existe) {
                $tipo = $this->entrada_salida == 1 ? 'entrada' : 'salida';

                $this->dispatch(
                    'alerta-actualizado',
                    titulo: 'Registro duplicado',
                    mensaje: "Ya registraste una $tipo el día de hoy.",
                    tipo: 'error'
                );
                return;
            }

            // Obtener datos de sede
            $sede = Tbl_sede::where('codsedeofi', $this->codsede_destino)->value('nomsedeofi');
            $dependencia = Tbl_sede::where('coddepofi', $this->coddependencia_destino)->value('nomdepofi');

            if ($this->entrada_salida == 1) {

                // === REGISTRAR ENTRADA ===
                Tbl_voluntariado_marcacione::create([
                    'dni'                    => $this->dni,
                    'datos'                  => strtoupper($this->datos),
                    'codsede_destino'        => $this->codsede_destino,
                    'sede_destino'           => $sede,
                    'coddependencia_destino' => $this->coddependencia_destino,
                    'dependencia_destino'    => $dependencia,
                    'entrada_salida'         => 1,
                    'fecha'                  => now()->format('Y-m-d'),
                    'hora_entrada'           => now()->format('H:i:s'),
                    'observacion'            => $this->observacion,
                    'activo'                 => "1",
                    'created_user'           => auth()->user()->datos,
                    'updated_user'           => auth()->user()->datos,
                ]);

            } else {

               // === REGISTRAR SALIDA ===
                $hoy = now()->format('Y-m-d');

                // Buscar la ENTRADA del día
                $instanciaTbl = Tbl_voluntariado_marcacione::where('dni', $this->dni)
                    ->whereDate('fecha', $hoy)
                    ->where('entrada_salida', 1)
                    ->where('activo', 1)
                    ->firstOrFail();

                // Calcular el tiempo del día
                $horaEntrada = Carbon::parse($instanciaTbl->hora_entrada);
                $horaSalida  = now(); // ← mejor forma

                $segundos = $horaEntrada->diffInSeconds($horaSalida);
                $subtotal = gmdate("H:i:s", $segundos);

                // Actualizar registro
                $instanciaTbl->update([
                    'hora_salida' => $horaSalida->format('H:i:s'),
                    'subtotal'    => $subtotal,
                    'updated_user' => auth()->user()->datos,
                ]);
                
            }

            // Reset formularios
            $this->reset([
                'dni',
                'datos',
                'sede_destino',
                'dependencia_destino',
                'entrada_salida',
                'observacion',
            ]);

            $this->dispatch('registroGuardado');

            $this->dispatch(
                'alerta-actualizado',
                titulo: 'Datos guardados',
                mensaje: 'Los datos se han guardado correctamente.',
                tipo: 'success'
            );

        } catch (\Exception $e) {
            session()->flash('error', 'Error al guardar los datos: ' . $e->getMessage());
        }
    }



    public function editar(Tbl_voluntariado_marcacione $instanciaTbl){

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
        
    }


    // PERSONAL
    // ---------------------------------------------------------
    public function buscar_voluntario(){
        
    }

    public function agregar_voluntario(Tbl_voluntariado $ipersonal){
        $this->id_voluntario = $ipersonal->id;
        $this->dni = $ipersonal->dni;
        $this->datos = $ipersonal->datos;

        $this->reset('searchbuscarpersonal');
    }

    public function cerrar_voluntario(){

    }

    public function actualizarHora()
    {
        $this->hora = now()->format('H:i:s');
    }
}
