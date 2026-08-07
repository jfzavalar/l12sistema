<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformaticasSpijwebsEntrega extends Model
{
    protected $table = 'informaticas_spijwebs_entregas';

    protected $fillable = [
        'persona_id',
        'dni',
        'appaterno',
        'apmaterno',
        'nombres',
        'datos',
        'celpersonal',
        'celinstitucional',
        'correopersonal',
        'correoinstitucional',
        
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
        'regimen',
        'tipo_regimen',
        'cargo',
        'cargo_condicion',

        'anio',
        'enviarformatos',
        'enviarusuario',
        'febrero',
        'enviarformatos',
        'enviarusuario',

        'informatico_dni',
        'informatico',
        'activo',
        'created_user',
        'updated_user',
    ];
}
