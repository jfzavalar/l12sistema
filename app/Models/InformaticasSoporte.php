<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformaticasSoporte extends Model
{
    protected $fillable = [
        'bien_id',
        'bien_cod',
        'bien_cod_patrimonial',
        'persona_id',
        'persona_dni',
        'persona_datos',
        'personal_id',
        'preventivo',
        'p01',
        'p02',
        'p03',
        'p04',
        'p05',
        'p06',
        'p07',
        'potros',
        'correctivo',
        'c01',
        'c02',
        'c03',
        'c04',
        'c05',
        'c06',
        'c07',
        'cotros',
        'operativo',
        'observacion_usuario',
        'recomendacion_usuario',
        'activo',
        'created_user',
        'updated_user',
    ];
}
