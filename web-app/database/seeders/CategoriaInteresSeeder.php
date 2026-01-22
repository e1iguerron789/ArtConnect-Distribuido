<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaInteresSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categorias_interes')->upsert(
            [
                ['nombre' => 'Pintura', 'created_at' => now(), 'updated_at' => now()],
                ['nombre' => 'Música', 'created_at' => now(), 'updated_at' => now()],
                ['nombre' => 'Escultura', 'created_at' => now(), 'updated_at' => now()],
                ['nombre' => 'Fotografía', 'created_at' => now(), 'updated_at' => now()],
            ],
            ['nombre'],           // clave única
            ['updated_at']        // qué actualizar si ya existe
        );
    }
}
