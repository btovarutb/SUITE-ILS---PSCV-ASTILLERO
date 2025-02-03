<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdToSistemasEquiposTable extends Migration
{
    public function up()
    {
        Schema::table('sistemas_equipos', function (Blueprint $table) {
            $table->id()->first();
        });
    }

    public function down()
    {
        Schema::table('sistemas_equipos', function (Blueprint $table) {
            $table->dropColumn('id');
        });
    }
}
