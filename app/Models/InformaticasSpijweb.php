<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformaticasSpijweb extends Model
{
    protected $table = 'informaticas_spijwebs';

    protected $fillable = [
        //'id',
        'dni',
        'datos',
        'sede_origen',
        'dependencia_origen',
        'regimen',
        'cargo',
        'correo_personal',
        'correo_institucional',
        'cel_personal',
        'cel_institucional',
        'actaruta',
        'usuariospijweb',
        'passwordspijweb',
        'estado_formato',
        'estado_userpass',
        'activo',
        //
        'created_user',
        'updated_user'
    ];
}
