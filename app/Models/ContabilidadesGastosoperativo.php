<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContabilidadesGastosoperativo extends Model
{
    protected $table = 'contabilidades_gastosoperativos';

    protected $fillable = [
        'persona_id',
        'dni',
        'personal_id',
        'anio',
        'enero',
        'febrero',
        'marzo',
        'abril',
        'mayo',
        'junio',
        'julio',
        'agosto',
        'septiembre',
        'octubre',
        'noviembre',
        'diciembre',
        'updated_motivo',
        'activo',
        'created_user',
        'updated_user',
    ];
}
