<?php

namespace App\Http\Controllers\Rrhh;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mpfn.rrhh.personal.index');
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

    public function reportePDF()
    {
        $ipersonal = Persona::join('personales', 'personas.id', '=', 'personales.persona_id')
            ->select(
                'personas.*',
                'personales.persona_id',
                'personales.regimen',
                'personales.tipo_regimen',
                'personales.cargo',
                'personales.sedeorigen',
                'personales.dependenciaorigen',
                'personales.despachoorigen',
                'personales.sededestino',
                'personales.dependenciadestino',
                'personales.despachodestino'
            )
            ->where([['personas.activo',1],['personales.activo', 1]])
            ->orderBy('personales.dependenciaorigen') // 👈 importante
            ->orderBy('personas.datos')
            ->get();

        // ✅ AGRUPAR POR DEPENDENCIA
        $personalAgrupado = $ipersonal->groupBy('dependenciaorigen');

        $pdf = Pdf::loadView('pdf.rrhh.personal.reportePDF', compact('personalAgrupado'));

        return $pdf->stream('reportePDF.pdf');
    }

    // public function reportePDF()
    // {
    //     $ipersonal = Persona::join('personales', 'personas.id', '=', 'personales.persona_id')
    //         ->select('personas.*',
    //             'personales.persona_id',
    //             'personales.regimen',
    //             'personales.tipo_regimen',
    //             'personales.cargo',
    //             'personales.sedeorigen',
    //             'personales.dependenciaorigen',
    //             'personales.despachoorigen',
    //             'personales.sededestino',
    //             'personales.dependenciadestino',
    //             'personales.despachodestino')
    //         ->where([['personas.activo',1],['personales.activo', 1]])
    //         ->orderBy('personas.datos')
    //         ->get();

    //     $pdf = Pdf::loadView('pdf.rrhh.personal.reportePDF', compact('ipersonal'));

    //     //Mostrar PDF
    //     return $pdf->stream('reportePDF'.'.pdf');
    // }
}
