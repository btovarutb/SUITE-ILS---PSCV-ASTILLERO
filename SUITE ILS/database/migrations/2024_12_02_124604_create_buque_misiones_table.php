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
            $table->unsignedBigInteger('buque_id');
            $table->string('mision');
            $table->string('velocidad')->nullable();
            $table->integer('num_motores')->nullable();
            $table->decimal('potencia', 5, 2)->nullable(); // Ejemplo: 75.00 para 75%
            $table->decimal('porcentaje', 5, 2)->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();

            // Clave foránea
            $table->foreign('buque_id')->references('id')->on('buques')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('buque_misiones');
    }


};
