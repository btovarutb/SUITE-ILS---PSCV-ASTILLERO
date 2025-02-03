<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePotenciaColumnInBuqueMisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buque_misiones', function (Blueprint $table) {
            $table->decimal('potencia', 5, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buque_misiones', function (Blueprint $table) {
            $table->string('potencia')->change();
        });
    }
}
