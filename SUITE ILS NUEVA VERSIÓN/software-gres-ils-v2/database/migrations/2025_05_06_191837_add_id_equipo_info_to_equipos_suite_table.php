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
        Schema::table('equipos_suite', function (Blueprint $table) {
            $table->unsignedBigInteger('id_equipo_info')->nullable()->after('id')->unique();
        });
    }
    
    public function down()
    {
        Schema::table('equipos_suite', function (Blueprint $table) {
            $table->dropColumn('id_equipo_info');
        });
    }
};
