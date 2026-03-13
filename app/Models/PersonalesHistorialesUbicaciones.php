<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalesHistorialesUbicaciones extends Model
{
    protected $table = 'personales_historiales_ubicacione';

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
        'created_user',
        'updated_user',
    ];
}
