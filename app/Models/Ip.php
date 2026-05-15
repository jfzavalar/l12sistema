<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ip extends Model
{
    protected $fillable = [
        'grupo',
        'ip',
        'codigo',
        'codigo_patrimonial',
        'bien',
        'estado',
        'activo',
        'created_user',
        'updated_user',
    ];
}
