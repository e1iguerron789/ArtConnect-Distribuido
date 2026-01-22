<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_intereses', function (Blueprint $table) {
            $table->id();

            // Relación con usuarios
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // Relación con opciones de interés
            $table->foreignId('opcion_interes_id')
                ->constrained('opcion_intereses')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_intereses');
    }
};
