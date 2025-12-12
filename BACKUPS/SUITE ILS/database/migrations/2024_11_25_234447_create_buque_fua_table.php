<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuqueFuaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buque_fua', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buque_id')->constrained('buques')->onDelete('cascade'); // Relación con buques
            $table->integer('roh_1')->nullable(); // ROH Año 1
            $table->integer('roh_3')->nullable(); // ROH Año 3
            $table->integer('roh_5')->nullable(); // ROH Año 5
            $table->integer('mant_basico_1')->nullable(); // Plan de Mantenimiento Básico Año 1
            $table->integer('mant_intermedio_3')->nullable(); // Plan de Mantenimiento Intermedio Año 3
            $table->integer('mant_mayor_5')->nullable(); // Plan de Mantenimiento Mayor Año 5
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buque_fua');
    }
}
