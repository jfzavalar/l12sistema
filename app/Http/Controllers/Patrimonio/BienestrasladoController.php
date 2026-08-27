<?php

namespace App\Http\Controllers\Patrimonio;

use App\Http\Controllers\Controller;
use App\Models\PatrimoniosBiene;
use App\Models\PatrimoniosBienesAsignacione;
use App\Models\PatrimoniosBienesDesplazamientosTemporale;
use App\Models\PatrimoniosBienesDesplazamientosTemporalesDetalle;
use App\Models\Persona;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BienestrasladoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mpfn.patrimonio.traslado.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function exportarPDF($id)
    {
        // ✅ Obtener asignación
        $instanciaTbl = PatrimoniosBienesDesplazamientosTemporale::where('id',$id)
            ->where('activo','1')
            ->orderBy('id','desc')
            ->first();

        $instanciaTblDetalle = PatrimoniosBienesDesplazamientosTemporalesDetalle::where('desplazamiento_id',$id)
            ->where('activo','1')
            ->orderBy('id','desc')
            ->get();

        // ✅ Obtener bien (solo si existe)
        $iBien = null;

        if ($instanciaTbl->id) {
            $iBien = PatrimoniosBiene::join('patrimonios_bienes_desplazamientos_temporales_detalles','patrimonios_bienes.id','=','patrimonios_bienes_desplazamientos_temporales_detalles.bien_id')
                ->select(
                    'patrimonios_bienes.codigo_barra',
                    'patrimonios_bienes.codigo_patrimonial',
                    'patrimonios_bienes.descripcion',
                    'patrimonios_bienes.marca',
                    'patrimonios_bienes.modelo',
                    'patrimonios_bienes.nro_serie',
                    'patrimonios_bienes.medidas',
                    'patrimonios_bienes.estado',
                )
                ->where('desplazamiento_id', $instanciaTbl->id)
                ->get();
        }

        // 🔴 Validación importante
        if (!$instanciaTbl) {
            abort(404, 'Registro no encontrado');
        }

        // ✅ Generar PDF
        $pdf = Pdf::loadView('pdf.patrimonio.bienesdesplazamiento-acta', [
            'instanciaTbl' => $instanciaTbl,
            'instanciaTblDetalle' => $instanciaTblDetalle,
            'iBien' => $iBien,
        ])->setPaper('a4', 'landscape');

        // 🔥 Habilitar paginación (IMPORTANTE)
        $pdf->getDomPDF()->set_option("isPhpEnabled", true);

        return $pdf->stream('reportePDF.pdf');
    }
}
