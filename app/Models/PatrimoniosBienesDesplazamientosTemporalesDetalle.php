<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatrimoniosBienesDesplazamientosTemporalesDetalle extends Model
{
    protected $table = 'patrimonios_bienes_desplazamientos_temporales_detalles';

    protected $fillable = [
        'desplazamiento_id',
        'persona_id',
        'personal_dni',
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

        'persona_id2',
        'persona_dni2',
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

        'persona_id3',
        'persona_dni3',
        'personal_id3',
        'datos3',
        'regimen3',
        'regimen_tipo3',
        'cargo3',
        'cargo_condicion3',

        'codsedeorigen3',
        'sedeorigen3',
        'coddependenciaorigen3',
        'dependenciaorigen3',
        'coddespachoorigen3',
        'despachoorigen3',
        
        'codsededestino3',
        'sededestino3',
        'coddependenciadestino3',
        'dependenciadestino3',
        'coddespachodestino3',
        'despachodestino3',

        'bien_id',
        'cod',
        'cod_patrimonial',
        'bien',

        'estado',
        
        'activo',
        'created_user',
        'updated_user',
    ];
}
