<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gres_sistema', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buque_id');
            $table->unsignedBigInteger('sistema_id');
            $table->string('mec')->nullable(); // MEC asignado (1,2,3,4)
            $table->string('diagrama')->nullable(); // Ruta al diagrama asignado
            $table->json('observaciones')->nullable(); // Observaciones con preguntas relacionadas
            $table->timestamps();

            // Relaciones
            $table->foreign('buque_id')->references('id')->on('buques')->onDelete('cascade');
            $table->foreign('sistema_id')->references('id')->on('sistemas_suite')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gres_sistema');
    }
};
