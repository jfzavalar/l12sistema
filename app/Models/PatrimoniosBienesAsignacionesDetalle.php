<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatrimoniosBienesAsignacionesDetalle extends Model
{
    protected $table = 'patrimonios_bienes_asignaciones_detalles';

    protected $fillable = [
        'persona_id',
        'dni',
        'personal_id',
        'datos',
        'regimen',
        'cargo',
        'sede_id',
        'sede',
        'dependencia_id',
        'dependencia',
        'despacho_id',
        'persona_id2',
        'dni2',
        'personal_id2',
        'datos2',
        'regimen2',
        'cargo2',
        'sede_id2',
        'sede2',
        'dependencia_id2',
        'dependencia2',
        'despacho_id2',
        'despacho2',
        'bien_id',
        'cod',
        'cod_patrimonial',
        'bien',
        'activo',
        'created_user',
        'updated_user',
    ];
}
