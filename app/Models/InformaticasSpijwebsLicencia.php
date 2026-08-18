<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformaticasSpijwebsLicencia extends Model
{
    protected $table = 'informaticas_spijwebs_licencias';

    protected $fillable = [
        'usuario',
        'password',
        'asignado',
        'activo',
        'created_user',
        'updated_user',
    ];
}
