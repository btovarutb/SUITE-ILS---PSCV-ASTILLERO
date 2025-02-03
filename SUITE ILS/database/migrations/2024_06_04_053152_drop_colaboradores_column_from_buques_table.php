<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColaboradoresColumnFromBuquesTable extends Migration
{
    public function up()
    {
        Schema::table('buques', function (Blueprint $table) {
            $table->dropColumn('colaboradores');
        });
    }

    public function down()
    {
        Schema::table('buques', function (Blueprint $table) {
            $table->json('colaboradores')->nullable(); // Suponiendo que era una columna JSON
        });
    }
}
