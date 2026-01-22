<?php

namespace App\DTO;

class UserContext
{
    public function __construct(
        public readonly array $interesesIds,
        public readonly array $interesesNombres,
        public readonly ?float $lat,
        public readonly ?float $lng,
    ) {}
}
