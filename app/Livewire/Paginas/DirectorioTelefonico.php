<?php

namespace App\Livewire\Paginas;

use App\Models\InformaticasBienesAnexosAsignaciones;
use Livewire\Component;
use Livewire\WithPagination;

class DirectorioTelefonico extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    // VARIABLES INPUTS DE BUSQUEDA
    public $search = '',
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

            // BUSCADOR POR DEPENDENCIA
            ->when($this->searchdependencia, function ($query) {
                $searchdependencia = trim($this->searchdependencia);

                // Dividir en palabras clave
                $keywords = explode(' ', $searchdependencia);

                $query->where(function ($q) use ($keywords) {
                    foreach ($keywords as $word) {
                        $q->where('dependenciadestino', 'like', '%' . $word . '%');
                    }
                });
            })

            // BUSCADOR POR ANEXO
            ->when($this->searchanexo, function ($query) {
                $searchanexo = trim($this->searchanexo);

                $query->where(function ($q) use ($searchanexo) {
                    $q->where('anexo', 'like', '%' . $searchanexo . '%');
                });
            })

            ->orderBy('datos')

            ->paginate();

        return view('livewire.paginas.directorio-telefonico',
                compact('lista_activos'));
    }
}
