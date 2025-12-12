<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuquesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buques', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('tipo');
            $table->text('descripcion')->nullable();
            $table->integer('autonomia_horas')->nullable();
            $table->integer('vida_diseno_anios')->nullable();
            $table->integer('horas_navegacion_anio')->nullable();
            $table->string('imagen')->nullable(); // Para almacenar la ruta de la imagen subida
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buques');
    }
}
