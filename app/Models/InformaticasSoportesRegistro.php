<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformaticasSoportesRegistro extends Model
{
    protected $table = 'informaticas_soportes_registros';

    protected $fillable = [
        'soporte_id',
        'tarea_id',
        'tipo'
    ];
}
