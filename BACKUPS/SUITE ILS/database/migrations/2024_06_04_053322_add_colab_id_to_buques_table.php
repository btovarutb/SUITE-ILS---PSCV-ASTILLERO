<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColabIdToBuquesTable extends Migration
{
    public function up()
    {
        Schema::table('buques', function (Blueprint $table) {
            $table->unsignedBigInteger('colab_id')->nullable()->after('image_path');

            // Establecer la clave foránea
            $table->foreign('colab_id')->references('id')->on('colaboradores')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('buques', function (Blueprint $table) {
            // Eliminar la clave foránea y la columna
            $table->dropForeign(['colab_id']);
            $table->dropColumn('colab_id');
        });
    }
}

