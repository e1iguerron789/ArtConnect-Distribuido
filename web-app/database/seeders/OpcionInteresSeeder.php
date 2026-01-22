<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpcionInteresSeeder extends Seeder
{
    public function run(): void
    {
        $cat = DB::table('categorias_interes')->pluck('id', 'nombre'); // ['Pintura' => 1, ...]

        $rows = [
            // Pintura
            ['categoria_interes_id' => $cat['Pintura'] ?? null, 'nombre' => 'Acuarela'],
            ['categoria_interes_id' => $cat['Pintura'] ?? null, 'nombre' => 'Óleo'],
            ['categoria_interes_id' => $cat['Pintura'] ?? null, 'nombre' => 'Acrílico'],

            // Música
            ['categoria_interes_id' => $cat['Música'] ?? null, 'nombre' => 'Guitarra'],
            ['categoria_interes_id' => $cat['Música'] ?? null, 'nombre' => 'Piano'],

            // Escultura
            ['categoria_interes_id' => $cat['Escultura'] ?? null, 'nombre' => 'Arcilla'],
            ['categoria_interes_id' => $cat['Escultura'] ?? null, 'nombre' => 'Madera'],

            // Fotografía
            ['categoria_interes_id' => $cat['Fotografía'] ?? null, 'nombre' => 'Retrato'],
            ['categoria_interes_id' => $cat['Fotografía'] ?? null, 'nombre' => 'Paisaje'],
        ];

        // filtra por seguridad por si una categoría no existe
        $rows = array_values(array_filter($rows, fn ($r) => !is_null($r['categoria_interes_id'])));

        // idempotente: si ya existe la opción para esa categoría, no duplica
        DB::table('opcion_intereses')->upsert(
            array_map(fn($r) => $r + ['created_at' => now(), 'updated_at' => now()], $rows),
            ['categoria_interes_id', 'nombre'],
            ['updated_at']
        );
    }
}
