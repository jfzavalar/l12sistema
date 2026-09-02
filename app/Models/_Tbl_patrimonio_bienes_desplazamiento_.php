<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_patrimonio_bienes_desplazamiento extends Model
{
    protected $fillable = [
        //'id',
        'dni_solicitante',
        'solicitante',
        'dni_responsabletraslado',
        'responsabletraslado',
        'sede_origen',
        'dependencia_origen',
        'sede_destino',
        'dependencia_destino',
        'motivo_traslado',
        'tipotraslado',
        'fechasalida',
        'fecharetorno',
        'observacion',
        'traslado',
        'lista_equipos_traslado',
        'actaruta',
        'activo',
        'created_user',
        'updated_user'
    ];
}
