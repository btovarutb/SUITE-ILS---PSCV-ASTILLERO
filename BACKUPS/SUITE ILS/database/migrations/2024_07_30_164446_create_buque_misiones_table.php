<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuqueMisionesTable extends Migration
{
    public function up()
    {
        Schema::create('buque_misiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buque_id')->constrained()->onDelete('cascade');
            $table->string('mision');
            $table->integer('velocidad')->default(0);
            $table->integer('num_motores')->default(0);
            $table->integer('potencia')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('buque_misiones');
    }
}
