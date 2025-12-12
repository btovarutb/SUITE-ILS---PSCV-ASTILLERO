<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuqueSistemasBuqueTable extends Migration
{
    public function up()
    {
        Schema::create('buque_sistemas_buque', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buque_id');
            $table->unsignedBigInteger('sistemas_buque_id');
            $table->string('mec')->nullable();
            $table->string('titulo')->nullable();
            $table->string('image')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('mision')->nullable();
            $table->timestamps();

            $table->foreign('buque_id')->references('id')->on('buques')->onDelete('cascade');
            $table->foreign('sistemas_buque_id')->references('id')->on('sistemas_buque')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('buque_sistemas_buque');
    }
}
