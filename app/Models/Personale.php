<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personale extends Model
{
    protected $fillable = [
        'persona_id',
        'persona_dni',
        'tipo_regimen',
        'regimen',
        'cargo',
        'codsedeorigen',
        'sedeorigen',
        'coddependenciaorigen',
        'dependenciaorigen',
        'coddespachoorigen',
        'despachoorigen',
        'codsededestino',
        'sededestino',
        'coddependenciadestino',
        'dependenciadestino',
        'coddespachodestino',
        'despachodestino',
        'celinstitucional',
        'correoinstitucional',

        'numero_convocatoria',

        'tipo_documento',
        
        'fecha_inicio',
        'fecha_fin',
        'ruta_documento',

        'activo',

        'created_user',
        'updated_user',
    ];
}
