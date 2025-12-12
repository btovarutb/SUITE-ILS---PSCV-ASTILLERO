<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Paso 1: Renombrar primero
        Schema::table('buques', function (Blueprint $table) {
            if (Schema::hasColumn('buques', 'numero_casco')) {
                $table->renameColumn('numero_casco', 'numero_casco_cotecmar');
            }
        });

        // Paso 2: Agregar columna nueva en una segunda llamada
        Schema::table('buques', function (Blueprint $table) {
            if (!Schema::hasColumn('buques', 'numero_casco_armada')) {
                $table->string('numero_casco_armada')->nullable()->after('numero_casco_cotecmar');
            }
        });
    }

    public function down(): void
    {
        Schema::table('buques', function (Blueprint $table) {
            if (Schema::hasColumn('buques', 'numero_casco_armada')) {
                $table->dropColumn('numero_casco_armada');
            }
        });

        Schema::table('buques', function (Blueprint $table) {
            if (Schema::hasColumn('buques', 'numero_casco_cotecmar')) {
                $table->renameColumn('numero_casco_cotecmar', 'numero_casco');
            }
        });
    }
};
