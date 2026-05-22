<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformaticasIp extends Model
{
    protected $table = 'informaticas_ips';

    protected $fillable = [
        'id',
        'red',
        'grupo',
        'ip',
        'bien_id',
        'codigo',
        'codigo_patrimonial',
        'bien',
        'estado',
        'persona_id',
        'dni',
        'nombres',
        'apppaterno',
        'apmaterno',
        'sede',
        'dependencia',
        'despacho',
        'regimen',
        'tipo',
        'cargo',
        'condicion',
        'activo',
        'created_user',
        'updated_user',
        'created_at',
        'updated_at',

    ];
}
