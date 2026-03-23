<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministracionesExpimportante extends Model
{
    protected $table = 'administraciones_expimportantes';

    protected $fillable = [
        'persona_id',
        'dni',
        'datos',
        'personal_id',
        'codsedeorigen',
        'sedeorigen',
        'coddependenciaorigen',
        'dependenciaorigen',
        'coddespachoorigen',
        'despachoorigen',
        'numexpediente',
        'expdetalle',
        'estado',
        'oficina_ubicacion',
        'asignado_a',
        'fecha',
        'activo',
        'created_user',
        'updated_user',
    ];
}
