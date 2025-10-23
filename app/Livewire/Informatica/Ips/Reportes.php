<?php

namespace App\Livewire\Informatica\Ips;
use App\Models\Tbl_personales_biene;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Reportes extends Component
{
    public function render()
    {
        $totales_por_sede = Tbl_personales_biene::select(
            'nomsedeofi',
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN ip IS NOT NULL AND ip <> "" THEN 1 ELSE 0 END) as con_ip'),
            DB::raw('SUM(CASE WHEN ip IS NULL OR ip = "" THEN 1 ELSE 0 END) as sin_ip')
        )
        ->where('activo', '1')
        ->where('clase', 'COMPUTO')
            ->where(function ($q) {
                $q->whereIn('familia', [
                    'COMPUTADORA PERSONAL PORTATIL',
                    'UNIDAD CENTRAL DE PROCESO - CPU'
                ])
                ->orWhere('familia', 'like', '%impreso%');
            })
            ->whereNotIn('nomsedeofi', [
                'CASA ACOGIDA TAMBO'
            ])
        ->groupBy('nomsedeofi')
        ->orderBy('nomsedeofi')
        ->get();

        return view('livewire.informatica.ips.reportes',
                compact('totales_por_sede'));
    }
}
