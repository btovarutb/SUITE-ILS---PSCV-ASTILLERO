<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuqueMisionesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buque_misiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buque_id')->constrained()->onDelete('cascade');
            $table->foreignId('mision_id')->constrained('misiones')->onDelete('cascade');
            $table->integer('porcentaje')->nullable(); // Porcentaje asociado a la misión
            $table->text('descripcion')->nullable(); // Descripción opcional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buque_misiones');
    }
}
