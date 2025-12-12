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
            $table->string('col_cargo')->nullable();
            $table->string('col_nombre')->nullable();
            $table->string('col_entidad')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('buques', function (Blueprint $table) {
            $table->dropColumn('col_cargo');
            $table->dropColumn('col_nombre');
            $table->dropColumn('col_entidad');
        });
    }
};
