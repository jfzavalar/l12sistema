<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalesAtencionesServicio extends Model
{
    protected $table = 'personales_atenciones_servicios';

    protected $fillable = [
        'servicio',
        'activo',
        'created_user',
        'updated_user',
    ];
}
