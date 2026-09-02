<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_personales_contrato extends Model
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


        'fecha_inicio',
        'fecha_fin',
        'causal',
        'actaruta',
        'observacion',
        
        'activo',
        //
        'created_user',
        'updated_user'
    ];
}
