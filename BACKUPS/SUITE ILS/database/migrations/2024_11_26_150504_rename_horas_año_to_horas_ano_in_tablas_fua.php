<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameHorasAñoToHorasAnoInTablasFua extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tablas_fua', function (Blueprint $table) {
            $table->renameColumn('horas_año', 'horas_ano');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tablas_fua', function (Blueprint $table) {
            $table->renameColumn('horas_ano', 'horas_año');
        });
    }
}
