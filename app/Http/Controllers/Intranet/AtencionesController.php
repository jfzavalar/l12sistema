<?php

namespace App\Http\Controllers\Intranet;

use App\Http\Controllers\Controller;
use App\Models\PatrimoniosBiene;
use App\Models\Persona;
use App\Models\PersonalesAtencione;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AtencionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mpfn.intranet.atenciones.index');
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
        $ipersonal = PersonalesAtencione::select('personales_atenciones.*')
            ->where('personales_atenciones.activo', 1)
            ->where('personales_atenciones.id', $id)
            ->orderBy('personales_atenciones.datos')
            ->first();

        // 🔴 Validación importante
        if (!$ipersonal) {
            abort(404, 'Registro no encontrado');
        }

        // 🔹 Inicializar SIEMPRE
        $ibien = null;

        if (!empty($ipersonal->bien_id)) {
            $ibien = PatrimoniosBiene::select(
                    'codigo_barra',
                    'codigo_patrimonial',
                    'descripcion',
                    'marca',
                    'modelo',
                    'nro_serie',
                    'medidas',
                    'color',
                    'estado'
                )
                ->where('id', $ipersonal->bien_id)
                ->first();
        }

        // 🔹 UNA sola carga de vista
        $pdf = Pdf::loadView('pdf.informatica.atencion-acta', [
            'ipersonal' => $ipersonal,
            'ibien' => $ibien
        ]);

        return $pdf->stream('reportePDF.pdf');
    }
}
