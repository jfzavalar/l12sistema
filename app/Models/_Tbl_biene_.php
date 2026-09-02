<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_biene extends Model
{
    protected $fillable = [
        //
        'cod_pat',
        'cod_barra',
        'bien',
        'marca',
        'modelo',
        'serie',
        'medidas',
        'color',
        'est_cons',
        'cod_ubif',
        'desc_ubif',
        'cod_usuario',
        'desc_usuario',
        'desc_cargo',
        'clase',
        'familia',
        'observa',
        'df',
        'nro_pecosanro_pecosa',
        'doc_adq',
        'ndoc_adq',
        'fecha_adq',
        'acoddepofi',
        'ip',
        'coddepofi',
        'nomdepofi',
        'anomdepofi',
        'sedepofi',
        'codsedeofi',
        'nomsedeofi',
        'codsede',
        'nomsede',
        'estadoofi',
        'codgbien',
        'estado',
        'codcat',
        'codgclase',
        'user_admin',
        'pass_admin',
        'sistema_operativo',
        'impresora01',
        'ip_impresora01',
        'impresora02',
        'ip_impresora02',
        'impresora03',
        'ip_impresora03',
        'desplazamiento',
        'activo',
        'observacion',
        'created_user',
        'updated_user',
    ];
}
