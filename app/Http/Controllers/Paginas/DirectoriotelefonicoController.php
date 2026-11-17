<?php

namespace App\Http\Controllers\Paginas;

use App\Http\Controllers\Controller;
use App\Models\InformaticasBienesAnexosAsignaciones;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class DirectoriotelefonicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('paginas.directorio_telefonico.index');
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

    public function exportarPDFReporte()
    {
        $instanciaTbl = InformaticasBienesAnexosAsignaciones::where('activo', '1')
            ->where('custodia', 'NO')
            ->orderBy('sededestino', 'asc')
            ->orderBy('dependenciadestino', 'asc')
            ->get();

        $pdf = Pdf::loadView('pdf.informatica.anexotelefonico-reporte', compact('instanciaTbl'));

        return $pdf->stream('reporte.pdf');
    }
}
