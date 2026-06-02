<?php

namespace App\Livewire\Voluntariado\Asistencia;

use App\Models\Personales_dependencia;
use App\Models\Personales_sede;
use App\Models\Tbl_sede;
use App\Models\Voluntariado;
use App\Models\VoluntariadosMarcacione;
use Carbon\Carbon;
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

    // Variables UI
    public $mostrarcontroles = "d-none",
        $mostrarcontrolgpli = "d-none",
        $mostrarotrosp = "d-none",
        $mostrarotrosc = "d-none",
        $mostrarcargafoto = "d-none";

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

    // Variables asistencia
    public $entrada_salida,
        $fecha,
        $hora,
        $hora_entrada,
        $hora_salida;

    // Filtro
    public $filtro_fecha;

    // Buscar
    public $searchmarcaciones = '';
    public $searchbuscarvoluntario = '';

    public function updatingSearchmarcaciones()
    {
        $this->resetPage('marcacionesPage');
    }

    public function updatingSearchbuscarvoluntario()
    {
        $this->resetPage('voluntariosPage');
    }

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
        $lista_activos = VoluntariadosMarcacione::where('activo', 1)
            ->when($this->filtro_fecha, function ($query) {
                $query->whereDate('fecha', $this->filtro_fecha);
            })
            ->when($this->searchmarcaciones, function ($query) {
                $query->where(function ($q) {
                    $q->where('dni', 'like', '%' . $this->searchmarcaciones . '%')
                        ->orWhere('datos', 'like', '%' . $this->searchmarcaciones . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10, ['*'], 'marcacionesPage');

        $lista_sedes = Personales_sede::select('id', 'cod', 'nombre', 'nombred')
            ->where('activo', 1)
            ->distinct()
            ->orderBy('nombre')
            ->get();

        $lista_dependencias = Personales_dependencia::select('id', 'nombre', 'sede_id')
            ->where('activo', 1)
            ->where('sede_id', $this->codsede_origen)
            ->distinct()
            ->orderBy('nombre')
            ->get();

        $lista_voluntarios = Voluntariado::where('activo', 1)
            ->where(function ($query) {
                $query->where('dni', 'like', '%' . $this->searchbuscarvoluntario . '%')
                    ->orWhere('datos', 'like', '%' . $this->searchbuscarvoluntario . '%');
            })
            ->paginate(10, ['*'], 'voluntariosPage');

        return view(
            'livewire.voluntariado.asistencia.activos',
            compact(
                'lista_activos',
                'lista_sedes',
                'lista_dependencias',
                'lista_voluntarios'
            )
        );
    }

    public function updatedDni($value)
    {
        if (strlen($value) === 8) {

            $persona = Voluntariado::where('dni', $value)->first();

            if ($persona) {
                $this->datos = $persona->datos;
                $this->cel_personal = $persona->cel_personal;
                $this->correo_personal = $persona->correo_personal;
            } else {
                $this->datos = "";
                $this->cel_personal = "";
                $this->correo_personal = "";
            }
        } else {
            $this->datos = "";
            $this->cel_personal = "";
            $this->correo_personal = "";
        }
    }

    public function nuevo()
    {
        $this->reset([
            'dni',
            'datos',
            'entrada_salida',
            'observacion',
            'hora_entrada',
            'hora_salida'
        ]);
    }

    public function guardar()
    {
        try {

            $this->validate([
                'dni' => 'required',
                'datos' => 'required',
                'codsede_destino' => 'required',
                'coddependencia_destino' => 'required',
                'entrada_salida' => 'required|in:0,1',
            ]);

            $existe = VoluntariadosMarcacione::where('dni', $this->dni)
                ->whereDate('fecha', now()->format('Y-m-d'))
                ->where('entrada_salida', $this->entrada_salida)
                ->where('activo', 1)
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

            $sede = Tbl_sede::where('codsedeofi', $this->codsede_destino)
                ->value('nomsedeofi');

            $dependencia = Tbl_sede::where('coddepofi', $this->coddependencia_destino)
                ->value('nomdepofi');

            // ENTRADA
            if ($this->entrada_salida == 1) {

                VoluntariadosMarcacione::create([

                    'dni' => $this->dni,
                    'datos' => strtoupper($this->datos),

                    'codsede_destino' => $this->codsede_destino,
                    'sede_destino' => $sede,

                    'coddependencia_destino' => $this->coddependencia_destino,
                    'dependencia_destino' => $dependencia,

                    'entrada_salida' => 1,

                    'fecha' => now()->format('Y-m-d'),

                    'hora_entrada' => now()->format('H:i:s'),

                    'observacion' => $this->observacion,

                    'activo' => 1,

                    'created_user' => auth()->user()->datos,
                    'updated_user' => auth()->user()->datos,
                ]);

            } else {

                // SALIDA
                $hoy = now()->format('Y-m-d');

                $instanciaTbl = VoluntariadosMarcacione::where('dni', $this->dni)
                    ->whereDate('fecha', $hoy)
                    ->where('entrada_salida', 1)
                    ->where('activo', 1)
                    ->first();

                if (!$instanciaTbl) {

                    $this->dispatch(
                        'alerta-actualizado',
                        titulo: 'Sin entrada',
                        mensaje: 'No existe una entrada registrada para hoy.',
                        tipo: 'warning'
                    );

                    return;
                }

                $horaEntrada = Carbon::parse($instanciaTbl->hora_entrada);
                $horaSalida = now();

                $segundos = $horaEntrada->diffInSeconds($horaSalida);

                $subtotal = gmdate("H:i:s", $segundos);

                $instanciaTbl->update([

                    'hora_salida' => $horaSalida->format('H:i:s'),
                    'subtotal' => $subtotal,
                    'updated_user' => auth()->user()->datos,

                ]);
            }

            $this->reset([
                'dni',
                'datos',
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

            session()->flash(
                'error',
                'Error al guardar los datos: ' . $e->getMessage()
            );
        }
    }

    public function editar(VoluntariadosMarcacione $instanciaTbl)
    {
        $this->id_voluntario = $instanciaTbl->id;

        $this->dni = $instanciaTbl->dni;
        $this->datos = $instanciaTbl->datos;

        $this->codsede_destino = $instanciaTbl->codsede_destino;
        $this->sede_destino = $instanciaTbl->sede_destino;

        $this->coddependencia_destino = $instanciaTbl->coddependencia_destino;
        $this->dependencia_destino = $instanciaTbl->dependencia_destino;

        $this->entrada_salida = $instanciaTbl->entrada_salida;

        $this->fecha = $instanciaTbl->fecha;

        $this->hora_entrada = $instanciaTbl->hora_entrada;
        $this->hora_salida = $instanciaTbl->hora_salida;

        $this->observacion = $instanciaTbl->observacion;

        $this->activo = $instanciaTbl->activo;

        $this->created_user = $instanciaTbl->created_user;
        $this->updated_user = $instanciaTbl->updated_user;
    }

    public function agregar_voluntario(Voluntariado $ipersonal)
    {
        $this->id_voluntario = $ipersonal->id;

        $this->dni = $ipersonal->dni;
        $this->datos = $ipersonal->datos;

        $this->reset('searchbuscarvoluntario');
    }

    public function actualizarHora()
    {
        $this->hora = now()->format('H:i:s');
    }
}