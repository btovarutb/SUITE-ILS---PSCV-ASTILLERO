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
        Schema::dropIfExists('buque_misiones');
    }

    public function down()
    {
        // Opcionalmente, puedes recrear la tabla en el método down si lo deseas
    }
};
