<?php

namespace App\Livewire\Contabilidad;

use App\Models\ContabilidadesGastosoperativo;
use App\Models\Persona;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class GastosoperativosComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    // Variables de búsqueda
    public $search;
    public function updatingSearch(){
        $this->resetPage('personalesPage');
    }

    //Variables
    public $observacioncambioestado;

    // Variables de Modal
    public $modal_abierto_alerta_cambio_estado = false;

    Public $filtrosede, $filtrodependencia;
    public $filtrotipodocumento;
    public $filtroregimen;
    public $filtroanio;

    public function mount()
    {
        $this->filtroanio = now()->year;
    }

    public function render()
    {
        $lista_activos = $this->queryConFiltros('CONTRATO')
            ->orderBy('personas.datos')
            ->paginate(30, ['personas.*'], 'personalesPage');

        $aniosBD = DB::table('contabilidades_gastosoperativos')
            ->select('anio') // cambia 'fecha' por tu campo real
            ->distinct()
            ->pluck('anio')
            ->toArray();

        // Año actual
        $anioActual = Carbon::now()->year;

        // Unir y evitar duplicados
        $anios = collect($aniosBD)
            ->push($anioActual)
            ->unique()
            ->sortDesc()
            ->values();

        return view('livewire.contabilidad.gastosoperativos-component',
                        compact('lista_activos','anios'));
    }

    private function queryConFiltros($tipoDocumento = null)
    {
        return Persona::join('personales', 'personas.id', '=', 'personales.persona_id')
            ->join('contabilidades_gastosoperativos', 'personas.id', '=', 'contabilidades_gastosoperativos.persona_id')
            ->select(
                'personas.*',
                'personales.persona_id',
                'personales.celinstitucional',
                'personales.correoinstitucional',
                'personales.regimen',
                'personales.tipo_regimen',
                'personales.cargo',
                'personales.sedeorigen',
                'personales.dependenciaorigen',
                'personales.despachoorigen',
                'personales.sededestino',
                'personales.dependenciadestino',
                'personales.despachodestino',
                'personales.tipo_documento',
                'contabilidades_gastosoperativos.id as gastosoperativos_id',
                'contabilidades_gastosoperativos.anio',
                'contabilidades_gastosoperativos.enero',
                'contabilidades_gastosoperativos.febrero',
                'contabilidades_gastosoperativos.marzo',
                'contabilidades_gastosoperativos.abril',
                'contabilidades_gastosoperativos.mayo',
                'contabilidades_gastosoperativos.junio',
                'contabilidades_gastosoperativos.julio',
                'contabilidades_gastosoperativos.agosto',
                'contabilidades_gastosoperativos.septiembre',
                'contabilidades_gastosoperativos.octubre',
                'contabilidades_gastosoperativos.noviembre',
                'contabilidades_gastosoperativos.diciembre',
            )
            ->where('personales.activo', 1)
            ->where('personales.cargo', 'like', 'FISCAL' . '%')
            ->where(function ($query) {
                if ($this->filtroanio) {
                    $query->where('contabilidades_gastosoperativos.anio', (int)$this->filtroanio);
                } else {
                    $query->where('contabilidades_gastosoperativos.anio', now()->year);
                }
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('personas.dni', 'like', '%' . $this->search . '%')
                    ->orWhere('personas.datos', 'like', '%' . $this->search . '%');
                });
            });
    }

    public function generarGastosOperativos($soloNuevo = false, $personaId = null)
    {
        $usuario = auth()->user()->datos; // Mejor que usar propiedad pública    
        
        $anioActual = Carbon::now()->year;

        $query = Persona::join('personales', 'personas.id', '=', 'personales.persona_id')
            ->select(
                'personas.id as persona_id',
                'personas.dni',
                'personales.id as personal_id',
                'personales.celinstitucional',
                'personales.correoinstitucional',
                'personales.regimen',
                'personales.tipo_regimen',
                'personales.cargo',
                'personales.sedeorigen',
                'personales.dependenciaorigen',
                'personales.despachoorigen',
                'personales.sededestino',
                'personales.dependenciadestino',
                'personales.despachodestino',
                'personales.tipo_documento'
            )
            ->where('personales.activo', 1)
            ->where('personales.cargo', 'like', 'FISCAL%');

        // 👉 Si solo quieres el nuevo fiscal
        if ($soloNuevo && $personaId) {
            $query->where('personas.id', $personaId);
        }

        $personas = $query->get();

        foreach ($personas as $persona) {

            // 🔒 Evitar duplicados por persona + año
            $existe = ContabilidadesGastosoperativo::where('persona_id', $persona->persona_id)
                ->where('anio', $anioActual)
                ->exists();

            if (!$existe) {
                ContabilidadesGastosoperativo::create([
                    'persona_id' => $persona->persona_id,
                    'dni' => $persona->dni,
                    'personal_id' => $persona->personal_id,

                    'anio' => $anioActual,

                    // Datos opcionales
                    // 'celular' => $persona->celinstitucional,
                    // 'correo' => $persona->correoinstitucional,
                    // 'cargo' => $persona->cargo,
                    // 'sede' => $persona->sededestino,
                    // 'dependencia' => $persona->dependenciadestino,
                    // 'despacho' => $persona->despachodestino,

                    // Meses inicializados en 0
                    'enero' => '0',
                    'febrero' => '0',
                    'marzo' => '0',
                    'abril' => '0',
                    'mayo' => '0',
                    'junio' => '0',
                    'julio' => '0',
                    'agosto' => '0',
                    'septiembre' => '0',
                    'octubre' => '0',
                    'noviembre' => '0',
                    'diciembre' => '0',

                    'activo' => '1',
                    'created_user' => $usuario,
                    'updated_user' => $usuario,
                ]);
            }
        }
    }

    public function entregado($gastosoperativos_id, $mes)
    {
        $registro = ContabilidadesGastosoperativo::find($gastosoperativos_id);

        // Si el mes está en 0, abrir el modal
        if ($registro->$mes == '1') {
            $this->modal_abierto_alerta_cambio_estado = true;

            // Guarda los datos para usarlos al confirmar
            $this->gastosoperativos_id = $gastosoperativos_id;
            $this->mes = $mes;

            return;
        }

        if (!$registro) return;

        $mesesPermitidos = [
            'enero','febrero','marzo','abril','mayo','junio',
            'julio','agosto','septiembre','octubre','noviembre','diciembre'
        ];

        if (!in_array($mes, $mesesPermitidos)) return;

        // 🔄 Toggle (0 ↔ 1)
        $registro->$mes = $registro->$mes == '1' ? '0' : '1';
        $registro->save();
    }

    public function cerrar_alerta_cambio_estado()
    {
        $this->modal_abierto_alerta_cambio_estado = false;
    }

}
