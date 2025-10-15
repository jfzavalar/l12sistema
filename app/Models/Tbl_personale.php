<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_personale extends Model
{
    protected $fillable = [
        //'id',
        'dni',
        'datos',

        'codsede_origen',
        'sede_origen',
        'coddependencia_origen',
        'dependencia_origen',

        'codsede_destino',
        'sede_destino',
        'coddependencia_destino',
        'dependencia_destino',

        'regimen',
        'cargo',
        'correo_personal',
        'correo_institucional',
        'cel_personal',
        'cel_institucional',
        
        'activo',
        //
        'created_user',
        'updated_user'
    ];
}
