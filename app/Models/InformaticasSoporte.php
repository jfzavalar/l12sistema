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
        'sede_ubicacion',
        'dependencia_ubicacion',
        'despacho_ubicacion',
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
        'ruta_documento',
        'activo',
        'created_user',
        'updated_user',
    ];
}
