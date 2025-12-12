<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuqueSistemaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buque_sistema', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buque_id')->constrained('buques')->onDelete('cascade');
            $table->foreignId('sistema_id')->constrained('sistemas_suite')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buque_sistema');
    }
}
