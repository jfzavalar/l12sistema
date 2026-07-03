<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalesAtencionesIncidenciasSolicitudes extends Model
{
    protected $table = 'personales_atenciones_incidencias_solicitudes';

    protected $fillable = [
        'servicio_id',
        'tipo',
        'tipo_desc',
        'servicio',
        'incidencia_solicitud',
        'respuesta',
        'activo',
        'created_user',
        'updated_user',
    ];
}
