<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();

            // Importante: en microservicio NO debe haber FK a users de otro servicio
            // Guardamos solo el user_id como entero
            $table->unsignedBigInteger('user_id')->index();

            $table->unsignedBigInteger('categoria_interes_id')->index();
            $table->unsignedBigInteger('opcion_interes_id')->nullable()->index();

            $table->string('titulo', 150);
            $table->text('descripcion')->nullable();

            $table->date('fecha');
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();

            $table->string('direccion_texto')->nullable();
            $table->decimal('latitud', 10, 7)->nullable();
            $table->decimal('longitud', 10, 7)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
