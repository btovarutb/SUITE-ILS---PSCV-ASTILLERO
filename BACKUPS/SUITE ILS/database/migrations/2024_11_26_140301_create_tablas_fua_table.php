<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablasFuaTable extends Migration
{
    public function up()
    {
        Schema::create('tablas_fua', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buque_id')->constrained('buques')->onDelete('cascade'); // Relación con la tabla buques
            $table->integer('vida_diseño')->nullable();
            $table->integer('horas_año')->nullable();
            $table->integer('horas_mant_año')->nullable();
            $table->integer('horas_disp_año')->nullable();
            $table->integer('max_mis_año')->nullable();
            $table->integer('mis_plan_mant')->nullable();
            $table->integer('dias_op_año')->nullable();
            $table->integer('dias_mision')->nullable();
            $table->integer('dias_nav_mision')->nullable();
            $table->integer('horas_op_mision')->nullable();
            $table->integer('horas_op_año')->nullable();
            $table->integer('horas_nav_mision')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tablas_fua');
    }
}
