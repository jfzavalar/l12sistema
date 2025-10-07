<?php

namespace App\Http\Controllers\Informatica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FirmasdigitalesController extends Controller
{
    public function index(){
        return view('procesos.informatica.firmasdigitales.index');
    }
}
