<?php

namespace App\Http\Controllers\Voluntariado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VoluntariadoController extends Controller
{
    public function index(){
        return view('mpfn.voluntariado.asistencia.index');
    }
}
