<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUniqueConstraintFromSistemasEquipos extends Migration
{
    public function up()
    {
        Schema::table('sistemas_equipos', function (Blueprint $table) {
            // Eliminar restricción única en 'mfun'
            $table->dropUnique(['mfun']);
        });
    }

    public function down()
    {
        Schema::table('sistemas_equipos', function (Blueprint $table) {
            // Agregar de nuevo la restricción única si se necesita revertir
            $table->unique('mfun');
        });
    }
}
