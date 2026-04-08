<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatrimoniosBienesDesplazamiento extends Model
{
    protected $table = 'patrimonios_bienes_desplazamientos';

    protected $fillable = [
        'solicitante_id',
        'dni_solicitante',
        'solicitante',
        'responsabletraslado_id',
        'dni_responsabletraslado',
        'responsabletraslado',
        'codsede_origen',
        'sede_origen',
        'coddependencia_origen',
        'dependencia_origen',
        'codsede_destino',
        'sede_destino',
        'coddependencia_destino',
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
        'updated_user',
    ];
}
