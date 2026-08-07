<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContabilidadesGastosoperativosEntrega extends Model
{
    protected $table = 'contabilidades_gastosoperativos_entregas';

    protected $fillable = [
        'persona_id',
        'dni',
        'appaterno',
        'apmaterno',
        'nombres',
        'datos',
        'celpersonal',
        'celinstitucional',
        'correopersonal',
        'correoinstitucional',
        'personal_id',
        'regimen',
        'tipo_regimen',
        'cargo',
        'cargo_condicion',
        'sede',
        'dependencia',
        'despacho',

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

        'menero',
        'mfebrero',
        'mmarzo',
        'mabril',
        'mmayo',
        'mjunio',
        'mjulio',
        'magosto',
        'mseptiembre',
        'moctubre',
        'mnoviembre',
        'mdiciembre',

        'activo',
        'created_user',
        'updated_user',
    ];
}
