<?php

namespace App\Livewire\Admin\Dependencias;

use App\Models\Personales_dependencia;
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

class DependenciasComponent extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = "bootstrap";

    // Variables de búsqueda
    public $search;
    public function updatingSearch(){
        $this->resetPage('sedesPage');
    }

    public function render()
    {
        $lista_activos = Personales_dependencia::where('activo','1')
            ->where('nombre','like','%' . $this->search . '%')
            ->orderBy('nombre')
            ->paginate(30,['*'], 'sedesPage');

        return view('livewire.admin.dependencias.dependencias-component',
                        compact('lista_activos'));
    }
}
