<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGresColabTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('gres_colab', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buque_id')->constrained()->onDelete('cascade');
            $table->string('cargo');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('entidad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('gres_colab');
    }
}
