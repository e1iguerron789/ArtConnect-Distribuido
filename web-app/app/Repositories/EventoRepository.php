<?php

namespace App\Repositories;

use App\Models\Evento;
use Illuminate\Support\Collection;

class EventoRepository
{
    public function obtenerParaMapa(): Collection
    {
        return Evento::with([
            'categoria:id,nombre',
            'opcion:id,nombre,categoria_interes_id'
        ])->get([
            'id','titulo','categoria_interes_id','opcion_interes_id',
            'latitud','longitud','fecha','hora_inicio','hora_fin','direccion_texto'
        ]);
    }
}
