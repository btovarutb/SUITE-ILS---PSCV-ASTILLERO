<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHorasNavegacionAnualToBuquesTable extends Migration
{
    public function up()
    {
        Schema::table('buques', function (Blueprint $table) {
            $table->integer('horas_navegacion_anual')->nullable()->after('autonomia_horas');
        });
    }

    public function down()
    {
        Schema::table('buques', function (Blueprint $table) {
            $table->dropColumn('horas_navegacion_anual');
        });
    }
}
