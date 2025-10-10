<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use App\Models\Tbl_patrimonio_bienes_desplazamiento;
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
            ->join('tbl_patrimonio_bienes as b', 'b.cod_patrimonial', '=', 'd.cod_patrimonial')
            ->select(
                'd.id',
                'd.id_biendesplazamiento',
                'd.cod_patrimonial',
                'd.traslado',
                'd.activo',
                'd.created_user',
                'd.updated_user',
                'b.cod_barra',
                'b.desc_bien',
                'b.desc_marca',
                'b.modelo',
                'b.nro_serie',
                'b.desc_color',
                'b.des_estado_conservacion'
            )
            ->where('d.activo', '1')
            ->where('d.id_biendesplazamiento', $id)
            ->get();

        $pdf = Pdf::loadView('pdf.patrimonio.bieninformatico-traslado-acta', compact('instanciaTbl','instanciaTbl_detalle'));

        //Mostrar PDF
        return $pdf->stream('traslado_'.$instanciaTbl->id.'.pdf');
    
    }
}
