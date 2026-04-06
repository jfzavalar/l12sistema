<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalesRotacione extends Model
{
    protected $table = 'personales_rotaciones';

    protected $fillable = [
        'persona_id',
        'persona_dni',
        'personal_id',
        'sede_id',
        'sede',
        'dependencia_id',
        'dependencia',
        'despacho_id',
        'despacho',
        'num_expediente',
        'fecha_iniciou',
        'fecha_finu',
        'motivo_ubicacion',
        'ruta_documento',
        'estado',
        'activo',
        'created_user',
        'updated_user',
    ];
}
