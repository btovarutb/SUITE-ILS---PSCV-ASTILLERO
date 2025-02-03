<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateVelocidadColumnInBuqueMisionesTable extends Migration
{
    public function up()
    {
        Schema::table('buque_misiones', function (Blueprint $table) {
            $table->string('velocidad', 255)->change(); // Cambiar a tipo string
        });
    }

    public function down()
    {
        Schema::table('buque_misiones', function (Blueprint $table) {
            $table->integer('velocidad')->change(); // Revertir a tipo integer si es necesario
        });
    }
}
