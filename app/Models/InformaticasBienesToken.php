<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformaticasBienesToken extends Model
{
    protected $table = 'informaticas_bienes_tokens';

    protected $fillable = [
        'codigo',
        'equipo',
        'modelo',
        'operativo',
        'asignado',
        'activo',
        'created_user',
        'updated_user',
    ];
}
