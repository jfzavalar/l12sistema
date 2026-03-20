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
        'estado',
        'oficina_ubicacion',
        'fecha',
        'activo',
        'created_user',
        'updated_user',
    ];
}
