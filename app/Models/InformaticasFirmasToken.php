<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformaticasFirmasToken extends Model
{
    protected $table = 'informaticas_firmas_tokens';

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
        'codsededestino',
        'sededestino',
        'coddependenciadestino',
        'dependenciadestino',
        'coddespachodestino',
        'despachodestino',
        'token_id',
        'token_codigo',
        'asignacion',
        'fecha_expiracion',
        'observacion',
        'ruta_documento',
        'activo',
        'created_user',
        'updated_user',
    ];
}
