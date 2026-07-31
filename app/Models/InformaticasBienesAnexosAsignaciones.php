<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformaticasBienesAnexosAsignaciones extends Model
{
    protected $table = 'informaticas_bienes_anexos_asignaciones';

    protected $fillable = [
        'persona_id',
        'dni',
        'nombres',
        'appaterno',
        'apmaterno',
        'celpersonal',
        'celinstitucional',
        'correopersonal',
        'correoinstitucional',
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
        'regimen',
        'tipo_regimen',
        'cargo',
        'cargo_condicion',
        
        'anexo_id',
        'serie',
        'tipo',
        'modelo',
        'anexo',
        'marca',
        'trasformador',
        'auriculares',
        'baseauriculares',
        'asignacionlibrecustodia',
        'observacion',
        'estado',
        'informatico_dni',
        'informatico',
        'activo',
        'created_user_cargo',
        'created_user',
        'updated_user',
    ];
}
