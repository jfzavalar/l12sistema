<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tbl_patrimonio_bienes_desplazamientos_detalle extends Model
{
    protected $fillable = [
        //'id',
        'id_biendesplazamiento',
        'cod_patrimonial',
        'traslado',
        'activo',
        'created_user',
        'updated_user',
    ];
}
