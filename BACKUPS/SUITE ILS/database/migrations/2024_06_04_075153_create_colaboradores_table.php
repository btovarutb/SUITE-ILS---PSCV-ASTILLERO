<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColaboradoresTable extends Migration
{
    public function up()
    {
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buque_id')->constrained()->onDelete('cascade');
            $table->string('col_cargo');
            $table->string('col_nombre');
            $table->string('col_entidad');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('colaboradores');
    }
}
