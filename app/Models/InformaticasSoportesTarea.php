<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformaticasSoportesTarea extends Model
{
    protected $table = 'informaticas_soportes_tareas';

    protected $fillable = [
        'nombre',
        'tipo'
    ];
}