<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatrimoniosBienesSobrante extends Model
{
    protected $table = 'patrimonios_bienes_sobrantes';

    protected $fillable = [

        'activo',
        'created_user',
        'updated_user',
    ];
}
