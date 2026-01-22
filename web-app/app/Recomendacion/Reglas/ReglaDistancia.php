<?php

namespace App\Recomendacion\Reglas;

use App\DTO\UserContext;
use App\Models\Evento;

class ReglaDistancia implements ReglaRelevancia
{
    public function puntaje(Evento $evento, UserContext $ctx): int
    {
        $evento->distancia = null;

        if (!$ctx->lat || !$ctx->lng || !$evento->latitud || !$evento->longitud) return 0;

        $km = $this->haversine($ctx->lat, $ctx->lng, (float)$evento->latitud, (float)$evento->longitud);
        $evento->distancia = round($km, 3);

        if ($km < 1) return 20;
        if ($km < 3) return 10;
        return 0;
    }

    private function haversine(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $R = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) ** 2 +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon/2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $R * $c;
    }
}
