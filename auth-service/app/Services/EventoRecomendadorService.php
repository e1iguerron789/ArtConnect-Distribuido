<?php

namespace App\Services;

use App\DTO\UserContext;
use App\Repositories\EventoRepository;
use App\Recomendacion\Reglas\ReglaRelevancia;
use Illuminate\Support\Collection;

class EventoRecomendadorService
{
    /** @param ReglaRelevancia[] $reglas */
    public function __construct(
        private EventoRepository $repo,
        private array $reglas
    ) {}

    public function recomendar(UserContext $ctx): Collection
    {
        $eventos = $this->repo->obtenerParaMapa();

        foreach ($eventos as $ev) {
            $score = 0;
            foreach ($this->reglas as $regla) {
                $score += $regla->puntaje($ev, $ctx);
            }
            $ev->relevancia = $score;
        }

        return $eventos->sortByDesc('relevancia')->values();
    }
}
