<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalesAtencione extends Model
{
    protected $table = 'personales_atenciones';

    protected $fillable = [
        // DATOS DE LA PERSONA
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
        // DATOS DEL PERSONAL
        'personal_id',
        'codsedeorigen',
        'sedeorigen',
        'coddependenciaorigen',
        'dependenciaorigen',
        'coddespachoorigen',
        'despachoorigen',
        'codsede',
        'sededestino',
        'coddependenciadestino',
        'dependenciadestino',
        'coddespachodestino',
        'despachodestino',
        'regimen',
        'tipo_regimen',
        'cargo',
        'cargo_condicion',
        //DATOS DE LA ATENCIÓN
        'reportado_por',
        'solicitud_incidencia',
        'servicio',
        'detalle_servicio',
        'bien_id',
        'cod',
        'cod_patrimonial',
        'datos_bien',
        'ip',
        'cea',
        'sgf',
        'glpi',
        'enviado_lima',
        'detalle_problema',
        'ncopias',
        'obs_usuario',
        'obs_informatico',
        'estado',
        'atendido',
        'atendido_por_id',
        'atendido_por_dni',
        'atendido_por_datos',
        'tiempo_atencion',
        'respuesta',
        'conformidad',
        'ruta_evidencia',
        'ruta_documento',
        'informatico_dni',
        'informatico',
        'activo',
        'created_user_cargo',
        'created_user',
        'updated_user',
    ];
}
