<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSistemasSuiteTable extends Migration
{
    public function up()
    {
        Schema::create('sistemas_suite', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_constructivo_id')->constrained('grupos_constructivos')->onDelete('cascade');
            $table->string('codigo', 10);
            $table->string('nombre', 255);
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sistemas_suite');
    }
}
