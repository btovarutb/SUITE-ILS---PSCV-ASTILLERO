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
        Schema::table('buque_fua', function (Blueprint $table) {
            $table->decimal('disponible_misiones_1', 10, 2)->nullable(); // Disponible para Misiones - 1er Año
            $table->decimal('disponibilidad_mantenimiento_1', 10, 2)->nullable(); // Disponibilidad de Mantenimiento - 1er Año
            $table->decimal('disponible_misiones_3', 10, 2)->nullable(); // Disponible para Misiones - 3er Año
            $table->decimal('disponibilidad_mantenimiento_3', 10, 2)->nullable(); // Disponibilidad de Mantenimiento - 3er Año
            $table->decimal('disponible_misiones_5', 10, 2)->nullable(); // Disponible para Misiones - 5to Año
            $table->decimal('disponibilidad_mantenimiento_5', 10, 2)->nullable(); // Disponibilidad de Mantenimiento - 5to Año
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buque_fua', function (Blueprint $table) {
            //
        });
    }
};
