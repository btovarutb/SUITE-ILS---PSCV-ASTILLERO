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
        Schema::dropIfExists('colaboradores');
    }
    
    public function down()
    {
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buque_id');
            $table->string('cargo');
            $table->string('nombre');
            $table->string('entidad');
            $table->timestamps();
    
            $table->foreign('buque_id')->references('id')->on('buques')->onDelete('cascade');
        });
    }
};