<?php

namespace App\Http\Controllers\Informatica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IpsController extends Controller
{
    public function index()
    {
        return view('mpfn.informatica.ips.index');
    }
}
