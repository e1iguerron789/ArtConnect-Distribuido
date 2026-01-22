<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
     return [
        'id' => $this->id,
        'user_id' => $this->user_id,
        'categoria_interes_id' => $this->categoria_interes_id,
        'opcion_interes_id' => $this->opcion_interes_id,
        'titulo' => $this->titulo,
        'descripcion' => $this->descripcion,
        'fecha' => optional($this->fecha)->format('Y-m-d'),
        'hora_inicio' => $this->hora_inicio,
        'hora_fin' => $this->hora_fin,
        'direccion_texto' => $this->direccion_texto,
        'latitud' => $this->latitud,
        'longitud' => $this->longitud,
        'created_at' => optional($this->created_at)->toISOString(),
        'updated_at' => optional($this->updated_at)->toISOString(),
      ];
    }

}
