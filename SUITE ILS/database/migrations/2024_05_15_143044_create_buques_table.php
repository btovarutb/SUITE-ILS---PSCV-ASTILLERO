<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('buques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nombre_proyecto');
            $table->string('tipo_buque');
            $table->text('descripcion_proyecto');
            $table->integer('autonomia_horas');
            $table->string('image_path')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('buques');
    }
};
