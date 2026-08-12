<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalesLegajo extends Model
{
    protected $table = 'personales_legajos';

    protected $fillable = [

        'persona_id',
        'dni',
        'appaterno',
        'apmaterno',
        'nombres',
        'datos',
        'personal_id',
        'regimen',
        'tipo_regimen',
        'cargo',
        'cargo_condicion',
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
        'correopersonal',
        'celinstitucional',
        'correoinstitucional',
        'tipo_documento',
        'motivo',
        'titulodocumento',
        'fechaemision',
        'ruta_legajo',
        'informatico_dni',
        'informatico',
        'activo',
        'created_user',
        'updated_user',

    ];
}
