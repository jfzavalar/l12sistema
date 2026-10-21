<?php

namespace App\Http\Controllers\Informatica;

use App\Http\Controllers\Controller;
use App\Models\InformaticasBienesAnexosAsignaciones;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\If_;

class AnexosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mpfn.informatica.anexos.index');
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
        $instanciaTbl = InformaticasBienesAnexosAsignaciones::findOrFail($id);

        // Buscar el penúltimo registro con el mismo anexo
        $penultimo = InformaticasBienesAnexosAsignaciones::where('anexo', $instanciaTbl->anexo)
                        ->where('id', '<', $instanciaTbl->id) // solo anteriores
                        ->orderBy('id', 'desc')                      
                        ->first();
        
        // Validar existencia
        if (!$penultimo) {
            $penultimo = null; // explícito, para que la vista lo maneje con @if
        }

        $pdf = Pdf::loadView('pdf.informatica.anexotelefonico-acta', compact('instanciaTbl','penultimo'));
        

        // MOSTRAR PDF
        return $pdf->stream('acta_'.$instanciaTbl->id.'_anexo_'.$instanciaTbl->anexo.'_usuario_'.$instanciaTbl->dni.'.pdf');
        
        //Descargar PDF
        // return response()->streamDownload(function () use ($pdf) {
        //     echo $pdf->stream();
        // }, 'spijweb_'.$userspijweb->dni.'.pdf');
    }

}
