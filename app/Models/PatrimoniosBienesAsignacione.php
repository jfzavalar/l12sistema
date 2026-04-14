<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatrimoniosBienesAsignacione extends Model
{
    protected $table = 'patrimonios_bienes_asignaciones';

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
        'despacho',
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
        'referencia',
        'motivo',
        'bien_id',
        'cod',
        'cod_patrimonial',
        'bien',
        'ruta_documento',
        'activo',
        'created_user',
        'updated_user',
    ];
}
