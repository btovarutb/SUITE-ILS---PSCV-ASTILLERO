<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMisionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('misiones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buque_id');
            $table->string('mision');
            $table->timestamps();

            $table->foreign('buque_id')->references('id')->on('buques')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('misiones');
    }
}
