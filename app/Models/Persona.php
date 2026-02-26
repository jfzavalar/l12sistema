<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{    
    protected $fillable = [
        'dni',
        'datos',
        'appaterno',
        'apmaterno',
        'nombres',
        'genero',
        'estadocivil',
        'fechanacimiento',
        'celpersonal',
        'correopersonal',
        'foto',

        'activo',

        'created_user',
        'updated_user',
    ];
}
