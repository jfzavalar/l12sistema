<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Tbl_patrimonio_bienes_desplazamiento;
use App\Models\Tbl_personale;
use App\Models\Tbl_personales_biene;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PatrimonioController extends Controller
{
    public function index(){
        return view('procesos.administracion.patrimonio.index');
    }

    public function exportarPDF($id)
    {
        $instanciaTbl = Tbl_patrimonio_bienes_desplazamiento::findOrFail($id);
        
        $instanciaTbl_detalle = DB::table('tbl_patrimonio_bienes_desplazamientos_detalles as d')
            ->join('tbl_bienes as b', 'b.cod_pat', '=', 'd.cod_patrimonial')
            ->select(
                'd.id',
                'd.id_biendesplazamiento',
                'd.cod_patrimonial',
                'd.traslado',
                'd.activo',
                'd.created_user',
                'd.updated_user',
                'b.cod_barra',
                'b.bien',
                'b.marca',
                'b.modelo',
                'b.serie',
                'b.color',
                'b.est_cons'
            )
            ->where('d.activo', '1')
            ->where('d.id_biendesplazamiento', $id)
            ->get();

        $pdf = Pdf::loadView('pdf.patrimonio.desplazamiento-bienes-acta', compact('instanciaTbl','instanciaTbl_detalle'));

        //Mostrar PDF
        return $pdf->stream('traslado_'.$instanciaTbl->id.'.pdf');
    
    }

    public function exportarPDFAsignacion($vDni)
    {
        $instanciaTbl = Tbl_personale::where('dni', $vDni)->firstOrFail();
        
        $instanciaTbl_detalle = Tbl_personales_biene::where('cod_usuario', $vDni)->get();

        $pdf = Pdf::loadView('pdf.patrimonio.bien-asignacion-acta', compact('instanciaTbl','instanciaTbl_detalle'));

        //Mostrar PDF
        return $pdf->stream('traslado_'.$instanciaTbl->id.'.pdf');
    
    }
}
