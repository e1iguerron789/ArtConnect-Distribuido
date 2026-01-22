<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias_interes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // Ej: "Estilo Artístico"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias_interes');
    }
};
