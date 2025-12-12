<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatosSapAndWeightFieldsToBuquesTable extends Migration
{
    public function up(): void
    {
        Schema::table('buques', function (Blueprint $table) {
            // JSON anidado para SAP
            if (!Schema::hasColumn('buques', 'datos_sap')) {
                $table->json('datos_sap')->nullable()->after('imagen');
            }
            // 3 campos nuevos
            if (!Schema::hasColumn('buques', 'peso_buque')) {
                $table->decimal('peso_buque', 12, 3)->nullable()->after('autonomia_millas_nauticas');
            }
            if (!Schema::hasColumn('buques', 'unidad_peso')) {
                $table->string('unidad_peso', 20)->nullable()->after('peso_buque');
            }
            if (!Schema::hasColumn('buques', 'tamano_dimension_buque')) {
                $table->string('tamano_dimension_buque', 100)->nullable()->after('unidad_peso');
            }
        });
    }

    public function down(): void
    {
        Schema::table('buques', function (Blueprint $table) {
            if (Schema::hasColumn('buques', 'datos_sap')) $table->dropColumn('datos_sap');
            if (Schema::hasColumn('buques', 'peso_buque')) $table->dropColumn('peso_buque');
            if (Schema::hasColumn('buques', 'unidad_peso')) $table->dropColumn('unidad_peso');
            if (Schema::hasColumn('buques', 'tamano_dimension_buque')) $table->dropColumn('tamano_dimension_buque');
        });
    }
}
