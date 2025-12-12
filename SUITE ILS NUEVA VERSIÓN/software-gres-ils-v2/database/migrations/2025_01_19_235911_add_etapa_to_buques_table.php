<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('buques', function (Blueprint $table) {
            $table->string('etapa')->default('Activo'); // Columna nueva con valor por defecto
        });
    }

    public function down()
    {
        Schema::table('buques', function (Blueprint $table) {
            $table->dropColumn('etapa');
        });
    }

};
