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
        Schema::create('buque_sistemas_equipos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buque_id')->constrained()->onDelete('cascade');
            $table->foreignId('sistemas_equipos_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('buque_sistemas_equipos');
    }
};
