<?php

namespace App\Http\Controllers\Informatica;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class soporteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mpfn.informatica.soporte.index');
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
        $ipersonal = Persona::join('personales', 'personas.id', '=', 'personales.persona_id')
            ->join('informaticas_soportes','personas.id','=','informaticas_soportes.persona_id')
            ->join('patrimonios_bienes','informaticas_soportes.bien_id','patrimonios_bienes.id')
            ->select('personas.*',
                'personales.persona_id',
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
                'informaticas_soportes.id as soporte_id',
                'informaticas_soportes.bien_cod_patrimonial',
                'informaticas_soportes.p01',
                'informaticas_soportes.p02',
                'informaticas_soportes.p03',
                'informaticas_soportes.p04',
                'informaticas_soportes.p05',
                'informaticas_soportes.p06',
                'informaticas_soportes.p07',
                'informaticas_soportes.potros',
                'informaticas_soportes.c01',
                'informaticas_soportes.c02',
                'informaticas_soportes.c03',
                'informaticas_soportes.c04',
                'informaticas_soportes.c05',
                'informaticas_soportes.c06',
                'informaticas_soportes.c07',
                'informaticas_soportes.observacion_usuario',
                'informaticas_soportes.recomendacion_usuario',
                'informaticas_soportes.cotros',
                'informaticas_soportes.operativo',
                'patrimonios_bienes.bien',
                'patrimonios_bienes.marca',
                'patrimonios_bienes.modelo',
                'patrimonios_bienes.serie',
                'patrimonios_bienes.medidas',
                'patrimonios_bienes.color',
                'patrimonios_bienes.estado')
            ->where([['personas.activo',1],['personales.activo', 1]])
            ->where('informaticas_soportes.id',$id)
            ->orderBy('personas.datos')
            ->first();

        $pdf = Pdf::loadView('pdf.informatica.soporte-acta', compact('ipersonal'));

        //Mostrar PDF
        return $pdf->stream('reportePDF'.'.pdf');
    }
}
