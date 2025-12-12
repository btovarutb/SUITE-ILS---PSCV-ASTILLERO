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
        Schema::create('buque_sistema', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buque_id');
            $table->unsignedBigInteger('sistema_id');
            $table->string('mec')->nullable();
            $table->string('image')->nullable();
            $table->json('observaciones')->nullable();
            $table->json('misiones')->nullable();
            $table->timestamps();
    
            $table->foreign('buque_id')->references('id')->on('buques')->onDelete('cascade');
            $table->foreign('sistema_id')->references('id')->on('sistemas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buque_sistema');
    }
};
