<?php

namespace App\Http\Controllers\Informatica;

use App\Http\Controllers\Controller;
use App\Models\InformaticasFirmasToken;
use App\Models\Personale;
use App\Models\Tbl_tokens_asignado;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class FirmasdigitalesController extends Controller
{
    public function index(){
        return view('procesos.informatica.firmasdigitales.index');
    }

    public function exportarPDF($id)
    {
        $instanciaTbl = InformaticasFirmasToken::findOrFail($id);

        $ipersonal = Personale::where('activo','1')->where('persona_dni',$instanciaTbl->dni)->first();

        $pdf = Pdf::loadView('pdf.informatica.token-acta', compact('instanciaTbl','ipersonal'));

        //Mostrar PDF
        return $pdf->stream('token_'.$instanciaTbl->dni.'.pdf');
        
        //Descargar PDF
        // return response()->streamDownload(function () use ($pdf) {
        //     echo $pdf->stream();
        // }, 'spijweb_'.$userspijweb->dni.'.pdf');
    }
}
