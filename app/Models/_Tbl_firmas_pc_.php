<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_firmas_pc extends Model
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
        'sededestino',
        'coddependencia_destino',
        'dependencia_destino',
        
        'regimen',
        'cargo',
        'correo_personal',
        'correo_institucional',
        'cel_personal',
        'cel_institucional',
        //
        'idtoken',
        'codtoken',
        'operativo',
        'asignacion',
        'fecha_expiracion',
        'observacion',
        'actaruta',
        'activo',
        //
        'created_user',
        'updated_user'
    ];
}
