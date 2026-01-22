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
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();

            // Usuario que crea el evento
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Relación con categorías y opciones de interés
            $table->foreignId('categoria_interes_id')
                  ->constrained('categorias_interes')
                  ->onDelete('cascade');

            $table->foreignId('opcion_interes_id')
                  ->nullable()
                  ->constrained('opcion_intereses')
                  ->onDelete('cascade');

            // Información básica del evento
            $table->string('titulo', 150);
            $table->text('descripcion')->nullable();

            // Fecha y horarios
            $table->date('fecha');
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();

            // Ubicación
            $table->string('direccion_texto')->nullable(); // lo que escribe el usuario
            $table->decimal('latitud', 10, 7)->nullable();
            $table->decimal('longitud', 10, 7)->nullable();

            // Evento presencial / virtual
            $table->boolean('es_virtual')->default(false);
            $table->string('enlace_virtual')->nullable(); // link a Zoom, Twitch, etc.

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
