<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sistemas_equipos', function (Blueprint $table) {
            $table->timestamps(); // Esto agrega 'created_at' y 'updated_at'
        });
    }

    public function down()
    {
        Schema::table('sistemas_equipos', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
};
