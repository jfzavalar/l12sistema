<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personales_contrato extends Model
{
    protected $fillable = [
        'contrato_id_persona',
        'contrato_dni_persona',
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
