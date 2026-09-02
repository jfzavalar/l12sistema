<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_incidencias_solicitude extends Model
{
    protected $fillable = [
        //'id',
        'tipo',
        'tipo_desc',
        'descripcion',
        'detalle',
        'respuesta',
        'interno',
        'estado',
        'estado_desc',
        'activo',
        //       
        'created_user',
        'updated_user'
    ];
}
