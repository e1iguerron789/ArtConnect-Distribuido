<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpcionInteres extends Model
{
    use HasFactory;

    protected $table = 'opcion_intereses';

    protected $fillable = [
        'categoria_interes_id',
        'nombre',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaInteres::class, 'categoria_interes_id');
    }
}
