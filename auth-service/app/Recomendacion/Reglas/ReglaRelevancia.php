<?php

namespace App\Recomendacion\Reglas;

use App\DTO\UserContext;
use App\Models\Evento;

interface ReglaRelevancia
{
    public function puntaje(Evento $evento, UserContext $ctx): int;
}
