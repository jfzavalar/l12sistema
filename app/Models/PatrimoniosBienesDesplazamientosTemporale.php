<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatrimoniosBienesDesplazamientosTemporale extends Model
{
    protected $table = 'patrimonios_bienes_desplazamientos_temporales';

    protected $fillable = [
        'persona_id',
        'dni',
        'personal_id',
        'datos',
        'regimen',
        'regimen_tipo',
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
        
        'persona_id2',
        'dni2',
        'personal_id2',
        'datos2',
        'regimen2',
        'regimen_tipo2',
        'cargo2',
        'cargo_condicion2',

        'codsedeorigen2',
        'sedeorigen2',
        'coddependenciaorigen2',
        'dependenciaorigen2',
        'coddespachoorigen2',
        'despachoorigen2',

        'codsededestino2',
        'sededestino2',
        'coddependenciadestino2',
        'dependenciadestino2',
        'coddespachodestino2',
        'despachodestino2',

        'referencia',
        'motivo',

        // 'bien_id',
        // 'cod',
        // 'cod_patrimonial',
        // 'bienes',
        
        'ruta_documento',

        'activo',
        'created_user',
        'updated_user',
    ];
}
