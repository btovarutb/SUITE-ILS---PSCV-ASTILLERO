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
        Schema::table('buque_fua', function (Blueprint $table) {
            $table->integer('mant_basico_3')->nullable()->after('mant_intermedio_3'); // Columna después de 'mant_intermedio_3'
        });
    }

    public function down()
    {
        Schema::table('buque_fua', function (Blueprint $table) {
            $table->dropColumn('mant_basico_3');
        });
    }

};
