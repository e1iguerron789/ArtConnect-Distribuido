<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';

    protected $fillable = [
        'user_id',
        'categoria_interes_id',
        'opcion_interes_id',
        'titulo',
        'descripcion',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'direccion_texto',
        'latitud',
        'longitud',
    ];

    protected $casts = [
        'fecha' => 'date:Y-m-d',
        'latitud' => 'float',
        'longitud' => 'float',
    ];
}
