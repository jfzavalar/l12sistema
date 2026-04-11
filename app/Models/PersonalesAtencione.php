<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalesAtencione extends Model
{
    protected $table = 'personales_atenciones';

    protected $fillable = [
        'persona_id',
        'dni',
        'personal_id',
        'datos',
        'codsede_origen',
        'sede_origen',
        'coddependencia_origen',
        'dependencia_origen',
        'coddespacho_origen',
        'despacho_origen',
        'codsede_destino',
        'sede_destino',
        'coddependencia_destino',
        'dependencia_destino',
        'coddespacho_destino',
        'despacho_destino',
        'reportado_por',
        'solicitud_incidencia',
        'servicio',
        'detalle_servicio',
        'bien_id',
        'cod',
        'cod_patrimonial',
        'datos_bien',
        'cea',
        'sgf',
        'detalle_problema',
        'captura_evidencia',
        'ncopias',
        'glpi',
        'enviado_lima',
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
        'activo',
        'ruta_evidencia',
        'ruta_documento',
        'created_user',
        'updated_user',
    ];
}
