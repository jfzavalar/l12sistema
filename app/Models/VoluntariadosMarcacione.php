<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoluntariadosMarcacione extends Model
{
    protected $table = 'voluntariados_marcaciones';

    protected $fillable = [
        //'id',
        'dni',
        'datos',

        'codsede_origen',
        'sede_origen',
        'coddependencia_origen',
        'dependencia_origen',

        'codsede_destino',
        'sede_destino',
        'coddependencia_destino',
        'dependencia_destino',
        
        // 'regimen',
        // 'cargo',
        // 'correo_personal',
        // 'correo_institucional',
        // 'cel_personal',
        // 'cel_institucional',
        'entrada_salida',
        'fecha',
        'hora_entrada',
        'hora_salida',
        'subtotal',
        'observacion',
        //
        'activo',
        //
        'created_user',
        'updated_user'
    ];
}
