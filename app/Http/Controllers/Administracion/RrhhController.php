<?php

namespace App\Http\Controllers\Administracion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RrhhController extends Controller
{
    public function index(){
        return view('procesos.administracion.rrhh.index');
    }
}
