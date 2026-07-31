<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformaticasBienesAnexos extends Model
{
    protected $table = 'informaticas_bienes_anexos';

    protected $fillable = [
        'serie',
        'tipo',
        'modelo',
        'anexo',
        'marca',
        'transformador',
        'auriculares',
        'baseauriculares',
        'asignacionlibrecustodia',
        'observacion',
        'estado',
        'activo',
        'created_user_cargo',
        'created_user',
        'updated_user',
    ];
}
