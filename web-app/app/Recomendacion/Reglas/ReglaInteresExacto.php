<?php

namespace App\Recomendacion\Reglas;

use App\DTO\UserContext;
use App\Models\Evento;

class ReglaInteresExacto implements ReglaRelevancia
{
    public function puntaje(Evento $evento, UserContext $ctx): int
    {
        return in_array($evento->opcion_interes_id, $ctx->interesesIds) ? 50 : 0;
    }
}
