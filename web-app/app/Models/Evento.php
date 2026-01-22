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

    // Relaciones

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaInteres::class, 'categoria_interes_id');
    }

    public function opcion()
    {
        return $this->belongsTo(OpcionInteres::class, 'opcion_interes_id');
    }


}

