<?php

namespace App\Http\Controllers\Patrimonio;

use App\Http\Controllers\Controller;
use App\Models\PatrimoniosBienesSobrante;
use App\Models\PatrimoniosBienesSobrantesAsignacione;
use App\Models\Persona;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BienesasignacionsobranteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mpfn.patrimonio.asignacionessobrantes.index');
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
        $iasignacion = PatrimoniosBienesSobrantesAsignacione::select(
                'id',
                'persona_id',
                'dni',
                'personal_id',
                'datos',
                'regimen',
                'cargo',
                'sede_id',
                'sede',
                'dependencia_id',
                'dependencia',
                'despacho_id',
                'persona_id2',
                'dni2',
                'personal_id2',
                'datos2',
                'regimen2',
                'cargo2',
                'sede_id2',
                'sede2',
                'dependencia_id2',
                'dependencia2',
                'despacho_id2',
                'despacho2',
                'referencia',
                'motivo',
                'bien_id',
                'cod',
                'cod_patrimonial',
                'bien',
                'ruta_documento',
                'activo',
                'created_user',
                'updated_user',
            )
            ->where('id', $id)
            ->where('activo', 1)
            ->firstOrFail(); // 🔥 más limpio que validar manualmente

        // ✅ Obtener bien (solo si existe)
        $ibien = null;

        if ($iasignacion->id) {
            $ibien = PatrimoniosBienesSobrante::join('patrimonios_bienes_sobrantes_asignaciones_detalles','patrimonios_bienes_sobrantes.id','=','patrimonios_bienes_sobrantes_asignaciones_detalles.bien_id')
                ->select(
                    'patrimonios_bienes_sobrantes.codigo_barra',
                    'patrimonios_bienes_sobrantes.codigo_patrimonial',
                    'patrimonios_bienes_sobrantes.descripcion',
                    'patrimonios_bienes_sobrantes.marca',
                    'patrimonios_bienes_sobrantes.modelo',
                    'patrimonios_bienes_sobrantes.nro_serie',
                    'patrimonios_bienes_sobrantes.medidas',
                    'patrimonios_bienes_sobrantes.estado',
                )
                ->where('patrimonios_bienes_sobrantes_asignaciones_detalles.asignacion_id', $iasignacion->id)
                ->get();
        }

        $ipersonal = Persona::join('personales','personas.id','=','personales.persona_id')
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
            )
            ->where('cargo','ADMINISTRADOR')
            ->where('personales.activo',1)
            ->first();

        // ✅ Generar PDF
        $pdf = Pdf::loadView('pdf.patrimonio.bienessobrantesasignados-acta', [
                'iasignacion' => $iasignacion,
                'ibien' => $ibien,
                'ipersonal' => $ipersonal,
            ])
            ->setPaper('a4', 'landscape');

        // 🔥 Habilitar paginación (IMPORTANTE)
        $pdf->getDomPDF()->set_option("isPhpEnabled", true);

        return $pdf->stream('reportePDF.pdf');
    }
}
