<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVidaDisenoToBuquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buques', function (Blueprint $table) {
            $table->integer('vida_diseno')->nullable()->after('horas_navegacion_anual'); // Ajusta la posición según tu preferencia
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buques', function (Blueprint $table) {
            $table->dropColumn('vida_diseno');
        });
    }
}

