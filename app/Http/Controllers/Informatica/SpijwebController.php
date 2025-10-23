<?php

namespace App\Http\Controllers\Informatica;

use App\Http\Controllers\Controller;
use App\Models\Tbl_spijweb;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SpijwebController extends Controller
{
    public function index(){
        return view('procesos.informatica.spijweb.index');
    }


    public function exportarPDF($id)
    {
        $instanciaTbl = Tbl_spijweb::findOrFail($id);

        $pdf = Pdf::loadView('pdf.informatica.spijweb-acta', compact('instanciaTbl'));

        //Mostrar PDF
        return $pdf->stream('spijweb_'.$instanciaTbl->dni.'.pdf');
        
        //Descargar PDF
        // return response()->streamDownload(function () use ($pdf) {
        //     echo $pdf->stream();
        // }, 'spijweb_'.$userspijweb->dni.'.pdf');
    }
}
