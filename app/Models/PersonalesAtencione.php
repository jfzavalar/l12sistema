<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalesAtencione extends Model
{
    protected $table = 'personales_atenciones';

    protected $fillable = [
        'persona_id',
        'dni',
        'personal_id',
        'datos',
        'codsede_origen',
        'sede_origen',
        'coddependencia_origen',
        'dependencia_origen',
        'codsede_destino',
        'sede_destino',
        'coddependencia_destino',
        'dependencia_destino',
        'reportado_por_id',
        'reportado_por_dni',
        'reportado_por_datos',
        'tipo',
        'tipo_desc',
        'descripcion',
        'detalle',
        'cea',
        'cf',
        'enviado_lima',
        'glpi',
        'observacion_incidencia',
        'atendido',
        'atendido_por_id',
        'atendido_por_dni',
        'atendido_por_datos',
        'tiempo_atencion',
        'respuesta',
        'conformidad',
        'activo',
        'created_user',
        'updated_user',

    ];
}
