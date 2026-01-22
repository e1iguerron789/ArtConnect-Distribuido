<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('opcion_intereses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoria_interes_id');
            $table->string('nombre');
            $table->timestamps();

            // Relación con categorias_interes
            $table->foreign('categoria_interes_id')
                ->references('id')
                ->on('categorias_interes')
                ->onDelete('cascade');  // Si se borra la categoría, se eliminan sus opciones
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opcion_intereses');
    }
};
