<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTituloToBuqueSistemasEquiposTable extends Migration
{
    public function up()
    {
        Schema::table('buque_sistemas_equipos', function (Blueprint $table) {
            $table->string('titulo')->nullable();
        });
    }

    public function down()
    {
        Schema::table('buque_sistemas_equipos', function (Blueprint $table) {
            $table->dropColumn('titulo');
        });
    }
}
