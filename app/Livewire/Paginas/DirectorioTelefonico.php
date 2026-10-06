<?php

namespace App\Livewire\Paginas;

use App\Models\InformaticasBienesAnexosAsignaciones;
use App\Models\Personales_dependencia;
use App\Models\Personales_sede;
use Livewire\Component;
use Livewire\WithPagination;

class DirectorioTelefonico extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    // VARIABLES DE FORMULARIO

    public $codsededestino = '',
            $coddependenciadestino = '';

    // VARIABLES INPUTS DE BUSQUEDA
    public $search = '',
            $searchsede = '',
            $searchdependencia = '',
            $searchanexo = '';

    public function updatingSearch(){
        $this->resetPage('directorioPage');
    }
    public function updatingSearchdependencia(){
        $this->resetPage('directorioPage');
    }
    public function updatingSearchanexo(){
        $this->resetPage('directorioPage');
    }

    public function render()
    {
        $lista_activos = InformaticasBienesAnexosAsignaciones::where('activo',1)
            // BUSCADOR
            ->when($this->search, function ($query) {

                $search = trim($this->search);

                $query->where(function ($q) use ($search) {
                    $q->where('dni', 'like', '%' . $search . '%')
                    ->orWhere('datos', 'like', '%' . $search . '%');
                });

            })

            // BUSCADOR POR SEDE
            ->when($this->searchsede, function ($query) {
                $searchsede = trim($this->searchsede);

                $query->where(function ($q) use ($searchsede) {
                    $q->where('codsededestino', $searchsede);
                });
            })

            // BUSCADOR POR DEPENDENCIA
            ->when($this->searchdependencia, function ($query) {
                $searchdependencia = trim($this->searchdependencia);

                $query->where(function ($q) use ($searchdependencia) {
                    $q->where('coddependenciadestino', $searchdependencia);
                });
            })

            

            // BUSCADOR POR DEPENDENCIA
            // ->when($this->searchdependencia, function ($query) {
            //     $searchdependencia = trim($this->searchdependencia);

            //     $keywords = explode(' ', $searchdependencia);

            //     $query->where(function ($q) use ($keywords) {
            //         foreach ($keywords as $word) {
            //             $q->where('dependenciadestino', 'like', '%' . $word . '%');
            //         }
            //     });
            // })

            // BUSCADOR POR ANEXO
            ->when($this->searchanexo, function ($query) {
                $searchanexo = trim($this->searchanexo);

                $query->where(function ($q) use ($searchanexo) {
                    $q->where('anexo', 'like', '%' . $searchanexo . '%');
                });
            })

            ->orderBy('datos')

            ->paginate();

        $lista_sedes = Personales_sede::select('id','nombre','nombred')
            ->where('activo','1')
            // ->where('nombre','like','%' . $this->searchsedes . '%')
            ->distinct()
            ->orderBy('nombre')
            ->get();

        $lista_dependencias = Personales_dependencia::select('id','nombre')
            ->where('activo','1')
            ->where('sede_id',$this->searchsede)
            // ->where('nombre','like','%' . $this->searchdependencias . '%')
            ->distinct()
            ->orderBy('nombre')
            ->get();

        return view('livewire.paginas.directorio-telefonico',
                compact('lista_activos','lista_sedes','lista_dependencias'));
    }
}
