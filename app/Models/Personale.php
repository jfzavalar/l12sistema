<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personale extends Model
{
    protected $fillable = [
        // 'id',
        'dni',
        'datos',
        'appaterno',
        'apmaterno',
        'nombres',
        'genero',
        'estadocivil',
        'fechanacimiento',
        'regimen',
        'cargo',
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
        'celpersonal',
        'celinstitucional',
        'correopersonal',
        'correoinstitucional',
        'foto',
        'activo',
        'created_user',
        'updated_user',
        // 'created_at',
        // 'updated_at',
    ];
}
