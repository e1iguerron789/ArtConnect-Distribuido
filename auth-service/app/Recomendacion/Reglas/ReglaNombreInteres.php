<?php

namespace App\Recomendacion\Reglas;

use App\DTO\UserContext;
use App\Models\Evento;

class ReglaNombreInteres implements ReglaRelevancia
{
    public function puntaje(Evento $evento, UserContext $ctx): int
    {
        if (!$evento->opcion) return 0;
        return in_array($evento->opcion->nombre, $ctx->interesesNombres) ? 30 : 0;
    }
}
