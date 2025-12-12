<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSistemasBuquesTable extends Migration
{
    public function up()
    {
        Schema::create('sistemas_buques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buque_id');
            $table->string('codigo');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->timestamps();

            // Clave foránea
            $table->foreign('buque_id')->references('id')->on('buques')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sistemas_buques');
    }
}
