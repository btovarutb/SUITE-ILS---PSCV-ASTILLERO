<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColaboradoresFromBuqueSistemasEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buque_sistemas_equipos', function (Blueprint $table) {
            $table->dropColumn('colaboradores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buque_sistemas_equipos', function (Blueprint $table) {
            $table->text('colaboradores')->nullable();
        });
    }
}
