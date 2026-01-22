<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserIntereses extends Model
{
    use HasFactory;

    protected $table = 'user_intereses';

    protected $fillable = [
        'user_id',
        'opcion_interes_id',
    ];

    public function opcion()
    {
        return $this->belongsTo(OpcionInteres::class, 'opcion_interes_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
