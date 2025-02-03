<?php
// database/migrations/xxxx_xx_xx_create_diagramas_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiagramasTable extends Migration
{
    public function up()
    {
        Schema::create('diagramas', function (Blueprint $table) {
            $table->id();
            $table->string('ruta');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('diagramas');
    }
}

