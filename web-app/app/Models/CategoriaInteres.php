<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaInteres extends Model
{
    use HasFactory;

    protected $table = 'categorias_interes';

    protected $fillable = [
        'nombre',
    ];

    public function opciones()
    {
        return $this->hasMany(OpcionInteres::class, 'categoria_interes_id');
    }
}
