<?php

// database/migrations/xxxx_xx_xx_add_diagrama_id_to_buque_sistemas_equipos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiagramaIdToBuqueSistemasEquiposTable extends Migration
{
    public function up()
    {
        Schema::table('buque_sistemas_equipos', function (Blueprint $table) {
            $table->unsignedBigInteger('diagrama_id')->nullable()->after('id');
            $table->foreign('diagrama_id')->references('id')->on('diagramas');
        });
    }

    public function down()
    {
        Schema::table('buque_sistemas_equipos', function (Blueprint $table) {
            $table->dropForeign(['diagrama_id']);
            $table->dropColumn('diagrama_id');
        });
    }
}

