<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatrimoniosBiene extends Model
{
    protected $table = 'patrimonios_bienes';

    protected $fillable = [
        'codigo_patrimonial',
        'descripcion',
        'nombre_sede',
        'nombre_depend',
        'responsable',
        'usuario',
        'nombre_prov',
        'fecha_compra',
        'valor_compra',
        'fecha_alta',
        'valor_inicial',
        'sede',
        'pliego',
        'ubicac_fisica',
        'nombre_item',
        'sec_ejec',
        'tipo_modalidad',
        'codigo_barra',
        'modelo',
        'nro_orden',
        'medidas',
        'hvalor_neto',
        'abrev_movimto',
        'secuencia',
        'nro_documento',
        'flag_compartido',
        'marca',
        'centro_costo',
        'estado',
        'abreviatura',
        'fecha_nea',
        'tipo_doc_refer',
        'sec_modelo',
        'nro_serie',
        'grupo_bien',
        'clase_bien',
        'familia_bien',
        'item_bien',
        'color',
        'caracteristicas',
        'observaciones',
        'asignacion',
        'ruta_documento',
        'activo',
        'ip',
        'created_user',
        'updated_user',
    ];
}
